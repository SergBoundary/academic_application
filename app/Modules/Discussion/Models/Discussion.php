<?php

namespace App\Modules\Discussion\Models;

use App\Core\Models\Model;

class Discussion extends Model
{
    public function getAllPosts()
    {
        $sql = "SELECT 
                  `tr`.`id` AS `research_id`, `tr`.`title`, `tr`.`content` AS `quote`, `tr`.`user_id` AS `author`,
                  `ta`.`username` AS `author_username`, `ta`.`name` AS `author_name`, `ta`.`surname` AS `author_surname`, `ta`.`avatar` AS `author_avatar`,
                  `to`.`username` AS `opponent_username`, `to`.`name` AS `opponent_name`, `to`.`surname` AS `opponent_surname`, `to`.`avatar` AS `opponent_avatar`,
                  `td`.`id` AS `discussion_id`, `td`.`user_id` AS `opponent`, `td`.`research_post_id`, `td`.`discussion_post_id`, `td`.`type`, `tdo`.`type` AS `opponent_type`, 
                  `td`.`content` AS `discussion`, `td`.`created_at`, `td`.`updated_at`
                FROM `discussion_posts` AS `td`
                INNER JOIN `research_posts` AS `tr`
                  ON `tr`.`id` = `td`.`research_post_id`
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `users` AS `to`
                  ON `to`.`id` = `td`.`user_id`
                LEFT JOIN `discussion_posts` AS `tdo`
                  ON `tdo`.`id` = `td`.`discussion_post_id`
                ORDER BY `tr`.`id`, `td`.`id` ASC";
        
        return $this->query($sql);
    }

    // public function getPostById($id)
    // {
    //     $sql = "SELECT 
    //               `td`.`id`, `td`.`user_id` AS `opponent`, `td`.`research_id`, `td`.`content` AS `discussion`, `td`.`created_at`, `td`.`updated_at`,
    //               `tr`.`title`, `tr`.`content` AS `quote`, `tr`.`user_id` AS `author`,
    //               `ta`.`username` AS `ausername`, `ta`.`name` AS `aname`, `ta`.`surname` AS `asurname`,
    //               `to`.`username` AS `ousername`, `to`.`name` AS `oname`, `to`.`surname` AS `osurname`
    //             FROM `discussion_posts` AS `td`
    //             INNER JOIN `research_posts` AS `tr`
    //               ON `tr`.`id` = `td`.`research_id`
    //             INNER JOIN `users` AS `ta`
    //               ON `ta`.`id` = `tr`.`user_id`
    //             INNER JOIN `users` AS `to`
    //               ON `to`.`id` = `td`.`user_id`
    //             WHERE `td`.`id` = :id";
        
    //     $result = $this->query($sql, ['id' => $id]);
        
    //     return $result[0] ?? null;
    // }
}
