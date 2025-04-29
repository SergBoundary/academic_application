<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $header ?  'AcApp : ' . $header : 'AcApp' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/index.css">

    <script>
        window.App = {
            language: "<?= $language ?>"
        };
    </script>
    <script src="/js/index.js" defer></script>
</head>

<body>
    <div class="container">
        <header>
            <nav class="navbar navbar-expand navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img src="/img/layout/baseline_public_white_24dp.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                    </a>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link <?php if ($navbar == 'research'): ?>active<?php endif; ?>" href="/<?= $language ?>/research"><?= __('research') ?></a>
                            <a class="nav-link <?php if ($navbar == 'discussion'): ?>active<?php endif; ?>" href="/<?= $language ?>/discussion"><?= __('discussion') ?></a>
                            <?php if (isUserLoggedIn()): ?>
                                <?php if (isAdminLoggedIn()): ?>
                                    <a class="nav-link <?php if ($navbar == 'admin'): ?>active<?php endif; ?>" href="/<?= $language ?>/admin"><?= __('admin_panel') ?></a>
                                <?php endif; ?>
                                <a class="nav-link" href="/<?= $language ?>/logout"><?= __('logout') ?></a>
                            <?php else: ?>
                                <a class="nav-link <?php if ($navbar == 'authorization'): ?>active<?php endif; ?>" href="/<?= $language ?>/login"><?= __('log_in') ?></a>
                            <?php endif; ?>
                        </div>
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
</body>

</html>