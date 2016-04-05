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

$thisID = $_REQUEST["licenseid"];
if ($thisID == "" ) {
        // add new
        $action = "new";
} else {
        // edit
        $action = "edit";
}

// print header
require_once("header.inc.php");


//print_r($_REQUEST);
//echo "this id =[" . $thisID . "]<br />";

if ($action == "edit") {
        $licensequery = "SELECT * FROM license WHERE id = " . $thisID;
        $result = mysql_query($licensequery)
          or die("Query failed: " . mysql_error());
        $row = mysql_fetch_array($result, MYSQL_ASSOC);

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
//      $archiving_note        = $row["archiving_note"];
        $arch_note_online      = $row["arch_note_online"];
        $arch_note_media       = $row["arch_note_media"];
        $arch_note_other       = $row["arch_note_other"];
        $authusers             = $row["authusers"];
        $concurrent            = $row["concurrent"];
//      $coursepack_note       = $row["coursepack_note"];
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
	$publisher			   = $row["publisher"];
	$alumni_users		   = $row["alumni_users"];
	$link_radio            = $row["link_radio"];
	$link                  = $row["link"];
	$cancel                = $row["cancel"];
	$cancel_days           = $row["cancel_days"];
	$links = "<p>Public view of this license: <a href=\"license.php?id=" . $thisID . "\">http://" .$_SERVER["SERVER_NAME"] . str_replace("addedit.php","",$_SERVER["PHP_SELF"]) . "license.php?id=" . $thisID;
        #$links = "<p>Public view of this license: <a href=\"license.php?id=" . $thisID . "\">http://" .$_SERVER["SERVER_NAME"] . str_replace("addedit.php","",$_SERVER["PHP_SELF"]) . "license.php?id=" . $thisID . "</a></p><p>Staff view of this license: <a href=\"license.php?id=" . $thisID . "&view=S\">http://" .$_SERVER["SERVER_NAME"] . str_replace("addedit.php","",$_SERVER["PHP_SELF"]) . "license.php?id=" . $thisID . "&view=S</a></p>";
        echo "<h2>Editing license " . $thisID . ": " . $e_product . ".</h2>";

} else {
        $e_product             = "";
	$licensor              = "";
	$license_date          = NULL;
	$license_term          = "";
	$concurrent_users      = "";
	$walkin_users          = "";
	$walkin_users_note     = "";
        $managing_library      = $libraryid;
        $scan_url              = "";
        $pubnotes              = "";
        $staffnotes            = "";
        $archiving_note        = "";
        $arch_note_online      = "";
        $arch_note_media       = "";
        $arch_note_other       = "";
        $authusers             = "";
        $concurrent            = "";
        $coursepack_note       = "";
        $cp_note_silent        = "";
	$coursepack_print      = "";
	$coursepack_electronic = "";
        $cp_note_delete        = "";
        $cp_note_permission    = "";
        $distance              = "";
        $download_radio        = "";
        $download              = "";
        $e_reserve             = "";
        $ill_ariel             = "";
        $ill_email             = "";
        $ill_mailfax           = "";
        $ill_npo               = "";
        $ill_note              = "";
        $perpetual             = "";
        $perpetual_note        = "";
        $p_reserve             = "";
        $print_radio           = "";
        $print                 = "";
        $remote                = "";
        $share_radio           = "";
        $share                 = "";
	$access_info_note      = "";
	$breach_cure_period    = "";
	$publisher			   = "";
	$alumni_users		   = "";
	$link_radio            = "";
	$link                  = "";
	$cancel                = "";
	$cancel_days           = "";
	$term_note             = "";
        $links                 = "";
        echo "<h2>Adding New License.</h2>";
}


if ($scan_url == "") {
        $filemsg = "<strong>License PDF:</strong><br />";
        $filehelp = "(Optional)";
} else {
        $filemsg = "<strong>License PDF to <em>REPLACE</em> Current PDF:</strong><br />";
        $filehelp = "(Leave blank to keep <a href=\"" . $scan_url . "\">current PDF</a>)";
}

?>


<table border="0" width="450">
<tr><td>

<hr>

<form enctype="multipart/form-data" name="adde_reserveedit" method="POST" action="addedit_process.php">
<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />

<input name="id" type="hidden" value="<?php echo $thisID; ?>">

