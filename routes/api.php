<?php

require_once __DIR__ . '/../app/Core/Database.php';

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/LedgerController.php';
require_once __DIR__ . '/../app/Controllers/GLCodeController.php';

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

    /**case 'check':
    *   (new LedgerController())->check();
    *  break;
    */

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

    /**
     * =========================
     * GL CODES
     * =========================
     */

    case 'gl-upload':
        (new GLCodeController())->upload();
        break;

    case 'gl-preview':
        (new GLCodeController())->preview();
        break;

    case 'gl-insert':
        (new GLCodeController())->insert();
        break;

    case 'gl-codes':
        (new GLCodeController())->getAll();
        break;

    case 'gl-toggle-status':
        (new GLCodeController())->toggleStatus();
        break;

    case 'gl-level4':
        (new GLCodeController())->getLevel4();
        break;

    case 'gl-by-category':
        (new GLCodeController())->getByCategories();
        break;

    case 'create-user':
        require_once __DIR__ . '/../app/Controllers/UserController.php';
        (new UserController())->create();
        break;

    case 'gl-search':
        (new GLCodeController())->search();
        break;

    default:
        echo json_encode([
            'ok' => false,
            'message' => 'Invalid API route'
        ]);
        break;
}