<?php

namespace App\Core\Http\Controllers\Admin;

use App\Core\Http\Controllers\Controller;
use App\Core\Middleware\MiddlewareService;
use App\Core\Models\Research;
use App\Core\Models\User;
use App\Core\Views\View;
use App\Core\Services\RedisService; // для обновления кэша, если нужно

class AdminResearchController extends Controller
{
    // Список авторских исследований
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'authors_research_table';
        $header = __('authors_research_table');

        $navbar = 'admin';
        $breadcrumb = [
            'active' => __('authors_research_table'),
            'list' => [
                ['name' => 'AcApp', 'url' => ''],
                ['name' => __('admin_panel'), 'url' => 'admin']
            ],
        ];

        $postModel = new Research();
        $postList = $postModel->getAllPosts();

        $groupedPosts = [];
        foreach ($postList as $post) {
            $userId = $post['user_id'];
            if (!isset($groupedPosts[$userId])) {
                $avatarAuthorFile = !empty($post['avatar']) ? "/uploads/avatars/" . htmlspecialchars($post['avatar']) : "/img/default-avatar.jpg";
                $avatarAuthor = $avatarAuthorFile . "?v=" . time();
                $groupedPosts[$userId] = [
                    'user_id'   => $post['user_id'],
                    'username'  => $post['username'],
                    'name'      => $post['name'],
                    'surname'   => $post['surname'],
                    'avatar'    => $avatarAuthor,
                    'post'      => []
                ];
            }
            // Добавляем обсуждение в группу исследования `tr`.`title`, `tr`.`content`, `tr`.`category`
            $groupedPosts[$userId]['post'][] = [
                'id'              => $post['id'],
                'type_id'         => $post['type_id'],
                'title'           => $post['title'],
                'content'         => $post['content'],
                'category_id'     => $post['category_id'],
                'category_name'   => $post['category_name'],
                'locked'          => $post['locked'],
                'created_at'      => $post['created_at'],
                'updated_at'      => $post['updated_at'],
            ];
        }

        $view = new View('', '', 'admin/research/index', compact('language', 'header', 'title', 'navbar', 'breadcrumb', 'groupedPosts'));
        $view->render();
    }

    // Форма редактирования перевода
    public function edit($id)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;

        $postModel = new Research();
        $post = $postModel->getPostById($id);

        $userModel = new User();
        $user = $userModel->getById($post['user_id']);

        $title = 'user_research_post_edit';
        $header = __('user_research_post_edit');

        $navbar = 'research';
        $breadcrumb = [
            'active' => __('editing'),
            'list' => [
                ['name' => 'AcApp', 'url' => ''],
                ['name' => $user['name'] . ' ' . $user['surname'], 'url' => $user['username']],
                ['name' => __('research'), 'url' => 'admin/research']
            ],
        ];

        $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $categories = $postModel->getCategories();

        $view = new View('', '', 'admin/research/edit', compact('language', 'header', 'title', 'navbar', 'breadcrumb', 'user', 'avatar', 'post', 'categories'));
        $view->render();

        //     $view = new View('Research', '', 'posts/edit', compact('language', 'header', 'title', 'navbar', 'breadcrumb', 'user', 'avatar', 'post', 'categories'));

        //     $view = new View('', '', 'admin/research/edit', compact('language', 'header', 'title', 'navbar', 'breadcrumb', 'translation'));
        //     $view->render();
        // debug($post, 1);
    }

    // // Обработка обновления перевода
    // public function update()
    // {
    //     $language = $this->language;

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $key = $_POST['key'] ?? '';
    //         $data = [
    //             'ru' => $_POST['ru'] ?? '',
    //             'en' => $_POST['en'] ?? '',
    //             'pl' => $_POST['pl'] ?? '',
    //             'uk' => $_POST['uk'] ?? ''
    //         ];

    //         $translationModel = new Translation();
    //         $result = $translationModel->updateTranslation($key, $data);

    //         // Обновление кэша Redis можно выполнить здесь:
    //         // Для каждого языка обновляем Redis-хэш
    //         foreach ($this->languages as $lang) {
    //             $cacheKey = "cache_{$lang}";
    //             // Здесь можно либо полностью сбросить кэш, либо обновить только изменённый ключ
    //             // Например, обновляем хэш:
    //             $redis = RedisService::getConnection();
    //             $redis->hset($cacheKey, $key, $data[$lang]);
    //         }

    //         header("Location: /{$language}/admin/research");
    //         exit;
    //     }
    // }

    // // Удаление перевода
    // public function delete()
    // {
    //     $language = $this->language;

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $key = $_POST['key'] ?? '';
    //         $translationModel = new Translation();
    //         $result = $translationModel->deleteTranslation($key);

    //         // Очистка кэша для каждого языка
    //         foreach ($this->languages as $lang) {
    //             $cacheKey = "cache_{$lang}";
    //             $redis = RedisService::getConnection();
    //             $redis->hdel($cacheKey, [$key]);
    //         }

    //         header("Location: /{$language}/admin/research");
    //         exit;
    //     }
    // }

    public function toggleLock($id)
    {
        // убедимся, что это AJAX-запрос
        header('Content-Type: application/json; charset=utf-8');

        // проверка auth/role уже сделана middleware
        $postModel = new Research();

        // получаем текущее состояние и новый desired state из JSON
        $data = json_decode(file_get_contents('php://input'), true);
        $newLocked = isset($data['locked']) && $data['locked'] ? 1 : 0;

        // обновляем поле locked в БД
        $postModel->updateLock((int)$id, $newLocked);

        // отправляем обратно текущее состояние
        echo json_encode(['locked' => $newLocked]);
        exit;
    }
}
