<?php

namespace App\Core\Models;

use App\Core\Services\DatabaseService;
use PDO;

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = DatabaseService::getConnection();
    }
}