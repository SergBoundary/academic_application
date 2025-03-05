<?php

namespace App\Core\Services;

use App\Core\Models\Language;
use App\Core\Services\RedisService;

class LanguageService
{
    protected static $model;
    protected static $languages = [];
    protected static $defaultLanguage = 'ru';

    public static function loadLanguages()
    {
        $languageModel = new Language();
        self::$languages = $languageModel->getLanguages();
        
        // Определяем язык по умолчанию из базы
        foreach (self::$languages as $lang) {
            if ($lang['default']) {
                self::$defaultLanguage = $lang['code'];
                break;
            }
        }
        
        // Сохраним языки в сессии или глобальной переменной, если нужно
        $_SESSION['languages'] = self::$languages;
    }
    
    public static function getDefaultLanguage()
    {
        return self::$defaultLanguage;
    }
    
    public static function getCurrentLanguage()
    {
        // Если язык указан в URL, используем его, иначе язык по умолчанию
        if (isset($_SESSION['current_language'])) {
            return $_SESSION['current_language'];
        }
        return self::$defaultLanguage;
    }
    
    public static function setCurrentLanguage($langCode)
    {
        // Можно добавить проверку: если $langCode существует в self::$languages
        $_SESSION['current_language'] = $langCode;
    }
    
    public static function translate($key)
    {
        $lang = self::getCurrentLanguage();
        
        // Получаем подключение к Redis
        $redis = RedisService::getConnection();
        // Формируем ключ кэша для языка, например: "cache_ru"
        $cacheKey = "cache_{$lang}";

        // Инициализируем кэш для языка, если он ещё не создан
        RedisService::initializeCacheForLanguage($lang);
        
        // Пытаемся получить перевод из Redis (хэш с ключами переводов)
        $translation = $redis->hGet($cacheKey, $key);
        if ($translation !== false && $translation !== null) {
            return $translation;
        }
        
        // Если Redis не используется или ключ не найден, обращаемся к MySQL
        $languageModel = new Language();
        $result = $languageModel->getTranslate($lang, $key);
        
        if ($result && !empty($result['translation'])) {
            $translation = $result['translation'];
            // Сохраняем перевод в Redis для ускорения будущих запросов
            $redis->hSet($cacheKey, $key, $translation);
            return $translation;
        }
        
        // Если перевода нет, возвращаем ключ (или можно вернуть пустую строку)
        return $key;
    }
}
