<?php

namespace App\Core\Services;

use App\Core\Models\Language;

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
        
        // Попробуем сначала получить перевод из Redis (если настроено)
        $cacheKey = "chash_{$lang}";
        // Пример: $redis = new \Redis(); $redis->connect('127.0.0.1');
        // $translation = $redis->hGet($cacheKey, $key);
        // if ($translation) { return $translation; }
        
        // Если Redis не используется или ключ не найден, обращаемся к MySQL
        $languageModel = new Language();
        $result = $languageModel->getTranslate($lang, $key);
        // var_dump($lang);die;

        $translation = $result ? $result['translation'] : $key;
        
        // Можно сохранить $translation в Redis для ускорения
        // $redis->hSet($cacheKey, $key, $translation);
        
        return $translation;
    }
}
