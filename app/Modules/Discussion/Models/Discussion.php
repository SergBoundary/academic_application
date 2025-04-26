<?php

namespace App\Modules\Discussion\Models;

use App\Core\Models\Model;

class Discussion extends Model
{
    public function getAllPosts()
    {
        $sql = "SELECT 
                  `tr`.`id` AS `research_id`, `tr`.`title` AS `author_title`, `tr`.`content` AS `author_content`, `tr`.`category_id`, `tr`.`user_id` AS `author_id`,
                  `tr`.`created_at` AS `author_created_at`, `tr`.`updated_at` AS `author_updated_at`,
                  `ta`.`username` AS `author_username`, `ta`.`name` AS `author_name`, `ta`.`surname` AS `author_surname`, `ta`.`avatar` AS `author_avatar`,
                  `to`.`username` AS `opponent_username`, `to`.`name` AS `opponent_name`, `to`.`surname` AS `opponent_surname`, `to`.`avatar` AS `opponent_avatar`,
                  `td`.`id` AS `discussion_id`, `td`.`user_id` AS `opponent_id`, `td`.`research_post_id`, `td`.`discussion_post_id`, 
                  `td`.`discussion_post_type_id` AS `discussion_type_id`, `tdt`.`{$this->language}` AS `discussion_type_name`,
                  `tdo`.`discussion_post_type_id` AS `discussion_level_up_type_id`, `tdto`.`{$this->language}` AS `discussion_level_up_type_name`,
                  `td`.`content` AS `discussion_content`, `td`.`created_at` AS `discussion_created_at`, `td`.`updated_at` AS `discussion_updated_at`,
                  `trc`.`{$this->language}` AS `category_name`
                FROM `discussion_posts` AS `td`
                INNER JOIN `research_posts` AS `tr`
                  ON `tr`.`id` = `td`.`research_post_id`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `users` AS `to`
                  ON `to`.`id` = `td`.`user_id`
                LEFT JOIN `discussion_posts` AS `tdo`
                  ON `tdo`.`id` = `td`.`discussion_post_id`
                LEFT JOIN `discussion_post_types` AS `tdt`
                  ON `tdt`.`id` = `td`.`discussion_post_type_id`
                LEFT JOIN `discussion_post_types` AS `tdto`
                  ON `tdto`.`id` = `tdo`.`discussion_post_type_id`
                ORDER BY `tr`.`id`, `td`.`id` ASC";
        
        return $this->query($sql);
    }
}
