<?php

namespace App\Core\Middleware;

use App\Core\Services\LanguageService;
use App\Core\Models\User;
use App\Core\Services\RedisService;

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
            return; // The administrator has access to everything
        }

        $userId = $_SESSION['user']['id'];
        $redis = RedisService::getConnection();
        $key = "user_data:{$userId}";
        $cachedUser = $redis->hgetall($key);

        if (!empty($cachedUser)) {
            // Если кэшированная метка времени отличается от сессионной, обновляем сессию
            if (!isset($_SESSION['user']['updated_at']) || $cachedUser['updated_at'] !== $_SESSION['user']['updated_at']) {
                $_SESSION['user'] = $cachedUser;
            }
        } else {
            // Если в кэше нет данных, то обращаемся к базе, чтобы получить свежие данные
            $userModel = new User();
            $latestUserData = $userModel->getById($userId);
            if ($latestUserData && isset($latestUserData['updated_at'])) {
                $_SESSION['user'] = $latestUserData;
                // Обновляем кэш:
                $redis->hmset($key, $latestUserData);
                $redis->expire($key, 3600);
            }
        }

        // We check whether the module is requested and whether the user has rights to it
        $url = $_SERVER['REQUEST_URI'];
        $userPermissions = $_SESSION['user']['permissions'] ?? [];
    
        if (preg_match('#^/(?P<language>[a-z-]+)/(?P<module>research|discussion|private)(/|$)#', $url, $matches)) {
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
