<?php

// basic functions and stuff
require_once("config.inc.php");

$adminuser = strtoupper($_COOKIE["liblogin"]);

if ($adminuser == "") {
header("Location: ./login.php");
die();
}

$libraryquery = "SELECT library_name, libraryid FROM library WHERE library_code = \"" . $adminuser .
 "\"";
$nameresult = mysql_query($libraryquery)
  or die("Query failed: " . mysql_error());

$libraryrow = mysql_fetch_assoc($nameresult);

$adminlibrary = $libraryrow["library_name"];
$libraryid = $libraryrow["libraryid"];

// print header
require_once("header.inc.php");


echo "<h2>Welcome.  You are administering licenses for " . $adminlibrary . ".</h2>";
echo "<p>(Not " . $adminuser . "? Please <a href=\"logout.php\">sign in again</a>)</p>";

?>
<hr>

<p><a href="addedit.php">Add a New License</a></p>

<?php
$licensequery = "SELECT id, e_product FROM license WHERE managing_library = " . $libraryid ." ORDER by e_product";
$result = mysql_query($licensequery)
  or die("Query failed: " . mysql_error());

if (mysql_num_rows($result) > 0) {
        echo "<form name=\"addedit\" method=\"POST\" action=\"addedit.php\">";
        echo "<p>Edit License: <select name=\"licenseid\">";
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
          echo "<option name=\"id\" value=\"" . $row["id"] . "\">" . $row["e_product"] . "</option>\
n" ;
        }
        echo "</select><input type=\"submit\" name=\"submit\" value=\"Go\"></form>";
}
echo "<hr />";

$emailquery = "SELECT email from library where libraryid = " . $libraryid;
$emailresult = mysql_query($emailquery)
  or die("Query failed: " . mysql_error());

echo "<p>E-mail contact for license questions for " . $adminlibrary . ":<br />";
echo "<form name=\"editemail\" method=\"POST\" action=\"email_process.php\">";
echo "<input type=\"text\" name=\"email\" value=\"" . mysql_result($emailresult, 0) . "\" size=\"40\" maxlength=\"80\">";
echo "<input type=\"submit\" name=\"submit\" value=\"Change\"></form></p>";
  
echo "<hr />";  

mysql_close($conn);


require_once("footer.inc.php");

?>

