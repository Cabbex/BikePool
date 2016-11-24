<?php
require_once __DIR__ . "/google-api-php-client-2.1.0/vendor/autoload.php";

        const CLIENT_ID = "490145815034-1ggkdb0rcrmh90v4fq74uqscsa4br3dp.apps.googleusercontent.com";
        const CLIENT_SECRET = "ShbeDdRdUcmCRBUBKGHyRRuo";
        const redirectUri = "http://localhost/BikePool/PHP/login.php";

session_start();

$client = new Google_Client;
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(redirectUri);
$client->setScopes("email");

$plus = new Google_Service_Plus($client);

if (isset($_REQUEST["logout"])) {
    session_unset();
}

if (isset($_GET["code"])) {
    $client->authenticate($_GET["code"]);
    $_SESSION["access_token"] = $client->getAccessToken();
    $redirect = "http://" . $_SERVER["Http_Host"];
    header("Location:" . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION["access_token"]) && $_SESSION["access_token"]) {
    $client->setAccessToken($_SESSION["access_token"]);
    $me = $plus->people->get("me");

    $id = $me["id"];
    $name = $me["displayName"];
} else {
    $authUrl = $client->createAuthUrl();
}
?>

<html>
    <head>
        <title>Test login</title>
    </head>
    <body>
        <?php
        if(isset($authUrl)){
        echo "<div>";
        echo"<a href='". $authUrl ."'>Login</a>";
        echo"</div>";
        }else{
            print "ID: {$id} <br>";
            print "Name {$name} <br>";
        }
        ?>
    </body>
</html>
