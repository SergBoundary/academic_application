<?php

namespace App\Core\Http\Controllers;

use App\Core\Models\Model;
use App\Core\Services\LanguageService;

class Controller
{
    protected $language;

    public function __construct()
    {
        $this->language = LanguageService::getCurrentLanguage();
    }
}
