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

    

    // =========================================
    // API: GET SINGLE USER
    // =========================================
    public function getOne()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            return $this->json(['ok' => false, 'message' => 'User ID required']);
        }

        return $this->json(
            $this->service->getUserWithGL($id)
        );
    }

    // =========================================
    // API: UPDATE USER
    // =========================================
    public function update()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        return $this->json(
            $this->service->updateUser($input)
        );
    }

    // =========================================
    // API: RESET PASSWORD
    // =========================================
    public function resetPassword()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        return $this->json(
            $this->service->resetPassword($input['user_id'])
        );
    }



    public function changePassword()
    {
        session_start();

        $input = json_decode(file_get_contents("php://input"), true);

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return $this->json([
                'ok' => false,
                'message' => 'Unauthorized'
            ]);
        }

        if (empty($input['password'])) {
            return $this->json([
                'ok' => false,
                'message' => 'Password is required'
            ]);
        }

        return $this->json(
            $this->service->changePassword($userId, $input['password'])
        );
    }


}