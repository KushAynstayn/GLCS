<?php
// public/index.php

// 1. Get the requested page from the URL (?page=login), default to 'landing'
$page = $_GET['page'] ?? 'landing';

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