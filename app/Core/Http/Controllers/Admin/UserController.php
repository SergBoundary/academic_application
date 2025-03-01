<?php

namespace App\Core\Http\Controllers\Admin;

use App\Core\Http\Controllers\Controller;
use App\Core\Models\User;
use App\Core\Views\View;

class UserController extends Controller
{
    public function index()
    {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        $view = new View('', '', 'admin/users/index', compact('users'));
        $view->render();
    }

    public function edit($id)
    {
        $userModel = new User();
        $user = $userModel->getById($id);

        if (!$user) {
            echo "Пользователь не найден!";
            exit;
        }

        $view = new View('', '', 'admin/users/edit', compact('user'));
        $view->render();
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            $userModel = new User();
            $userModel->updateUser($id, $email, $role);

            header("Location: /admin/users");
            exit;
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $userModel = new User();
            $userModel->deleteUser($id);

            header("Location: /admin/users");
            exit;
        }
    }
}
