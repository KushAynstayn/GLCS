<?php

class Controller
{
    protected function json($data)
    {
        header('Content-Type: application/json');

        echo json_encode($data, JSON_UNESCAPED_UNICODE);

        exit; // 🔥 CRITICAL: stops HTML leaks
    }
}