<h2><?= __($title) ?></h2>
<p><small>Опубликовано: <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></small></p>
<hr>

<!-- Если пост из Social, показываем ссылку на Research -->
<?php if (!empty($post['research_id'])): ?>
    <p><a href="/<?= $language ?>/<?= $post['ausername'] ?>/profile"><?= $post['aname'] ?> <?= $post['asurname'] ?></a></p>
    <p><strong><a href="/<?= $language ?>/research/<?= $post['research_id'] ?>"><?= $post['title'] ?></a></strong></p>
    <p><?= nl2br(htmlspecialchars($post['quote'])) ?></p>
<?php endif; ?>

<hr>
<p><a href="/<?= $language ?>/<?= $post['ousername'] ?>/profile"><?= $post['oname'] ?> <?= $post['osurname'] ?></a></p>
<p><?= nl2br(htmlspecialchars($post['discussion'])) ?></p>
<hr>
<!-- Кнопки редактирования и удаления (только для автора поста) -->
<?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['opponent']): ?>
    <a href="/<?= $language ?>/research/<?= $post['id'] ?>/edit" class="btn btn-warning">Редактировать</a>
    <form method="POST" action="/<?= $language ?>/research/<?= $post['id'] ?>/delete" style="display:inline;">
        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить этот пост?');">Удалить</button>
    </form>
<hr>
<?php endif; ?>

<!-- Кнопка "Назад" -->
<p><a href="/<?= $language ?>/research">← Назад</a></p>
