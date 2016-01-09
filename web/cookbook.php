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
cs_DestroyAdmin();
cs_AddHeader();
echo "<h2>" . MSG_COOKBOOK . "</h2>\n";
if (isset($_POST['action']))
{
	if ($_POST['action'] == "cook_add")
	{
		//Insert recipe into cookbook
		$sql_check_dupes = "SELECT id FROM personal_book WHERE id = '{$_SESSION['recipe_id']}'";
		if (!$exec_check_dupes = mysql_query($sql_check_dupes))
		{
			echo "<p class=\"error\">" . ERROR_COOKBOOK_DUPLICATE . "<br>\n" . mysql_error();
			cs_AddFooter();
			exit();
		}
		$dupes_found = mysql_num_rows($exec_check_dupes);
		if ($dupes_found >= 1)
		{
			echo "<p class=\"error\">" . MSG_RECIPE . "{$_SESSION['recipe_name']} " . MSG_COOKBOOK_PRESENT . " {$_SESSION['recipe_id']}\n";
			cs_AddFooter();
			exit();
		}
		//Insert recipe into the cookbook
		$sql_add_cookbook = "INSERT INTO personal_book (id, recipe_name) VALUES ('{$_SESSION['recipe_id']}', '{$_SESSION['recipe_name']}')";
		if (!$exec_add_cookbook = mysql_query($sql_add_cookbook))
		{
			echo "<p class=\"error\">" . ERROR_COOKBOOK_INSERT . "<br>\n" . mysql_error();
			cs_AddFooter();
			exit();
		}
		echo "<p>{$_SESSION['recipe_name']} " . MSG_COOKBOOK_INSERT . ".\n";
		//Prints out number of recipes into personal cookbook with link to
		//cookbook.php
		$sql_cookbook_recipes = "SELECT * FROM personal_book";
		if (!$exec_cookbook_recipes = mysql_query($sql_cookbook_recipes))
		{
			echo "<p class=\"error\">" . ERROR_COOKBOOK_SELECT . "<br>\n" . mysql_error();
			cs_AddFooter();
			exit();
		}
		$num_cookbook = mysql_num_rows($exec_cookbook_recipes);
		if (0 == $num_cookbook)
		{
			echo "<p class=\"error\">" . MSG_COOKBOOK_NORECIPES . ".\n";
			unset($_SESSION['recipe_id']);
			unset($_SESSION['recipe_name']);
		}
		if ($num_cookbook >= 1)
		{
			echo "<p>$num_cookbook " . MSG_COOKBOOK_NUMBER . "\n";
			echo "<p><a href=\"cookbook.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_COOKBOOK_READ . "</a>\n";
		}
		unset($_SESSION['recipe_id']);
		unset($_SESSION['recipe_name']);
		cs_AddFooter();
		exit();
	}
	if ($_POST['action'] == "cook_remove")
	{
		echo "<h2>" . MSG_COOKBOOK_DELETE . "</h2>\n";
		$sql_cookbook_delete = "DELETE FROM personal_book WHERE id = '{$_POST['recipe_remove']}'";
		if (!$exec_cookbook_delete = mysql_query($sql_cookbook_delete))
		{
			echo "<p class=\"error\">" . ERROR_COOKBOOK_DELETE . "<br>" . mysql_error();
		exit();
		}
		echo "<p>" . MSG_RECIPE . " <strong>{$_POST['recipe_name']}</strong>";
		echo "<a href=\"cookbook.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\"> " . MSG_COOKBOOK_DELETED . "</a>\n";
		unset($_SESSION['recipe_id']);
		unset($_SESSION['recipe_name']);
		cs_AddFooter();
		exit();
	}
	else
	{
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . ".<br>\n";
		cs_AddFooter();
		exit();
	}
}
if (isset($_SESSION['recipe_id']))
{
	unset($_SESSION['recipe_id']);
}
if (isset($_SESSION['recipe_name']))
{
	unset($_SESSION['recipe_name']);
}
echo "<p>" . MSG_COOKBOOK_WELCOME . "!\n";
$sql_cookbook_recipes = "SELECT * FROM personal_book";
if (!$exec_cookbook_recipes = mysql_query($sql_cookbook_recipes))
{
	echo "<p class=\"error\">" . ERROR_COOKBOOK_SELECT . "<br>\n" . mysql_error();
	exit();
}
$num_cookbook = cs_CountCookbook();
if (0 == $num_cookbook)
{
	echo "<p class=\"error\">" . MSG_COOKBOOK_NORECIPES . ".\n";
}
if ($num_cookbook >= 1)
{
	echo "<p>$num_cookbook " . MSG_COOKBOOK_NUMBER . "<br>\n<table>";
	cs_PrintCookbook();
}
cs_AddFooter();
?>
