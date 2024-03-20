<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/head.php';

if ($auth) {
    if (! empty($_POST['save'])) {
        $data = $_POST;
        
        $errors = verifyFieldsDate($data);

        if (empty($errors)) {
            $year = date('Y');
            $dateBirthday = "{$data['birthday']}-{$data['birthmonth']}-{$year}";
            saveBirthday($data['birthday'] . '-' . $data['birthmonth']);
        } 
    }

    if (! empty($_POST['logout'])) {
        session_destroy();
        getRedirect();
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
        <div class="container header-top">
            <nav class="navbar">
                <ul>
                   <li><a href="/">Главная</a></li>
                </ul>
            </nav>
            
            <div>
               <div class="login"><?= getCurrentUser() ?></div>

                <form method="post">
                    <input name="logout" type="submit" value="Выход">
                </form>
            </div>
        </div>
    </header>

    <main class="content-main">
        <section id="header">
            <div class="container">
                <p>Приветствуем, <strong><?= getCurrentUser() ?>!</strong></p>
                <?php if (! empty($_COOKIE['birthday'])): ?>
                    <p>Ваш день рождения: <strong><?= formatDate($_COOKIE['birthday'] . '-' . date('Y')) ?></strong></p>
                    <p><?= getTimerBD($_COOKIE['birthday']) ?></p>
                <?php endif; ?>
            </div>
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
                                <div class="old"><del>10000₽</del></div>
                            </div>
                            <div class="end-date private"><strong><?= getTimer($_SESSION['timein']) ?></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php if (empty($_COOKIE['birthday'])): ?>
            <section id="settings">
                <div class="container">
                    <h2>Настройки</h2>
                    <p>Введите свою дату рождения для предоставления Вам индивидуальных скидок и подарков в день рождения.</p>
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
        <?php endif; ?>
    
    </main>
    
    <footer>

    </footer>

    <?php /*if ($auth): ?> // раскоментировать, чтобы запустить js-счётчик до истечения персональной акции с обратным отсчетом
        <script src="assets/script.js"></script>
    <?php endif; */?>
</body>
</html>
<?php 
} else {
    getRedirect();
}