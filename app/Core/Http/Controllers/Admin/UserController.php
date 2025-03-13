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
        $title = 'user_properties';
        $header = __('user_properties');

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
            $email = $_POST['email'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $role = $_POST['role'];
            $permissions = [
                'research' => isset($_POST['research']),
                'social' => isset($_POST['social']),
                'private' => isset($_POST['private'])
            ];

            $userModel = new User();
            $userModel->updateUser($id, $email, $name, $surname, $role, $permissions);

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
}
