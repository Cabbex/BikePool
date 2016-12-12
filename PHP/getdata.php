<?php

require './connection.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
try {
    $data;
    $connection = getConnection();
    $sql = "SELECT Namn, Tillganglighet, Tagtid, ID FROM anvandare";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $resultSet = $stmt->fetchAll();
    $data = json_encode($resultSet);
    $error = json_last_error_msg();
    print_r($data);
} catch (PDOException $e) {
    echo "GetData Error, meddelande = " . $e;
    echo "<br/>";
}