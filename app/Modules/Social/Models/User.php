<?php

namespace App\Modules\Social\Models;

use App\Core\Models\Model;

class User extends Model
{
    protected $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function getAllUsers(): array
    {
        $sql = "SELECT `id`, `email`, `name`, `surname` 
                FROM `users` 
                WHERE `email` = :email";
        $result = $this->model->query($sql, ['email' => 'serge@mail.com']);
        return $result;
    }
}
