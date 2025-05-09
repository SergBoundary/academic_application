<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;
use App\Core\Models\User;
use App\Core\Models\Statistics;
use App\Core\Middleware\MiddlewareService;

class HomeController extends Controller
{
    public function index()
    {
        $language = $this->language;
        
        $title = 'welcome_to_acapp';
        $header = __('welcome_to_acapp');

        $userModel = new User();
        $users = $userModel->getAllUsers();

        $statModel = new Statistics();
        $statAllUsers = $statModel->statAllUsers();

        $navbar = '';
        $breadcrumb = [
            'active' => 'AcApp',
            'list' => [],
        ];

        $view = new View('', '', '', compact(['language', 'header', 'title', 'navbar', 'breadcrumb', 'users', 'statAllUsers']));
        $view->render();
    }
}
