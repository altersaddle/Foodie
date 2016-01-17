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
    foodie_AddHeader();

    if (isset($_POST['action']))
    {
	    if ($_POST['action'] == "insert_recipe")
	    {
            $filename = '';
		    echo "<h3>{$_REQUEST['name']}</h3>\n";

		    //$sql_insert = "INSERT INTO main (id, name, dish, mainingredient, people, origin, season, kind, time, difficulty, wines, ingredients, description, notes) VALUES ('', '{$_REQUEST['recipe_name']}', '{$_REQUEST['recipe_dish']}', '{$_REQUEST['recipe_mainingredient']}', '{$_REQUEST['recipe_people']}', '{$_REQUEST['recipe_origin']}', '{$_REQUEST['recipe_season']}', '{$_REQUEST['recipe_kind']}', '{$_REQUEST['recipe_time']}', '{$_REQUEST['recipe_difficulty']}', '{$_REQUEST['recipe_wine']}', '{$_REQUEST['recipe_ingredients']}', '{$_REQUEST['recipe_description']}', '{$_REQUEST['recipe_notes']}')";
		    //Modify recipe statement
            $stmt = $dbconnect->prepare("insert into main (name, dish, mainingredient, people, origin, season, kind, time, difficulty, wines, ingredients, description, notes, video) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssssss", $_POST['name'], $_POST['dish'], $_POST['mainingredient'], $_POST['people'], $_POST['origin'],
                $_POST['season'], $_POST['kind'], $_POST['time'], $_POST['difficulty'], $_POST['wine'], 
                $_POST['ingredients'], $_POST['description'], $_POST['notes'], $_POST['video']);

		    if (!$stmt->execute())
		    {
			    echo "<p class=\"error\">" . ERROR_INSERT_RECIPE . " {$_REQUEST['name']}<br>\n" . $stmt->error;
		    }
            else {
		        echo "<p>{$_REQUEST['name']} " . MSG_INSERT_OK . "!\n";
                // get ID of new row
                $newid = $dbconnect->insert_id;

                if (!empty($_FILES['recipe_image']) && !empty($_FILES['recipe_image']['tmp_name'])) {
                    // save image
                    $uploadtype = exif_imagetype($_FILES['recipe_image']['tmp_name']);
                    $filename = "image-".$newid.image_type_to_extension($uploadtype);
                    copy ("{$_FILES['recipe_image']['tmp_name']}", dirname(__FILE__)."/images/$filename");
                }
                echo "<a href=\"recipe.php?recipe=$newid\">".MSG_ADMIN_MMEDIA_DISPLAY_RECIPE."</a>";
            }
            $stmt->close();
	    }
	    else
	    {
		    echo "<p class=\"error\">" . ERROR_UNEXPECTED . ".<br>\n";
	    }
    }
    else {
        //Display insert form
        echo "<p>" . MSG_INSERT_HERE . "\n";
        $dish_number = $dbconnect->query("SELECT * FROM dish");
        $dishnumber = $dish_number->num_rows;
        if ($dishnumber == '0') {
	        echo "<p>" . MSG_SERVING_TABLE_EMPTY . ".<br>";
	        echo "<a href=\"admin_dish.php</a>\n";
        }
        $cooking_number = $dbconnect->query("SELECT * FROM cooking");
        $cooknumber = $cooking_number->num_rows;
        if ($cooknumber == '0') {
	        echo "<p>" . MSG_COOKING_TABLE_EMPTY . ".<br>";
	        echo "<a href=\"admin_cook.php\">" . MSG_ADMIN_MENU_COOKING_ADD . "</a>\n";
        }
        
        $recipe_name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $recipe_mainingredient = isset($_REQUEST['mainingredient']) ? $_REQUEST['mainingredient'] : '';
        $recipe_people = isset($_REQUEST['people']) ? $_REQUEST['people'] : '';
        $recipe_origin = isset($_REQUEST['origin']) ? $_REQUEST['origin'] : '';
        $recipe_season = isset($_REQUEST['season']) ? $_REQUEST['season'] : '';
        $recipe_time = isset($_REQUEST['time']) ? $_REQUEST['time'] : '';

        $difficulty_number = $dbconnect->query("SELECT * FROM difficulty");
        $difnumber = $difficulty_number->num_rows;
        echo "<p class=\"mandatory\">" . MSG_ASTERISK . "\n";
        echo "<form method=post action=\"admin_insert.php\">\n";
        echo "<input type=\"hidden\" name=\"action\" value=\"insert_recipe\">\n<p>";
        echo MSG_RECIPE_NAME . "&nbsp;*:\n<input type=\"text\" size=\"30\" name=\"name\" value=\"".$recipe_name."\"><p>";
        echo MSG_RECIPE_SERVING . "&nbsp;*:\n";
        echo "<select name=dish><option value=\"\">" . MSG_CHOOSE_SERVING . "</option><option value=\"\">----------------</option>\n";
        while ($data_dish=$dish_number->fetch_object()) {
	        echo "<option value=\"$data_dish->dish\">$data_dish->dish</option>\n";
        }
        echo "</select>\n";
        echo "<p>" . MSG_RECIPE_MAIN . "&nbsp;*:\n<input type=\"text\" size=\"30\" name=\"mainingredient\" value=\"".$recipe_mainingredient."\">";
        echo "<p>" . MSG_RECIPE_PEOPLE . ":\n<input type=\"text\" size=\"2\" name=\"people\" value=\"".$recipe_people."\">\n";
        echo "<p>" . MSG_RECIPE_ORIGIN . ":\n<input type=\"text\" size=\"30\" name=\"origin\" value=\"".$recipe_origin."\">\n";
        echo "<p>" . MSG_RECIPE_SEASON . ":\n<input type=\"text\" size=\"30\" name=\"season\" value=\"".$recipe_season."\">\n";
        echo "<p>" . MSG_RECIPE_COOKING . "&nbsp;*:\n";
        echo "<select name=kind><option value=\"\">" . MSG_CHOOSE_COOKING . "</option><option value=\"\">----------------</option>\n";
        while ($data_cook=$cooking_number->fetch_object()) {
	        echo "<option value=\"$data_cook->type\">$data_cook->type</option>\n";
        }
        echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option></select>\n";
        echo "<p>" . MSG_RECIPE_TIME . ":\n<input type=\"text\" size=\"30\" name=\"time\" value=\"".$recipe_time."\">";
        echo "<p>" . MSG_RECIPE_DIFFICULTY . "&nbsp;*:\n ";
        echo "<select name=difficulty><option value=\"\">" . MSG_CHOOSE_DIFFICULTY . "</option><option value=\"\">--------------------</option>\n";
        while ($data_difficulty=$difficulty_number->fetch_object()) {
	        echo "<option value=\"$data_difficulty->difficulty\">$data_difficulty->difficulty</option>\n";
        }
        echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option></select>\n";
        echo "</select>\n";
        echo "<p>" . MSG_RECIPE_WINES . ":\n<input type=\"text\" size=\"30\" name=\"wine\">";
        echo "<p>" . MSG_RECIPE_INGREDIENTS . "&nbsp;*:\n<br><textarea cols=60 rows=5 name=\"ingredients\" wrap=\"virtual\"></textarea>\n";
        echo "<p>" . MSG_RECIPE_DESCRIPTION . "&nbsp;*:\n<br><textarea cols=60 rows=5 name=\"description\" wrap=\"virtual\"></textarea>\n";
        echo "<p>" . MSG_RECIPE_NOTES . ":\n<br><textarea cols=60 rows=5 name=\"notes\" wrap=\"virtual\"></textarea>\n";
        echo "<P>" . MSG_MMEDIA_INSERT_IMAGE . ":\n<br><input type=\"file\" name=\"recipe_image\">\n";
        echo "<p>" . MSG_MMEDIA_INSERT_VIDEOCLIP . ":\n<input type=\"text\" size=\"60\" name=\"video\">";
        echo "<p><input type=\"submit\" value=\"" . BTN_INSERT_RECIPE . "\">\n&nbsp;<input type=\"reset\" value=\"" . BTN_INSERT_CLEAR . "\">\n</form>\n";
    }
    foodie_AddFooter();
}
?>

