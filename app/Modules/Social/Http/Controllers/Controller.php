<?php

namespace App\Modules\Social\Http\Controllers;

use App\Core\Models\Model;
use App\Core\Services\LanguageService;

class Controller
{
    protected $language;
    public $title;

    public function __construct()
    {
        $this->language = LanguageService::getCurrentLanguage();
        $this->title = 'social_network';
    }
}
