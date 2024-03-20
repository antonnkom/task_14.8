<?php
define('SECONDS_PER_MINUTE', 60);
define('SECONDS_PER_HOUR', 3600);
define('SECONDS_PER_DAY', 86400);
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/data.php';

/**
 * Возвращает массив пользователей
 * @return array
 */
function getUsersList() : array
{
    $json = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/users.json');
    $users = json_decode($json, true);
    return $users ?? [];
}

/**
 * Проверка на существование пользователя
 * @param string $login
 * @return array
 */
function existsUser(string $login) : array
{
    $users = getUsersList();
    return $users[$login] ?? [];
}

/**
 * Проверка на сущетсвование пользователя и правильность введённого пароля
 * @param string $login
 * @param string $password
 * @return bool
 */
function checkPassword(string $login, string $password) : bool
{
    $user = existsUser($login);

    if ($user) {
        $hash = sha1($password);
        
        if ($user['password'] === $hash) {
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $login;
            $_SESSION['id'] = $user['id'];
            
            if (! empty($_COOKIE['timein'])) {
                $_SESSION['timein'] = $_COOKIE['timein'];
            } else {
                $timein = date('Y-m-d H:i:s');
                setcookie('timein', $timein, time() + 86400); // привязка к устройству
                $_SESSION['timein'] = $timein;
            }
        }
    }

    return $_SESSION['auth'] ?? false;
}

/**
 * Возвращает имя пользователя
 */
function getCurrentUser()
{
    $name = $_SESSION['login'] ?? null;
    return $name;
}

/**
 * Регистрация нового пользователя
 * @param string $login
 * @param string $password
 * @return bool
 */
function getRegistration(string $login, string $password) : bool
{
    $login = htmlspecialchars($login);
    $password = htmlspecialchars($password);

    $users = getUsersList();
    $users[$login] = ['id' => (string)(count($users) + 1), 'password' => sha1($password),];

    $json = json_encode($users, JSON_UNESCAPED_UNICODE);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/users.json', $json);

    $_SESSION['auth'] = true;
    $_SESSION['login'] = $login;
    $_SESSION['id'] = count($users);

    return $_SESSION['auth'] ?? false;
}

/**
 * Проверка правильности заполнения полей
 * @param array $data
 * @return string
 */
function verifyFields(array $data) : string
{
    $error = '';
    $login = htmlspecialchars($data['login']);
    $password = htmlspecialchars($data['password']);

    if (empty($login)) {
        $error = 'Не заполнено поле "Логин"';
    } elseif (empty($password)) {
        $error = 'Введите пароль';
    } elseif (! empty($data['enter'])) {
        if (! checkPassword($login, $password)) {
            $error = 'Неправильные Логин или Пароль';
        }
    } elseif (! empty($data['reg'])) {
        if (existsUser($login)) {
            $error = 'Пользователь с таким Логином уже существует';
        }
    }

    return $error;
}

/**
 * Проверка полей для даты рождения
 * @param array $data
 * @return string
 */
function verifyFieldsDate(array $data) : string
{
    $error = '';

    if (empty($data['birthday'])) {
        $error = 'Введите дату рождения';
    } elseif (empty($data['birthmonth'])) {
        $error = 'Введите месяц рождения';
    } elseif ($data['birthday'] < 1) {
        $error = 'Некорректно введена дата';
    } elseif ($data['birthday'] > 29) {
        if ($data['birthmonth'] === '2') {
            $error = 'Некорректно введена дата';
        }
    } elseif ($data['birthday'] > 30) {
        if (
            $data['birthmonth'] === '4' ||
            $data['birthmonth'] === '6' ||
            $data['birthmonth'] === '9' ||
            $data['birthmonth'] === '11'
        ) {
            $error = 'Некорректно введена дата';
        }
    }

    return $error;
}

/**
 * Редирект
 * @param string $url
 * @param int $code
 */
function getRedirect()
{
    $protocol = (! empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS'])) ? 'https://' : 'http://';
    $url = $protocol . $_SERVER['SERVER_NAME'];
    header("Location: $url", true, 301);
    exit();
}

/**
 * Таймер
 * @param string $date
 * @return string
 */
function getTimer(string $date) : string
{
    $dateEndOfAction = strtotime('+1 day', strtotime($date));
    
    $secondsRemaining = $dateEndOfAction - time();

    $hoursRemaining = floor($secondsRemaining / SECONDS_PER_HOUR);
    $secondsRemaining -= ($hoursRemaining * SECONDS_PER_HOUR);

    $minutesRemaining = floor($secondsRemaining / SECONDS_PER_MINUTE);
    $secondsRemaining -= ($minutesRemaining * SECONDS_PER_MINUTE);
    
    return "часов: $hoursRemaining, минут: $minutesRemaining, секунд: $secondsRemaining";
}

/**
 * получение форматированной даты рождения
 * @param string $date
 * @return string
 */
function formatDate(string $date) : string
{
    $monthList = [
        1  => 'января',
        2  => 'февраля',
        3  => 'марта',
        4  => 'апреля',
        5  => 'мая', 
        6  => 'июня',
        7  => 'июля',
        8  => 'августа',
        9  => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря'
    ];

    $day = date('d', strtotime($date));
    $month = date('n', strtotime($date));

    return $day . ' ' . $monthList[$month];
}

/**
 * Запись даты рождения
 * @param string $date
 */
function saveBirthday(string $date)
{
    if (! empty($_COOKIE['birthday'])) {
        $_SESSION['birthday'] = $_COOKIE['birthday'];
    } else {
        setcookie('birthday', $date, time() + 86400 * 365);
        $_SESSION['birthday'] = $date;
    }
}

/**
 * Таймер до дня рождения
 * @param string $date
 * @return string
 */
function getTimerBD(string $date) : string
{
    $y = date('Y');
    $dateBD = $date . '-' . $y;
    $now = date('d-m-Y');
    $_SESSION['sale'] = 0;

    $dateBDToTime = strtotime($dateBD);
    $nowToTime = strtotime($now);

    if ($dateBDToTime > $nowToTime) {
        $restTime = $dateBDToTime - $nowToTime;
    } elseif ($dateBDToTime < $nowToTime) {
        $dateBDToTime = strtotime('+1 year', strtotime($dateBDToTime));
        $restTime = $dateBDToTime - $nowToTime;
    } else {
        $_SESSION['sale'] = 1;
        return '<strong>C днём рождения!</strong>';
    }

    return 'Осталось дней до дня рождения: <strong>' . floor($restTime / SECONDS_PER_DAY) . '</strong>';
}

// $array = [
//     'admin' => ['id'=> '1', 'password' => sha1('P@hj&W0'),],
//     'anton' => ['id'=> '2', 'password' => sha1('jkl^89%'),],
//     'user' => ['id'=> '3', 'password' => sha1('u8kl#!23'),],
// ];
 
// $json = json_encode($array, JSON_UNESCAPED_UNICODE);
// file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/users.json', $json);
