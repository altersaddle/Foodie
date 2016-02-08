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

if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php?redirect=".urlencode($_SERVER["REQUEST_URI"]));
}
else {
    foodie_Begin();
foodie_AdminHeader();
    echo "<h2>" . MSG_ADMIN . "</h2>\n";
    echo "<h3>" . MSG_ADMIN_MENU_RECIPE_MOD . "</h3>\n";
    if (isset($_POST['action']) && $_POST['action'] == "modify")
    {
		//Modify recipe statement
        $stmt = $dbconnect->prepare("UPDATE main SET name=?, dish=?, mainingredient=?, people=?, origin=?, kind=?, season=?, time=?, difficulty=?, ingredients=?, description=?, notes=?, wines=?, image=?, video=? WHERE id = ?");
        $stmt->bind_param("ssssssssssssssss", $_POST['name'], $_POST['dish'], $_POST['mainingredient'], $_POST['people'], $_POST['origin'], $_POST['kind'], $_POST['season'], $_POST['time'], $_POST['difficulty'], $_POST['ingredients'], $_POST['description'], $_POST['notes'], $_POST['wines'], $_POST['image'], $_POST['video'], $_POST['id']);

		if (!$exec_modify_recipe = $stmt->execute())
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_MODIFY_UNABLE . " {$_POST['name']}<br>\n" . mysqli_error();
			foodie_Footer();
			exit(); 
		}
		else {
            echo "<p>{$_POST['name']} " . MSG_ADMIN_MODIFY_SUCCESS . "\n";
		    //Print modified recipe
		    $sql_recipe = "SELECT * FROM main WHERE id = '{$_POST['id']}'";
		    if (!$exec_recipe = mysqli_query($dbconnect, $sql_recipe)) 
		    {
			    echo "<p>" . ERROR_RECIPE_RETRIEVE  ."<br>\n" . mysqli_error();
			    cs_AdminFastLogout();
			    cs_AddFooter();
			    exit();
		    }
            $reciperow = $exec_recipe->fetch_assoc();
            $recipename = $reciperow['name'];
            foodie_PrintRecipeData($reciperow);
        }
    } // 
    else if (isset($_GET['recipe']))
    {
	    $sql_modify_recipe = "SELECT * FROM main WHERE id = '{$_GET['recipe']}'";
	    if (!$exec_modify_recipe = mysqli_query($dbconnect, $sql_modify_recipe))
	    {
		    echo "<p class=\"error\">" . ERROR_RECIPE_RETRIEVE . "<br>\n" . mysqli_error();
		    cs_AdminFastLogout();
		    cs_AddFooter();
		    exit();
	    }
	    while ($recipe_data = mysqli_fetch_object($exec_modify_recipe))
	    {
		    //query database for dish types, difficulty grades and cooking types
 		    $dish_number = mysqli_query($dbconnect, "SELECT * FROM dish");
		    $difficulty_number = mysqli_query($dbconnect, "SELECT * FROM difficulty");
		    $cooking_number = mysqli_query($dbconnect, "SELECT * FROM cooking");
		    //Print the form
		    echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n";
		    echo "<input type=\"hidden\" name=\"action\" value=\"modify\">\n
		    <input type=\"hidden\" name=\"id\" value=\"$recipe_data->id\">\n
		    <p>" . MSG_RECIPE_NAME . ": <input type=\"text\" size=\"50\" name=\"name\" value=\"$recipe_data->name\">\n
		    <p>" . MSG_RECIPE_SERVING . ": <select name=\"dish\"><option value=\"$recipe_data->dish\">$recipe_data->dish</option>\n";
		    while ($data_dish=mysqli_fetch_object($dish_number)) 
		    {
			    if ($data_dish->dish != $recipe_data->dish)
			    {
				    echo "<option value=\"$data_dish->dish\">$data_dish->dish</option>\n";
			    }
		    }
		    echo "</select>
		    <p>" . MSG_RECIPE_MAIN . ": <input type=\"text\" size=\"30\" name=\"mainingredient\" value=\"$recipe_data->mainingredient\">\n
		    <p>" . MSG_RECIPE_PEOPLE . ": <input type=\"text\" size=\"30\" name=\"people\" value=\"$recipe_data->people\">\n
		    <p>" . MSG_RECIPE_ORIGIN . ": <input type=\"text\" size=\"30\" name=\"origin\" value=\"$recipe_data->origin\">\n
		    <p>" . MSG_RECIPE_COOKING . ":<select name=kind><option value=\"$recipe_data->kind\">$recipe_data->kind</option>\n";
		    while ($data_cook=mysqli_fetch_object($cooking_number)) {
			    if ($data_cook->type != $recipe_data->kind)
			    {
				    echo "<option value=\"$data_cook->type\">$data_cook->type</option>\n";
			    }
		    }
		    echo "</select>\n
		    <p>" . MSG_RECIPE_SEASON . ": <input type=\"text\" size=\"30\" name=\"season\" value=\"$recipe_data->season\">\n
		    <p>" . MSG_RECIPE_TIME . ": <input type=\"text\" size=\"10\" name=\"time\" value=\"$recipe_data->time\">\n
		    <p>" . MSG_RECIPE_DIFFICULTY . ": <select name=\"difficulty\">\n";
		    if ($recipe_data->difficulty == "-")
		    {
			    echo "<option value=\"$recipe_data->difficulty\">" . MSG_NOT_SPECIFIED . "</option>\n";
		    }
		    else {
			    echo "<option value=\"$recipe_data->difficulty\">$recipe_data->difficulty</option>\n";
		    }
		    while ($data_diff=mysqli_fetch_object($difficulty_number)) {
			    if ($data_diff->difficulty != $recipe_data->difficulty)
			    {
				    echo "<option value=\"$data_diff->difficulty\">$data_diff->difficulty</option>\n";
			    }
		    }
		    if ($recipe_data->difficulty != "-")
		    {
			    echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option>\n";
		    }
		    echo "</select>\n
		    <p>" . MSG_RECIPE_INGREDIENTS . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"ingredients\">$recipe_data->ingredients</textarea>\n
		    <p>" . MSG_RECIPE_DESCRIPTION . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"description\">$recipe_data->description</textarea>\n
		    <p>" . MSG_RECIPE_NOTES . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"notes\">$recipe_data->notes</textarea>\n
		    <p>" . MSG_RECIPE_WINES . ": <input type=\"text\" size=\"30\" name=\"wines\" value=\"$recipe_data->wines\">\n
		    <p>" . MSG_ADMIN_MODIFY_IMAGE . ": <input type=\"text\" size=\"30\" name=\"image\" value=\"$recipe_data->image\">\n
		    <p>" . MSG_ADMIN_MODIFY_VIDEO . ": <input type=\"text\" size=\"30\" name=\"video\" value=\"$recipe_data->video\">\n
		    <p><input type=\"submit\" value=\"" . BTN_ADMIN_MODIFY_RECIPE . "\">\n
		    ";
	    }
    }
    else {
        // Neither get nor post, print the form

        echo "<p>" . MSG_ADMIN_MODIFY_SELECT . ":\n";
        // Print browse list
        if (!isset($_GET['offset'])) {
	        $_GET['offset'] = 0;
        }

        $letter_where = '';
        $letter_arg = '';
        $sql = "SELECT id,name FROM main ORDER BY name ASC LIMIT {$_GET['offset']},{$setting_max_lines_page}";
        // If letter is set, adjust SQL
        if (isset($_GET['letter'])) {
	        $sql = "SELECT id,name FROM main WHERE name LIKE '{$_GET['letter']}%' ORDER BY name ASC LIMIT {$_GET['offset']},{$setting_max_lines_page}";
            $letter_arg = "&letter=".$_GET['letter'];
            $letter_where = " WHERE name LIKE '{$_GET['letter']}%'";
        }

        //Count recipes in query
        $dbquery = $dbconnect->query("SELECT COUNT(*) FROM main $letter_where");
        $result = $dbquery->fetch_row();
        $recipe_number = $result[0];
        $dbquery->close();
        //Retrieve recipe names and ID's
        if (!$exec_db_browse = $dbconnect->query($sql)) {
	        echo "<p class=\"error\">" . ERROR_BROWSE . "\n<br>" . mysqli_error();
	        cs_AdminFastLogout();
	        cs_AddFooter();
	        exit();
        };
        foodie_AlphaLinks("admin_modify.php?");
        //Count recipes in query, if == 0 print that no recipes are
        //available
        $num_letter = mysqli_num_rows($exec_db_browse);
        if ($num_letter == "0")
        {
	        echo "<p class=\"error\">" . ERROR_ADMIN_DELETE_LETTER . " {$_GET['letter']}\n";
        }
	    echo "<table class=\"browse\">";
	    while ($recipe_browse_list = $exec_db_browse->fetch_object()) 
	    {
		    echo "<tr><td><a href=\"admin_modify.php?recipe=$recipe_browse_list->id\">$recipe_browse_list->name</a></td></tr>\n";
	    }
	    echo "</table>\n";

        echo "<p>" . MSG_AVAILABLE_PAGES . ": \n";
        if ($_GET['offset']>=1) 
        { // bypass PREV link if offset is 0
	        $prevoffset=$_GET['offset'] - $setting_max_lines_page;
	        echo "<p align=center><a href=\"admin_modify.php?offset=$prevoffset$letter_arg\">" . MSG_PREVIOUS . "</a> - \n";
        }
        // calculate number of pages needing links
        $pages=intval($recipe_number/$setting_max_lines_page);
        // $pages now contains int of pages needed unless there is a remainder from division
        if ($recipe_number%$setting_max_lines_page) {
            // has remainder so add one page
            $pages++;
        }
        for ($i=1;$i<=$pages;$i++) { // loop thru
            $newoffset=$setting_max_lines_page*($i-1);
            echo "<a href=\"admin_modify.php?offset=$newoffset$letter_arg\">$i</a> \n";
        }
        // check to see if last page
        if (!(($_GET['offset']/$setting_max_lines_page)==$pages) && $pages!=1) {
            // not last page so give NEXT link
	        $newoffset=$_GET['offset']+$setting_max_lines_page;
	        echo "&nbsp;-&nbsp;<a href=\"admin_modify.php?offset=$newoffset$letter_arg\">" . MSG_NEXT . "</a>\n";
        }
    }
    foodie_Footer();
}
?>
