<?php

declare(strict_types=1);

// This file contains the application settings, like the database dsn, username and password

 $settings = [
    // 'database' => [
    //     'dsn' => sprintf('sqlite:%s/var/survey.sqlite3', __DIR__),
    //     'username' => null,
    //     'password' => null,
    //     'options' => [
    //         PDO::ATTR_PERSISTENT => true,
    //     ],
    // ],

    //MySQL database example:
    
    'database' => [
        'dsn' => 'mysql:host=localhost;dbname=test_db;charset=UTF8',
        'username' => 'root',
        'password' => '',
        'options' => [
            PDO::ATTR_PERSISTENT => true,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
        ],
    ],
];
