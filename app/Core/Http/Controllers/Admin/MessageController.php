<?php 

namespace App\Core\Http\Controllers\Admin;

use App\Core\Http\Controllers\AdminController;
use App\Core\Models\Message;
use App\Core\Views\View;
use App\Core\Middleware\MiddlewareService;

class MessageController extends AdminController
{
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'messages_from_users';
        $header = __('messages_from_users');

        $messageModel = new Message();
        $messages = $messageModel->getAllMessages();
        // debug($messages, 1);

        $view = new View('', '', 'admin/messages/index', compact('language', 'header', 'title', 'messages'));
        $view->render();
    }
}
