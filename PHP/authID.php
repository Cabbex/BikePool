<?php

require_once __DIR__ . "/google-api-php-client-2.1.0/vendor/autoload.php";
require 'connection.php';
$config = __DIR__ . "/outh-credentials.json";
$client = new Google_Client;
$client->setAuthConfig($config);

if ($_GET["token"]) {
    $result = $client->verifyIdToken($_GET["token"]);
    if($result){
            print var_export($result);
            echo "<br/>";
            print $result["name"];
            echo "<br/>";
            print $result["family_name"];
            echo "<br/>";
            print $result["email"];
            echo "<br/>";
            print $result["sub"];
            if (checkUser($result["sub"])){
                echo "det funkar";
            } else {
                echo "det funkar inte";
            }
    }
    
}


function checkUser($sub){
    try{
    $connection = getConnection();
    $sql = "SELECT Login_id FROM Anvandare WHERE Login_id =". $sub;
    $stmt = $connection->prepare($sql);
    $stmt->bindColumn(":sub", $sub);
    $stmt->execute();
    } catch (PDOException $e){
        echo "Checkuser fail 1 ".$e;
    }
    print var_export($stmt);
    echo "<br/>";   
    if(isset($stmt)){
        return false;
    } else {
        return true;
    }
    
}