<div class="card text-dark bg-light shadow-lg">
    <div class="card-header">
        <img class="rounded-circle border" src="<?= $post['opponent_avatar'] ?>" alt="Аватар оппонента" width="30">
        <a href="/<?= $language ?>/<?= $post['opponent_username'] ?>/profile" class="text-decoration-none">
            <?= htmlspecialchars($post['opponent_name'] . ' ' . $post['opponent_surname']) ?>
        </a>
        <div class="float-end">
            <small class="text-muted"><?= date('d.m.Y H:i', strtotime($post['discussion_created_at'])) ?></small>
        </div>
    </div>
    <div class="card-body">
        <h6 class="card-title text-muted">
            <?= $post['discussion_type_name'] ?>
            <span class="text-muted">[<?= $post['discussion_id'] ?>]</span>
            <?php if (!empty($post['discussion_post_id'])): ?>
                to <?= $post['discussion_level_up_type_name'] ?> <span>[<?= $post['discussion_post_id'] ?>]</span>
            <?php else: ?>
                to <?= $post['discussion_level_up_type_name'] ?>
                <a href="/<?= $language ?>/<?= $post['author_username'] ?>/research/<?= $post['research_id'] ?>" class="text-decoration-none">
                    "<span><?= $post['author_title'] ?></span>"
                </a>
                by
                <img class="rounded-circle border" src="<?= $post['author_avatar'] ?>" alt="Аватар оппонента" width="30">
                <a href="/<?= $language ?>/<?= $post['author_username'] ?>/profile" class="text-decoration-none">
                    <?= htmlspecialchars($post['author_name'] . ' ' . $post['author_surname']) ?>
                </a>
            <?php endif; ?>
        </h6>
        <p class="card-text"><?= nl2br(htmlspecialchars($post['discussion_content'] ?? 'Без обсуждения')) ?></p>
    </div>
    <div class="card-footer bg-transparent">
        <div class="float-start">
            <form method="POST" action="/<?= $language ?>/interact/liked/discussion/<?= $post['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="liked" data-post-id="<?= $post['discussion_id'] ?>" data-module="discussion">
                <button type="submit" class="btn <?= $post['discussion_liked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Agree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-heart-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="liked" data-post-id="<?= $post['discussion_id'] ?>" title="Who agrees?">
                <span class="mx-1"><?= $post['discussion_likedCount'] ?></span>
            </a>
            <form method="POST" action="/<?= $language ?>/interact/disliked/discussion/<?= $post['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="disliked" data-post-id="<?= $post['discussion_id'] ?>" data-module="discussion">
                <button type="submit" class="btn <?= $post['discussion_disliked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Disagree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-heartbreak-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="disliked" data-post-id="<?= $post['discussion_id'] ?>" title="Who disagrees?">
                <span class="mx-1"><?= $post['discussion_dislikedCount'] ?></span>
            </a>
            <!-- Create comment -->
            <form method="GET" action="<?php if (isset($_SESSION['user'])): ?>/<?= $language ?>/<?= $_SESSION['user']['username'] ?>/discussion/<?= $post['research_id'] ?>/<?= $post['discussion_id'] ?>/create<?php endif; ?>" class="d-inline">
                <button type="submit" class="btn <?= $post['discussion_comment'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Comment" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-chat-left-text-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="comment" data-post-id="<?= $post['discussion_id'] ?>" title="Who comments?">
                <span class="mx-1"><?= $post['discussion_commentCount'] ?></span>
            </a>
            <a href="" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Translate">
                <i class="bi bi-translate"></i>
            </a>
            <form method="POST" action="/<?= $language ?>/interact/shared/discussion/<?= $post['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="shared" data-post-id="<?= $post['discussion_id'] ?>" data-module="discussion">
                <button type="submit" class="btn <?= $post['discussion_shared'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0 ms-3" title="Share" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-share-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="shared" data-post-id="<?= $post['discussion_id'] ?>" title="Who shares?">
                <span class="mx-1"><?= $post['discussion_sharedCount'] ?></span>
            </a>
            <form method="POST" action="/<?= $language ?>/interact/bookmarked/discussion/<?= $post['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="bookmarked" data-post-id="<?= $post['discussion_id'] ?>" data-module="discussion">
                <button type="submit" class="btn <?= $post['discussion_bookmarked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Bookmark" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-bookmark-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="bookmarked" data-post-id="<?= $post['discussion_id'] ?>" title="Who bookmarks?">
                <span class="mx-1"><?= $post['discussion_bookmarkedCount'] ?></span>
            </a>
            <form method="POST" action="/<?= $language ?>/interact/subscribed/discussion/<?= $post['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="subscribed" data-post-id="<?= $post['discussion_id'] ?>" data-module="discussion">
                <button type="submit" class="btn <?= $post['discussion_subscribed'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Subscription" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-bell-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="subscribed" data-post-id="<?= $post['discussion_id'] ?>" title="Who subscriptions?">
                <span class="mx-1"><?= $post['discussion_subscribedCount'] ?></span>
            </a>
        </div>
        <div class="float-end">
            <a href="" class="btn btn-outline-secondary btn-sm" title="Download PDF"><i class="bi bi-file-pdf-fill"></i></a>
            <!-- Кнопки редактирования и удаления (только для автора поста) -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['opponent_id']): ?>
                <a href="/<?= $language ?>/<?= $post['opponent_username'] ?>/discussion/<?= $post['discussion_id'] ?>/edit" class="btn btn-outline-warning btn-sm ms-3" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                <form method="POST" action="/<?= $language ?>/<?= $post['opponent_username'] ?>/discussion/<?= $post['discussion_id'] ?>/delete" style="display:inline;">
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete') ?>');" title="Delete"><i class="bi bi-trash3-fill"></i></button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>