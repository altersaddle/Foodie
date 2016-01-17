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
//This function includes the HTML header
function foodie_AddHeader() 
{	
	include(dirname(__FILE__)."/includes/header.inc.php");
}
//This function includes the HTML footer
function foodie_AddFooter()
{
	include(dirname(__FILE__)."/includes/footer.inc.php");
}
//Function used to determine page size for PDF generated file
function cs_CheckForPageSize()
{
$page_check = array ('A4', 'legal', 'letter'); 
if (!in_array("{$_SESSION['page_size']}", $page_check))
{	
	cs_AddHeader();
	echo "<p class=\"error\">{$_SESSION['page_size']} " . ERROR_PAGE_SIZE . "!\n";
	echo "<p>" . MSG_USE_ONLY_VALUES . ":<br>\n";
	//Displays content of array $image_type
	foreach ($page_check as $extension)
	{
		echo "$extension \n";
	}
	cs_AddFooter();
	session_unset();
	session_destroy();
	exit();
	}
}

function cs_CheckDangerousInput($danger_field)
{
	global $trans_sid;
	if (eregi("[!|#�+*<>^?�$%&\/\\]",$danger_field)) 
	{
		cs_AddHeader();
		echo "<h2>" . MSG_SECURITY_WARNING ."!</h2>";
		echo "<p class=\"error\">" . MSG_INPUT_FIELD ." <em>$danger_field</em> " . MSG_INPUT_DANGER .".<br>";
		exit();
	}		
}
function cs_CheckDangerousInputConfig($danger_field)
{
	global $trans_sid;
	if (eregi("[!|#�+*<>^?�$%&\/\\]",$danger_field)) 
	{	
		echo "<p class=\"error\">" . MSG_INPUT_FIELD ." <em>$danger_field</em> " . MSG_INPUT_DANGER.".\n";
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}";
		if ($trans_sid == 0)
		{
			echo "?" . SID;
		}
		echo "\">\n";
		echo "<table>\n<tr><td><p>" . MSG_ADMIN_CFG_HOSTNAME . ":</td><td><input type=\"text\" name=\"config_server\" value=\"{$_POST['config_server']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_PORT . ":</td><td><input type=\"text\" name=\"config_port\" value=\"{$_POST['config_port']}\" size=\"5\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_DBNAME . ":</td><td><input type=\"text\" name=\"config_dbname\" value=\"{$_POST['config_dbname']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_USER . ":</td><td><input type=\"text\" name=\"config_user\" value=\"{$_POST['config_user']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_PASS . ":</td><td><input type=\"text\" name=\"config_pass\" value=\"{$_POST['config_pass']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_EMAIL . ":</td><td><input type=\"text\" name=\"config_email_address\" value=\"{$_POST['config_email_address']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_LOCALE . ":</td><td><select name=\"config_locale\"><option value=\"{$_POST['config_locale']}\">{$_POST['config_locale']}</option>\n";
		$lang_dir = opendir(dirname(__FILE__)."/lang");
		while (($lang_item = readdir($lang_dir)) !== false) 
		{ 
			if ($lang_item == "." OR $lang_item == "..") continue;
			//Strip away dot and php extension
			$lang_file = str_replace(".php", "", $lang_item);
			if ($lang_file != $_POST['config_locale'])
			{
				echo "<option value=\"$lang_file\">$lang_file</option>\n";
			}
		}  
		closedir($lang_dir);
		echo "
		</select></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_LINES . ":</td><td><input type=\"text\" name=\"config_max_lines_page\" value=\"{$_POST['config_max_lines_page']}\" size=\"3\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_PAGESIZE . ":</td><td><select name=\"config_page_size\">
		<option value=\"{$_POST['config_page_size']}\">{$_POST['config_page_size']}</option>\n";
		$avail_pagesize = array ('A4', 'letter', 'legal'); 
		foreach ($avail_pagesize as $pagesize)
		{
			if ($pagesize != $_POST['config_page_size'])
			{
				echo "<option value=\"$pagesize\">$pagesize</option>\n";
			}
		}
		echo "
		</select></td></tr>\n
		</table>\n
		<input type=\"hidden\" name=\"change\" value=\"ok\">\n
		<div align=center><input type=\"submit\" value=\"" . BTN_ADMIN_CFG_CHANGE . "\"></div>\n
		</form>\n\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
}
function cs_CheckDangerousModifyInputNoSlash($field)
{
	global $trans_sid;
	if (eregi("[!|#�+*<>^?�$%&]",$field)) 
	{	
		echo "<p class=\"error\">" . MSG_INPUT_FIELD ." <em>$field</em> " . MSG_INPUT_DANGER.".\n";
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}";
		if ($trans_sid == 0)
		{
			echo "?" . SID;
		}			
		echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"modify\">\n
		<input type=\"hidden\" name=\"id\" value=\"{$_POST['id']}\">\n
		<p>" . MSG_RECIPE_NAME . ": <input type=\"text\" size=\"50\" name=\"name\" value=\"{$_POST['name']}\">\n
		<p>" . MSG_RECIPE_SERVING . ": <select name=\"dish\"><option value=\"{$_POST['dish']}\">{$_POST['dish']}</option>\n";
		while ($data_dish=mysql_fetch_object($dish_number)) 
		{
			if ($data_dish->dish != $_POST['dish'])
			{
				echo "<option value=\"$data_dish->dish\">$data_dish->dish</option>\n";
			}
		}
		echo "</select>
		<p>" . MSG_RECIPE_MAIN . ": <input type=\"text\" size=\"30\" name=\"mainingredient\" value=\"{$_POST['mainingredient']}\">\n
		<p>" . MSG_RECIPE_PEOPLE . ": <input type=\"text\" size=\"30\" name=\"people\" value=\"{$_POST['people']}\">\n
		<p>" . MSG_RECIPE_ORIGIN . ": <input type=\"text\" size=\"30\" name=\"origin\" value=\"{$_POST['origin']}\">\n
		<p>" . MSG_RECIPE_COOKING . ":<select name=kind><option value=\"$recipe_data->kind\">{$_POST['kind']}</option>\n";
		while ($data_cook=mysql_fetch_object($cooking_number)) {
			if ($data_cook->type != $_POST['kind'])
			{
				echo "<option value=\"$data_cook->type\">$data_cook->type</option>\n";
			}
		}
		echo "</select>\n
		<p>" . MSG_RECIPE_SEASON . ": <input type=\"text\" size=\"30\" name=\"season\" value=\"{$_POST['season']}\">\n
		<p>" . MSG_RECIPE_TIME . ": <input type=\"text\" size=\"10\" name=\"time\" value=\"{$_POST['time']}\">\n
		<p>" . MSG_RECIPE_DIFFICULTY . ": <select name=\"difficulty\">\n";
		if ($_POST['difficulty'] == "-")
		{
			echo "<option value=\"{$_POST['difficulty']}\">" . MSG_NOT_SPECIFIED . "</option>\n";
		}
		else {
			echo "<option value=\"{$_POST['difficulty']}\">{$_POST['difficulty']}</option>\n";
		}
		while ($data_diff=mysql_fetch_object($difficulty_number)) {
			if ($data_diff->difficulty != $_POST['difficulty'])
			{
				echo "<option value=\"$data_diff->difficulty\">$data_diff->difficulty</option>\n";
			}
		}
		if ($_POST['difficulty'] != "-")
		{
			echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option>\n";
		}
		echo "</select>\n
		<p>" . MSG_RECIPE_INGREDIENTS . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"ingredients\">{$_POST['ingredients']}</textarea>\n
		<p>" . MSG_RECIPE_DESCRIPTION . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"description\">{$_POST['description']}</textarea>\n
		<p>" . MSG_RECIPE_NOTES . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"notes\">{$_POST['notes']}</textarea>\n
		<p>" . MSG_RECIPE_WINES . ": <input type=\"text\" size=\"30\" name=\"wines\" value=\"{$_POST['wines']}\">\n
		<p>" . MSG_ADMIN_MODIFY_IMAGE . ": <input type=\"text\" size=\"30\" name=\"image\" value=\"{$_POST['image']}\">\n
		<p>" . MSG_ADMIN_MODIFY_VIDEO . ": <input type=\"text\" size=\"30\" name=\"video\" value=\"{$_POST['video']}\">\n
		<p><input type=\"submit\" value=\"" . BTN_ADMIN_MODIFY_RECIPE . "\">\n
		";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
}
function cs_CheckDangerousModifyInput($field)
{
	global $trans_sid; 
	if (eregi("[!|#�+*<>^?�$%&\/\\]",$field)) 
	{	
		echo "<p class=\"error\">" . MSG_INPUT_FIELD ." <em>$field</em> " . MSG_INPUT_DANGER.".\n";
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}";
		if ($trans_sid == 0)
		{
			echo "?" . SID;
		}			
		echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"modify\">\n
		<input type=\"hidden\" name=\"id\" value=\"{$_POST['id']}\">\n
		<p>" . MSG_RECIPE_NAME . ": <input type=\"text\" size=\"50\" name=\"name\" value=\"{$_POST['name']}\">\n
		<p>" . MSG_RECIPE_SERVING . ": <select name=\"dish\"><option value=\"{$_POST['dish']}\">{$_POST['dish']}</option>\n";
		while ($data_dish=mysql_fetch_object($dish_number)) 
		{
			if ($data_dish->dish != $_POST['dish'])
			{
				echo "<option value=\"$data_dish->dish\">$data_dish->dish</option>\n";
			}
		}
		echo "</select>
		<p>" . MSG_RECIPE_MAIN . ": <input type=\"text\" size=\"30\" name=\"mainingredient\" value=\"{$_POST['mainingredient']}\">\n
		<p>" . MSG_RECIPE_PEOPLE . ": <input type=\"text\" size=\"30\" name=\"people\" value=\"{$_POST['people']}\">\n
		<p>" . MSG_RECIPE_ORIGIN . ": <input type=\"text\" size=\"30\" name=\"origin\" value=\"{$_POST['origin']}\">\n
		<p>" . MSG_RECIPE_COOKING . ":<select name=kind><option value=\"{$_POST['kind']}\">{$_POST['kind']}</option>\n";
		while ($data_cook=mysql_fetch_object($cooking_number)) {
			if ($data_cook->type != $_POST['kind'])
			{
				echo "<option value=\"$data_cook->type\">$data_cook->type</option>\n";
			}
		}
		echo "</select>\n
		<p>" . MSG_RECIPE_SEASON . ": <input type=\"text\" size=\"30\" name=\"season\" value=\"{$_POST['season']}\">\n
		<p>" . MSG_RECIPE_TIME . ": <input type=\"text\" size=\"10\" name=\"time\" value=\"{$_POST['time']}\">\n
		<p>" . MSG_RECIPE_DIFFICULTY . ": <select name=\"difficulty\">\n";
		if ($_POST['difficulty'] == "-")
		{
			echo "<option value=\"{$_POST['difficulty']}\">" . MSG_NOT_SPECIFIED . "</option>\n";
		}
		else {
			echo "<option value=\"{$_POST['difficulty']}\">{$_POST['difficulty']}</option>\n";
		}
		while ($data_diff=mysql_fetch_object($difficulty_number)) {
			if ($data_diff->difficulty != $_POST['difficulty'])
			{
				echo "<option value=\"$data_diff->difficulty\">$data_diff->difficulty</option>\n";
			}
		}
		if ($_POST['difficulty'] != "-")
		{
			echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option>\n";
		}
		echo "</select>\n
		<p>" . MSG_RECIPE_INGREDIENTS . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"ingredients\">{$_POST['ingredients']}</textarea>\n
		<p>" . MSG_RECIPE_DESCRIPTION . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"description\">{$_POST['description']}</textarea>\n
		<p>" . MSG_RECIPE_NOTES . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"notes\">{$_POST['notes']}</textarea>\n
		<p>" . MSG_RECIPE_WINES . ": <input type=\"text\" size=\"30\" name=\"wines\" value=\"{$_POST['wines']}\">\n
		<p>" . MSG_ADMIN_MODIFY_IMAGE . ": <input type=\"text\" size=\"30\" name=\"image\" value=\"{$_POST['image']}\">\n
		<p>" . MSG_ADMIN_MODIFY_VIDEO . ": <input type=\"text\" size=\"30\" name=\"video\" value=\"{$_POST['video']}\">\n
		<p><input type=\"submit\" value=\"" . BTN_ADMIN_MODIFY_RECIPE . "\">\n
		";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
}
function cs_CheckEmptyModifyInput($field)
{
	global $trans_sid;
	if (empty($field)) 
	{	
		echo "<p class=\"error\">" . ERROR_INPUT_REQUIRED . "!\n";
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}";
		if ($trans_sid == 0)
		{
			echo "?" . SID;
		}			
		echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"modify\">\n
		<input type=\"hidden\" name=\"id\" value=\"{$_POST['id']}\">\n
		<p>" . MSG_RECIPE_NAME . ": <input type=\"text\" size=\"50\" name=\"name\" value=\"{$_POST['name']}\">\n
		<p>" . MSG_RECIPE_SERVING . ": <select name=\"dish\"><option value=\"{$_POST['dish']}\">{$_POST['dish']}</option>\n";
		while ($data_dish=mysql_fetch_object($dish_number)) 
		{
			if ($data_dish->dish != $_POST['dish'])
			{
				echo "<option value=\"$data_dish->dish\">$data_dish->dish</option>\n";
			}
		}
		echo "</select>
		<p>" . MSG_RECIPE_MAIN . ": <input type=\"text\" size=\"30\" name=\"mainingredient\" value=\"{$_POST['mainingredient']}\">\n
		<p>" . MSG_RECIPE_PEOPLE . ": <input type=\"text\" size=\"30\" name=\"people\" value=\"{$_POST['people']}\">\n
		<p>" . MSG_RECIPE_ORIGIN . ": <input type=\"text\" size=\"30\" name=\"origin\" value=\"{$_POST['origin']}\">\n
		<p>" . MSG_RECIPE_COOKING . ":<select name=kind><option value=\"{$_POST['kind']}\">{$_POST['kind']}</option>\n";
		while ($data_cook=mysql_fetch_object($cooking_number)) {
			if ($data_cook->type != $_POST['kind'])
			{
				echo "<option value=\"$data_cook->type\">$data_cook->type</option>\n";
			}
		}
		echo "</select>\n
		<p>" . MSG_RECIPE_SEASON . ": <input type=\"text\" size=\"30\" name=\"season\" value=\"{$_POST['season']}\">\n
		<p>" . MSG_RECIPE_TIME . ": <input type=\"text\" size=\"10\" name=\"time\" value=\"{$_POST['time']}\">\n
		<p>" . MSG_RECIPE_DIFFICULTY . ": <select name=\"difficulty\">\n";
		if ($_POST['difficulty'] == "-")
		{
			echo "<option value=\"{$_POST['difficulty']}\">" . MSG_NOT_SPECIFIED . "</option>\n";
		}
		else {
			echo "<option value=\"{$_POST['difficulty']}\">{$_POST['difficulty']}</option>\n";
		}
		while ($data_diff=mysql_fetch_object($difficulty_number)) {
			if ($data_diff->difficulty != $_POST['difficulty'])
			{
				echo "<option value=\"$data_diff->difficulty\">$data_diff->difficulty</option>\n";
			}
		}
		if ($_POST['difficulty'] != "-")
		{
			echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option>\n";
		}
		echo "</select>\n
		<p>" . MSG_RECIPE_INGREDIENTS . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"ingredients\">{$_POST['ingredients']}</textarea>\n
		<p>" . MSG_RECIPE_DESCRIPTION . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"description\">{$_POST['description']}</textarea>\n
		<p>" . MSG_RECIPE_NOTES . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"notes\">{$_POST['notes']}</textarea>\n
		<p>" . MSG_RECIPE_WINES . ": <input type=\"text\" size=\"30\" name=\"wines\" value=\"{$_POST['wines']}\">\n
		<p>" . MSG_ADMIN_MODIFY_IMAGE . ": <input type=\"text\" size=\"30\" name=\"image\" value=\"{$_POST['image']}\">\n
		<p>" . MSG_ADMIN_MODIFY_VIDEO . ": <input type=\"text\" size=\"30\" name=\"video\" value=\"{$_POST['video']}\">\n
		<p><input type=\"submit\" value=\"" . BTN_ADMIN_MODIFY_RECIPE . "\">\n
		";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
}
function cs_CheckEmptyInputConfig($field)
{
	global $trans_sid;
	if (empty($field)) 
	{	
		echo "<p class=\"error\">" . ERROR_INPUT_REQUIRED . "!\n";
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}";
		if ($trans_sid == 0)
		{
			echo "?" . SID;
		}			
		echo "\">\n";
		echo "<table>\n<tr><td><p>" . MSG_ADMIN_CFG_HOSTNAME . ":</td><td><input type=\"text\" name=\"config_server\" value=\"{$_POST['config_server']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_PORT . ":</td><td><input type=\"text\" name=\"config_port\" value=\"{$_POST['config_port']}\" size=\"5\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_DBNAME . ":</td><td><input type=\"text\" name=\"config_dbname\" value=\"{$_POST['config_dbname']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_USER . ":</td><td><input type=\"text\" name=\"config_user\" value=\"{$_POST['config_user']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_PASS . ":</td><td><input type=\"text\" name=\"config_pass\" value=\"{$_POST['config_pass']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_EMAIL . ":</td><td><input type=\"text\" name=\"config_email_address\" value=\"{$_POST['config_email_address']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_LOCALE . ":</td><td><select name=\"config_locale\"><option value=\"{$_POST['config_locale']}\">{$_POST['config_locale']}</option>\n";
		$lang_dir = opendir(dirname(__FILE__)."/lang");
		while (($lang_item = readdir($lang_dir)) !== false) 
		{ 
			if ($lang_item == "." OR $lang_item == "..") continue;
			//Strip away dot and php extension
			$lang_file = str_replace(".php", "", $lang_item);
			if ($lang_file != $_POST['config_locale'])
			{
				echo "<option value=\"$lang_file\">$lang_file</option>\n";
			}
		}  
		closedir($lang_dir);
		echo "
		</select></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_LINES . ":</td><td><input type=\"text\" name=\"config_max_lines_page\" value=\"{$_POST['config_max_lines_page']}\" size=\"3\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_PAGESIZE . ":</td><td><select name=\"config_page_size\">
		<option value=\"{$_POST['config_page_size']}\">{$_POST['config_page_size']}</option>\n";
		$avail_pagesize = array ('A4', 'letter', 'legal'); 
		foreach ($avail_pagesize as $pagesize)
		{
			if ($pagesize != $_POST['config_page_size'])
			{
				echo "<option value=\"$pagesize\">$pagesize</option>\n";
			}
		}
		echo "
		</select></td></tr>\n
		</table>\n
		<input type=\"hidden\" name=\"change\" value=\"ok\">\n
		<div align=center><input type=\"submit\" value=\"" . BTN_ADMIN_CFG_CHANGE . "\"></div>\n
		</form>\n\n";
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
}

