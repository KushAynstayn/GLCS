<?php

require_once __DIR__ . '/../Models/User.php';

class AuthController {

    public function login() {

        session_start();

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$username || !$password) {
            echo json_encode([
                'ok' => false,
                'message' => 'Username and password are required'
            ]);
            return;
        }

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if (!$user) {
            echo json_encode([
                'ok' => false,
                'message' => 'User not found'
            ]);
            return;
        }

        if (!password_verify($password, $user['password'])) {
            echo json_encode([
                'ok' => false,
                'message' => 'Incorrect password'
            ]);
            return;
        }

        $_SESSION['user'] = $user;

        echo json_encode([
            'ok' => true,
            'message' => 'Login successful',
            'redirect' => 'index.php?page=dashboard'
        ]);
    }
}