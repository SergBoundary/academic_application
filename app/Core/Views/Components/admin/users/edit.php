<h2><?= __('editing_user_properties') ?>: <?= $user['name'] ?></h2>

<form method="POST" action="/admin/users/update">
    <input type="hidden" name="id" value="<?= $user['id']; ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= $user['email']; ?>" required>
    <br>
    <br>

    <label><?= __('role') ?></label>
    <select name="role">
        <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
    </select>
    <br>

    <h4><?= __('user_rights') ?>:</h4>
    <label>
        <input type="checkbox" name="research" <?= isset($permissions['research']) && $permissions['research'] ? 'checked' : '' ?>>
        <?= __('module') ?> "Research"
    </label>
    <br>

    <label>
        <input type="checkbox" name="social" <?= isset($permissions['social']) && $permissions['social'] ? 'checked' : '' ?>>
        <?= __('module') ?> "Social"
    </label>
    <br>

    <label>
        <input type="checkbox" name="private" <?= isset($permissions['private']) && $permissions['private'] ? 'checked' : '' ?>>
        <?= __('module') ?> "Private"
    </label>
    <br>
    <br>

    <button type="submit"><?= __('save') ?></button>
</form>