<?php

/**
 * This file is for the authentication side for google currnetly. This will check if there is a user in our database with the unique ID google gives every user.
 * @author Casper Björk <https://github.com/Cabbex>
 */
require_once __DIR__ . "/google-api-php-client-2.1.0/vendor/autoload.php";
require 'connection.php';
session_start();
$config = __DIR__ . "/outh-credentials.json";
$client = new Google_Client;
$client->setAuthConfig($config);
if ($_GET["token"]) {
    $result = $client->verifyIdToken($_GET["token"]);
    print var_export($result);
    if ($result) {
        if (checkUser($result["sub"])) {
            //Användaren finns.
            $_SESSION["loggedIn"] = true;
            header("Location: http://localhost/BikePool/min_sida.php?id=" . $result["sub"]);
        } else {
            //Användaren finns inte.
            $id = getNextID();
            insertKontakt($result, $id);
            insertPosition($id);
            createUser($id, $result);
            $_SESSION["loggedIn"] = true;
            header("Location: http://localhost/BikePool/min_sida.php?id=" . $result["sub"]);
        }
    } else {
        echo "fail verifyToken";
    }
} else {
    echo "Fail get token";
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
        $sql = "SELECT Login_id FROM anvandare WHERE Login_id =" . $sub;
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
/**
 * <h1>Insert Kontakt </h1>
 * <p>Will handle the creations of new users. Inserts the users Email only.</p>
 * @param type $result
 * @param type $id
 */
function insertKontakt($result, $id) {
    try {
        $connection = getConnection();
        $sql = "INSERT INTO kontaktlista(Email, Nummer, Kontakt_ID) VALUES (\"" . $result["email"] . "\",0," . $id . ")";
        $stmt = $connection->prepare(stripslashes($sql));
        $stmt->execute();
    } catch (PDOException $exc) {
        echo "InsertKontakt fel - " . $exc;
        echo "<br/>";
    }
    $stmt = null;
    $connection = null;
}
/**
 * <h1>Insert Position </h1>
 * <p>Will handle the creations of new users. Inserts nothing of importens. Is only to hold up a spot. </p>
 * @param type $id
 */
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
/**
 * <h1>Gets the next id in database </h1>
 * <p>Will return the next aveilble ID from the database. </p>
 * @return type
 */
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
/**
 * <h1>Creates the user</h1>
 * <p>Will create most of the user but nothing different from the other instert methods. </p>
 * @param type $id
 * @param type $result
 */
function createUser($id, $result){
    try {
        $connection = getConnection();
        $sql = "INSERT INTO anvandare(ID, Namn, Tillganglighet, G_F, Tagtid, KL_ID, POS_ID, Login_ID)
            VALUES (" . $id . ",\"" . $result["name"] . "\",0,1,0," . $id . "," . $id . ",\"" . $result["sub"] . "\")";
        $stmt = $connection->prepare(stripslashes($sql));
        $stmt->execute();
    } catch (PDOException $exc) {
        echo "createUser fel - ".$exc;
    }
}
