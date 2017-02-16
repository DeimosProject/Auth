<?php

include_once __DIR__ . '/bootstrap.php';

if ($auth->domain(isset($_GET['domain']) ? $_GET['domain'] : 'default')->user())
{
    $auth->domain(isset($_GET['domain']) ? $_GET['domain'] : 'default')->forgetUser();

    header('location: ./');
    die;
}

echo 'Вы не авторизованы!';