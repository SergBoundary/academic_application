<h2><?= __('new_password') ?></h2>
<form action="/<?= $language ?>/password/update" method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
    <input type="password" name="password" placeholder="<?= __('enter_new_password') ?>" required>
    <button type="submit"><?= __('to_update_password') ?></button>
</form>
