<?php

require_once __DIR__ . '/../app/Core/Database.php';

$db = Database::getInstance()->getConnection();

echo "Resetting database...\n";

$db->exec("SET FOREIGN_KEY_CHECKS = 0");
$db->exec("TRUNCATE TABLE gle");
$db->exec("TRUNCATE TABLE imports");
$db->exec("TRUNCATE TABLE import_errors");
$db->exec("SET FOREIGN_KEY_CHECKS = 1");

echo "Done!\n";