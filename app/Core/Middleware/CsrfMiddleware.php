<?php

namespace App\Core\Middleware;

class CsrfMiddleware
{
    public static function generateToken(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function getToken(): string
    {
        return self::generateToken();
    }

    public static function validateToken(string $token): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) {
            die("CSRF-токен недействителен!");
        }
    }
}
