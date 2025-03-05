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
        if (!AuthMiddleware::checkRole('admin')) {
            echo "Доступ запрещен!";
            exit;
        }

        $title = 'admin_panel';

        $view = new View('', '', 'admin/admin', compact(['language', 'title']));
        $view->render();
    }
}
