<?php

namespace App\Core\Models;

class Message extends Model
{
    public function saveMessage($userId, $email, $message)
    {
        $sql = "INSERT INTO `messages` (`user_id`, `email`, `message`) VALUES (:user_id, :email, :message)";
        return $this->execute($sql, ['user_id' => $userId, 'email' => $email, 'message' => $message]);
    }

    public function getAllMessages()
    {
        $sql = "SELECT * FROM `messages` ORDER BY `created_at` DESC";
        return $this->query($sql);
    }
}
