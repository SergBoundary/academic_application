<form method="POST" action="/<?= $language ?>/<?= $user['username'] ?>/research/store" enctype="multipart/form-data">
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
            <div class="container border mb-2 p-4 bg-body shadow">
                <div class="row">
                <div class="mb-3 col-6">
                    <label for="form_post_category" class="form-label"><?= __('research_category') ?></label>
                    <select class="form-select" name="form_post_category" id="form_post_category">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3 col-3">
                    <label for="form_post_language" class="form-label"><?= __('research_publication_language') ?></label>
                    <select class="form-select" name="form_post_language" id="form_post_language">
                        <?php foreach ($languages as $lang): ?>
                            <option value="<?= $lang['code'] ?>"<?= $lang['default'] ? ' selected' : '' ?>><?= $lang['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
            </div>
            <div class="container border mb-2 p-4 bg-body shadow">
                <h5>Meta tags</h5>
                <div class="mb-3">
                    <label for="form_post_title" class="form-label"><?= __('research_title') ?></label>
                    <input type="text" class="form-control" name="form_post_title" id="form_post_title" placeholder="<?= __('research_title_placeholder') ?>">
                </div>
                <div class="my-3">
                    <label for="form_post_authors" class="form-label"><?= __('research_authors') ?></label>
                    <input type="text" class="form-control" name="form_post_authors" id="form_post_authors" placeholder="<?= __('research_authors_placeholder') ?>">
                </div>
                <div class="mb-3">
                    <label for="form_post_keywords" class="form-label"><?= __('research_keywords') ?></label>
                    <input type="text" class="form-control" name="form_post_keywords" id="form_post_keywords" placeholder="<?= __('research_keywords_placeholder') ?>">
                </div>
                <div class="mb-3">
                    <label for="form_post_description" class="form-label"><?= __('research_description') ?></label>
                    <textarea class="form-control" name="form_post_description" id="form_post_description" rows="2" placeholder="<?= __('research_description_placeholder') ?>"></textarea>
                </div>
            </div>
            <div class="container border mb-2 p-4 bg-body shadow">
                <h5><?= __('research_contents') ?></h5>
                <div class="my-3">
                    <label for="form_post_abstract" class="form-label"><?= __('research_abstract') ?></label>
                    <textarea class="form-control" name="form_post_abstract" id="form_post_abstract" rows="2" placeholder="<?= __('research_abstract_placeholder') ?>"></textarea>
                </div>
                <div class="mb-3">
                    <label for="form_post_objective" class="form-label"><?= __('research_objective') ?></label>
                    <textarea class="form-control" name="form_post_objective" id="form_post_objective" rows="2" placeholder="<?= __('research_objective_placeholder') ?>"></textarea>
                </div>
                <div class="mb-3">
                    <label for="form_post_methods" class="form-label"><?= __('research_methods') ?></label>
                    <textarea class="form-control" name="form_post_methods" id="form_post_methods" rows="2" placeholder="<?= __('research_methods_placeholder') ?>"></textarea>
                </div>
                <div class="mb-3">
                    <label for="form_post_results" class="form-label"><?= __('research_results') ?></label>
                    <textarea class="form-control" name="form_post_results" id="form_post_results" rows="2" placeholder="<?= __('research_results_placeholder') ?>"></textarea>
                </div>
                <div class="mb-3">
                    <label for="form_post_conclusions" class="form-label"><?= __('research_conclusions') ?></label>
                    <textarea class="form-control" name="form_post_conclusions" id="form_post_conclusions" rows="2" placeholder="<?= __('research_conclusions_placeholder') ?>"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label"><?= __('illustrations') ?></label>
                    <input type="file" class="form-control" name="form_post_image" id="image">
                </div>
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