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

