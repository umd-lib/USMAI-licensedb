<?php

// basic functions and stuff
require_once("config.inc.php");

setcookie("liblogin", "", time() - 3600);
header("Location: ./login.php");
die();

?>

