<?php

/**
 * This block is used to suppress errors about missing variable in PHPStorm
 * @var PDO $db
 */


require_once __DIR__ . '/../bootstrap.php';

if (!isset($_SESSION['userRole'])) {
    header("Location:login.php");
    exit;
}

if ($_SESSION['userRole'] !== 'USER' && $_SESSION['userRole'] !== 'ADMIN') {
    header("Location:index.php");
    exit;
}

$errors = [];

require_once __DIR__ . '/../survey.php';
if (isset($_POST['page'])) {
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
            $id = createSurvey(
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
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => sprintf('Record with id %d has been created successfully', $id),
                'id' => $id,
            ];
        } catch (PDOException $exception) {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Could not create a new record'
            ];
        }

        header("Location:index.php?page=" . (int)$_POST['page']);
        exit;
    }
}

// Template data
$data = [
    'title' => 'Survey - Create',
    'extra_css' => [
        'overview.css',
        'create.css',
        'style.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
    ],
    'action' => 'create.php',
    'button' => 'Create',
    'currentPage' => $_GET['page'] ?? 1,
    'record' => [], // You can use this array to prefill the "create" form using the POST data.
    'errors' => $errors,
];

require_once __DIR__ . '/../templates/detail.phtml';
