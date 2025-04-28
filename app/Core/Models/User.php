<?php

namespace App\Core\Models;

use App\Core\Models\Model;

class User extends Model
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model();
    }

    public function getAllUsers(): array
    {
        $sql = "SELECT `id`, `username`, `name`, `surname`, `avatar`, `email`, `role`, `permissions`, `updated_at` FROM `users`";
        $result = $this->model->query($sql);
        return $result;
    }

    public function getByEmail(string $email): ?array
    {
        $sql = "SELECT `id`, `username`, `name`, `surname`, `avatar`, `email`, `role`, `permissions`, `updated_at` FROM `users` WHERE `email` = :email LIMIT 1";
        $result = $this->model->query($sql, ['email' => $email]);
        return $result ? $result[0] : null;
    }

    public function getUserByUsername(string $username): ?array
    {
        $sql = "SELECT `id`, `username`, `name`, `surname`, `avatar`, `email`, `role`, `permissions`, `updated_at` FROM `users` WHERE `username` = :username LIMIT 1";
        $result = $this->model->query($sql, ['username' => $username]);
        return $result ? $result[0] : null;
    }

    public function getById($id)
    {
        $sql = "SELECT `id`, `username`, `name`, `surname`, `avatar`, `email`, `role`, `permissions`, `updated_at` FROM `users` WHERE `id` = :id";
        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function getUserPassword($id)
    {
        $sql = "SELECT `id`, `password` FROM `users` WHERE `id` = :id";
        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createUser(string $username, string $name, string $surname, string $email, string $password): void
    {
        $sql = "INSERT INTO `users` (`username`, `name`, `surname`, `email`, `password`) VALUES (:username, :name, :surname, :email, :password)";
        $this->model->execute($sql, [
            'username' => $username,
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => $password
        ]);
    }

    public function setRole(int $userId, string $role): void
    {
        $sql = "UPDATE `users` SET `role` = :role WHERE `id` = :id";
        $this->model->execute($sql, ['role' => $role, 'id' => $userId]);
    }

    public function updateUser($id, $name, $surname, $avatar, $email, $role, array $permissions)
    {
        $sql = "UPDATE `users` SET `name` = :name, `surname` = :surname, `avatar` = :avatar, `email` = :email, `role` = :role, `permissions` = :permissions WHERE `id` = :id";
        return $this->execute($sql, ['id' => $id, 'name' => $name, 'surname' => $surname, 'avatar' => $avatar, 'email' => $email, 'role' => $role, 'permissions' => json_encode($permissions)]);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM `users` WHERE `id` = :id";
        return $this->execute($sql, ['id' => $id]);
    }

    public function updatePasswordByEmail(string $email, string $hashedPassword): bool
    {
        return $this->execute(
            "UPDATE `users` SET `password` = ? WHERE `email` = ?",
            [$hashedPassword, $email]
        );
    }

    public function updateProfile($id, $name, $surname, $avatar)
    {
        $sql = "UPDATE users SET name = :name, surname = :surname, avatar = :avatar WHERE id = :id";
        return $this->execute($sql, ['id' => $id, 'name' => $name, 'surname' => $surname, 'avatar' => $avatar]);
    }


    public function getPermissions(int $userId): array
    {
        $sql = "SELECT `permissions` FROM `users` WHERE `id` = :id";
        $result = $this->query($sql, ['id' => $userId]);

        return !empty($result) ? json_decode($result[0]['permissions'], true) : [];
    }

    public function generateUsername($name, $surname)
    {
        // Транслитерация
        $baseUsername = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', "$name-$surname"), '-'));

        // Проверяем, свободен ли `username`
        $username = $baseUsername;
        $counter = 1;
        while ($this->usernameExists($username)) {
            $username = $baseUsername . '-' . $counter;
            $counter++;
        }

        return $username;
    }

    // Проверка существования `username`
    private function usernameExists($username)
    {
        $sql = "SELECT id FROM users WHERE username = :username";
        $result = $this->query($sql, ['username' => $username]);
        return !empty($result);
    }
}
