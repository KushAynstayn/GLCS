<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Services/GLCodeService.php';

class GLCodeController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new GLCodeService();
    }

    public function upload()
    {
        return $this->json(
            $this->service->extractMultipleExcel($_FILES['files'] ?? null)
        );
    }

    public function preview()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        return $this->json(
            $this->service->getPreview($input ?? [])
        );
    }

    public function insert()
    {
        $raw = file_get_contents("php://input");
        $input = json_decode($raw, true);

        if (!is_array($input)) {
            return $this->json([
                'ok' => false,
                'message' => 'Invalid JSON input'
            ]);
        }

        return $this->json(
            $this->service->insertBatch($input)
        );
    }
}