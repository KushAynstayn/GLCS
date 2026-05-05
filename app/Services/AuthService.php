<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';

class AuthService
{
    public function attemptLogin($username, $password)
    {
        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if (!$user) {
            return ['ok' => false, 'message' => 'User not found'];
        }

        if (!password_verify($password, $user['password'])) {
            return ['ok' => false, 'message' => 'Incorrect password'];
        }

        // GET ROLE
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT name FROM roles WHERE id = ?");
        $stmt->execute([$user['role_id']]);
        $role = $stmt->fetch();

        return [
            'ok' => true,
            'user' => $user,
            'role_name' => $role['name'] ?? 'User',
            'force_password_change' => (int)$user['is_default_password'] === 1
        ];
    }
}