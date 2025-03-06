<?php

namespace App\Core\Middleware;

use App\Core\Services\LanguageService;

class AuthMiddleware
{
    public static function handle(): void
    {
        // Checking authorization
        if (!isset($_SESSION['user'])) { 
            $language = LanguageService::getCurrentLanguage();
            header("Location: /{$language}/login");
            exit;
        }        

        if ($_SESSION['user']['role'] === 'admin') {
            return; // AThe administrator has access to everything
        }        

        // We check whether the module is requested and whether the user has rights to it
        $url = $_SERVER['REQUEST_URI'];
        $userPermissions = $_SESSION['user']['permissions'] ?? [];
    
        if (preg_match('#^/(?P<language>[a-z-]+)/(?P<module>research|social|private)(/|$)#', $url, $matches)) {
            $module = $matches['module'];
    
            if (empty($userPermissions[$module]) || !$userPermissions[$module]) {
                die("У вас нет доступа к модулю: " . ucfirst($module));
            }
        }
    }

    public static function checkRole(string $role): bool
    {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === $role;
    }
}
