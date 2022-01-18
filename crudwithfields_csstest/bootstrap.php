<?php

declare(strict_types=1);

// This file will boostrap the application.
// Because I did not use an autoloader for this example, I will initialize the application here.
// This file needs to be included in each entrypoint php file.
//
//

session_start();

// Load the application settings
require_once __DIR__ . '/settings.php';

// Initiate the database connection.
require_once __DIR__ .'/database.php';
