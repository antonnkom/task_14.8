<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/head.php';

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
    <title>SPA-салон</title>
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar">

            </nav>
            <?php if ($auth) : ?>
                <div class="login"><?= getCurrentUser() ?></div>

                <form method="post">
                    <input name="logout" type="submit" value="Выход">
                </form>
            <?php else : ?>
                <a href="login.php">Вход</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        
            <?php if ($auth): ?>
                <p><?= getTimer('2024-03-20 01:00:00') ?></p>
                
                <div id="timer" class="timer_action">
                    <div class="countdown-number">
                        <span class="hours countdown-time"></span>
                        <span class="countdown-text">Часы</span>
                    </div>
                    <div class="countdown-number">
                        <span class="minutes countdown-time"></span>
                        <span class="countdown-text">Минуты</span>
                    </div>
                    <div class="countdown-number">
                        <span class="seconds countdown-time"></span>
                        <span class="countdown-text">Секунды</span>
                    </div>
                </div>

            <?php endif; ?>
        
    </main>
    
    <footer>

    </footer>
    <script src="script.js"></script>
</body>
</html>