<?php

namespace App\Modules\Research\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Modules\Research\Models\ResearchPost;
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
        $posts = $postModel->getUserPosts($user['id']);
        // debug($posts, 1);

        $view = new View('Research', '', 'posts/index', compact('language', 'header', 'title', 'user', 'posts'));
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
        $post = $postModel->getPostById($id);

        if (!$post) {
            http_response_code(404);
            echo "Публикация не найдена!";
            exit;
        }

        $titlePost = $post['title'];
        $avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();
        
        $view = new View('Research', '', 'posts/view', compact('language', 'header', 'title', 'user', 'avatar', 'titlePost', 'post'));
        $view->render();
    }

    public function create($username)
    {
        $language = $this->language;
        $title = 'user_research_post_create';
        $header = __('user_research_post_create');
        
        if ($_SESSION['user']['username'] !== $username) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $title = "Создать пост";
        $view = new View('user', '', 'posts/edit', compact('language', 'header', 'title', 'username'));
        $view->render();
    }

    public function store($language, $username)
    {
        if ($_SESSION['user']['username'] !== $username) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $postModel = new ResearchPost();
        $postModel->createPost($_SESSION['user']['id'], $_POST['title'], $_POST['content']);

        header("Location: /$language/$username/posts");
        exit;
    }

    public function edit($username, $id)
    {
        $postModel = new ResearchPost();
        $post = $postModel->getPostById($id);

        if (!$post || $post['user_id'] != $_SESSION['user']['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $title = "Редактировать пост";
        $view = new View('user', '', 'posts/edit', compact('title', 'username', 'post'));
        $view->render();
    }

    public function update($language, $username, $id)
    {
        $postModel = new ResearchPost();
        $post = $postModel->getPostById($id);

        if (!$post || $post['user_id'] != $_SESSION['user']['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $postModel->updatePost($id, $_POST['title'], $_POST['content']);

        header("Location: /$language/$username/posts");
        exit;
    }

    public function delete($language, $username, $id)
    {
        $postModel = new ResearchPost();
        $post = $postModel->getPostById($id);

        if (!$post || $post['user_id'] != $_SESSION['user']['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $postModel->deletePost($id);

        header("Location: /$language/$username/posts");
        exit;
    }
}
