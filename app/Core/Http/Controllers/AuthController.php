<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;
use App\Modules\Social\Models\User;

class AuthController extends Controller
{
    public function register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $surname = $_POST['surname'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (!$name || !$email || !$password) {
                $error = "Заполните все обязательные поля: Имя, Email, Пароль!";
            } else {
                $userModel = new User();
                $existingUser = $userModel->getByEmail($email);

                if ($existingUser) {
                    $error = "Этот email уже зарегистрирован!";
                } else {
                    $userModel->createUser($name, $surname, $email, $password);
                    header("Location: /login");
                    exit;
                }
            }
        }

        $view = new View('', '', 'register', compact('error'));
        $view->render();
    }

    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $existingUser = $userModel->getByEmail($email);

            // Простая проверка (в реальном проекте используй хеширование!)
            if ($email === $existingUser['email'] && $password === $existingUser['password']) {
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
