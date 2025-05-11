<?php

namespace App\Core\Http\Controllers\Admin;

use App\Core\Http\Controllers\Controller;
use App\Core\Middleware\MiddlewareService;
use App\Core\Models\Translation;
use App\Core\Views\View;
use App\Core\Services\RedisService;

class AdminResearchFormatController extends Controller
{
    protected $languages = ['ru', 'en', 'pl', 'uk'];

    // Список переводов
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'translation_table';
        $header = __('translation_table');

        // Проверка прав и авторизации уже выполнена через middleware
        $translationModel = new Translation();
        $translations = $translationModel->getAll();

        $navbar = 'admin';
        $breadcrumb = [
            'active' => __('translation_table'),
            'list' => [
                ['name' => 'AcApp', 'url' => ''],
                ['name' => __('admin_panel'), 'url' => 'admin']
            ],];

        $view = new View('', '', 'admin/translations/index', compact('language', 'header', 'title', 'navbar', 'breadcrumb', 'translations'));
        $view->render();
    }

    // Форма добавления нового перевода
    public function create()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'translation_create';
        $header = __('translation_create');

        $navbar = 'admin';
        $breadcrumb = [
            'active' => __('translation_create'),
            'list' => [
                ['name' => 'AcApp', 'url' => ''],
                ['name' => __('admin_panel'), 'url' => 'admin'],
                ['name' => __('translation_table'), 'url' => 'admin/translations']
            ],];

        $view = new View('', '', 'admin/translations/create', compact('language', 'header', 'title', 'navbar', 'breadcrumb'));
        $view->render();
    }

    // Обработка добавления нового перевода
    public function store()
    {
        // debug($_POST['uk']);die;
        $language = $this->language;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key = $_POST['key'] ?? '';
            // Предположим, мы обрабатываем переводы для языков ru, en, pl, ua
            $data = [
                'ru' => $_POST['ru'] ?? '',
                'en' => $_POST['en'] ?? '',
                'pl' => $_POST['pl'] ?? '',
                'uk' => $_POST['uk'] ?? ''
            ];

            $translationModel = new Translation();
            $result = $translationModel->createTranslation($key, $data);

            // После успешного добавления можно обновить кэш для каждого языка
            // Например, сбросить соответствующий Redis-хэш, если он существует

            header("Location: /{$language}/admin/translations");
            exit;
        }
    }

    // Форма редактирования перевода
    public function edit($key)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'translation_edit';
        $header = __('translation_edit');

        $translationModel = new Translation();
        $translation = $translationModel->getByKey($key);

        if (!$translation) {
            echo "Перевод не найден.";
            exit;
        }

        $navbar = 'admin';
        $breadcrumb = [
            'active' => __('translation_edit'),
            'list' => [
                ['name' => 'AcApp', 'url' => ''],
                ['name' => __('admin_panel'), 'url' => 'admin'],
                ['name' => __('translation_table'), 'url' => 'admin/translations']
            ],];

        $view = new View('', '', 'admin/translations/edit', compact('language', 'header', 'title', 'navbar', 'breadcrumb', 'translation'));
        $view->render();
    }

    // Обработка обновления перевода
    public function update()
    {
        $language = $this->language;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key = $_POST['key'] ?? '';
            $data = [
                'ru' => $_POST['ru'] ?? '',
                'en' => $_POST['en'] ?? '',
                'pl' => $_POST['pl'] ?? '',
                'uk' => $_POST['uk'] ?? ''
            ];

            $translationModel = new Translation();
            $result = $translationModel->updateTranslation($key, $data);

            // Обновление кэша Redis можно выполнить здесь:
            // Для каждого языка обновляем Redis-хэш
            foreach ($this->languages as $lang) {
                $cacheKey = "cache_{$lang}";
                // Здесь можно либо полностью сбросить кэш, либо обновить только изменённый ключ
                // Например, обновляем хэш:
                $redis = RedisService::getConnection();
                $redis->hset($cacheKey, $key, $data[$lang]);
            }

            header("Location: /{$language}/admin/translations");
            exit;
        }
    }

    // Удаление перевода
    public function delete()
    {
        $language = $this->language;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key = $_POST['key'] ?? '';
            $translationModel = new Translation();
            $result = $translationModel->deleteTranslation($key);

            // Очистка кэша для каждого языка
            foreach ($this->languages as $lang) {
                $cacheKey = "cache_{$lang}";
                $redis = RedisService::getConnection();
                $redis->hdel($cacheKey, [$key]);
            }

            header("Location: /{$language}/admin/translations");
            exit;
        }
    }
}
