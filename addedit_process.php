<!--
<?php
print "<pre>";
print_r($_POST);
print "</pre>";
?>
-->

<?php
// This is a function to convert date from MM/DD/YYYY to YYYY-MM-DD :
function entomysql($date) {
        $new = explode("/",$date);
        $a=array ($new[2], $new[0], $new[1]);
        return $n_date=implode("-", $a);
}
?>

<?php

// basic functions and stuff
require_once("config.inc.php");

$adminuser = strtoupper($_COOKIE["liblogin"]);

if ($adminuser == "") {
header("Location: ./login.php");
die();
}

$libraryquery = "SELECT library_name, libraryid FROM library WHERE library_code = \"" . $adminuser . "\"";
$nameresult = mysql_query($libraryquery)
  or die("Query failed: " . mysql_error());

$library_REQUEST = mysql_fetch_assoc($nameresult);

$adminlibrary = $library_REQUEST["library_name"];
$libraryid = $library_REQUEST["libraryid"];

$thisID = $_REQUEST["id"];
if ($thisID == "" ) {
        // add new
        $action = "add";
} else {
        // edit
        $action = "edit";
}
        $e_product             = mysql_real_escape_string(stripslashes($_REQUEST["e_product"]));
        $licensor              = mysql_real_escape_string(stripslashes($_REQUEST["licensor"]));
        $license_date          = mysql_real_escape_string(stripslashes($_REQUEST["license_date"]));
        $managing_library      = mysql_real_escape_string(stripslashes($_REQUEST["managing_library"]));
        $license_term          = mysql_real_escape_string(stripslashes($_REQUEST["license_term"]));
        $concurrent_users      = mysql_real_escape_string(stripslashes($_REQUEST["concurrent_users"]));
        $walkin_users          = mysql_real_escape_string(stripslashes($_REQUEST["walkin_users"]));
        $walkin_users_note     = mysql_real_escape_string(stripslashes($_REQUEST["walkin_users_note"]));
        $pubnotes              = mysql_real_escape_string(stripslashes($_REQUEST["pubnotes"]));
        $staffnotes            = mysql_real_escape_string(stripslashes($_REQUEST["staffnotes"]));
        $archiving_note        = "";
        $arch_note_online      = mysql_real_escape_string(stripslashes($_REQUEST["arch_note_online"]));
        $arch_note_media       = mysql_real_escape_string(stripslashes($_REQUEST["arch_note_media"]));
        $arch_note_other       = mysql_real_escape_string(stripslashes($_REQUEST["arch_note_other"]));
        $authusers             = mysql_real_escape_string(stripslashes($_REQUEST["authusers"]));
        $concurrent            = mysql_real_escape_string(stripslashes($_REQUEST["concurrent"]));
        $coursepack_note       = "";
        $cp_note_silent        = mysql_real_escape_string(stripslashes($_REQUEST["cp_note_silent"]));
        $coursepack_print      = mysql_real_escape_string(stripslashes($_REQUEST["coursepack_print"]));
        $coursepack_electronic = mysql_real_escape_string(stripslashes($_REQUEST["coursepack_electronic"]));
        $cp_note_delete        = mysql_real_escape_string(stripslashes($_REQUEST["cp_note_delete"]));
        $cp_note_permission    = mysql_real_escape_string(stripslashes($_REQUEST["cp_note_permission"]));
        $distance              = mysql_real_escape_string(stripslashes($_REQUEST["distance"]));
        $download_radio        = mysql_real_escape_string(stripslashes($_REQUEST["download_radio"]));
        $download              = mysql_real_escape_string(stripslashes($_REQUEST["download"]));
        $e_reserve             = mysql_real_escape_string(stripslashes($_REQUEST["e_reserve"]));
        $ill_ariel             = mysql_real_escape_string(stripslashes($_REQUEST["ill_ariel"]));
        $ill_email             = mysql_real_escape_string(stripslashes($_REQUEST["ill_email"]));
        $ill_mailfax           = mysql_real_escape_string(stripslashes($_REQUEST["ill_mailfax"]));
        $ill_npo               = mysql_real_escape_string(stripslashes($_REQUEST["ill_npo"]));
        $ill_note              = mysql_real_escape_string(stripslashes($_REQUEST["ill_note"]));
        $perpetual             = mysql_real_escape_string(stripslashes($_REQUEST["perpetual"]));
        $perpetual_note        = mysql_real_escape_string(stripslashes($_REQUEST["perpetual_note"]));
        $p_reserve             = mysql_real_escape_string(stripslashes($_REQUEST["p_reserve"]));
        $print_radio           = mysql_real_escape_string(stripslashes($_REQUEST["print_radio"]));
        $print                 = mysql_real_escape_string(stripslashes($_REQUEST["print"]));
        $remote                = mysql_real_escape_string(stripslashes($_REQUEST["remote"]));
        $share_radio           = mysql_real_escape_string(stripslashes($_REQUEST["share_radio"]));
        $share                 = mysql_real_escape_string(stripslashes($_REQUEST["share"]));
        $access_info_note      = mysql_real_escape_string(stripslashes($_REQUEST["access_info_note"]));
        $breach_cure_period    = mysql_real_escape_string(stripslashes($_REQUEST["breach_cure_period"]));
        $term_note             = mysql_real_escape_string(stripslashes($_REQUEST["term_note"]));
	$publisher             = mysql_real_escape_string(stripslashes($_REQUEST["publisher"]));
	$alumni_users          = mysql_real_escape_string(stripslashes($_REQUEST["alumni_users"]));
	$link_radio            = mysql_real_escape_string(stripslashes($_REQUEST["link_radio"]));
	$link                  = mysql_real_escape_string(stripslashes($_REQUEST["link"]));
	$cancel                = mysql_real_escape_string(stripslashes($_REQUEST["cancel"]));
	$cancel_days           = mysql_real_escape_string(stripslashes($_REQUEST["cancel_days"]));
        
