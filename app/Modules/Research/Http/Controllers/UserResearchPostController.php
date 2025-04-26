<?php

namespace App\Modules\Research\Http\Controllers;

use App\Modules\Research\Http\Controllers\Controller;
use App\Modules\Research\Models\ResearchPost;
use App\Core\Models\Interaction;
use App\Core\Models\User;
use App\Core\Views\View;

class UserResearchPostController extends Controller
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
        $title = 'user_research_posts';
        $header = __('user_research_posts') . ' : ' . $user['name'] . ' ' . $user['surname'];
        
        $postModel = new ResearchPost();
        $postList = $postModel->getUserPosts($user['id']);

        $interactionModel = new Interaction();
        $statCount = $interactionModel->statPostsList('research');
        $сommentCount = $interactionModel->statCommentsList('research');
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $statAction = $interactionModel->statUserPostsList($userId, 'research');
            $сommentAction = $interactionModel->statUserCommentsList($userId, 'research');
        }
        
        $avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        foreach ($postList as $post) {
            $posts[$post['id']] = [
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

        $view = new View('Research', '', 'posts/index', compact('language', 'header', 'title', 'avatar', 'user', 'posts'));
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
        $title = 'user_research_post_view';
        $header = __('user_research_post_view') . ' : ' . $user['name'] . ' ' . $user['surname'];
        
        $postModel = new ResearchPost();
        $postView = $postModel->getPostById($id);

        if (!$postView) {
            http_response_code(404);
            echo "Публикация не найдена!";
            exit;
        }

        $interactionModel = new Interaction();
        $statCount = $interactionModel->statPostsList('research');
        $сommentCount = $interactionModel->statCommentsList('research');
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $statAction = $interactionModel->statUserPostsList($userId, 'research');
            $сommentAction = $interactionModel->statUserCommentsList($userId, 'research');
        }

        $titlePost = $postView['title'];
        $avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $post = [
            'user_id'         => $postView['user_id'],
            'username'        => $postView['username'],
            'name'            => $postView['name'],
            'surname'         => $postView['surname'],
            'avatar'          => $avatar,
            'id'              => $postView['id'],
            'title'           => $postView['title'],
            'content'         => $postView['content'],
            'category_id'     => $postView['category_id'],
            'category_name'   => $postView['category_name'],
            'created_at'      => $postView['created_at'],
            'updated_at'      => $postView['updated_at'],
            'liked'           => $statAction[$postView['id']]['liked'] ?? '0',
            'likedCount'      => $statCount[$postView['id']]['liked'] ?? '0',
            'comment'         => $сommentAction[$postView['id']] ?? '0',
            'commentCount'    => $сommentCount[$postView['id']] ?? '0',
            'disliked'        => $statAction[$postView['id']]['disliked'] ?? '0',
            'dislikedCount'   => $statCount[$postView['id']]['disliked'] ?? '0',
            'bookmarked'      => $statAction[$postView['id']]['bookmarked'] ?? '0',
            'bookmarkedCount' => $statCount[$postView['id']]['bookmarked'] ?? '0',
            'subscribed'      => $statAction[$postView['id']]['subscribed'] ?? '0',
            'subscribedCount' => $statCount[$postView['id']]['subscribed'] ?? '0',
            'shared'          => $statAction[$postView['id']]['shared'] ?? '0',
            'sharedCount'     => $statCount[$postView['id']]['shared'] ?? '0'
        ];
        // debug($post, 1);
        
        $view = new View('Research', '', 'posts/view', compact('language', 'header', 'title', 'user', 'avatar', 'titlePost', 'post'));
        $view->render();
    }

    public function create($username)
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

        $language = $this->language;
        $title = 'user_research_post_create';
        $header = __('user_research_post_create');
        
        $avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $postModel = new ResearchPost();
        $categories = $postModel->getCategories();
        
        $view = new View('Research', '', 'posts/create', compact('language', 'header', 'title', 'user', 'avatar', 'categories'));
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
        $title = $_POST['form_post_title'];
        $category = $_POST['form_post_category'];
        $content = $_POST['form_post_content'];
        
        $language = $this->language;

        $postModel = new ResearchPost();
        $id = $postModel->createPost($userId, $title, $content, $category);

        header("Location: /{$language}/{$username}/research/{$id}");
        exit;
    }

    public function edit($username, $id)
    {
        $language = $this->language;

        $postModel = new ResearchPost();
        $post = $postModel->getPostById($id);

        if (!$post || $post['user_id'] != $_SESSION['user']['id'] || $_SESSION['user']['username'] !== $username) {
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
        
        $title = 'user_research_post_edit';
        $header = __('user_research_post_edit');
        
        $avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $categories = $postModel->getCategories();
        
        $view = new View('Research', '', 'posts/edit', compact('language', 'header', 'title', 'user', 'avatar', 'post', 'categories'));
        $view->render();
    }

    public function update($username, $id)
    {
        $language = $this->language;
        
        $postModel = new ResearchPost();
        $post = $postModel->getPostById($id);

        if (!$post || $post['user_id'] != $_SESSION['user']['id'] || $_SESSION['user']['username'] !== $username) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $title = $_POST['form_post_title'];
        $category = $_POST['form_post_category'];
        $content = $_POST['form_post_content'];

        $postModel->updatePost($id, $title, $content, $category);

        header("Location: /{$language}/{$username}/research/{$id}");
        exit;
    }

    public function delete($username, $id)
    {
        $language = $this->language;
        
        $postModel = new ResearchPost();
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
