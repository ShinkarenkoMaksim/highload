<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<? if ($auth): ?>
    <a href="/info">Инфо</a> <br>
    <?= $username ?> <a href="/user/logout/"> [Выход]</a>
<? else: ?>
    <h3>Авторизация</h3>
    <form action="/user/login/" method="post">
        <label for="login">Ваш e-mail</label>
        <input id="login" type="email" name="login" placeholder="e-mail"><br><br>
        <label for="pass">Ваш пароль</label>
        <input id="pass" type="password" name="pass" placeholder="Пароль"><br><br>
        <input type="submit" name="submit" value="Войти">
    </form>
    <br><br>

    <h3>Авторизация Redis</h3>
    <form action="/userredis/login/" method="post">
        <label for="login">Ваш e-mail</label>
        <input id="login" type="email" name="login" placeholder="e-mail"><br><br>
        <label for="pass">Ваш пароль</label>
        <input id="pass" type="password" name="pass" placeholder="Пароль"><br><br>
        <input type="submit" name="submit" value="Войти">
    </form>
    <br><br>

    <a href="/register">Регистрация</a>

<? endif; ?><br>

</body>
</html>