function cs_CheckDangerousInputInstall($danger_field)
{
	if (eregi("[!|#�+*<>^?�$%&\/\\]",$danger_field)) 
	{
		cs_AddHeader();
		echo "<h2>" . MSG_SECURITY_WARNING ."!</h2>";
		echo "<p class=\"error\">" . MSG_INPUT_FIELD ." <em>$danger_field</em> " . MSG_INPUT_DANGER .".<br>\n";
		global $page_size_array;
		echo "<p>" . MSG_INSTALL_FORM . "\n";
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n
		<h3>" . MSG_INSTALL_SERVER . "</h3>\n<table width=\"100%\">
		<tr><td><p>" . MSG_ADMIN_CFG_HOSTNAME . ":\n</td>
		<td><input type=\"text\" size=\"30\" name=\"db_hostname\" value=\"{$_POST['db_hostname']}\"></td>\n
		<td><p>" . MSG_ADMIN_CFG_PORT . ":\n</td>
		<td><input type=\"text\" size=\"30\" name=\"db_port\" value=\"{$_POST['db_port']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_USER . "\n</td>
		<td><input type=\"text\" size=\"30\" name=\"db_username\" value=\"{$_POST['db_username']}\"></td>\n
		<td><p>" . MSG_ADMIN_CFG_PASS . "\n</td><td><input type=\"password\" size=\"30\" name=\"db_password\" value=\"{$_POST['db_password']}\"></td></tr>
		<tr><td><p>" . MSG_ADMIN_CFG_DBNAME . "\n</td>
		<td><input type=\"text\" size=\"30\" name=\"{$_POST['db_name']}\" value=\"ricette\"></td>
		<td colspan=\"2\">&nbsp;</td></tr>\n</table>\n
		<h3>" . MSG_INSTALL_APPLICATION . "</h3>\n
		<table width=\"100%\">
		<tr><td><p>" . MSG_ADMIN_CFG_LINES . ":\n</td>
		<td><input type=\"text\" size=\"3\" name=\"sw_lines_per_page\" value=\"{$_POST['sw_lines_per_page']}\"></td>\n
		<td><p>" . MSG_ADMIN_CFG_PAGESIZE . ":\n</td><td><select name=\"sw_page_size\">\n";
		foreach ($page_size_array as $available_size)
		{
			echo "<option value=\"$available_size\">$available_size</option>\n";
		}
		echo "</select></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_EMAIL . ":\n</td>
		<td colspan=\"3\"><input type=\"text\" size=\"50\" name=\"sw_email_address\" value=\"{$_POST['sw_email_address']}\">
		</td></tr></table>\n
		<br><h3>" . MSG_INSTALL_ADMIN . "</h3>\n
		<table width=\"100%\">
		<tr><td><p>" . MSG_ADMIN_USER . ":</td>
		<td><input type=\"text\" size=\"20\" name=\"sw_admin_user\" value=\"{$_POST['sw_admin_user']}\"></td>
		<td><p>" . MSG_ADMIN_PASS . ":</td>
		<td><input type=\"password\" size=\"20\" name=\"sw_admin_password\" value=\"{$_POST['sw_admin_password']}\"></td></tr></table>\n
		<input type=\"hidden\" name=\"installation\" value=\"ok\">\n
		<input type=\"hidden\" name=\"sw_locale\" value=\"{$_POST['sw_locale']}\">
		<div align=center><input type=\"submit\" value=\"" . BTN_INSTALL . "\"></div></form>\n";
		exit();
	}
}
function cs_CheckDangerousInputNoSlash($danger_field)
{
	if (eregi("[!|#�+*<>^?�$%&]",$danger_field)) 
	{
		echo "<h2>" . MSG_SECURITY_WARNING ."!</h2>";
		echo "<p class=\"error\">" . MSG_INPUT_FIELD ." <em>$danger_field</em> " . MSG_INPUT_DANGER .".<br>\n<a href=\"{$_SERVER['HTTP_REFERER']}\">" . MSG_BACK ."</a>\n";
		exit();
	}
}
function cs_CheckEmptyFormField($empty)
{
	global $trans_sid;
	if (empty($empty))
	{
		echo "<p class=\"error\">" . ERROR_INPUT_REQUIRED . "!\n";
		cs_AddFooter();
		exit();
	}
}
function cs_CheckDangerousFormField($danger)
{
	if (eregi("[!|#�+*<>^?�$%&\/\\]",$danger)) 
	{
		echo "<p class=\"error\">" . MSG_INPUT_FIELD ." <em>$danger</em> " . MSG_INPUT_DANGER .".<br>\n<a href=\"{$_SERVER['HTTP_REFERER']}\">" . MSG_BACK ."</a>\n";
		cs_AddFooter();
		exit();
	}
}
function cs_ConfigValueEmpty($configvar)
{
	if (empty($configvar))
	{
		echo "<p class=\"error\">" . ERROR_CONFIG_NOT_SET . ".<br>\n";
		session_unset();
		session_destroy();
		echo "<a href=\"install.php\">" . MSG_RESTART_INSTALL . ".\n";
		cs_AddFooter();
		exit();
	}
}
function cs_CheckEmptyValueInstall($field)
{
	if (empty($field))
	{
	global $page_size_array;
	cs_AddHeader();
	echo "<p class=\"error\">" . ERROR_INPUT_REQUIRED . ".<br>\n";
	echo "<p>" . MSG_INSTALL_FORM . "\n";
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n
	<h3>" . MSG_INSTALL_SERVER . "</h3>\n<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_CFG_HOSTNAME . ":\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_hostname\" value=\"{$_POST['db_hostname']}\"></td>\n
	<td><p>" . MSG_ADMIN_CFG_PORT . ":\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_port\" value=\"{$_POST['db_port']}\"></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_CFG_USER . "\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_username\" value=\"{$_POST['db_username']}\"></td>\n
	<td><p>" . MSG_ADMIN_CFG_PASS . "\n</td><td><input type=\"password\" size=\"30\" name=\"db_password\" value=\"{$_POST['db_password']}\"></td></tr>
	<tr><td><p>" . MSG_ADMIN_CFG_DBNAME . "\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_name\" value=\"{$_POST['db_name']}\"></td>
	<td colspan=\"2\">&nbsp;</td></tr>\n</table>\n
	<h3>" . MSG_INSTALL_APPLICATION . "</h3>\n
	<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_CFG_LINES . ":\n</td>
	<td><input type=\"text\" size=\"3\" name=\"sw_lines_per_page\" value=\"{$_POST['sw_lines_per_page']}\"></td>\n
	<td><p>" . MSG_ADMIN_CFG_PAGESIZE . ":\n</td><td><select name=\"sw_page_size\">\n";
	foreach ($page_size_array as $available_size)
	{
		echo "<option value=\"$available_size\">$available_size</option>\n";
	}
	echo "</select></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_CFG_EMAIL . ":\n</td>
	<td colspan=\"3\"><input type=\"text\" size=\"50\" name=\"sw_email_address\" value=\"{$_POST['sw_email_address']}\">
	</td></tr></table>\n
	<br><h3>" . MSG_INSTALL_ADMIN . "</h3>\n
	<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_USER . ":</td>
	<td><input type=\"text\" size=\"20\" name=\"sw_admin_user\" value=\"{$_POST['sw_admin_user']}\"></td>
	<td><p>" . MSG_ADMIN_PASS . ":</td>
	<td><input type=\"password\" size=\"20\" name=\"sw_admin_password\" value=\"{$_POST['sw_admin_password']}\"></td></tr></table>\n
	<input type=\"hidden\" name=\"installation\" value=\"ok\">\n
	<input type=\"hidden\" name=\"sw_locale\" value=\"{$_POST['sw_locale']}\">
	<div align=center><input type=\"submit\" value=\"" . BTN_INSTALL . "\"></div></form>\n";
	exit();
	}
}

