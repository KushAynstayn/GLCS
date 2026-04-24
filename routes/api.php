<?php

require_once __DIR__ . '/../app/Core/Database.php';

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/LedgerController.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_GET['api'] ?? null;

switch ($action) {

    /**
     * =========================
     * AUTH
     * =========================
     */
    case 'login':
        (new AuthController())->login();
        break;

    /**
     * =========================
     * LEDGER
     * =========================
     */
    case 'upload':
        (new LedgerController())->upload();
        break;

    case 'check':
        (new LedgerController())->check();
        break;

    case 'preview':
        (new LedgerController())->preview();
        break;

    case 'insert':
        (new LedgerController())->insert();
        break;

    case 'report-partner':
    require_once __DIR__ . '/../app/Controllers/ReportController.php';
    (new ReportController())->partnerReport();
    break;

    case 'partners':
    require_once __DIR__ . '/../app/Controllers/ReportController.php';
    $controller = new ReportController();
    $controller->getPartners();
    break;

    default:
        echo json_encode([
            'ok' => false,
            'message' => 'Invalid API route'
        ]);
        break;
}