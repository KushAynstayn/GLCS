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
}