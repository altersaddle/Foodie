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
require(dirname(__FILE__)."/includes/dbcommands.inc.php");

$filename = "foodie.sql";

if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php?redirect=".urlencode($_SERVER["REQUEST_URI"]));
}
else {
    foodie_Begin();
foodie_AdminHeader();
    echo "<h2>" . MSG_ADMIN . "</h2>\n";
    echo "<h3>" . MSG_ADMIN_MENU_BACKUP_BKP. "</h3>\n";
    if (!isset($_POST['backup_action']))
    {
	    echo "<p>" . MSG_ADMIN_BACKUP_SAVEDIR . "\n";
	    echo "<form method=\"post\" action=\"admin_backup.php\">\n";
	    echo "<p><input type=\"hidden\" name=\"backup_action\" value=\"do_backup\">
	    <p><input type=\"submit\" value=\"" . BTN_ADMIN_BACKUP_PROCEED . "\">
	    </form>\n";
	
	    foodie_Footer();
	    exit();
    }
    else
    {
	    //If $_POST variable is correctly set save sql backup file
	    if ($_POST['backup_action'] == "do_backup")
	    {
            // Save character set
            $charset = $dbconnect->character_set_name();
            $dbconnect->set_charset("utf8");
		    if (file_exists(dirname(__FILE__)."/backup/$filename"))
		    {
			    unlink(dirname(__FILE__)."/backup/$filename");
			    echo "<p>" . MSG_ADMIN_BACKUP_OLDDEL . "\n";
		    }
		    $backup_file = fopen(dirname(__FILE__)."/backup/$filename", "w");
		    if (!$backup_file)
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_SUBDIR . "\n";
			    echo "<br>" . MSG_ADMIN_BACKUP_CRASHED . "\n";
			
			    foodie_Footer();
			    exit();
		    }
		    echo "<p>" . MSG_ADMIN_BACKUP_BACKING . "...\n";
		    fputs($backup_file, "#   SQL backup file for Foodie\n");
		    //Backup admin table
		    $sql_admin = "SELECT * FROM admin";
		    if (!$exec_admin = $dbconnect->query($sql_admin))
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " admin.<br>\n" . $exec_admin->error();
			
			    foodie_Footer();
			    exit();
		    }
		    fputs($backup_file, "DROP TABLE IF EXISTS admin;\n");
		    fputs($backup_file, $dbcreatecommands['admin'].";\n");
		    while ($dump_admin = $exec_admin->fetch_object())
		    {
			    fputs($backup_file, "INSERT INTO admin VALUES ('$dump_admin->user', '$dump_admin->password');\n");
		    }
		    //Backup cooking table
		    $sql_cooking = "SELECT * FROM cooking";
		    if (!$exec_cooking = $dbconnect->query($sql_cooking))
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " cooking.<br>\n" . $exec_cooking->error();
			
			    foodie_Footer();
			    exit();
		    }
		    fputs($backup_file, "DROP TABLE IF EXISTS cooking;\n");
		    fputs($backup_file, $dbcreatecommands['cooking'].";\n");
		    while ($dump_cooking = $exec_cooking->fetch_object())
		    {
			    $cooking_type = $dbconnect->real_escape_string($dump_cooking->type);
			    fputs($backup_file, "INSERT INTO cooking VALUES ($dump_cooking->id, '$cooking_type');\n");
		    }
		    //Backup difficulty table
		    $sql_difficulty = "SELECT * FROM difficulty";
		    if (!$exec_difficulty = $dbconnect->query($sql_difficulty))
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " difficulty.<br>\n" . $exec_difficulty->error();
			
			    foodie_Footer();
			    exit();
		    }
		    fputs($backup_file, "DROP TABLE IF EXISTS difficulty;\n");
		    fputs($backup_file, $dbcreatecommands['difficulty'].";\n");
		    while ($dump_difficulty = $exec_difficulty->fetch_object())
		    {
			    fputs($backup_file, "INSERT INTO difficulty VALUES ($dump_difficulty->id, $dump_difficulty->difficulty);\n");
		    }
		    //Backup dish table
		    $sql_dish = "SELECT * FROM dish";
		    if (!$exec_dish = $dbconnect->query($sql_dish))
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " dish.<br>\n" . $exec_dish->error();
			
			    foodie_Footer();
			    exit();
		    }
		    fputs($backup_file, "DROP TABLE IF EXISTS dish;\n");
		    fputs($backup_file, $dbcreatecommands['dish'].";\n");
		    while ($dump_dish = $exec_dish->fetch_object())
		    {
			    $dish_dish = $dbconnect->real_escape_string($dump_dish->dish);
			    fputs($backup_file, "INSERT INTO dish VALUES ($dump_dish->id, '$dish_dish');\n");
		    }
		    //Backup main table
		    $sql_main = "SELECT * FROM main";
		    if (!$exec_main = $dbconnect->query($sql_main))
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " main.<br>\n" . $exec_main->error();
			    foodie_Footer();
			    exit();
		    }
		    fputs($backup_file, "DROP TABLE IF EXISTS main;\n");
		    fputs($backup_file, $dbcreatecommands['main'].";\n");
		    while ($dump_main = $exec_main->fetch_object())
		    {
			    $main_name = $dbconnect->real_escape_string($dump_main->name);
			    $main_dish = $dbconnect->real_escape_string($dump_main->dish);
			    $main_mainingredient = $dbconnect->real_escape_string($dump_main->mainingredient);
			    $main_origin = $dbconnect->real_escape_string($dump_main->origin);
			    $main_ingredients = $dbconnect->real_escape_string($dump_main->ingredients);
			    $main_description = $dbconnect->real_escape_string($dump_main->description);
			    $main_kind = $dbconnect->real_escape_string($dump_main->kind);
			    $main_season = $dbconnect->real_escape_string($dump_main->season);
			    $main_time = $dbconnect->real_escape_string($dump_main->time);
			    $main_notes = $dbconnect->real_escape_string($dump_main->notes);
			    $main_wines = $dbconnect->real_escape_string($dump_main->wines);
			    fputs($backup_file, "INSERT INTO main VALUES ($dump_main->id, '$main_name', '$main_dish', '$main_mainingredient', '$dump_main->people', '$main_origin', '$main_ingredients', '$main_description', '$main_kind', '$main_season', '$main_time', '$dump_main->difficulty', '$main_notes', '$dump_main->image', '$dump_main->video', '$main_wines');\n");
		    }
		    //Backup personal_book
		    $sql_personal_book = "SELECT * FROM personal_book";
		    if (!$exec_personal_book = $dbconnect->query($sql_personal_book))
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " personal_book.<br>\n" . $exec_personal_book->error();
			
			    foodie_Footer();
			    exit();
		    }
		    fputs($backup_file, "DROP TABLE IF EXISTS personal_book;\n");
		    fputs($backup_file, $dbcreatecommands['personal_book'].";\n");
		    while ($dump_personal_book = $exec_personal_book->fetch_object())
		    {
			    $personal_book_recipe_name = $dbconnect->real_escape_string($dump_personal_book->recipe_name);
			    fputs($backup_file, "INSERT INTO personal_book VALUES ($dump_personal_book->id, '$personal_book_recipe_name');\n");
		    }
		    //Backup rating
		    $sql_rating = "SELECT * FROM rating";
		    if (!$exec_rating = $dbconnect->query($sql_rating))
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " rating.<br>\n" . $exec_rating->error();
			
			    foodie_Footer();
			    exit();
		    }
		    fputs($backup_file, "DROP TABLE IF EXISTS rating;\n");
		    fputs($backup_file, $dbcreatecommands['rating'].";\n");
		    while ($dump_rating = $exec_rating->fetch_object())
		    {
			    fputs($backup_file, "INSERT INTO rating VALUES ($dump_rating->id, $dump_rating->vote);\n");
		    }
		    //Backup shopping
		    $sql_shopping = "SELECT * FROM shopping";
		    if (!$exec_shopping = $dbconnect->query($sql_shopping))
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_BACKUP_TABLE . " shopping.<br>\n" . $exec_shopping->error();
			
			    foodie_Footer();
			    exit();
		    }
		    fputs($backup_file, "DROP TABLE IF EXISTS shopping;\n");
		    fputs($backup_file, $dbcreatecommands['shopping'].";\n");
		    while ($dump_shopping = $exec_shopping->fetch_object())
		    {
			    $shopping_recipe = $dbconnect->real_escape_string($dump_shopping->recipe);
			    $shopping_ingredients = $dbconnect->real_escape_string($dump_shopping->ingredients);
			    fputs($backup_file, "INSERT INTO shopping VALUES ($dump_shopping->id, '$shopping_recipe', '$shopping_ingredients');\n");
		    }
		    fclose ($backup_file);
		    echo "<p>" . MSG_ADMIN_BACKUP_FILE . ": <a href=\"backup/$filename\" target=\"_blank\">backup/$filename</a>\n";
            $dbconnect->set_charset($charset);
		
		    foodie_Footer();
		    exit();
	    }
	    //if $_POST has not expected value terminate with error
	    echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
    }
    //Fast logout from admin area

    foodie_Footer();
}?>