function foodie_AlphaLinks($prefix)
{
	$alphabet = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9");
	echo "<p>";
	foreach ($alphabet as $letter)
	{
		echo "<a href=\"".$prefix."letter=$letter\">$letter</a> ";
	}
}

// parameters: $query - SQL query to use, $parameter - optional, which parameter to print
function foodie_PrintBrowseTable($query, $parameter = 'id')
{
	echo "<table class=\"browse\">";
	while ($recipe_row = $query->fetch_array()) 
	{
        echo "<tr>";
        if ($parameter != 'id') {
            echo "<td><strong>{$recipe_row[$parameter]}</strong></td>";
        }
		echo "<td><a href=\"recipe.php?recipe={$recipe_row['id']}\">{$recipe_row['name']}</a></td></tr>\n";
	}
	echo "</table>\n";
}

//Print recipe data
function foodie_PrintRecipeData($recipe_data)
{
	echo "<p>&nbsp;\n<br>\n<table class=\"recipe\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\">";

	echo "<tr><td class=\"recipe-title\">" . MSG_RECIPE_NAME . "</strong></td><td class=\"recipe-title\"><strong>{$recipe_data['name']}</strong></td></tr>\n";
	if (!empty($recipe_data["image"]))
	{
		echo "<tr><td colspan=2 class=\"recipe-image\"><img src=\"images/{$recipe_data['image']}\" alt=\"{$recipe_data['image']}\"></td></tr>\n";
	} else
	{
		echo "<tr><td colspan=2 style=\"text-align:left;\" class=\"recipe-image\">" . MSG_RECIPE_IMAGE_UNAVAILABLE ;
        if (isset($_SESSION['admin_user'])) {
            echo " <a href=\"admin_mmedia.php?recipe_id={$recipe_data['id']}\">". MSG_RECIPE_ADD_NEW ."</a>";
        }
        echo "</td></tr>\n";
	}

	echo "<tr><td>" . MSG_RECIPE_SERVING . "</td><td>{$recipe_data['dish']}</td></tr>\n";
	echo "<tr><td>" . MSG_RECIPE_MAIN . "</td><td>{$recipe_data['mainingredient']}</td></tr>\n";
	echo "<tr><td>" . MSG_RECIPE_PEOPLE . "</td><td>{$recipe_data['people']}</td></tr>\n";
	echo "<tr><td>" . MSG_RECIPE_ORIGIN . "</td><td>{$recipe_data['origin']}</td></tr>\n";
	echo "<tr><td>" . MSG_RECIPE_SEASON . "</td><td>{$recipe_data['season']}</td></tr>\n";
	echo "<tr><td>" . MSG_RECIPE_COOKING . "</td><td>{$recipe_data['kind']}</td></tr>\n";
	echo "<tr><td>" . MSG_RECIPE_TIME . "</td><td>{$recipe_data['time']}</td></tr>\n";
	echo "<tr><td>" . MSG_RECIPE_DIFFICULTY . "</td><td>\n";
	for ($i = 1; $i <= $recipe_data["difficulty"]; $i++) 
	{
		echo "*";
	}
	echo "</td></tr>\n";
	echo "<tr><td>" . MSG_RECIPE_WINES . "</td><td>{$recipe_data['wines']}</td></tr>\n";
	$recipe_ingredients = nl2br($recipe_data['ingredients']);
	echo "<tr><td>" . MSG_RECIPE_INGREDIENTS . "</td><td>$recipe_ingredients</td></tr>\n";
	$recipe_description = nl2br($recipe_data['description']);
	echo "<tr><td>" . MSG_RECIPE_DESCRIPTION . "</td><td>$recipe_description</td></tr>\n";
	$recipe_notes = nl2br($recipe_data['notes']);
	echo "<tr><td>" . MSG_RECIPE_NOTES . "</td><td>$recipe_notes</td></tr>\n";
	echo "</table>\n";
}

