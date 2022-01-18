<?php

declare(strict_types=1);

function login(PDO $db, string $username, string $password): bool
{
    $sql = 'SELECT * FROM `users` WHERE username = :username';
    $stmt = $db->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            updatePassword($db, (int) $user['id'], $password);
        }

        $_SESSION['username'] = $user['username'];
        $_SESSION['userRole'] = $user['role'];
        return true;
    }

    return false;
}

function updatePassword(PDO $db, int $userId, string $password): bool
{
    $sql = 'UPDATE `users` SET `password` = :password WHERE `id` = :userId';
    return $db->prepare($sql)->execute([
        ':userId' => $userId,
        ':password' => password_hash($password, PASSWORD_DEFAULT),
    ]);
}

