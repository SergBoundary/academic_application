<?php

namespace App\Core\Http\Controllers\User;

use App\Core\Http\Controllers\Controller;
use App\Core\Views\View;
use App\Core\Models\User;
use App\Core\Models\Statistics;
use App\Core\Models\Message;
use App\Core\Middleware\MiddlewareService;
use App\Modules\Research\Models\Research;

class UserController extends Controller
{
    public function index($username)
    {
        $language = $this->language;

        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Пользователь не найден!";
            exit;
        }

        $postModel = new Research();
        $postList = $postModel->getAllPosts();

        $statModel = new Statistics();
        $statUserResearchPost = $statModel->statUserResearchPost($user['id']);
        $statUserDiscussionPost = $statModel->statUserDiscussionPost($user['id']);

        $title = 'user';
        $header = __('user') . ' : ' . $user['name'] . ' ' . $user['surname'];

        $menuFirstActive = (isset($_SESSION['user']) && $_SESSION['user']['id'] == $user['id']) ? 'my_world' : '';

        $menuFirst = [
            'active' => $menuFirstActive,
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => $user['name'] . ' ' . $user['surname'],
            'list' => [
                ['name' => __('start'), 'url' => '']
            ],
        ];
        
        $menuSecond = [
            'active' => 'my_world',
            'list' => [
                ['name' => 'my_world', 'url' => $language . '/admin/messages-group', 'disabled' => true],
                ['name' => 'research_designs', 'url' => $language . '/' . $user['username'] . '/research-designs', 'disabled' => true],
                ['name' => 'research_publications', 'url' => $language . '/' . $user['username'] . '/research-publications', 'disabled' => true],
                ['name' => 'me', 'url' => $language . '/' . $user['username'], 'disabled' => true],
            ],
        ];

        $asideMenu = [
            'active' => '',
            'list' => [
                ['name' => 'user_offers', 'url' => $language . '/' . $user['username'] . '', 'disabled' => true],
                ['name' => 'user_library', 'url' => $language . '/' . $user['username'] . '', 'disabled' => true],
                ['name' => 'user_people', 'url' => $language . '/' . $user['username'] . '', 'disabled' => true],
                ['name' => 'user_news', 'url' => $language . '/' . $user['username'] . '', 'disabled' => true],
                ['name' => 'user_statistics', 'url' => $language . '/' . $user['username'] . '', 'disabled' => true],
            ],
        ];

        $view = new View('', '', 'user/index', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'user', 'statUserResearchPost', 'statUserDiscussionPost'));
        $view->render();
    }
}
