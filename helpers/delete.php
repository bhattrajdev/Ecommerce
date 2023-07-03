<!-- delete from table where id = $id -->
<?php
function delete($tablename, $key, $id)
{
    global $dbcon;
    try {
        $stmt = $dbcon->prepare("DELETE FROM $tablename WHERE $key = $id");
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e;
    }
}
