<?php

include_once __DIR__ . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    /**
     * @var \Deimos\Auth\Auth $auth
     */

    $password = $auth->domain()->provider('domainPassword');
    $password->login($_POST['login'], $_POST['password']);
    $auth->domain()->provider('domainCookie')->persist();
    die;
}

?>

<form method="post">
    auth
    <input type="text" name="login"/>
    <input type="password" name="password"/>

    <button type="submit">send</button>
</form>