//Print browse table used to delete recipes
function cs_PrintDeleteTable()
{
	global $exec_db_browse;
	global $trans_sid;
	echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\" bgcolor=\"#aaaaaa\">";
	$arr_element = 0;
	$line_number = 1;
	while ($recipe_browse_list = mysql_fetch_object($exec_db_browse)) 
	{
		$list_data[$arr_element][0] = $recipe_browse_list->id;
		$list_data[$arr_element][1] = $recipe_browse_list->name;
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
		echo "<a href=\"admin_delete.php?recipe=$list_var[0]";
		if ($trans_sid == 0)
		{
			echo "&" . SID;
		}
		echo "\">$list_var[1]</a>";
		echo "</td></tr>\n";
	}
	echo "</table>\n";
}
//Print browse table used to modify/delete cooking types
function cs_PrintCookingTable($action)
{
	global $exec_db_browse;
	global $trans_sid;
	echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\" bgcolor=\"#aaaaaa\">";
	$arr_element = 0;
	$line_number = 1;
	$list_num_rows = mysql_num_rows($exec_db_browse);
	if ($list_num_rows == 0)
	{
		echo "<p>" . MSG_NO_COOKING_TYPE . "\n";
		cs_AddFooter();
		exit();
	}
	while ($cook_browse_list = mysql_fetch_object($exec_db_browse)) 
	{
		$list_data[$arr_element][0] = $cook_browse_list->id;
		$list_data[$arr_element][1] = $cook_browse_list->type;
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
		echo "<tr><td bgcolor=\"$row_color\"><a href=\"admin_cook.php?action=$action&recipe=$list_var[0]";
		if ($trans_sid == 0)
		{
			echo "&" . SID;
		}
		echo "\">$list_var[1]</a></td></tr>\n";
	}
	echo "</table>\n";
}
//Print browse table used to modify/delete dishes
function cs_PrintDishTable($action)
{
	global $trans_sid;
	global $exec_db_browse;
	echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\" bgcolor=\"#aaaaaa\">";
	$arr_element = 0;
	$line_number = 1;
	$list_num_rows = mysql_num_rows($exec_db_browse);
	if ($list_num_rows == 0)
	{
		echo "<p>" . MSG_NO_SERVING . "\n";
		cs_AddFooter();
		exit();
	}
	while ($dish_browse_list = mysql_fetch_object($exec_db_browse)) 
	{
		$list_data[$arr_element][0] = $dish_browse_list->id;
		$list_data[$arr_element][1] = $dish_browse_list->dish;
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
		echo "<tr><td bgcolor=\"$row_color\">";
		echo "<a href=\"admin_dish.php?action=$action&recipe=$list_var[0]";
		if ($trans_sid == 0)
		{
			echo "&" . SID;
		}
		echo "\">$list_var[1]</a>";
		echo "</td></tr>\n";
	}
	echo "</table>\n";
}

