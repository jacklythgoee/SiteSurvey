<?php

declare(strict_types=1);

function getGuestByHash(PDO $db, string $hash): array
{
    $sql = 'SELECT * FROM guests WHERE `hash` = :hash';
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':hash' => $hash
    ]);

    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($record === false) {
        throw new RuntimeException('record not found');
    }

    return $record;
}

function removeHashFromGuest(PDO $db, int $id): void
{
    $sql = 'UPDATE `guests` SET hash = "" WHERE `id` = :id';
    $stmt = $db->prepare($sql);
    try {
        $db->beginTransaction();
        $stmt->execute([':id' => $id]);
        $db->commit();
    } catch (PDOException $exception){
        $db->rollBack();
        throw $exception;
    }
}
