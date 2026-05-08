<?php

require_once __DIR__ . '/../Services/DashboardService.php';

class DashboardController
{
    private $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index()
    {
        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? null;

        return [
            'totalGLCodes' => $this->dashboardService->getTotalGLCodes($from, $to),

            'totalUsers' => $this->dashboardService->getTotalUsers(),

            'userGLAccess' => $this->dashboardService->getUserGLAccess(),

            'importsPerMonth' => $this->dashboardService->getImportsPerMonth($from, $to),

            'recentImports' => $this->dashboardService->getRecentImports(),

            'from' => $from,
            'to' => $to
        ];
    }
}