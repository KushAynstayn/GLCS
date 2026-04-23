<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenSpout\Reader\XLSX\Reader;

class LedgerService
{
    private $uploadPath;
    private $db;

    public function __construct()
    {
        $this->uploadPath = __DIR__ . '/../../tmp/uploads/';

        // ✅ FIX: use same DB singleton as Model
        require_once __DIR__ . '/../Core/Database.php';

        $this->db = Database::getInstance()->getConnection();

        if (!$this->db) {
            throw new Exception("Database connection failed in LedgerService");
        }

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    // =====================================================
    // STEP 1: MULTI FILE EXTRACT
    // =====================================================
    public function extractMultipleExcel($files)
    {
        if (!$files) {
            return ['ok' => false, 'message' => 'No files uploaded'];
        }

        $fileKeys = [];
        $count = count($files['name']);

        for ($i = 0; $i < $count; $i++) {

            $file = [
                'tmp_name' => $files['tmp_name'][$i],
                'name' => $files['name'][$i]
            ];

            $result = $this->extractSingleFile($file);

            if ($result['ok']) {
                $fileKeys[] = $result['file_key'];
            }
        }

        return [
            'ok' => true,
            'file_keys' => $fileKeys,
            'file_count' => count($fileKeys)
        ];
    }

    // =====================================================
    // SINGLE FILE EXTRACT
    // =====================================================
    private function extractSingleFile($file)
    {
        $fileKey = uniqid('gle_');
        $uploadFile = $this->uploadPath . $fileKey . '.json';

        $reader = new Reader();
        $reader->open($file['tmp_name']);

        $rows = [];
        $headers = [];

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {

                $cells = $row->toArray();

                if (empty($headers)) {
                    $headers = $this->normalizeHeaders($cells);
                    continue;
                }

                $mapped = [];

                foreach ($headers as $i => $col) {
                    $mapped[$col] = $cells[$i] ?? null;
                }

                $rows[] = $mapped;
            }
        }

        $reader->close();

        file_put_contents($uploadFile, json_encode([
            'file_key' => $fileKey,
            'rows' => $rows
        ]));

        return [
            'ok' => true,
            'file_key' => $fileKey,
            'row_count' => count($rows)
        ];
    }

    // =====================================================
    // STEP 2: DUPLICATE CHECK (PRESERVED - NOT USED YET)
    // =====================================================
    public function checkDuplicatesBatch($data)
    {
        $fileKeys = $data['file_keys'] ?? [];

        if (empty($fileKeys)) {
            return ['ok' => false, 'message' => 'No files to check'];
        }

        $totalDuplicates = 0;
        $summary = [];

        foreach ($fileKeys as $key) {

            $path = $this->uploadPath . $key . '.json';

            if (!file_exists($path)) continue;

            $json = json_decode(file_get_contents($path), true);
            $rows = $json['rows'] ?? [];

            $duplicates = 0;

            foreach ($rows as $row) {

                if ($this->existsReference($row['reference'] ?? null)) {
                    $duplicates++;
                }
            }

            $summary[] = [
                'file_key' => $key,
                'duplicates' => $duplicates,
                'rows' => count($rows)
            ];

            $totalDuplicates += $duplicates;
        }

        return [
            'ok' => true,
            'total_duplicates' => $totalDuplicates,
            'files' => $summary,
            'can_insert' => $totalDuplicates === 0
        ];
    }

