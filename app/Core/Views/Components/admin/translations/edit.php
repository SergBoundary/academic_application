<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <form action="/<?= $language ?>/admin/translations/update" method="POST">
            <input type="hidden" name="key" value="<?= htmlspecialchars($translation['key_name']) ?>">
            <div class="mb-3">
                <label for="en" class="form-label">English (EN)</label>
                <textarea class="form-control" name="en" id="en" rows="2" placeholder="<?= htmlspecialchars(__('enter_your_translation')) ?>"><?= htmlspecialchars($translation['en']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="pl" class="form-label">Polski (PL)</label>
                <textarea class="form-control" name="pl" id="pl" rows="2" placeholder="<?= htmlspecialchars(__('enter_your_translation')) ?>"><?= htmlspecialchars($translation['pl']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="uk" class="form-label">Українська (UK)</label>
                <textarea class="form-control" name="uk" id="uk" rows="2" placeholder="<?= htmlspecialchars(__('enter_your_translation')) ?>"><?= htmlspecialchars($translation['uk']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="ru" class="form-label">Русский (RU)</label>
                <textarea class="form-control" name="ru" id="ru" rows="2" placeholder="<?= htmlspecialchars(__('enter_your_translation')) ?>"><?= htmlspecialchars($translation['ru']) ?></textarea>
            </div>
            <div class="float-end">
                <a href="/<?= $language ?>/admin/translations" class="btn btn-outline-secondary btn-sm me-1"><?= __('cancel') ?></a>
                <button type="submit" class="btn btn-secondary btn-sm"><?= __('save_changes') ?></button>
            </div>
        </form>
    </div>
</div>