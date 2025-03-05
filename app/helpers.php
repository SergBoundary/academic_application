<?php
if (!function_exists('__')) {
    function __($key)
    {
        return \App\Core\Services\LanguageService::translate($key);
    }
}
