<?php

include_once __DIR__ . '/bootstrap.php';

if ($auth->domain()->user())
{
    echo 'Добро пожаловать!';
    die;
}

?>

<a href="auth.php">авторизация</a> | <a href="reg.php">регистрация</a>
