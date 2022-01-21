<?php

/**
 * This block is used to suppress errors about missing variable in PHPStorm
 * @var PDO $db
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

if (!isset($_SESSION['userRole'])) {
    header("Location:login.php");
    exit;
}

require_once __DIR__ . '/../survey.php';

$maxPage = getSurveyPages($db);

// Set the current page
$page = 1;
if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
}
if ($page > $maxPage) {
    $page = $maxPage;
}

// Calculate the pagination pages
$startPage = $page - 3;
if ($startPage < 1) {
    $startPage = 1;
}
$endPage = $startPage + 5;
if ($endPage > $maxPage) {
    $endPage = $maxPage;
}

// Template data
$data = [
    'title' => 'Survey - Overview',
    'extra_css' => [
        'overview.css',
        
        
    ],
    'maxPages' => getSurveyPages($db),
    'startPage' => $startPage,
    'endPage' => $endPage,
    'currentPage' => $page,
    'records' => getSurveyData($db, $page),
    'flash' => $_SESSION['flash'] ?? null,
];

// Clear flash data
if (isset($_SESSION['flash'])) {
    unset($_SESSION['flash']);
}

require_once __DIR__ . '/../templates/overview.phtml';
