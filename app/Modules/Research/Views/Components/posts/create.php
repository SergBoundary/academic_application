<form method="POST" action="/<?= $language ?>/<?= $user['username'] ?>/research/store">
    <div class="card text-dark bg-light shadow-lg mb-2">
        <div class="card-header">
            <img class="rounded-circle border" src="<?= $avatar ?>" alt="Аватар автора" width="30">
            <a href="/<?= $language ?>/<?= $user['username'] ?>/profile" class="text-decoration-none">
                <?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?>
            </a>
            <div class="float-end">
                <small class="text-muted"><span id="dynamicClock"></span></small>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="title" class="form-label"><?= __('form_post_title') ?></label>
                <input type="text" class="form-control" name="form_post_title" id="title">
            </div>
            <div class="mb-3 col-6">
                <label for="category" class="form-label"><?= __('form_post_category') ?></label>
                <select class="form-select" name="form_post_category" id="category">
                    <option value="1" selected>Philosophy</option>
                    <option value="2">Phisics</option>
                    <option value="3">Ethics</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label"><?= __('form_post_content') ?></label>
                <textarea class="form-control" name="form_post_content" id="content" rows="3"></textarea>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="float-end">
                <a href="/<?= $language ?>/<?= $user['username'] ?>/research" class="btn btn-outline-secondary btn-sm ms-3"><?= __('cancel') ?></a>
                <button type="submit" class="btn btn-secondary btn-sm"><?= __('create') ?></button>
            </div>
        </div>
    </div>
</form>