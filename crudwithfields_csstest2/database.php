<?php

declare(strict_types=1);

// This file contains every thing needed to create a database connection.
// We use PDO because it can work with MySQL and SQLite (used in this example).

if (!isset($settings) || !array_key_exists('database', $settings)) {
    throw new Exception('database configuration does not exist');
}

try {
    $db = new PDO(
        $settings['database']['dsn'],
        $settings['database']['username'],
        $settings['database']['password'],
        $settings['database']['options']
    );
} catch (PDOException $exception) {
    die($exception->getMessage());
}
