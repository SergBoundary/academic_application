<?php

namespace App\Core\Services;

use PDO;
use PDOException;

class DatabaseService
{
    private static ?PDO $pdo = null;

    public static function init(): void
    {
        if (self::$pdo === null) {
            $config = require ROOT . '/config/database.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";

            try {
                self::$pdo = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                die("Ошибка подключения к базе данных: " . $e->getMessage());
            }
        }
    }

    public static function getConnection(): ?PDO
    {
        return self::$pdo;
    }
}
