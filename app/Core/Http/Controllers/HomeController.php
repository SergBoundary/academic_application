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

        $menuFirst = [
            'active' => '',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('start'),
            'list' => [],
        ];
        
        $menuSecond = [
            'active' => 'we',
            'list' => [
                ['name' => 'our_world', 'url' => $language . '/', 'disabled' => true],
                ['name' => 'we', 'url' => $language . '/we', 'disabled' => true],
            ],
        ];

        $view = new View('', '', '', compact(['language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'users', 'statAllUsers']));
        $view->render();
    }
}
