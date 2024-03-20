<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/head.php';

if ($auth) {
    if (! empty($_POST)) {
        $data = $_POST;
        
        $errors = verifyFieldsDate($data);

        if (empty($errors)) {
            $dateBirthday = "{$data['birthday']}-{$data['monthday']}";
            var_dump($dateBirthday);
        } 
    } 
?> 
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>SPA-салон</title>
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <ul>
                   <li><a href="/">Главная</a></li>
                </ul>
            </nav>
            
            <div class="login"><?= getCurrentUser() ?></div>

            <form method="post">
                <input name="logout" type="submit" value="Выход">
            </form>
        </div>
    </header>

    <main class="content-main">
        <section id="header">

        </section>

        <section id="actions">
            <div class="container">
                <div class="actions">
                    <div class="action">
                        <div class="action-photo"></div>
                        <div class="action-content">
                            <div class="action-title">Персональная акция на СПА процедуры 50% скидка</div>
                            <div class="action-price">
                                <div class="new">5000₽</div>
                                <div class="old">10000₽</del></div>
                            </div>
                            <div class="end-date"><?= getTimer($_SESSION['timein']) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="settings">
            <div class="container">
                <h2>Настройки</h2>
                <form action="cabinet.php" method="post">
                    <input name="birthday" type="number" min="1" max="31" placeholder="день рождения">
                    <select name="birthmonth">
                        <option value="1">Январь</option>
                        <option value="2">Февраль</option>
                        <option value="3">Март</option>
                        <option value="4">Апрель</option>
                        <option value="5">май</option>
                        <option value="6">Июнь</option>
                        <option value="7">Август</option>
                        <option value="8">Сентябрь</option>
                        <option value="9">Октябрь</option>
                        <option value="10">Ноябрь</option>
                        <option value="11">Декабрь</option>
                        <option value="12">Январь</option>
                    </select>
                    <input name="save" type="submit" value="Сохранить">
                </form>
                <p class="error"><?= $errors ?? ''; ?></p>
            </div>
        </section>
    
    </main>
    
    <footer>

    </footer>

    <?php if ($auth): ?>
        <script src="assets/script.js"></script>
    <?php endif; ?>
</body>
</html>
<?php 
} else {
    getRedirect();
}