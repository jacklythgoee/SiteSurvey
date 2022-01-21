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

if ($_SESSION['userRole'] !== 'ADMIN') {
    header("Location:index.php");
    exit;
}

if (!isset($_GET['id'])) {
    $data = [
        'redirect' => 'index.php?page=' . ($_GET['page'] ?? 1),
        'error' => 'Cannot delete a unknown entity'
    ];
    require_once __DIR__ . '/../templates/error.phtml';
    exit;
}
$id = (int) $_GET['id'];

require_once __DIR__ . '/../survey.php';

try {
    $record = getSurveyById($db, (int) $id);
} catch (RuntimeException $exception) {
    $data = [
        'redirect' => 'index.php?page=' . ($_GET['page'] ?? 1),
        'error' => ucfirst($exception->getMessage()),
    ];
    require_once __DIR__ . '/../templates/error.phtml';
    exit;
}

try {
    deleteSurveyById($db, $id);
    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => sprintf('Record with id %d has been deleted successfully', $id),
    ];
} catch (PDOException $exception) {
    $_SESSION['flash'] = [
        'type' => 'danger',
        'message' => sprintf('Could not delete record with %d', $id),
    ];
}

header("Location:index.php?page=" . ($_GET['page'] ?? 1));
exit;


