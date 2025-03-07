<?php

namespace App\Modules\Research\Http\Controllers;

use App\Core\Views\View;
use App\Core\Middleware\MiddlewareService;

class ResearchController extends Controller
{
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = $this->title;
        $header = __($this->title);
        
        $view = new View('Research', '', 'index', compact('language', 'header', 'title'));
        $view->render();
    }
}
