<?php

namespace App\Core\Http;

class Router
{
    protected static array $routes = [];
    protected static array $route = [];

    public static function add(string $pattern, array $route = [])
    {
        self::$routes[$pattern] = $route;
        // var_dump(self::$routes);die;
    }

    public static function dispatch(string $url)
    {
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {
            // Проверяем метод запроса (GET, POST и т. д.)
            if (!isset(self::$route['method']) || $_SERVER['REQUEST_METHOD'] === strtoupper(self::$route['method'])) {
                $module = isset(self::$route['module']) && self::$route['module']
                    ? "Modules\\" . self::$route['module']
                    : 'Core';
                $controller = self::$route['controller'] ?? 'Home';
                $action = self::$route['action'] ?? 'index';
                $role = self::$route['role'] ?? '';
                $params = self::$route['params'] ?? [];

                if ($role == 'Admin') {
                    $controllerClass = "App\\$module\\Http\\Controllers\\Admin\\$controller" . "Controller";
                } else {
                    $controllerClass = "App\\$module\\Http\\Controllers\\$controller" . "Controller";
                }

                if (class_exists($controllerClass)) {
                    $controllerObj = new $controllerClass();
                    if (method_exists($controllerObj, $action)) {
                        call_user_func_array([$controllerObj, $action], $params);
                    } else {
                        echo "Метод $action не найден в $controllerClass";
                    }
                } else {
                    echo "Контроллер $controllerClass не найден";
                }
            }
        } else {
            http_response_code(404);
            echo "Страница не найдена";
        }
    }

    protected static function matchRoute(string $url): bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                if (!isset($route['method']) || $_SERVER['REQUEST_METHOD'] === strtoupper($route['method'])) {
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $route[$key] = $value;
                        }
                    }
                    array_shift($matches); // Удаляем первый элемент (полный URL)
                    $route['params'] = $matches; // Добавляем параметры
                    self::$route = $route;
                    return true;
                }
            }
        }
        return false;
    }

    protected static function removeQueryString(string $url): string
    {
        return explode('?', $url)[0];
    }
}
