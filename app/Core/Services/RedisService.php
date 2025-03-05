<?php

namespace App\Core\Services;

use App\Core\Models\Language;
use Predis\Client as PredisClient;

class RedisService
{
    protected static ?PredisClient $redis = null;

    public static function getConnection(): PredisClient
    {
        if (self::$redis === null) {
            // Подключаем и настраиваем подключение Redis
            $config = require ROOT . '/config/redis.php';
            self::$redis = new PredisClient($config);
            // self::$redis->connect($config['scheme'], $config['host'], $config['port']);
            // При необходимости, авторизация:
            // self::$redis->auth('your_redis_password');
        }
        return self::$redis;
    }

    public static function initializeCacheForLanguage(string $lang)
    {
        $redis = RedisService::getConnection();
        $cacheKey = "cache_{$lang}";

        if (!$redis->exists($cacheKey)) {
            // Запрашиваем все переводы для языка из базы
            $languageModel = new Language();
            $translations = $languageModel->getLangTranslates($lang);

            // Отладка: проверьте, что возвращается из базы
            if (!is_array($translations)) {
                error_log("Error: Translations query did not return an array. Returned: " . print_r($translations, true));
                return;
            }

            if (!empty($translations)) {
                foreach ($translations as $row) {
                    // Если $row не массив, выводим отладочную информацию
                    if (!is_array($row)) {
                        error_log("Error: Row is not an array: " . print_r($row, true));
                        continue;
                    }
                    $redis->hSet($cacheKey, $row['key_name'], $row['translation']);
                }
            }
        }
    }
}
