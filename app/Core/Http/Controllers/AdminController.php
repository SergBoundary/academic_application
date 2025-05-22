<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;
use App\Core\Middleware\MiddlewareService;
use App\Core\Middleware\AuthMiddleware;

class AdminController extends Controller
{
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'admin_panel';
        $header = __('admin_panel');

        if (!AuthMiddleware::checkRole('admin')) {
            echo "Доступ запрещен!";
            exit;
        }

        $menuFirst = [
            'active' => 'admin_panel',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('admin_panel'),
            'list' => [
                ['name' => __('start'), 'url' => '']
            ],
        ];
        
        $menuSecond = [
            'active' => '',
            'list' => [
                ['name' => 'messages', 'url' => $language . '/admin/messages-group', 'disabled' => true],
                ['name' => 'users', 'url' => $language . '/admin/users-group', 'disabled' => true],
                ['name' => 'researches', 'url' => $language . '/admin/research-group', 'disabled' => true],
                ['name' => 'devops', 'url' => $language . '/admin/devops', 'disabled' => true],
            ],
        ];

        $view = new View('', '', 'admin/admin', compact(['language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath']));
        $view->render();
    }
}
