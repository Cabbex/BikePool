<?php

require './connection.php';
try {
    $data;
    $connection = getConnection();
    $sql = "SELECT Namn, Tillganglighet, Tagtid FROM anvandare";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $resultSet = $stmt->fetchAll();
    $data = json_encode($resultSet);
    $error = json_last_error_msg();
    echo $data;
} catch (PDOException $e) {
    echo "GetData Error, meddelande = " . $e;
    echo "<br/>";
}