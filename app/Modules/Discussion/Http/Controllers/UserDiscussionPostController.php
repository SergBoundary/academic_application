<?php

namespace App\Modules\Discussion\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Modules\Research\Models\ResearchPost;
use App\Modules\Discussion\Models\DiscussionPost;
use App\Core\Models\User;
use App\Core\Views\View;

class UserDiscussionPostController extends Controller
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
        $header = __('user_discussion_posts') . ' : ' . $user['name'] . ' ' . $user['surname'];

        $postModel = new DiscussionPost();
        $posts = $postModel->getUserPosts($user['id']);

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
                    'category_id'      => $post['category_id'],
                    'category_name'    => $post['category_name'],
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
                'discussion_type_id'            => $post['discussion_type_id'],
                'discussion_type_name'          => $post['discussion_type_name'],
                'discussion_level_up_type_id'   => $post['discussion_level_up_type_id'],
                'discussion_level_up_type_name' => $post['discussion_level_up_type_id'] ? $post['discussion_level_up_type_name'] : 'text',
                'discussion_content' => $post['discussion_content'],
                'created_at'         => $post['created_at'],
                'updated_at'         => $post['updated_at']
            ];
        }

        $view = new View('Discussion', '', 'posts/index', compact('language', 'header', 'title', 'groupedPosts'));
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
        $header = __('user_discussion_post_view') . ' : ' . $user['name'] . ' ' . $user['surname'];

        $postModel = new DiscussionPost();
        $post = $postModel->getPostById($id);

        if (!$post) {
            http_response_code(404);
            echo "Публикация не найдена!";
            exit;
        }

        $avatarAuthorFile = !empty($post['author_avatar']) ? "/avatars/" . htmlspecialchars($post['author_avatar']) : "/img/default-avatar.jpg";
        $avatarAuthor = $avatarAuthorFile . "?v=" . time();
        $avatarOpponentFile = !empty($post['opponent_avatar']) ? "/avatars/" . htmlspecialchars($post['opponent_avatar']) : "/img/default-avatar.jpg";
        $avatarOpponent = $avatarOpponentFile . "?v=" . time();
        $viewPost = [
            // Добавляем предмет обсуждения
            'research_id'        => $post['research_id'],
            'author_title'       => $post['author_title'],
            'author_username'    => $post['author_username'],
            'author_name'        => $post['author_name'],
            'author_surname'     => $post['author_surname'],
            'author_content'     => $post['author_content'],
            'category_id'        => $post['category_id'],
            'category_name'      => $post['category_name'],
            'author_avatar'      => $avatarAuthor,
            // Добавляем само обсуждение
            'discussion_id'      => $post['discussion_id'],
            'opponent_id'        => $post['opponent_id'],
            'opponent_username'  => $post['opponent_username'],
            'opponent_name'      => $post['opponent_name'],
            'opponent_surname'   => $post['opponent_surname'],
            'opponent_avatar'    => $avatarOpponent,
            'discussion_post_id' => $post['discussion_post_id'],
            'discussion_type_id'            => $post['discussion_type_id'],
            'discussion_type_name'          => $post['discussion_type_name'],
            'discussion_level_up_type_id'   => $post['discussion_level_up_type_id'],
            'discussion_level_up_type_name' => $post['discussion_level_up_type_id'] ? $post['discussion_level_up_type_name'] : 'text',
            'discussion_content' => $post['discussion_content'],
            'created_at'         => $post['created_at'],
            'updated_at'         => $post['updated_at']
        ];

        $view = new View('Discussion', '', 'posts/view', compact('language', 'header', 'title', 'user', 'viewPost'));
        $view->render();
    }

    public function create($username, $researchid, $discussionid)
    {
        if ($_SESSION['user']['username'] !== $username) {
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

        if ($discussionid == 0) {
            $avatarAuthorFile = !empty($researchPost['avatar']) ? "/avatars/" . htmlspecialchars($researchPost['avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $viewPost = [
                // Добавляем предмет обсуждения
                'research_id'        => $researchPost['id'],
                'author_title'       => $researchPost['title'],
                'author_username'    => $researchPost['username'],
                'author_name'        => $researchPost['name'],
                'author_surname'     => $researchPost['surname'],
                'author_content'     => $researchPost['content'],
                'category_id'        => $researchPost['category_id'],
                'category_name'      => $researchPost['category_name'],
                'author_avatar'      => $avatarAuthor
            ];
        } else {
            $avatarAuthorFile = !empty($discussionPost['author_avatar']) ? "/avatars/" . htmlspecialchars($discussionPost['author_avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $avatarOpponentFile = !empty($discussionPost['opponent_avatar']) ? "/avatars/" . htmlspecialchars($discussionPost['opponent_avatar']) : "/img/default-avatar.jpg";
            $avatarOpponent = $avatarOpponentFile . "?v=" . time();
            $viewPost = [
                // Добавляем предмет обсуждения
                'research_id'        => $discussionPost['research_id'],
                'author_title'       => $discussionPost['author_title'],
                'author_username'    => $discussionPost['author_username'],
                'author_name'        => $discussionPost['author_name'],
                'author_surname'     => $discussionPost['author_surname'],
                'author_content'     => $discussionPost['author_content'],
                'category_id'        => $discussionPost['category_id'],
                'category_name'      => $discussionPost['category_name'],
                'author_avatar'      => $avatarAuthor,
                // Добавляем само обсуждение
                'discussion_id'      => $discussionPost['discussion_id'],
                'opponent_id'        => $discussionPost['opponent_id'],
                'opponent_username'  => $discussionPost['opponent_username'],
                'opponent_name'      => $discussionPost['opponent_name'],
                'opponent_surname'   => $discussionPost['opponent_surname'],
                'opponent_avatar'    => $avatarOpponent,
                'discussion_post_id' => $discussionPost['discussion_post_id'],
                'discussion_type_id'            => $discussionPost['discussion_type_id'],
                'discussion_type_name'          => $discussionPost['discussion_type_name'],
                'discussion_level_up_type_id'   => $discussionPost['discussion_level_up_type_id'],
                'discussion_level_up_type_name' => $discussionPost['discussion_level_up_type_id'] ? $discussionPost['discussion_level_up_type_name'] : 'text',
                'discussion_content' => $discussionPost['discussion_content'],
                'created_at'         => $discussionPost['created_at'],
                'updated_at'         => $discussionPost['updated_at']
            ];
        }

        $language = $this->language;
        $title = 'user_research_post_create';
        $header = __('user_research_post_create');

        $avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $view = new View('Discussion', '', 'posts/create', compact('language', 'header', 'title', 'user', 'avatar', 'discussionid', 'discussionTypes', 'viewPost'));
        $view->render();
    }

    public function store($username)
    {
        if ($_SESSION['user']['username'] !== $username) {
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
        if ($_SESSION['user']['username'] !== $username) {
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
        // debug($postUpdate, 1);

        if ($discussionid == 0) {
            $avatarAuthorFile = !empty($researchPost['avatar']) ? "/avatars/" . htmlspecialchars($researchPost['avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $viewPost = [
                // Добавляем предмет обсуждения
                'research_id'        => $researchPost['id'],
                'author_title'       => $researchPost['title'],
                'author_username'    => $researchPost['username'],
                'author_name'        => $researchPost['name'],
                'author_surname'     => $researchPost['surname'],
                'author_content'     => $researchPost['content'],
                'category_id'        => $researchPost['category_id'],
                'category_name'      => $researchPost['category_name'],
                'author_avatar'      => $avatarAuthor
            ];
        } else {
            $avatarAuthorFile = !empty($discussionPost['author_avatar']) ? "/avatars/" . htmlspecialchars($discussionPost['author_avatar']) : "/img/default-avatar.jpg";
            $avatarAuthor = $avatarAuthorFile . "?v=" . time();
            $avatarOpponentFile = !empty($discussionPost['opponent_avatar']) ? "/avatars/" . htmlspecialchars($discussionPost['opponent_avatar']) : "/img/default-avatar.jpg";
            $avatarOpponent = $avatarOpponentFile . "?v=" . time();
            $viewPost = [
                // Добавляем предмет обсуждения
                'research_id'        => $discussionPost['research_id'],
                'author_title'       => $discussionPost['author_title'],
                'author_username'    => $discussionPost['author_username'],
                'author_name'        => $discussionPost['author_name'],
                'author_surname'     => $discussionPost['author_surname'],
                'author_content'     => $discussionPost['author_content'],
                'category_id'        => $discussionPost['category_id'],
                'category_name'      => $discussionPost['category_name'],
                'author_avatar'      => $avatarAuthor,
                // Добавляем само обсуждение
                'discussion_id'      => $discussionPost['discussion_id'],
                'opponent_id'        => $discussionPost['opponent_id'],
                'opponent_username'  => $discussionPost['opponent_username'],
                'opponent_name'      => $discussionPost['opponent_name'],
                'opponent_surname'   => $discussionPost['opponent_surname'],
                'opponent_avatar'    => $avatarOpponent,
                'discussion_post_id' => $discussionPost['discussion_post_id'],
                'discussion_type_id'            => $discussionPost['discussion_type_id'],
                'discussion_type_name'          => $discussionPost['discussion_type_name'],
                'discussion_level_up_type_id'   => $discussionPost['discussion_level_up_type_id'],
                'discussion_level_up_type_name' => $discussionPost['discussion_level_up_type_id'] ? $discussionPost['discussion_level_up_type_name'] : 'text',
                'discussion_content' => $discussionPost['discussion_content'],
                'created_at'         => $discussionPost['created_at'],
                'updated_at'         => $discussionPost['updated_at']
            ];
        }

        $language = $this->language;
        $title = 'user_research_post_edit';
        $header = __('user_research_post_edit');

        $avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $view = new View('Discussion', '', 'posts/edit', compact('language', 'header', 'title', 'user', 'avatar', 'discussionid', 'discussionTypes', 'viewPost', 'postUpdate'));
        $view->render();
    }

    public function update($username, $id)
    {
        if ($_SESSION['user']['username'] !== $username) {
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

        if (!$post || $post['user_id'] != $_SESSION['user']['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $postModel->deletePost($id);

        header("Location: /{$language}/{$username}/posts");
        exit;
    }
}
