<?php

namespace App\Core\Middleware;

use App\Core\Models\User;

class PermissionMiddleware
{
    public static function handle(string $module): void
    {
        if (!isset($_SESSION['user']['id'])) {
            die("Доступ запрещен. Авторизуйтесь!");
        }

        $userModel = new User();
        $permissions = $userModel->getPermissions($_SESSION['user']['id']);

        if (empty($permissions[$module])) {
            die("Доступ к модулю \"$module\" запрещен!");
        }
    }
}
