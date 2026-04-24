<?php

require_once __DIR__ . '/../Models/User.php';

class UserController {

    public function index() {

        $userModel = new User();

        $users = $userModel->getAllUsers();
        $roles = $userModel->getRoles();
        $departments = $userModel->getDepartments();

        // return data to be used in the view
        return [
            'users' => $users,
            'roles' => $roles,
            'departments' => $departments
        ];
    }
}