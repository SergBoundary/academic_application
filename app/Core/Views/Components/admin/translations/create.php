<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <h4 class="mb-4"><?= $mapPath['active'] ?></h4>
        <form action="/<?= $language ?>/admin/translations/store" method="POST">
            <div class="mb-3">
                <label for="key" class="form-label"><?= __('key') ?></label>
                <input type="text" class="form-control" id="key" name="key" placeholder="<?= htmlspecialchars(__('enter_translation_key')) ?>" required>
            </div>
            <div class="mb-3">
                <label for="en" class="form-label">English (EN)</label>
                <textarea class="form-control" name="en" id="en" rows="2" placeholder="<?= htmlspecialchars(__('enter_your_translation')) ?>" required></textarea>
            </div>
            <div class="mb-3">
                <label for="pl" class="form-label">Polski (PL)</label>
                <textarea class="form-control" name="pl" id="pl" rows="2" placeholder="<?= htmlspecialchars(__('enter_your_translation')) ?>" required></textarea>
            </div>
            <div class="mb-3">
                <label for="uk" class="form-label">Українська (UK)</label>
                <textarea class="form-control" name="uk" id="uk" rows="2" placeholder="<?= htmlspecialchars(__('enter_your_translation')) ?>" required></textarea>
            </div>
            <div class="mb-3">
                <label for="ru" class="form-label">Русский (RU)</label>
                <textarea class="form-control" name="ru" id="ru" rows="2" placeholder="<?= htmlspecialchars(__('enter_your_translation')) ?>" required></textarea>
            </div>
            <div class="float-end">
                <a href="/<?= $language ?>/admin/translations" class="btn btn-outline-secondary btn-sm me-1"><?= __('cancel') ?></a>
                <button type="submit" class="btn btn-secondary btn-sm"><?= __('add_translation') ?></button>
            </div>
        </form>
    </div>
</div>