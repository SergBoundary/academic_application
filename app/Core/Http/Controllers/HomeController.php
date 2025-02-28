<?php

namespace App\Core\Http\Controllers;

use App\Core\Middleware\MiddlewareService;
use App\Core\Views\View;
use App\Core\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }        

        MiddlewareService::run('auth');

        $module = 'Social';
        $layout = '';
        $view = '';
        $title = 'Пользователи';

        $userModel = new User();
        $users = $userModel->getAllUsers();

        $view = new View($module, $layout, $view, compact(['title', 'users']));
        $view->render();
    }
}
