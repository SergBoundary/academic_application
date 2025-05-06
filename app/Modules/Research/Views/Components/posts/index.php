<div class="card text-dark bg-body shadow mb-2">
    <div class="card-header">
        <img class="rounded-circle border" src="<?= $avatar ?>" alt="Аватар автора" width="30">
        <a href="/<?= $language ?>/<?= $user['username'] ?>/profile" class="text-decoration-none">
            <strong><?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?></strong>
        </a>
        <div class="float-end">
            <!-- Кнопка "Создать пост" (только для авторизованных) -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['username'] == $user['username']): ?>
                <a href="/<?= $language ?>/<?= $user['username'] ?>/research/create" class="btn btn-outline-secondary btn-sm rounded-pill" title="Create new post"><i class="bi bi-plus-lg"></i></a>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty($posts)): ?>
        <ul class="list-group list-group-flush">
            <?php foreach ($posts as $post): ?>
                <li class="list-group-item">
                    <div class="inline-block my-2">
                        <em><?= $post['category_name'] ?></em>
                        <div class="float-end">
                            <small class="text-muted"><?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></small>
                        </div>
                        <h5><?= $post['title'] ?></h5>
                    </div>
                    <div class="float-start mt-2">
                        <form method="POST" action="/<?= $language ?>/interact/liked/research/<?= $post['id'] ?>" class="d-inline ajax-interaction" data-action="liked" data-post-id="<?= $post['id'] ?>" data-module="research">
                            <button type="submit" class="btn <?= $post['liked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Agree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </form>
                        <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="liked" data-post-id="<?= $post['id'] ?>" title="Who agrees?">
                            <span class="mx-1"><?= $post['likedCount'] ?></span>
                        </a>
                        <form method="POST" action="/<?= $language ?>/interact/disliked/research/<?= $post['id'] ?>" class="d-inline ajax-interaction" data-action="disliked" data-post-id="<?= $post['id'] ?>" data-module="research">
                            <button type="submit" class="btn <?= $post['disliked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Disagree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                <i class="bi bi-heartbreak-fill"></i>
                            </button>
                        </form>
                        <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="disliked" data-post-id="<?= $post['id'] ?>" title="Who disagrees?">
                            <span class="mx-1"><?= $post['dislikedCount'] ?></span>
                        </a>
                        <!-- Create comment -->
                        <form method="GET" action="<?php if (isset($_SESSION['user'])): ?>/<?= $language ?>/<?= $_SESSION['user']['username'] ?>/discussion/<?= $post['id'] ?>/0/create<?php endif; ?>" class="d-inline">
                            <button type="submit" class="btn <?= $post['comment'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Comment" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                <i class="bi bi-chat-left-text-fill"></i>
                            </button>
                        </form>
                        <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="comment" data-post-id="<?= $post['id'] ?>" title="Who comments?">
                            <span class="mx-1"><?= $post['commentCount'] ?></span>
                        </a>
                        <a href="" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Translate">
                            <i class="bi bi-translate"></i>
                        </a>
                        <form method="POST" action="/<?= $language ?>/interact/shared/research/<?= $post['id'] ?>" class="d-inline ajax-interaction" data-action="shared" data-post-id="<?= $post['id'] ?>" data-module="research">
                            <button type="submit" class="btn <?= $post['shared'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0 ms-3" title="Share" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                <i class="bi bi-share-fill"></i>
                            </button>
                        </form>
                        <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="shared" data-post-id="<?= $post['id'] ?>" title="Who shares?">
                            <span class="mx-1"><?= $post['sharedCount'] ?></span>
                        </a>
                        <form method="POST" action="/<?= $language ?>/interact/bookmarked/research/<?= $post['id'] ?>" class="d-inline ajax-interaction" data-action="bookmarked" data-post-id="<?= $post['id'] ?>" data-module="research">
                            <button type="submit" class="btn <?= $post['bookmarked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Bookmark" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                <i class="bi bi-bookmark-fill"></i>
                            </button>
                        </form>
                        <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="bookmarked" data-post-id="<?= $post['id'] ?>" title="Who bookmarks?">
                            <span class="mx-1"><?= $post['bookmarkedCount'] ?></span>
                        </a>
                        <form method="POST" action="/<?= $language ?>/interact/subscribed/research/<?= $post['id'] ?>" class="d-inline ajax-interaction" data-action="subscribed" data-post-id="<?= $post['id'] ?>" data-module="research">
                            <button type="submit" class="btn <?= $post['subscribed'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Subscription" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                <i class="bi bi-bell-fill"></i>
                            </button>
                        </form>
                        <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="subscribed" data-post-id="<?= $post['id'] ?>" title="Who subscriptions?">
                            <span class="mx-1"><?= $post['subscribedCount'] ?></span>
                        </a>
                    </div>
                    <div class="float-end mt-2">
                        <a href="/<?= $language ?>/<?= $user['username'] ?>/research/<?= $post['id'] ?>" class="btn btn-outline-secondary btn-sm rounded-pill" title="<?= __('view_post') ?>">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="row">
            <div class="h-auto mx-auto text-center p-5">
                <h3 class="text-muted"><?= __('no_publications_here_yet') ?></h3>
            </div>
        </div>
    <?php endif; ?>
</div>