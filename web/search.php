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

foodie_Begin();
foodie_Header();
echo "<h2>" . MSG_SEARCH_TITLE . "</h2>\n";

$errorstr = "";
$search_text = "";
$search_field = "";
$results = "";

if (isset($_POST['action']))
{
	if(empty($_POST['search_text'])) {
		$errorstr = "<p class=\"error\">" . ERROR_INPUT_REQUIRED . "!\n";
	}
	else {
        $search_text = htmlspecialchars($_POST['search_text']);
        if ($_POST['action'] == "search")
	    {
		    //Split search_text variable entering it into an array
		    //only if contains spaces
		    if (strstr($_POST['search_text'], " "))
		    {
			    $search_terms = explode(" ", $_POST['search_text']);
		    }
            else {
                // an array of one
                $search_terms = array($_POST['search_text']);
            }

            // Get search field, bail out if it's not from the form
            $search_field = $_POST['search_field'];
            $search_field_check = array ('name', 'mainingredient', 'ingredients', 'description', 'notes', 'wines', 'all'); 
            if (!in_array($search_field, $search_field_check)) {	
                $errorstr = "<p class=\"error\">" . ERROR_ILLEGAL_REQUEST ."!\n";
            }
            else {
		        if ($search_field == "all")
		        {
			        $results .= "<p>" . MSG_SEARCH_STRING . " <strong>{$_POST['search_text']}</strong> " . MSG_SEARCH_FOUND . ":<br>\n";
			        foreach ($search_terms as $single_term)
			        {
				        $stmt = $dbconnect->prepare("SELECT * FROM main WHERE name LIKE ? OR mainingredient LIKE ? OR ingredients LIKE ? OR description LIKE ? OR notes LIKE ? OR wines LIKE ? ORDER BY name ASC");
                        $p = "%".$single_term."%";
                        $stmt->bind_param('ssssss', $p, $p, $p, $p, $p, $p);
                
                        $stmt->execute();
				        if (!$search_result = $stmt->get_result())
				        {
                            $results = "";
					        $errorstr = "<p class=\"error\">" . ERROR_SEARCH_DATABASE . "<br>\n" . $search_result->error();
					        break;
				        }
				        else {
                            //count results
				            $num_hits = $search_result->num_rows;
				            //if result == 0
				            if ($num_hits == 0)
				            {
					            $results .= "<p class=\"error\">" . MSG_SEARCH_NORECIPESFOUND . "</p>\n";
				            }
				            else
				            {
					            $results .= "<p class=\"error\">" . MSG_SEARCH_RECIPESFOUND . ": $num_hits</p>\n";
				            }
					
				            while ($search_multi_all_item = $search_result->fetch_object())
				            {
					            $results .= "<p><a href=\"recipe.php?recipe={$search_multi_all_item->id}\">{$search_multi_all_item->name}</a>\n";
				            }
                        }
			        }
		        }
		        else
		        {
			        foreach ($search_terms as $single_term)
			        {
				        //Search on single fields		
				        $results .= "<p>" . MSG_SEARCH_STRING . " <strong>$single_term</strong> " . MSG_SEARCH_FIELD . ":<br>\n";
				        $sql = "SELECT * FROM main WHERE {$search_field} LIKE ? ORDER BY name ASC";
                        $stmt = $dbconnect->prepare($sql);
                        $single_term_wildcard = "%".$single_term."%";
                        $stmt->bind_param('s', $single_term_wildcard);
                        $stmt->execute();
				        if (!$search_result = $stmt->get_result())
				        {
					        $errorstr = "<p class=\"error\">" . ERROR_SEARCH_DATABASE . "<br>\n" . $search_result->error();
					        break;
				        }
                        else {
				            //count results
				            $num_hits = $search_result->num_rows;
				            //if result == 0
				            if ($num_hits == 0)
				            {
					            $results .= "<p class=\"error\">" . MSG_SEARCH_NORECIPESFOUND . "</p>\n";
				            }
				            else
				            {
					            $results .= "<p class=\"error\">" . MSG_SEARCH_RECIPESFOUND . ": $num_hits</p>\n";
				            }

				            while ($search_multi_item = $search_result->fetch_object())
				            {
					            $results .= "<p><a href=\"recipe.php?recipe=$search_multi_item->id\">$search_multi_item->name</a>\n";
				            }
                        }
			        }
		        }
            }
	    }
	    else {
		    //Display an error message if hidden post variable has
		    //been tampered
		    $errorstr =  "<p class=\"error\">" . ERROR_UNEXPECTED . "<br>\n";
	    }
    }
}
//Count recipes in database
if ($dbquery = $dbconnect->query("SELECT COUNT(*) FROM main"))
{
    $result = $dbquery->fetch_row();
    $num_recipes = $result[0];
    $dbquery->close();
    if ($num_recipes == 0)
    {
	    $errorstr = "<p class=\"error\">" . MSG_NO_RECIPES . "<br>\n" . MSG_BROWSE_EMPTY . "?\n";
    }
	
}
else {
    $errorstr = "<p class=\"error\">" . ERROR_COUNT_RECIPES . "<br>\n" . $dbquery->error();
}

?>
    <form method="post" action="search.php">
      <input type="hidden" name="action" value="search">
      <p><?= MSG_SEARCH_INSERT_STRING ?>:<br>
      (<?= MSG_SEARCH_INSERT_PARTIAL ?>)<br>
      <input type="text" name="search_text" size="80" value="<?= $search_text ?>">
      <p><?= MSG_SEARCH_INSERT_FIELD ?>:<br>
      <select name="search_field">
        <?= foodie_OptionText("all", MSG_SEARCH_ALLFIELDS, $search_field) ?>
        <?= foodie_OptionText("name", MSG_RECIPE_NAME, $search_field) ?>
        <?= foodie_OptionText("mainingredient", MSG_RECIPE_MAIN, $search_field) ?>
        <?= foodie_OptionText("ingredients", MSG_RECIPE_INGREDIENTS, $search_field) ?>
        <?= foodie_OptionText("description", MSG_RECIPE_DESCRIPTION, $search_field) ?>
        <?= foodie_OptionText("notes", MSG_RECIPE_NOTES, $search_field) ?>
        <?= foodie_OptionText("wines", MSG_RECIPE_WINES, $search_field) ?>
      </select>
      <p><input type="submit" value="<?= BTN_SEARCH ?>">
    </form>
<?php

if (!empty($errorstr))
{
	echo $errorstr;
}

echo $results;

foodie_Footer();
?>
