<?php

namespace App\Modules\Discussion\Models;

use App\Core\Models\Model;

class DiscussionPost extends Model
{
    public function getTypes()
    {
        $sql = "SELECT 
                    `id`, `{$this->language}` AS `type`
                FROM `discussion_types` 
                ORDER BY `id`";

        return $this->query($sql);
    }

    public function getUserPosts($userId)
    {
        $sql = "SELECT 
                  `tr`.`id` AS `research_id`, `tr`.`title` AS `author_title`, `tr`.`content` AS `author_content`, `tr`.`category_id`, `tr`.`user_id` AS `author_id`,
                  `tr`.`created_at` AS `author_created_at`, `tr`.`updated_at` AS `author_updated_at`,
                  `ta`.`username` AS `author_username`, `ta`.`name` AS `author_name`, `ta`.`surname` AS `author_surname`, `ta`.`avatar` AS `author_avatar`,
                  `to`.`username` AS `opponent_username`, `to`.`name` AS `opponent_name`, `to`.`surname` AS `opponent_surname`, `to`.`avatar` AS `opponent_avatar`,
                  `td`.`id` AS `discussion_id`, `td`.`user_id` AS `opponent_id`, `td`.`research_id` AS `research_post_id`, `td`.`discussion_id` AS `discussion_post_id`, 
                  `td`.`discussion_type_id` AS `discussion_type_id`, `tdt`.`{$this->language}` AS `discussion_type_name`,
                  `tdo`.`discussion_type_id` AS `discussion_level_up_type_id`, `tdto`.`{$this->language}` AS `discussion_level_up_type_name`,
                  `td`.`content` AS `discussion_content`, `td`.`created_at` AS `discussion_created_at`, `td`.`updated_at` AS `discussion_updated_at`,
                  `trc`.`{$this->language}` AS `category_name`
                FROM `discussions` AS `td`
                INNER JOIN `researches` AS `tr`
                  ON `tr`.`id` = `td`.`research_id`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `users` AS `to`
                  ON `to`.`id` = `td`.`user_id`
                LEFT JOIN `discussions` AS `tdo`
                  ON `tdo`.`id` = `td`.`discussion_id`
                LEFT JOIN `discussion_types` AS `tdt`
                  ON `tdt`.`id` = `td`.`discussion_type_id`
                LEFT JOIN `discussion_types` AS `tdto`
                  ON `tdto`.`id` = `tdo`.`discussion_type_id`
                WHERE `td`.`user_id` = :user_id
                ORDER BY `tr`.`id`, `td`.`id` ASC";

        return $this->query($sql, ['user_id' => $userId]);
    }

    public function getPostById($id)
    {
        $sql = "SELECT 
                  `tr`.`id` AS `research_id`, `tr`.`title` AS `author_title`, `tr`.`content` AS `author_content`, `tr`.`category_id`, `tr`.`user_id` AS `author_id`,
                  `tr`.`created_at` AS `author_created_at`, `tr`.`updated_at` AS `author_updated_at`,
                  `ta`.`username` AS `author_username`, `ta`.`name` AS `author_name`, `ta`.`surname` AS `author_surname`, `ta`.`avatar` AS `author_avatar`,
                  `to`.`username` AS `opponent_username`, `to`.`name` AS `opponent_name`, `to`.`surname` AS `opponent_surname`, `to`.`avatar` AS `opponent_avatar`,
                  `td`.`id` AS `discussion_id`, `td`.`user_id` AS `opponent_id`, `td`.`research_id` AS `research_post_id`, `td`.`discussion_id` AS `discussion_post_id`, 
                  `td`.`discussion_type_id` AS `discussion_type_id`, `tdt`.`{$this->language}` AS `discussion_type_name`,
                  `tdo`.`discussion_type_id` AS `discussion_level_up_type_id`, `tdto`.`{$this->language}` AS `discussion_level_up_type_name`,
                  `td`.`content` AS `discussion_content`, `td`.`created_at` AS `discussion_created_at`, `td`.`updated_at` AS `discussion_updated_at`,
                  `trc`.`{$this->language}` AS `category_name`
                FROM `discussions` AS `td`
                INNER JOIN `researches` AS `tr`
                  ON `tr`.`id` = `td`.`research_id`
                INNER JOIN `research_post_categories` AS `trc`
                  ON `trc`.`id` = `tr`.`category_id`
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `users` AS `to`
                  ON `to`.`id` = `td`.`user_id`
                LEFT JOIN `discussions` AS `tdo`
                  ON `tdo`.`id` = `td`.`discussion_id`
                LEFT JOIN `discussion_types` AS `tdt`
                  ON `tdt`.`id` = `td`.`discussion_type_id`
                LEFT JOIN `discussion_types` AS `tdto`
                  ON `tdto`.`id` = `tdo`.`discussion_type_id`
                WHERE `td`.`id` = :id
                ORDER BY `tr`.`id`, `td`.`id` ASC";

        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createPost($userId, $typeId, $content, $researchId, $discussionId = '0')
    {
        $sql = "INSERT INTO `discussions` (`user_id`, `research_id`, `discussion_id`, `discussion_type_id`, `content`) 
                VALUES (:user_id, :research_id, :discussion_id, :discussion_type_id, :content)";

        $result = $this->execute($sql, [
            'user_id' => $userId,
            'research_id' => $researchId,
            'discussion_id' => $discussionId,
            'discussion_type_id' => $typeId,
            'content' => $content
        ]);

        // Если запрос выполнен успешно, возвращаем ID вставленной записи
        if ($result) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function updatePost($id, $typeId, $content, $researchId, $discussionId = '0')
    {
        $sql = "UPDATE `discussions` 
                SET `content` = :content, `research__id` = :research_id, `discussion_id` = :discussion_id, `discussion_type_id` = :discussion_type_id 
                WHERE id = :id";

        return $this->execute($sql, [
            'id' => $id,
            'research_id' => $researchId,
            'discussion_id' => $discussionId,
            'discussion_type_id' => $typeId,
            'content' => $content
        ]);
    }

    public function deletePost($id)
    {
        return $this->execute("DELETE FROM `discussions` WHERE `id` = :id", ['id' => $id]);
    }
}
