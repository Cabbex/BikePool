<?php
session_start();
$_SESSION["loggedIn"] = false;
header("Location: http://localhost/BikePool/index.php");
