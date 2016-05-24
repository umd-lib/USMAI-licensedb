<?php

// basic functions and stuff
require_once("config.inc.php");

$adminuser = strtoupper($_COOKIE["liblogin"]);

if ($adminuser == "") {
header("Location: ./login.php");
die();
}

$libraryquery = "SELECT library_name, libraryid FROM library WHERE library_code
= \"" . $adminuser . "\"";
$nameresult = mysql_query($libraryquery)
  or die("Query failed: " . mysql_error());

$library_REQUEST = mysql_fetch_assoc($nameresult);

$libraryid = $library_REQUEST["libraryid"];


$new_email = mysql_real_escape_string(stripslashes($_REQUEST["email"]));

$query = "UPDATE library SET" .
	" email = \"" . $new_email . "\"" .
        " WHERE libraryid = " . $libraryid;

$result = mysql_query($query)
  or die("Query failed: " . mysql_error());

header("Location: ./admin.php");

?>

