<?php

namespace App\Core\Middleware;

class MiddlewareService
{
    private static array $middlewares = [];

    public static function add(string $key, callable $middleware): void
    {
        self::$middlewares[$key] = $middleware;
    }

    public static function run(string $key): void
    {
        if (isset(self::$middlewares[$key])) {
            call_user_func(self::$middlewares[$key]);
        }
    }
}
