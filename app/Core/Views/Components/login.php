<h2><?= htmlspecialchars($title) ?></h2>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Войти</button>
</form>
<p><a href="/register">Регистрация</a> | <a href="/password/reset">Забыли пароль?</a></p>
