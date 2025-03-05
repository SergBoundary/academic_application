<h2><?= __($title) ?></h2>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>
<form method="POST">
    <input type="text" name="name" placeholder="<?= __('name') ?>" required>
    <input type="text" name="surname" placeholder="<?= __('surname') ?>">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="<?= __('password') ?>" required>
    <button type="submit"><?= __('sign_up') ?></button>
</form>
