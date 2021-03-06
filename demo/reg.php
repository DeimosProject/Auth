<?php

include_once __DIR__ . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    /**
     * @var \Deimos\Auth\Auth $auth
     */

    $password = $auth->domain(isset($_GET['domain']) ? $_GET['domain'] : 'default')->provider('domainPassword');

    $orm->create('user', [
        'email'    => $_POST['login'] . '@deimos',
        'login'    => $_POST['login'],
        'password' => $password->hash($_POST['password'])
    ]);

    header('location: ./');
    die;

}

?>

<form method="post">
    <input type="text" name="login"/>
    <input type="password" name="password"/>

    <button type="submit">send</button>
</form>
