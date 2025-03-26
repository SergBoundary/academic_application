<?php

namespace App\Modules\Discussion\Http\Controllers;

use App\Core\Http\Controllers\Controller;
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
        $title = 'discussion_user_post';
        $header = __('discussion_user_post') . ' : ' . $user['name'] . ' ' . $user['surname'];
        
        $postModel = new DiscussionPost();
        $posts = $postModel->getUserPosts($user['id']);

        $view = new View('Discussion', '', 'posts/index', compact('language', 'header', 'title', 'posts'));
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
        $title = 'discussion_post_view';
        $header = __('discussion_post_view') . ' : ' . $user['name'] . ' ' . $user['surname'];
        
        $postModel = new DiscussionPost();
        $post = $postModel->getPostById($id);

        if (!$post) {
            http_response_code(404);
            echo "Публикация не найдена!";
            exit;
        }

        $titlePost = $post['title'];
        
        $view = new View('Discussion', '', 'posts/view', compact('language', 'header', 'title', 'titlePost', 'post', 'user'));
        $view->render();
    }
}
