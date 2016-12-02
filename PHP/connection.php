<?php

function getConnection(){
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bikepool";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    return $conn;
    }
catch(PDOException $e)
    {
    $errormessage = "Connection failed: " . $e->getMessage();
    return $errormessage;
    }
}

?>
