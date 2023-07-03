<?php

// select function
function select(
    $field,
    $tablename,
    $condition = null
) {
    global $dbcon;
    try {
        $stmt = $dbcon->prepare("SELECT $field FROM $tablename $condition");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e;
        return null;
    }
}
