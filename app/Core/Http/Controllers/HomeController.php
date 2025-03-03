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

        $module = '';
        $layout = '';
        $view = '';
        $title = 'Пользователи';

        $userModel = new User();
        $users = $userModel->getAllUsers();

        $view = new View($module, $layout, $view, compact(['title', 'users']));
        $view->render();
    }
}