<!-- ***************** -->
<!-- Form fields begin -->
<!-- ***************** -->

<p><font size="2"><strong>E-resource: </strong> <?php if($e_product == ""){echo 'New entry';} else {echo $e_product;}?></font></p>
<p><font size="2"><strong>Managing library: </strong> <?php echo $adminlibrary; ?></font></p>
<input name="managing_library" type="hidden" value="<?php echo $managing_library; ?>">

<?php echo $filemsg ?><input name="licensefile" type="file" /><br /><?php echo $filehelp ?>

<hr>
<br />
<p align="center"><strong>Fields for Public Display</strong></p>
<fieldset><legend>License Name</legend><textarea cols="50" rows="1" name="e_product"><?php echo $e_product; ?></textarea></fieldset>
<fieldset><legend>Vendor/Agent</legend><textarea cols="50" rows="1" name="licensor"><?php echo $licensor; ?></textarea></fieldset>
<fieldset><legend>Publisher</legend><textarea cols="50" rows="1" name="publisher"><?php echo $publisher; ?></textarea></fieldset>
<fieldset><legend>Date of license (in MM/DD/YYYY format)</legend><textarea cols="50" rows="1" name="license_date"><?php echo $license_date; ?></textarea></fieldset>
<fieldset><legend>Subscription/Renewal term</legend><textarea cols="50" rows="1" name="license_term"><?php echo $license_term; ?></textarea></fieldset>
<br />


<!-- License Type -->

<p align="center"><strong>License Type</strong></p>
<br />

<!-- Unlimited checkbox -->
<Input type='Checkbox' name='ch_unlimited_usage' id='ch_unlimited_usage' 
onClick="document.getElementById('walkin_users_yes').checked  = (this.checked)?1:0;
         document.getElementById('remote_access_yes').checked = (this.checked)?1:0;
         document.getElementById('concurrent_users').disabled = (this.checked)?1:0"
         <?php if($concurrent_users == "Unlimited"){echo" CHECKED";}?>>Unlimited simultaneous users (e.g. campus wide)
<br />

<br />
<fieldset><legend>Limited number of simultaneous users</legend><textarea cols="50" rows="3" name="concurrent_users" id="concurrent_users">
<?php echo $concurrent_users; ?></textarea></fieldset>
<fieldset><legend>Limitations on user groups</legend><textarea cols="50" rows="3" name="authusers" id="authusers">
<?php echo $authusers; ?></textarea></fieldset>
<br />
<legend>Walk-in Users:</legend><br>
<Input type = 'Radio' name='walkin_users' id='walkin_users_yes' value = 'Yes' onclick="document.getElementById('walkin_users_note').disabled=false"
<?php if($walkin_users == "Yes"){echo" CHECKED";}?>>Yes<br />
<Input type = 'Radio' name='walkin_users' id='walkin_users_no'  value = 'No'  onclick="document.getElementById('walkin_users_note').disabled=true"
<?php if($walkin_users == "No") {echo" CHECKED";}?>>No<br />
<br />
<br />
<fieldset><legend>Limitations on walk-in locations (e.g. single-site)</legend><textarea cols="50" rows="3" name="walkin_users_note" id="walkin_users_note">
<?php echo $walkin_users_note; ?></textarea></fieldset>
<br />
<legend>Alumni Users:</legend><br>
<Input type = 'Radio' name='alumni_users' id='alumni_users_yes' value = 'Yes'
<?php if($alumni_users == "Yes"){echo" CHECKED";}?>>Yes<br />
<Input type = 'Radio' name='alumni_users' id='alumni_users_no'  value = 'No'
<?php if($alumni_users == "No") {echo" CHECKED";}?>>No<br />
<Input type = 'Radio' name='alumni_users' id='alumni_users_silent' value = 'Silent'
<?php if($alumni_users == "Silent") {echo" CHECKED";}?>>Silent<br />
<br />
<legend>Remote Access:</legend><br>
<Input type = 'Radio' name ='remote' id='remote_access_yes' value= 'Yes' 
<?php if($remote == "Yes"){echo" CHECKED";}?>>Yes<br />
<Input type = 'Radio' name ='remote' id='remote_access_no'  value= 'No' 
<?php if($remote == "No") {echo" CHECKED";}?>>No<br />
<br />

