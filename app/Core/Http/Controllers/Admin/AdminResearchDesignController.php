<?php

namespace App\Core\Http\Controllers\Admin;

use App\Core\Http\Controllers\Controller;
use App\Core\Middleware\MiddlewareService;
use App\Core\Models\ResearchStructure;
use App\Core\Views\View;
use App\Core\Services\RedisService;

class AdminResearchDesignController extends Controller
{
    protected $languages = ['ru', 'en', 'pl', 'uk'];

    // Список переводов
    public function index()
    {
        MiddlewareService::run('auth'); // Checking authorization

        $language = $this->language;
        $title = 'research_implementation_standards';
        $header = __('research_implementation_standards');

        $menuFirst = [
            'active' => 'admin_panel',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => 'research_design_standards',
            'list' => [
                ['name' => __('start'), 'url' => ''],
                ['name' => __('admin_panel'), 'url' => $language . '/admin']
            ],
        ];
        
        $menuSecond = [
            'active' => '',
            'list' => [
                ['name' => 'research_design_standards', 'url' => $language . '/admin/research/standard/design', 'disabled' => true],
            ],
        ];

        $asideMenu = [
            'active' => 'research_disciplines',
            'list' => [
                ['name' => 'research_disciplines', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'research_fields', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'research_areas', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'research_types', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'research_elements', 'url' => $language . '/' . '', 'disabled' => true],
            ],
        ];

        $structureModel = new ResearchStructure();
        $types = $structureModel->getTypes();
        $elements = $structureModel->getElements();
        $disciplines = $structureModel->getDisciplines();
        $fields = $structureModel->getFields();
        $areas = $structureModel->getAreas();

        $view = new View(
            '',
            '',
            'admin/research/standard/structure/index',
            compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'types', 'elements', 'disciplines', 'fields', 'areas')
        );
        $view->render();
    }

    // Форма добавления нового перевода
    public function create($form)
    {
        MiddlewareService::run('auth'); // Checking authorization

        $formParam = [
            'discipline' => [
                'header' => 'research_discipline',
                'breadcrumb' => 'research_discipline'
            ],
            'field' => [
                'header' => 'research_field',
                'breadcrumb' => 'research_field'
            ],
            'area' => [
                'header' => 'research_area',
                'breadcrumb' => 'research_area'
            ],
            'type' => [
                'header' => 'research_type',
                'breadcrumb' => 'research_type'
            ],
            'element' => [
                'header' => 'research_element',
                'breadcrumb' => 'research_element'
            ],
        ];

        $language = $this->language;
        $title = 'create';
        $header = __($formParam[$form]['header']) . ' : ' . __($title);

        $navbar = 'admin';
        $breadcrumb = [
            'active' => __($title),
            'list' => [
                ['name' => 'AcApp', 'url' => ''],
                ['name' => __('admin_panel'), 'url' => 'admin'],
                ['name' => __($formParam[$form]['breadcrumb']), 'url' => 'admin/research/standard/structure']
            ],
        ];

        $structureModel = new ResearchStructure();
        $types = $structureModel->getTypes();
        $disciplines = $structureModel->getDisciplines();
        $fields = $structureModel->getFields();

        $view = new View(
            '',
            '',
            'admin/research/standard/structure/create',
            compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'form', 'types', 'disciplines', 'fields')
        );
        $view->render();
    }

    public function store()
    {
        // debug($_POST['uk']);die;
        $language = $this->language;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $form = $_POST['form'] ?? '';
            // discipline|field|area|type|element
            // $data = [
            //     'ru' => $_POST['ru'] ?? '',
            //     'en' => $_POST['en'] ?? '',
            //     'pl' => $_POST['pl'] ?? '',
            //     'uk' => $_POST['uk'] ?? ''
            // ];

            if ($form == 'field') {
                $data = [
                    'research_discipline_id' => $_POST['form_discipline'] ?? '',
                    'ru' => $_POST['ru'] ?? '',
                    'en' => $_POST['en'] ?? '',
                    'pl' => $_POST['pl'] ?? '',
                    'uk' => $_POST['uk'] ?? ''
                ];
            } elseif ($form == 'area') {
                $data = [
                    'research_discipline_id' => $_POST['form_discipline'] ?? '',
                    'research_field_id' => $_POST['form_field'] ?? '',
                    'ru' => $_POST['ru'] ?? '',
                    'en' => $_POST['en'] ?? '',
                    'pl' => $_POST['pl'] ?? '',
                    'uk' => $_POST['uk'] ?? ''
                ];
            } elseif ($form == 'element') {
                $data = [
                    'research_post_type_id' => $_POST['research_post_type_id'] ?? '',
                    'ru' => $_POST['ru'] ?? '',
                    'en' => $_POST['en'] ?? '',
                    'pl' => $_POST['pl'] ?? '',
                    'uk' => $_POST['uk'] ?? ''
                ];
            }

            $structureModel = new ResearchStructure();
            $result = $structureModel->createStructure($form, $data);

            // После успешного добавления можно обновить кэш для каждого языка
            // Например, сбросить соответствующий Redis-хэш, если он существует

            header("Location: /{$language}/admin/research/standard/structure");
            exit;
        }
    }

    // // Форма редактирования перевода
    // public function edit($key)
    // {
    //     MiddlewareService::run('auth'); // Checking authorization

    //     $language = $this->language;
    //     $title = 'translation_edit';
    //     $header = __('translation_edit');

    //     $translationModel = new Translation();
    //     $translation = $translationModel->getByKey($key);

    //     if (!$translation) {
    //         echo "Перевод не найден.";
    //         exit;
    //     }

    //     $navbar = 'admin';
    //     $breadcrumb = [
    //         'active' => __('translation_edit'),
    //         'list' => [
    //             ['name' => 'AcApp', 'url' => ''],
    //             ['name' => __('admin_panel'), 'url' => 'admin'],
    //             ['name' => __('translation_table'), 'url' => 'admin/translations']
    //         ],];

    //     $view = new View('', '', 'admin/translations/edit', compact('language', 'header', 'title', 'navbar', 'breadcrumb', 'translation'));
    //     $view->render();
    // }

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

    //         header("Location: /{$language}/admin/translations");
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

    //         header("Location: /{$language}/admin/translations");
    //         exit;
    //     }
    // }

    public function listFields(int $disciplineId)
    {
        header('Content-Type: application/json; charset=utf-8');

        $structureModel = new ResearchStructure();
        $fields = $structureModel->getByDiscipline($disciplineId);
        echo json_encode($fields);
        exit;
    }
}
