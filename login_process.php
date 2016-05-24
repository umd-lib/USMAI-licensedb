<?php session_start();

// basic functions and stuff
require_once("config.inc.php");

$s_username = $_REQUEST["username"];
$s_password = $_REQUEST["password"];


$query = "SELECT * from library where library_code = \"" . $s_username . "\" AND pword = \"" . $s_password ."\"";
$result = mysql_query($query)
  or die("Query failed: " . mysql_error());

if (mysql_num_rows($result) == 0 ) {
 header("Location: ./login.php?msg=1");
 die();
} else {
 setcookie("liblogin", $s_username);
 if(isset($_SESSION['dl'])) {
  $myheader = "Location: ./file_retrieve.php?dl=" . $_SESSION['dl'];
  header($myheader);
 } else {
  header("Location: ./admin.php");
 }
die();
}

?>

