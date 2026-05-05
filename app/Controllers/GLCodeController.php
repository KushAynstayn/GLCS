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


    public function getAll()
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if ($page < 1) $page = 1;

        return $this->json(
            $this->service->getAllGLCodes($page, 20)
        );
    }

    public function toggleStatus()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        return $this->json(
            $this->service->updateStatus(
                $input['gl_account'],
                $input['status']
            )
        );
    }


    public function getLevel4()
    {
        return $this->json(
            $this->service->getLevel4Categories()
        );
    }

    public function getByCategories()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        return $this->json(
            $this->service->getGLCodesByCategories($input['categories'] ?? [])
        );
    }


    public function search()
    {
        // ✅ SUPPORT GET (your modal)
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];

            return $this->json(
                $this->service->searchGLCodes($keyword)
            );
        }

        // ✅ KEEP EXISTING POST (other system parts)
        $input = json_decode(file_get_contents("php://input"), true);

        return $this->json(
            $this->service->searchGLCodes($input['query'] ?? '')
        );
    }

}