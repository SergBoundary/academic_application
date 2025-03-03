<h2><?= htmlspecialchars($title) ?></h2>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>
<form method="POST">
    <input type="text" name="name" placeholder="Имя" required>
    <input type="text" name="surname" placeholder="Фамилия">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Зарегистрироваться</button>
</form>
