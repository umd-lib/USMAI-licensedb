<!--
<?php session_start();
print "<pre>";
print_r($_SESSION);
print "</pre>";
?>
-->

<?php

// basic functions and stuff
require_once("config.inc.php");

// print header
require_once("header.inc.php");

//print_r($_COOKIE);
?>

<p>Please enter your login credentials to enter the USMAI License Information Database:</p>

<?php
if ($_GET['msg'] == 1) {
echo "<p><span style=\"color: red;\">Incorrect entry.  Please try again:</span></p>";
}
?>

<form name="login" method="POST" action="login_process.php">
<table border="0">
<tr>
<td align="right">Username:</td><td><input name="username" length="30" maxlength="30"></td>
</tr><tr>
<td align="right">Password:</td><td><input type="password" name="password" length="30" maxlength="30"></td>
</tr><tr>
<td colspan="2" align="center"><input type="submit" name="submit" value="submit"></td>
</tr>

</form> 

<?php

require_once("footer.inc.php");

?>
