<h2><?= htmlspecialchars(__($title)) ?></h2>
<form method="POST" action="/<?= $language ?>/admin/translations/create">
    <label><?= __('key') ?> (key_name):</label><br>
    <input type="text" name="key" required><br><br>
    
    <label>English (en):</label><br>
    <textarea name="en" rows="2" cols="40"></textarea><br><br>
    
    <label>Polski (pl):</label><br>
    <textarea name="pl" rows="2" cols="40"></textarea><br><br>
    
    <label>Українська (uk):</label><br>
    <textarea name="uk" rows="2" cols="40"></textarea><br><br>
    
    <label>Русский (ru):</label><br>
    <textarea name="ru" rows="2" cols="40"></textarea><br><br>
    
    <button type="submit"><?= __('add_translation') ?></button>
</form>
