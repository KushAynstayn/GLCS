<?php

require_once __DIR__ . '/../Core/Database.php';


class DashboardService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // TOTAL GL CODES
    public function getTotalGLCodes($from = null, $to = null)
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM gl_codes
            WHERE 1=1
        ";

        if ($from && $to) {
            $sql .= " AND DATE(created_at) BETWEEN :from AND :to";
        }

        $stmt = $this->db->prepare($sql);

        if ($from && $to) {
            $stmt->bindParam(':from', $from);
            $stmt->bindParam(':to', $to);
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // TOTAL USERS EXCLUDING ADMIN
    public function getTotalUsers()
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM users
            WHERE role_id != 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // USER GL ACCESS
    public function getUserGLAccess()
    {
        $sql = "
            SELECT
                u.id,
                CONCAT(u.first_name, ' ', u.last_name) as full_name,
                COUNT(uga.gl_code_id) as total_gl
            FROM users u

            LEFT JOIN user_gl_access uga
                ON u.id = uga.user_id

            WHERE u.role_id != 1

            GROUP BY u.id

            ORDER BY total_gl DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // IMPORTS GRAPH
    public function getImportsPerMonth($from = null, $to = null)
    {
        $sql = "
            SELECT
                MONTH(created_at) as month_num,
                DATE_FORMAT(created_at, '%b') as month_name,
                COUNT(*) as total_imports
            FROM imports

            WHERE 1=1
        ";

        if ($from && $to) {
            $sql .= " AND DATE(created_at) BETWEEN :from AND :to";
        }

        $sql .= "
            GROUP BY MONTH(created_at), DATE_FORMAT(created_at, '%b')

            ORDER BY month_num ASC
        ";

        $stmt = $this->db->prepare($sql);

        if ($from && $to) {
            $stmt->bindParam(':from', $from);
            $stmt->bindParam(':to', $to);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // RECENT IMPORTS
    public function getRecentImports()
    {
        $sql = "
            SELECT
                file_name,
                created_at
            FROM imports

            ORDER BY created_at DESC

            LIMIT 3
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}