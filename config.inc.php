<?php

// database connection details
$db_username = "ermlcns";
$db_password = "";
$db_host = "localhost:/apps/license/mysql/mysql.sock";
$db_name = "ermlcns";

// database connection stuff
$conn = mysql_connect($db_host, $db_username, $db_password)
	or die("Could not connect: " . mysql_error());
mysql_select_db($db_name)
	or die("Could not select database");

?>
