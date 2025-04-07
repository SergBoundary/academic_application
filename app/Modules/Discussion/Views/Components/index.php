<h4><?= __($title) ?></h4>

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
                <h6><em><?= $group['category_name'] ?></em></h6>
                <h5 class="card-title">
                    <a href="/<?= $language ?>/<?= $group['author_username'] ?>/research/<?= $group['research_id'] ?>" class="text-decoration-none">
                        <?= htmlspecialchars($group['author_title'] ?? 'Без названия') ?>
                    </a>
                </h5>
                <p class="card-text"><?= htmlspecialchars($group['author_content'] ?? 'Без обсуждения') ?></p>
            </div>
            <div class="card-footer bg-transparent">
                <div class="float-start mt-1">
                    <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Agree">
                        <i class="bi bi-heart-fill"></i>
                        <span class="badge rounded-pill bg-secondary">0</span>
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Disagree">
                        <i class="bi bi-heartbreak-fill"></i>
                        <span class="badge rounded-pill bg-secondary">0</span>
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Comments">
                        <i class="bi bi-chat-left-text-fill"></i>
                        <span class="badge rounded-pill bg-secondary">0</span>
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Translate">
                        <i class="bi bi-translate"></i>
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Bookmark">
                        <i class="bi bi-bookmark-fill"></i>
                        <span class="badge rounded-pill bg-secondary">0</span>
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Subscription">
                        <i class="bi bi-bell-fill"></i>
                        <span class="badge rounded-pill bg-secondary">0</span>
                    </a>
                </div>
                <div class="float-end">
                    <!-- Кнопка "Создать пост" (только для авторизованных) -->
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="/<?= $language ?>/<?= $_SESSION['user']['username'] ?>/discussion/<?= $group['research_id'] ?>/0/create" class="btn btn-outline-secondary btn-sm" title="Create new post">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    <?php endif; ?>
                </div>
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
                            <?= $discussion['discussion_type_name'] ?>
                            <span class="text-muted">[<?= $discussion['discussion_id'] ?>]</span>
                            <?php if (!empty($discussion['discussion_post_id'])): ?>
                                to <?= $discussion['discussion_level_up_type_name'] ?> <span>[<?= $discussion['discussion_post_id'] ?>]</span>
                            <?php else: ?>
                                to <?= $discussion['discussion_level_up_type_name'] ?> "<span><?= $group['author_title'] ?></span>"
                            <?php endif; ?>
                        </h6>
                        <p class="card-text"><?= htmlspecialchars($discussion['discussion_content'] ?? 'Без обсуждения') ?></p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Agree">
                            <i class="bi bi-heart-fill"></i>
                            <span class="badge rounded-pill bg-secondary">0</span>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Disagree">
                            <i class="bi bi-heartbreak-fill"></i>
                            <span class="badge rounded-pill bg-secondary">0</span>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0" title="Comments">
                            <i class="bi bi-chat-left-text-fill"></i>
                            <span class="badge rounded-pill bg-secondary">0</span>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Translate">
                            <i class="bi bi-translate"></i>
                        </a>
                        <div class="float-end">
                            <a href="/<?= $language ?>/<?= $discussion['opponent_username'] ?>/discussion/<?= $discussion['discussion_id'] ?>" class="btn btn-outline-secondary btn-sm" title="View post">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <!-- Кнопка "Создать пост" (только для авторизованных) -->
                            <?php if (isset($_SESSION['user'])): ?>
                                <a href="/<?= $language ?>/<?= $_SESSION['user']['username'] ?>/discussion/<?= $group['research_id'] ?>/<?= $discussion['discussion_id'] ?>/create" class="btn btn-outline-secondary btn-sm" title="Create new post">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>Пока здесь нет публикаций.</p>
<?php endif; ?>