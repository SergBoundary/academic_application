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

        $navbar = 'admin';
        $breadcrumb = [
            'active' => __('admin_panel'),
            'list' => [
                ['name' => 'AcApp', 'url' => '']
            ],];

        $view = new View('', '', 'admin/admin', compact(['language', 'header', 'title', 'navbar', 'breadcrumb']));
        $view->render();
    }
}
