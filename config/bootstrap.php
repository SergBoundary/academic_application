<?php

use App\Core\Services\DatabaseService;
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
