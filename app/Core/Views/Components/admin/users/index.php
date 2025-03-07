<h2><?= __($title) ?></h2>
<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th><?= __('role') ?></th>
        <th><?= __('actions') ?></th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id']; ?></td>
            <td><?= $user['email']; ?></td>
            <td><?= $user['role']; ?></td>
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
