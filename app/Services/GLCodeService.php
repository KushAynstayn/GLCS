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


    // =========================================
    // FETCH ALL GL CODES
    // =========================================
    public function getAllGLCodes($page = 1, $limit = 20)
    {
        $offset = ($page - 1) * $limit;

        // COUNT TOTAL
        $countStmt = $this->db->query("SELECT COUNT(*) FROM gl_codes");
        $total = $countStmt->fetchColumn();

        // DATA
        $stmt = $this->db->prepare("
            SELECT 
                gl_account,
                account_title,
                level_4,
                level_3,
                level_2,
                level_1,
                fs_account_type,
                normal_balance,
                status
            FROM gl_codes
            ORDER BY gl_account ASC
            LIMIT $limit OFFSET $offset
        ");

        $stmt->execute();

        return [
            'ok' => true,
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $page,
            'total_pages' => ceil($total / $limit)
        ];
    }


    // =========================================
    // TOGGLE STATUS
    // =========================================
    public function updateStatus($glAccount, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE gl_codes 
            SET status = ? 
            WHERE gl_account = ?
        ");

        $stmt->execute([$status, $glAccount]);

        return ['ok' => true];
    }


    // =========================================
    // GET DISTINCT LEVEL 4
    // =========================================
    public function getLevel4Categories()
    {
        $stmt = $this->db->query("
            SELECT DISTINCT level_4 
            FROM gl_codes
            WHERE level_4 IS NOT NULL AND level_4 != ''
            ORDER BY level_4 ASC
        ");

        return [
            'ok' => true,
            'data' => $stmt->fetchAll(PDO::FETCH_COLUMN)
        ];
    }


    // =========================================
    // GET GL CODES BY CATEGORY
    // =========================================
    public function getGLCodesByCategories($categories)
    {
        if (empty($categories)) {
            return ['ok' => true, 'data' => []];
        }

        $placeholders = implode(',', array_fill(0, count($categories), '?'));

        $stmt = $this->db->prepare("
            SELECT id, gl_account, account_title, level_4
            FROM gl_codes
            WHERE level_4 IN ($placeholders)
            AND status = 1
            ORDER BY gl_account ASC
        ");

        $stmt->execute($categories);

        return [
            'ok' => true,
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }


    public function searchGLCodes($query)
    {
        if (!$query) {
            return ['ok' => true, 'data' => []];
        }

        $stmt = $this->db->prepare("
            SELECT id, gl_account, account_title, level_4
            FROM gl_codes
            WHERE 
                gl_account LIKE ? 
                OR account_title LIKE ?
            ORDER BY gl_account ASC
            LIMIT 50
        ");

        $like = "%$query%";

        $stmt->execute([$like, $like]);

        return [
            'ok' => true,
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }


}