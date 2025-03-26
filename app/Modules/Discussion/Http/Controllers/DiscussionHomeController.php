<?php

namespace App\Modules\Discussion\Http\Controllers;

use App\Core\Views\View;
use App\Modules\Discussion\Models\Discussion;
use App\Core\Models\User;
use App\Core\Middleware\MiddlewareService;

class DiscussionHomeController extends Controller
{
    public function index()
    {
        $language = $this->language;
        $title = 'discussion_posts';
        $header = __('discussion_posts');

        $postModel = new Discussion();
        $posts = $postModel->getAllPosts();

        $postType = [
            1 => 'Opinion',
            2 => 'Question',
            3 => 'Proposal',
            4 => 'Answer',
            5 => 'Accept',
            6 => 'Rejection'
        ];

        $postOppositionType = [
            1 => 'Opinion',
        ];

        $groupedPosts = [];
        foreach ($posts as $post) {
            $researchId = $post['research_id'];
            if (!isset($groupedPosts[$researchId])) {
                $avatarAuthorFile = !empty($post['author_avatar']) ? "/avatars/" . htmlspecialchars($post['author_avatar']) : "/img/default-avatar.jpg";
                $avatarAuthor = $avatarAuthorFile . "?v=" . time();
                $groupedPosts[$researchId] = [
                    'research_id'      => $post['research_id'],
                    'title'            => $post['title'],
                    'quote'            => $post['quote'],
                    'author_username'  => $post['author_username'],
                    'author_name'      => $post['author_name'],
                    'author_surname'   => $post['author_surname'],
                    'author_avatar'    => $avatarAuthor,
                    'discussions'      => []
                ];
            }
            // Добавляем обсуждение в группу исследования
            $avatarOpponentFile = !empty($post['opponent_avatar']) ? "/avatars/" . htmlspecialchars($post['opponent_avatar']) : "/img/default-avatar.jpg";
            $avatarOpponent = $avatarOpponentFile . "?v=" . time();
            $groupedPosts[$researchId]['discussions'][] = [
                'discussion_id'      => $post['discussion_id'],
                'opponent_username'  => $post['opponent_username'],
                'opponent_name'      => $post['opponent_name'],
                'opponent_surname'   => $post['opponent_surname'],
                'opponent_avatar'    => $avatarOpponent,
                'discussion_post_id' => $post['discussion_post_id'],
                'type'               => $post['type'],
                'type_name'          => $postType[$post['type']],
                'opponent_type'      => $post['opponent_type'],
                'opponent_type_name' => $post['opponent_type'] ? $postType[$post['opponent_type']] : '',
                'discussion'         => $post['discussion'],
                'created_at'         => $post['created_at'],
                'updated_at'         => $post['updated_at']
            ];
        }

        $view = new View('Discussion', '', 'index', compact('language', 'header', 'title', 'groupedPosts', 'postOppositionType'));
        $view->render();
    }

    // public function view($id)
    // {
    //     $postModel = new Discussion();
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
    //     $title = 'discussion_post_view';
    //     $header = __('discussion_post_view') . ' : ' . $user['name'] . ' ' . $user['surname'];

    //     $view = new View('Discussion', '', 'posts/view', compact('language', 'header', 'title', 'post'));
    //     $view->render();
    // }
}
