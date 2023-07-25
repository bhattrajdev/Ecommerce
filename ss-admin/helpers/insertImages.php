<?php

function insertImages($tablename, array $data, $condition = null)
{
    global $dbcon;
    try {
        foreach ($data['name'] as $image) {
            $fields = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $insertData = [
                'product_id' => $data['product_id'],
                'name' => $image
            ];

            $stmt = $dbcon->prepare("INSERT INTO $tablename ($fields) VALUES ($placeholders)");
            $stmt->execute($insertData);
        }
    } catch (PDOException $e) {
        echo $e;
    }
}
