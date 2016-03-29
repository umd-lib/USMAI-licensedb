<?php
// This is a function to convert date from YYYY-MM-DD to MM/DD/YYYY:
function enfmysql($date) {
        $new = explode("-",$date);
        $a=array ($new[1], $new[2], $new[0]);
        return $n_date=implode("/", $a);
}
?>

<?php

// basic functions and stuff
require_once("config.inc.php");

$thisID = $_GET['id'];

if ($thisID == "") {
header("Location: ./index.php");
die();
}

$view = $_GET['view'];
if ($view == "") {
$view = "P";
}

// print header
require_once("header.inc.php");


// echo "This license ID = [" . $thisID . "]";

$query = "SELECT license.*, library.library_name, library.library_code, library.email from library, license where license.managing_library = library.libraryid and license.id = " . $thisID;
$result = mysql_query($query)
  or die("Query failed: " . mysql_error());


while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
$id                    = $row["id"];
$e_product             = $row["e_product"];
$licensor              = $row["licensor"];
$license_date          = enfmysql($row["license_date"]);
$license_term          = $row["license_term"];
$concurrent_users      = $row["concurrent_users"];
$walkin_users          = $row["walkin_users"];
$walkin_users_note     = $row["walkin_users_note"];
$managing_library      = $row["managing_library"];
$scan_url              = $row["scan_url"];
$pubnotes              = $row["pubnotes"];
$staffnotes            = $row["staffnotes"];
$archiving_note        = $row["archiving_note"];
$arch_note_online      = $row["arch_note_online"];
$arch_note_media       = $row["arch_note_media"];
$arch_note_other       = $row["arch_note_other"];
$authusers             = $row["authusers"];
$concurrent            = $row["concurrent"];
$coursepack_note       = $row["coursepack_note"];
$cp_note_silent        = $row["cp_note_silent"];
$coursepack_print      = $row["coursepack_print"];
$coursepack_electronic = $row["coursepack_electronic"];
$cp_note_delete        = $row["cp_note_delete"];
$cp_note_permission    = $row["cp_note_permission"];
$distance              = $row["distance"];
$download_radio        = $row["download_radio"];
$download              = $row["download"];
$e_reserve             = $row["e_reserve"];
$ill_ariel             = $row["ill_ariel"];
$ill_email             = $row["ill_email"];
$ill_mailfax           = $row["ill_mailfax"];
$ill_npo               = $row["ill_npo"];
$ill_note              = $row["ill_note"];
$perpetual             = $row["perpetual"];
$perpetual_note        = $row["perpetual_note"];
$p_reserve             = $row["p_reserve"];
$print_radio           = $row["print_radio"];
$print                 = $row["print"];
$remote                = $row["remote"];
$share_radio           = $row["share_radio"];
$share                 = $row["share"];
$access_info_note      = $row["access_info_note"];
$breach_cure_period    = $row["breach_cure_period"];
$term_note             = $row["term_note"];
$library_code          = $row["library_code"];
$library_name          = $row["library_name"];
$library_email         = $row["email"];
}
mysql_free_result($result);

echo "<table border=\"0\" width=\"500\">\n";

echo "<tr bgcolor=\"#FFCC33\"><td style=\"padding: 10px 10px 10px 6px; border-bottom: 1px solid #444444\"><FONT size=3>Terms and Conditions for <strong>" . $e_product . "</strong></td></tr>\n";


echo "<tr class=\"Block\"><td style=\"border-bottom: 1px solid #444444\"><FONT size=2>Terms and conditions apply to <strong>" . $library_name . "</strong></td></tr>\n";
echo "<tr class=\"Block\"><td style=\"border-bottom: 1px solid #444444\"><FONT size=2>Vendor: <strong>" . $licensor . "</strong></td></tr>\n";


echo "<tr><td>Most electronic resources are protected by copyright and also subject to a variety of licensing restrictions on access and use.  Your campus may also have additional policies that govern the use of electronic resources.  Some important terms and restrictions for " . $e_product . " are listed below.  Please <a href=\"mailto:" . $library_email . "?subject=License info request: " . $e_product . "\"><u>ask us</u></a> for further assistance.</td></tr>\n";

// Q&A starts here

echo "<tr><td class=\"CitationTextRed\">Limitations on access</td></tr><tr><td class=\"Block\" style=\"padding-left: 14px;\">\n";

if ($concurrent_users != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Limitations on simultaneous users: </b>" . $concurrent_users . "</td></tr>\n";
}

if ($authusers != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Limitations on user groups: </b>" . $authusers . "</td></tr>\n";
}

if ($walkin_users != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Walk-in library use permitted? </b>" . $walkin_users . "</td></tr>\n";
}

if ($walkin_users_note != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Limitations on walk-in locations: </b>" . $walkin_users_note . "</td></tr>\n";
}

if ($remote != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Remote access permitted? </b>" . $remote . "</td></tr>\n";
}


echo "<tr><td></td></tr>\n<tr><td></td></tr>\n";
echo "<tr><td class=\"CitationTextRed\">Additional restrictions on usage</td></tr><tr><td class=\"Block\" style=\"padding-left: 14px;\">\n";

if ($print_radio != "" || $print != "") {
   if  ($print != "") {
      $print = '. Note: ' . $print;
   }
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Printing: </b>" . $print_radio . $print . "</td></tr>\n";
}

