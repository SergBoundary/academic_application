<?php

namespace App\Modules\Research\Http\Controllers;

use App\Modules\Research\Http\Controllers\Controller;
use App\Modules\Research\Models\ResearchPost;
use App\Core\Services\FileStorageService;
use App\Core\Models\Interaction;
use App\Core\Models\User;
use App\Core\Models\Language;
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
        $description = '';
        $keywords = '';
        $authors = '';
        $title = 'user_research_posts';
        $header = __('user_research_posts') . ' : ' . $user['name'] . ' ' . $user['surname'];

        $menuFirst = [
            'active' => 'researches',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('researches'),
            'list' => [
                ['name' => __('start'), 'url' => ''],
                ['name' => $user['name'] . ' ' . $user['surname'], 'url' => $username]
            ],
        ];
        
        $menuSecond = [
            'active' => '',
            'list' => [
                ['name' => 'research_designs', 'url' => $language . '/research-designs', 'disabled' => true],
                ['name' => 'research_publications', 'url' => $language . '/research-publications', 'disabled' => true],
            ],
        ];

        $asideMenu = [
            'active' => '',
            'list' => [
                ['name' => 'user_offers', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_library', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_people', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_news', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_statistics', 'url' => $language . '/' . '', 'disabled' => true],
            ],
        ];
        
        $postModel = new ResearchPost();
        $postList = $postModel->getUserPosts($user['id']);

        $interactionModel = new Interaction();
        $statCount = $interactionModel->statPostsList('research');
        $сommentCount = $interactionModel->statCommentsList('research');
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $statAction = $interactionModel->statUserPostsList($userId, 'research');
            $сommentAction = $interactionModel->statUserCommentsList($userId, 'research');
        }
        
        $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $posts = [];
        foreach ($postList as $post) {
            $posts[$post['id']] = [
                'id'              => $post['id'],
                'title'           => $post['title'],
                'content'         => $post['content'],
                'category_id'     => $post['category_id'],
                'category_name'   => $post['category_name'],
                'created_at'      => $post['created_at'],
                'updated_at'      => $post['updated_at'],
                'liked'           => $statAction[$post['id']]['liked'] ?? '0',
                'likedCount'      => $statCount[$post['id']]['liked'] ?? '0',
                'comment'         => $сommentAction[$post['id']] ?? '0',
                'commentCount'    => $сommentCount[$post['id']] ?? '0',
                'disliked'        => $statAction[$post['id']]['disliked'] ?? '0',
                'dislikedCount'   => $statCount[$post['id']]['disliked'] ?? '0',
                'bookmarked'      => $statAction[$post['id']]['bookmarked'] ?? '0',
                'bookmarkedCount' => $statCount[$post['id']]['bookmarked'] ?? '0',
                'subscribed'      => $statAction[$post['id']]['subscribed'] ?? '0',
                'subscribedCount' => $statCount[$post['id']]['subscribed'] ?? '0',
                'shared'          => $statAction[$post['id']]['shared'] ?? '0',
                'sharedCount'     => $statCount[$post['id']]['shared'] ?? '0'
            ];
        }

        $view = new View('Research', '', 'posts/index', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'avatar', 'user', 'posts'));
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

        $menuFirst = [
            'active' => 'researches',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('view'),
            'list' => [
                ['name' => __('start'), 'url' => ''],
                ['name' => $user['name'] . ' ' . $user['surname'], 'url' => $username],
                ['name' => __('researches'), 'url' => $username.'/research']
            ],
        ];
        
        $menuSecond = [
            'active' => '',
            'list' => [
                ['name' => 'research_designs', 'url' => $language . '/research-designs', 'disabled' => true],
                ['name' => 'research_publications', 'url' => $language . '/research-publications', 'disabled' => true],
            ],
        ];

        $asideMenu = [
            'active' => '',
            'list' => [
                ['name' => 'user_offers', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_library', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_people', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_news', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_statistics', 'url' => $language . '/' . '', 'disabled' => true],
            ],
        ];
        
        $postModel = new ResearchPost();
        $postView = $postModel->getPostById($id);

        if (!$postView) {
            http_response_code(404);
            echo "Публикация не найдена!";
            exit;
        }

        $interactionModel = new Interaction();
        $statCount = $interactionModel->statPostsList('research');
        $сommentCount = $interactionModel->statCommentsList('research');
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $statAction = $interactionModel->statUserPostsList($userId, 'research');
            $сommentAction = $interactionModel->statUserCommentsList($userId, 'research');
        }

        $titlePost = $postView['title'];
        $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $post = [
            'user_id'         => $postView['user_id'],
            'username'        => $postView['username'],
            'name'            => $postView['name'],
            'surname'         => $postView['surname'],
            'avatar'          => $avatar,
            'id'              => $postView['id'],
            'title'           => $postView['title'],
            'content'         => $postView['content'],
            'file_path'       => FileStorageService::getUrl('posts/'.$postView['file_path']),
            'category_id'     => $postView['category_id'],
            'category_name'   => $postView['category_name'],
            'created_at'      => $postView['created_at'],
            'updated_at'      => $postView['updated_at'],
            'liked'           => $statAction[$postView['id']]['liked'] ?? '0',
            'likedCount'      => $statCount[$postView['id']]['liked'] ?? '0',
            'comment'         => $сommentAction[$postView['id']] ?? '0',
            'commentCount'    => $сommentCount[$postView['id']] ?? '0',
            'disliked'        => $statAction[$postView['id']]['disliked'] ?? '0',
            'dislikedCount'   => $statCount[$postView['id']]['disliked'] ?? '0',
            'bookmarked'      => $statAction[$postView['id']]['bookmarked'] ?? '0',
            'bookmarkedCount' => $statCount[$postView['id']]['bookmarked'] ?? '0',
            'subscribed'      => $statAction[$postView['id']]['subscribed'] ?? '0',
            'subscribedCount' => $statCount[$postView['id']]['subscribed'] ?? '0',
            'shared'          => $statAction[$postView['id']]['shared'] ?? '0',
            'sharedCount'     => $statCount[$postView['id']]['shared'] ?? '0'
        ];
        
        $view = new View('Research', '', 'posts/view', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'user', 'avatar', 'titlePost', 'post'));
        $view->render();
    }

    public function create($username)
    {
        $language = $this->language;
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            flash('', __('cannot_create_another_user_content'), 'error');
            header("Location: /{$language}/{$username}/research");
            return;
        }

        $userModel = new User();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            http_response_code(404);
            echo "Автор публикации не найден!";
            exit;
        }

        $title = 'user_research_post_create';
        $header = __('user_research_post_create');

        $menuFirst = [
            'active' => 'researches',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('creation'),
            'list' => [
                ['name' => __('start'), 'url' => ''],
                ['name' => $user['name'] . ' ' . $user['surname'], 'url' => $username],
                ['name' => __('researches'), 'url' => $username.'/research']
            ],
        ];
        
        $menuSecond = [
            'active' => '',
            'list' => [
                ['name' => 'research_designs', 'url' => $language . '/research-designs', 'disabled' => true],
                ['name' => 'research_publications', 'url' => $language . '/research-publications', 'disabled' => true],
            ],
        ];

        $asideMenu = [
            'active' => '',
            'list' => [
                ['name' => 'user_offers', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_library', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_people', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_news', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_statistics', 'url' => $language . '/' . '', 'disabled' => true],
            ],
        ];
        
        $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $postModel = new ResearchPost();
        $categories = $postModel->getCategories();
        
        $languageModel = new Language();
        $languages = $languageModel->getLanguages();
        
        $view = new View('Research', '', 'posts/create', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'user', 'avatar', 'categories', 'languages'));
        $view->render();
    }

    public function store($username)
    {
        $language = $this->language;
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            flash('', __('cannot_create_another_user_content'), 'error');
            header("Location: /{$language}/{$username}/research");
            return;
        }

        $userId = $_SESSION['user']['id'];
        $lang = $_POST['form_post_language'];
        $category = $_POST['form_post_category'];
        $title = trim($_POST['form_post_title']);
        $authors = trim($_POST['form_post_authors']);
        $keywords = trim($_POST['form_post_keywords']);
        $description = trim($_POST['form_post_description']);
        $abstract = trim($_POST['form_post_abstract']);
        $objective = trim($_POST['form_post_objective']);
        $methods = trim($_POST['form_post_methods']);
        $results = trim($_POST['form_post_results']);
        $conclusions = trim($_POST['form_post_conclusions']);

        $abstractFilePath = FileStorageService::saveString('posts', $abstract, 'abstract');
        $objectiveFilePath = FileStorageService::saveString('posts', $objective, 'objective');
        $methodsFilePath = FileStorageService::saveString('posts', $methods, 'methods');
        $resultsFilePath = FileStorageService::saveString('posts', $results, 'results');
        $conclusionsFilePath = FileStorageService::saveString('posts', $conclusions, 'conclusions');

        $postModel = new ResearchPost();
        $id = $postModel->createPost($userId, $lang, $category, $title, $authors, $keywords, $description, $abstractFilePath, $objectiveFilePath, $methodsFilePath, $resultsFilePath, $conclusionsFilePath);

        header("Location: /{$language}/{$username}/research/{$id}");
        exit;
    }

    public function edit($username, $id)
    {
        $language = $this->language;
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            flash('', __('cannot_edit_another_user_content'), 'error');
            header("Location: /{$language}/{$username}/research/{$id}");
            return;
        }

        $postModel = new ResearchPost();
        $post = $postModel->getPostById($id);

        if (!$post || !isset($_SESSION['user']) || $post['user_id'] != $_SESSION['user']['id'] || $_SESSION['user']['username'] !== $username) {
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

        $menuFirst = [
            'active' => 'researches',
            'list' => [
                ['name' => 'researches', 'url' => $language . '/research'],
                ['name' => 'discussions', 'url' => $language . '/discussion']
            ],
        ];

        $mapPath = [
            'active' => __('editing'),
            'list' => [
                ['name' => __('start'), 'url' => ''],
                ['name' => $user['name'] . ' ' . $user['surname'], 'url' => $username],
                ['name' => __('researches'), 'url' => $username.'/research']
            ],
        ];
        
        $menuSecond = [
            'active' => '',
            'list' => [
                ['name' => 'research_designs', 'url' => $language . '/research-designs', 'disabled' => true],
                ['name' => 'research_publications', 'url' => $language . '/research-publications', 'disabled' => true],
            ],
        ];

        $asideMenu = [
            'active' => '',
            'list' => [
                ['name' => 'user_offers', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_library', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_people', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_news', 'url' => $language . '/' . '', 'disabled' => true],
                ['name' => 'user_statistics', 'url' => $language . '/' . '', 'disabled' => true],
            ],
        ];
        
        $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
        $avatar = $avatarFile . "?v=" . time();

        $categories = $postModel->getCategories();
        
        $view = new View('Research', '', 'posts/edit', compact('language', 'header', 'title', 'menuFirst', 'menuSecond', 'mapPath', 'asideMenu', 'user', 'avatar', 'post', 'categories'));
        $view->render();
    }

    public function update($username, $id)
    {
        $language = $this->language;
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            flash('', __('cannot_edit_another_user_content'), 'error');
            header("Location: /{$language}/{$username}/research/{$id}");
            return;
        }
        
        $postModel = new ResearchPost();
        $post = $postModel->getPostById($id);

        if (!$post || !isset($_SESSION['user']) || $post['user_id'] != $_SESSION['user']['id'] || $_SESSION['user']['username'] !== $username) {
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
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            flash('', 'Вы не можете изменять контент от имени другого пользователя', 'error');
            header("Location: /{$language}/{$username}/research/{$id}");
            return;
        }
        
        $postModel = new ResearchPost();
        $post = $postModel->getPostById($id);

        if (!$post || !isset($_SESSION['user']) || $post['user_id'] != $_SESSION['user']['id']) {
            http_response_code(403);
            echo "Доступ запрещен!";
            exit;
        }

        $postModel->deletePost($id);

        header("Location: /{$language}/{$username}/research");
        exit;
    }
}
