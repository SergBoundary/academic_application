<?php

namespace App\Core\Http;

use App\Core\Services\LanguageService;

class Router
{
    protected static array $routes = [];
    protected static array $route = [];

    public static function add(string $pattern, array $route = [])
    {
        self::$routes[$pattern] = $route;
    }

    public static function dispatch(string $url)
    {
        $default = LanguageService::getDefaultLanguage();
        $url = self::removeQueryString($url);


        if (!preg_match("#(?P<language>[a-z-]+)#i", $url, $matches)) {
            header("Location: /{$default}/" . $url);
            exit;
        }
        $langCode = $matches['language'];
        $languages = $_SESSION['languages'] ?? [];
        $found = false;

        //     echo '<pre>';
        // var_dump($langCode);
        // var_dump($languages);
        // var_dump($default);die;

        foreach ($languages as $lang) {
            if ($lang['code'] === $langCode) {
                LanguageService::setCurrentLanguage($langCode);
                $found = true;
                break;
            }
        }
        //     echo '<pre>';
        // var_dump('found: ' . $found);
        // var_dump('langCode: ' . $langCode);
        if (!$found) {
            $segments = explode('/', trim($url, '/'));
            // var_dump($segments);
            array_shift($segments);
            // var_dump($segments);
            $newUrl = implode('/', $segments);
            // var_dump($newUrl);
            // die;
            // array_splice($matches, 0, 2);

            header("Location: /{$default}/" . $newUrl);
            exit;
        }

            // die;

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
                    array_splice($matches, 0, 3);
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
        if ($url !== '') {
            $url = explode('?', $url)[0]; // Убираем GET-параметры
            $url = explode('&', $url)[0]; // Убираем параметры, если они переданы через '&'
        }
        return rtrim($url, '/');
    }
}
