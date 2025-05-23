<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <form action="/<?= $language ?>/admin/research/standard/structure/store" method="POST">
            <input type="hidden" name="form" value="<?= $form ?>">
            <div class="row">
                <?php if ($form == 'field'): ?>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="form_discipline"><?= __('research_discipline') ?></label>
                        <select class="form-select" name="form_discipline" id="form_discipline" aria-label="<?= __('research_discipline') ?>">
                            <option selected>...</option>
                            <?php foreach ($disciplines as $discipline): ?>
                                <option value="<?= $discipline['id'] ?>"><?= $discipline[$language] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-6">
                        <div class="float-end">
                            <a href="/<?= $language ?>/admin/research/standard/structure/create/discipline" class="btn btn-outline-secondary btn-sm rounded-pill mt-2" title="<?= __('add_discipline') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_discipline') ?></a>
                        </div>
                    </div>
                <?php elseif ($form == 'area'): ?>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="form_discipline"><?= __('research_discipline') ?></label>
                        <select class="form-select" name="form_discipline" id="form_discipline" aria-label="<?= __('research_discipline') ?>">
                            <option selected>...</option>
                            <?php foreach ($disciplines as $discipline): ?>
                                <option value="<?= $discipline['id'] ?>"><?= $discipline[$language] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-6">
                        <div class="float-end">
                            <a href="/<?= $language ?>/admin/research/standard/structure/create/discipline" class="btn btn-outline-secondary btn-sm rounded-pill mt-2" title="<?= __('add_discipline') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_discipline') ?></a>
                        </div>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="form_field"><?= __('research_field') ?></label>
                        <select class="form-select" name="form_field" id="form_field" aria-label="<?= __('research_field') ?>">
                            <option selected>...</option>
                            <?php foreach ($fields as $field): ?>
                                <option value="<?= $field['id'] ?>"><?= $field[$language] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-6">
                        <div class="float-end">
                            <a href="/<?= $language ?>/admin/research/standard/structure/create/field" class="btn btn-outline-secondary btn-sm rounded-pill mt-2" title="<?= __('add_field') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_field') ?></a>
                        </div>
                    </div>
                <?php elseif ($form == 'element'): ?>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="form_type"><?= __('research_type') ?></label>
                        <select class="form-select" name="form_type" id="form_type" aria-label="<?= __('research_type') ?>">
                            <option selected>...</option>
                            <?php foreach ($types as $type): ?>
                                <option value="<?= $type['id'] ?>"><?= $type[$language] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-6">
                        <div class="float-end">
                            <a href="/<?= $language ?>/admin/research/standard/structure/create/discipline" class="btn btn-outline-secondary btn-sm rounded-pill mt-2" title="<?= __('add_type') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_type') ?></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            // discipline|field|area|type|element
            ?>
            <div class="mb-3">
                <label for="en" class="form-label">English (EN)</label>
                <input type="text" class="form-control" id="en" name="en" placeholder="<?= htmlspecialchars(__('enter_translation_' . $form)) ?>" required>
            </div>
            <div class="mb-3">
                <label for="pl" class="form-label">Polski (PL)</label>
                <input type="text" class="form-control" id="pl" name="pl" placeholder="<?= htmlspecialchars(__('enter_translation_' . $form)) ?>" required>
            </div>
            <div class="mb-3">
                <label for="uk" class="form-label">Українська (UK)</label>
                <input type="text" class="form-control" id="uk" name="uk" placeholder="<?= htmlspecialchars(__('enter_translation_' . $form)) ?>" required>
            </div>
            <div class="mb-3">
                <label for="ru" class="form-label">Русский (RU)</label>
                <input type="text" class="form-control" id="ru" name="ru" placeholder="<?= htmlspecialchars(__('enter_translation_' . $form)) ?>" required>
            </div>
            <div class="float-end">
                <a href="/<?= $language ?>/admin/translations" class="btn btn-outline-secondary btn-sm me-1"><?= __('cancel') ?></a>
                <button type="submit" class="btn btn-secondary btn-sm"><?= __('add_translation') ?></button>
            </div>
        </form>
    </div>
</div>