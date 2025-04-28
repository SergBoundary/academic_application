<h3><?= htmlspecialchars(__($title)) ?></h3>

<div class="container mt-2 p-4 bg-light shadow-lg">
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= __('user') ?></th>
                        <th scope="col"><?= __('email') ?></th>
                        <th scope="col" class="col-1"><?= __('research') ?></th>
                        <th scope="col" class="col-1"><?= __('discussion') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php
                        $avatarFile = !empty($user['avatar']) ? "/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
                        $avatar = $avatarFile . "?v=" . time();
                        ?>
                        <tr>
                            <td>
                                <img class="rounded-circle border" src="<?= $avatar ?>" alt="Аватар автора" width="30">
                                <a class="text-decoration-none" href="/<?= $language ?>/<?= $user['username']; ?>/profile"><?= $user['name']; ?> <?= $user['surname']; ?></a>
                            </td>
                            <td><?= $user['email']; ?></td>
                            <td class="text-end px-3"><?= $statAllUsers[$user['id']]['research']['posted'] ?></td>
                            <td class="text-end px-3"><?= $statAllUsers[$user['id']]['discussion']['posted'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>