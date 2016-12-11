<?php
session_start();
$_SESSION["loggedIn"] = false;
header("Location: http://casper.te4.nu/BikePool/index.php");
