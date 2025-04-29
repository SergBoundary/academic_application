<?php

if (!function_exists('__')) {
    function __($key)
    {
        return \App\Core\Services\LanguageService::translate($key);
    }
}

if (!function_exists('isUserLoggedIn')) {
    function isUserLoggedIn(): bool {
        return isset($_SESSION['user']);
    }
}

if (!function_exists('isAdminLoggedIn')) {
    function isAdminLoggedIn(): bool {
        return $_SESSION['user']['role'] === 'admin';
    }
}

if (!function_exists('debug')) {
    function debug($arr, $die = false) {
        echo '<pre>'.print_r($arr, true).'</pre>';
        if ($die) {
            die;
        }
    }
}
