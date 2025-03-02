<?php

namespace App\Core\Middleware;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }

    public static function checkRole(string $role): bool
    {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === $role;
    }
}