<hr>

<p align="center"><strong>Fields for Staff Display</strong></p>

<!-- ILL -->
<p align="center"><strong>ILL</strong></p>
<Input type = 'Checkbox' Name ='ill_Print_fax'      id="ill_Print_fax"      onclick="document.getElementById('ill_none').checked = false" 
<?php if($ill_mailfax == "Yes"){echo" CHECKED";}?>>Print/fax<br />
<Input type = 'Checkbox' Name ='ill_Email'          id="ill_Email"          onclick="document.getElementById('ill_none').checked = false" 
<?php if($ill_email   == "Yes"){echo" CHECKED";}?>>Email/Electronic<br />
<Input type = 'Checkbox' Name ='ill_Ariel_Odyssey'  id="ill_Ariel_Odyssey"  onclick="document.getElementById('ill_none').checked = false" 
<?php if($ill_ariel   == "Yes"){echo" CHECKED";}?>>Secure Transmission<br />
<Input type = 'Checkbox' Name ='ill_NPO'            id="ill_NPO"            onclick="document.getElementById('ill_none').checked = false" 
<?php if($ill_npo     == "Yes"){echo" CHECKED";}?>>Can only lend to non-profits<br />

<Input type = 'Checkbox' Name ='ill_License_silent' id="ill_License_silent" onclick="
document.getElementById('ill_none').checked           = false;
document.getElementById('ill_CONTU').checked          = false;
document.getElementById('ill_CONTU_fax').checked      = false;" 
<?php if($ill_note    == "Silent, US copyright law (fair use) prevails"){echo" CHECKED";}?>
>License silent, US Copyright law (fair use) prevails<br />

<Input type = 'Checkbox' Name ='ill_CONTU'          id="ill_CONTU"          onclick="if(this.checked) {
document.getElementById('ill_Print_fax').checked      = true;
document.getElementById('ill_Email').checked          = false;
document.getElementById('ill_Ariel_Odyssey').checked  = true;
document.getElementById('ill_License_silent').checked = false;
document.getElementById('ill_CONTU').checked          = true;
document.getElementById('ill_CONTU_fax').checked      = false;
document.getElementById('ill_none').checked           = false}" 
<?php if($ill_note == 'Follow CONTU guidelines' && $ill_mailfax == "Yes" && $ill_ariel == "Yes"){echo" CHECKED";}?>
>Follow CONTU guidelines<br />

<Input type = 'Checkbox' Name ='ill_CONTU_fax'      id="ill_CONTU_fax"      onclick="if(this.checked) {
document.getElementById('ill_Print_fax').checked      = true;
document.getElementById('ill_Email').checked          = false;
document.getElementById('ill_Ariel_Odyssey').checked  = false;
document.getElementById('ill_License_silent').checked = false;
document.getElementById('ill_CONTU').checked          = false;
document.getElementById('ill_CONTU_fax').checked      = true;
document.getElementById('ill_none').checked           = false}" 
<?php if($ill_note == 'Follow CONTU guidelines' && $ill_mailfax=='Yes' && $ill_ariel == "No"){echo" CHECKED";}?>
>Follow CONTU guidelines, fax only<br />

<Input type = 'Checkbox' Name ='ill_check'          id="ill_none"           onclick="if(this.checked) {
document.getElementById('ill_Print_fax').checked      = false;
document.getElementById('ill_Email').checked          = false;
document.getElementById('ill_Ariel_Odyssey').checked  = false;
document.getElementById('ill_License_silent').checked = false;
document.getElementById('ill_CONTU').checked          = false;
document.getElementById('ill_CONTU_fax').checked      = false;
document.getElementById('ill_NPO').checked            = false}" 
<?php if($ill_note == "" && $ill_mailfax=='No' && $ill_ariel == "No" && $ill_email == "No" && $ill_npo == "No"){echo" CHECKED";}?>
>None<br />

<!-- E-reserves -->
<p align="center"><strong>E-reserves</strong></p>
<Input type = 'Radio' Name ='e_reserve' id='e_reserve_yes' value= 'Yes' 
<?php if($e_reserve == "Yes"){echo" CHECKED";}?>>Yes, delete upon cessation of use<br />
<Input type = 'Radio' Name ='e_reserve' id='e_reserve_no' value= 'No' 
<?php if($e_reserve == "No") {echo" CHECKED";}?>>No<br />
<Input type = 'Radio' Name ='e_reserve' id='e_reserve_silent' value= 'Silent' 
<?php if($e_reserve == "Silent") {echo" CHECKED";}?>>Silent<br />
<br />

