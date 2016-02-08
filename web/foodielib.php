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

// Start the HTML document
function foodie_Begin()
{
    echo <<<EOT
<html>
  <head>
    <meta http-equiv="Cache-Control" content="private, pre-check=0, post-check=0, max-age=0">
	<meta http-equiv="Expires" content="Tue, 17 Nov 2002, 00:00:00 GMT">
	<title>{ MSG_SITE_BROWSER_TITLE }</title>
    <link href="foodie.css" rel="stylesheet" type="text/css">
EOT;
}

// Print the page title and common links
function foodie_Header() 
{	
    echo <<<EOT
  </head>
  <body>
    <h1><a href="index.php">{ MSG_SITE_TITLE ?></a></h1>
    <p class="menu">
      <table border="0" width="95%" cellpadding=0 cellspacing=0>
        <tr>
          <td class="menu" align="left">
            <a href="browse.php">{ MSG_BROWSE }</a> - 
	        <a href="search.php">{ MSG_SEARCH }</a> - 
	        <a href="cookbook.php">{ MSG_COOKBOOK }</a> - 
	        <a href="shoppinglist.php">{ MSG_SHOPPING }</a>
	     </td>
         <td align="right" class="menu">
            <a href="admin_index.php">{ MSG_ADMIN }</a> 
         </td>
       </tr>
     </table>	
EOT;
}

// Print the administrative links 
function foodie_AdminHeader()
{

}

// Print the markup that appears at the bottom of the page
function foodie_Footer()
{
    echo "<p class=\"small\">Powered by <a href=\"https://github.com/altersaddle/Foodie\"><em>Foodie</em></a>!</p>\n";
    echo "<p class=\"small\"><a href=\"license.php\">" . MSG_GPL_NOTICE . "</p>\n";
}

// Close the HTML document
function foodie_End()
{
    echo "</body></html>";
}

function foodie_AlphaLinks($link)
{
	$alphabet = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9");
	echo "<p>";
	foreach ($alphabet as $letter)
	{
		echo "<a href=\"".$link."letter=$letter\">$letter</a> ";
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