// Setting variables based on the checkbox status after the submission

if (isset($_POST['submit'])) {

	if(isset($_POST['ch_unlimited_usage'])) {
		if ($_POST['ch_unlimited_usage'] == 'on') {
			$concurrent_users = 'Unlimited';
		}
	}

	if(isset($_POST['walkin_users'])) {
		if ($_POST['walkin_users'] == 'Yes') {
			$walkin_users = 'Yes';
		}
		else if ($_POST['walkin_users'] == 'No') {
			$walkin_users = 'No';
		}
	}

	if(isset($_POST['remote'])) {
		if ($_POST['remote'] == 'Yes') {
			$remote = 'Yes';
		}
		else if ($_POST['remote'] == 'No') {
			$remote = 'No';
		}
	}


// ALUMNI USERS
	if(isset($_POST['alumni_users'])) {
		if ($_POST['alumni_users'] == 'Yes') {
			$alumni_users = 'Yes';
		}
		else if ($_POST['alumni_users'] == 'No') {
			$alumni_users = 'No';
		}
		else if ($_POST['alumni_users'] == 'Silent') {
			$alumni_users = 'Silent';
		}
	}	
	
// ILL

	if(isset($_POST['ill_Print_fax'])) {
		if ($_POST['ill_Print_fax'] == 'on') {
			$ill_mailfax = 'Yes';
		}
	} else {$ill_mailfax = 'No';}

	if(isset($_POST['ill_Email'])) {
		if ($_POST['ill_Email'] == 'on') {
			$ill_email = 'Yes';
		}
	} else {$ill_email = 'No';}

	if(isset($_POST['ill_Ariel_Odyssey'])) {
		if ($_POST['ill_Ariel_Odyssey'] == 'on') {
			$ill_ariel = 'Yes';
		}
	} else {$ill_ariel = 'No';}

	if(isset($_POST['ill_NPO'])) {
		if ($_POST['ill_NPO'] == 'on') {
			$ill_npo = 'Yes';
		}
	} else {$ill_npo = 'No';}

	if(isset($_POST['ill_License_silent'])) {
		if ($_POST['ill_License_silent'] == 'on') {
			$ill_note = 'Silent, US copyright law (fair use) prevails';
		}
	} else if(isset($_POST['ill_CONTU'])) {
		if ($_POST['ill_CONTU'] == 'on') {
			$ill_note = 'Follow CONTU guidelines';
		}
	} else if(isset($_POST['ill_CONTU_fax'])) {
		if ($_POST['ill_CONTU'] == 'on') {
			$ill_note = 'Follow CONTU guidelines';
		}
	} else {$ill_note = '';}

// E-reserves

	if(isset($_POST['e_reserve'])) {
		if ($_POST['e_reserve'] == 'Yes') {
			$e_reserve = 'Yes';
		}
		else if ($_POST['e_reserve'] == 'No') {
			$e_reserve = 'No';
		}
		else if ($_POST['e_reserve'] == 'Silent') {
			$e_reserve = 'Silent';
		}
	}

// Coursepack
	if(isset($_POST['cp_silent'])) {
		if ($_POST['cp_silent'] == 'on') {
			$cp_note_silent  = 'License silent, US copyright (fair use) law prevails.';
		}
	} else { $cp_note_silent = ''; }

	if(isset($_POST['cp_print'])) {
		if ($_POST['cp_print'] == 'on') {
			$coursepack_print = 'Yes';
		}
	} else {$coursepack_print = 'No';}

	if(isset($_POST['cp_electronic'])) {
		if ($_POST['cp_electronic'] == 'on') {
			$coursepack_electronic = 'Yes';
		}
	} else {$coursepack_electronic = 'No';}

	if(isset($_POST['cp_delete'])) {
		if ($_POST['cp_delete'] == 'on') {
			$cp_note_delete  = 'Delete upon cessation of use.';
		}
	} else { $cp_note_delete = ''; }

	if(isset($_POST['cp_permission'])) {
		if ($_POST['cp_permission'] == 'on') {
			$cp_note_permission = 'Seek permission from publisher.';
			$coursepack_note = $coursepack_note . " " . $cp_note_permission;
		}
	} else { $cp_note_permission = ''; }

	if(isset($_POST['cp_none'])) {
		if ($_POST['cp_none'] == 'on') {
			$coursepack_note = 'No';
		}
	} else { $coursepack_note = $cp_note_silent . " " . $cp_note_delete . " " . $cp_note_permission; }


// Archiving
	if(isset($_POST['arch_online'])) {
		if ($_POST['arch_online'] == 'on') {
			$arch_note_online = 'Yes, LOCKSS, Portico, or other shared online archive.';
		}
	}

	if(isset($_POST['arch_media'])) {
		if ($_POST['arch_media'] == 'on') {
			$arch_note_media = 'Yes, Upon cancellation in DVD-ROM or other appropriate media.';
		}
	}

	if(isset($_POST['arch_none'])) {
		if ($_POST['arch_none'] == 'on') {
			$archiving_note = 'No';
		}
	} else $archiving_note = $arch_note_other . " " . $arch_note_online . " " . $arch_note_media;

// Perpetual rights
	if(isset($_POST['perpetual'])) {
		if ($_POST['perpetual'] == 'Yes') {
			$perpetual = 'Yes';
		}
		else if ($_POST['perpetual'] == 'No') {
			$perpetual = 'No';
		}
	}

// Additional Use Restrictions Notes
	if(isset($_POST['download_radio'])) {
		if ($_POST['download_radio'] == 'Permitted') {
			$download_radio = 'Permitted';
		}
		else if ($_POST['download_radio'] == 'Prohibited') {
			$download_radio = 'Prohibited';
		}
		else if ($_POST['download_radio'] == 'Silent') {
			$download_radio = 'Silent';
		}
	}

	if(isset($_POST['share_radio'])) {
		if ($_POST['share_radio'] == 'Permitted') {
			$share_radio = 'Permitted';
		}
		else if ($_POST['share_radio'] == 'Prohibited') {
			$share_radio = 'Prohibited';
		}
		else if ($_POST['share_radio'] == 'Silent') {
			$share_radio = 'Silent';
		}
	}

	if(isset($_POST['print_radio'])) {
		if ($_POST['print_radio'] == 'Permitted') {
			$print_radio = 'Permitted';
		}
		else if ($_POST['print_radio'] == 'Prohibited') {
			$print_radio = 'Prohibited';
		}
		else if ($_POST['print_radio'] == 'Silent') {
			$print_radio = 'Silent';
		}
	}
	
	if(isset($_POST['link_radio'])) {
		if ($_POST['link_radio'] == 'Permitted') {
			$link_radio = 'Permitted';
		}
		else if ($_POST['link_radio'] == 'Prohibited') {
			$link_radio = 'Prohibited';
		}
		else if ($_POST['link_radio'] == 'Silent') {
			$link_radio = 'Silent';
		}
	}
// Trimming blank spaces around the textbox content
        $e_product           = trim($e_product);
        $licensor            = trim($licensor);
        $license_date        = trim($license_date);
        $license_term        = trim($license_term);
        $concurrent_users    = trim($concurrent_users);
        $authusers           = trim($authusers);
        $walkin_users_note   = trim($walkin_users_note);
        $arch_note_other     = trim($arch_note_other);
        $coursepack_note     = trim($coursepack_note);
        $perpetual_note      = trim($perpetual_note);
        $download            = trim($download);
        $share               = trim($share);
        $print               = trim($print);
        $access_info_note    = trim($access_info_note);
        $breach_cure_period  = trim($breach_cure_period);
        $term_note           = trim($term_note);
	$publisher           = trim($publisher);
	$link                = trim($link);
	$cancel_days         = trim($cancel_days);
	$cancel              = trim($cancel);
}

