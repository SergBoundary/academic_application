<h2><?= htmlspecialchars(__($title)) ?></h2>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?= __('user_profile') ?> <a href="/<?= $language ?>/<?= $user['username']; ?>/profile"><?= $user['name'] ?></a> (<?= $user['email'] ?>)</li>
    <?php endforeach; ?>
</ul>