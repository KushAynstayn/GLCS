<?php

require_once __DIR__ . '/../Services/ReportService.php';

class ReportController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new ReportService();
    }

    public function partnerReport()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!is_array($input)) {
            return $this->json([
                'ok' => false,
                'message' => 'Invalid input'
            ]);
        }

        return $this->json(
            $this->service->getPartnerReport($input)
        );
    }

    // 🔥 ADD THIS (for dropdown)
    public function getPartners()
    {
        return $this->json(
            $this->service->getPartnerList()
        );
    }


    public function getGLCodes()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? 0;
        $role = $_SESSION['user']['role_name'] ?? '';

        return $this->json(
            $this->service->getGLCodes($userId, $role)
        );
    }

    public function getMainZones()
    {
        return $this->json(
            $this->service->getMainZones()
        );
    }

    public function getZones()
    {
        $input = $_GET['main_zone'] ?? '';
        return $this->json($this->service->getZones($input));
    }

    public function getRegions()
    {
        $input = $_GET['zone'] ?? '';
        return $this->json($this->service->getRegions($input));
    }

    public function getAreas()
    {
        return $this->json($this->service->getAreas());
    }

}