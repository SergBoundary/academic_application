<h4><?= __($title) ?></h4>

<!-- Список постов -->
<div class="card text-dark bg-light shadow-lg mb-2">
    <div class="card-header">
        <img class="rounded-circle border" src="<?= $avatar ?>" alt="Аватар автора" width="30">
        <a href="/<?= $language ?>/<?= $user['username'] ?>/profile" class="text-decoration-none">
            <strong><?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?></strong>
        </a>
        <div class="float-end">
            <!-- Кнопка "Создать пост" (только для авторизованных) -->
            <?php if (isset($_SESSION['user'])): ?>
                <a href="/<?= $language ?>/<?= strtolower($module) ?>/create" class="btn btn-secondary btn-sm">
                <i class="bi bi-plus-lg"></i>
                    Create new research
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty($posts)): ?>
        <ul class="list-group list-group-flush">
            <?php foreach ($posts as $post): ?>
                <li class="list-group-item">
                    <div class="inline-block my-3">
                        <h5>
                            <a href="/<?= $language ?>/<?= $user['username'] ?>/research/<?= $post['id'] ?>" class="text-decoration-none">
                                <?= $post['title'] ?>
                            </a>
                        </h5>
                    </div>

                    <div class="float-start mt-1">
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0">
                            <i class="bi bi-heart-fill"></i>
                            <span class="badge rounded-pill bg-secondary">0</span>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0">
                            <i class="bi bi-heartbreak-fill"></i>
                            <span class="badge rounded-pill bg-secondary">0</span>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0">
                            <i class="bi bi-chat-left-text-fill"></i>
                            <span class="badge rounded-pill bg-secondary">0</span>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0">
                            <i class="bi bi-share-fill"></i>
                            <span class="badge rounded-pill bg-secondary">0</span>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3">
                            <i class="bi bi-translate"></i>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3">
                            <i class="bi bi-bookmark-fill"></i>
                            <span class="badge rounded-pill bg-secondary">0</span>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0">
                            <i class="bi bi-bell-fill"></i>
                            <span class="badge rounded-pill bg-secondary">0</span>
                        </a>
                    </div>
                    <div class="float-end mt-1">
                        <small class="text-muted"><?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></small>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Пока здесь нет публикаций.</p>
    <?php endif; ?>
</div>