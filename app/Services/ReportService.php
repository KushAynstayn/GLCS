<?php

require_once __DIR__ . '/../Core/Database.php';

class ReportService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // =========================================
    // PARTNER REPORT WITH PAGINATION
    // =========================================
    public function getPartnerReport($input)
    {
        $partner = $input['partner'] ?? '';
        $dateFrom = $input['date_from'] ?? null;
        $dateTo = $input['date_to'] ?? null;
        $page = $input['page'] ?? 1;

        $limit = 20;
        $offset = ($page - 1) * $limit;

        $sql = "FROM gle WHERE 1=1";
        $params = [];

        if (!empty($partner)) {
            $sql .= " AND `desc` LIKE ?";
            $params[] = "%$partner%";
        }

        if ($dateFrom && $dateTo) {
            $sql .= " AND datetime BETWEEN ? AND ?";
            $params[] = $dateFrom;
            $params[] = $dateTo;
        }

        // 🔥 TOTAL COUNT
        $stmt = $this->db->prepare("SELECT COUNT(*) " . $sql);
        $stmt->execute($params);
        $total = $stmt->fetchColumn();

        // 🔥 DATA
        $stmt = $this->db->prepare("
            SELECT *
            $sql
            ORDER BY datetime DESC
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute($params);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'ok' => true,
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'total_pages' => ceil($total / $limit)
        ];
    }

    // =========================================
    // PARTNER DROPDOWN LIST
    // =========================================
    public function getPartnerList()
    {
        $stmt = $this->db->query("
            SELECT DISTINCT `desc`
            FROM gle
            WHERE `desc` IS NOT NULL
            ORDER BY `desc` ASC
            LIMIT 100
        ");

        return [
            'ok' => true,
            'data' => $stmt->fetchAll(PDO::FETCH_COLUMN)
        ];
    }
}