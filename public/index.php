
<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
// public/index.php
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../app/Core/Controller.php';
require_once '../app/Core/Model.php';
require_once '../app/Core/Database.php';


// API ROUTING (for AJAX)
if (isset($_GET['api'])) {

    require_once '../app/Controllers/LedgerController.php';

    $controller = new LedgerController();

    switch ($_GET['api']) {

        case 'upload':
            $controller->upload();
            break;

        case 'check':
            $controller->check();
            break;

        case 'preview':
            $controller->preview();
            break;

        case 'insert':
            $controller->insert();
            break;

        default:
            echo json_encode(['error' => 'Invalid API']);
            break;
    }

    exit; // VERY IMPORTANT
}

// 1. Get the requested page from the URL (?page=login), default to 'landing'
$page = $_GET['page'] ?? 'landing';


// HANDLE AJAX ACTIONS FIRST (before loading pages)
$action = $_GET['action'] ?? null;

if ($action) {
    require_once '../app/Controllers/LedgerController.php';

    $controller = new LedgerController();

    switch ($action) {
        case 'upload':
            $controller->upload();
            break;

        case 'check':
            $controller->check();
            break;

        case 'insert':
            $controller->insert();
            break;

        default:
            echo json_encode(['ok' => false, 'message' => 'Invalid action']);
    }

    exit; // VERY IMPORTANT: stop page rendering
}

// 2. Define allowed routes (This prevents users from accessing arbitrary files)
$routes = [
    // public
    'landing' => '../resources/views/pages/landing.php',

     // main pages
    'dashboard' => '../resources/views/pages/dashboard.php',
    'gle-import' => '../resources/views/pages/gle_import.php',

    // reports
    'reports-gle' => '../resources/views/pages/reports_gle.php',
    'reports-overall' => '../resources/views/pages/reports_overall.php',

    // admin
    'user-management' => '../resources/views/pages/user_management.php',
    'gl-settings' => '../resources/views/pages/gl_code_settings.php',

];

// 3. Determine which file to load
$fileToLoad = $routes[$page] ?? $routes['landing'];

// 4. Start capturing the content
ob_start();

// 5. Include the target component/page
include($fileToLoad);

// 6. Save the content into $content variable
$content = ob_get_clean();

// 7. Include the master layout
include('../resources/views/layouts/main.php');
?>