<!-- Course Pack -->
<p align="center"><strong>Course Pack</strong></p>
<Input type = 'Checkbox' Name='cp_silent'     id="cp_silent"     onclick="document.getElementById('cp_none').checked = false"
<?php if($cp_note_silent == 'License silent, US copyright (fair use) law prevails.'){echo" CHECKED";}?>
>License silent, US Copyright law (fair use) prevails<br />
<Input type = 'Checkbox' Name='cp_print'      id="cp_print"      onclick="document.getElementById('cp_none').checked = false"
<?php if($coursepack_print      == "Yes"){echo" CHECKED";}?>>Print<br />
<Input type = 'Checkbox' Name='cp_electronic' id="cp_electronic" onclick="document.getElementById('cp_none').checked = false"
<?php if($coursepack_electronic == "Yes"){echo" CHECKED";}?>>Electronic<br />
<Input type = 'Checkbox' Name='cp_delete'     id="cp_delete"     onclick="document.getElementById('cp_none').checked = false"
<?php if($cp_note_delete == 'Delete upon cessation of use.')  {echo" CHECKED";}?>>Delete upon cessation of use<br />
<Input type = 'Checkbox' Name='cp_permission' id="cp_permission" onclick="document.getElementById('cp_none').checked = false"
<?php if($cp_note_permission == 'Seek permission from publisher.'){echo" CHECKED";}?>>Seek permission from publisher<br />
<Input type = 'Checkbox' Name='cp_none'      id="cp_none" onclick="if(this.checked) {
document.getElementById('cp_silent').checked     = false;
document.getElementById('cp_print').checked      = false;
document.getElementById('cp_electronic').checked = false;
document.getElementById('cp_delete').checked     = false;
document.getElementById('cp_permission').checked = false}" 
<?php if($cp_note_silent == "" && $cp_note_delete == "" && $cp_note_permission == "" && $coursepack_print == "No" && $coursepack_electronic == "No")
{echo" CHECKED";}?>>None, not allowed<br />

<!-- Archiving -->
<p align="center"><strong>Archiving</strong></p>
<Input type = 'Checkbox' Name ='arch_online' id="arch_online" onclick="
document.getElementById('arch_none').checked   = false;
document.getElementById('arch_note_other').disabled = false"
<?php if($arch_note_online == 'Yes, LOCKSS, Portico, or other shared online archive.'){echo" CHECKED";}?>
>Yes, LOCKSS, Portico, or other shared online archive<br />
<Input type = 'Checkbox' Name ='arch_media'  id="arch_media"  onclick="
document.getElementById('arch_none').checked   = false;
document.getElementById('arch_note_other').disabled = false"
<?php if($arch_note_media == 'Yes, Upon cancellation in DVD-ROM or other appropriate media.'){echo" CHECKED";}?>
>Yes, Upon cancellation in DVD-ROM or other appropriate media<br />
<Input type = 'Checkbox' Name ='arch_none'   id="arch_none"   onclick="
document.getElementById('arch_online').checked      = false;
document.getElementById('arch_media').checked       = false;
document.getElementById('arch_note_other').disabled = (this.checked)?1:0"
<?php if($arch_note_online == "" && $arch_note_media == "" && $arch_note_other == ""){echo" CHECKED";}?>>No<br />
<fieldset><legend>Other</legend><textarea cols="50" rows="1" name="arch_note_other" id="arch_note_other" ><?php echo $arch_note_other; ?></textarea></fieldset><br />
<br />

<!-- Perpetual Access Rights -->
<p align="center"><strong>Perpetual Access Rights</strong></p>
<Input type = 'Radio' Name ='perpetual' id='perpetual_yes' value='Yes' 
<?php if($perpetual == "Yes"){echo" CHECKED";}?>>Yes<br />
<Input type = 'Radio' Name ='perpetual' id='perpetual_no'  value='No' 
<?php if($perpetual == "No") {echo" CHECKED";}?>>No<br />
<fieldset><legend>Perpetual Access Note</legend><textarea cols="50" rows="3" name="perpetual_note" id='perpetual_note'>
<?php echo $perpetual_note; ?></textarea></fieldset>
<br />

