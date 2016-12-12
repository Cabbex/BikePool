<?php

require './connection.php';
session_start();
if ($_GET["cord"]) {
    try {
        $connection = getConnection();
        $sql = "SELECT ID FROM anvandare WHERE Login_ID = " . $_SESSION["sub"];
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $resultSet = $stmt->fetch();
    } catch (PDOException $exc) {
        echo "Fel i SELECT ID " . $exc;
    }



    $id = $resultSet["ID"];
    $cords = $_GET["cord"];    
    $array = explode(":", $cords);
    $latitude = $array[0];
    $longitude = $array[1];
    $stmt = $connection->prepare("UPDATE `position` SET `Longitude`=".$longitude.",`Latitude`=".$latitude.","
            . "`Positions_ID`=".$id." WHERE Positions_ID =".$id);
    $stmt->execute();
    header("Location: http://localhost/BikePool/min_sida.php?id=" . $_SESSION["sub"]);
}


