<?php
session_start([
    'cookie_lifetime' => 86400, // 1 день
    'cookie_httponly' => true,  // Защита от XSS
    'cookie_secure'   => isset($_SERVER['HTTPS']), // Только HTTPS
]);

define("WWW", __DIR__);
define("ROOT", dirname(__DIR__));
define("APP", dirname(__DIR__) . '/app');
define("CORE", dirname(__DIR__) . '/app/Core');
define("MODULES", dirname(__DIR__) . '/app/Modules');

require_once CORE . '/Helpers/helpers.php';
require_once ROOT . '/vendor/autoload.php';  // Composer
require_once ROOT . '/config/bootstrap.php'; // Инициализация системы

use App\Core\Http\Router;

$query = rtrim($_SERVER['QUERY_STRING'], '/');
Router::dispatch($query);