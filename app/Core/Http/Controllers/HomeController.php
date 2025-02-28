<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;
use App\Modules\Social\Models\User;

class HomeController extends Controller
{
    public function index()
    {
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
