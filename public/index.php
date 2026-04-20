<?php
// public/index.php

// 1. Get the requested page from the URL (?page=login), default to 'landing'
$page = $_GET['page'] ?? 'landing';

// 2. Define allowed routes (This prevents users from accessing arbitrary files)
$routes = [
    'landing' => '../resources/views/components/landing.php',

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