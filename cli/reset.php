<?php

require_once __DIR__ . '/../app/Core/Database.php';

$db = Database::getInstance()->getConnection();

echo "Resetting database...\n";

$db->exec("SET FOREIGN_KEY_CHECKS = 0");
$db->exec("TRUNCATE TABLE gle");
$db->exec("TRUNCATE TABLE imports");
$db->exec("TRUNCATE TABLE import_errors");
$db->exec("TRUNCATE TABLE gl_codes");
$db->exec("SET FOREIGN_KEY_CHECKS = 1");

echo "Done!\n";