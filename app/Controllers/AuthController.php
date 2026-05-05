<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Services/AuthService.php';

class AuthController extends Controller {

    public function login() {

        session_start();

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$username || !$password) {
            return $this->json([
                'ok' => false,
                'message' => 'Username and password are required'
            ]);
        }

        $authService = new AuthService();
        $result = $authService->attemptLogin($username, $password);

        if (!$result['ok']) {
            return $this->json($result);
        }

        $user = $result['user'];

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role_id' => $user['role_id'],
            'role_name' => $result['role_name']
        ];

        // 🔥 IMPORTANT FLAG
        $_SESSION['force_password_change'] = $result['force_password_change'];

        return $this->json([
            'ok' => true,
            'force_password_change' => $result['force_password_change'],
            'redirect' => 'index.php?page=dashboard'
        ]);
    }
}