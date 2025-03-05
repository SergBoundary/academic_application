<h2>Новый пароль</h2>
<form action="/<?= $language ?>/password/update" method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
    <input type="password" name="password" placeholder="Введите новый пароль" required>
    <button type="submit">Обновить пароль</button>
</form>
