<?php

namespace App\Modules\Discussion\Models;

use App\Core\Models\Model;

class DiscussionPost extends Model
{
    public function getUserPosts($userId)
    {
        return $this->query("SELECT * FROM `discussion_posts` WHERE `user_id` = :user_id ORDER BY `created_at` DESC", ['user_id' => $userId]);
    }

    public function getPostById($id)
    {
        $result = $this->query("SELECT * FROM `discussion_posts` WHERE `id` = :id", ['id' => $id]);
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
