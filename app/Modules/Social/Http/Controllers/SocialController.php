<?php

namespace App\Modules\Social\Http\Controllers;

use App\Core\Views\View;
use App\Core\Middleware\MiddlewareService;

class SocialController extends Controller
{
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $title = $this->title;
        
        $view = new View('Social', '', 'index', compact('title'));
        $view->render();
    }
}
