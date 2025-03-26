<h2><?= $user['name'] ?> <?= $user['surname'] ?></h2>
<hr>

<!-- Кнопка "Создать пост" (только для авторизованных) -->
<?php if (isset($_SESSION['user'])): ?>
    <a href="/<?= $language ?>/<?= strtolower($module) ?>/create" class="btn btn-primary">Создать пост</a>
<?php endif; ?>

<!-- Список постов -->
<?php if (!empty($posts)): ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <a href="/<?= $language ?>/<?= $user['username'] ?>/research/<?= $post['id'] ?>">
                    <?= htmlspecialchars($post['title'] ?? 'Без названия') ?>
                </a> 
                <small>(<?= date('d.m.Y H:i', strtotime($post['created_at'])) ?>)</small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Пока здесь нет публикаций.</p>
<?php endif; ?>
