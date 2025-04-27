<?php
$avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
$avatarUrl = $avatarFile . "?v=" . time(); // Добавляем timestamp
?>
<div class="container p-4 bg-light shadow-lg">
    <div class="row">
        <div class="col-auto">
            <div class="card">
                <img class="card-img-top rounded border" src="<?= $avatarUrl ?>" alt="Аватар" width="100">
            </div>
            <div class="card-body d-grid gap-2">
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $user['id']): ?>
                    <a href="/<?= $language ?>/<?= $user['username'] ?>/edit-profile" class="btn btn-outline-secondary btn-sm mb-1" title="<?= __('edit_profile') ?>"><i class="bi bi-pencil-fill me-2"></i><?= __('edit_profile') ?></a>
                    <form action="/<?= $language ?>/<?= $user['username'] ?>/delete-account" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить аккаунт?');">
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete_account') ?>');" title="<?= __('delete_account') ?>"><i class="bi bi-trash3-fill me-2"></i><?= __('delete_account') ?></button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-10">
            <div class="mb-3 row">
                <div class="col-2"><?= __('name') ?></div>
                <div class="col-10">
                    <?= htmlspecialchars($user['name']) ?>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2"><?= __('surname') ?></div>
                <div class="col-10">
                    <?= htmlspecialchars($user['surname']) ?>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2"><?= __('email') ?></div>
                <div class="col-10">
                    <?= htmlspecialchars($user['email']) ?>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2"><?= __('role') ?></div>
                <div class="col-10">
                    <?= htmlspecialchars($user['role']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-2 p-4 bg-light shadow-lg">
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="col-auto"><?= __('category') ?></th>
                        <th scope="col" class="col-1"><?= __('created') ?></th>
                        <th scope="col" class="col-1"><?= __('liked') ?></th>
                        <th scope="col" class="col-1"><?= __('disliked') ?></th>
                        <th scope="col" class="col-1"><?= __('shared') ?></th>
                        <th scope="col" class="col-1"><?= __('bookmarked') ?></th>
                        <th scope="col" class="col-1"><?= __('subscribed') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a class="text-decoration-none" href="/<?= $language ?>/<?= $user['username'] ?>/research"><?= __('research') ?></a></td>
                        <td class="text-end px-3"><?= $statUserResearchPost['posted'] ?></td>
                        <td class="text-end px-3"><?= $statUserResearchPost['liked'] ?></td>
                        <td class="text-end px-3"><?= $statUserResearchPost['disliked'] ?></td>
                        <td class="text-end px-3"><?= $statUserResearchPost['shared'] ?></td>
                        <td class="text-end px-3"><?= $statUserResearchPost['bookmarked'] ?></td>
                        <td class="text-end px-3"><?= $statUserResearchPost['subscribed'] ?></td>
                    </tr>
                    <tr>
                        <td><a class="text-decoration-none" href="/<?= $language ?>/<?= $user['username'] ?>/discussion"><?= __('discussion') ?></a></td>
                        <td class="text-end px-3"><?= $statUserDiscussionPost['posted'] ?></td>
                        <td class="text-end px-3"><?= $statUserDiscussionPost['liked'] ?></td>
                        <td class="text-end px-3"><?= $statUserDiscussionPost['disliked'] ?></td>
                        <td class="text-end px-3"><?= $statUserDiscussionPost['shared'] ?></td>
                        <td class="text-end px-3"><?= $statUserDiscussionPost['bookmarked'] ?></td>
                        <td class="text-end px-3"><?= $statUserDiscussionPost['subscribed'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $user['id']): ?>
    <div class="container mt-2 p-4 bg-light shadow-lg">
        <div class="row">
            <form action="/<?= $language ?>/<?= $user['username'] ?>/send-message" method="POST">
                <div class="mb-3">
                    <label for="content" class="form-label"><?= __('contact_admin') ?></label>
                    <textarea class="form-control" name="message" id="content" rows="3" placeholder="<?= __('enter_your_message') ?>" required></textarea>
                </div>
                <div class="float-end">
                    <button type="submit" class="btn btn-secondary btn-sm"><?= __('send') ?></button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>