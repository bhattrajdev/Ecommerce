<?php
// update function
function update($tablename, array $data, $condition)
{
    global $dbcon;
    try {

        $setClause = implode(', ', array_map(function ($key) {
            return $key . '=:' . $key;
        }, array_keys($data)));

        $stmt = $dbcon->prepare("UPDATE $tablename SET $setClause WHERE $condition");
        $stmt->execute($data);

        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
