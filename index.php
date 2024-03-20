<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/head.php';

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
                    <?php if ($auth): ?>
                        <li><a href="cabinet.php">Личный кабинет</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <div>
                <?php if ($auth) : ?>
                    <div class="login"><?= getCurrentUser() ?></div>

                    <form method="post">
                        <input name="logout" type="submit" value="Выход">
                    </form>
                <?php else : ?>
                    <a href="login.php">Вход</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="content-main">
        <section id="header">
            <div class="container">
                <?php if ($auth) : ?>
                    <p>Приветствуем, <strong><?= getCurrentUser() ?>!</strong></p>
                    <?php if (! empty($_COOKIE['birthday'])): ?>
                        <p>Ваш день рождения: <strong><?= formatDate($_COOKIE['birthday'] . '-' . date('Y')) ?></strong></p>
                        <p><?= getTimerBD($_COOKIE['birthday']) ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>

        <section id="actions">
            <div class="container">
                <h2>Акции</h2>
                <div class="actions">
                    <?php if ($auth): ?>
                        <div class="action">
                            <div class="action-photo"></div>
                            <div class="action-content">
                                <div class="action-title">Персональная акция на СПА процедуры 50% скидка</div>
                                <div class="action-price">
                                    <div class="new">5000₽</div>
                                    <div class="old"><del>10000₽</del></div>
                                </div>
                                <div class="end-date private">До конца действия акции осталось: <strong><?= getTimer($_SESSION['timein']) ?></strong></div>
                            </div>
                        </div>
                    <?php endif; ?>

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
            </div>
        </section>

        <section id="services">
            <div class="container">
                <h2>Наши услуги</h2>
                <div class="services">
                    <?php foreach ($services as $service): ?>
                        <?php
                        if (! empty($_SESSION['sale'])) {
                            $price = ceil($service['price'] * 0.95);
                        } else {
                            $price = $service['price'];
                        }
                        ?>
                        <div class="service">
                            <div class="service-title"><?= $service['name'] ?></div>
                            <div class="service-price"><?= $price ?>₽</div>
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
            </div>
        </section>
        
        <section id="gallery">
            <div class="photos">
                
            </div>
        </section>
    </main>
    
    <footer>

    </footer>

    <?php /*if ($auth): ?> // раскоментировать, чтобы запустить js-счётчик до истечения персональной акции с обратным отсчетом
        <script src="assets/script.js"></script>
    <?php endif; */?>
</body>
</html>