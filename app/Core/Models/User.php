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

    public function getByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM `users` WHERE `email` = :email LIMIT 1";
        $result = $this->model->query($sql, ['email' => $email]);
        return $result ? $result[0] : null;
    }

    public function createUser(string $name, string $surname, string $email, string $password): void
    {
        $sql = "INSERT INTO `users` (`name`, `surname`, `email`, `password`) VALUES (:name, :surname, :email, :password)";
        $this->model->execute($sql, [
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => $password // Позже заменим на хеширование!
        ]);
    }

    public function setRole(int $userId, string $role): void
    {
        $sql = "UPDATE `users` SET `role` = :role WHERE `id` = :id";
        $this->model->execute($sql, ['role' => $role, 'id' => $userId]);
    }

    public function getAllUsers(): array
    {
        $sql = "SELECT `id`, `email`, `name`, `surname`, `role` FROM `users`";
        $result = $this->model->query($sql);
        return $result;
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function updateUser($id, $email, $role, array $permissions)
    {
        $sql = "UPDATE `users` SET `email` = :email, `role` = :role, permissions = :permissions WHERE `id` = :id";
        return $this->execute($sql, ['id' => $id, 'email' => $email, 'role' => $role, 'permissions' => json_encode($permissions)]);
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

    public function getPermissions(int $userId): array
    {
        $sql = "SELECT `permissions` FROM `users` WHERE `id` = :id";
        $result = $this->query($sql, ['id' => $userId]);

        return !empty($result) ? json_decode($result[0]['permissions'], true) : [];
    }
}
