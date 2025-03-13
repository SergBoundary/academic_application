<h2>Мир пользователя: <?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?></h2>

<p>Email: <?= htmlspecialchars($user['email']) ?></p>
<p>Роль: <?= htmlspecialchars($user['role']) ?></p>

<a href="/<?= $language ?>/<?= $user['username'] ?>/edit-profile">Редактировать профиль</a>