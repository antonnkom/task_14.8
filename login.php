<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/head.php';

if ($auth) {
    getRedirect();
}

if (! empty($_POST)) {
    $data = $_POST;

    $errors = verifyFields($data);

    if (empty($errors)) {
        if (! empty($data['reg'])) {
            getRegistration($data['login'], $data['password']);
        }
        getRedirect();
    }
}
?>

<html>

<body>
    <form action="login.php" method="post">
        <input name="login" type="text" placeholder="Логин">
        <input name="password" type="password" placeholder="Пароль">
        <input name="enter" type="submit" value="Войти">
        <input name="reg" type="submit" value="Зарегистрироваться">
    </form>
    <p class="error"><?= $errors ?? ''; ?></p>
</body>

</html>