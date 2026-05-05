<?php

require_once __DIR__ . '/../Core/Database.php';

class UserService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    

    public function createUser($data)
    {

        try {

            $this->db->beginTransaction();

            // =========================
            // VALIDATION
            // =========================
            if (empty($data['id_number']) || empty($data['firstname']) || empty($data['lastname'])) {
                throw new Exception("Required fields are missing");
            }

            // =========================
            // HANDLE DEPARTMENT
            // =========================
            $deptId = $data['department_id'] ?? null;

            if ($deptId && str_starts_with($deptId, 'new_')) {

                $deptName = trim($data['department_name']);

                if (!$deptName) {
                    throw new Exception("Department name is required");
                }

                $stmt = $this->db->prepare("INSERT INTO departments (name) VALUES (?)");
                $stmt->execute([$deptName]);

                $deptId = $this->db->lastInsertId();
            }

            // =========================
            // DEFAULT PASSWORD
            // =========================
            $hashedPassword = password_hash('Mlinc12345!@', PASSWORD_BCRYPT);

            // =========================
            // INSERT USER
            // =========================
            $stmt = $this->db->prepare("
                INSERT INTO users 
                (id_number, username, first_name, middle_name, last_name, role_id, password, department_id, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Active', NOW())
            ");

            $stmt->execute([
                $data['id_number'],
                $data['username'],
                $data['firstname'],
                $data['middlename'] ?? null,
                $data['lastname'],
                $data['role_id'],
                $hashedPassword,
                $deptId
            ]);

            $userId = $this->db->lastInsertId();

            

            // =========================
            // GL ACCESS (FIXED)
            // =========================
            error_log("FINAL GL ARRAY BEFORE INSERT:");
            error_log(print_r($data['gl_codes'], true));
            
            if (!empty($data['gl_codes']) && is_array($data['gl_codes'])) {

                $stmt = $this->db->prepare("
                    INSERT INTO user_gl_access (user_id, gl_code_id)
                    VALUES (?, ?)
                ");

                foreach ($data['gl_codes'] as $glCodeId) {
                    error_log("TRY INSERT user_gl_access: user_id=$userId gl_code_id=$glCodeId");
                    
                    $glCodeId = (int) $glCodeId;

                    if ($glCodeId <= 0) continue;

                    $stmt->execute([$userId, $glCodeId]);

                    
                }
            }else {
                error_log("NO GL CODES RECEIVED");
            }

            // =========================
            // LOG
            // =========================
            $stmt = $this->db->prepare("
                INSERT INTO user_logs (user_id, action, description, created_at)
                VALUES (?, 'USER_CREATED', ?, NOW())
            ");

            $stmt->execute([
                $userId,
                "User {$data['username']} created"
            ]);

            $this->db->commit();

            return ['ok' => true];

        } catch (Exception $e) {

            error_log("CREATE USER FAILED: " . $e->getMessage());

            $this->db->rollBack();

            return [
                'ok' => false,
                'message' => $e->getMessage()
            ];
        }
    }



    public function getUserWithGL($userId)
    {
        $stmt = $this->db->prepare("
            SELECT u.*, r.name as role_name
            FROM users u
            LEFT JOIN roles r ON u.role_id = r.id
            WHERE u.id = ?
        ");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("
            SELECT g.id, g.gl_account, g.account_title
            FROM user_gl_access uga
            JOIN gl_codes g ON g.id = uga.gl_code_id
            WHERE uga.user_id = ?
        ");
        $stmt->execute([$userId]);

        $user['gl_codes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['ok' => true, 'data' => $user];
    }
   

    public function updateUser($data)
    {
        try {

            $this->db->beginTransaction();

            $userId = $data['id'];

            $username = $data['username'] ?? null;

            if (!$username) {
                $username = strtoupper($data['lastname']) . $data['id_number'];
            }

            $stmt = $this->db->prepare("
                UPDATE users SET
                    id_number = ?,
                    username = ?,
                    first_name = ?,
                    middle_name = ?,
                    last_name = ?,
                    role_id = ?,
                    status = ?
                WHERE id = ?
            ");

            $stmt->execute([
                $data['id_number'],
                $username,
                $data['firstname'],
                $data['middlename'] ?? null,
                $data['lastname'],
                $data['role_id'],
                $data['status'],
                $userId
            ]);

            // 🔥 RESET GL ACCESS
            $this->db->prepare("DELETE FROM user_gl_access WHERE user_id = ?")
                    ->execute([$userId]);

            if (!empty($data['gl_codes'])) {

                $stmt = $this->db->prepare("
                    INSERT INTO user_gl_access (user_id, gl_code_id)
                    VALUES (?, ?)
                ");

                foreach ($data['gl_codes'] as $gl) {
                    $stmt->execute([$userId, (int)$gl]);
                }
            }

            $this->db->commit();

            return ['ok' => true];

        } catch (Exception $e) {

            $this->db->rollBack();

            return [
                'ok' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function resetPassword($userId)
    {
        $password = password_hash('Mlinc12345!@', PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
            UPDATE users SET password = ? WHERE id = ?
        ");

        $stmt->execute([$password, $userId]);

        return ['ok' => true];
    }

}