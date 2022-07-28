<?php

declare(strict_types=1);

function validateSurveyData(
    string $customer_name,
    string $customer_email,
    string $customer_mobile,
    string $poNum,
    string $site_name,
    string $street1,
    string $postcode,
    string $city,
    string $county,
    string $current_machine,
    string $ordered_machine,
    ?string $q1,
    ?string $q2,
    ?string $q3,
    ?string $q4,
    ?string $q5,
    ?string $q6,
    ?string $q7,
    ?string $q8,
    ?string $q9,
    ?string $q10,
    ?string $q11,
    ?string $q12,
    string $suggestions
): array {
    $errors = [];

    // Insert some validation here. I added customer_name and customer_email required as example

    return $errors;
}

function getSurveyData(PDO $db, int $page=0): Generator
{
    --$page; // Subtract one to start with 0
    if ($page < 0) {
        $page = 0;
    }
    $startLimit = $page * 10;
    $sql = sprintf('SELECT * FROM `survey` ORDER BY `id` DESC LIMIT %d, 10', $startLimit);
    $stmt = $db->query($sql);
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        yield $row;  // Return the result directly, which is better for memory usage.
    }
}

function getSurveyPages(PDO $db): int
{
    $sql = 'SELECT count(*) AS c FROM `survey`';
    $stmt = $db->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int) ceil((int) $result['c'] / 10);
}

function getSurveyById(PDO $db, int $id): array
{
    $sql = 'SELECT * FROM `survey` WHERE `id` = :id';
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':id' => $id
    ]);

    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($record === false) {
        throw new RuntimeException('record not found');
    }

    return $record;
}

/**
 * @throws PDOException
 */
function updateSurveyById(
    PDO $db,
    int $id,
    string $customer_name,
    string $customer_email,
    string $customer_mobile,
    string $poNum,
    string $site_name,
    string $street1,
    string $postcode,
    string $city,
    string $county,
    string $current_machine,
    string $ordered_machine,
    ?string $q1,
    ?string $q2,
    ?string $q3,
    ?string $q4,
    ?string $q5,
    ?string $q6,
    ?string $q7,
    ?string $q8,
    ?string $q9,
    ?string $q10,
    ?string $q11,
    ?string $q12,
    string $suggestions
): void {
    $sql = 'UPDATE `survey` SET `customer_name` = :customer_name, `customer_email` = :customer_email, `customer_mobile` = :customer_mobile,
                                `poNum` = :poNum, `site_name` = :site_name, `street1` = :street1, `postcode` = :postcode, `city` = :city, `county` = :county,
                                `current_machine` = :current_machine, `ordered_machine` = :ordered_machine,
                                `q1` = :q1, `q2` = :q2, `q3` = :q3, `q4` = :q4, `q5` = :q5, `q6` = :q6, `q7` = :q7, `q8` = :q8, `q9` = :q9,
                                `q10` = :q10, `q11` = :q11, `q12` = :q12, `suggestions` = :suggestions, `updated_at` = :updated_at WHERE `id` = :id';
    $stmt = $db->prepare($sql);
    try {
        $db->beginTransaction();
        $stmt->execute([
            ':id' => $id,
            ':customer_name' => $customer_name,
            ':customer_email' => $customer_email,
            ':customer_mobile' => $customer_mobile,
            ':poNum' => $poNum,
            ':site_name' => $site_name,
            ':street1' => $street1,
            ':postcode' => $postcode,
            ':city' => $city,
            ':county' => $county,
            ':current_machine' => $current_machine,
            ':ordered_machine' => $ordered_machine,
            ':q1' => $q1,
            ':q2' => $q2,
            ':q3' => $q3,
            ':q4' => $q4,
            ':q5' => $q5,
            ':q6' => $q6,
            ':q7' => $q7,
            ':q8' => $q8,
            ':q9' => $q9,
            ':q10' => $q10,
            ':q11' => $q11,
            ':q12' => $q12,
            ':suggestions' => $suggestions,
            'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
        ]);
        $db->commit();
    } catch (PDOException $exception) {
        $db->rollBack();
        throw $exception;
    }
}

/**
 * @throws PDOException
 */
function deleteSurveyById(PDO $db, int $id): void
{
    $sql = 'DELETE FROM `survey` WHERE `id` = :id';
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

/**
 * @throws PDOException
 */
function createSurvey(
    PDO $db,
    string $customer_name,
    string $customer_email,
    string $customer_mobile,
    string $poNum,
    string $site_name,
    string $street1,
    string $postcode,
    string $city,
    string $county,
    string $current_machine,
    string $ordered_machine,
    ?string $q1,
    ?string $q2,
    ?string $q3,
    ?string $q4,
    ?string $q5,
    ?string $q6,
    ?string $q7,
    ?string $q8,
    ?string $q9,
    ?string $q10,
    ?string $q11,
    ?string $q12,
    string $suggestions
): int {
    $sql = 'INSERT INTO `survey` (`customer_name`, `customer_email`, `customer_mobile`, `poNum`, `site_name`, `street1`, `postcode`, `city`, `county`,
                                  `current_machine`, `ordered_machine`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `q11`, `q12`,
                                  `suggestions`, `created_at`, `updated_at`) 
                                  VALUES (:customer_name, :customer_email, :customer_mobile, :poNum, :site_name, :street1, :postcode, :city, :county, :current_machine, :ordered_machine,
                                   :q1, :q2, :q3, :q4, :q5, :q6, :q7, :q8, :q9, :q10, :q11, :q12, :suggestions,  :created_at, :updated_at)';
    $stmt = $db->prepare($sql);

    try {
        $db->beginTransaction();
        $stmt->execute([
           ':customer_name' => $customer_name,
           ':customer_email' => $customer_email,
           ':customer_mobile' => $customer_mobile,
           ':poNum' => $poNum,
           ':site_name' => $site_name,
           ':street1' => $street1,
           ':postcode' => $postcode,
           ':city' => $city,
           ':county' => $county,
           ':current_machine' => $current_machine,
           ':ordered_machine' => $ordered_machine,
           ':q1' => $q1,
           ':q2' => $q2,
           ':q3' => $q3,
           ':q4' => $q4,
           ':q5' => $q5,
           ':q6' => $q6,
           ':q7' => $q7,
           ':q8' => $q8,
           ':q9' => $q9,
           ':q10' => $q10,
           ':q11' => $q11,
           ':q12' => $q12,
           ':suggestions' => $suggestions,
           'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
           'updated_at' => (new DateTime())->format('Y-m-d H:i:s')
       ]);
        $db->commit();
        return (int)$db->lastInsertId();
    } catch (PDOException $exception) {
        $db->rollBack();
        throw $exception;
    }
}
