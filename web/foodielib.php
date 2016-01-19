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

?>
