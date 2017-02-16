<?php

include_once __DIR__ . '/bootstrap.php';

if ($auth->domain()->user())
{
    $auth->domain()->forgetUser();

    header('location: ./');
    die;
}

echo 'Вы не авторизованы!';