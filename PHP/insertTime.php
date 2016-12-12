<?php

require './connection.php';
session_start();
if ($_GET["time"]) {
    try {
        $connection = getConnection();
        $sql = "UPDATE `anvandare` SET Tagtid = \"" . $_GET["time"] . "\"  WHERE Login_ID =" . $_SESSION["sub"];
        $stmt = $connection->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "InsertTime Error, meddelande = " . $e;
        echo "<br/>";
    }
    header("Location: http://casper.te4.nu/BikePool/min_sida.php?id=".$_SESSION["sub"]);
}

