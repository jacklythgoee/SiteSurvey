<?php

/**
 * This block is used to suppress errors about missing variable in PHPStorm
 * @var PDO $db
 */

require_once __DIR__ . '/../bootstrap.php';

if (isset($_SESSION['userRole'])) {
    $_SESSION['flash'] = [
        'type' => 'warning',
        'message' => 'Using the "Guest" page is not allowed while being logged in',
    ];
    header("Location:index.php");
    exit;
}

require_once __DIR__ . '/../guest.php';
require_once __DIR__ . '/../survey.php';

$errors = [];

try {
    $hash = $_GET['hash'] ?? 'invalid';    // A empty string is not valid hash
    $guest = getGuestByHash($db, $hash);
} catch (RuntimeException $exception) {
    $data = [
        'error' => 'Guest access is not allowed without a valid hash'
    ];
    require_once __DIR__ . '/../templates/error.phtml';
    exit;
}

if (isset($_POST['hash'])) {
    $errors = validateSurveyData(
        $_POST['customer_name'] ?? '',
        $_POST['customer_email'] ?? '',
        $_POST['customer_mobile'] ?? '',
        $_POST['poNum'] ?? '',
        $_POST['site_name'] ?? '',
        $_POST['street1'] ?? '',
        $_POST['postcode'] ?? '',
        $_POST['city'] ?? '',
        $_POST['county'] ?? '',
        $_POST['current_machine'] ?? '',
        $_POST['ordered_machine'] ?? '',
        $_POST['q1'] ?? '',
        $_POST['q2'] ?? '',
        $_POST['q3'] ?? '',
        $_POST['q4'] ?? '',
        $_POST['q5'] ?? '',
        $_POST['q6'] ?? '',
        $_POST['q7'] ?? '',
        $_POST['q8'] ?? '',
        $_POST['q9'] ?? '',
        $_POST['q10'] ?? '',
        $_POST['q11'] ?? '',
        $_POST['q12'] ?? '',
        $_POST['suggestions'] ?? ''
    );

    if (count($errors) === 0) {
        // No errors, create the record.
        try {
            createSurvey(
                $db,
                $_POST['customer_name'],
                $_POST['customer_email'],
                $_POST['customer_mobile'],
                $_POST['poNum'],
                $_POST['site_name'],
                $_POST['street1'],
                $_POST['postcode'],
                $_POST['city'],
                $_POST['county'],
                $_POST['current_machine'],
                $_POST['ordered_machine'],
                $_POST['q1'] ?? '',
                $_POST['q2'] ?? '',
                $_POST['q3'] ?? '',
                $_POST['q4'] ?? '',
                $_POST['q5'] ?? '',
                $_POST['q6'] ?? '',
                $_POST['q7'] ?? '',
                $_POST['q8'] ?? '',
                $_POST['q9'] ?? '',
                $_POST['q10'] ?? '',
                $_POST['q11'] ?? '',
                $_POST['q12'] ?? '',
                $_POST['suggestions']
            );

            removeHashFromGuest($db, (int) $guest['id']);

            // This should have been a redirect to a "thank you" page.
            $data = [
                'type' => 'success',
                'error' => 'Thank you for filling out our survey'
            ];
            require_once __DIR__ . '/../templates/error.phtml';
            exit;

        } catch (PDOException $exception) {
            $data = [
                'type' => 'danger',
                'error' => 'Something went wrong while saving the survey. Please try again.'
            ];
            require_once __DIR__ . '/../templates/error.phtml';
            exit;
        }
    }
}

// Template data
$data = [
    'title' => 'Survey - Create',
    'extra_css' => [
        'create.css',
        'style.css',
        'https://use.fontawesome.com/releases/v5.15.4/css/all.css'
    

    ],
    'action' => 'guest.php?hash=' . $hash,
    'button' => 'Create',
    'hash' => $guest['hash'],
    'record' => [],
    'errors' => $errors,
];
require_once __DIR__ . '/../templates/header.phtml';
require_once __DIR__ . '/../templates/detail.phtml';

// guest link
// http://localhost/guest.php?hash=hash
