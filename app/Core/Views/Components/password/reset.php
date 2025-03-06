<h2><?= __($title) ?></h2>
<form action="/<?= $language ?>/password/reset-request" method="post">
    <input type="email" name="email" placeholder="Введите ваш email" required>
    <button type="submit">Сбросить пароль</button>
</form>
