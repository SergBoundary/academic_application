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
        $language = $this->language;
        $title = 'register';
        $header = __('register');
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

                    header("Location: /{$language}/login");
                    exit;
                }
            }
        }

        $view = new View('', '', 'register', compact('language', 'header', 'title', 'error'));
        $view->render();
    }

    public function login()
    {
        $language = $this->language;
        $title = 'authorization';
        $header = __('authorization');
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->getByEmail($email);
            $userPassword = $userModel->getUserPassword($user['id']);

            // Проверка email с хешированым паролем
            if (isset($user) && $email === $user['email'] && password_verify($password, $userPassword['password'])) {
                // Загружаем права доступа
                $permissions = $userModel->getPermissions($user['id']);
                // Создаем сессию для пользователя и записываем в нее его свойства
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'permissions' => $permissions
                ];
                // Если админ — отправляем на /admin
                if ($user['role'] === 'admin') {
                    header("Location: /{$language}/admin");
                    exit;
                }
                header("Location: /{$language}");
                exit;
            } else {
                $error = "Неверный email или пароль!";
            }
        }

        $view = new View('', '', 'login', compact('language', 'header', 'title', 'error'));
        $view->render();
    }

    public function logout()
    {
        $language = $this->language;
        $_SESSION = [];
        session_destroy();
        header("Location: /{$language}/login");
        exit;
    }

    public function showResetForm()
    {
        $language = $this->language;
        $title = 'reset_password';
        $view = new View('', '', 'password/reset', compact('language', 'title'));
        $view->render();
    }

    public function sendResetLink()
    {
        $language = $this->language;
        $title = 'reset_password';
        
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
        $body = "<p>Для сброса пароля перейдите по ссылке:</p> <p><a href='https://acapp.loc/{$language}/password/new?token=$token'>Сбросить пароль</a></p>";
        
        Mailer::send($email, $subject, $body);
        
        $view = new View('', '', 'password/send_link', compact('language', 'title'));
        $view->render();
    }

    public function showNewPasswordForm()
    {
        $language = $this->language;
        $view = new View('', '', 'password/new', compact('language'));
        $view->render();
    }

    public function updatePassword()
    {
        $language = $this->language;
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
        echo "<a href='/{$language}/login'>Вернуться к форме логирования.</a>";
    }
}
