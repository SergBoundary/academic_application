<?php

namespace App\Core\Models;

class Language extends Model
{
    public function getLanguages(): array
    {
        $sql = "SELECT `code`, `name`, `default` FROM `languages` WHERE `visible` = 1";
        return $this->query($sql);
    }
    
    public function getLangTranslates($lang): array
    {
        $sql = "SELECT `key_name`, `{$lang}` as `translation` FROM `translations`";
        $result = $this->query($sql);

        return $result;
    }
    
    public function getTranslate($lang, $key): array
    {
        $sql = "SELECT `{$lang}` as `translation` FROM `translations` WHERE `key_name` = :key LIMIT 1";
        $result = $this->query($sql, ['key' => $key]);

        return $result[0];
    }
}
