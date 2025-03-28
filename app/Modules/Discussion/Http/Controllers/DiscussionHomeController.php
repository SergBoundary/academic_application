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
            0 => 'text',
            1 => 'Opinion',
            2 => 'Question',
            3 => 'Proposal',
            4 => 'Answer',
            5 => 'Accept',
            6 => 'Rejection'
        ];

        $groupedPosts = [];
        foreach ($posts as $post) {
            $researchId = $post['research_id'];
            if (!isset($groupedPosts[$researchId])) {
                $avatarAuthorFile = !empty($post['author_avatar']) ? "/avatars/" . htmlspecialchars($post['author_avatar']) : "/img/default-avatar.jpg";
                $avatarAuthor = $avatarAuthorFile . "?v=" . time();
                $groupedPosts[$researchId] = [
                    'research_id'      => $post['research_id'],
                    'author_title'     => $post['author_title'],
                    'author_content'   => $post['author_content'],
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
                'discussion_type'               => $post['discussion_type'],
                'discussion_type_name'          => $postType[$post['discussion_type']],
                'discussion_level_up_type'      => $post['discussion_level_up_type'],
                'discussion_level_up_type_name' => $post['discussion_level_up_type'] ? $postType[$post['discussion_level_up_type']] : $postType[0],
                'discussion_content' => $post['discussion_content'],
                'created_at'         => $post['created_at'],
                'updated_at'         => $post['updated_at']
            ];
        }

        $view = new View('Discussion', '', 'index', compact('language', 'header', 'title', 'groupedPosts'));
        $view->render();
    }
}
