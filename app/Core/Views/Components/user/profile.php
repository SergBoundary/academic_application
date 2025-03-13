<h2><?= $header ?></h2>

<?php
$avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
$avatarUrl = $avatarFile . "?v=" . time(); // Добавляем timestamp
?>
<img src="<?= $avatarUrl ?>" alt="Аватар" width="100">

<p><?= __('name') ?>: <strong><?= htmlspecialchars($user['name']) ?></strong></p>
<p><?= __('surname') ?>: <strong><?= htmlspecialchars($user['surname']) ?></strong></p>
<p>Email: <strong><?= htmlspecialchars($user['email']) ?></strong></p>
<p><?= __('role') ?>: <strong><?= htmlspecialchars($user['role']) ?></strong></p>

<?php if ($_SESSION['user']['id'] == $user['id']): ?>
    <a href="/<?= $language ?>/<?= $user['username'] ?>/edit-profile"><?= __('edit_profile') ?></a>
    <form action="/<?= $language ?>/<?= $user['username'] ?>/delete-account" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить аккаунт?');">
        <button type="submit" style="color: red;"><?= __('delete_account') ?></button>
    </form>
<?php endif; ?>
