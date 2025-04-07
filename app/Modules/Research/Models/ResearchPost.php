<?php

namespace App\Modules\Research\Models;

use App\Core\Models\Model;

class ResearchPost extends Model
{
    public function getCategories()
    {
        $sql = "SELECT 
                    `id`, `{$this->language}` AS `category`
                FROM `research_post_categories` 
                ORDER BY `{$this->language}`";
        
        return $this->query($sql);
    }

    public function getUserPosts($userId)
    {
        $sql = "SELECT 
                    `tr`.`id`, `tr`.`user_id`, `tr`.`title`, `tr`.`content`, `tr`.`category_id`, `tr`.`created_at`, `tr`.`updated_at`,
                    `ta`.`username`, `ta`.`name`, `ta`.`surname`, `ta`.`avatar`,
                    `trc`.`{$this->language}` AS `category_name`
                FROM `research_posts` AS `tr` 
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                WHERE `tr`.`user_id` = :user_id 
                ORDER BY `tr`.`created_at` DESC";
        
        return $this->query($sql, ['user_id' => $userId]);
    }

    public function getPostById($id)
    {
        $sql = "SELECT 
                    `tr`.`id`, `tr`.`user_id`, `tr`.`title`, `tr`.`content`, `tr`.`category_id`, `tr`.`created_at`, `tr`.`updated_at`,
                    `ta`.`username`, `ta`.`name`, `ta`.`surname`, `ta`.`avatar`,
                    `trc`.`{$this->language}` AS `category_name`
                FROM `research_posts` AS `tr` 
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                WHERE `tr`.`id` = :id";

        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createPost($userId, $title, $content, $category)
    {
        $sql = "INSERT INTO `research_posts` (`user_id`, `title`, `content`, `category_id`) 
                VALUES (:user_id, :title, :content, :category_id)";

        $result = $this->execute($sql, [
            'user_id'  => $userId,
            'title'    => $title,
            'content'  => $content,
            'category_id' => $category
        ]);

        // Если запрос выполнен успешно, возвращаем ID вставленной записи
        if ($result) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function updatePost($id, $title, $content, $category)
    {
        $sql = "UPDATE `research_posts` 
                SET `title` = :title, `content` = :content, `category_id` = :category_id 
                WHERE id = :id";

        return $this->execute($sql, [
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'category_id' => $category
        ]);
    }

    public function deletePost($id)
    {
        return $this->execute("DELETE FROM `research_posts` WHERE `id` = :id", ['id' => $id]);
    }
}
