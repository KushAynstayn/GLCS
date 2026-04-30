<?php

require_once __DIR__ . '/../Core/Database.php';

class ReportService
{
    private $db;
    private $master;

    public function __construct()
    {
        $this->db = Database::getConnection('default');
        $this->master = Database::getConnection('masterdata');
    }

    // =========================
    // MAIN REPORT
    // =========================
    public function getPartnerReport($input)
    {
        session_start();

        $userId = $_SESSION['user']['id'] ?? 0;
        $role = $_SESSION['user']['role_name'] ?? '';

        $partner = $input['partner'] ?? '';
        $glCode = $input['gl_code'] ?? '';
        $dateFrom = $input['date_from'] ?? null;
        $dateTo = $input['date_to'] ?? null;

        $mainZone = $input['main_zone'] ?? '';
        $zone = $input['zone'] ?? '';
        $region = $input['region'] ?? '';
        $area = $input['area'] ?? '';

        $page = $input['page'] ?? 1;

        $limit = 20;
        $offset = ($page - 1) * $limit;

        $sql = "FROM gle WHERE 1=1";
        $params = [];

        // 🔹 PARTNER
        if ($partner) {
            $sql .= " AND `desc` LIKE ?";
            $params[] = "%$partner%";
        }

        // 🔹 DATE
        if ($dateFrom && $dateTo) {
            $sql .= " AND datetime BETWEEN ? AND ?";
            $params[] = $dateFrom;
            $params[] = $dateTo;
        }

        // 🔹 GL CODE FILTER
        if (!empty($glCode)) {
            $sql .= " AND TRIM(gl_code) = ?";
            $params[] = trim($glCode);
        }


        // 🔹 MAIN ZONE
        if ($mainZone) {
            $sql .= " AND main_zone = ?";
            $params[] = $mainZone;
        }

        // 🔹 ZONE
        if ($zone) {
            $sql .= " AND zone = ?";
            $params[] = $zone;
        }

        // 🔹 REGION
        if ($region) {
            $sql .= " AND region = ?";
            $params[] = $region;
        }

        // 🔹 AREA
        if ($area) {
            $sql .= " AND area = ?";
            $params[] = $area;
        }

        // 🔥 USER ACCESS CONTROL
        if (strtolower($role) !== 'admin') {
            $sql .= " AND gl_code IN (
                SELECT gl_account 
                FROM gl_codes gc
                JOIN user_gl_access uga ON uga.gl_code_id = gc.id
                WHERE uga.user_id = ?
            )";
            $params[] = $userId;
        }

        // 🔹 COUNT
        $stmt = $this->db->prepare("SELECT COUNT(*) $sql");
        $stmt->execute($params);
        $total = $stmt->fetchColumn();

        // 🔹 DATA
        $stmt = $this->db->prepare("
            SELECT *
            $sql
            ORDER BY datetime DESC
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute($params);

        return [
            'ok' => true,
            'data' => $stmt->fetchAll(),
            'total' => $total,
            'page' => $page,
            'total_pages' => ceil($total / $limit)
        ];
    }

    // =========================
    // PARTNER DROPDOWN
    // =========================
    public function getPartnerList()
    {
        $stmt = $this->db->query("
            SELECT DISTINCT TRIM(`desc`) as partner
            FROM gle
            WHERE `desc` IS NOT NULL 
            AND `desc` != ''
            ORDER BY partner ASC
            LIMIT 200
        ");

        return [
            'ok' => true,
            'data' => $stmt->fetchAll(PDO::FETCH_COLUMN)
        ];
    }

    // =========================
    // GL CODES (WITH ACCESS CONTROL)
    // =========================
    public function getGLCodes($userId, $role)
    {
        if (strtolower($role) === 'admin') { // ✅ FIX
            $stmt = $this->db->query("
                SELECT gl_account, account_title
                FROM gl_codes
                ORDER BY gl_account
            ");
        } else {
            $stmt = $this->db->prepare("
                SELECT gc.gl_account, gc.account_title
                FROM gl_codes gc
                JOIN user_gl_access uga ON uga.gl_code_id = gc.id
                WHERE uga.user_id = ?
                ORDER BY gc.gl_account
            ");
            $stmt->execute([$userId]);
        }

        return [
            'ok' => true,
            'data' => $stmt->fetchAll()
        ];
    }

    // =========================
    // MAIN ZONES
    // =========================
    public function getMainZones()
    {
        $stmt = $this->master->query("
            SELECT main_zone_code, main_zone_description
            FROM main_zone_masterfile
            ORDER BY main_zone_code
        ");

        return ['ok' => true, 'data' => $stmt->fetchAll()];
    }

    // =========================
    // ZONES (BY MAIN ZONE)
    // =========================
    public function getZones($mainZone)
    {
        $stmt = $this->master->prepare("
            SELECT zone_code, zone_description
            FROM zone_masterfile
            WHERE main_zone_code = ?
            ORDER BY zone_code
        ");
        $stmt->execute([$mainZone]);

        return ['ok' => true, 'data' => $stmt->fetchAll()];
    }

    // =========================
    // REGIONS (BY ZONE)
    // =========================
    public function getRegions($zone)
    {
        $stmt = $this->master->prepare("
            SELECT region_code, region_description
            FROM region_masterfile
            WHERE zone_code = ?
            ORDER BY region_description
        ");
        $stmt->execute([$zone]);

        return ['ok' => true, 'data' => $stmt->fetchAll()];
    }

    // =========================
    // AREAS
    // =========================
    public function getAreas()
    {
        $stmt = $this->master->query("
            SELECT area
            FROM area_masterfile
            ORDER BY area
        ");

        return ['ok' => true, 'data' => $stmt->fetchAll(PDO::FETCH_COLUMN)];
    }
    
}