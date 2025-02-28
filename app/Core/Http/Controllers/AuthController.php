<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;

class AuthController extends Controller
{
    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Простая проверка (в реальном проекте используй хеширование!)
            if ($email === 'prog.sebo@gmail.com' && $password === 'a') {
                $_SESSION['user'] = ['email' => $email];
                header("Location: /");
                exit;
            } else {
                $error = "Неверный email или пароль!";
            }
        }

        $view = new View('', '', 'login', compact('error'));
        $view->render();
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
