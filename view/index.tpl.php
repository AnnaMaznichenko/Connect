<!doctype html>
<head>
</head>

<body>
    <h3><b>Авторизация</b></h3>
    <form method="post">
        <p>Логин: <input type="text" name="login" value="<?= !empty($user->login) ? $user->login : ""?>"></p>
        <?php if (!empty($errors["login"])): ?>
            <div class="error"><?= $errors["login"]; ?></div>
        <?php endif ?>
        <p>Пароль: <input type="password" name="password" value="<?= !empty($user->password) ? $user->password : ""?>"></p>
        <?php if (!empty($errors["password"])): ?>
            <div class="error"><?= $errors["password"]; ?></div>
        <?php endif ?>
        <p><input type="submit" name="send_form" value="Авторизоваться"></input></p>
        <?php if (!empty($send_form) && empty($errors)): ?>
            <div class="success"><?= "Привет, " . $user->login . "!"?></div>
        <?php endif ?>
        <p><a href="/ae/register.php">Зарегистрироваться</a><p>
    </form>
</body>