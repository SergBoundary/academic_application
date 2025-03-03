<h2><?= htmlspecialchars($title) ?></h2>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?= $user['name'] ?> (<?= $user['email'] ?>)</li>
    <?php endforeach; ?>
</ul>