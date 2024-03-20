<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/head.php';

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
<head>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Dosis%3A300%2C700%2C600%7COpen%20Sans%3A300%2C300italic%2C400%2C400italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic&subset=latin%2Clatin-ext&display=swap">
</head>
<body>
    <main id="auth" class="content-auth">
        <section id="authorisation">
            <form action="login.php" method="post">
                <input name="login" type="text" placeholder="Логин">
                <input name="password" type="password" placeholder="Пароль">
                <input name="enter" type="submit" value="Войти">
                <input name="reg" type="submit" value="Зарегистрироваться">
            </form>
            <p class="error"><?= $errors ?? ''; ?></p>
        </section>

        <section id="content">
            <h2>Наши услуги</h2>
            <div class="services">
                <?php foreach ($services as $service): ?>
                    <div class="service">
                        <div class="service-title"><?= $service['name'] ?></div>
                        <div class="service-price"><?= $service['price'] ?>₽</div>
                        <div class="service-list">
                            <ul>
                                <?php foreach ($service['list'] as $list): ?>
                                    <li><?= $list ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <h2>Акции</h2>
            <div class="actions">
                <?php foreach ($actions as $action): ?>
                    <div class="action">
                        <div class="action-photo"></div>
                        <div class="action-content">
                            <div class="action-title"><?= $action['name'] ?></div>
                            <div class="action-price">
                                <div class="new"><?= $action['new_price'] ?>₽</div>
                                <div class="old"><del><?= $action['old_price'] ?>₽</del></div>
                            </div>
                            <div class="end-date">Действуе до <?= $action['date'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="photos">
                
            </div>
        </section>
    </main>
</body>

</html>