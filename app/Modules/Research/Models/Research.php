<?php

namespace App\Modules\Research\Models;

use App\Core\Models\Model;

class Research extends Model
{
    public function getAllPosts()
    {
        $sql = "SELECT 
                  `tr`.`id`, `tr`.`user_id`, `tr`.`title`, `tr`.`content`, `tr`.`category`, `tr`.`created_at`, `tr`.`updated_at`,
                  `tu`.`username`, `tu`.`name`, `tu`.`surname`, `tu`.`avatar`
                FROM `research_posts` AS `tr`
                INNER JOIN `users` AS `tu`
                  ON `tu`.`id` = `tr`.`user_id`
                ORDER BY `tr`.`user_id`, `tr`.`id` ASC";
        
        return $this->query($sql);
    }

    // public function getPostById($id)
    // {
    //     $sql = "SELECT 
    //               `tr`.`id`, `tr`.`user_id`, `tr`.`title`, `tr`.`content`, `tr`.`category`, `tr`.`created_at`, `tr`.`updated_at`,
    //               `tu`.`username`, `tu`.`name`, `tu`.`surname`
    //             FROM `research_posts` AS `tr`
    //             INNER JOIN `users` AS `tu`
    //               ON `tu`.`id` = `tr`.`user_id`
    //             WHERE `tr`.`id` = :id";
        
    //     $result = $this->query($sql, ['id' => $id]);
        
    //     return $result[0] ?? null;
    // }
}