<?php session_start();
  
  // Saving the number of the license file to be downloaded into the global variable
  // This is to be able to return to the download page after the authentication
  if (isset($_GET['dl'])) {
   $_SESSION['dl'] = $_GET['dl'];
  }

  define('CHUNK_SIZE', 1024*1024); // Size (in bytes) of tiles chunk

  // Read a file and display its content chunk by chunk
  function readfile_chunked($filename, $retbytes = TRUE) {
    $buffer = '';
    $cnt =0;
    // $handle = fopen($filename, 'rb');
    $handle = fopen($filename, 'rb');
    if ($handle === false) {
      return false;
    }
    while (!feof($handle)) {
      $buffer = fread($handle, CHUNK_SIZE);
      echo $buffer;
      ob_flush();
      flush();
      if ($retbytes) {
        $cnt += strlen($buffer);
      }
    }
    $status = fclose($handle);
    if ($retbytes && $status) {
      return $cnt; // return num. bytes delivered like readfile() does.
    }
    return $status;
  }

  // Checking that the user is logged in
  require_once("config.inc.php");

  $adminuser = strtoupper($_COOKIE["liblogin"]);

  if ($adminuser == "") {
  header("Location: ./login.php");
  die();
  }

  $libraryquery = "SELECT library_name, libraryid FROM library WHERE library_code = \"" . $adminuser . "\"";
  $nameresult = mysql_query($libraryquery)
  or die("Query failed: " . mysql_error());

  $libraryrow = mysql_fetch_assoc($nameresult);

  $adminlibrary = $libraryrow["library_name"];
  $libraryid = $libraryrow["libraryid"];

  // Downloading the file  
  $license_number = $_GET['dl'];
  $filename       = "/apps/license/licensepdfs/license" . $license_number . ".pdf";
  $mimetype       = 'application/pdf';
  header('Content-Type: '.$mimetype );
  readfile_chunked($filename);

?>
