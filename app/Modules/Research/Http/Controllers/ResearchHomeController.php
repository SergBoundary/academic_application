<?php

namespace App\Modules\Research\Http\Controllers;

use App\Core\Views\View;
use App\Modules\Research\Models\Research;
use App\Core\Models\User;
use App\Core\Middleware\MiddlewareService;

class ResearchHomeController extends Controller
{
    public function index()
    {
        $language = $this->language;
        $title = 'research_posts';
        $header = __('research_posts');
        
        $postModel = new Research();
        $posts = $postModel->getAllPosts();

        $groupedPosts = [];
        foreach ($posts as $post) {
            $userId = $post['user_id'];
            if (!isset($groupedPosts[$userId])) {
                $avatarAuthorFile = !empty($post['avatar']) ? "/avatars/" . htmlspecialchars($post['avatar']) : "/img/default-avatar.jpg";
                $avatarAuthor = $avatarAuthorFile . "?v=" . time();
                $groupedPosts[$userId] = [
                    'user_id'   => $post['user_id'],
                    'username'  => $post['username'],
                    'name'      => $post['name'],
                    'surname'   => $post['surname'],
                    'avatar'    => $avatarAuthor,
                    'post'      => []
                ];
            }
            // Добавляем обсуждение в группу исследования `tr`.`title`, `tr`.`content`, `tr`.`category`
            $groupedPosts[$userId]['post'][] = [
                'id'            => $post['id'],
                'title'         => $post['title'],
                'content'       => $post['content'],
                'category_id'   => $post['category_id'],
                'category_name' => $post['category_name'],
                'created_at'    => $post['created_at'],
                'updated_at'    => $post['updated_at']
            ];
        }
        
        $view = new View('Research', '', 'index', compact('language', 'header', 'title', 'groupedPosts'));
        $view->render();
    }
}
