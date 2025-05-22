<form method="POST" action="/<?= $language ?>/admin/research/update">
    <input type="hidden" name="form_post_id" value="<?= $post['id'] ?>">
    <div class="card text-dark bg-body shadow mb-2">
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
            <h4 class="mb-4"><?= $mapPath['active'] ?></h4>
            <div class="mb-3">
                <label for="form_post_title" class="form-label"><?= __('form_post_title') ?></label>
                <input type="text" class="form-control" name="form_post_title" id="form_post_title" value="<?= $post['title'] ?>">
            </div>
            <div class="mb-3 col-6">
                <?php if (!empty($categories)): ?>
                    <label for="form_post_category" class="form-label"><?= __('form_post_category') ?></label>
                    <select class="form-select" name="form_post_category" id="form_post_category">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $post['category_id'] ? 'selected' : '' ?>><?= $category['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="form_post_content" class="form-label"><?= __('form_post_content') ?></label>
                <textarea class="form-control" name="form_post_content" id="form_post_content" rows="5"><?= htmlspecialchars($post['content']) ?></textarea>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="float-end">
                <a href="/<?= $language ?>/admin/research" class="btn btn-outline-secondary btn-sm ms-3"><?= __('cancel') ?></a>
                <button type="submit" class="btn btn-secondary btn-sm"><?= __('save') ?></button>
            </div>
        </div>
    </div>
</form>