if ($download_radio != "" || $download != "") {
   if  ($download != "") {
      $download = '. Note: ' . $download;
   }
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Downloading: </b>" . $download_radio . $download . "</td></tr>\n";
}

if ($share_radio != "" || $share != "") {
   if  ($share != "") {
      $share = '. Note: ' . $share;
   }
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Sharing: </b>" . $share_radio . $share . "</td></tr>\n";
}

if ($access_info_note != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Other Access Restrictions: </b>" . $access_info_note . "</td></tr>\n";
}

echo "<tr><td></td></tr>\n<tr><td></td></tr>\n";
echo "<tr><td class=\"CitationTextRed\">Restrictions on library services</td></tr><tr><td class=\"Block\" style=\"padding-left: 14px;\">\n";

$ill_summary = "";
if ($ill_mailfax == "Yes") {
$ill_summary = $ill_summary . 'Print or fax. ';
}
if ($ill_email   == "Yes") {
$ill_summary = $ill_summary . 'Electronic. ';
}
if ($ill_ariel   == "Yes") {
$ill_summary = $ill_summary . 'Ariel/Odyssey. ';
}
if ($ill_note    == "Silent, US copyright law (fair use) prevails") {
$ill_summary = $ill_summary . 'Silent, US copyright law (fair use) prevails. ';
}
if ($ill_note    == "Follow CONTU guidelines") {
$ill_summary = $ill_summary . 'Follow CONTU guidelines. ';
}
if ($ill_note   == "Follow CONTU guidelines, fax only") {
$ill_summary = $ill_summary . 'Follow CONTU guidelines, print and fax only. '; 
}
if ($ill_npo    == "Yes") {
$ill_summary = $ill_summary . 'Can only lend to non-profits. '; 
}
if ($ill_note == "" && $ill_mailfax=='No' && $ill_ariel == "No" && $ill_email == "No" && $ill_npo == "No" ) {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Interlibrary Loan: </b>Prohibitted</td></tr>\n";
}
if ($ill_mailfax == "Yes" || $ill_email == "Yes"  || $ill_ariel == "Yes"  || $ill_npo == "Yes"  || $ill_note != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Interlibrary Loan: </b>Permitted</td></tr>\n";
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Interlibrary Loan Delivery: </b>" . $ill_summary . "</td></tr>\n";
}
if ($e_reserve == "Yes") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>E-reserves: </b> Permitted, delete upon cessation of use.</td></tr>\n";
}
if ($e_reserve == "No") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>E-reserves: </b> Prohibitted</td></tr>\n";
}
if ($p_reserve != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Print reserves: </b>" . $p_reserve . "</td></tr>\n";
}
if ($archiving_note != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Archiving: </b>" . $archiving_note . "</td></tr>\n";
}
if ($perpetual != "") {
   if  ($perpetual_note != "") {
      $perpetual_note = '. Note: ' . $perpetual_note;
   }
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Perpetual Access: </b>" . $perpetual . $perpetual_note . "</td></tr>\n";
}

echo "<tr><td></td></tr>\n<tr><td></td></tr>\n";
echo "<tr><td class=\"CitationTextRed\">Coursepack usage</td></tr><tr><td class=\"Block\" style=\"padding-left: 14px;\">\n";

if ($coursepack_print != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Paper coursepacks: </b>" . $coursepack_print . "</td></tr>\n";
}

if ($coursepack_electronic != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Electronic coursepacks: </b>" . $coursepack_electronic . "</td></tr>\n";
}

if ($coursepack_note != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Notes: </b>" . $coursepack_note . "</td></tr>\n";
}



echo "<tr><td></td></tr>";
echo "<tr><td class=\"CitationTextRed\">License description</td></tr><tr><td class=\"Block\" style=\"padding-left: 14px;\">\n";

if ($scan_url != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>License PDF: </b><a href=\"" . $scan_url . "\" target=\"_blank\">[License]</a></td></tr>\n";
}
if ($license_date != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Date of license: </b>" . $license_date . "</td></tr>\n";
}
if ($license_term != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Subscription/renewal term: </b>" . $license_term . "</td></tr>\n";
}
if ($library_name != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Managing library: </b>" . $library_name . "</td></tr>\n";
}

echo "<tr><td></td></tr>\n<tr><td></td></tr>\n";
echo "<tr><td class=\"CitationTextRed\">Other information</td></tr><tr><td class=\"Block\" style=\"padding-left: 14px;\">\n";
if ($breach_cure_period != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Breach instructions: </b>" . $breach_cure_period . "</td></tr>\n";
}
if ($term_note != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>General Note: </b>" . $term_note . "</td></tr>\n";
}
if ($staffnotes != "") {
echo "<tr><td class=\"Block\" style=\"padding-left: 4px;\"><b>Other: </b>" . $staffnotes . "</td></tr>\n";
}


if ($library_email != "") {
echo "<tr><td style=\"padding: 14px 4px 4px 6px; border-bottom: 1px solid #444444; font\"><a href=\"mailto:" . $library_email . "?subject=License info request: " . $e_product . "\">Request More Information about Terms and Conditions for " . $e_product . "</a></td></tr>";
}

echo "</table>\n";


mysql_close($conn);


require_once("footer.inc.php");

?>


