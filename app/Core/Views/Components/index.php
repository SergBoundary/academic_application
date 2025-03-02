<h2><?= $title ?></h2>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?= $user['name'] ?> (<?= $user['email'] ?>)</li>
    <?php endforeach; ?>
</ul>

<a href="/logout">Выйти</a>