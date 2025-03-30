<?php

namespace App\Core\Models;

use App\Core\Services\DatabaseService;
use PDO;
use PDOException;
use App\Core\Services\LanguageService;

class Model
{
    protected PDO $db;
    protected $language;

    public function __construct()
    {
        $this->db = DatabaseService::getConnection();
        $this->language = LanguageService::getCurrentLanguage();
    }
    
    public function execute($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute($params);
        if($res !== false) {
            return $stmt->fetchAll();
        }
        return [];
     }
}