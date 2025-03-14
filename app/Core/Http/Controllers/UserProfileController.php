<?php

namespace App\Core\Http\Controllers;

use App\Core\Views\View;
use App\Core\Models\User;
use App\Core\Models\Message;
use App\Core\Middleware\MiddlewareService;

class UserProfileController extends Controller
{
    public function index($username)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;

        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Пользователь не найден!";
            exit;
        }

        $title = 'user_profile';
        $header = __('user_profile') . ' : ' . $user['name'] . ' ' . $user['surname'];

        $view = new View('', '', 'user/profile', compact('language', 'header', 'title', 'user'));
        $view->render();
    }

    public function edit($username)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;

        // Проверяем, существует ли пользователь
        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Пользователь не найден!";
            exit;
        }

        // Проверяем, является ли пользователь владельцем профиля
        if ($_SESSION['user']['id'] != $user['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $title = 'editing_profile';
        $header = __('editing_profile') . ' : ' . $user['name'] . ' ' . $user['surname'];

        $view = new View('', '', 'user/edit-profile', compact('language', 'header', 'title', 'user'));
        $view->render();
    }

    public function update($username)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;

        // Проверяем, существует ли пользователь
        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Пользователь не найден!";
            exit;
        }

        // Проверяем, является ли пользователь владельцем профиля
        if ($_SESSION['user']['id'] != $user['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        // Получаем данные формы
        $name = $_POST['name'] ?? '';
        $surname = $_POST['surname'] ?? '';

        // Проверяем, загружен ли файл
        if (!empty($_FILES['avatar']['name'])) {
            $avatarPath = $this->uploadAvatar($_FILES['avatar'], $user['id']);
        } else {
            $avatarPath = $user['avatar'];
        }

        // Обновляем данные в БД
        $userModel->updateProfile($user['id'], $name, $surname, $avatarPath);

        // Перенаправляем на страницу профиля
        header("Location: /$language/$username/profile");
        exit;
    }

    public function delete($username)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;

        // Получаем данные пользователя
        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Пользователь не найден!";
            exit;
        }

        // Проверяем, что пользователь удаляет СВОЙ аккаунт
        if ($_SESSION['user']['id'] != $user['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        // Удаляем аватар, если он есть
        if (!empty($user['avatar'])) {
            $avatarPath = ROOT . "/storage/uploads/avatars/" . $user['avatar'];
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }
        }

        // Удаляем пользователя из БД
        $userModel->deleteUser($user['id']);

        // Удаляем сессию (автоматический выход)
        session_destroy();

        // Перенаправляем на главную страницу
        header("Location: /$language/");
        exit;
    }

    public function sendMessage($username)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;

        // Получаем пользователя
        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Пользователь не найден!";
            exit;
        }

        // Проверяем, что отправляет СВОЙ профиль
        if ($_SESSION['user']['id'] != $user['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        // Получаем текст сообщения
        $messageText = trim($_POST['message'] ?? '');

        if (empty($messageText)) {
            echo "Ошибка: Сообщение не может быть пустым!";
            exit;
        }

        // Сохраняем сообщение в БД
        $messageModel = new Message();
        $messageModel->saveMessage($user['id'], $user['email'], $messageText);

        // Перенаправляем обратно на профиль
        header("Location: /$language/$username/profile?success=1");
        exit;
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
