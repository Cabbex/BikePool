<?php

function getConnection(){
$servername = "casper-192206.mysql.binero.se";
$username = "192206_ow69026";
$password = "_ow69026";
$dbname = "192206-casper";

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
