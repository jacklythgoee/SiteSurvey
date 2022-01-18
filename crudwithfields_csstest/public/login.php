<?php

require_once __DIR__ . '/../bootstrap.php';

$error = null;
if (isset($_POST['username'], $_POST['password'])) {
    // Handle login request
    require_once __DIR__ . '/../auth.php';

    if (login($db, trim($_POST['username']), $_POST['password']) === true) {
        header('Location: index.php');
        exit;
    }
    $error = 'Invalid username or password';
}

// Template data
$data = [
    'title' => 'Survey - Login',
    'extra_css' => 'signin.css',
    'error' => $error,
];

require_once __DIR__ . '/../templates/login.phtml';
