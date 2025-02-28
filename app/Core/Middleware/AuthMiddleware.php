<?php

namespace App\Core\Middleware;

class AuthMiddleware
{
    public static function handle(): void
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            die("Доступ запрещен. Авторизуйтесь!");
        }
    }

    public static function checkRole(string $role): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === $role;
    }
}
