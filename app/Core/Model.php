<?php
// /app/Core/Model.php

require_once __DIR__ . '/Database.php';

class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();

        if (!$this->db) {
            throw new Exception("Database connection failed");
        }
    }
}