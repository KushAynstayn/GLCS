<?php
require_once __DIR__ . '/../Core/Model.php';

class User extends Model {

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function getAllUsers() {

        $stmt = $this->db->query("
            SELECT 
                users.*,
                roles.name AS role_name
            FROM users
            LEFT JOIN roles ON users.role_id = roles.id
            ORDER BY users.id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getRoles() {
        $stmt = $this->db->query("SELECT id, name FROM roles ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDepartments() {
        $stmt = $this->db->query("SELECT id, name FROM departments ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}