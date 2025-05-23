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
                    `tr`.`id`, `tr`.`user_id`, `tr`.`title`, `tr`.`category_id`, `tr`.`content`, `tr`.`file_path`, `tr`.`created_at`, `tr`.`updated_at`,
                    `ta`.`username`, `ta`.`name`, `ta`.`surname`, `ta`.`avatar`,
                    `trc`.`{$this->language}` AS `category_name`
                FROM `researches` AS `tr` 
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                WHERE `tr`.`user_id` = :user_id AND `tr`.`locked` = 0
                ORDER BY `tr`.`created_at` DESC";
        
        return $this->query($sql, ['user_id' => $userId]);
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

    public function createPost($userId, $language, $category, $title, $authors, $keywords, $description, $abstract, $objective, $methods, $results, $conclusions)
    {
        $sql = "INSERT INTO `researches` (`user_id`, `language_id`, `category_id`, `title`, `authors`, `keywords`, `description`, `abstract`, `objective`, `methods`, `results`, `conclusions`) 
                VALUES (:user_id, :language_id, :category_id, :title, :authors, :keywords, :description, :abstract, :objective, :methods, :results, :conclusions)";

        $result = $this->execute($sql, [
            'user_id'  => $userId,
            'language_id' => $language,
            'category_id' => $category,
            'title'    => $title,
            'authors'  => $authors,
            'keywords'  => $keywords,
            'description'  => $description,
            'abstract'  => $abstract,
            'objective'  => $objective,
            'methods'  => $methods,
            'results'  => $results,
            'conclusions'  => $conclusions
        ]);

        // Если запрос выполнен успешно, возвращаем ID вставленной записи
        if ($result) {
            return $this->db->lastInsertId();
        }

        return false;
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

    public function deletePost($id)
    {
        return $this->execute("DELETE FROM `researches` WHERE `id` = :id", ['id' => $id]);
    }
}
