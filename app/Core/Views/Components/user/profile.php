<h2><?= $header ?></h2>

<?php
$avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
$avatarUrl = $avatarFile . "?v=" . time(); // Добавляем timestamp
?>
<img class="rounded border" src="<?= $avatarUrl ?>" alt="Аватар" width="100">

<p><?= __('name') ?>: <strong><?= htmlspecialchars($user['name']) ?></strong></p>
<p><?= __('surname') ?>: <strong><?= htmlspecialchars($user['surname']) ?></strong></p>
<p>Email: <strong><?= htmlspecialchars($user['email']) ?></strong></p>
<p><?= __('role') ?>: <strong><?= htmlspecialchars($user['role']) ?></strong></p>
<hr>

<?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $user['id']): ?>
    <a href="/<?= $language ?>/<?= $user['username'] ?>/edit-profile"><?= __('edit_profile') ?></a>
    <form action="/<?= $language ?>/<?= $user['username'] ?>/delete-account" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить аккаунт?');">
        <button type="submit" style="color: red;"><?= __('delete_account') ?></button>
    </form>

    <h3><?= __('contact_admin') ?></h3>
    <form action="/<?= $language ?>/<?= $user['username'] ?>/send-message" method="POST">
        <textarea name="message" placeholder="Введите ваше сообщение" required></textarea>
        <button type="submit">Отправить</button>
    </form>
    <hr>
<?php endif; ?>


<a class="nav-link" href="/<?= $language ?>/<?= $user['username'] ?>/research"><?= __('research') ?></a>
<a class="nav-link" href="/<?= $language ?>/<?= $user['username'] ?>/discussion"><?= __('discussion') ?></a>
<hr>