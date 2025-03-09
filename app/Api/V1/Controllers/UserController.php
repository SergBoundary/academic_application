<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Middleware\JWTMiddleware;
use App\Core\Services\RedisService;
use App\Core\Models\User;

class UserController extends BaseApiController
{
    public function index()
    {
        // Проверяем JWT
        $userData = JWTMiddleware::check(); // если не прошел, отправит 401 и выйдет
        // Здесь можно проверить роль или другие данные пользователя из $userData

        // Подключаем Redis
        $redis = RedisService::getConnection();
        $cacheKey = "users_list";

        // Если в Redis уже есть данные, возвращаем их
        $cachedUsers = $redis->get($cacheKey);
        if ($cachedUsers) {
            $this->jsonResponse(['users' => json_decode($cachedUsers, true)]);
        }

        // Получаем список пользователей, например:
        $userModel = new User();
        $users = $userModel->getAllUsers();

        // Декодируем permissions перед отправкой ответа
        foreach ($users as &$user) {
            $user['permissions'] = json_decode($user['permissions'], true);
        }

        // Кэшируем результат на 1 час (3600 секунд)
        $redis->setex($cacheKey, 3600, json_encode($users));

        $this->jsonResponse(['users' => $users]);
    }

    public function update()
{
    // Проверяем токен
    $userData = JWTMiddleware::check();

    // Проверяем, является ли пользователь админом
    if ($userData['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(['error' => 'Access denied']);
        exit;
    }

    // Получаем входные данные
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data || !isset($data['id'], $data['email'], $data['name'], $data['surname'], $data['role'], $data['permissions'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input data']);
        exit;
    }

    // Обновляем пользователя
    $userModel = new User();
    $updated = $userModel->updateUser($data['id'], $data['email'], $data['name'], $data['surname'], $data['role'], $data['permissions']);

    if ($updated) {
        // Удаляем кэш пользователей в Redis
        $redis = RedisService::getConnection();
        $redis->del("users_list");

        $this->jsonResponse(['message' => 'User updated successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update user']);
    }
}

}
