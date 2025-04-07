<div class="card text-dark bg-light shadow-lg mb-2">
    <div class="card-header">
        <img class="rounded-circle border" src="<?= $viewPost['author_avatar'] ?>" alt="Аватар оппонента" width="30">
        <a href="/<?= $language ?>/<?= $viewPost['author_username'] ?>/profile" class="text-decoration-none">
            <?= htmlspecialchars($viewPost['author_name'] . ' ' . $viewPost['author_surname']) ?>
        </a>
        <div class="float-end">
            <a href="/<?= $language ?>/<?= $viewPost['author_username'] ?>/research/<?= $viewPost['research_id'] ?>" class="btn btn-outline-secondary btn-sm" title="View post">
                <i class="bi bi-eye-fill"></i>
            </a>
        </div>
    </div>
    <div class="card-body">
        <h6><em><?= $viewPost['category_name'] ?></em></h6>
        <h5 class="card-title">
            <?= htmlspecialchars($viewPost['author_title'] ?? 'Без названия') ?>
        </h5>
        <p class="card-text"><?= htmlspecialchars($viewPost['author_content'] ?? 'Без обсуждения') ?></p>
    </div>
</div>
<?php if ($discussionid != 0): ?>
    <div class="card text-dark bg-light shadow-lg ms-3 mb-2">
        <div class="card-header">
            <img class="rounded-circle border" src="<?= $viewPost['opponent_avatar'] ?>" alt="Аватар оппонента" width="30">
            <a href="/<?= $language ?>/<?= $viewPost['opponent_username'] ?>/profile" class="text-decoration-none">
                <?= htmlspecialchars($viewPost['opponent_name'] . ' ' . $viewPost['opponent_surname']) ?>
            </a>
            <div class="float-end">
                <a href="/<?= $language ?>/<?= $viewPost['opponent_username'] ?>/discussion/<?= $viewPost['discussion_id'] ?>" class="btn btn-outline-secondary btn-sm" title="View post">
                    <i class="bi bi-eye-fill"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <h6 class="card-title text-muted">
                <?= $viewPost['discussion_type_name'] ?>
                <span class="text-muted">[<?= $viewPost['discussion_id'] ?>]</span>
                <?php if (!empty($viewPost['discussion_post_id'])): ?>
                    to <?= $viewPost['discussion_level_up_type_name'] ?> <span>[<?= $viewPost['discussion_post_id'] ?>]</span>
                <?php else: ?>
                    to text "<span><?= $viewPost['author_title'] ?></span>"
                <?php endif; ?>
            </h6>
            <p class="card-text"><?= htmlspecialchars($viewPost['discussion_content'] ?? 'Без обсуждения') ?></p>
        </div>
    </div>
<?php endif; ?>
<form method="POST" action="/<?= $language ?>/<?= $user['username'] ?>/discussion/store">
    <input type="hidden" name="form_post_research_id" id="form_post_research_id" value="<?= $viewPost['research_id'] ?>">
    <input type="hidden" name="form_post_discussion_id" id="form_post_discussion_id" value="<?= $viewPost['discussion_id'] ?? '0' ?>">
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
                        <option value="<?= $discussionType['id'] ?>"><?= $discussionType['type'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 col-4 mt-2">
                <?php if ($discussionid != 0): ?>
                    <strong>to <?= $viewPost['discussion_type_name'] ?> <span>[<?= $viewPost['discussion_id'] ?>]</span></strong>
                <?php else: ?>
                    <strong>to text "<span><?= $viewPost['author_title'] ?></span>"</strong>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="form_post_content" class="form-label"><?= __('form_post_content') ?></label>
                <textarea class="form-control" name="form_post_content" id="form_post_content" rows="3"></textarea>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="float-end">
                <a href="/<?= $language ?>/<?= $user['username'] ?>/discussion" class="btn btn-outline-secondary btn-sm ms-3"><?= __('cancel') ?></a>
                <button type="submit" class="btn btn-secondary btn-sm"><?= __('create') ?></button>
            </div>
        </div>
    </div>
</form>