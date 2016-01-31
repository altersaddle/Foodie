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
    echo "<h2>" . MSG_ADMIN . "</h2>\n";
	echo "<h3>" . MSG_ADMIN_MENU_MULTIMEDIA . "</h3>\n";

    if (isset($_POST['action']) && $_POST['action'] == "update_media") { // Postback to this form, update database
        $recipe_name = $_REQUEST['recipe_name'];
        echo "<h4>" . $recipe_name . "</h4>\n";
        if (!empty($_FILES['recipe_image']) && !empty($_FILES['recipe_image']['tmp_name'])) {
            // update image
            $imageinfo = getimagesize($_FILES['recipe_image']['tmp_name']);
            $filename = "image-".$_REQUEST['recipe_id'].image_type_to_extension($imageinfo[2]);
            if ($imageinfo[0] > 700) {
                // use Image Magick to resize this image
                $image = new \Imagick($_FILES['recipe_image']['tmp_name']);
                $scalefactor = 700 / $imageinfo[0];
                $height = $imageinfo[1] * $scalefactor;
                $image->scaleImage(700, $height, true);
                $image_success = $image->writeImage(dirname(__FILE__)."/images/$filename");
            }
            else {
                $image_success = copy ("{$_FILES['recipe_image']['tmp_name']}", dirname(__FILE__)."/images/$filename");
            }
            if (!$image_success) {
			    echo "<p class=\"error\">" . ERROR_UNEXPECTED . ": " . ERROR_UPLOAD . "!\n";
		    }
            else {
                // update database
                $stmt = $dbconnect->prepare("UPDATE main SET image=? WHERE id = ?");
                $stmt->bind_param("ss", $filename, $_REQUEST['recipe_id']);

		        if (!$image_update = $stmt->execute())
		        {
			        echo "<p class=\"error\">" . ERROR_ADMIN_MODIFY_UNABLE . " {$recipe_name}<br>\n" . $dbconnect->error();
		        }
		        else {
                    echo "<p>{$recipe_name} " . MSG_ADMIN_MMEDIA_IMAGE_ADDED . "\n";
                }
            }
        }

        // update video
        $stmt = $dbconnect->prepare("UPDATE main SET video=? WHERE id = ?");
        $stmt->bind_param("ss", $_REQUEST['recipe_video'], $_REQUEST['recipe_id']);

		if (!$image_update = $stmt->execute())
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_MODIFY_UNABLE . " {$recipe_name}<br>\n" . $dbconnect->error();
		}
		else {
            echo "<p>{$recipe_name} " . MSG_ADMIN_MMEDIA_VIDEO_UPDATED . "\n";
        }
    }
    else if (isset($_REQUEST['recipe_id']) && is_numeric($_REQUEST['recipe_id'])) { // Get a recipe and present a form
        $recipe_id = $_REQUEST['recipe_id'];
        $stmt = $dbconnect->prepare("SELECT name, image, video FROM main WHERE id = ?");
        $stmt->bind_param('s', $recipe_id );
        $stmt->execute();

        if (!$recipe_result = $stmt->get_result()) {
	        echo "<p>" . ERROR_RECIPE_RETRIEVE ."<br>\n";
	        echo $recipe_result->error();
        }
        else {
            $recipe = $recipe_result->fetch_object();
            
            echo "<h4>" . $recipe->name . "</h4>\n";
            echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"admin_mmedia.php\">\n";
			
			if (empty($recipe->image))
			{
                echo "<p>" . MSG_RECIPE_IMAGE_UNAVAILABLE . ".\n";
			} else
			{
				echo "<p>" . MSG_ADMIN_MULTIMEDIA_IMAGE_AVAILABLE . "<br>\n";
                echo "<img src=\"images/$recipe->image\"><br>\n";
			}
            echo "<p>" . MSG_MMEDIA_INSERT_IMAGE . ":\n<input type=\"file\" name=\"recipe_image\">\n";

			if (empty($recipe->video)) {
				echo "<p>" . MSG_RECIPE_VIDEO_UNAVAILABLE . ".\n";
                echo "<p>" . MSG_MMEDIA_INSERT_VIDEOCLIP . ":\n<input type=\"text\" name=\"recipe_video\">\n";
			} 
            else {
				echo "<p>" . MSG_ADMIN_MULTIMEDIA_VIDEO_AVAILABLE . "\n";
                echo "<a href=\"$recipe->video\" target=\"blank\">" . MSG_ADMIN_MULTIMEDIA_LAUNCH_VIDEO . "</a>\n";
                echo "<p>" . MSG_MMEDIA_INSERT_VIDEOCLIP . ":\n<input type=\"text\" name=\"recipe_video\" value=\"$recipe->video\">\n";
			}
            
			echo "<input type=\"hidden\" name=\"action\" value=\"update_media\">\n";
            echo "<input type=\"hidden\" name=\"recipe_id\" value=\"$recipe_id\">\n";
            echo "<input type=\"hidden\" name=\"recipe_name\" value=\"{$recipe->name}\">\n";
            echo "<p><input type=\"submit\" value=\"" . BTN_SUBMIT_CHANGES . "\">\n</form>\n";
        }
        $recipe_result->close();
    }
    else {
        // print a form to choose a recipe
        echo "<p>" . MSG_ADMIN_MMEDIA_RECIPE_SELECT . ":<br>\n"; 
	    
	    if (!$exec_list = $dbconnect->query("SELECT id, name FROM main ORDER BY name")) {
		    echo "<p class=\"error\">" . ERROR_BROWSE . "<br>\n" . $dbconnect->error();
	    }	
        else {
	        echo "<form method=\"post\" action=\"admin_mmedia.php\">\n<select name=\"recipe_id\">\n";
	        while ($recipe_data = $exec_list->fetch_object())
	        {
		        echo "<option value=\"$recipe_data->id\">$recipe_data->name</option>\n";
	        }
	        echo "</select>\n";
	        echo "<input type=\"hidden\" name=\"admin\" value=\"select_mmedia\"><p><input type=\"submit\" value=\"" . BTN_ADMIN_MMEDIA_SELECT . "\"></form>\n";
        }
    }

    foodie_AddFooter();
}
?>
