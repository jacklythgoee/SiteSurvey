<?php

declare(strict_types=1);

// This file contains the application settings, like the database dsn, username and password

 $settings = [
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
