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
        // echo '<pre>';
        // var_dump(self::$routes);die;
        if (self::matchRoute($url)) {
          // var_dump(self::$route['module']);die;
            $module = isset(self::$route['module']) && self::$route['module'] 
              ? "Modules\\" . self::$route['module'] 
              : 'Core';      
            $controller = self::$route['controller'] ?? 'Index';
            $action = self::$route['action'] ?? 'index';

            $controllerClass = "App\\$module\\Http\\Controllers\\$controller" . "Controller";

            if (class_exists($controllerClass)) {
                $controllerObj = new $controllerClass();
                if (method_exists($controllerObj, $action)) {
                    $controllerObj->$action();
                } else {
                    echo "Метод $action не найден в $controllerClass";
                }
            } else {
                echo "Контроллер $controllerClass не найден";
            }
        } else {
            http_response_code(404);
            echo "Страница не найдена";
        }
    }

    protected static function matchRoute(string $url): bool
    {
        foreach (self::$routes as $pattern => $route) {
          // echo '<pre>';
          // var_dump($pattern);
          // var_dump($route);
            if (preg_match("#$pattern#i", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    protected static function removeQueryString(string $url): string
    {
        return explode('?', $url)[0];
    }
}
