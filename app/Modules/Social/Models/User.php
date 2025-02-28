<?php

namespace App\Modules\Social\Models;

use App\Core\Models\Model;

class User extends Model
{
    public function getAllUsers(): array
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }
}
