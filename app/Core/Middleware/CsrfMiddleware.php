<?php

namespace App\Core\Middleware;

class CsrfMiddleware
{
    public static function generateToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateToken(string $token): void
    {
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) {
            die("CSRF-токен недействителен!");
        }
    }
}
