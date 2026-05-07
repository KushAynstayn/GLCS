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
     * GL EXCEL DOWNLOAD
     * =========================
     */
    case 'gl-download':
        {
            require_once __DIR__ . '/../app/Controllers/ReportController.php';
            (new ReportController())->downloadGLE();
            break;
        }

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

    case 'main-zones':
        require_once __DIR__ . '/../app/Controllers/ReportController.php';
        (new ReportController())->getMainZones();
        break;

    case 'zones':
        require_once __DIR__ . '/../app/Controllers/ReportController.php';
        (new ReportController())->getZones();
        break;

    case 'regions':
        require_once __DIR__ . '/../app/Controllers/ReportController.php';
        (new ReportController())->getRegions();
        break;

    case 'areas':
        require_once __DIR__ . '/../app/Controllers/ReportController.php';
        (new ReportController())->getAreas();
        break;

    case 'glcodes':
        require_once __DIR__ . '/../app/Controllers/ReportController.php';
        (new ReportController())->getGLCodes();
        break;

    case 'user-getOne':
        require_once __DIR__ . '/../app/Controllers/UserController.php';
        (new UserController())->getOne();
        break;

    case 'user-update':
        require_once __DIR__ . '/../app/Controllers/UserController.php';
        (new UserController())->update();
        break;

    case 'user-resetPassword':
        require_once __DIR__ . '/../app/Controllers/UserController.php';
        (new UserController())->resetPassword();
        break;

    case 'change-password':
        require_once __DIR__ . '/../app/Controllers/UserController.php';
        (new UserController())->changePassword();
        break;

    case 'branches':
        require_once __DIR__ . '/../app/Controllers/ReportController.php';
        (new ReportController())->getBranches();
        break;

    case 'transaction-types':
        require_once __DIR__ . '/../app/Controllers/ReportController.php';
        (new ReportController())->getTransactionTypes();
        break;

    case 'gl-store':
        (new GLCodeController())->store();
        break;

    case 'gl-dropdowns':
        (new GLCodeController())->dropdowns();
        break;

    default:
        echo json_encode([
            'ok' => false,
            'message' => 'Invalid API route'
        ]);
        break;
}