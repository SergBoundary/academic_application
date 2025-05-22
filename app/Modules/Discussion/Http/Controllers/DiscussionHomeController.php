<?php

namespace App\Modules\Discussion\Http\Controllers;

use App\Core\Views\View;
use App\Modules\Discussion\Models\Discussion;
use App\Core\Models\Interaction;
use App\Core\Models\User;
use App\Core\Middleware\MiddlewareService;

class DiscussionHomeController extends Controller
{
    public function index()
    {
        $language = $this->language;
        $title = 'discussions';
        $header = __($title);

        $menuFirst = [
            'active' => 'discussions',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('discussions'),
            'list' => [
                ['name' => __('start'), 'url' => '']
            ],
        ];
        
        $menuSecond = [
            'active' => '',
            'list' => [
                ['name' => 'research_results', 'url' => $language . '/research-designs', 'disabled' => true],
                ['name' => 'research_publications', 'url' => $language . '/research-publications', 'disabled' => true],
            ],
        ];

        $asideMenu = [
            'active' => '',
            'list' => [
                ['name' => 'user_people', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_news', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_statistics', 'url' => $language . '/' . '', 'disabled' => true],
            ],
        ];

        $postModel = new Discussion();
        $posts = $postModel->getAllPosts();

        $interactionModel = new Interaction();
        $statResearchCount = $interactionModel->statPostsList('research');
        $statDiscussionCount = $interactionModel->statPostsList('discussion');
        $сommentResearchCount = $interactionModel->statCommentsList('research');
        $сommentDiscussionCount = $interactionModel->statCommentsList('discussion');
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $statResearchAction = $interactionModel->statUserPostsList($userId, 'research');
            $statDiscussionAction = $interactionModel->statUserPostsList($userId, 'discussion');
            $сommentResearchAction = $interactionModel->statUserCommentsList($userId, 'research');
            $сommentDiscussionAction = $interactionModel->statUserCommentsList($userId, 'discussion');
        }

        $groupedPosts = [];
        foreach ($posts as $post) {
            $researchId = $post['research_id'];
            if (!isset($groupedPosts[$researchId])) {
                $avatarAuthorFile = !empty($post['author_avatar']) ? "/uploads/avatars/" . htmlspecialchars($post['author_avatar']) : "/img/default-avatar.jpg";
                $avatarAuthor = $avatarAuthorFile . "?v=" . time();
                $groupedPosts[$researchId] = [
                    'research_id'              => $post['research_id'],
                    'author_title'             => $post['author_title'],
                    'author_content'           => $post['author_content'],
                    'author_username'          => $post['author_username'],
                    'author_name'              => $post['author_name'],
                    'author_surname'           => $post['author_surname'],
                    'category_id'              => $post['category_id'],
                    'category_name'            => $post['category_name'],
                    'author_avatar'            => $avatarAuthor,
                    'author_created_at'        => $post['author_created_at'],
                    'author_updated_at'        => $post['author_updated_at'],
                    'research_liked'           => $statResearchAction[$post['research_id']]['liked'] ?? '0',
                    'research_likedCount'      => $statResearchCount[$post['research_id']]['liked'] ?? '0',
                    'research_comment'         => $сommentResearchAction[$post['research_id']] ?? '0',
                    'research_commentCount'    => $сommentResearchCount[$post['research_id']] ?? '0',
                    'research_disliked'        => $statResearchAction[$post['research_id']]['disliked'] ?? '0',
                    'research_dislikedCount'   => $statResearchCount[$post['research_id']]['disliked'] ?? '0',
                    'research_bookmarked'      => $statResearchAction[$post['research_id']]['bookmarked'] ?? '0',
                    'research_bookmarkedCount' => $statResearchCount[$post['research_id']]['bookmarked'] ?? '0',
                    'research_subscribed'      => $statResearchAction[$post['research_id']]['subscribed'] ?? '0',
                    'research_subscribedCount' => $statResearchCount[$post['research_id']]['subscribed'] ?? '0',
                    'research_shared'          => $statResearchAction[$post['research_id']]['shared'] ?? '0',
                    'research_sharedCount'     => $statResearchCount[$post['research_id']]['shared'] ?? '0',
                    'discussions'              => []
                ];
            }
            // Добавляем обсуждение в группу исследования
            $avatarOpponentFile = !empty($post['opponent_avatar']) ? "/uploads/avatars/" . htmlspecialchars($post['opponent_avatar']) : "/img/default-avatar.jpg";
            $avatarOpponent = $avatarOpponentFile . "?v=" . time();
            $groupedPosts[$researchId]['discussions'][] = [
                'discussion_id'                 => $post['discussion_id'],
                'opponent_username'             => $post['opponent_username'],
                'opponent_name'                 => $post['opponent_name'],
                'opponent_surname'              => $post['opponent_surname'],
                'opponent_avatar'               => $avatarOpponent,
                'discussion_post_id'            => $post['discussion_post_id'],
                'discussion_type_id'            => $post['discussion_type_id'],
                'discussion_type_name'          => $post['discussion_type_name'],
                'discussion_level_up_type_id'   => $post['discussion_level_up_type_id'],
                'discussion_level_up_type_name' => $post['discussion_level_up_type_id'] ? $post['discussion_level_up_type_name'] : 'text',
                'discussion_content'            => $post['discussion_content'],
                'discussion_created_at'         => $post['discussion_created_at'],
                'discussion_updated_at'         => $post['discussion_updated_at'],
                'discussion_liked'              => $statDiscussionAction[$post['discussion_id']]['liked'] ?? '0',
                'discussion_likedCount'         => $statDiscussionCount[$post['discussion_id']]['liked'] ?? '0',
                'discussion_comment'            => $сommentDiscussionAction[$post['discussion_id']] ?? '0',
                'discussion_commentCount'       => $сommentDiscussionCount[$post['discussion_id']] ?? '0',
                'discussion_disliked'           => $statDiscussionAction[$post['discussion_id']]['disliked'] ?? '0',
                'discussion_dislikedCount'      => $statDiscussionCount[$post['discussion_id']]['disliked'] ?? '0',
                'discussion_bookmarked'         => $statDiscussionAction[$post['discussion_id']]['bookmarked'] ?? '0',
                'discussion_bookmarkedCount'    => $statDiscussionCount[$post['discussion_id']]['bookmarked'] ?? '0',
                'discussion_subscribed'         => $statDiscussionAction[$post['discussion_id']]['subscribed'] ?? '0',
                'discussion_subscribedCount'    => $statDiscussionCount[$post['discussion_id']]['subscribed'] ?? '0',
                'discussion_shared'             => $statDiscussionAction[$post['discussion_id']]['shared'] ?? '0',
                'discussion_sharedCount'        => $statDiscussionCount[$post['discussion_id']]['shared'] ?? '0'
            ];
        }

        $view = new View('Discussion', '', 'index', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'groupedPosts'));
        $view->render();
    }
}
