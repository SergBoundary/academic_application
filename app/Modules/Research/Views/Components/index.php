<h4><?= __($title) ?></h4>

<!-- Список постов -->
<?php if (!empty($groupedPosts)): ?>
    <?php foreach ($groupedPosts as $group): ?>
        <div class="card text-dark bg-light shadow-lg mb-2">
            <div class="card-header">
                <img class="rounded-circle border" src="<?= $group['avatar'] ?>" alt="Аватар автора" width="30">
                <a href="/<?= $language ?>/<?= $group['username'] ?>/profile" class="text-decoration-none">
                    <strong><?= htmlspecialchars($group['name'] . ' ' . $group['surname']) ?></strong>
                </a>
            </div>
            <?php if (!empty($group['post'])): ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($group['post'] as $post): ?>
                        <li class="list-group-item">
                            <div class="inline-block my-3">
                                <h5>
                                    <a href="/<?= $language ?>/<?= $group['username'] ?>/research/<?= $post['id'] ?>" class="text-decoration-none">
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
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Пока здесь нет публикаций.</p>
<?php endif; ?>