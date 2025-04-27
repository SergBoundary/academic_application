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
        $sql = "SELECT `m`.`id`, `m`.`user_id`, `m`.`email`, `m`.`message`, `m`.`created_at`, 
                       `u`.`username`, `u`.`name`, `u`.`surname`, `u`.`avatar`, `u`.`role`
                FROM `messages` AS `m`
                INNER JOIN `users` AS `u`
                  ON `u`.`id` = `m`.`user_id`
                ORDER BY `created_at` DESC";
        return $this->query($sql);
    }
}
