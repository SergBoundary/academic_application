<?php

namespace App\Api\V1\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    private static $secretKey = 'my_secret_key'; // замените на свой секрет
    private static $algo = 'HS256';

    public static function generateToken(array $payload): string
    {
        // Можно добавить exp (expiration) в payload
        $payload['iat'] = time();
        $payload['exp'] = time() + 3600; // токен действителен 1 час
        return JWT::encode($payload, self::$secretKey, self::$algo);
    }

    public static function validateToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key(self::$secretKey, self::$algo));
            return (array)$decoded;
        } catch (\Exception $e) {
            return null;
        }
    }
}
