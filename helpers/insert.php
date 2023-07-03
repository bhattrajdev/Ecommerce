<?php
function insert($tablename, array $data)
{
    global $dbcon;
    try {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $stmt = $dbcon->prepare("INSERT INTO $tablename ($fields) VALUES ($placeholders)");
        $stmt->execute($data);

        return $dbcon->lastInsertId();
        // return $stmt->rowCount();
    } catch (PDOException $e) {
        echo $e;
    }
}
