<h2><?= __($title) ?></h2>
<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th><?= __('role') ?></th>
        <th><?= __('user_rights') ?></th>
        <th><?= __('actions') ?></th>
    </tr>
    <?php foreach ($users as $user): ?>
        <?php 
            // Преобразуем permissions из JSON в массив, если необходимо
            $permissions = is_array($user['permissions']) ? $user['permissions'] : json_decode($user['permissions'], true);
        ?>
        <tr>
            <td><?= $user['id']; ?></td>
            <td><?= $user['email']; ?></td>
            <td><?= $user['role']; ?></td>
            <td>
                Research: <?= !empty($permissions['research']) ? '✓' : '✗' ?>,
                Discussion: <?= !empty($permissions['discussion']) ? '✓' : '✗' ?>,
                Private: <?= !empty($permissions['private']) ? '✓' : '✗' ?>
            </td>
            <td>
                <a href="/<?= $language ?>/admin/users/edit/<?= $user['id']; ?>"><?= __('edit') ?></a>
                <form method="POST" action="/<?= $language ?>/admin/users/delete" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                    <button type="submit"><?= __('delete') ?></button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
