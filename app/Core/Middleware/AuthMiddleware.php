<?php

namespace App\Core\Middleware;

class AuthMiddleware
{
    public static function handle(): void
    {
        MiddlewareService::run('auth'); // Checking authorization

        if ($_SESSION['user']['role'] === 'admin') {
            return; // Админам всегда можно!
        }        

        // Проверяем, запрашивается ли модуль и есть ли у пользователя права на него
        $url = $_SERVER['REQUEST_URI'];
        $userPermissions = $_SESSION['user']['permissions'] ?? [];
        // var_dump($_SESSION['user']);die;
    
        if (preg_match('#^/(research|social|private)#', $url, $matches)) {
            $module = $matches[1];
    
            if (empty($userPermissions[$module]) || !$userPermissions[$module]) {
                die("У вас нет доступа к модулю: " . ucfirst($module));
            }
        }
    }

    public static function checkRole(string $role): bool
    {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === $role;
    }
}
