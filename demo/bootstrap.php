<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

$request->queryBetween('a', 1, 20);

$config = [

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

$builder = new Deimos\Builder\Builder();

$dbConfig = new \Deimos\Config\ConfigObject($builder, [
    'adapter'  => 'mysql',
    'database' => 'test',
    'username' => 'root',
    'password' => 'root'
]);

$database = new \Deimos\Database\Database($dbConfig);
$orm      = new \Deimos\ORM\ORM($builder, $database);

$authConfig = new \Deimos\Config\ConfigObject($builder, $config);
$auth       = new \Deimos\Auth\Auth($orm, $authConfig);