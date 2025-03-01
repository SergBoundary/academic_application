<h1>Список пользователей</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id']; ?></td>
            <td><?= $user['email']; ?></td>
            <td><?= $user['role']; ?></td>
            <td>
                <a href="/admin/users/edit/<?= $user['id']; ?>">Редактировать</a>
                <form method="POST" action="/admin/users/delete" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
