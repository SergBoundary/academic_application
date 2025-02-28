<?php

use App\Core\Services\DatabaseService;
use App\Core\Middleware\MiddlewareService;
use App\Core\Middleware\AuthMiddleware;
use App\Core\Middleware\CsrfMiddleware;
// use Core\Services\LoggerService;

// Автозагрузка классов (если без Composer)
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Запуск сервисов
DatabaseService::init();
// LoggerService::init();

// Подключаем маршруты
require_once __DIR__ . '/../routes/web.php';

session_start();

// Регистрируем middleware
MiddlewareService::add('auth', [AuthMiddleware::class, 'handle']);
MiddlewareService::add('csrf', function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        CsrfMiddleware::validateToken($_POST['_csrf'] ?? '');
    }
});
