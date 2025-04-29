<?php
$avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
$avatarUrl = $avatarFile . "?v=" . time(); // Добавляем timestamp
?>
<div class="container border mb-2 p-4 bg-body shadow">
    <form action="/<?= $language ?>/admin/users/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $user['id']; ?>">
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
                        <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="role" class="col-sm-2 col-form-label"><?= __('role') ?></label>
                    <div class="col-sm-6">
                        <select id="role" name="role" class="form-select" aria-label="Default select example">
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>><?= __('user') ?></option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>><?= __('admin') ?></option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="role" class="col-sm-2 col-form-label"><?= __('user_rights') ?></label>
                    <div class="col-sm-6 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="research" id="checkResearch" <?= isset($permissions['research']) && $permissions['research'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="checkResearch">
                                <?= __('research') ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="discussion" id="checkDiscussion" <?= isset($permissions['discussion']) && $permissions['discussion'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="checkDiscussion">
                                <?= __('discussion') ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="project" id="checkProject" <?= isset($permissions['project']) && $permissions['project'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="checkProject">
                                <?= __('project') ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-10 offset-2 mt-5">
                    <a href="/<?= $language ?>/admin/users" class="btn btn-outline-secondary btn-sm me-1"><?= __('cancel') ?></a>
                    <button type="submit" class="btn btn-secondary btn-sm"><?= __('save_changes') ?></button>
                </div>
            </div>
        </div>
    </form>
</div>