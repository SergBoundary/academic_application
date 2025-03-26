<?php

namespace App\Modules\Research\Models;

use App\Core\Models\Model;

class ResearchPost extends Model
{
    public function getUserPosts($userId)
    {
        return $this->query("SELECT * FROM `research_posts` WHERE `user_id` = :user_id ORDER BY `created_at` DESC", ['user_id' => $userId]);
    }

    public function getPostById($id)
    {
        $result = $this->query("SELECT * FROM `research_posts` WHERE `id` = :id", ['id' => $id]);
        return $result[0] ?? null;
    }
    
    public function createPost($userId, $title, $content)
    {
        return $this->execute("INSERT INTO `research_posts` (`user_id`, `title`, `content`) VALUES (:user_id, :title, :content)", [
            'user_id' => $userId,
            'title' => $title,
            'content' => $content
        ]);
    }

    public function updatePost($id, $title, $content)
    {
        return $this->execute("UPDATE `research_posts` SET `title` = :title, `content` = :content WHERE id = :id", [
            'id' => $id,
            'title' => $title,
            'content' => $content
        ]);
    }

    public function deletePost($id)
    {
        return $this->execute("DELETE FROM `research_posts` WHERE `id` = :id", ['id' => $id]);
    }
}
