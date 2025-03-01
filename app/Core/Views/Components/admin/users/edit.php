<h1>Редактирование пользователя</h1>
<form method="POST" action="/admin/users/update">
    <input type="hidden" name="id" value="<?= $user['id']; ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= $user['email']; ?>" required>

    <label>Роль</label>
    <select name="role">
        <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
    </select>

    <button type="submit">Сохранить</button>
</form>