    // =====================================================
    // STEP 3: MAIN INSERT ENGINE (OPTION A: ALLOW DUPLICATES)
    // =====================================================
    public function insertBatch($data)
    {
        $this->cleanupOldFiles();

        try {

            
            $fileKeys = $data['file_keys'] ?? [];

            if (empty($fileKeys)) {
                return ['ok' => false, 'message' => 'No file_keys received'];
            }

            if (!$this->db) {
                return ['ok' => false, 'message' => 'DB is null'];
            }

            $totalInserted = 0;

            foreach ($fileKeys as $key) {

                try {

                    $path = $this->uploadPath . $key . '.json';

                    if (!file_exists($path)) continue;

                    $json = json_decode(file_get_contents($path), true);
                    $rows = $json['rows'] ?? [];

                    $importId = $this->createImportSession($key, $path, count($rows));

                    $batch = [];
                    $batchCount = 0;

                    foreach ($rows as $row) {

                        $clean = $this->cleanRow($row);
                        $clean['import_id'] = $importId;

                        $batch[] = $clean;
                        $batchCount++;

                        if ($batchCount === 200) {
                            $totalInserted += $this->bulkInsert($batch);
                            $batch = [];
                            $batchCount = 0;
                        }
                    }

                    if (!empty($batch)) {
                        $totalInserted += $this->bulkInsert($batch);
                    }

                    // ✅ SUCCESS STATUS
                    $this->updateSingleImport($importId, count($rows), 'completed');

                    unlink($path);

                } catch (Exception $e) {

                    
                    // ❌ FAILED STATUS
                    if (isset($importId)) {
                        $this->updateSingleImport($importId, 0, 'failed');
                    }

                    continue; // 🔥 MOVE TO NEXT FILE
                }
            }

            $this->updateImportStatus($fileKeys, $totalInserted);

            return [
                'ok' => true,
                'inserted' => $totalInserted
            ];

        } catch (Throwable $e) {

        
            return [
                'ok' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    // =====================================================
    // BULK INSERT ENGINE
    // =====================================================
    private function bulkInsert($rows)
    {
        if (empty($rows)) return 0;

        $columns = array_keys($rows[0]);

        // 🔥 escape all column names
        $escapedColumns = array_map(function($col) {
            return "`$col`";
        }, $columns);

        $colString = implode(',', $escapedColumns);

        $placeholders = [];
        $values = [];

        foreach ($rows as $row) {

            $rowPlaceholders = [];

            foreach ($row as $val) {
                $rowPlaceholders[] = '?';
                $values[] = $val;
            }

            $placeholders[] = '(' . implode(',', $rowPlaceholders) . ')';
        }

        $sql = "INSERT INTO gle ($colString) VALUES " . implode(',', $placeholders);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);

        return count($rows);
    }

    // =====================================================
    // IMPORT TRACKING (OPTIONAL BUT READY)
    // =====================================================
    public function createImportSession($fileName, $filePath, $totalRows)
    {
        if (!$this->db) return null;

        $stmt = $this->db->prepare("
            INSERT INTO imports (file_name, file_path, uploaded_by, total_rows, status)
            VALUES (?, ?, ?, ?, 'processing')
        ");

        $stmt->execute([
            $fileName,
            $filePath,
            $_SESSION['user_id'] ?? 0,
            $totalRows
        ]);

        return $this->db->lastInsertId();
    }

    // =====================================================
    // HELPERS
    // =====================================================
    private function normalizeHeaders($headers)
    {
        return array_map(function ($h) {

            $h = strtolower(trim($h));
            $h = preg_replace('/[^a-z0-9]/', '_', $h);

            if ($h === 'gl_description') return 'gl_desc';
            if ($h === 'description') return 'desc';
            
            

            return $h;

        }, $headers);
    }

    private function cleanRow($row)
    {
        return [
            'datetime' => $this->parseExcelDate($row['date_time'] ?? null),
            'gl_code' => $row['gl_code'] ?? null,
            'gl_desc' => $row['gl_desc'] ?? null,
            'desc' => $row['desc'] ?? null,
            'reference' => $row['reference'] ?? null,
            'entry_number' => $row['entry_number'] ?? null,
            'currency' => $row['currency'] ?? null,
            'debit' => $this->num($row['debit'] ?? null),
            'credit' => $this->num($row['credit'] ?? null),
            'transaction_type' => $row['transaction_type'] ?? null,
            'branch_id' => $row['branch_id'] ?? null,
            'cost_center' => $this->cleanCostCenter($row['cost_center'] ?? null),
            'item' => $row['item'] ?? null,
            'main_zone' => $row['main_zone'] ?? null,
            'zone' => $row['zone'] ?? null,
            'region' => $row['region'] ?? null,
        ];
    }


    private function parseExcelDate($value)
    {
        if (!$value) return null;

        // Handle Excel numeric date
        if (is_numeric($value)) {
            return date('Y-m-d H:i:s', ($value - 25569) * 86400);
        }

        // 🔥 FORCE correct format parsing
        $dt = DateTime::createFromFormat('m/d/Y h:i A', trim($value));

        if ($dt !== false) {
            return $dt->format('Y-m-d H:i:s');
        }

        // fallback (last attempt)
        $time = strtotime($value);
        return $time ? date('Y-m-d H:i:s', $time) : null;
    }


    private function num($val)
    {
        return is_numeric($val) ? $val : preg_replace('/[^0-9.-]/', '', $val);
    }

    // OPTIONAL DUPLICATE CHECK HELPER
    private function existsReference($reference)
    {
        if (!$reference || !$this->db) return false;

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM gle WHERE reference = ?");
        $stmt->execute([$reference]);

        return $stmt->fetchColumn() > 0;
    }



    public function getPreview($data)
    {
        $fileKeys = $data['file_keys'] ?? [];

        $result = [];

        foreach ($fileKeys as $key) {

            $path = __DIR__ . "/../../tmp/uploads/$key.json";

            if (!file_exists($path)) continue;

            $json = json_decode(file_get_contents($path), true);

            if (!$json || empty($json['rows'])) continue;

            $result[] = [
                'file_key' => $key,
                'preview' => array_slice($json['rows'], 0, 10)
            ];
        }

        return [
            'ok' => true,
            'data' => $result
        ];
    }


    private function cleanCostCenter($value)
    {
        if (!$value) return null;

        // remove leading digits + dash
        return preg_replace('/^\d+-/', '', $value);
    }


    private function updateImportStatus($fileKeys, $insertedRows)
    {
        if (!$this->db) return;

        foreach ($fileKeys as $key) {

            // find import record by file_name
            $stmt = $this->db->prepare("
                UPDATE imports
                SET inserted_rows = ?, status = 'completed'
                WHERE file_name = ?
            ");

            $stmt->execute([$insertedRows, $key]);
        }
    }


    public function cleanupOldFiles($minutes = 30)
    {
        foreach (glob($this->uploadPath . '*.json') as $file) {
            if (time() - filemtime($file) > ($minutes * 60)) {
                unlink($file);
            }
        }
    }


    private function updateSingleImport($importId, $insertedRows, $status)
    {
        if (!$this->db || !$importId) return;

        $stmt = $this->db->prepare("
            UPDATE imports
            SET inserted_rows = ?, status = ?
            WHERE id = ?
        ");

        $stmt->execute([$insertedRows, $status, $importId]);
    }

}