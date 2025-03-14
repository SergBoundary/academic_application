<?php

namespace App\Core\Middleware;

class GuestMiddleware
{
    public static function handle()
    {
        if (isset($_SESSION['user'])) {
            // Если пользователь залогинен, он не гость, доступ запрещён
            http_response_code(403);
            die("Доступ разрешен лишь для гостей!");
        }
    }
}
