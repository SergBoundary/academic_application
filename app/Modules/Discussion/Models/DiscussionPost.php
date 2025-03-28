<?php

namespace App\Modules\Discussion\Models;

use App\Core\Models\Model;

class DiscussionPost extends Model
{
    public function getUserPosts($userId)
    {
        $sql = "SELECT 
                  `tr`.`id` AS `research_id`, `tr`.`title` AS `author_title`, `tr`.`content` AS `author_content`, `tr`.`user_id` AS `author_id`,
                  `ta`.`username` AS `author_username`, `ta`.`name` AS `author_name`, `ta`.`surname` AS `author_surname`, `ta`.`avatar` AS `author_avatar`,
                  `to`.`username` AS `opponent_username`, `to`.`name` AS `opponent_name`, `to`.`surname` AS `opponent_surname`, `to`.`avatar` AS `opponent_avatar`,
                  `td`.`id` AS `discussion_id`, `td`.`user_id` AS `opponent_id`, `td`.`research_post_id`, `td`.`discussion_post_id`, 
                  `td`.`type` AS `discussion_type`, `tdo`.`type` AS `discussion_level_up_type`, `td`.`content` AS `discussion_content`, `td`.`created_at`, `td`.`updated_at`
                FROM `discussion_posts` AS `td`
                INNER JOIN `research_posts` AS `tr`
                  ON `tr`.`id` = `td`.`research_post_id`
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `users` AS `to`
                  ON `to`.`id` = `td`.`user_id`
                LEFT JOIN `discussion_posts` AS `tdo`
                  ON `tdo`.`id` = `td`.`discussion_post_id`
                WHERE `td`.`user_id` = :user_id
                ORDER BY `tr`.`id`, `td`.`id` ASC";
        
        return $this->query($sql, ['user_id' => $userId]);
    }

    public function getPostById($id)
    {
        $sql = "SELECT 
                  `tr`.`id` AS `research_id`, `tr`.`title` AS `author_title`, `tr`.`content` AS `author_content`, `tr`.`user_id` AS `author_id`,
                  `ta`.`username` AS `author_username`, `ta`.`name` AS `author_name`, `ta`.`surname` AS `author_surname`, `ta`.`avatar` AS `author_avatar`,
                  `to`.`username` AS `opponent_username`, `to`.`name` AS `opponent_name`, `to`.`surname` AS `opponent_surname`, `to`.`avatar` AS `opponent_avatar`,
                  `td`.`id` AS `discussion_id`, `td`.`user_id` AS `opponent_id`, `td`.`research_post_id`, `td`.`discussion_post_id`, 
                  `td`.`type` AS `discussion_type`, `tdo`.`type` AS `discussion_level_up_type`, `td`.`content` AS `discussion_content`, `td`.`created_at`, `td`.`updated_at`
                FROM `discussion_posts` AS `td`
                INNER JOIN `research_posts` AS `tr`
                  ON `tr`.`id` = `td`.`research_post_id`
                INNER JOIN `users` AS `ta`
                  ON `ta`.`id` = `tr`.`user_id`
                INNER JOIN `users` AS `to`
                  ON `to`.`id` = `td`.`user_id`
                LEFT JOIN `discussion_posts` AS `tdo`
                  ON `tdo`.`id` = `td`.`discussion_post_id`
                WHERE `td`.`id` = :id
                ORDER BY `tr`.`id`, `td`.`id` ASC";
        
        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }
    
    public function createPost($userId, $type, $content, $researchId = null, $discussionId = null)
    {
        return $this->execute("INSERT INTO `discussion_posts` (`user_id`, `type`, `content`, `research_post_id`, `discussion_post_id`) VALUES (:user_id, :type, :content, :research_id, :discussion_id)", [
            'user_id' => $userId,
            'type' => $type,
            'content' => $content,
            'research_id' => $researchId,
            'discussion_id' => $discussionId
        ]);
    }

    public function updatePost($id, $type, $content, $researchId = null, $discussionId = null)
    {
        return $this->execute("UPDATE `discussion_posts` SET `type` = :type, `content` = :content, `research_post_id` = :research_id, `discussion_post_id` = :discussion_id WHERE id = :id", [
            'id' => $id,
            'type' => $type,
            'content' => $content,
            'research_id' => $researchId,
            'discussion_id' => $discussionId
        ]);
    }

    public function deletePost($id)
    {
        return $this->execute("DELETE FROM `discussion_posts` WHERE `id` = :id", ['id' => $id]);
    }
}
