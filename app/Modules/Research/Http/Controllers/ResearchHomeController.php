<?php

namespace App\Modules\Research\Http\Controllers;

use App\Core\Views\View;
use App\Modules\Research\Models\Research;
use App\Core\Models\Interaction;
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
        $postList = $postModel->getAllPosts();

        $interactionModel = new Interaction();
        $statCount = $interactionModel->statPostsList('research');
        $сommentCount = $interactionModel->statCommentsList('research');
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $statAction = $interactionModel->statUserPostsList($userId, 'research');
            $сommentAction = $interactionModel->statUserCommentsList($userId, 'research');
        }
        // debug($сommentAction, 1);

        $groupedPosts = [];
        foreach ($postList as $post) {
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
                'id'              => $post['id'],
                'title'           => $post['title'],
                'content'         => $post['content'],
                'category_id'     => $post['category_id'],
                'category_name'   => $post['category_name'],
                'created_at'      => $post['created_at'],
                'updated_at'      => $post['updated_at'],
                'liked'           => $statAction[$post['id']]['liked'] ?? '0',
                'likedCount'      => $statCount[$post['id']]['liked'] ?? '0',
                'comment'         => $сommentAction[$post['id']] ?? '0',
                'commentCount'    => $сommentCount[$post['id']] ?? '0',
                'disliked'        => $statAction[$post['id']]['disliked'] ?? '0',
                'dislikedCount'   => $statCount[$post['id']]['disliked'] ?? '0',
                'bookmarked'      => $statAction[$post['id']]['bookmarked'] ?? '0',
                'bookmarkedCount' => $statCount[$post['id']]['bookmarked'] ?? '0',
                'subscribed'      => $statAction[$post['id']]['subscribed'] ?? '0',
                'subscribedCount' => $statCount[$post['id']]['subscribed'] ?? '0',
                'shared'          => $statAction[$post['id']]['shared'] ?? '0',
                'sharedCount'     => $statCount[$post['id']]['shared'] ?? '0'
            ];
        }
        // debug($groupedPosts, 1);

        $view = new View('Research', '', 'index', compact('language', 'header', 'title', 'groupedPosts'));
        $view->render();
    }
}