<!-- Additional Use Restrictions Notes -->
<p align="center"><strong>Additional Use Restrictions Notes</strong></p>

<fieldset><legend>Digital Copy/Download</legend>
<Input type = 'Radio' Name ='download_radio' id='download_permitted' value='Permitted' 
<?php if($download_radio == "Permitted"){echo" CHECKED";}?>>Permitted
<Input type = 'Radio' Name ='download_radio' id='download_prohibited'  value='Prohibited' 
<?php if($download_radio == "Prohibited") {echo" CHECKED";}?>>Prohibited
<Input type = 'Radio' Name ='download_radio' id='download_silent'  value='Silent' 
<?php if($download_radio == "Silent") {echo" CHECKED";}?>>Silent
<textarea cols="50" rows="3" name="download"><?php echo $download; ?></textarea>
</fieldset><br />

<fieldset><legend>Scholarly Sharing Note</legend>
<Input type = 'Radio' Name ='share_radio' id='share_permitted' value='Permitted' 
<?php if($share_radio == "Permitted"){echo" CHECKED";}?>>Permitted
<Input type = 'Radio' Name ='share_radio' id='share_prohibited'  value='Prohibited' 
<?php if($share_radio == "Prohibited") {echo" CHECKED";}?>>Prohibited
<Input type = 'Radio' Name ='share_radio' id='share_silent'  value='Silent' 
<?php if($share_radio == "Silent") {echo" CHECKED";}?>>Silent
<textarea cols="50" rows="3" name="share"><?php echo $share; ?></textarea>
</fieldset><br />

<fieldset><legend>Printing</legend>
<Input type = 'Radio' Name ='print_radio' id='print_permitted' value='Permitted' 
<?php if($print_radio == "Permitted"){echo" CHECKED";}?>>Permitted
<Input type = 'Radio' Name ='print_radio' id='print_prohibited'  value='Prohibited' 
<?php if($print_radio == "Prohibited") {echo" CHECKED";}?>>Prohibited
<Input type = 'Radio' Name ='print_radio' id='print_silent'  value='Silent' 
<?php if($print_radio == "Silent") {echo" CHECKED";}?>>Silent
<textarea cols="50" rows="3" name="print"><?php echo $print; ?></textarea>
</fieldset><br />

<fieldset><legend>Other Access Information</legend><textarea cols="50" rows="3" name="access_info_note"><?php echo $access_info_note; ?></textarea></fieldset>
<fieldset><legend>Breach Instructions</legend><textarea cols="50" rows="3" name="breach_cure_period"><?php echo $breach_cure_period; ?></textarea></fieldset><br />

<fieldset><legend>Link</legend>
<Input type = 'Radio' Name ='link_radio' id='link_permitted' value='Permitted'
<?php if($link_radio == "Permitted"){echo" CHECKED";}?>>Permitted
<Input type = 'Radio' Name ='link_radio' id='link_prohibited' value='Prohibited'
<?php if($link_radio == "Prohibited") {echo" CHECKED";}?>>Prohibited
<Input type = 'Radio' Name ='link_radio' id='link_silent' value='Silent'
<?php if($link_radio == "Silent") {echo" CHECKED";}?>>Silent
<textarea cols="50" rows="3" name="link"><?php echo $link; ?></textarea>
</fieldset><br />

<fieldset><legend>Cancellation</legend><label for="cancel_days">Number of Days</label><br />
<Input type = 'Number' Name ='cancel_days' id='cancel_days' value='<?php echo $cancel_days; ?>'></Input><br />
<label for="cancel">Cancellation Note</label><br />
<textarea cols="50" rows="3" name="cancel"><?php echo $cancel; ?></textarea></fieldset><br />

<fieldset><legend>General Notes/Comments</legend><textarea cols="50" rows="3" name="term_note"><?php echo $term_note; ?></textarea></fieldset>
<br />

<p align="center"><input type="submit" name="submit" value="Submit"></p>
</form>

</td></tr></table>

<?php echo $links; ?>


<?php

mysql_close($conn);

require_once("footer.inc.php");

?>