if ($action == "edit") {

$query = "UPDATE license SET" .
        " e_product = \"" . $e_product . "\"," .
        " licensor = \"" . $licensor . "\"," .
        " license_date = \"" . entomysql($license_date) . "\"," .
        " license_term = \"" . $license_term . "\"," .
        " concurrent_users = \"" . $concurrent_users . "\"," .
        " walkin_users = \"" . $walkin_users . "\"," .
        " walkin_users_note = \"" . $walkin_users_note . "\"," .
        " managing_library = " . $managing_library . "," .
        " pubnotes = \"" . $pubnotes . "\"," .
        " staffnotes = \"" . $staffnotes . "\"," .
        " archiving_note = \"" . $archiving_note . "\"," .
        " arch_note_online = \"" . $arch_note_online . "\"," .
        " arch_note_media = \"" . $arch_note_media . "\"," .
        " arch_note_other = \"" . $arch_note_other . "\"," .
        " authusers = \"" . $authusers . "\"," .
        " concurrent = \"" . $concurrent . "\"," .
        " coursepack_note = \"" . $coursepack_note . "\"," .
        " cp_note_silent = \"" . $cp_note_silent . "\"," .
        " coursepack_print = \"" . $coursepack_print . "\"," .
        " coursepack_electronic = \"" . $coursepack_electronic . "\"," .
        " cp_note_delete = \"" . $cp_note_delete . "\"," .
        " cp_note_permission = \"" . $cp_note_permission . "\"," .
        " distance = \"" . $distance . "\"," .
        " download_radio = \"" . $download_radio . "\"," .
        " download = \"" . $download . "\"," .
        " e_reserve = \"" . $e_reserve . "\"," .
        " ill_ariel = \"" . $ill_ariel . "\"," .
        " ill_email = \"" . $ill_email . "\"," .
        " ill_mailfax = \"" . $ill_mailfax . "\"," .
        " ill_npo = \"" . $ill_npo . "\"," .
        " ill_note = \"" . $ill_note . "\"," .
        " perpetual = \"" . $perpetual . "\"," .
        " perpetual_note = \"" . $perpetual_note . "\"," .
        " p_reserve = \"" . $p_reserve . "\"," .
        " print_radio = \"" . $print_radio . "\"," .
        " print = \"" . $print . "\"," .
        " access_info_note = \"" . $access_info_note . "\"," .
        " breach_cure_period = \"" . $breach_cure_period . "\"," .
        " term_note = \"" . $term_note . "\"," .
        " remote = \"" . $remote . "\"," .
	" publisher = \"" . $publisher . "\"," .
	" alumni_users = \"" . $alumni_users . "\"," .
	" link_radio = \"" . $link_radio . "\"," .
	" link = \"" . $link . "\"," .
	" cancel = \"" . $cancel . "\"," .
	" cancel_days = \"" . $cancel_days . "\"," .
        " share_radio = \"" . $share_radio . "\"," .
        " share = \"" . $share . "\"" .
        " WHERE id = " . $thisID;

}

