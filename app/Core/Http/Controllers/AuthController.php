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
                    // Генерируем `username`
                    $username = $userModel->generateUsername($name, $surname);
                    // Хешируем пароль перед сохранением
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $userModel->createUser($username, $name, $surname, $email, $hashedPassword);

                    header("Location: /{$language}/login");
                    exit;
                }
            }
        }

        $menuFirst = [
            'active' => 'authorization',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('register'),
            'list' => [
                ['name' => __('start'), 'url' => '']
            ],
        ];
        
        $menuSecond = [
            'active' => 'register',
            'list' => [],
        ];

        $view = new View('', '', 'register', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'error'));
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
            // Проверка email
            if (isset($user)) {
                $userPassword = $userModel->getUserPassword($user['id']);

                // Проверка email с хешированым паролем
                if (isset($user) && $email === $user['email'] && password_verify($password, $userPassword['password'])) {
                    // Загружаем права доступа
                    $permissions = $userModel->getPermissions($user['id']);
                    // Создаем сессию для пользователя и записываем в нее его свойства
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'name' => $user['name'],
                        'surname' => $user['surname'],
                        'avatar' => $user['avatar'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'permissions' => $permissions
                    ];
                    header("Location: /{$language}");
                    exit;
                } else {
                    $error = __('incorrect_data_entered');
                }
            } else {
                $error = __('incorrect_data_entered');
            }
        }

        $menuFirst = [
            'active' => 'authorization',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('authorization'),
            'list' => [
                ['name' => __('start'), 'url' => '']
            ],
        ];
        
        $menuSecond = [
            'active' => 'authorization',
            'list' => [],
        ];

        $view = new View('', '', 'login', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'error'));
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
        $header = __('reset_password');

        $menuFirst = [
            'active' => 'authorization',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('reset_password'),
            'list' => [
                ['name' => __('start'), 'url' => '']
            ],
        ];
        
        $menuSecond = [
            'active' => 'reset_password',
            'list' => [],
        ];

        $view = new View('', '', 'password/reset', compact('language', 'header', 'menuFirst', 'menuSecond', 'mapPath', 'title'));
        $view->render();
    }

    public function sendResetLink()
    {
        $language = $this->language;
        $title = 'reset_password';
        $header = __('reset_password');

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

        $menuFirst = [
            'active' => 'authorization',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('reset_password'),
            'list' => [
                ['name' => __('start'), 'url' => '']
            ],
        ];
        
        $menuSecond = [
            'active' => 'reset_password',
            'list' => [],
        ];

        $view = new View('', '', 'password/send_link', compact('language', 'header', 'menuFirst', 'menuSecond', 'mapPath', 'title'));
        $view->render();
    }

    public function showNewPasswordForm()
    {
        $language = $this->language;
        $title = 'new_password';
        $header = __('new_password');

        $menuFirst = [
            'active' => 'authorization',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('new_password'),
            'list' => [
                ['name' => __('start'), 'url' => '']
            ],
        ];
        
        $menuSecond = [
            'active' => 'new_password',
            'list' => [],
        ];

        $view = new View('', '', 'password/new', compact('language', 'header', 'menuFirst', 'menuSecond', 'mapPath', 'title'));
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
