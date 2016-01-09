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
$trans_sid = cs_IsTransSid();
cs_AddHeader();
cs_CheckLoginAdmin();
echo "<h2>" . MSG_ADMIN . "</h2>\n";
echo "<h3>" . MSG_ADMIN_MENU_RECIPE_ADD . "</h3>\n";
require(dirname(__FILE__)."/includes/db_connection.inc.php");
//If set POST variable action record recipe into database.
//Verify contento of the variable: 

//If set POST variable preview display recipe preview. Abort with error
//if preview value is different than "on"
if (isset($_POST['action']))
{
	if ($_POST['action'] == "ins_preview")
	{
		if (empty($_POST['name'])) 
		{
			echo "<p class=\"error\">" . MSG_RECIPE_NAME . "&nbsp;" . ERROR_MISSING . "!\n";
			cs_PrintInsertRecipeForm();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		if (empty($_POST['mainingredient'])) 
		{
			echo "<p class=\"error\">" . MSG_RECIPE_MAIN . "&nbsp;" . ERROR_MISSING . "!\n";
			cs_PrintInsertRecipeForm();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		if (empty($_POST['ingredients'])) 
		{
			echo "<p class=\"error\">" . MSG_RECIPE_INGREDIENTS . "&nbsp;" . ERROR_MISSING . "!\n";
			cs_PrintInsertRecipeForm();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		if (empty($_POST['description'])) 
		{
			echo "<p class=\"error\">" . MSG_RECIPE_DESCRIPTION . "&nbsp;" . ERROR_MISSING . "!\n";
			cs_PrintInsertRecipeForm();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		if (empty($_POST['kind'])) 
		{
			echo "<p class=\"error\">" . MSG_RECIPE_COOKING . "&nbsp;" . ERROR_MISSING . "!\n";
			cs_PrintInsertRecipeForm();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		if (empty($_POST['dish'])) 
		{
			echo "<p class=\"error\">" . MSG_RECIPE_SERVING . "&nbsp;" . ERROR_MISSING . "!\n";
			cs_PrintInsertRecipeForm();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		if (empty($_POST['difficulty'])) 
		{
			echo "<p class=\"error\">" . MSG_RECIPE_DIFFICULTY . "&nbsp;" . ERROR_MISSING . "!\n";
			cs_PrintInsertRecipeForm();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Check for dangerous input
		$description = stripslashes(nl2br($_POST['description']));
		$ingredients = stripslashes(nl2br($_POST['ingredients']));
		$notes = nl2br($_POST['notes']);
		//Print recipe preview
		echo "<p>" . MSG_RECIPE_NAME . ": ".stripslashes($_POST['name'])."\n
		<p>" . MSG_RECIPE_SERVING . ": ".stripslashes($_POST['dish'])."\n
		<p>" . MSG_RECIPE_MAIN . ": ".stripslashes($_POST['mainingredient'])."\n
		<p>" . MSG_RECIPE_PEOPLE . ": ".stripslashes($_POST['people'])."\n
		<p>" . MSG_RECIPE_ORIGIN . ": ".stripslashes($_POST['origin'])."\n
		<p>" . MSG_RECIPE_SEASON . ": ".stripslashes($_POST['season'])."\n
		<p>" . MSG_RECIPE_COOKING . ": ".stripslashes($_POST['kind'])."\n
		<p>" . MSG_RECIPE_TIME . ": ".stripslashes($_POST['time'])."\n
		<p>" . MSG_RECIPE_DIFFICULTY . ": ".stripslashes($_POST['difficulty'])."\n
		<p>" . MSG_RECIPE_WINES . ": ".stripslashes($_POST['wine'])."\n
		<p>" . MSG_RECIPE_INGREDIENTS . ": $ingredients\n
		<p>" . MSG_RECIPE_DESCRIPTION . ": $description\n
		<p>Notes: $notes\n";
		//End recipe preview
		$_SESSION['recipe_name'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['name']), ENT_QUOTES));
		$_SESSION['recipe_dish'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['dish']), ENT_QUOTES));
		$_SESSION['recipe_mainingredient'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['mainingredient']), ENT_QUOTES));
		$_SESSION['recipe_people'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['people']), ENT_QUOTES));
		$_SESSION['recipe_origin'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['origin']), ENT_QUOTES));
		$_SESSION['recipe_season'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['season']), ENT_QUOTES));
		$_SESSION['recipe_kind'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['kind']), ENT_QUOTES));
		$_SESSION['recipe_time'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['time']), ENT_QUOTES));
		$_SESSION['recipe_difficulty'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['difficulty']), ENT_QUOTES));
		$_SESSION['recipe_wine'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['wine']), ENT_QUOTES));
		$_SESSION['recipe_ingredients'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['ingredients']), ENT_QUOTES));
		$_SESSION['recipe_description'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['description']), ENT_QUOTES));
		$_SESSION['recipe_notes'] = mysql_escape_string(htmlspecialchars(stripslashes($_POST['notes']), ENT_QUOTES));
		echo "<p>" . MSG_INSERT_VIDEOCLIP . ":<br>\n";
		echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"admin_insert.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"insert_video\">\n
		<input type=\"file\" name=\"recipe_video\">\n
		<p><input type=\"submit\" value=\"" . BTN_INSERT_VIDEOCLIP . "\">\n
		</form>\n";
		echo "<p>" . MSG_INSERT_IMAGE . ":<br>\n";
		echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"admin_insert.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"insert_image\">\n<input type=\"file\" name=\"recipe_image\">\n<p><input type=\"submit\" value=\"" . BTN_INSERT_IMAGE . "\">\n</form>\n";
		echo "<form method=\"post\" action=\"admin_insert.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"insert_recipe\">\n<p><input type=\"submit\" value=\"" . BTN_INSERT_RECIPE . "\">\n</form>\n";
		cs_AddFooter();
		exit();
	}
	if ($_POST['action'] == "insert_recipe")
	{
		echo "<h3>{$_SESSION['recipe_name']}</h3>\n";
		$sql_insert = "INSERT INTO main (id, name, dish, mainingredient, people, origin, season, kind, time, difficulty, wines, ingredients, description, notes) VALUES ('', '{$_SESSION['recipe_name']}', '{$_SESSION['recipe_dish']}', '{$_SESSION['recipe_mainingredient']}', '{$_SESSION['recipe_people']}', '{$_SESSION['recipe_origin']}', '{$_SESSION['recipe_season']}', '{$_SESSION['recipe_kind']}', '{$_SESSION['recipe_time']}', '{$_SESSION['recipe_difficulty']}', '{$_SESSION['recipe_wine']}', '{$_SESSION['recipe_ingredients']}', '{$_SESSION['recipe_description']}', '{$_SESSION['recipe_notes']}')";
		if (!$exec_insert=mysql_query($sql_insert)) 
		{
			echo "<p class=\"error\">" . ERROR_INSERT_RECIPE . " {$_SESSION['recipe_name']}<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p>{$_SESSION['recipe_name']} " . MSG_INSERT_OK . "!\n";
		unset($_SESSION['recipe_name']);
		unset($_SESSION['recipe_dish']);
		unset($_SESSION['recipe_mainingredient']);
		unset($_SESSION['recipe_people']);
		unset($_SESSION['recipe_origin']);
		unset($_SESSION['recipe_season']);
		unset($_SESSION['recipe_kind']);
		unset($_SESSION['recipe_time']);
		unset($_SESSION['recipe_difficulty']);
		unset($_SESSION['recipe_wine']);
		unset($_SESSION['recipe_ingredients']);
		unset($_SESSION['recipe_description']);
		unset($_SESSION['recipe_notes']);
		cs_AddFooter();
		exit();
	}
	if ($_POST['action'] == "insert_image")
	{
		//Check input file name
		if (eregi("[@!|#§+*<>^?£$%&\/\\]", $_FILES['recipe_image']['name'])) 
		{
			echo "<p class=\"error\">" . ERROR_INVALID_CHAR . "&nbsp;" . ERROR_FILE_IMAGE . "!\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$image_type = array ('.jpg', '.JPG', '.jpeg', '.JPEG','.gif', '.GIF','.tif', '.TIF','.tiff', '.TIFF', '.png', '.PNG', '.bmp', '.BMP'); 
		$image_extension = substr(strrchr($_FILES['recipe_image']['name'], "."), 0);
		if (!in_array("$image_extension", $image_type))
		{
		        echo "<p class=\"error\">" . ERROR_INVALID_IMAGE . "!\n";
		        echo "<p>" . MSG_VALID_FORMAT . ":<br>\n";
	        //Displays content of array $image_type
		        foreach ($image_type as $extension)
			{
				echo "$extension/\n";
			}
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Check for duplicate image file
		$sql_duplicate_image = "SELECT image FROM main where image = '{$_FILES['recipe_image']['name']}'";
		if (!$exec_duplicate_image = mysql_query($sql_duplicate_image))
		{
			echo "<p class=\"error\">" . ERROR_DUPLICATE_IMAGE . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$num_images = mysql_num_rows($exec_duplicate_image);
		if ($num_images >= "1")
		{
			echo "<p class=\"error\">" . ERROR_EXIST_IMAGE . ".\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Extract from environment the script path
		$path = dirname(__FILE__);
		$upload_path = "$path/images";
		$check_name = $_FILES['recipe_image']['name'];
		$upload_error = copy ("{$_FILES['recipe_image']['tmp_name']}", "$upload_path/{$_FILES['recipe_image']['name']}");
		if ($upload_error == 0) 
		{
			echo "<p class=\"error\">" . ERROR_UNEXPECTED . ": " . ERROR_UPLOAD . "!\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Insert data into database
		$sql_insert = "INSERT INTO main (id, name, dish, mainingredient, people, origin, season, kind, time, difficulty, wines, ingredients, description, notes, image) VALUES ('', '{$_SESSION['recipe_name']}', '{$_SESSION['recipe_dish']}', '{$_SESSION['recipe_mainingredient']}', '{$_SESSION['recipe_people']}', '{$_SESSION['recipe_origin']}', '{$_SESSION['recipe_season']}', '{$_SESSION['recipe_kind']}', '{$_SESSION['recipe_time']}', '{$_SESSION['recipe_difficulty']}', '{$_SESSION['recipe_wine']}', '{$_SESSION['recipe_ingredients']}', '{$_SESSION['recipe_description']}', '{$_SESSION['recipe_notes']}', '{$_FILES['recipe_image']['name']}')";
		if (!$exec_insert=mysql_query($sql_insert)) 
		{
			echo "<p class=\"error\">" . ERROR_INSERT_RECIPE . "{$_SESSION['recipe_name']}<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p>{$_SESSION['recipe_name']} " . MSG_INSERT_IMAGE_OK . " {$_FILES['recipe_image']['name']}\n";
		unset($_SESSION['recipe_name']);
		unset($_SESSION['recipe_dish']);
		unset($_SESSION['recipe_mainingredient']);
		unset($_SESSION['recipe_people']);
		unset($_SESSION['recipe_origin']);
		unset($_SESSION['recipe_season']);
		unset($_SESSION['recipe_kind']);
		unset($_SESSION['recipe_time']);
		unset($_SESSION['recipe_difficulty']);
		unset($_SESSION['recipe_wine']);
		unset($_SESSION['recipe_ingredients']);
		unset($_SESSION['recipe_description']);
		unset($_SESSION['recipe_notes']);
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	if ($_POST['action'] == "insert_video")
	{	
		//Check input file name
		if (eregi("[@!|#§+*<>^?£$%&\/\\]", $_FILES['recipe_video']['name'])) 
		{
			echo "<p class=\"error\">" . ERROR_INVALID_CHAR . "&nbsp;" . ERROR_FILE_VIDEO . "!\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$video_type = array ('.avi', '.AVI', '.mpeg', '.MPEG','.mpg', '.MPG','.asf', '.ASF','.wmv', '.WMV', '.qt', '.QT', '.qtx', '.QTX'); 
		$video_extension = substr(strrchr($_FILES['recipe_video']['name'], "."), 0);
		if (!in_array("$video_extension", $video_type))
		{
		        echo "<p class=\"error\">" . ERROR_INVALID_VIDEO . "!\n";
		        echo "<p>" . MSG_VALID_FORMAT . ":<br>\n";
	        //Displays content of array $video_type
		        foreach ($video_type as $extension)
			{
				echo "$extension/\n";
			}
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Check for duplicate video file
		$sql_duplicate_video = "SELECT image FROM main where video = '{$_FILES['recipe_video']['name']}'";
		if (!$exec_duplicate_video = mysql_query($sql_duplicate_video))
		{
			echo "<p class=\"error\">" . ERROR_DUPLICATE_VIDEO . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$num_video = mysql_num_rows($exec_duplicate_video);
		if ($num_video >= "1")
		{
			echo "<p class=\"error\">" . ERROR_EXIST_VIDEO . ".\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Extract from environment the script path
		$path = dirname(__FILE__);
		$upload_path = "$path/video";
		$check_name = $_FILES['recipe_video']['name'];
		$upload_error = copy ("{$_FILES['recipe_video']['tmp_name']}", "$upload_path/{$_FILES['recipe_video']['name']}");
		if ($upload_error == 0) 
		{
			echo "<p class=\"error\">" . ERROR_UNEXPECTED . ": " . ERROR_UPLOAD . "!\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Insert data into database
		$sql_insert = "INSERT INTO main (id, name, dish, mainingredient, people, origin, season, kind, time, difficulty, wines, ingredients, description, notes, video) VALUES ('', '{$_SESSION['recipe_name']}', '{$_SESSION['recipe_dish']}', '{$_SESSION['recipe_mainingredient']}', '{$_SESSION['recipe_people']}', '{$_SESSION['recipe_origin']}', '{$_SESSION['recipe_season']}', '{$_SESSION['recipe_kind']}', '{$_SESSION['recipe_time']}', '{$_SESSION['recipe_difficulty']}', '{$_SESSION['recipe_wine']}', '{$_SESSION['recipe_ingredients']}', '{$_SESSION['recipe_description']}', '{$_SESSION['recipe_notes']}', '{$_FILES['recipe_video']['name']}')";
		if (!$exec_insert=mysql_query($sql_insert)) 
		{
			echo "<p class=\"error\">" . ERROR_INSERT_RECIPE . " {$_SESSION['recipe_name']}<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p>{$_SESSION['recipe_name']} " . MSG_INSERT_VIDEO_OK . " {$_FILES['recipe_video']['name']}\n";
		unset($_SESSION['recipe_name']);
		unset($_SESSION['recipe_dish']);
		unset($_SESSION['recipe_mainingredient']);
		unset($_SESSION['recipe_people']);
		unset($_SESSION['recipe_origin']);
		unset($_SESSION['recipe_season']);
		unset($_SESSION['recipe_kind']);
		unset($_SESSION['recipe_time']);
		unset($_SESSION['recipe_difficulty']);
		unset($_SESSION['recipe_wine']);
		unset($_SESSION['recipe_ingredients']);
		unset($_SESSION['recipe_description']);
		unset($_SESSION['recipe_notes']);
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	else
	{
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . ".<br>\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
}
//Display insert form
echo "<p>" . MSG_INSERT_HERE . "\n";
$dish_number = mysql_query("SELECT * FROM dish");
$dishnumber = mysql_num_rows($dish_number);
if ($dishnumber == '0') {
	echo "<p>" . MSG_SERVING_TABLE_EMPTY . ".<br>";
	echo "<a href=\"admin_dish.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_ADMIN_MENU_SERVING_ADD . "</a>\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}

$difficulty_number = mysql_query("SELECT * FROM difficulty");
$difnumber = mysql_num_rows($difficulty_number);
$cooking_number = mysql_query("SELECT * FROM cooking");
$cooknumber = mysql_num_rows($cooking_number);
if ($cooknumber == '0') {
	echo "<p>" . MSG_COOKING_TABLE_EMPTY . ".<br>";
	echo "<a href=\"admin_cook.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_ADMIN_MENU_COOKING_ADD . "</a>\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
echo "<p class=\"mandatory\">" . MSG_ASTERISK . "\n";
echo "<form method=post action=\"admin_insert.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"ins_preview\">\n<p>";
echo MSG_RECIPE_NAME . "&nbsp;*:\n<input type=\"text\" size=\"30\" name=\"name\" value=\"".$_SESSION['recipe_name']."\"><p>";
echo MSG_RECIPE_SERVING . "&nbsp;*:\n";
echo "<select name=dish><option value=\"\">" . MSG_CHOOSE_SERVING . "</option><option value=\"\">----------------</option>\n";
while ($data_dish=mysql_fetch_object($dish_number)) {
	echo "<option value=\"$data_dish->dish\">$data_dish->dish</option>\n";
}
echo "</select>\n";
echo "<p>" . MSG_RECIPE_MAIN . "&nbsp;*:\n<input type=\"text\" size=\"30\" name=\"mainingredient\" value=\"".$_SESSION['recipe_mainingredient']."\">";
echo "<p>" . MSG_RECIPE_PEOPLE . ":\n<input type=\"text\" size=\"2\" name=\"people\" value=\"".$_SESSION['recipe_people']."\">\n";
echo "<p>" . MSG_RECIPE_ORIGIN . ":\n<input type=\"text\" size=\"30\" name=\"origin\" value=\"".$_SESSION['recipe_origin']."\">\n";
echo "<p>" . MSG_RECIPE_SEASON . ":\n<input type=\"text\" size=\"30\" name=\"season\" value=\"".$_SESSION['recipe_season']."\">\n";
echo "<p>" . MSG_RECIPE_COOKING . "&nbsp;*:\n";
echo "<select name=kind><option value=\"\">" . MSG_CHOOSE_COOKING . "</option><option value=\"\">----------------</option>\n";
while ($data_cook=mysql_fetch_object($cooking_number)) {
	echo "<option value=\"$data_cook->type\">$data_cook->type</option>\n";
}
echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option></select>\n";
echo "<p>" . MSG_RECIPE_TIME . ":\n<input type=\"text\" size=\"30\" name=\"time\" value=\"".$_SESSION['recipe_time']."\">";
echo "<p>" . MSG_RECIPE_DIFFICULTY . "&nbsp;*:\n ";
echo "<select name=difficulty><option value=\"\">" . MSG_CHOOSE_DIFFICULTY . "</option><option value=\"\">--------------------</option>\n";
while ($data_difficulty=mysql_fetch_object($difficulty_number)) {
	echo "<option value=\"$data_difficulty->difficulty\">$data_difficulty->difficulty</option>\n";
}
echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option></select>\n";
echo "</select>\n";
echo "<p>" . MSG_RECIPE_WINES . ":\n<input type=\"text\" size=\"30\" name=\"wine\">";
echo "<p>" . MSG_RECIPE_INGREDIENTS . "&nbsp;*:\n<br><textarea cols=60 rows=5 name=\"ingredients\" wrap=\"virtual\"></textarea>\n<p>" . MSG_RECIPE_DESCRIPTION . "&nbsp;*:\n<br><textarea cols=60 rows=5 name=\"description\" wrap=\"virtual\"></textarea>\n<p>" . MSG_RECIPE_NOTES . ":\n<br><textarea cols=60 rows=5 name=\"notes\" wrap=\"virtual\"></textarea>\n<p><input type=\"submit\" value=\"" . BTN_INSERT_PREVIEW . "\">\n&nbsp;<input type=\"reset\" value=\"" . BTN_INSERT_CLEAR . "\">\n</form>\n";
cs_AdminFastLogout();
cs_AddFooter();
?>

