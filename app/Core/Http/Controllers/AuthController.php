<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;
use App\Core\Models\User;

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
                    // Хешируем пароль перед сохранением
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $userModel->createUser($name, $surname, $email, $hashedPassword);

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
            $user = $userModel->getByEmail($email);

            // Проверка email с хешированым паролем
            if (isset($user) && $email === $user['email'] && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
                // Если админ — отправляем на /admin
                if ($user['role'] === 'admin') {
                    header("Location: /admin");
                    exit;
                }
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
