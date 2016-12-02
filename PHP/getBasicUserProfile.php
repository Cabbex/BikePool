<?php

require 'connection.php';


$connection = getConnection();
$sql = "SELECT * FROM Anvandare WHERE Login_id =".$_GET["id"];
$stmt = $connection->prepare($sql);
$stmt->execute();
$resultSet = $stmt->fetch();

$name = $resultSet["Namn"];
if($resultSet["Tillganglighet"] == 1){
    $ready = true;
} else {
    $ready = false;
}