if ($action == "add") {
$query = "INSERT into license (e_product, licensor, license_date, license_term, concurrent_users, walkin_users, walkin_users_note, managing_library, pubnotes, staffnotes, archiving_note, arch_note_online, arch_note_media, arch_note_other, authusers, concurrent, coursepack_note, cp_note_silent, coursepack_print, coursepack_electronic, cp_note_delete, cp_note_permission, distance, download_radio, download, e_reserve, ill_ariel, ill_email, ill_mailfax, ill_npo, ill_note, perpetual, perpetual_note, p_reserve, print_radio, print, access_info_note, breach_cure_period, term_note, remote, publisher, alumni_users, link_radio, link, cancel, cancel_days, share_radio, share) VALUES (\"" .
$e_product . "\",\"" .
$licensor . "\",\"" .
entomysql($license_date) . "\",\"" .
$license_term . "\",\"" .
$concurrent_users . "\",\"" .
$walkin_users . "\",\"" .
$walkin_users_note . "\",\"" .
$managing_library . "\",\"" .
$pubnotes . "\",\"" .
$staffnotes . "\",\"" .
$archiving_note . "\",\"" .
$arch_note_online . "\",\"" .
$arch_note_media . "\",\"" .
$arch_note_other . "\",\"" .
$authusers . "\",\"" .
$concurrent . "\",\"" .
$coursepack_note . "\",\"" .
$cp_note_silent . "\",\"" .
$coursepack_print . "\",\"" .
$coursepack_electronic . "\",\"" .
$cp_note_delete . "\",\"" .
$cp_note_permission . "\",\"" .
$distance  . "\",\"" .
$download_radio . "\",\"" .
$download . "\",\"" .
$e_reserve . "\",\"" .
$ill_ariel . "\",\"" .
$ill_email . "\",\"" .
$ill_mailfax . "\",\"" .
$ill_npo . "\",\"" .
$ill_note . "\",\"" .
$perpetual . "\",\"" .
$perpetual_note . "\",\"" .
$p_reserve . "\",\"" .
$print_radio . "\",\"" .
$print . "\",\"" .
$access_info_note . "\",\"" .
$breach_cure_period . "\",\"" .
$term_note . "\",\"" .
$remote . "\",\"" .
$publisher . "\",\"" .
$alumni_users . "\",\"" .
$link_radio . "\",\"" .
$link . "\",\"" .
$cancel . "\",\"" .
$cancel_days . "\",\"" .
$share_radio . "\",\"" .
$share . "\")" ;

}

