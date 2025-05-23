<?php

namespace App\Core\Models;

use App\Core\Models\Model;

class Research extends Model
{
    public function getCategories()
    {
        $sql = "SELECT 
                    `id`, `{$this->language}` AS `category`
                FROM `research_post_categories` 
                ORDER BY `{$this->language}`";
        
        return $this->query($sql);
    }

    public function getAllPosts()
    {
        $sql = "SELECT 
                  `tr`.`id`, `tr`.`user_id`, `tr`.`type_id`, `tr`.`title`, `tr`.`content`, `tr`.`category_id`, `tr`.`locked`, `tr`.`created_at`, `tr`.`updated_at`,
                  `tu`.`username`, `tu`.`name`, `tu`.`surname`, `tu`.`avatar`,
                  `trc`.`{$this->language}` AS `category_name`
                FROM `researches` AS `tr`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                INNER JOIN `users` AS `tu`
                  ON `tu`.`id` = `tr`.`user_id`
                ORDER BY `tr`.`user_id`, `tr`.`created_at` ASC";
        
        return $this->query($sql);
    }

    public function getPostById($id)
    {
        $sql = "SELECT 
                    `tr`.`id`, `tr`.`user_id`, `tr`.`title`, `tr`.`category_id`, `tr`.`content`, `tr`.`file_path`, `tr`.`created_at`, `tr`.`updated_at`,
                    `ta`.`username`, `ta`.`name`, `ta`.`surname`, `ta`.`avatar`,
                    `trc`.`{$this->language}` AS `category_name`
                FROM `researches` AS `tr` 
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                WHERE `tr`.`id` = :id AND `tr`.`locked` = 0";

        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function getAdminPostById($id)
    {
        $sql = "SELECT 
                    `tr`.`id`, `tr`.`user_id`, `tr`.`title`, `tr`.`category_id`, `tr`.`content`, `tr`.`file_path`, `tr`.`created_at`, `tr`.`updated_at`,
                    `ta`.`username`, `ta`.`name`, `ta`.`surname`, `ta`.`avatar`,
                    `trc`.`{$this->language}` AS `category_name`
                FROM `researches` AS `tr` 
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                WHERE `tr`.`id` = :id";

        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function updatePost($id, $title, $content, $category)
    {
        $sql = "UPDATE `researches` 
                SET `title` = :title, `content` = :content, `category_id` = :category_id 
                WHERE id = :id";

        return $this->execute($sql, [
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'category_id' => $category
        ]);
    }
    
    public function updateLock(int $id, int $locked): bool
    {
        return $this->execute(
            "UPDATE researches SET locked = :locked WHERE id = :id",
            ['locked' => $locked, 'id' => $id]
        );
    }
    
}