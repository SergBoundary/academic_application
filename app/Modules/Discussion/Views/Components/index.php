<h2><?= __($title) ?></h2>
<hr>

<!-- Список постов -->
<?php if (!empty($groupedPosts)): ?>
    <?php foreach ($groupedPosts as $group): ?>
        <div class="card text-dark bg-light shadow-lg mb-2">
            <div class="card-header">
                <img class="rounded-circle border" src="<?= $group['author_avatar'] ?>" alt="Аватар оппонента" width="30">
                <a href="/<?= $language ?>/<?= $group['author_username'] ?>/profile" class="text-decoration-none">
                    <?= htmlspecialchars($group['author_name'] . ' ' . $group['author_surname']) ?>
                </a>
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="/<?= $language ?>/<?= $group['author_username'] ?>/research/<?= $group['research_id'] ?>" class="text-decoration-none">
                        <?= htmlspecialchars($group['title'] ?? 'Без названия') ?>
                    </a>
                </h5>
                <p class="card-text"><?= htmlspecialchars($group['quote'] ?? 'Без обсуждения') ?></p>
            </div>
            <div class="card-footer bg-transparent">
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
        </div>
        <?php if (!empty($group['discussions'])): ?>
            <?php foreach ($group['discussions'] as $discussion): ?>
                <div class="card text-dark bg-light shadow-lg ms-3 mb-2">
                    <div class="card-header">
                        <img class="rounded-circle border" src="<?= $discussion['opponent_avatar'] ?>" alt="Аватар оппонента" width="30">
                        <a href="/<?= $language ?>/<?= $discussion['opponent_username'] ?>/profile" class="text-decoration-none">
                            <?= htmlspecialchars($discussion['opponent_name'] . ' ' . $discussion['opponent_surname']) ?>
                        </a>
                        <div class="float-end">
                            <small class="text-muted"><?= date('d.m.Y H:i', strtotime($discussion['created_at'])) ?></small>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title text-muted">
                            <?= $discussion['type_name'] ?>
                            <span class="text-muted">[<?= $discussion['discussion_id'] ?>]</span>
                            <?php if (!empty($discussion['discussion_post_id'])): ?>
                                to <?= $discussion['opponent_type_name'] ?> <span>[<?= $discussion['discussion_post_id'] ?>]</span>
                            <?php endif; ?>
                        </h6>
                        <p class="card-text"><?= htmlspecialchars($discussion['discussion'] ?? 'Без обсуждения') ?></p>
                    </div>
                    <div class="card-footer bg-transparent">
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
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3">
                            <i class="bi bi-translate"></i>
                        </a>
                        <div class="float-end">
                            <a href="/<?= $language ?>/<?= $discussion['opponent_username'] ?>/discussion/<?= $discussion['discussion_id'] ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>Пока здесь нет публикаций.</p>
<?php endif; ?>
<hr>