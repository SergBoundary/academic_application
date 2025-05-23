<?php

namespace App\Modules\Discussion\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Modules\Research\Models\ResearchPost;
use App\Modules\Discussion\Models\DiscussionPost;
use App\Core\Models\Interaction;
use App\Core\Models\User;
use App\Core\Views\View;

class UserDiscussionController extends Controller
{
    public function index($username)
    {
        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Автор публикации не найден!";
            exit;
        }

        $language = $this->language;
        $title = 'user_discussion_posts';
        $header = __($title) . ' : ' . $user['name'] . ' ' . $user['surname'];

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
                ['name' => __('start'), 'url' => ''],
                ['name' => $user['name'] . ' ' . $user['surname'], 'url' => $username]
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

        $postModel = new DiscussionPost();
        $posts = $postModel->getUserPosts($user['id']);

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

        $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $view = new View('Discussion', '', 'posts/index', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'avatar', 'user', 'groupedPosts'));
        $view->render();
    }

    public function view($username, $id)
    {
        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Автор публикации не найден!";
            exit;
        }

        $language = $this->language;
        $title = 'user_discussion_post_view';
        $header = __($title) . ' : ' . $user['name'] . ' ' . $user['surname'];

        $menuFirst = [
            'active' => 'discussions',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('view'),
            'list' => [
                ['name' => __('start'), 'url' => ''],
                ['name' => $user['name'] . ' ' . $user['surname'], 'url' => $username],
                ['name' => __('discussions'), 'url' => $username . '/discussion']
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

        $discussionModel = new DiscussionPost();
        $postView = $discussionModel->getPostById($id);

        if (!$postView) {
            http_response_code(404);
            echo "Публикация не найдена!";
            exit;
        }

        $researchPostModel = new ResearchPost();
        $researchPost = $researchPostModel->getPostById($postView['research_post_id']);

        $discussionid = $postView['discussion_post_id'];
        $discussionTypes = $discussionModel->getTypes();
        $discussionPost = $discussionModel->getPostById($discussionid);

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
        
        $postInteraction = [
            'discussion_liked'              => $statDiscussionAction[$postView['discussion_id']]['liked'] ?? '0',
            'discussion_likedCount'         => $statDiscussionCount[$postView['discussion_id']]['liked'] ?? '0',
            'discussion_comment'            => $сommentDiscussionAction[$postView['discussion_id']] ?? '0',
            'discussion_commentCount'       => $сommentDiscussionCount[$postView['discussion_id']] ?? '0',
            'discussion_disliked'           => $statDiscussionAction[$postView['discussion_id']]['disliked'] ?? '0',
            'discussion_dislikedCount'      => $statDiscussionCount[$postView['discussion_id']]['disliked'] ?? '0',
            'discussion_bookmarked'         => $statDiscussionAction[$postView['discussion_id']]['bookmarked'] ?? '0',
            'discussion_bookmarkedCount'    => $statDiscussionCount[$postView['discussion_id']]['bookmarked'] ?? '0',
            'discussion_subscribed'         => $statDiscussionAction[$postView['discussion_id']]['subscribed'] ?? '0',
            'discussion_subscribedCount'    => $statDiscussionCount[$postView['discussion_id']]['subscribed'] ?? '0',
            'discussion_shared'             => $statDiscussionAction[$postView['discussion_id']]['shared'] ?? '0',
            'discussion_sharedCount'        => $statDiscussionCount[$postView['discussion_id']]['shared'] ?? '0'
        ];

        $postView = array_merge($postView, $postInteraction);

        if ($discussionid == 0) {
            $avatarAuthorFile = !empty($researchPost['avatar']) ? "/uploads/avatars/" . htmlspecialchars($researchPost['avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $post = [
                // Добавляем предмет обсуждения
                'research_id'              => $researchPost['id'],
                'author_title'             => $researchPost['title'],
                'author_username'          => $researchPost['username'],
                'author_name'              => $researchPost['name'],
                'author_surname'           => $researchPost['surname'],
                'author_content'           => $researchPost['content'],
                'category_id'              => $researchPost['category_id'],
                'category_name'            => $researchPost['category_name'],
                'author_avatar'            => $avatarAuthor,
                'author_created_at'        => $researchPost['created_at'],
                'author_updated_at'        => $researchPost['updated_at'],
                'research_liked'           => $statResearchAction[$researchPost['id']]['liked'] ?? '0',
                'research_likedCount'      => $statResearchCount[$researchPost['id']]['liked'] ?? '0',
                'research_comment'         => $сommentResearchAction[$researchPost['id']] ?? '0',
                'research_commentCount'    => $сommentResearchCount[$researchPost['id']] ?? '0',
                'research_disliked'        => $statResearchAction[$researchPost['id']]['disliked'] ?? '0',
                'research_dislikedCount'   => $statResearchCount[$researchPost['id']]['disliked'] ?? '0',
                'research_bookmarked'      => $statResearchAction[$researchPost['id']]['bookmarked'] ?? '0',
                'research_bookmarkedCount' => $statResearchCount[$researchPost['id']]['bookmarked'] ?? '0',
                'research_subscribed'      => $statResearchAction[$researchPost['id']]['subscribed'] ?? '0',
                'research_subscribedCount' => $statResearchCount[$researchPost['id']]['subscribed'] ?? '0',
                'research_shared'          => $statResearchAction[$researchPost['id']]['shared'] ?? '0',
                'research_sharedCount'     => $statResearchCount[$researchPost['id']]['shared'] ?? '0',
                'discussion_id'            => $discussionid
            ];
        } else {
            $avatarAuthorFile = !empty($discussionPost['author_avatar']) ? "/uploads/avatars/" . htmlspecialchars($discussionPost['author_avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $avatarOpponentFile = !empty($discussionPost['opponent_avatar']) ? "/uploads/avatars/" . htmlspecialchars($discussionPost['opponent_avatar']) : "/img/default-avatar.jpg";
            $avatarOpponent = $avatarOpponentFile . "?v=" . time();
            $post = [
                // Добавляем предмет обсуждения
                'research_id'              => $discussionPost['research_id'],
                'author_title'             => $discussionPost['author_title'],
                'author_username'          => $discussionPost['author_username'],
                'author_name'              => $discussionPost['author_name'],
                'author_surname'           => $discussionPost['author_surname'],
                'author_content'           => $discussionPost['author_content'],
                'category_id'              => $discussionPost['category_id'],
                'category_name'            => $discussionPost['category_name'],
                'author_avatar'            => $avatarAuthor,
                'author_created_at'        => $discussionPost['author_created_at'],
                'author_updated_at'        => $discussionPost['author_updated_at'],
                'research_liked'           => $statResearchAction[$discussionPost['research_id']]['liked'] ?? '0',
                'research_likedCount'      => $statResearchCount[$discussionPost['research_id']]['liked'] ?? '0',
                'research_comment'         => $сommentResearchAction[$discussionPost['research_id']] ?? '0',
                'research_commentCount'    => $сommentResearchCount[$discussionPost['research_id']] ?? '0',
                'research_disliked'        => $statResearchAction[$discussionPost['research_id']]['disliked'] ?? '0',
                'research_dislikedCount'   => $statResearchCount[$discussionPost['research_id']]['disliked'] ?? '0',
                'research_bookmarked'      => $statResearchAction[$discussionPost['research_id']]['bookmarked'] ?? '0',
                'research_bookmarkedCount' => $statResearchCount[$discussionPost['research_id']]['bookmarked'] ?? '0',
                'research_subscribed'      => $statResearchAction[$discussionPost['research_id']]['subscribed'] ?? '0',
                'research_subscribedCount' => $statResearchCount[$discussionPost['research_id']]['subscribed'] ?? '0',
                'research_shared'          => $statResearchAction[$discussionPost['research_id']]['shared'] ?? '0',
                'research_sharedCount'     => $statResearchCount[$discussionPost['research_id']]['shared'] ?? '0',
                // Добавляем само обсуждение
                'discussion_id'                 => $discussionPost['discussion_id'],
                'opponent_id'                   => $discussionPost['opponent_id'],
                'opponent_username'             => $discussionPost['opponent_username'],
                'opponent_name'                 => $discussionPost['opponent_name'],
                'opponent_surname'              => $discussionPost['opponent_surname'],
                'opponent_avatar'               => $avatarOpponent,
                'discussion_post_id'            => $discussionPost['discussion_post_id'],
                'discussion_type_id'            => $discussionPost['discussion_type_id'],
                'discussion_type_name'          => $discussionPost['discussion_type_name'],
                'discussion_level_up_type_id'   => $discussionPost['discussion_level_up_type_id'],
                'discussion_level_up_type_name' => $discussionPost['discussion_level_up_type_id'] ? $discussionPost['discussion_level_up_type_name'] : 'text',
                'discussion_content'            => $discussionPost['discussion_content'],
                'discussion_created_at'         => $discussionPost['discussion_created_at'],
                'discussion_updated_at'         => $discussionPost['discussion_updated_at'],
                'discussion_liked'              => $statDiscussionAction[$discussionPost['discussion_id']]['liked'] ?? '0',
                'discussion_likedCount'         => $statDiscussionCount[$discussionPost['discussion_id']]['liked'] ?? '0',
                'discussion_comment'            => $сommentDiscussionAction[$discussionPost['discussion_id']] ?? '0',
                'discussion_commentCount'       => $сommentDiscussionCount[$discussionPost['discussion_id']] ?? '0',
                'discussion_disliked'           => $statDiscussionAction[$discussionPost['discussion_id']]['disliked'] ?? '0',
                'discussion_dislikedCount'      => $statDiscussionCount[$discussionPost['discussion_id']]['disliked'] ?? '0',
                'discussion_bookmarked'         => $statDiscussionAction[$discussionPost['discussion_id']]['bookmarked'] ?? '0',
                'discussion_bookmarkedCount'    => $statDiscussionCount[$discussionPost['discussion_id']]['bookmarked'] ?? '0',
                'discussion_subscribed'         => $statDiscussionAction[$discussionPost['discussion_id']]['subscribed'] ?? '0',
                'discussion_subscribedCount'    => $statDiscussionCount[$discussionPost['discussion_id']]['subscribed'] ?? '0',
                'discussion_shared'             => $statDiscussionAction[$discussionPost['discussion_id']]['shared'] ?? '0',
                'discussion_sharedCount'        => $statDiscussionCount[$discussionPost['discussion_id']]['shared'] ?? '0'
            ];
        }

        $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $view = new View('Discussion', '', 'posts/view', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'user', 'avatar', 'discussionid', 'discussionTypes', 'post', 'postView'));
        $view->render();
    }

    public function create($username, $researchid, $discussionid)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Автор публикации не найден!";
            exit;
        }

        $researchPostModel = new ResearchPost();
        $researchPost = $researchPostModel->getPostById($researchid);

        $discussionPostModel = new DiscussionPost();
        $discussionTypes = $discussionPostModel->getTypes();
        $discussionPost = $discussionPostModel->getPostById($discussionid);

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

        if ($discussionid == 0) {
            $avatarAuthorFile = !empty($researchPost['avatar']) ? "/uploads/avatars/" . htmlspecialchars($researchPost['avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $post = [
                // Добавляем предмет обсуждения
                'research_id'              => $researchPost['id'],
                'author_title'             => $researchPost['title'],
                'author_username'          => $researchPost['username'],
                'author_name'              => $researchPost['name'],
                'author_surname'           => $researchPost['surname'],
                'author_content'           => $researchPost['content'],
                'category_id'              => $researchPost['category_id'],
                'category_name'            => $researchPost['category_name'],
                'author_avatar'            => $avatarAuthor,
                'author_created_at'        => $researchPost['created_at'],
                'author_updated_at'        => $researchPost['updated_at'],
                'research_liked'           => $statResearchAction[$researchPost['id']]['liked'] ?? '0',
                'research_likedCount'      => $statResearchCount[$researchPost['id']]['liked'] ?? '0',
                'research_comment'         => $сommentResearchAction[$researchPost['id']] ?? '0',
                'research_commentCount'    => $сommentResearchCount[$researchPost['id']] ?? '0',
                'research_disliked'        => $statResearchAction[$researchPost['id']]['disliked'] ?? '0',
                'research_dislikedCount'   => $statResearchCount[$researchPost['id']]['disliked'] ?? '0',
                'research_bookmarked'      => $statResearchAction[$researchPost['id']]['bookmarked'] ?? '0',
                'research_bookmarkedCount' => $statResearchCount[$researchPost['id']]['bookmarked'] ?? '0',
                'research_subscribed'      => $statResearchAction[$researchPost['id']]['subscribed'] ?? '0',
                'research_subscribedCount' => $statResearchCount[$researchPost['id']]['subscribed'] ?? '0',
                'research_shared'          => $statResearchAction[$researchPost['id']]['shared'] ?? '0',
                'research_sharedCount'     => $statResearchCount[$researchPost['id']]['shared'] ?? '0',
            ];
        } else {
            $avatarAuthorFile = !empty($discussionPost['author_avatar']) ? "/uploads/avatars/" . htmlspecialchars($discussionPost['author_avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $avatarOpponentFile = !empty($discussionPost['opponent_avatar']) ? "/uploads/avatars/" . htmlspecialchars($discussionPost['opponent_avatar']) : "/img/default-avatar.jpg";
            $avatarOpponent = $avatarOpponentFile . "?v=" . time();
            $post = [
                // Добавляем предмет обсуждения
                'research_id'              => $discussionPost['research_id'],
                'author_title'             => $discussionPost['author_title'],
                'author_username'          => $discussionPost['author_username'],
                'author_name'              => $discussionPost['author_name'],
                'author_surname'           => $discussionPost['author_surname'],
                'author_content'           => $discussionPost['author_content'],
                'category_id'              => $discussionPost['category_id'],
                'category_name'            => $discussionPost['category_name'],
                'author_avatar'            => $avatarAuthor,
                'author_created_at'        => $discussionPost['author_created_at'],
                'author_updated_at'        => $discussionPost['author_updated_at'],
                'research_liked'           => $statResearchAction[$discussionPost['research_id']]['liked'] ?? '0',
                'research_likedCount'      => $statResearchCount[$discussionPost['research_id']]['liked'] ?? '0',
                'research_comment'         => $сommentResearchAction[$discussionPost['research_id']] ?? '0',
                'research_commentCount'    => $сommentResearchCount[$discussionPost['research_id']] ?? '0',
                'research_disliked'        => $statResearchAction[$discussionPost['research_id']]['disliked'] ?? '0',
                'research_dislikedCount'   => $statResearchCount[$discussionPost['research_id']]['disliked'] ?? '0',
                'research_bookmarked'      => $statResearchAction[$discussionPost['research_id']]['bookmarked'] ?? '0',
                'research_bookmarkedCount' => $statResearchCount[$discussionPost['research_id']]['bookmarked'] ?? '0',
                'research_subscribed'      => $statResearchAction[$discussionPost['research_id']]['subscribed'] ?? '0',
                'research_subscribedCount' => $statResearchCount[$discussionPost['research_id']]['subscribed'] ?? '0',
                'research_shared'          => $statResearchAction[$discussionPost['research_id']]['shared'] ?? '0',
                'research_sharedCount'     => $statResearchCount[$discussionPost['research_id']]['shared'] ?? '0',
                // Добавляем само обсуждение
                'discussion_id'                 => $discussionPost['discussion_id'],
                'opponent_id'                   => $discussionPost['opponent_id'],
                'opponent_username'             => $discussionPost['opponent_username'],
                'opponent_name'                 => $discussionPost['opponent_name'],
                'opponent_surname'              => $discussionPost['opponent_surname'],
                'opponent_avatar'               => $avatarOpponent,
                'discussion_post_id'            => $discussionPost['discussion_post_id'],
                'discussion_type_id'            => $discussionPost['discussion_type_id'],
                'discussion_type_name'          => $discussionPost['discussion_type_name'],
                'discussion_level_up_type_id'   => $discussionPost['discussion_level_up_type_id'],
                'discussion_level_up_type_name' => $discussionPost['discussion_level_up_type_id'] ? $discussionPost['discussion_level_up_type_name'] : 'text',
                'discussion_content'            => $discussionPost['discussion_content'],
                'discussion_created_at'         => $discussionPost['discussion_created_at'],
                'discussion_updated_at'         => $discussionPost['discussion_updated_at'],
                'discussion_liked'              => $statDiscussionAction[$discussionPost['discussion_id']]['liked'] ?? '0',
                'discussion_likedCount'         => $statDiscussionCount[$discussionPost['discussion_id']]['liked'] ?? '0',
                'discussion_comment'            => $сommentDiscussionAction[$discussionPost['discussion_id']] ?? '0',
                'discussion_commentCount'       => $сommentDiscussionCount[$discussionPost['discussion_id']] ?? '0',
                'discussion_disliked'           => $statDiscussionAction[$discussionPost['discussion_id']]['disliked'] ?? '0',
                'discussion_dislikedCount'      => $statDiscussionCount[$discussionPost['discussion_id']]['disliked'] ?? '0',
                'discussion_bookmarked'         => $statDiscussionAction[$discussionPost['discussion_id']]['bookmarked'] ?? '0',
                'discussion_bookmarkedCount'    => $statDiscussionCount[$discussionPost['discussion_id']]['bookmarked'] ?? '0',
                'discussion_subscribed'         => $statDiscussionAction[$discussionPost['discussion_id']]['subscribed'] ?? '0',
                'discussion_subscribedCount'    => $statDiscussionCount[$discussionPost['discussion_id']]['subscribed'] ?? '0',
                'discussion_shared'             => $statDiscussionAction[$discussionPost['discussion_id']]['shared'] ?? '0',
                'discussion_sharedCount'        => $statDiscussionCount[$discussionPost['discussion_id']]['shared'] ?? '0'
            ];
        }

        $language = $this->language;
        $title = 'user_research_post_create';
        $header = __('user_research_post_create');

        $menuFirst = [
            'active' => 'discussions',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('creation'),
            'list' => [
                ['name' => __('start'), 'url' => ''],
                ['name' => $user['name'] . ' ' . $user['surname'], 'url' => $username],
                ['name' => __('discussions'), 'url' => $username . '/discussion']
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

        $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $view = new View('Discussion', '', 'posts/create', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'user', 'avatar', 'discussionid', 'discussionTypes', 'post'));
        $view->render();
    }

    public function store($username)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $typeId = $_POST['form_post_type'];
        $content = $_POST['form_post_content'];
        $researchId = $_POST['form_post_research_id'];
        $discussionId = $_POST['form_post_discussion_id'];

        $language = $this->language;

        $postModel = new DiscussionPost();
        $id = $postModel->createPost($userId, $typeId, $content, $researchId, $discussionId);

        header("Location: /{$language}/{$username}/discussion/{$id}");
        exit;
    }

    public function edit($username, $id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Автор публикации не найден!";
            exit;
        }

        $discussionPostModel = new DiscussionPost();
        $postUpdate = $discussionPostModel->getPostById($id);

        $researchPostModel = new ResearchPost();
        $researchPost = $researchPostModel->getPostById($postUpdate['research_post_id']);

        $discussionid = $postUpdate['discussion_post_id'];
        $discussionTypes = $discussionPostModel->getTypes();
        $discussionPost = $discussionPostModel->getPostById($discussionid);

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

        if ($discussionid == 0) {
            $avatarAuthorFile = !empty($researchPost['avatar']) ? "/uploads/avatars/" . htmlspecialchars($researchPost['avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $post = [
                // Добавляем предмет обсуждения
                'research_id'              => $researchPost['id'],
                'author_title'             => $researchPost['title'],
                'author_username'          => $researchPost['username'],
                'author_name'              => $researchPost['name'],
                'author_surname'           => $researchPost['surname'],
                'author_content'           => $researchPost['content'],
                'category_id'              => $researchPost['category_id'],
                'category_name'            => $researchPost['category_name'],
                'author_avatar'            => $avatarAuthor,
                'author_created_at'        => $researchPost['created_at'],
                'author_updated_at'        => $researchPost['updated_at'],
                'research_liked'           => $statResearchAction[$researchPost['id']]['liked'] ?? '0',
                'research_likedCount'      => $statResearchCount[$researchPost['id']]['liked'] ?? '0',
                'research_comment'         => $сommentResearchAction[$researchPost['id']] ?? '0',
                'research_commentCount'    => $сommentResearchCount[$researchPost['id']] ?? '0',
                'research_disliked'        => $statResearchAction[$researchPost['id']]['disliked'] ?? '0',
                'research_dislikedCount'   => $statResearchCount[$researchPost['id']]['disliked'] ?? '0',
                'research_bookmarked'      => $statResearchAction[$researchPost['id']]['bookmarked'] ?? '0',
                'research_bookmarkedCount' => $statResearchCount[$researchPost['id']]['bookmarked'] ?? '0',
                'research_subscribed'      => $statResearchAction[$researchPost['id']]['subscribed'] ?? '0',
                'research_subscribedCount' => $statResearchCount[$researchPost['id']]['subscribed'] ?? '0',
                'research_shared'          => $statResearchAction[$researchPost['id']]['shared'] ?? '0',
                'research_sharedCount'     => $statResearchCount[$researchPost['id']]['shared'] ?? '0',
                'discussion_id'            => $discussionid
            ];
        } else {
            $avatarAuthorFile = !empty($discussionPost['author_avatar']) ? "/uploads/avatars/" . htmlspecialchars($discussionPost['author_avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $avatarOpponentFile = !empty($discussionPost['opponent_avatar']) ? "/uploads/avatars/" . htmlspecialchars($discussionPost['opponent_avatar']) : "/img/default-avatar.jpg";
            $avatarOpponent = $avatarOpponentFile . "?v=" . time();
            $post = [
                // Добавляем предмет обсуждения
                'research_id'              => $discussionPost['research_id'],
                'author_title'             => $discussionPost['author_title'],
                'author_username'          => $discussionPost['author_username'],
                'author_name'              => $discussionPost['author_name'],
                'author_surname'           => $discussionPost['author_surname'],
                'author_content'           => $discussionPost['author_content'],
                'category_id'              => $discussionPost['category_id'],
                'category_name'            => $discussionPost['category_name'],
                'author_avatar'            => $avatarAuthor,
                'author_created_at'        => $discussionPost['author_created_at'],
                'author_updated_at'        => $discussionPost['author_updated_at'],
                'research_liked'           => $statResearchAction[$discussionPost['research_id']]['liked'] ?? '0',
                'research_likedCount'      => $statResearchCount[$discussionPost['research_id']]['liked'] ?? '0',
                'research_comment'         => $сommentResearchAction[$discussionPost['research_id']] ?? '0',
                'research_commentCount'    => $сommentResearchCount[$discussionPost['research_id']] ?? '0',
                'research_disliked'        => $statResearchAction[$discussionPost['research_id']]['disliked'] ?? '0',
                'research_dislikedCount'   => $statResearchCount[$discussionPost['research_id']]['disliked'] ?? '0',
                'research_bookmarked'      => $statResearchAction[$discussionPost['research_id']]['bookmarked'] ?? '0',
                'research_bookmarkedCount' => $statResearchCount[$discussionPost['research_id']]['bookmarked'] ?? '0',
                'research_subscribed'      => $statResearchAction[$discussionPost['research_id']]['subscribed'] ?? '0',
                'research_subscribedCount' => $statResearchCount[$discussionPost['research_id']]['subscribed'] ?? '0',
                'research_shared'          => $statResearchAction[$discussionPost['research_id']]['shared'] ?? '0',
                'research_sharedCount'     => $statResearchCount[$discussionPost['research_id']]['shared'] ?? '0',
                // Добавляем само обсуждение
                'discussion_id'                 => $discussionPost['discussion_id'],
                'opponent_id'                   => $discussionPost['opponent_id'],
                'opponent_username'             => $discussionPost['opponent_username'],
                'opponent_name'                 => $discussionPost['opponent_name'],
                'opponent_surname'              => $discussionPost['opponent_surname'],
                'opponent_avatar'               => $avatarOpponent,
                'discussion_post_id'            => $discussionPost['discussion_post_id'],
                'discussion_type_id'            => $discussionPost['discussion_type_id'],
                'discussion_type_name'          => $discussionPost['discussion_type_name'],
                'discussion_level_up_type_id'   => $discussionPost['discussion_level_up_type_id'],
                'discussion_level_up_type_name' => $discussionPost['discussion_level_up_type_id'] ? $discussionPost['discussion_level_up_type_name'] : 'text',
                'discussion_content'            => $discussionPost['discussion_content'],
                'discussion_created_at'         => $discussionPost['discussion_created_at'],
                'discussion_updated_at'         => $discussionPost['discussion_updated_at'],
                'discussion_liked'              => $statDiscussionAction[$discussionPost['discussion_id']]['liked'] ?? '0',
                'discussion_likedCount'         => $statDiscussionCount[$discussionPost['discussion_id']]['liked'] ?? '0',
                'discussion_comment'            => $сommentDiscussionAction[$discussionPost['discussion_id']] ?? '0',
                'discussion_commentCount'       => $сommentDiscussionCount[$discussionPost['discussion_id']] ?? '0',
                'discussion_disliked'           => $statDiscussionAction[$discussionPost['discussion_id']]['disliked'] ?? '0',
                'discussion_dislikedCount'      => $statDiscussionCount[$discussionPost['discussion_id']]['disliked'] ?? '0',
                'discussion_bookmarked'         => $statDiscussionAction[$discussionPost['discussion_id']]['bookmarked'] ?? '0',
                'discussion_bookmarkedCount'    => $statDiscussionCount[$discussionPost['discussion_id']]['bookmarked'] ?? '0',
                'discussion_subscribed'         => $statDiscussionAction[$discussionPost['discussion_id']]['subscribed'] ?? '0',
                'discussion_subscribedCount'    => $statDiscussionCount[$discussionPost['discussion_id']]['subscribed'] ?? '0',
                'discussion_shared'             => $statDiscussionAction[$discussionPost['discussion_id']]['shared'] ?? '0',
                'discussion_sharedCount'        => $statDiscussionCount[$discussionPost['discussion_id']]['shared'] ?? '0'
            ];
        }

        $language = $this->language;
        $title = 'user_research_post_edit';
        $header = __('user_research_post_edit');

        $menuFirst = [
            'active' => 'discussions',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('editing'),
            'list' => [
                ['name' => __('start'), 'url' => ''],
                ['name' => $user['name'] . ' ' . $user['surname'], 'url' => $username],
                ['name' => __('discussions'), 'url' => $username . '/discussion']
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

        $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $view = new View('Discussion', '', 'posts/edit', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'user', 'avatar', 'discussionid', 'discussionTypes', 'post', 'postUpdate'));
        $view->render();
    }

    public function update($username, $id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $typeId = $_POST['form_post_type'];
        $content = $_POST['form_post_content'];
        $researchId = $_POST['form_post_research_id'];
        $discussionId = $_POST['form_post_discussion_id'];

        $language = $this->language;

        $postModel = new DiscussionPost();
        $postModel->updatePost($id, $typeId, $content, $researchId, $discussionId);


        header("Location: /{$language}/{$username}/discussion/{$id}");
        exit;
    }

    public function delete($username, $id)
    {
        $language = $this->language;

        $postModel = new DiscussionPost();
        $post = $postModel->getPostById($id);

        if (!$post || !isset($_SESSION['user']) || $post['user_id'] != $_SESSION['user']['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $postModel->deletePost($id);

        header("Location: /{$language}/{$username}/posts");
        exit;
    }
}
