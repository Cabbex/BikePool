<?php

require './connection.php';
session_start();
if ($_GET["cord"]) {
    $connection = getConnection();
    $sql = "SELECT ID FROM anvandare WHERE Login_ID = ".$_SESSION["sub"];
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $resultSet = $stmt->fetch();
    
    $id = $resultSet["ID"];
    $cords = $_GET["cord"];    
    $stmt = $connection->prepare("UPDATE `position` SET `Longitude`=[value-1],`Latitude`=[value-2],`Positions_ID`=[value-3] WHERE");
}


