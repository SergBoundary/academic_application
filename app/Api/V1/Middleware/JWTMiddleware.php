<?php

namespace App\Api\V1\Middleware;

use App\Api\V1\Services\JWTService;

class JWTMiddleware
{
    public static function check()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $authHeader = trim($headers['Authorization'] ?? '');
            if (str_starts_with($authHeader, 'Bearer ')) {
                $token = substr($authHeader, 7);
                $payload = JWTService::validateToken($token);
                if ($payload) {
                    return $payload; // можно сохранить данные пользователя для дальнейшего использования
                }
            }
        }
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
}
