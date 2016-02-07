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

$recipe_name = "Unknown";
$recipe_id = -1;

if (isset($_POST['recipe'])) {
    $recipe_id = intval($_POST['recipe']);
}

echo "<h2>" . MSG_COOKBOOK . "</h2>\n";
if (isset($_POST['action'])) {
    // Get recipe name
    $stmt = $dbconnect->prepare("SELECT name FROM main WHERE id = ?");
    $stmt->bind_param('s', $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_object()) {
        $recipe_name = $row->name;
    }
    $stmt->close();

	if ($_POST['action'] == "cook_add")	{
		//Insert recipe into cookbook
		$sql_check_dupes = "SELECT id FROM personal_book WHERE id = '{$recipe_id}'";
		if ($exec_check_dupes = $dbconnect->query($sql_check_dupes)) {
		    $dupes_found = $exec_check_dupes->num_rows;
		    if ($dupes_found < 1) {
                // not a duplicate, insert
                $stmt = $dbconnect->prepare("INSERT INTO personal_book (id, recipe_name) VALUES (?, ?)");
                $stmt->bind_param('ss', $recipe_id, $recipe_name);
                
		        if ($stmt->execute()) {
		            echo "<p>{$recipe_name} " . MSG_COOKBOOK_INSERT . ".\n";
		            //Prints out number of recipes into personal cookbook with link to cookbook.php
		            $sql_cookbook_recipes = "SELECT * FROM personal_book";
		            if ($exec_cookbook_recipes = $dbconnect->query($sql_cookbook_recipes)) {
		                $num_cookbook = $exec_cookbook_recipes->num_rows;
		                if (0 == $num_cookbook)
		                {
			                echo "<p class=\"error\">" . MSG_COOKBOOK_NORECIPES . ".\n";
		                }
		                if ($num_cookbook >= 1)
		                {
			                echo "<p>$num_cookbook " . MSG_COOKBOOK_NUMBER . "\n";
			                echo "<p><a href=\"cookbook.php\">" . MSG_COOKBOOK_READ . "</a>\n";
		                }
                    }
		            else {
			            echo "<p class=\"error\">" . ERROR_COOKBOOK_SELECT . "<br>\n" . $exec_cookbook_recipes->error();
		            }
                }
		        else {
			        echo "<p class=\"error\">" . ERROR_COOKBOOK_INSERT . "<br>\n" . $result->error();
		        }
                $stmt->close();
            }
            else {
			    echo "<p class=\"error\">" . MSG_RECIPE . " {$recipe_name} " . MSG_COOKBOOK_PRESENT . " {$recipe_id}\n";
		    }	
		} 
        else {
            echo "<p class=\"error\">" . ERROR_COOKBOOK_DUPLICATE . "<br>\n" . $exec_check_dupes->error();
        }
	}
	else if ($_POST['action'] == "cook_remove")	{
		echo "<h2>" . MSG_COOKBOOK_DELETE . "</h2>\n";
		$sql_cookbook_delete = "DELETE FROM personal_book WHERE id = '{$recipe_id}'";
		if ($exec_cookbook_delete = $dbconnect->query($sql_cookbook_delete)) {
		    echo "<p>" . MSG_RECIPE . " <strong>{$recipe_name}</strong>";
		    echo "<a href=\"cookbook.php\"> " . MSG_COOKBOOK_DELETED . "</a>\n";
        }
    	else {
			echo "<p class=\"error\">" . ERROR_COOKBOOK_DELETE . "<br>" . $exec_cookbook_delete->error();
		}
	}
	else {
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . ".<br>\n";
	}
}
else {

    echo "<p>" . MSG_COOKBOOK_WELCOME . "!\n";
    $sql_cookbook_recipes = "SELECT id, recipe_name FROM personal_book";
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
	    echo "<table class=\"browse\">";
                
	    while ($cookbook_data = $cookbook_result->fetch_object()) 
	    {
		    echo "<tr><td>\n";
		    echo "<a href=\"recipe.php?recipe=$cookbook_data->id\">$cookbook_data->recipe_name</a>\n";
		    echo "</td><td valign=\"middle\" align=\"center\">\n";
		    echo "<form method=\"post\" action=\"cookbook.php\">\n";
		    echo "<input type=\"hidden\" name=\"action\" value=\"cook_remove\">\n<input type=\"hidden\" name=\"recipe\" value=\"$cookbook_data->id\">\n";
            echo "<input type=\"hidden\" name=\"recipe_name\" value=\"$cookbook_data->recipe_name\">\n<input type=\"submit\" value=\"" . MSG_COOKBOOK_DELETE . "\"></form></td></tr>\n";
	    }
	    echo "</table>\n";
    }
}

foodie_Footer();
?>
