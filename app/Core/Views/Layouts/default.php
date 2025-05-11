<?php
// разбиваем URI на путь и query string
[$path, $qs] = array_pad(explode('?', $_SERVER['REQUEST_URI'], 2), 2, '');
// убираем первый сегмент (код языка)
$segments = explode('/', trim($path, '/'));
array_shift($segments);
$langPath = '/' . implode('/', $segments);
// добавляем обратно ?… если есть
$query = $qs ? "?{$qs}" : '';
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="UTF-8">
    <title><?= $header ?  'AcApp : ' . $header : 'AcApp' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= App\Core\Middleware\CsrfMiddleware::getToken() ?>">
    <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/index.css">

    <script>
        window.App = {
            language: "<?= $language ?>"
        };
    </script>
</head>

<body>
    <div class="container">
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img src="/img/layout/baseline_public_white_24dp.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link <?php if ($navbar == 'research'): ?>active<?php endif; ?>" href="/<?= $language ?>/research"><?= __('researches') ?></a>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($navbar == 'discussion'): ?>active<?php endif; ?>" href="/<?= $language ?>/discussion"><?= __('discussion') ?></a>
                            </li>
                        </ul>
                        <ul class="navbar-nav justify-content-end">
                            <?php if (isUserLoggedIn()): ?>
                                <li class="nav-item dropdown">
                                    <?php
                                    $navbarAvatarFile = !empty($_SESSION['user']['avatar']) ? "/uploads/avatars/" . htmlspecialchars($_SESSION['user']['avatar']) : "/img/default-avatar.jpg";
                                    $navbarAvatar = $navbarAvatarFile . "?v=" . time(); // Добавляем timestamp
                                    ?>
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img class="rounded-circle border" src="<?= $navbarAvatar ?>" alt="Аватар автора" width="30">
                                        <?= htmlspecialchars($_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname']) ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark bg-dark border" aria-labelledby="navbarUserDropdown">
                                        <?php if (isAdminLoggedIn()): ?>
                                            <li><a class="dropdown-item" href="/<?= $language ?>/admin"><?= __('admin_panel') ?></a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                        <?php endif; ?>
                                        <li><a class="dropdown-item" href="/<?= $language ?>/<?= $_SESSION['user']['username'] ?>"><?= __('my_space') ?></a></li>
                                        <li><a class="dropdown-item" href="/<?= $language ?>/<?= $_SESSION['user']['username'] ?>/profile"><?= __('my_profile') ?></a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="/<?= $language ?>/logout"><?= __('logout') ?></a></li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if ($navbar == 'authorization'): ?>active<?php endif; ?>" href="/<?= $language ?>/login"><?= __('log_in') ?></a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item dropdown ms-2">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLanguageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= ucwords($_SESSION['current_language']) ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark bg-dark border" aria-labelledby="navbarLanguageDropdown">
                                    <?php foreach ($_SESSION['languages'] as $navLang): ?>
                                        <li>
                                            <a class="dropdown-item <?= ($navLang['code'] === $_SESSION['current_language']) ? 'active' : '' ?>" href="/<?= $navLang['code'] ?><?= $langPath . $query ?>">
                                                <?= htmlspecialchars($navLang['name'], ENT_QUOTES) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <?php foreach ($breadcrumb['list'] as $item): ?>
                        <li class="breadcrumb-item"><a href="/<?= $language ?><?= $item['url'] ? '/' . $item['url'] : '' ?>"><?= $item['name'] ?></a></li>
                    <?php endforeach; ?>
                    <li class="breadcrumb-item active" aria-current="page"><?= $breadcrumb['active'] ?></li>
                </ol>
            </nav>
        </header>
        <main>
            <?= $content ?? '' ?>
        </main>
        <footer class="ms-2 mt-3">
            <p>© 2024. <?= __('all_rights_reserved') ?>.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/index.js"></script>
</body>

</html>