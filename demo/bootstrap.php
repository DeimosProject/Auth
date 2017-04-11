<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

$config = [

    'demo' => [

        'domainCookie' => [
            'type'    => 'cookie',
            'persist' => 'domainPassword',

            'tokens' => [
                'model'   => 'token',
                'expires' => 3600 * 24 * 14
            ]
        ],

        'domainSession' => [
            'type'    => 'session',
            'persist' => 'domainPassword'
        ],

        'domainPassword' => [
            'type'  => 'password',
            'model' => 'user',

            'loginFields' => ['email', 'login'],
            'hashField'   => 'password'
        ]

    ],


    'default' => [

        'domainCookie' => [
            'type'    => 'cookie',
            'persist' => 'domainPassword',

            'tokens' => [
                'model'   => 'token',
                'expires' => 3600 * 24 * 14
            ]
        ],

        'domainSession' => [
            'type'    => 'session',
            'persist' => 'domainPassword'
        ],

        'domainPassword' => [
            'type'  => 'password',
            'model' => 'user',

            'loginFields' => ['email', 'login'],
            'hashField'   => 'password'
        ]

    ],

];

$helper = new Deimos\Helper\Helper();

$dbConfig = new \Deimos\Slice\Slice($helper, [
    'adapter'  => 'mysql',
    'database' => 'auth',
    'username' => 'root',
    'password' => 'root'
]);

$database = new \Deimos\Database\Database($dbConfig);
$orm      = new \Deimos\ORM\ORM($helper, $database);

$authConfig = new \Deimos\Slice\Slice($helper, $config);
$auth       = new \Deimos\Auth\Auth($orm, $authConfig);