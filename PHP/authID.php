<?php

require_once __DIR__ . "/google-api-php-client-2.1.0/vendor/autoload.php";
require 'connection.php';

$config = __DIR__ . "/outh-credentials.json";
$client = new Google_Client;
$client->setAuthConfig($config);

if ($_GET["token"]) {
    $result = $client->verifyIdToken($_GET["token"]);
    if ($result) {
        if (checkUser($result["sub"])) {
            //Användaren finns.
            try {
                $connection = getConnection();
                $sql = "SELECT * FROM Anvandare WHERE Login_id =" . $result["sub"];
                $stmt = $connection->prepare($sql);
                $stmt->execute();
                $resultSet = $stmt->fetch();
            } catch (PDOException $exc) {
                echo "CheckUser(True) Error, Meddelande: " . $exc;
            }
            header("Location: http://localhost/BikePool/min_sida.php?id=".$result["sub"]);
        } else {
            //Användaren finns inte.
            echo "Användare finns inte";
        }
    }
}

function checkUser($sub) {

    try {
        $connection = getConnection();
        $sql = "SELECT Login_id FROM Anvandare WHERE Login_id =" . $sub;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $resultSet = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Checkuser Error, meddelande = " . $e;
    }
    if ($resultSet["Login_id"] == $sub) {
        $connection = null;
        $stmt = null;
        $resultSet = null;
        return true;
    } else {
        $connection = null;
        $stmt = null;
        $resultSet = null;
        return false;
    }
}
