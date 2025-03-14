<?php

namespace App\Core\Http;

use App\Core\Services\LanguageService;
use App\Core\Middleware\MiddlewareService;

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

        foreach ($languages as $lang) {
            if ($lang['code'] === $langCode) {
                LanguageService::setCurrentLanguage($langCode);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $segments = explode('/', trim($url, '/'));
            array_shift($segments);
            $newUrl = implode('/', $segments);

            header("Location: /{$default}/" . $newUrl);
            exit;
        }

        if (self::matchRoute($url)) {
            // Проверяем метод запроса (GET, POST и т. д.)
            if (!isset(self::$route['method']) || $_SERVER['REQUEST_METHOD'] === strtoupper(self::$route['method'])) {

                // 🟢 Обрабатываем Middleware перед загрузкой контроллера
                if (!empty(self::$route['middleware'])) {
                    MiddlewareService::run(self::$route['middleware']);
                }

                $module = self::$route['module'] ?? '';
                $role = !empty(self::$route['role']) ? '\\' . self::$route['role'] : '';
                $controller = self::$route['controller'] ?? 'Home';
                $action = self::$route['action'] ?? 'index';
                $params = array_values(self::$route['params'] ?? []);

                if ($module == "Api\\V1") {
                    $controllerClass = "App\\Api\\V1\\Controllers{$role}\\$controller" . "Controller";
                } elseif (!empty($module)) {
                    $controllerClass = "App\\Modules\\$module\\Http\\Controllers{$role}\\$controller" . "Controller";
                } elseif (empty($module)) {
                    $controllerClass = "App\\Core\\Http\\Controllers{$role}\\$controller" . "Controller";
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
                    $params = [];
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $params[$key] = $value;
                        }
                    }
                    array_splice($params, 0, 1);
                    $route['params'] = array_values($params); // Добавляем параметры
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
