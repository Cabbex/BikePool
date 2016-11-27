<?php

require_once __DIR__ . "/google-api-php-client-2.1.0/vendor/autoload.php";

$config = __DIR__ . "/outh-credentials.json";

$client = new Google_Client;
$client->setAuthConfig($config);

if ($_GET["token"]) {
    $result = $client->verifyIdToken($_GET["token"]);
    if($result){
        print var_export($result);
        echo "<br/>";
        print $result["name"]; 
        print $result["family_name"];
        print $result["email"];
        print $result["sub"];
    }
    
}
  