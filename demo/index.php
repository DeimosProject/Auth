<?php

include_once __DIR__ . '/bootstrap.php';

if ($auth->domain(isset($_GET['domain']) ? $_GET['domain'] : 'default')->user())
{
    echo 'Добро пожаловать! ', '[<a href="forgot.php">выход</a>]';

    var_dump($auth->domain(isset($_GET['domain']) ? $_GET['domain'] : 'default')->user()->asArray());
    die;
}

?>

<a href="auth.php">авторизация</a> | <a href="reg.php">регистрация</a>
