<?php
require_once __DIR__ . '/../Models/User.php';

class UserController {

    public function index() {
        $userModel = new User();
        $users = $userModel->getAll();

        print_r($users); // test
    }
}