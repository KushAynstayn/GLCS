<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Services/UserService.php';
require_once __DIR__ . '/../Core/Controller.php';

class UserController extends Controller {

    private $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    // =========================================
    // VIEW (PAGE LOAD)
    // =========================================
    public function index() {

        $userModel = new User();

        $users = $userModel->getAllUsers();
        $roles = $userModel->getRoles();
        $departments = $userModel->getDepartments();

        return [
            'users' => $users,
            'roles' => $roles,
            'departments' => $departments
        ];
    }

    // =========================================
    // API: CREATE USER
    // =========================================
    public function create()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!is_array($input)) {
            return $this->json([
                'ok' => false,
                'message' => 'Invalid input'
            ]);
        }

        return $this->json(
            $this->service->createUser($input)
        );
    }
}