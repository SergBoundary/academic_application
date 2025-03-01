<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;
use App\Core\Middleware\AuthMiddleware;

class AdminController extends Controller
{
    public function index()
    {
        if (!AuthMiddleware::checkRole('admin')) {
            echo "Доступ запрещен!";
            exit;
        }

        $view = new View('', '', 'admin\\admin');
        $view->render();
    }
}
