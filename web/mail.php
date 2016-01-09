<?php
/*
***************************************************************************
* CrisoftRicette is a GPL licensed free software sofware written
* by Lorenzo Pulici, Milano, Italy (Earth)
* You can read license terms reading COPYING file included in this
* package.
* In case this file is missing you can obtain license terms through WWW
* pointing your web browser at http://www.gnu.org or http:///www.fsf.org
* If you can't browse the web please write an email to the software author
* at snowdog@tiscali.it
****************************************************************************
*/
session_name("crisoftricette");
session_start();
require_once(dirname(__FILE__)."/lang/".$_SESSION['locale'].".php");
require(dirname(__FILE__)."/crisoftlib.php");
$trans_sid = cs_IsTransSid();
cs_DestroyAdmin();
cs_AddHeader();
echo "<h2>" . MSG_MAIL_TITLE . "</h2>\n";
require(dirname(__FILE__)."/includes/db_connection.inc.php");
//If recipient POST variable is not set print the form to mail the
//recipe
if (!isset($_POST['recipient']))
{
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<p>" . MSG_MAIL_ADDRESS_REQUEST . " <strong>{$_SESSION['recipe_name']}</strong>\n
	<br><input type=\"text\" name=\"recipient\" size=\"30\">\n
	<p><input type=\"submit\" value=\"" . BTN_MAIL_SEND . "\">\n
	</form>
	";
	cs_AddFooter();
	exit();
}
//Check recipient email address
//if empty
if (empty($_POST['recipient']))
{
	echo "<h2>" . ERROR_GENERIC . "</h2>";
	echo "<p class=\"error\">" . ERROR_INPUT_REQUIRED . "\n";
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<p>" . MSG_MAIL_ADDRESS_REQUEST . " <strong>{$_SESSION['recipe_name']}</strong>\n
	<br><input type=\"text\" name=\"recipient\" size=\"30\">\n
	<p><input type=\"submit\" value=\"" . BTN_MAIL_SEND . "\">\n
	</form>
	";
	cs_AddFooter();
	exit();
}
//if $_SESSION['email_address'] is empty/unset abort with error
if (!isset($_SESSION['email_address']))
{
	echo "<p class=\"error\">" . ERROR_MAIL_SENDER . "<br>\n";
	exit();
}
if (empty($_SESSION['email_address']))
{
	echo "<p class=\"error\">" . ERROR_MAIL_SENDER . "<br>\n";
	exit();
}
//if dangerous chars are present
if (eregi("[!|#§+*<>^?£$%&\/\\]", $_POST['recipient']))
{
	echo "<h2>" . ERROR_GENERIC . "</h2>";
	echo "<p class=\"error\">{$_POST['recipient']} " . ERROR_MAIL_ADDRESS . "\n";
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<p>" . MSG_MAIL_ADDRESS_REQUEST . " <strong>{$_SESSION['recipe_name']}</strong>\n
	<br><input type=\"text\" name=\"recipient\" size=\"30\">\n
	<p><input type=\"submit\" value=\"" . BTN_MAIL_SEND . "\">\n
	</form>
	";
	cs_AddFooter();
	exit();
}
//if is a valid email address
if (!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]+))*$", $_POST['recipient']))
{
	echo "<h2>" . ERROR_GENERIC . "</h2>";
	echo "<p class=\"error\">{$_POST['recipient']} " . ERROR_MAIL_ADDRESS . "\n";
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<p>" . MSG_MAIL_ADDRESS_REQUEST . " <strong>{$_SESSION['recipe_name']}</strong>\n
	<br><input type=\"text\" name=\"recipient\" size=\"30\">\n
	<p><input type=\"submit\" value=\"" . BTN_MAIL_SEND . "\">\n
	</form>
	";
	cs_AddFooter();
	exit();
}
//retrieve data from database
$sql_recipe = "SELECT * FROM main WHERE id = '{$_SESSION['recipe_id']}'";
if (!$exec_recipe = mysql_query($sql_recipe)) {
	echo "<p class=\"error\">" . ERROR_RECIPE_RETRIEVE . "<br>" . mysql_error();
	cs_AddFooter();
	exit();
}
while ($data = mysql_fetch_object($exec_recipe)) {
	$ww_ingredients = wordwrap($data->ingredients, 72);
	$ww_description = wordwrap($data->description, 72);
	$ww_notes = wordwrap($data->notes, 72);
	$mail_subject = "{$_SESSION['software']} {$_SESSION['version']} " . MSG_RECIPE . ": $data->name";
	//All variables should be wordwrapped at 72 characters in order
	//not to break mail RFC
	$mail_recipe = "$data->name
	\n" . MSG_RECIPE_SERVING . ": $data->dish
	\n" . MSG_RECIPE_MAIN . ": $data->mainingredient
	\n" . MSG_RECIPE_PEOPLE . ": $data->people
	\n" . MSG_RECIPE_ORIGIN . ": $data->origin
	\n" . MSG_RECIPE_SEASON . ": $data->season
	\n" . MSG_RECIPE_COOKING . ": $data->kind
	\n" . MSG_RECIPE_TIME . ": $data->time
	\n" . MSG_RECIPE_DIFFICULTY . ": $data->difficulty (" . MSG_MAIL_DIFF . ")
	\n" . MSG_RECIPE_WINES . ": $data->wines
	\n" . MSG_RECIPE_INGREDIENTS . ": $ww_ingredients
	\n" . MSG_RECIPE_DESCRIPTION . ": $ww_description
	\n" . MSG_RECIPE_NOTES . ": $ww_notes
	\n-- \n" . MSG_MAIL_SENT . " {$_SESSION['software']}{$_SESSION['version']}.\n" . MSG_MAIL_DOWNLOAD . " {$_SESSION['software']} " . MSG_MAIL_WEBSITE . ":\n{$_SESSION['website']}\n";
}
//Generate mail and send it
$mail_headers = "From: ".$_SESSION['email_address']."\r\nReply-To: ".$_SESSION['email_address']."\r\nX-Mailer: ".$_SESSION['software']." internal mailer";
mail($_POST['recipient'], $mail_subject, $mail_recipe, $mail_headers);
//Ask if you want to send it again
echo "<p>" . MSG_MAIL_DELIVERED . "\n";
echo "<p><a href=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_MAIL_AGAIN . "</a>?\n";
cs_AddFooter();
?>

