<?php

use OpenSpout\Reader\XLSX\Reader;

abstract class BaseImportService
{
    protected $uploadPath;
    protected $db;

    public function __construct()
    {
        $this->uploadPath = __DIR__ . '/../../tmp/uploads/';

        require_once __DIR__ . '/../Core/Database.php';
        $this->db = Database::getInstance()->getConnection();

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    // =========================================
    // UPLOAD (SHARED)
    // =========================================
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
            'file_keys' => $fileKeys
        ];
    }

    private function extractSingleFile($file)
    {
        $fileKey = uniqid('imp_');
        $path = $this->uploadPath . $fileKey . '.json';

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

        file_put_contents($path, json_encode([
            'rows' => $rows
        ]));

        return [
            'ok' => true,
            'file_key' => $fileKey
        ];
    }

    // =========================================
    // PREVIEW (SHARED)
    // =========================================
    public function getPreview($data)
    {
        $fileKeys = $data['file_keys'] ?? [];
        $result = [];

        foreach ($fileKeys as $key) {

            $path = $this->uploadPath . $key . '.json';

            if (!file_exists($path)) continue;

            $json = json_decode(file_get_contents($path), true);

            $result[] = [
                'file_key' => $key,
                'preview' => array_slice($json['rows'], 0, 10)
            ];
        }

        return ['ok' => true, 'data' => $result];
    }

    // =========================================
    // INSERT (SHARED)
    // =========================================
    public function insertBatch($data)
    {
        $fileKeys = $data['file_keys'] ?? [];

        if (empty($fileKeys)) {
            return ['ok' => false, 'message' => 'No file_keys'];
        }

        $total = 0;

        foreach ($fileKeys as $key) {

            $path = $this->uploadPath . $key . '.json';

            if (!file_exists($path)) continue;

            $json = json_decode(file_get_contents($path), true);
            $rows = $json['rows'] ?? [];

            // ✅ CREATE IMPORT RECORD
            $importId = $this->createImportSession($key, $path, count($rows));

            try {

                $batch = [];
                $count = 0;
                $inserted = 0;

                foreach ($rows as $row) {

                    $batch[] = $this->cleanRow($row);
                    $count++;

                    if ($count === 200) {
                        $inserted += $this->bulkInsert($batch);
                        $batch = [];
                        $count = 0;
                    }
                }

                if (!empty($batch)) {
                    $inserted += $this->bulkInsert($batch);
                }

                // ✅ SUCCESS UPDATE
                $this->updateImportSession($importId, $inserted, 'completed');

                $total += $inserted;

                unlink($path);

            } catch (Exception $e) {

                // ❌ FAILED UPDATE
                $this->updateImportSession($importId, 0, 'failed');

                continue;
            }
        }

        return [
            'ok' => true,
            'inserted' => $total
        ];
    }

    private function bulkInsert($rows)
    {
        if (empty($rows)) return 0;

        $columns = array_keys($rows[0]);
        $escaped = array_map(fn($c) => "`$c`", $columns);

        $colString = implode(',', $escaped);

        $placeholders = [];
        $values = [];

        foreach ($rows as $row) {

            $rowPlace = [];

            foreach ($row as $val) {
                $rowPlace[] = '?';
                $values[] = $val;
            }

            $placeholders[] = '(' . implode(',', $rowPlace) . ')';
        }

        $sql = "INSERT INTO " . $this->getTable() . " ($colString) VALUES " . implode(',', $placeholders);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);

        return count($rows);
    }


    private function createImportSession($fileKey, $filePath, $totalRows)
    {
        $stmt = $this->db->prepare("
            INSERT INTO imports (file_name, file_path, uploaded_by, total_rows, status)
            VALUES (?, ?, ?, ?, 'processing')
        ");

        $stmt->execute([
            $fileKey,
            $filePath,
            $_SESSION['user_id'] ?? 0,
            $totalRows
        ]);

        return $this->db->lastInsertId();
    }


    private function updateImportSession($importId, $insertedRows, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE imports
            SET inserted_rows = ?, status = ?
            WHERE id = ?
        ");

        $stmt->execute([$insertedRows, $status, $importId]);
    }


    protected function normalizeHeaders($headers)
    {
        return array_map(function ($h) {
            $h = strtolower(trim($h));
            return preg_replace('/[^a-z0-9]/', '_', $h);
        }, $headers);
    }

    // =========================================
    // ABSTRACT (MUST IMPLEMENT)
    // =========================================
    abstract protected function cleanRow($row);
    abstract protected function getTable();
}