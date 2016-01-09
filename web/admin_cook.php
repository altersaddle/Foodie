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
require(dirname(__FILE__)."/includes/db_connection.inc.php");
$trans_sid = cs_IsTransSid();
cs_AddHeader();
cs_CheckLoginAdmin();
echo "<h2>" . MSG_ADMIN . "</h2>\n";
if ($_GET['action'] == "adm_insert")
{
	if (!isset($_POST['insert']))
	{
	echo "<h3>" . MSG_ADMIN_COOKING_INS . "</h3>\n";
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}?action=adm_insert"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">\n";
	echo "<table><tr><td><p>" . MSG_ADMIN_COOKING_TYPE . ":</td><td> <input type=\"text\" name=\"cooking_category\" size=\"20\">\n</td><td>
<input type=\"hidden\" name=\"insert\" value=\"adm_ok\"><input type=\"submit\" value=\"" . BTN_ADMIN_COOKING_INSERT . "\"></td></tr></table>\n</form>\n";
	//Fast logout from admin area
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
	}
	if ($_POST['insert'] == "adm_ok")
	{
		echo "<h3>" . MSG_ADMIN_COOKING_TITLE . "</h3>\n";
		if (empty($_POST['cooking_category']))
		{
			echo "<p class=\"error\">" . ERROR_INPUT_REQUIRED . "!\n";
			echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}?action=adm_insert"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">\n"; 
			echo "<table><tr><td><p>" . MSG_ADMIN_COOKING_TYPE . ":</td><td> <input type=\"text\" name=\"cooking_category\" size=\"20\">\n</td><td>
<input type=\"hidden\" name=\"insert\" value=\"adm_ok\"><input type=\"submit\" value=\"" . BTN_ADMIN_COOKING_INSERT . "\"></td></tr></table>\n</form>\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		
		if (eregi("[!|#§+*<>^?£$%&\/\\]", $_POST['cooking_category']))
		{
			echo "<p class=\"error\">" . MSG_INPUT_FIELD ." <em>{$_POST['cooking_category']}</em> " . MSG_INPUT_DANGER .".<br>\n";
			echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}?action=adm_insert"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">\n"; 
			echo "<table><tr><td><p>" . MSG_ADMIN_COOKING_TYPE . ":</td><td> <input type=\"text\" name=\"cooking_category\" size=\"20\">\n</td><td>
<input type=\"hidden\" name=\"insert\" value=\"adm_ok\"><input type=\"submit\" value=\"" . BTN_ADMIN_COOKING_INSERT . "\"></td></tr></table>\n</form>\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();

		}
		//Check for duplicate names
		$sql_check_for_dupes = "SELECT type FROM cooking WHERE type = '{$_POST['cooking_category']}'";
		//Aborts if SQL fails
		if (!$exec_check_for_dupes = mysql_query($sql_check_for_dupes)) 
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_COOKING_DUPES . " {$_POST['cooking_category']}<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Display an error message if desired dish type is already into
		//database
		$dish_type_dupes = mysql_num_rows($exec_check_for_dupes);
		if ($dish_type_dupes == '1') 
		{
			echo "<p class=\"error\"><strong>{$_POST['cooking_category']}</strong> " . ERROR_ADMIN_COOKING_PRESENT . ".<br>" . MSG_ADMIN_COOKING_SAME . ".\n";
			echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}?action=adm_insert"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">\n"; 
			echo "<table><tr><td><p>" . MSG_ADMIN_COOKING_TYPE . ":</td><td> <input type=\"text\" name=\"cooking_category\" size=\"20\">\n</td><td>
<input type=\"hidden\" name=\"insert\" value=\"adm_ok\"><input type=\"submit\" value=\"" . BTN_ADMIN_COOKING_INSERT . "\"></td></tr></table>\n</form>\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//If input passes all above checks, insert it into database
		$sql_insert_cook = "INSERT INTO cooking (id, type) VALUES ('', '{$_POST['cooking_category']}')";
		if (!$exec_insert_cook = mysql_query($sql_insert_cook)) 
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_COOKING_INSERT . " {$_POST['cooking_category']}<br>" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p><strong>{$_POST['cooking_category']}</strong> " . MSG_ADMIN_COOKING_SUCCESS . ".\n";
		echo "<p><a href=\"{$_SERVER['PHP_SELF']}?action=adm_insert"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">" . MSG_ADMIN_COOKING_NEW . "</a>?\n";
	//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
} 
//Code to modify existing cooking types
if ($_GET['action'] == "adm_modify")
{
	echo "<h3>" . MSG_ADMIN_COOKING_MOD . "</h3>\n";
	if (isset($_POST['modify']))
	{
		if ($_POST['modify'] == "adm_ok")
		{
			//Modify the cooking type
			$sql_modify_cook = "UPDATE cooking SET type='{$_POST['type']}' WHERE id = '{$_POST['id']}'";
			if (!$exec_modify_cook = mysql_query($sql_modify_cook))
			{
				echo "<p class=\"error\">" . ERROR_ADMIN_COOKING_MODIFY . " {$_POST['type']}<br>\n" . mysql_error();
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			echo "<p>" . MSG_ADMIN_COOKING_CHANGED . " {$_POST['type']}\n";
			//Fast logout from admin area
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		
		}
	}
	if (isset($_GET['recipe']))
	{
		$sql_get_cook = "SELECT * FROM cooking WHERE id = '{$_GET['recipe']}'";
		if (!$exec_get_cook = mysql_query($sql_get_cook))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_COOKING_SINGLE . "<br>\n" . mysql_error();
			//Fast logout from admin area
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Print the form with the data to be modified
		while ($get_cook = mysql_fetch_object($exec_get_cook))
		{
			echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}?action=adm_modify"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">\n";
			echo "<table><tr><td><p>" . MSG_RECIPE_COOKING . ":</td><td> <input type=\"text\" name=\"type\" size=\"20\" value=\"$get_cook->type\"></td><td><input type=\"hidden\" name=\"modify\" value=\"adm_ok\"><input type=\"hidden\" name=\"id\" value=\"$get_cook->id\"><input type=\"submit\" value=\"" . BTN_ADMIN_COOKING_MODIFY . "\"></td></tr></table>\n</form>\n";
		}
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	$sql_db_browse = "SELECT * FROM cooking";
	if (!$exec_db_browse = mysql_query($sql_db_browse))
	{
		echo "<p class=\"error\">" . ERROR_ADMIN_COOKING_RETRIEVE . "<br>\n" . mysql_error();
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	cs_PrintCookingTable($_GET['action']);
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//Code to delete existing cooking types
if ($_GET['action'] == "adm_delete")
{
	echo "<h3>" . MSG_ADMIN_COOKING_DEL . "</h3>\n";
	if (isset($_GET['recipe']))
	{
		$sql_delete_cook = "DELETE FROM cooking WHERE id = '{$_GET['recipe']}'";
		if (!$exec_delete_cook = mysql_query($sql_delete_cook))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_COOKING_DELETE . "<br>\n" . mysql_error();
			//Fast logout from admin area
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p>{$_GET['recipe']} " . MSG_ADMIN_COOKING_DELETED . "\n";
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	$sql_db_browse = "SELECT * FROM cooking";
	if (!$exec_db_browse = mysql_query($sql_db_browse))
	{
		echo "<p class=\"error\">" . ERROR_ADMIN_COOKING_RETRIEVE . "<br>\n" . mysql_error();
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	cs_PrintCookingTable($_GET['action']);
	//Fast logout from admin area
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
?>
