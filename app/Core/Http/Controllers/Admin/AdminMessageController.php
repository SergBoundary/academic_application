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

        $navbar = 'admin';
        $breadcrumb = [
            'active' => __('messages_from_users'),
            'list' => [
                ['name' => 'AcApp', 'url' => ''],
                ['name' => __('admin_panel'), 'url' => 'admin']
            ],];

        $view = new View('', '', 'admin/messages/index', compact('language', 'header', 'title', 'navbar', 'breadcrumb', 'messages'));
        $view->render();
    }
}
