<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;
use App\Core\Models\User;
use App\Core\Models\PasswordReset;
use App\Core\Services\Mailer;

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
        $_SESSION = [];
        session_destroy();
        header("Location: /login");
        exit;
    }

    public function showResetForm()
    {
        $view = new View('', '', 'password/reset');
        $view->render();
    }

    public function sendResetLink()
    {
        $email = $_POST['email'] ?? '';
        if (!$email) {
            die("Email обязателен!");
        }

        $userModel = new User();
        $user = $userModel->getByEmail($email);
        if (!$user) {
            die("Пользователь не найден!");
        }

        $token = bin2hex(random_bytes(32));
        $resetModel = new PasswordReset();
        $resetModel->createResetToken($email, $token);

        // Отправляем ссылку на email
        $subject = 'Восстановление пароля'; 
        $body = "<p>Для сброса пароля перейдите по ссылке:</p> <p><a href='https://acapp.loc/password/new?token=$token'>Сбросить пароль</a></p>";
        
        Mailer::send($email, $subject, $body);
        echo "<p>Проверьте свою почту и перейдите по ссылке для сброса пароля.</p>";
        echo "<p>Если письмо со ссылкой не пришло, то проверьте папку со спамом. Возможно, оно там.</p>";
        echo '<p><a href="/logout">Вернуться к форме входа</a></p>';
    }

    public function showNewPasswordForm()
    {
        $view = new View('', '', 'password/new');
        $view->render();
    }

    public function updatePassword()
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$token || !$password) {
            die("Ошибка: не хватает данных.");
        }

        $resetModel = new PasswordReset();
        $reset = $resetModel->getByToken($token);
        if (!$reset) {
            die("Токен недействителен!");
        }

        $userModel = new User();
        $userModel->updatePasswordByEmail($reset['email'], password_hash($password, PASSWORD_DEFAULT));

        $resetModel->deleteByEmail($reset['email']);

        echo "<p>Пароль успешно обновлен!<p>";
        echo "<a href='/login'>Вернуться к форме логирования.</a>";
    }
}
