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
        
        $avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

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
