<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col">
            <h4 class="mb-4"><?= $mapPath['active'] ?></h4>
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="col-1">ID</th>
                        <th scope="col"><?= __('user') ?></th>
                        <th scope="col"><?= __('email') ?></th>
                        <th scope="col" class="col-1"><?= __('role') ?></th>
                        <th scope="col" colspan="3"><?= __('user_rights') ?></th>
                        <th scope="col" class="col-1"><?= __('actions') ?></th>
                    </tr>
                    <tr>
                        <th scope="col" class="col-1"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col" class="col-1"></th>
                        <th scope="col" class="col-1"><?= __('research') ?></th>
                        <th scope="col" class="col-1"><?= __('discussion') ?></th>
                        <th scope="col" class="col-1"><?= __('project') ?></th>
                        <th scope="col" class="col-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php
                        // Преобразуем permissions из JSON в массив, если необходимо
                        $permissions = is_array($user['permissions']) ? $user['permissions'] : json_decode($user['permissions'], true);
                        ?>
                        <tr>
                            <td><?= $user['id']; ?></td>
                            <td><a class="text-decoration-none" href="/<?= $language ?>/<?= $user['username']; ?>/profile"><?= $user['name']; ?> <?= $user['surname']; ?></a></td>
                            <td><?= $user['email']; ?></td>
                            <td><?= $user['role']; ?></td>
                            <td>
                                <?= !empty($permissions['research']) ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' ?>
                            </td>
                            <td>
                                <?= !empty($permissions['discussion']) ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' ?>
                            </td>
                            <td>
                                <?= !empty($permissions['project']) ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' ?>
                            </td>
                            <td>
                                <a href="/<?= $language ?>/admin/users/edit/<?= $user['id']; ?>" class="btn btn-outline-warning btn-sm" title="<?= __('edit') ?>"><i class="bi bi-pencil-fill"></i></a>
                                <form method="POST" action="/<?= $language ?>/admin/users/delete" class="d-inline-block">
                                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete') ?>');" title="<?= __('delete') ?>"><i class="bi bi-trash3-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>