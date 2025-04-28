<?php

namespace App\Core\Http\Controllers\Admin;

use App\Core\Http\Controllers\Controller;
use App\Core\Middleware\MiddlewareService;
use App\Core\Models\User;
use App\Core\Views\View;
use App\Core\Services\RedisService;

class UserController extends Controller
{
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'users';
        $header = __('users');

        $userModel = new User();
        $users = $userModel->getAllUsers();

        $view = new View('', '', 'admin/users/index', compact('language', 'header', 'title', 'users'));
        $view->render();
    }

    public function edit($id)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'editing_user_data';
        $header = __('editing_user_data');

        $userModel = new User();
        $user = $userModel->getById($id);

        if (!$user) {
            echo "Пользователь не найден!";
            exit;
        }
        $permissions = $userModel->getPermissions($id);

        $view = new View('', '', 'admin/users/edit', compact('language', 'header', 'title', 'user', 'permissions'));
        $view->render();
    }

    public function update()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $avatar = $_POST['avatar'];
            $role = $_POST['role'];
            $permissions = [
                'research' => isset($_POST['research']),
                'discussion' => isset($_POST['discussion']),
                'project' => isset($_POST['project'])
            ];

            // Проверяем, существует ли пользователь
            $userModel = new User();
            $user = $userModel->getById($id);
    
            if (!$user) {
                http_response_code(404);
                echo "Пользователь не найден!";
                exit;
            }

            // Проверяем, загружен ли файл
            if (!empty($_FILES['avatar']['name'])) {
                $avatarPath = $this->uploadAvatar($_FILES['avatar'], $user['id']);
            } else {
                $avatarPath = $user['avatar'];
            }

            $userModel->updateUser($id, $name, $surname, $avatarPath, $email, $role, $permissions);

            $updatedUser = $userModel->getById($id);
            // Обновляем кэш в Redis:
            $redis = RedisService::getConnection();
            $key = "user_data:{$id}";
            // Сохраним данные в виде хэша:
            $redis->hmset($key, $updatedUser);
            // Установим TTL, например, 1 час:
            $redis->expire($key, 3600);

            // Если админ редактирует сам себя — обновляем сессию
            if ($_SESSION['user']['id'] == $id) {
                $_SESSION['user']['permissions'] = $permissions;
            }


            header("Location: /{$language}/admin/users");
            exit;
        }
    }

    public function delete()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $userModel = new User();
            $userModel->deleteUser($id);

            header("Location: /{$language}/admin/users");
            exit;
        }
    }

    // Метод загрузки аватара
    private function uploadAvatar($file, $userId)
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $uploadDir = ROOT . '/storage/uploads/avatars/';

        // Проверяем и создаём директорию, если её нет
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Проверяем MIME-тип
        if (!in_array($file['type'], $allowedTypes)) {
            echo "Ошибка: Допустимы только JPG, PNG и GIF!";
            exit;
        }

        // Генерируем уникальное имя файла
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = "user_avatar_{$userId}." . $fileExt;
        $filePath = $uploadDir . $fileName;

        // Перемещаем загруженный файл
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $fileName;
        } else {
            echo "Ошибка загрузки файла!";
            exit;
        }
    }
}
