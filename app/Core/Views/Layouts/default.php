<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Приложение AcApp' ?></title>
</head>
<body>
    <header>
        <h1>'Приложение AcApp'</h1>
    </header>
    <main>
        <?= $content ?? '' ?>
    </main>
    <footer>
        <p>© 2024. Все права защищены.</p>
    </footer>
</body>
</html>