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
                    'user_id'      => $post['user_id'],
                    'username'  => $post['username'],
                    'name'      => $post['name'],
                    'surname'   => $post['surname'],
                    'avatar'    => $avatarAuthor,
                    'post'      => []
                ];
            }
            // Добавляем обсуждение в группу исследования `tr`.`title`, `tr`.`content`, `tr`.`category`
            $groupedPosts[$userId]['post'][] = [
                'id'      => $post['id'],
                'title'         => $post['title'],
                'content'         => $post['content'],
                'category'         => $post['category'],
                'created_at'         => $post['created_at'],
                'updated_at'         => $post['updated_at']
            ];
        }
        // debug($groupedPosts, 1);
        
        $view = new View('Research', '', 'index', compact('language', 'header', 'title', 'groupedPosts'));
        $view->render();
    }

    // public function view($id)
    // {
    //     $postModel = new Research();
    //     $post = $postModel->getPostById($id);

    //     if (!$post) {
    //         http_response_code(404);
    //         echo "Публикация не найдена!";
    //         exit;
    //     }

    //     $userModel = new User();
    //     $user = $userModel->getById($post['id']);

    //     if (!$user) {
    //         http_response_code(404);
    //         echo "Автор публикации не найден!";
    //         exit;
    //     }

    //     $language = $this->language;
    //     $title = 'research_post_view';
    //     $header = __('research_post_view') . ' : ' . $user['name'] . ' ' . $user['surname'];
        
    //     $view = new View('Research', '', 'posts/view', compact('language', 'header', 'title', 'post'));
    //     $view->render();
    // }
}
