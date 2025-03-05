<h2><?= __($title) ?></h2>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="<?= __('password') ?>" required>
    <button type="submit"><?= __('log_in') ?></button>
</form>
<p><a href="/<?= $language ?>/register"><?= __('sign_up') ?></a> | <a href="/<?= $language ?>/password/reset"><?= __('forgot_password') ?></a></p>
