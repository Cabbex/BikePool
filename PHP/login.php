<!--
Not in use!!
->

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

if (isset($_REQUEST["logout"])) {
    session_unset();
}

if (isset($_GET["code"])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
    $client->setAccessToken($token);

    $_SESSION["id_token_token"] = $token;
}

if (!empty($_SESSION["id_token_token"]) && isset($_SESSION["id_token_token"])) {
    $client->setAccessToken($_SESSION["id_token_token"]);
} else {
    $authUrl = $client->createAuthUrl();
}

if ($client->getAccessToken()) {
    $token_data = $client->verifyIdToken();
}
?>
<html>
    <head>
        <title>Test login</title>
    </head>
    <body>
        <?php
        if (isset($authUrl)) {
            echo "<div>";
            echo"<a href='" . $authUrl . "'>Login</a>";
            echo"</div>";
        } else {
            echo "<p>ID_Token: </p>";
            print var_export($token_data);
            print $token_data[1][0];
            echo "<br/>";
            echo "<a href='?logout'>Logga ut</a>";
        }
        ?>
    </body>
</html>
