<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

require_once '../app/Core/Controller.php';
require_once '../app/Core/Model.php';
require_once '../app/Core/Database.php';
require_once '../app/Helpers/functions.php';

if (isset($_GET['logout'])) {

    session_start();

    require_once '../app/Core/Database.php';

    $db = Database::getInstance()->getConnection();

    if (isset($_SESSION['user']['id'])) {
        $stmt = $db->prepare("
            UPDATE users 
            SET last_online = NOW() 
            WHERE id = ?
        ");
        $stmt->execute([$_SESSION['user']['id']]);
    }

    session_destroy();

    header("Location: index.php?page=landing");
    exit;
}

/**
 * =========================
 * API ROUTING (SAFE)
 * =========================
 */
if (isset($_GET['api'])) {
    require_once __DIR__ . '/../routes/api.php';
    exit;
}

/**
 * =========================
 * PAGE ROUTING
 * =========================
 */
$page = $_GET['page'] ?? 'landing';

$routes = [
    'landing' => '../resources/views/pages/landing.php',
    'login' => '../resources/views/pages/login.php',

    'dashboard' => '../resources/views/pages/dashboard.php',
    'gle-import' => '../resources/views/pages/gle_import.php',

    'reports-gle' => '../resources/views/pages/reports_gle.php',
    'reports-overall' => '../resources/views/pages/reports_overall.php',

    'user-management' => '../resources/views/pages/user_management.php',
    'gl-settings' => '../resources/views/pages/gl_code_settings.php',
];

$fileToLoad = $routes[$page] ?? $routes['landing'];

if ($page === 'user-management') {
    require_once '../app/Controllers/UserController.php';

    $controller = new UserController();
    $data = $controller->index();

    $users = $data['users'];
    $roles = $data['roles'];
    $departments = $data['departments'];
}

ob_start();
include($fileToLoad);
$content = ob_get_clean();

include('../resources/views/layouts/main.php');