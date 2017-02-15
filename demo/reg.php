<?php

include_once __DIR__ . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    /**
     * @var \Deimos\Auth\Auth $auth
     */

    $password = $auth->domain()->provider('domainPassword');

    $orm->create('user', [
        'email'    => $_POST['login'] . '@deimos',
        'login'    => $_POST['login'],
        'password' => $password->hash($_POST['password'])
    ]);

}

?>

<form method="post">
    <input type="text" name="login"/>
    <input type="password" name="password"/>

    <button type="submit">send</button>
</form>
