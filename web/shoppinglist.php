<?php
/*
***************************************************************************
* Foodie is a GPL licensed free software web application written
* and copyright 2016 by Malcolm Walker, malcolm@ipatch.ca
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* License terms can be read in COPYING file included in this package.
* If this file is missing you can obtain license terms through WWW
* pointing your web browser at http://www.gnu.org or http:///www.fsf.org
****************************************************************************
*/
session_name("foodie");
session_start();
require(dirname(__FILE__)."/config/foodie.ini.php");

if (!isset($_SESSION['locale'])) {
  $_SESSION['locale'] = $setting_locale;  
}
require_once(dirname(__FILE__)."/lang/".$_SESSION['locale'].".php");
require(dirname(__FILE__)."/foodielib.php");
require(dirname(__FILE__)."/includes/dbconnect.inc.php");

echo "<h2>" . MSG_SHOPPING_TITLE . "</h2>\n";
if (!isset($_POST['action']))
{
	if (isset($_SESSION['recipe_id']))
	{
		unset($_SESSION['recipe_id']);
	}
	if (isset($_SESSION['recipe_name']))
	{
		unset($_SESSION['recipe_name']);
	}
	//Print shopping list
	$sql_shopping = "SELECT * FROM shopping";
	if (!$exec_shopping = $dbconnect->query($sql_shopping))
	{
		echo "<p class=\"error\">" . ERROR_SHOPPING_RETRIEVE_LIST . "<br>\n" . $exec_shopping->error();
		foodie_AddFooter();
		exit();
	}
	$num_recipes = $exec_shopping->num_rows;
	if ($num_recipes == 0)
	{
		echo "<p>" . MSG_SHOPPING_NODATA . ".\n";
		foodie_AddFooter();
		exit();
	}
	if ($num_recipes >= 1)
	{
		echo "<table>\n";
		while ($shopping_data = $exec_shopping->fetch_object())
		{
			$shopping_id = $shopping_data->id;
			$things_to_buy = nl2br($shopping_data->ingredients);
			echo
			"<tr><td>\n";
			echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n";
			echo "<p><strong>$shopping_data->recipe</strong></td><td><p>$things_to_buy</td><td><input type=\"hidden\" name=\"id\" value=\"$shopping_id\"><input type=\"hidden\" name=\"action\" value=\"sl_delete\"><input type=\"submit\" value=\"" . BTN_SHOPPING_DELETE . "\"></td></tr></form>";
		}
		echo "</table>\n";
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\" target=\"_BLANK\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"sl_print\">\n
		<input type=\"submit\" value=\"" . BTN_SHOPPING_PRINT . "\">
		</form>\n";
	}
	foodie_AddFooter();
	exit();
}
//define array for action
$action_ok = array("sl_add", "sl_delete", "sl_print");
//If action GET variable is different from definded into array display
//an error message
if (!in_array("{$_POST['action']}", $action_ok))
{	
        echo "<p class=\"error\">" . ERROR_UNEXPECTED . "!\n";
	foodie_AddFooter();
	exit();
}
if ($_POST['action'] == "sl_add")
{
	//Add ingredients of recipe to shopping list
	$sql_select_for_shopping = "SELECT name,ingredients FROM main WHERE id = '{$_SESSION['recipe_id']}'";
	if (!$exec_select_for_shopping = $dbconnect->query($sql_select_for_shopping))
	{
		echo "<p class=\"error\">" . ERROR_SHOPPING_RETRIEVE_RECIPE . "<br>\n" . $exec_select_for_shopping->error();
		foodie_AddFooter();
		exit();
	}
	while ($recipe_data = $exec_select_for_shopping->fetch_object())
	{
		$recipe_name = addslashes($recipe_data->name);
		$recipe_ingredients = addslashes($recipe_data->ingredients);
		$sql_shopping_add = "INSERT INTO shopping (recipe, ingredients) VALUES ('$recipe_name', '$recipe_ingredients')";
		if (!$exec_shopping_add = $dbconnect->query($sql_shopping_add))
		{
			echo "<p class=\"error\">" . ERROR_SHOPPING_INSERT . "!<br>\n" . $exec_shopping_add->error();
			foodie_AddFooter();
			exit();
		}
		echo "<p><strong>$recipe_name</strong>";
		echo "<a href=\"shoppinglist.php\"> " . MSG_SHOPPING_ADDED . "</a>\n";
	}
	foodie_AddFooter();
	exit();
}
if ($_POST['action'] == "sl_delete")
{
	//Delete recipes from shopping list
	if (!is_numeric($_POST['id']))
	{
		//If id GET variable has been tampered with non numeric
		//value abort program with error
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
		foodie_AddFooter();
		exit();
	}
	$sql_shopping_delete = "DELETE FROM shopping WHERE id = '{$_POST['id']}'";
	if (!$exec_shopping_delete = $dbconnect->query($sql_shopping_delete))
	{
		echo "<p class=\"error\">" . ERROR_SHOPPING_DELETE . "!<br>\n" . $exec_shopping_delete->error();
		foodie_AddFooter();
		exit();
	}
	echo "<p><a href=\"shoppinglist.php\">" . MSG_SHOPPING_DELETED . "</a>\n";
	foodie_AddFooter();
	exit();
}
if ($_POST['action'] == "sl_print")
{
	//Printer friendly version of shopping list
	//Print shopping list
	$sql_shopping = "SELECT * FROM shopping";
	if (!$exec_shopping = $dbconnect->query($sql_shopping))
	{
		echo "<p class=\"error\">" . ERROR_SHOPPING_RETRIEVE_LIST . "<br>\n" . $exec_shopping->error();
		foodie_AddFooter();
		exit();
	}
	while ($shopping_data = $exec_shopping->fetch_object())
	{
		$things_to_buy = nl2br($shopping_data->ingredients);
		echo "<p><strong>$shopping_data->recipe</strong><br>\n$things_to_buy";
	}
	echo "<p class=small>" . MSG_SHOPPING_SIGNATURE . " {$_SESSION['software']} {$_SESSION['version']}\n";
	exit();
}
?>
