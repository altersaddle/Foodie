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

foodie_AddHeader();
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
			foodie_AddFooter();
			exit();
		}
		$dupes_found = mysql_num_rows($exec_check_dupes);
		if ($dupes_found >= 1)
		{
			echo "<p class=\"error\">" . MSG_RECIPE . "{$_SESSION['recipe_name']} " . MSG_COOKBOOK_PRESENT . " {$_SESSION['recipe_id']}\n";
			foodie_AddFooter();
			exit();
		}
		//Insert recipe into the cookbook
		$sql_add_cookbook = "INSERT INTO personal_book (id, recipe_name) VALUES ('{$_SESSION['recipe_id']}', '{$_SESSION['recipe_name']}')";
		if (!$exec_add_cookbook = mysql_query($sql_add_cookbook))
		{
			echo "<p class=\"error\">" . ERROR_COOKBOOK_INSERT . "<br>\n" . mysql_error();
			foodie_AddFooter();
			exit();
		}
		echo "<p>{$_SESSION['recipe_name']} " . MSG_COOKBOOK_INSERT . ".\n";
		//Prints out number of recipes into personal cookbook with link to
		//cookbook.php
		$sql_cookbook_recipes = "SELECT * FROM personal_book";
		if (!$exec_cookbook_recipes = mysql_query($sql_cookbook_recipes))
		{
			echo "<p class=\"error\">" . ERROR_COOKBOOK_SELECT . "<br>\n" . mysql_error();
			foodie_AddFooter();
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
		foodie_AddFooter();
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
		foodie_AddFooter();
		exit();
	}
	else
	{
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . ".<br>\n";
		foodie_AddFooter();
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
if (!$cookbook_result = $dbconnect->query($sql_cookbook_recipes))
{
	echo "<p class=\"error\">" . ERROR_COOKBOOK_SELECT . "<br>\n" . $cookbook_result->error();
	exit();
}
$num_cookbook = $cookbook_result->num_rows;
if (0 == $num_cookbook)
{
	echo "<p class=\"error\">" . MSG_COOKBOOK_NORECIPES . ".\n";
}
if ($num_cookbook >= 1)
{
	echo "<p>$num_cookbook " . MSG_COOKBOOK_NUMBER . "<br>\n";
	echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\" bgcolor=\"#aaaaaa\">";
	$arr_element = 0;
	$line_number = 1;
	while ($cookbook_data = $cookbook_result->fetch_object()) 
	{
		$list_data[$arr_element][0] = $cookbook_data->id;
		$list_data[$arr_element][1] = $cookbook_data->recipe_name;
		$list_data[$arr_element][2] = $line_number;
		$arr_element++;
		$line_number++;
	}
	$count_data = count($list_data);
	foreach ($list_data as $list_var)
	{
		if (($list_var[2] % 2 == 0))
		{
			$row_color = "#eeeeee";
		} else
		{
			$row_color = "#dddddd";
		}
		echo "<tr><td bgcolor=\"$row_color\">\n";
		echo "<a href=\"recipe.php?recipe=$list_var[0]";
		if ($trans_sid == 0)
		{
			echo "&" . SID;
		}
		echo "\">$list_var[1]</a>\n";
		echo "</td><td valign=\"middle\" align=\"center\" bgcolor=\$row_color\">\n";
		echo "<form method=\"post\" action=\"cookbook.php";
		if ($trans_sid == 0)
		{
			echo "?" . SID;
		}
		echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"cook_remove\">\n<input type=\"hidden\" name=\"recipe_remove\" value=\"$list_var[0]\">\n<input type=\"hidden\" name=\"recipe_name\" value=\"$list_var[1]\">\n<input type=\"submit\" value=\"" . MSG_COOKBOOK_DELETE . "\"></form></td></tr>\n";
	}
	echo "</table>\n";
}


foodie_AddFooter();
?>
