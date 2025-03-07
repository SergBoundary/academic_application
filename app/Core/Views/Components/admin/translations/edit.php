<h2><?= htmlspecialchars(__($title)) ?>: <?= htmlspecialchars($translation['key_name']) ?></h2>
<form method="POST" action="/<?= $language ?>/admin/translations/update">
    <input type="hidden" name="key" value="<?= htmlspecialchars($translation['key_name']) ?>">
    
    <label>English (en):</label><br>
    <textarea name="en" rows="2" cols="40"><?= htmlspecialchars($translation['en']) ?></textarea><br><br>
    
    <label>Polski (pl):</label><br>
    <textarea name="pl" rows="2" cols="40"><?= htmlspecialchars($translation['pl']) ?></textarea><br><br>
    
    <label>Українська (ua):</label><br>
    <textarea name="uk" rows="2" cols="40"><?= htmlspecialchars($translation['uk']) ?></textarea><br><br>
    
    <label>Русский (ru):</label><br>
    <textarea name="ru" rows="2" cols="40"><?= htmlspecialchars($translation['ru']) ?></textarea><br><br>
    
    <button type="submit"><?= __('save_changes') ?></button>
</form>
