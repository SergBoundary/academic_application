<?php 

namespace App\Core\Http\Controllers\Admin;

use App\Core\Http\Controllers\AdminController;
use App\Core\Models\Message;
use App\Core\Views\View;
use App\Core\Middleware\MiddlewareService;

class AdminMessageController extends AdminController
{
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'messages_from_users';
        $header = __('messages_from_users');

        $messageModel = new Message();
        $messages = $messageModel->getAllMessages();

        $menuFirst = [
            'active' => 'admin_panel',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('messages_from_users'),
            'list' => [
                ['name' => __('start'), 'url' => ''],
                ['name' => __('admin_panel'), 'url' => 'admin']
            ],
        ];
        
        $menuSecond = [
            'active' => 'messages',
            'list' => [
                ['name' => 'messages', 'url' => $language . '/admin/messages-group', 'disabled' => true],
                ['name' => 'users', 'url' => $language . '/admin/users-group', 'disabled' => true],
                ['name' => 'researches', 'url' => $language . '/admin/research-group', 'disabled' => true],
                ['name' => 'devops', 'url' => $language . '/admin/devops', 'disabled' => true],
            ],
        ];

        $asideMenu = [
            'active' => 'messages_from_users',
            'list' => [
                ['name' => 'messages_from_users', 'url' => $language . '/' . '', 'disabled' => false],
                ['name' => 'user_news', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_statistics', 'url' => $language . '/' . '', 'disabled' => true],
            ],
        ];

        $view = new View('', '', 'admin/messages/index', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'messages'));
        $view->render();
    }
}
