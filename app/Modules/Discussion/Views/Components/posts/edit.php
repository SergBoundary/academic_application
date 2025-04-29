<div class="card text-dark bg-body shadow mb-2">
    <div class="card-header">
        <img class="rounded-circle border" src="<?= $post['author_avatar'] ?>" alt="Аватар оппонента" width="30">
        <a href="/<?= $language ?>/<?= $post['author_username'] ?>/profile" class="text-decoration-none">
            <?= htmlspecialchars($post['author_name'] . ' ' . $post['author_surname']) ?>
        </a>
        <div class="float-end">
            <small class="text-muted"><?= date('d.m.Y H:i', strtotime($post['author_created_at'])) ?></small>
        </div>
    </div>
    <div class="card-body">
        <h6><em><?= $post['category_name'] ?></em></h6>
        <h5 class="card-title">
            <?= htmlspecialchars($post['author_title'] ?? 'Без названия') ?>
        </h5>
        <p class="card-text"><?= nl2br(htmlspecialchars($post['author_content'] ?? 'Без обсуждения')) ?></p>
    </div>
    <div class="card-footer bg-transparent">
        <div class="float-start">
            <form method="POST" action="/<?= $language ?>/interact/liked/research/<?= $post['research_id'] ?>" class="d-inline ajax-interaction" data-action="liked" data-post-id="<?= $post['research_id'] ?>" data-module="research">
                <button type="submit" class="btn <?= $post['research_liked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Agree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-heart-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="liked" data-post-id="<?= $post['research_id'] ?>" title="Who agrees?">
                <span class="mx-1"><?= $post['research_likedCount'] ?></span>
            </a>
            <form method="POST" action="/<?= $language ?>/interact/disliked/research/<?= $post['research_id'] ?>" class="d-inline ajax-interaction" data-action="disliked" data-post-id="<?= $post['research_id'] ?>" data-module="research">
                <button type="submit" class="btn <?= $post['research_disliked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Disagree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-heartbreak-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="disliked" data-post-id="<?= $post['research_id'] ?>" title="Who disagrees?">
                <span class="mx-1"><?= $post['research_dislikedCount'] ?></span>
            </a>
            <!-- Create comment -->
            <form method="GET" action="<?php if (isset($_SESSION['user'])): ?>/<?= $language ?>/<?= $_SESSION['user']['username'] ?>/discussion/<?= $post['research_id'] ?>/0/create<?php endif; ?>" class="d-inline">
                <button type="submit" class="btn <?= $post['research_comment'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Comment" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-chat-left-text-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="сomment" data-post-id="<?= $post['research_id'] ?>" title="Who comments?">
                <span class="mx-1"><?= $post['research_commentCount'] ?></span>
            </a>
            <a href="" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Translate">
                <i class="bi bi-translate"></i>
            </a>
            <form method="POST" action="/<?= $language ?>/interact/shared/research/<?= $post['research_id'] ?>" class="d-inline ajax-interaction" data-action="shared" data-post-id="<?= $post['research_id'] ?>" data-module="research">
                <button type="submit" class="btn <?= $post['research_shared'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0 ms-3" title="Share" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-share-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="shared" data-post-id="<?= $post['research_id'] ?>" title="Who shares?">
                <span class="mx-1"><?= $post['research_sharedCount'] ?></span>
            </a>
            <form method="POST" action="/<?= $language ?>/interact/bookmarked/research/<?= $post['research_id'] ?>" class="d-inline ajax-interaction" data-action="bookmarked" data-post-id="<?= $post['research_id'] ?>" data-module="research">
                <button type="submit" class="btn <?= $post['research_bookmarked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Bookmark" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-bookmark-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="bookmarked" data-post-id="<?= $post['research_id'] ?>" title="Who bookmarks?">
                <span class="mx-1"><?= $post['research_bookmarkedCount'] ?></span>
            </a>
            <form method="POST" action="/<?= $language ?>/interact/subscribed/research/<?= $post['research_id'] ?>" class="d-inline ajax-interaction" data-action="subscribed" data-post-id="<?= $post['research_id'] ?>" data-module="research">
                <button type="submit" class="btn <?= $post['research_subscribed'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Subscription" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                    <i class="bi bi-bell-fill"></i>
                </button>
            </form>
            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="subscribed" data-post-id="<?= $post['research_id'] ?>" title="Who subscriptions?">
                <span class="mx-1"><?= $post['research_subscribedCount'] ?></span>
            </a>
        </div>
        <div class="float-end">
            <a href="/<?= $language ?>/<?= $post['author_username'] ?>/research/<?= $post['research_id'] ?>" class="btn btn-outline-secondary btn-sm rounded-pill" title="View post">
                <i class="bi bi-eye-fill"></i>
            </a>
        </div>
    </div>
</div>
<?php if ($discussionid != 0): ?>
    <div class="card text-dark bg-body shadow mb-2 ms-3">
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
                    to text "<span><?= $post['author_title'] ?></span>"
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
                <a href="/<?= $language ?>/<?= $post['opponent_username'] ?>/discussion/<?= $post['discussion_id'] ?>" class="btn btn-outline-secondary btn-sm rounded-pill" title="View post">
                    <i class="bi bi-eye-fill"></i>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
<form method="POST" action="/<?= $language ?>/<?= $user['username'] ?>/discussion/<?= $postUpdate['discussion_id'] ?>/update">
    <input type="hidden" name="form_post_research_id" id="form_post_research_id" value="<?= $post['research_id'] ?>">
    <input type="hidden" name="form_post_discussion_id" id="form_post_discussion_id" value="<?= $post['discussion_id'] ?>">
    <div class="card text-dark bg-light shadow-lg ms-3 mb-2">
        <div class="card-header">
            <img class="rounded-circle border" src="<?= $avatar ?>" alt="Аватар автора" width="30">
            <a href="/<?= $language ?>/<?= $user['username'] ?>/profile" class="text-decoration-none">
                <?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?>
            </a>
            <div class="float-end">
                <small class="text-muted"><span id="dynamicClock"></span></small>
            </div>
        </div>
        <div class="card-body row">
            <div class="mb-3 col-4">
                <select class="form-select" name="form_post_type" id="form_post_type">
                    <?php foreach ($discussionTypes as $discussionType): ?>
                        <option value="<?= $discussionType['id'] ?>" <?= $discussionType['id'] == $postUpdate['discussion_type_id'] ? 'selected' : '' ?>><?= $discussionType['type'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 col-4 mt-2">
                <?php if ($discussionid != 0): ?>
                    <strong>to <?= $post['discussion_type_name'] ?> <span>[<?= $post['discussion_id'] ?>]</span></strong>
                <?php else: ?>
                    <strong>to text "<span><?= $post['author_title'] ?></span>"</strong>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="form_post_content" class="form-label"><?= __('form_post_content') ?></label>
                <textarea class="form-control" name="form_post_content" id="form_post_content" rows="3"><?= htmlspecialchars($postUpdate['discussion_content']) ?></textarea>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="float-end">
                <a href="/<?= $language ?>/<?= $user['username'] ?>/discussion/<?= $postUpdate['discussion_id'] ?>" class="btn btn-outline-secondary btn-sm ms-3"><?= __('cancel') ?></a>
                <button type="submit" class="btn btn-secondary btn-sm"><?= __('create') ?></button>
            </div>
        </div>
    </div>
</form>