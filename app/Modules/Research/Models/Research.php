<?php

namespace App\Modules\Research\Models;

use App\Core\Models\Model;

class Research extends Model
{
    public function getAllPosts()
    {
        $sql = "SELECT 
                  `tr`.`id`, `tr`.`user_id`, `tr`.`title`, `tr`.`content`, `tr`.`category_id`, `tr`.`created_at`, `tr`.`updated_at`,
                  `tu`.`username`, `tu`.`name`, `tu`.`surname`, `tu`.`avatar`,
                  `trc`.`{$this->language}` AS `category_name`
                FROM `researches` AS `tr`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                INNER JOIN `users` AS `tu`
                  ON `tu`.`id` = `tr`.`user_id`
                WHERE `tr`.`locked` = 0
                ORDER BY `tr`.`user_id`, `tr`.`created_at` DESC";
        
        return $this->query($sql);
    }
}