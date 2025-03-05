<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;
use App\Core\Models\User;
use App\Core\Middleware\MiddlewareService;

class HomeController extends Controller
{
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $module = '';
        $layout = '';
        $view = '';
        $title = 'users';
        $header = __('users');

        $userModel = new User();
        $users = $userModel->getAllUsers();

        $view = new View($module, $layout, $view, compact(['language', 'header', 'title', 'users']));
        $view->render();
    }
}
