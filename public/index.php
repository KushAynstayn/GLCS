<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

require_once '../app/Core/Controller.php';
require_once '../app/Core/Model.php';
require_once '../app/Core/Database.php';
require_once '../app/Helpers/functions.php';

// ✅ RBAC + MIDDLEWARE
require_once '../app/Helpers/RBAC.php';
require_once '../app/Middleware/AuthMiddleware.php';
require_once '../app/Middleware/PermissionMiddleware.php';

/**
 * =========================
 * LOGOUT
 * =========================
 */
if (isset($_GET['logout'])) {

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
 * API ROUTING
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

// ✅ PROTECTED PAGES
$protectedPages = [
    'dashboard',
    'gle-import',
    'reports-gle',
    'reports-overall',
    'user-management',
    'gl-settings'
];

if (in_array($page, $protectedPages)) {
    AuthMiddleware::handle();
}

// ✅ PERMISSION MAP
$pagePermissions = [
    'gle-import' => 'gle_import.access',
    'reports-gle' => 'reports.gle_reports.view',
    'reports-overall' => 'reports.access',
    'user-management' => 'admin_settings.user_management',
    'gl-settings' => 'admin_settings.gl_code_settings',
];

if (isset($pagePermissions[$page])) {
    PermissionMiddleware::check($pagePermissions[$page]);
}

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

// ✅ LOAD USER MANAGEMENT DATA
if ($page === 'user-management') {
    require_once '../app/Controllers/UserController.php';

    $controller = new UserController();
    $data = $controller->index();

    $users = $data['users'];
    $roles = $data['roles'];
    $departments = $data['departments'];
}


if ($page === 'dashboard') {

    require_once '../app/Controllers/DashboardController.php';

    $controller = new DashboardController();

    $data = $controller->index();

    extract($data);
}

ob_start();
include($fileToLoad);
$content = ob_get_clean();

include('../resources/views/layouts/main.php');