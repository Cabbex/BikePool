<?php

/**
 * This file is for the authentication side for google currnetly. This will check if there is a user in our database with the unique ID google gives every user.
 * @author Casper Björk <https://github.com/Cabbex>
 */
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
            //Byta innan man skickar upp till webbservern
            header("Location: http://localhost/BikePool/getBasicUserProfile.php?id=" . $result["sub"]);
        } else {
            //Användaren finns inte.
            $id = getNextID();
            insertKontakt($result, $id);
            insertPosition($id);
            createUser($id, $result);
        }
    }
}

/**
 * <h1>Check if the user already exists</h1>
 * <p>Uses a SELECT question to ask if there is any data 
 * from the $sub. Returns true if there is a user, returns false if there is none</p>
 * @author Casper Björk <https://github.com/Cabbex>
 * @param Google-ID $sub
 * @return boolean
 */
function checkUser($sub) {

    try {
        $connection = getConnection();
        $sql = "SELECT Login_id FROM Anvandare WHERE Login_id =" . $sub;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $resultSet = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Checkuser Error, meddelande = " . $e;
        echo "<br/>";
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

function insertKontakt($result, $id) {
    try {
        $connection = getConnection();
        $sql = "INSERT INTO kontaktlista(Email, Nummer, Kontakt_ID) VALUES (" . $result["email"] . ",0," . $id . ")";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
    } catch (PDOException $exc) {
        echo "InsertKontakt fel - " . $exc;
        echo "<br/>";
    }
    $stmt = null;
    $connection = null;
}

function insertPosition($id) {
    try {
        $connection = getConnection();
        $sql = "INSERT INTO position (Longitude, Latitude, Positions_ID) VALUES (1,1," . $id . ")";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
    } catch (PDOException $exc) {
        echo "InsertPosition fel - " . $exc;
        echo "<br/>";
    }
    $stmt = null;
    $connection = null;
}

function getNextID() {
    try {
        $connection = getConnection();
        $sql = "SELECT Positions_ID FROM position";
        $PosStmt = $connection->prepare($sql);
        $PosStmt->execute();
        $totalUsers = $PosStmt->fetchAll();
    } catch (PDOException $exc) {
        echo "getNextID fel - ".$exc;
        echo "<br/>";
    }

    $id = count($totalUsers) + 1;
    $PosStmt = null;
    return $id;
}

function createUser($id, $result){
    try {
        $connection = getConnection();
        $sql = "INSERT INTO anvandare(ID, Namn, Tillganglighet, G_F, Tagtid, KL_ID, POS_ID, Login_ID)
            VALUES (" . $id . "," . $result["name"] . ",0,1,null," . $id . "," . $id . "," . $result["sub"] . ")";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
    } catch (PDOException $exc) {
        echo "createUser fel - ".$exc;
    }

}
