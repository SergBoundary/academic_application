<?php
$avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
$avatarUrl = $avatarFile . "?v=" . time(); // Добавляем timestamp
?>
<div class="container p-4 bg-light shadow-lg">
    <form action="/<?= $language ?>/<?= $user['username'] ?>/update-profile" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-auto">
                <div class="card">
                    <img class="card-img-top rounded border" src="<?= $avatarUrl ?>" id="avatarPreview" alt="Аватар" width="100">
                </div>
                <div class="card-body d-grid gap-2">
                    <input type="file" name="avatar" id="avatarInput" class="d-none">
                    <label for="avatarInput" class="btn btn-outline-secondary btn-sm mb-1" title="<?= __('upload_photo') ?>"><i class="bi bi-download me-2"></i><?= __('upload_photo') ?></label>
                </div>
            </div>
            <div class="col-10">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label"><?= __('name') ?></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="surname" class="col-sm-2 col-form-label"><?= __('surname') ?></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="surname" name="surname" value="<?= htmlspecialchars($user['surname']) ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label"><?= __('email') ?></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="role" class="col-sm-2 col-form-label"><?= __('role') ?></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="role" name="role" value="<?= htmlspecialchars($user['role']) ?>" disabled>
                    </div>
                </div>
                <div class="col-10 offset-2 mt-5">
                    <a href="/<?= $language ?>/<?= $user['username'] ?>/profile" class="btn btn-outline-secondary btn-sm me-1"><?= __('cancel') ?></a>
                    <button type="submit" class="btn btn-secondary btn-sm"><?= __('save_changes') ?></button>
                </div>
            </div>
        </div>
    </form>
</div>