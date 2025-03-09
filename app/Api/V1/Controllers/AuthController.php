<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Services\JWTService;
use App\Core\Models\User;

class AuthController extends BaseApiController
{
    public function login()
    {
        // Чтение JSON-данных из тела запроса
        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);
        if (is_null($data)) {
            // Вы можете отправить JSON-ответ с ошибкой и HTTP статусом 400
            error_log("Ошибка: входящие данные не распарсились. Raw input: " . $rawInput);
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid input, JSON expected.']);
            exit;
        }

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $userModel = new User();
        $user = $userModel->getByEmail($email);
        $userPassword = $userModel->getUserPassword($user['id']);

        if ($user && password_verify($password, $userPassword['password'])) {
            // Генерация токена, можно добавить в payload необходимые поля, например, id, email, role
            $token = JWTService::generateToken([
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'role' => $user['role'],
                'permissions' => $user['permissions']
            ]);
            $this->jsonResponse(['token' => $token]);
        } else {
            $this->jsonResponse(['error' => 'Invalid credentials'], 401);
        }
    }
}