//echo $query;

$result = mysql_query($query)
  or die("Query failed: " . mysql_error());


if ($action == "add") {
	echo "<p>You just added record number: " . mysql_insert_id() . "</p>";
	$thisID = mysql_insert_id();
} else {
	echo "<p>Record " . $thisID . " Updated</p>";
}



// Now we can handle the file--since we want to rename it to the license ID

$uploaddir = '/apps/license/licensepdfs/';
if ($_FILES['licensefile']['name'] != "") {
	$uploadfile = $uploaddir . "license" . $thisID . ".pdf" ;
	$scan_url = "http://license.lib.umd.edu/file_retrieve.php?dl=" . $thisID;
	
	if ((strtolower(substr($_FILES['licensefile']['name'], strlen($_FILES['licesnefile']['name'])-4)) == ".pdf") && (move_uploaded_file($_FILES['licensefile']['tmp_name'], $uploadfile))) {
		echo "File is valid, and was successfully uploaded.\n";
		$queryscan = "UPDATE license SET scan_url = \"" . $scan_url . "\" WHERE id = " . $thisID;
		$resultscan = mysql_query($queryscan)
			or die("Query failed: " . mysql_error());

	} else {
		echo "<p>License file not valid.  The license record was added/updated, but the file was not uploaded.</p>\n";
		print_r($_FILES);
		echo "<p>File Ext:[" . substr($_FILES['licensefile']['name'], strlen($_FILES['licensefile']['name'])-4) . "]</p>";
	}
}

echo "<p>Public view of this license: <a href=\"license.php?id=" . $thisID . "\">http://" .$_SERVER["SERVER_NAME"] . str_replace("addedit_process.php","",$_SERVER["PHP_SELF"]) . "license.php?id=" . $thisID . "</a></p>";

//echo "<p>Staff view of this license: <a href=\"license.php?id=" . $thisID . "&view=S\">http://" .$_SERVER["SERVER_NAME"] . str_replace("addedit_process.php","",$_SERVER["PHP_SELF"]) . "license.php?id=" . $thisID . "&view=S</a></p>";


echo "<p><a href=\"admin.php\">Back to License Administration</a></p>";



mysql_close($conn);

require_once("footer.inc.php");

?>

