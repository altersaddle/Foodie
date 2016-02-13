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

if (isset($_POST['action']))
{
	//Printer friendly version
	if ($_POST['action'] == "rec_print")
	{
		$stmt = $dbconnect->prepare("SELECT * FROM main WHERE id = ?");
        $stmt->bind_param('s', $_POST['recipe'] );
        $stmt->execute();
		if (!$recipe_result = $stmt->get_result()) 
		{
			foodie_Begin();
            foodie_Header();
			echo "<p>" . MSG_RECIPE_NO_RETRIEVE ."<br>\n" . $recipe_result->error();
			foodie_Footer();
			exit();
		}
		while ($data = $recipe_result->fetch_object()) 
		{
			echo "<h2>$data->name</h2>\n";
			if (!empty($data->image)) 
			{
				echo "<div align=center><img src=\"images/$data->image\" alt=\"$data->name\"></div>\n";
			} 
			echo "<p>" . MSG_RECIPE_SERVING . ": $data->dish\n";
			echo "<br>" . MSG_RECIPE_MAIN . ": $data->mainingredient\n";
			echo "<br>" . MSG_RECIPE_PEOPLE . ": $data->people\n";
			echo "<br>" . MSG_RECIPE_ORIGIN . ": $data->origin\n";
			echo "<br>" . MSG_RECIPE_SEASON . ": $data->season\n";
			echo "<br>" . MSG_RECIPE_COOKING . ": $data->kind\n";
			echo "<br>" . MSG_RECIPE_TIME . ": $data->time\n";
			echo "<br>" . MSG_RECIPE_DIFFICULTY . ": \n";
			for ($i = 1; $i <= $data->difficulty; $i++) 
			{
				echo "*";
			}
			echo "<br>" . MSG_RECIPE_WINES . ": $data->wines\n";
			echo "<br>" . MSG_RECIPE_INGREDIENTS . ": ". nl2br($data->ingredients) ."\n";
			echo "<br>" . MSG_RECIPE_DESCRIPTION . ": ". nl2br($data->description) ."\n";
			echo "<br>" . MSG_RECIPE_NOTES . ": $data->notes\n";
		}
		echo "<p class=small>" . MSG_RECIPE_PRINTED . " <em>Foodie</em>!</p>\n";
		exit();
	}
	else
	{
		//Display an error message if hidden post variable has
		//been tampered
		cs_AddHeader();
		echo "<p class=\"error\">" . ERROR_UNEXPECTED .".<br>\n";
		cs_AddFooter();
		exit();
	}
}
foodie_Begin();
foodie_Header();
$stmt = $dbconnect->prepare("SELECT * FROM main WHERE id = ?");
$stmt->bind_param('s', $_GET['recipe'] );
$stmt->execute();

if (!$recipe_result = $stmt->get_result()) {
	echo "<p>" . ERROR_RECIPE_RETRIEVE ."<br>\n";
	echo $recipe_result->error();
	foodie_Footer();
	exit();
}
$reciperow = $recipe_result->fetch_assoc();
$recipename = $reciperow['name'];
foodie_PrintRecipeData($reciperow);
$recipe_result->close();
//Counts votes into database and displays number of votes 
$stmt = $dbconnect->prepare("SELECT vote FROM rating WHERE id = ?");
$stmt->bind_param('s', $_GET['recipe']);
$stmt->execute();
if (!$votes_result = $stmt->get_result())
{
	echo "<p class=\"error\">" . ERROR_COUNT_VOTES . " {$recipename}<br>" . $votes_result->error();
	foodie_Footer();
	exit();
}
$num_votes = $votes_result->num_rows;
//Calculate average vote
if ($num_votes >= 1) {
    $sum_votes = 0;
    while ($rate_data = $votes_result->fetch_object())
    {
	    $sum_votes = $sum_votes + $rate_data->vote;
    }
    $avg_vote = $sum_votes / $num_votes;
    $votes_result->close();
    echo "<table><tr><td><p>" . MSG_RECIPE_VOTES_TOT . " $num_votes " . MSG_RECIPE_VOTES_AVG . ": $avg_vote\n</td><td>\n";
} 
else
{
	echo "<table><tr><td><p>" . MSG_RECIPE_NEVER_RATED . "\n -</td><td>\n";
}
echo "<form method=\"post\" action=\"rate.php\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"v_rate\">\n";
echo "<input type=\"hidden\" name=\"recipe_id\" value=\"{$_GET['recipe']}\">\n";
echo "<input type=\"submit\" value=\"" . BTN_RATE_RECIPE ."\"></form></td><tr></table>\n";


//Buttons below recipe
echo "<table><tr>";
//Print link to add selected recipe to personal cookbook only if it does
//not exist and referer is not cookbook.php
if (!strstr($_SERVER['HTTP_REFERER'], "cookbook.php"))
{
    $stmt = $dbconnect->prepare("SELECT id FROM personal_book WHERE id = ?");
    $stmt->bind_param('s', $_GET['recipe']);
    $stmt->execute();
	if (!$cookbook_result = $stmt->get_result())
	{
		echo "<td><p class=\"error\">" . ERROR_CHECK_COOKBOOK . "</td></tr></table><br>\n" . $cookbook_result->error();
		exit();
	}
	$num_cookbook = $cookbook_result->num_rows;
	if (0 == $num_cookbook)
	{
		echo "<td><form method=\"post\" action=\"cookbook.php\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"cook_add\">\n";
        echo "<input type=\"hidden\" name=\"recipe\" value=\"{$_GET['recipe']}\">\n";
        echo "<input type=\"submit\" value=\"" . BTN_ADD_COOKBOOK . "\"></form></td>\n";
	}
	else
	{
		echo "<td><p>" . MSG_ALREADY_COOKBOOK . "</td>\n";
	}
    $cookbook_result->close();
}
//Button for "Printer friendly" option
echo "<td><form method=\"post\" action=\"recipe.php\" target=\"_blank\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"rec_print\"><input type=\"hidden\" name=\"recipe\" value=\"{$_GET['recipe']}\">\n<input type=\"submit\" value=\"" . BTN_PRINT . "\"></form></td>\n";
echo "<td><form method=\"post\" action=\"shoppinglist.php\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"sl_add\">\n<input type=\"hidden\" name=\"recipe\" value=\"{$_GET['recipe']}\"><input type=\"submit\" value=\"" . BTN_ADD_SHOPPING . "\"></form></td>\n</tr></table>\n";
//Export single recipe
echo "<p>" . MSG_EXPORT_ASK .":\n";
echo "<form method=\"post\" action=\"export.php\">\n";
echo "<input type=\"hidden\" name=\"recipe\" value=\"{$_GET['recipe']}\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"export_ok\">\n
<input type=\"hidden\" name=\"mode\" value=\"single\">\n
<select name=\"export_type\">\n";
$plugins_dir = opendir(dirname(__FILE__)."/plugins");
while (($plugin_item = readdir($plugins_dir)) !== false) 
{ 
	if ($plugin_item == "." OR $plugin_item == "..") continue;
	$export_file = "plugins/".$plugin_item."/export.php";
	if (file_exists($export_file))
	{
		include(dirname(__FILE__)."/plugins/$plugin_item/definition.php");
		echo "<option value=\"$plugin_item\">$definition</option>\n";
	}
}  
closedir($plugins_dir);
echo "</select>\n<input type=\"submit\" value=\"" . MSG_EXPORT . "\"></form></td>\n";
//Go back
echo "<p><a href=\"{$_SERVER['HTTP_REFERER']}\">" . MSG_BACK . "</a>\n";
//}
foodie_Footer();
?>
