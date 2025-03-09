<?php

namespace App\Api\V1\Controllers;

class BaseApiController
{
    protected function jsonResponse($data, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
