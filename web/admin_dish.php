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
	echo "<h3>" . MSG_ADMIN_MENU_SERVING_ADD . "</h3>\n";
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}?action=adm_insert"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">\n";
	echo "<table><tr><td><p>" . MSG_RECIPE_SERVING . ":</td><td> <input type=\"text\" name=\"dish_type\" size=\"20\">\n</td><td><input type=\"hidden\" name=\"insert\" value=\"adm_ok\"><input type=\"submit\" value=\"" . BTN_ADMIN_SERVING_ADD . "\"></td></tr></table>\n</form>\n";
	//Fast logout from admin area
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
	}
	if ($_POST['insert'] == "adm_ok")
	{
		echo "<h3>" . MSG_ADMIN_MENU_SERVING_ADD . "</h3>\n";
		if (eregi("[@!|#§+*<>^?£$%&\/\\]", $_POST['dish_type'])) {
			echo "<p class=\"error\">" . ERROR_ADMIN_SERVING_INPUT . "!\n";
			echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}?action=adm_insert"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">\n";
			echo "<table><tr><td><p>" . MSG_RECIPE_SERVING . ":</td><td> <input type=\"text\" name=\"dish_type\" size=\"20\">\n</td><td><input type=\"hidden\" name=\"insert\" value=\"adm_ok\"><input type=\"submit\" value=\"" . BTN_ADMIN_SERVING_ADD . "\"></td></tr></table>\n</form>\n";
			//Fast logout from admin area
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Check for duplicate names
		$sql_check_for_dupes = "SELECT dish FROM dish WHERE dish = '{$_POST['dish_type']}'";
		//Aborts if SQL fails
		if (!$exec_check_for_dupes = mysql_query($sql_check_for_dupes)) 
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_SERVING_DUPES . " {$_POST['dish_type']} dish type\n" . mysql_error();
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
		}
		//Display an error message if desired dish type is already into
		//database
		$dish_type_dupes = mysql_num_rows($exec_check_for_dupes);
		if ($dish_type_dupes == '1') {
			echo "<p class=\"error\">{$_POST['dish_type']} " . ERROR_ADMIN_COOKING_PRESENT . "\n";
			echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}?action=adm_insert"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">\n";
			echo "<table><tr><td><p>" . MSG_RECIPE_SERVING . ":</td><td> <input type=\"text\" name=\"dish_type\" size=\"20\">\n</td><td><input type=\"hidden\" name=\"insert\" value=\"adm_ok\"><input type=\"submit\" value=\"" . BTN_ADMIN_SERVING_ADD . "\"></td></tr></table>\n</form>\n";
			//Fast logout from admin area
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//If input passes all above checks, insert it into database
		$sql_insert_dish_type = "INSERT INTO dish (id, dish) VALUES ('', '{$_POST['dish_type']}')";
		if (!$exec_insert_dish_type = mysql_query($sql_insert_dish_type)) 
{
			echo "<p class=\"error\">" . ERROR_ADMIN_SERVING_INSERT . " {$_POST['dish_type']}<br>\n" . mysql_error();
			//Fast logout from admin area
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p><strong>{$_POST['dish_type']}</strong> " . MSG_ADMIN_SERVING_SUCCESS . ".\n";
		echo "<p><a href=\"admin_dish.php?action=adm_insert"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">" . MSG_ADMIN_SERVING_ASKNEW . "</a>?\n";
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
}
//Code to modify existing cooking types
if ($_GET['action'] == "adm_modify")
{
	echo "<h3>" . MSG_ADMIN_MENU_SERVING_MOD . "</h3>\n";
	if (isset($_POST['modify']))
	{
		if ($_POST['modify'] == "adm_ok")
		{
			//Modify the cooking type
			$sql_modify_dish = "UPDATE dish SET dish='{$_POST['dish']}' WHERE id = '{$_POST['id']}'";
			if (!$exec_modify_dish = mysql_query($sql_modify_dish))
			{
				echo "<p class=\"error\">" . ERROR_ADMIN_SERVING_CHANGE . "  {$_POST['dish']}<br>\n" . mysql_error();
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			echo "<p>" . MSG_ADMIN_SERVING_CHANGED . " {$_POST['dish']}\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		
		}
	}
	if (isset($_GET['recipe']))
	{
		$sql_get_dish = "SELECT * FROM dish WHERE id = '{$_GET['recipe']}'";
		if (!$exec_get_dish = mysql_query($sql_get_dish))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_SERVING_RETRIEVE . "<br>\n" . mysql_error();
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
		}
		//Print the form with the data to be modified
		while ($get_dish = mysql_fetch_object($exec_get_dish))
		{
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}?action=adm_modify"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">\n";
		echo "<table><tr><td><p>" . MSG_RECIPE_SERVING . ":</td><td> <input type=\"text\" name=\"dish\" size=\"20\" value=\"$get_dish->dish\"></td><td>
<input type=\"hidden\" name=\"modify\" value=\"adm_ok\"><input type=\"hidden\" name=\"id\" value=\"$get_dish->id\"><input type=\"submit\" value=\"" . BTN_ADMIN_SERVING_CHANGE . "\"></td></tr></table>\n</form>\n";
		}
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	$sql_db_browse = "SELECT * FROM dish";
	if (!$exec_db_browse = mysql_query($sql_db_browse))
	{
		echo "<p class=\"error\">" . MSG_ADMIN_SERVING_RETRIEVE . "<br>" . mysql_error();
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	cs_PrintDishTable($_GET['action']);
	//Fast logout from admin area
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//Code to delete existing cooking types
if ($_GET['action'] == "adm_delete")
{
	echo "<h3>" . MSG_ADMIN_MENU_SERVING_DEL . "</h3>\n";
	if (isset($_GET['recipe']))
	{
		$sql_delete_cook = "DELETE FROM dish WHERE id = '{$_GET['recipe']}'";
		if (!$exec_delete_cook = mysql_query($sql_delete_cook))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_SERVING_DELETE . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p>" . MSG_ADMIN_SERVING_DELETED . "\n";
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	$sql_db_browse = "SELECT * FROM dish";
	if (!$exec_db_browse = mysql_query($sql_db_browse))
	{
		echo "<p class=\"error\">" . ERROR_ADMIN_SERVING_RETRIEVE . "<br>\n" . mysql_error();
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	cs_PrintDishTable($_GET['action']);
	//Fast logout from admin area
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//Fast logout from admin area
cs_AdminFastLogout();
cs_AddFooter();
?>
