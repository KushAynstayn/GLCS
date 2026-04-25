<?php

require_once __DIR__ . '/BaseImportService.php';

class GLCodeService extends BaseImportService
{
    protected function getTable()
    {
        return 'gl_codes';
    }

    protected function cleanRow($row)
    {
        return [
            'gl_account' => $row['gl_account'] ?? null,
            'account_title' => $row['account_title'] ?? null,
            'level_4' => $row['level_4'] ?? null,
            'level_3' => $row['level_3'] ?? null,
            'level_2' => $row['level_2'] ?? null,
            'level_1' => $row['level_1'] ?? null,
            'fs_account_type' => $row['fs_account_type'] ?? null,
            'normal_balance' => $row['normal_balance'] ?? null,
        ];
    }
}