<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?  'AcApp : ' . $title : 'AcApp' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <header>
    <h4><a href="/<?= $language ?>/research"><?= __('research') ?></a> | <a href="/<?= $language ?>/social"><?= __('social_network') ?></a> | <a href="/<?= $language ?>/logout"><?= __('logout') ?></a></h4>
    <h4><a href="/<?= $language ?>/">AcApp</a> / <?= __($title) ?></h4>
    </header>
    <main>
        <?= $content ?? '' ?>
    </main>
    <footer>
        <p>© 2024. <?= __('all_rights_reserved') ?>.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>