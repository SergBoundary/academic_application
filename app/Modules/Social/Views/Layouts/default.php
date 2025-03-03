<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?  'AcApp : ' . $title : 'AcApp' ?></title>
</head>
<body>
    <header>
        <h4><a href="/">AcApp</a> / <?= htmlspecialchars($title) ?></h4>
    </header>
    <main>
        <?= $content ?? '' ?>
    </main>
    <footer>
        <p>© 2024. Все права защищены.</p>
    </footer>
</body>
</html>