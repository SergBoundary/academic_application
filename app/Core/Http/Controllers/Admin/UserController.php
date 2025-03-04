<?php

namespace App\Core\Http\Controllers\Admin;

use App\Core\Http\Controllers\Controller;
use App\Core\Middleware\MiddlewareService;
use App\Core\Models\User;
use App\Core\Views\View;

class UserController extends Controller
{
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'users';

        $userModel = new User();
        $users = $userModel->getAllUsers();

        $view = new View('', '', 'admin/users/index', compact('language', 'title', 'users'));
        $view->render();
    }

    public function edit($id)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'user_properties';

        $userModel = new User();
        $user = $userModel->getById($id);

        if (!$user) {
            echo "Пользователь не найден!";
            exit;
        }
        $permissions = $userModel->getPermissions($id);

        $view = new View('', '', 'admin/users/edit', compact('language', 'title', 'user', 'permissions'));
        $view->render();
    }

    public function update()
    {
        $language = $this->language;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $permissions = [
                'research' => isset($_POST['research']),
                'social' => isset($_POST['social']),
                'private' => isset($_POST['private'])
            ];

            $userModel = new User();
            $userModel->updateUser($id, $email, $role, $permissions);

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
