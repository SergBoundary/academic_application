<h2><?= htmlspecialchars(__($title)) ?></h2>

<p>User content</p>

<?php if ($_SESSION['user']['id'] == $user['id']): ?>
    <a href="/<?= $language ?>/<?= $user['username']; ?>/profile"><?= __('user_profile') ?></a>
<?php endif; ?>