<?php

require 'connection.php';

//Skaffar den datan som en vanlig användare har.
if ($_GET["id"]) {
    try {
        $connection = getConnection();
        $sql = "SELECT ID, Namn, Tillganglighet, Tagtid, KL_ID, Login_ID, Email, Nummer, Kontakt_ID 
        FROM anvandare, kontaktlista 
        WHERE anvandare.Login_ID = " . $_GET["id"] . " AND anvandare.KL_ID = kontaktlista.Kontakt_ID";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $resultSet = $stmt->fetch();
    } catch (PDOException $exc) {
        echo "<strong>Nu har det blivit fel!"
        . " Skicka denna koden till en av programmerarna på github så löser vi det -> </strong><br/>" . $exc;
        $detblevfel = true;
    }
} else{
    header("Location: http://localhost/BikePool/index.php");
}
//Fyller i variablar som sedan används för att skriva ut datan på sidan.
    $name = $resultSet["Namn"];
    $email = $resultSet["Email"];
    $nummer = $resultSet["Nummer"];
    if ($resultSet["Tillganglighet"] == 1) {
        echo $ready = true;
    } else {
        echo $ready = false;
    }