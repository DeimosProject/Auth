<?php

include_once __DIR__ . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    /**
     * @var \Deimos\Auth\Auth $auth
     */

    $password = $auth->domain(isset($_GET['domain']) ? $_GET['domain'] : 'default')->provider('domainPassword');
    $password->login($_POST['login'], $_POST['password']);

    $provider = isset($_POST['withCookie']) ? 'domainCookie' : 'domainSession';

    $auth->domain(isset($_GET['domain']) ? $_GET['domain'] : 'default')->provider($provider)->persist();

    header('location: ./');
    die;
}

?>

<form method="post">
    auth
    <input type="text" name="login"/>
    <input type="password" name="password"/>

    <input type="checkbox" name="withCookie">

    <button type="submit">send</button>
</form>
