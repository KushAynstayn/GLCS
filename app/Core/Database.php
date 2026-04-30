<?php

class Database {

    private static $instances = [];
    private static $defaultInstance = null;

    private $connection;

    // 🔹 OLD STYLE SUPPORT (for existing code like login)
    private function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        $db = $config['default'];

        $this->connection = new PDO(
            "mysql:host={$db['host']};dbname={$db['dbname']}",
            $db['username'],
            $db['password']
        );

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function getInstance() {
        if (!self::$defaultInstance) {
            self::$defaultInstance = new Database();
        }
        return self::$defaultInstance;
    }

    public function getConnectionOld() {
        return $this->connection;
    }

    // 🔹 NEW MULTI-DB SUPPORT
    public static function getConnection($type = 'default') {

        if (!isset(self::$instances[$type])) {

            $config = require __DIR__ . '/../../config/database.php';

            if (!isset($config[$type])) {
                throw new Exception("Database [$type] not configured");
            }

            $db = $config[$type];

            self::$instances[$type] = new PDO(
                "mysql:host={$db['host']};dbname={$db['dbname']}",
                $db['username'],
                $db['password']
            );

            self::$instances[$type]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instances[$type]->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return self::$instances[$type];
    }
}