function cs_PrintInstallationForm()
{
	global $page_size_array;
	echo "<p>" . MSG_INSTALL_FORM . "\n";
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n
	<h3>" . MSG_INSTALL_SERVER . "</h3>\n<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_CFG_HOSTNAME . ":\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_hostname\" value=\"{$_POST['db_hostname']}\"></td>\n
	<td><p>" . MSG_ADMIN_CFG_PORT . ":\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_port\" value=\"{$_POST['db_port']}\"></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_CFG_USER . "\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_username\" value=\"{$_POST['db_username']}\"></td>\n
	<td><p>" . MSG_ADMIN_CFG_PASS . "\n</td><td><input type=\"password\" size=\"30\" name=\"db_password\" value=\"{$_POST['db_password']}\"></td></tr>
	<tr><td><p>" . MSG_ADMIN_CFG_DBNAME . "\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_name\" value=\"{$_POST['db_name']}\"></td>
	<td colspan=\"2\">&nbsp;</td></tr>\n</table>\n
	<h3>" . MSG_INSTALL_APPLICATION . "</h3>\n
	<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_CFG_LINES . ":\n</td>
	<td><input type=\"text\" size=\"3\" name=\"sw_lines_per_page\" value=\"{$_POST['sw_lines_per_page']}\"></td>\n
	<td><p>" . MSG_ADMIN_CFG_PAGESIZE . ":\n</td><td><select name=\"sw_page_size\">\n";
	foreach ($page_size_array as $available_size)
	{
		echo "<option value=\"$available_size\">$available_size</option>\n";
	}
	echo "</select></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_CFG_EMAIL . ":\n</td>
	<td colspan=\"3\"><input type=\"text\" size=\"50\" name=\"sw_email_address\" value=\"{$_POST['sw_email_address']}\">
	</td></tr></table>\n
	<br><h3>" . MSG_INSTALL_ADMIN . "</h3>\n
	<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_USER . ":</td>
	<td><input type=\"text\" size=\"20\" name=\"sw_admin_user\" value=\"{$_POST['sw_admin_user']}\"></td>
	<td><p>" . MSG_ADMIN_PASS . ":</td>
	<td><input type=\"password\" size=\"20\" name=\"sw_admin_password\" value=\"{$_POST['sw_admin_password']}\"></td></tr></table>\n
	<input type=\"hidden\" name=\"installation\" value=\"ok\">\n
	<input type=\"hidden\" name=\"sw_locale\" value=\"{$_POST['sw_locale']}\">
	<div align=center><input type=\"submit\" value=\"" . BTN_INSTALL . "\"></div></form>\n";
	exit();
}
function cs_PrintInsertRecipeForm()
{
	global $trans_sid;
	$dish_number = mysql_query("SELECT * FROM dish");
	$difficulty_number = mysql_query("SELECT * FROM difficulty");
	$cooking_number = mysql_query("SELECT * FROM cooking");
	echo "<p class=\"mandatory\">" . MSG_ASTERISK . "\n";
	echo "<form method=post action=\"admin_insert.php";
	if ($trans_sid == 0)
	{
		echo "?" . SID;
	}
	echo "\">\n";
	echo "<input type=\"hidden\" name=\"action\" value=\"ins_preview\">\n<p>" . MSG_RECIPE_NAME . "&nbsp;*:\n<input type=\"text\" size=\"30\" name=\"name\" value=\"".stripslashes("{$_POST['name']}")."\"><p>" . MSG_RECIPE_SERVING . "&nbsp;*:\n";
	if (!empty($_POST['dish']))
	{
		echo "<select name=dish><option value=\"{$_POST['dish']}\"\">{$_POST['dish']}</option>\n";
		while ($data_dish=mysql_fetch_object($dish_number)) 
		{
			if ($data_dish->dish != $_POST['dish'])
			{
				echo "<option value=\"$data_dish->dish\">$data_dish->dish</option>\n";
			}
		}
	} 
	else
	{
		echo "<select name=dish><option value=\"\">" . MSG_CHOOSE_SERVING . "</option><option value=\"\">----------------</option>\n";
		while ($data_dish=mysql_fetch_object($dish_number)) 
		{
			echo "<option value=\"$data_dish->dish\">$data_dish->dish</option>\n";
		}
	}
	echo "</select>\n";
	echo "<p>" . MSG_RECIPE_MAIN . "&nbsp;*:\n<input type=\"text\" size=\"30\" name=\"mainingredient\" value=\"".stripslashes($_POST['mainingredient'])."\"><p>" . MSG_RECIPE_PEOPLE . ":\n<input type=\"text\" size=\"2\" name=\"people\" value=\"".stripslashes($_POST['people'])."\">\n<p>" . MSG_RECIPE_ORIGIN . ":\n<input type=\"text\" size=\"30\" name=\"origin\" value=\"".stripslashes($_POST['origin'])."\">\n<p>" . MSG_RECIPE_SEASON . ":\n<input type=\"text\" size=\"30\" name=\"season\" value=\"".stripslashes($_POST['season'])."\">\n<p>" . MSG_RECIPE_COOKING . "&nbsp;*:\n";
	if (!empty($_POST['kind']))
	{
		echo "<select name=kind><option value=\"{$_POST['kind']}\">{$_POST['kind']}</option>\n";
		while ($data_cook=mysql_fetch_object($cooking_number)) 
		{
			if ($data_cook->type != $_POST['kind'])
			{
				echo "<option value=\"$data_cook->type\">$data_cook->type</option>\n";
			}
		}

	} 
	else
	{
		echo "<select name=kind><option value=\"\">" . MSG_CHOOSE_COOKING . "</option><option value=\"\">----------------</option>\n";
		while ($data_cook=mysql_fetch_object($cooking_number)) 
		{
			echo "<option value=\"$data_cook->type\">$data_cook->type</option>\n";
		}
	}
	echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option></select>\n";
	echo "<p>" . MSG_RECIPE_TIME . ":\n<input type=\"text\" size=\"30\" name=\"time\" value=\"".stripslashes($_POST['time'])."\"><p>" . MSG_RECIPE_DIFFICULTY . "&nbsp;*:\n ";
	if(!empty($_POST['difficulty']))
	{
		echo "<select name=difficulty><option value=\"{$_POST['difficulty']}\">{$_POST['difficulty']}</option>\n";
		while ($data_difficulty=mysql_fetch_object($difficulty_number)) 
		{
			if ($data_diffculty->difficulty != $_POST['difficulty'])
			{
				echo "<option value=\"$data_difficulty->difficulty\">$data_difficulty->difficulty</option>\n";
			}
		}
	}
	else
	{
		echo "<select name=difficulty><option value=\"\">" . MSG_CHOOSE_DIFFICULTY . "</option><option value=\"\">--------------------</option>\n";
		while ($data_difficulty=mysql_fetch_object($difficulty_number)) 
		{
			echo "<option value=\"$data_difficulty->difficulty\">$data_difficulty->difficulty</option>\n";
		}
	}
	echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option></select>\n";
	echo "</select>\n";
	echo "<p>" . MSG_RECIPE_WINES . ":\n<input type=\"text\" size=\"30\" name=\"wine\" value=\"".stripslashes($_POST['wine'])."\"><p>" . MSG_RECIPE_INGREDIENTS . "&nbsp;*:\n<br><textarea cols=60 rows=5 name=\"ingredients\" wrap=\"virtual\">".stripslashes($_POST['ingredients'])."</textarea>\n<p>" . MSG_RECIPE_DESCRIPTION . "&nbsp;*:\n<br><textarea cols=60 rows=5 name=\"description\" wrap=\"virtual\">".stripslashes($_POST['description'])."</textarea>\n<p>" . MSG_RECIPE_NOTES . ":\n<br><textarea cols=60 rows=5 name=\"notes\" wrap=\"virtual\">".stripslashes($_POST['notes'])."</textarea>\n<p><input type=\"submit\" value=\"" . BTN_INSERT_PREVIEW . "\">\n&nbsp;<input type=\"reset\" value=\"" . BTN_INSERT_CLEAR . "\">\n</form>\n";
}

?>
