<h2><?= $header ?></h2>

<form action="/<?= $language ?>/<?= $user['username'] ?>/update-profile" method="POST" enctype="multipart/form-data">
    <label><?= __('name') ?></label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
    
    <label><?= __('surname') ?></label>
    <input type="text" name="surname" value="<?= htmlspecialchars($user['surname']) ?>">

    <label><?= __('user_avatar') ?></label>
    <input type="file" name="avatar">

    <button type="submit"><?= __('save_changes') ?></button>
</form>

<a href="/<?= $language ?>/<?= $user['username'] ?>/profile"><?= __('cancel') ?></a>
