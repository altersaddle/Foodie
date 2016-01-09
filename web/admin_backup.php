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
echo "<h3>" . MSG_ADMIN_MENU_BACKUP_BKP. "</h3>\n";
if (!isset($_POST['backup_action']))
{
	echo "<p>" . MSG_ADMIN_BACKUP_SAVEDIR . "\n";
	echo "<form method=\"post\" action=\"admin_backup.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<p><input type=\"hidden\" name=\"backup_action\" value=\"do_backup\">
	<p><input type=\"submit\" value=\"" . BTN_ADMIN_BACKUP_PROCEED . "\">
	</form>\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
if (isset($_POST['backup_action']))
{
	//If $_POST variable is correctly set save slq backup file
	if ($_POST['backup_action'] == "do_backup")
	{
		if (file_exists(dirname(__FILE__)."/backup/crisoftricette.sql"))
		{
			unlink(dirname(__FILE__)."/backup/crisoftricette.sql");
			echo "<p>" . MSG_ADMIN_BACKUP_OLDDEL . "\n";
		}
		$backup_file = fopen(dirname(__FILE__)."/backup/crisoftricette.sql", "w");
		if (!$backup_file)
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_SUBDIR . "\n";
			echo "<br>" . MSG_ADMIN_BACKUP_CRASHED . "\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p>" . MSG_ADMIN_BACKUP_BACKING . "...\n";
		fputs($backup_file, "#   SQL backup file for CrisoftRicette\n");
		//Backup admin table
		$sql_admin = "SELECT * FROM admin";
		if (!$exec_admin = mysql_query($sql_admin))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " admin.<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		fputs($backup_file, "DROP TABLE IF EXISTS admin;\n");
		fputs($backup_file, "CREATE TABLE admin (user varchar(50) NOT NULL default '', password varchar(50) NOT NULL default '') TYPE=MyISAM;\n");
		while ($dump_admin = mysql_fetch_object($exec_admin))
		{
			fputs($backup_file, "INSERT INTO admin VALUES('$dump_admin->user', '$dump_admin->password');\n");
		}
		//Backup cooking table
		$sql_cooking = "SELECT * FROM cooking";
		if (!$exec_cooking = mysql_query($sql_cooking))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " cooking.<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		fputs($backup_file, "DROP TABLE IF EXISTS cooking;\n");
		fputs($backup_file, "CREATE TABLE cooking (id int(3) unsigned zerofill NOT NULL auto_increment, type varchar(255) NOT NULL default '', PRIMARY KEY  (id)) TYPE=MyISAM;\n");
		while ($dump_cooking = mysql_fetch_object($exec_cooking))
		{
			$cooking_type = addslashes($dump_cooking->type);
			fputs($backup_file, "INSERT INTO cooking VALUES($dump_cooking->id, '$cooking_type');\n");
		}
		//Backup difficulty table
		$sql_difficulty = "SELECT * FROM difficulty";
		if (!$exec_difficulty = mysql_query($sql_difficulty))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " difficulty.<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		fputs($backup_file, "DROP TABLE IF EXISTS difficulty;\n");
		fputs($backup_file, "CREATE TABLE difficulty (id int(1) unsigned zerofill NOT NULL auto_increment, difficulty int(1) NOT NULL default '0', PRIMARY KEY  (id)) TYPE=MyISAM;\n");
		while ($dump_difficulty = mysql_fetch_object($exec_difficulty))
		{
			fputs($backup_file, "INSERT INTO difficulty VALUES($dump_difficulty->id, $dump_difficulty->difficulty);\n");
		}
		//Backup dish table
		$sql_dish = "SELECT * FROM dish";
		if (!$exec_dish = mysql_query($sql_dish))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " dish.<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		fputs($backup_file, "DROP TABLE IF EXISTS dish;\n");
		fputs($backup_file, "CREATE TABLE dish (id int(3) unsigned zerofill NOT NULL auto_increment, dish varchar(255) NOT NULL default '', PRIMARY KEY  (id)) TYPE=MyISAM;\n");
		while ($dump_dish = mysql_fetch_object($exec_dish))
		{
			$dish_dish = addslashes($dump_dish->dish);
			fputs($backup_file, "INSERT INTO dish VALUES($dump_dish->id, '$dish_dish');\n");
		}
		//Backup main table
		$sql_main = "SELECT * FROM main";
		if (!$exec_main = mysql_query($sql_main))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " main.<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		fputs($backup_file, "DROP TABLE IF EXISTS main;\n");
		fputs($backup_file, "CREATE TABLE main (id int(8) unsigned zerofill NOT NULL auto_increment, name varchar(255) NOT NULL default '', dish varchar(255) NOT NULL default '', mainingredient varchar(255) NOT NULL default '', people varchar(4) NOT NULL default '', origin varchar(255) NOT NULL default '', ingredients text NOT NULL, description text NOT NULL, kind varchar(255) NOT NULL default '', season varchar(255) NOT NULL default '', time varchar(255) NOT NULL default '', difficulty varchar(255) NOT NULL default '', notes text NOT NULL, image varchar(255) NOT NULL default '', video varchar(255) NOT NULL default '', wines varchar(255) NOT NULL default '', PRIMARY KEY  (id), KEY id (id)) TYPE=MyISAM;\n");
		while ($dump_main = mysql_fetch_object($exec_main))
		{
			$main_name = addslashes($dump_main->name);
			$main_dish = addslashes($dump_main->dish);
			$main_mainingredient = addslashes($dump_main->mainingredient);
			$main_origin = addslashes($dump_main->origin);
			$main_ingredients = addslashes($dump_main->ingredients);
			$main_description = addslashes($dump_main->description);
			$main_kind = addslashes($dump_main->kind);
			$main_season = addslashes($dump_main->season);
			$main_time = addslashes($dump_main->time);
			$main_notes = addslashes($dump_main->notes);
			$main_wines = addslashes($dump_main->wines);
			$main_ingredients = str_replace("\n", "", $main_ingredients);
			$main_ingredients = str_replace("\r", "", $main_ingredients);
			$main_ingredients = str_replace("\r\n", "", $main_ingredients);
			$main_description = str_replace("\n", "", $main_description);
			$main_description = str_replace("\r", "", $main_description);
			$main_description = str_replace("\r\n", "", $main_description);
			$main_notes = str_replace("\n", "", $main_notes);
			$main_notes = str_replace("\r", "", $main_notes);
			$main_notes = str_replace("\r\n", "", $main_notes);
			fputs($backup_file, "INSERT INTO main VALUES($dump_main->id, '$main_name', '$main_dish', '$main_mainingredient', '$dump_main->people', '$main_origin', '$main_ingredients', '$main_description', '$main_kind', '$main_season', '$main_time', '$dump_main->difficulty', '$main_notes', '$dump_main->image', '$dump_main->video', '$main_wines');\n");
		}
		//Backup personal_book
		$sql_personal_book = "SELECT * FROM personal_book";
		if (!$exec_personal_book = mysql_query($sql_personal_book))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " personal_book.<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		fputs($backup_file, "DROP TABLE IF EXISTS personal_book;\n");
		fputs($backup_file, "CREATE TABLE personal_book (id int(8) unsigned zerofill NOT NULL default '00000000', recipe_name varchar(255) NOT NULL default '', KEY id (id)) TYPE=MyISAM;\n");
		while ($dump_personal_book = mysql_fetch_object($exec_personal_book))
		{
			$personal_book_recipe_name = addslashes($dump_personal_book->recipe_name);
			fputs($backup_file, "INSERT INTO personal_book VALUES($dump_personal_book->id, '$personal_book_recipe_name');\n");
		}
		//Backup rating
		$sql_rating = "SELECT * FROM rating";
		if (!$exec_rating = mysql_query($sql_rating))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " rating.<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		fputs($backup_file, "DROP TABLE IF EXISTS rating;\n");
		fputs($backup_file, "CREATE TABLE rating (id int(8) unsigned zerofill NOT NULL default '00000000', vote smallint(1) NOT NULL default '0', KEY id (id)) TYPE=MyISAM;\n");
		while ($dump_rating = mysql_fetch_object($exec_rating))
		{
			fputs($backup_file, "INSERT INTO rating VALUES($dump_rating->id, $dump_rating->vote);\n");
		}
		//Backup shopping
		$sql_shopping = "SELECT * FROM shopping";
		if (!$exec_shopping = mysql_query($sql_shopping))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " shopping.<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		fputs($backup_file, "DROP TABLE IF EXISTS shopping;\n");
		fputs($backup_file, "CREATE TABLE shopping (id int(8) unsigned zerofill NOT NULL auto_increment, recipe varchar(255) NOT NULL default '0', ingredients text NOT NULL, PRIMARY KEY  (id)) TYPE=MyISAM;\n");
		while ($dump_shopping = mysql_fetch_object($exec_shopping))
		{
			$shopping_recipe = addslashes($dump_shopping->recipe);
			$shopping_ingredients = addslashes($dump_shopping->ingredients);
			$shopping_ingredients = str_replace("\n", "", $shopping_ingredients);
			$shopping_ingredients = str_replace("\r", "", $shopping_ingredients);
			$shopping_ingredients = str_replace("\r\n", "", $shopping_ingredients);
			fputs($backup_file, "INSERT INTO shopping VALUES($dump_shopping->id, '$shopping_recipe', '$shopping_ingredients');\n");
		}
		fclose ($backup_file);
		echo "<p>" . MSG_ADMIN_BACKUP_FILE . " <a href=\"backup/crisoftricette.sql\" target=\"_blank\">backup/crisoftricette.sql</a> " . MSG_ADMIN_BACKUP_FILE . ".\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	//if $_POST has not expected value terminate with error
	echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
}
//Fast logout from admin area
cs_AdminFastLogout();
cs_AddFooter();
?>
