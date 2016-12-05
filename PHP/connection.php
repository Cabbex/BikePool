<?php
/**
 * <h1>Creates a connection to DB </h1>
 * <p>This creates a PDO connection to the Database that can be modified in this method. </p>
 *  @author Casper Björk <https://github.com/Cabbex>
 *  @return string|\PDO
 */
function getConnection(){
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bikepool";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
    }
catch(PDOException $e)
    {
    $errormessage = "Connection failed: " . $e->getMessage();
    return $errormessage;
    }
}

?>
