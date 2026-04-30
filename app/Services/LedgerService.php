<?php

require_once __DIR__ . '/BaseImportService.php';

class LedgerService extends BaseImportService
{
    protected function getTable()
    {
        return 'gle';
    }

    protected function cleanRow($row)
    {
        return [
            'datetime' => $this->parseExcelDate($row['date_time'] ?? null),
            'gl_code' => $row['gl_code'] ?? null,
            'gl_desc' => $row['gl_desc']
                ?? $row['gl_description']
                ?? $row['gl desc']
                ?? null,

            'desc' => $row['desc']
                ?? $row['description']
                ?? $row['transaction_desc']
                ?? null,
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

        if (is_numeric($value)) {
            return date('Y-m-d H:i:s', ($value - 25569) * 86400);
        }

        $dt = DateTime::createFromFormat('m/d/Y h:i A', trim($value));
        if ($dt) return $dt->format('Y-m-d H:i:s');

        $time = strtotime($value);
        return $time ? date('Y-m-d H:i:s', $time) : null;
    }

    private function num($val)
    {
        return is_numeric($val) ? $val : preg_replace('/[^0-9.-]/', '', $val);
    }

    private function cleanCostCenter($value)
    {
        if (!$value) return null;
        return preg_replace('/^\d+-/', '', $value);
    }
}