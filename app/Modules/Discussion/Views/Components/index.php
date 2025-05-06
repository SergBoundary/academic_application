<?php if (!empty($groupedPosts)): ?>
    <?php foreach ($groupedPosts as $group): ?>
        <div class="card text-dark bg-body shadow mb-2">
            <div class="card-header">
                <div class="float-start">
                    <img class="rounded-circle border" src="<?= $group['author_avatar'] ?>" alt="Аватар оппонента" width="30">
                    <a href="/<?= $language ?>/<?= $group['author_username'] ?>/profile" class="text-decoration-none">
                        <?= htmlspecialchars($group['author_name'] . ' ' . $group['author_surname']) ?>
                    </a>
                </div>
                <div class="float-end">
                    <small class="text-muted"><?= date('d.m.Y H:i', strtotime($group['author_created_at'])) ?></small>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2"><em><?= $group['category_name'] ?></em></div>
                <h5 class="card-title">
                    <?= htmlspecialchars($group['author_title'] ?? 'Без названия') ?>
                </h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($group['author_content'] ?? 'Без обсуждения')) ?></p>
            </div>
            <div class="card-footer bg-transparent">
                <div class="float-start">
                    <form method="POST" action="/<?= $language ?>/interact/liked/research/<?= $group['research_id'] ?>" class="d-inline ajax-interaction" data-action="liked" data-post-id="<?= $group['research_id'] ?>" data-module="research">
                        <button type="submit" class="btn <?= $group['research_liked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Agree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                            <i class="bi bi-heart-fill"></i>
                        </button>
                    </form>
                    <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="liked" data-post-id="<?= $group['research_id'] ?>" title="Who agrees?">
                        <span class="mx-1"><?= $group['research_likedCount'] ?></span>
                    </a>
                    <form method="POST" action="/<?= $language ?>/interact/disliked/research/<?= $group['research_id'] ?>" class="d-inline ajax-interaction" data-action="disliked" data-post-id="<?= $group['research_id'] ?>" data-module="research">
                        <button type="submit" class="btn <?= $group['research_disliked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Disagree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                            <i class="bi bi-heartbreak-fill"></i>
                        </button>
                    </form>
                    <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="disliked" data-post-id="<?= $group['research_id'] ?>" title="Who disagrees?">
                        <span class="mx-1"><?= $group['research_dislikedCount'] ?></span>
                    </a>
                    <!-- Create comment -->
                    <form method="GET" action="<?php if (isset($_SESSION['user'])): ?>/<?= $language ?>/<?= $_SESSION['user']['username'] ?>/discussion/<?= $group['research_id'] ?>/0/create<?php endif; ?>" class="d-inline">
                        <button type="submit" class="btn <?= $group['research_comment'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Comment" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                            <i class="bi bi-chat-left-text-fill"></i>
                        </button>
                    </form>
                    <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="сomment" data-post-id="<?= $group['research_id'] ?>" title="Who comments?">
                        <span class="mx-1"><?= $group['research_commentCount'] ?></span>
                    </a>
                    <a href="" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Translate">
                        <i class="bi bi-translate"></i>
                    </a>
                    <form method="POST" action="/<?= $language ?>/interact/shared/research/<?= $group['research_id'] ?>" class="d-inline ajax-interaction" data-action="shared" data-post-id="<?= $group['research_id'] ?>" data-module="research">
                        <button type="submit" class="btn <?= $group['research_shared'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0 ms-3" title="Share" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                            <i class="bi bi-share-fill"></i>
                        </button>
                    </form>
                    <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="shared" data-post-id="<?= $group['research_id'] ?>" title="Who shares?">
                        <span class="mx-1"><?= $group['research_sharedCount'] ?></span>
                    </a>
                    <form method="POST" action="/<?= $language ?>/interact/bookmarked/research/<?= $group['research_id'] ?>" class="d-inline ajax-interaction" data-action="bookmarked" data-post-id="<?= $group['research_id'] ?>" data-module="research">
                        <button type="submit" class="btn <?= $group['research_bookmarked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Bookmark" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                            <i class="bi bi-bookmark-fill"></i>
                        </button>
                    </form>
                    <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="bookmarked" data-post-id="<?= $group['research_id'] ?>" title="Who bookmarks?">
                        <span class="mx-1"><?= $group['research_bookmarkedCount'] ?></span>
                    </a>
                    <form method="POST" action="/<?= $language ?>/interact/subscribed/research/<?= $group['research_id'] ?>" class="d-inline ajax-interaction" data-action="subscribed" data-post-id="<?= $group['research_id'] ?>" data-module="research">
                        <button type="submit" class="btn <?= $group['research_subscribed'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Subscription" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                            <i class="bi bi-bell-fill"></i>
                        </button>
                    </form>
                    <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="subscribed" data-post-id="<?= $group['research_id'] ?>" title="Who subscriptions?">
                        <span class="mx-1"><?= $group['research_subscribedCount'] ?></span>
                    </a>
                </div>
                <div class="float-end">
                    <a href="/<?= $language ?>/<?= $group['author_username'] ?>/research/<?= $group['research_id'] ?>" class="btn btn-outline-secondary btn-sm rounded-pill" title="<?= __('view_post') ?>">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php if (!empty($group['discussions'])): ?>
            <?php foreach ($group['discussions'] as $discussion): ?>
                <div class="card text-dark bg-body shadow mb-2 ms-3">
                    <div class="card-header">
                        <img class="rounded-circle border" src="<?= $discussion['opponent_avatar'] ?>" alt="Аватар оппонента" width="30">
                        <a href="/<?= $language ?>/<?= $discussion['opponent_username'] ?>/profile" class="text-decoration-none">
                            <?= htmlspecialchars($discussion['opponent_name'] . ' ' . $discussion['opponent_surname']) ?>
                        </a>
                        <div class="float-end">
                            <small class="text-muted"><?= date('d.m.Y H:i', strtotime($discussion['discussion_created_at'])) ?></small>
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
                        <p class="card-text"><?= nl2br(htmlspecialchars($discussion['discussion_content'] ?? 'Без обсуждения')) ?></p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="float-start">
                            <form method="POST" action="/<?= $language ?>/interact/liked/discussion/<?= $discussion['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="liked" data-post-id="<?= $discussion['discussion_id'] ?>" data-module="discussion">
                                <button type="submit" class="btn <?= $discussion['discussion_liked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Agree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </form>
                            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="liked" data-post-id="<?= $discussion['discussion_id'] ?>" title="Who agrees?">
                                <span class="mx-1"><?= $discussion['discussion_likedCount'] ?></span>
                            </a>
                            <form method="POST" action="/<?= $language ?>/interact/disliked/discussion/<?= $discussion['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="disliked" data-post-id="<?= $discussion['discussion_id'] ?>" data-module="discussion">
                                <button type="submit" class="btn <?= $discussion['discussion_disliked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Disagree" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                    <i class="bi bi-heartbreak-fill"></i>
                                </button>
                            </form>
                            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="disliked" data-post-id="<?= $discussion['discussion_id'] ?>" title="Who disagrees?">
                                <span class="mx-1"><?= $discussion['discussion_dislikedCount'] ?></span>
                            </a>
                            <!-- Create comment -->
                            <form method="GET" action="<?php if (isset($_SESSION['user'])): ?>/<?= $language ?>/<?= $_SESSION['user']['username'] ?>/discussion/<?= $group['research_id'] ?>/<?= $discussion['discussion_id'] ?>/create<?php endif; ?>" class="d-inline">
                                <button type="submit" class="btn <?= $discussion['discussion_comment'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Comment" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                    <i class="bi bi-chat-left-text-fill"></i>
                                </button>
                            </form>
                            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="comment" data-post-id="<?= $discussion['discussion_id'] ?>" title="Who comments?">
                                <span class="mx-1"><?= $discussion['discussion_commentCount'] ?></span>
                            </a>
                            <a href="" class="btn btn-outline-secondary btn-sm border-0 ms-3" title="Translate">
                                <i class="bi bi-translate"></i>
                            </a>
                            <form method="POST" action="/<?= $language ?>/interact/shared/discussion/<?= $discussion['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="shared" data-post-id="<?= $discussion['discussion_id'] ?>" data-module="discussion">
                                <button type="submit" class="btn <?= $discussion['discussion_shared'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0 ms-3" title="Share" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                    <i class="bi bi-share-fill"></i>
                                </button>
                            </form>
                            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="shared" data-post-id="<?= $discussion['discussion_id'] ?>" title="Who shares?">
                                <span class="mx-1"><?= $discussion['discussion_sharedCount'] ?></span>
                            </a>
                            <form method="POST" action="/<?= $language ?>/interact/bookmarked/discussion/<?= $discussion['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="bookmarked" data-post-id="<?= $discussion['discussion_id'] ?>" data-module="discussion">
                                <button type="submit" class="btn <?= $discussion['discussion_bookmarked'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Bookmark" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                    <i class="bi bi-bookmark-fill"></i>
                                </button>
                            </form>
                            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="bookmarked" data-post-id="<?= $discussion['discussion_id'] ?>" title="Who bookmarks?">
                                <span class="mx-1"><?= $discussion['discussion_bookmarkedCount'] ?></span>
                            </a>
                            <form method="POST" action="/<?= $language ?>/interact/subscribed/discussion/<?= $discussion['discussion_id'] ?>" class="d-inline ajax-interaction" data-action="subscribed" data-post-id="<?= $discussion['discussion_id'] ?>" data-module="discussion">
                                <button type="submit" class="btn <?= $discussion['discussion_subscribed'] ? 'btn-outline-primary' : 'btn-outline-secondary' ?> btn-sm border-0" title="Subscription" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                                    <i class="bi bi-bell-fill"></i>
                                </button>
                            </form>
                            <a href="" class="btn btn-secondary btn-sm rounded-pill badge" data-action="subscribed" data-post-id="<?= $discussion['discussion_id'] ?>" title="Who subscriptions?">
                                <span class="mx-1"><?= $discussion['discussion_subscribedCount'] ?></span>
                            </a>
                        </div>
                        <div class="float-end">
                            <a href="/<?= $language ?>/<?= $discussion['opponent_username'] ?>/discussion/<?= $discussion['discussion_id'] ?>" class="btn btn-outline-secondary btn-sm rounded-pill" title="<?= __('view_post') ?>">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <div class="container border mb-2 bg-body shadow">
        <div class="row">
            <div class="h-auto mx-auto text-center p-5">
                <h3 class="text-muted"><?= __('no_critical_publications_here_yet') ?></h3>
            </div>
        </div>
    </div>
<?php endif; ?>