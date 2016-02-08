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
echo "<h2>" . MSG_BROWSE . "</h2>\n";

//Count recipes in database
$dbquery = $dbconnect->query("SELECT COUNT(*) FROM main");
$result = $dbquery->fetch_row();
$num_recipes = $result[0];
$dbquery->close();

// TODO: get this from the session?
$lines_per_page = $setting_max_lines_page;
$browse_parameter = 'id';
$letterarg = '';
$letter = '';
$offset = 0;

if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {
	$offset = $_GET['offset'];
}

if (isset($_GET['letter']) && strlen($_GET['letter']) == 1) {
    $letter = $_GET['letter'];
}

//If GET browse variable is not set print links to choose kind of
//browsing
if (!isset($_GET['browse'])) {
	if ($num_recipes == 0) 	{
		echo "<p class=\"error\">" . MSG_NO_RECIPES . "<br>\n" . MSG_BROWSE_EMPTY . "?\n";
	}
    else {
	    echo "<p>" . MSG_SELECT_BROWSE . "\n";
	    echo "<p><a href=\"{$_SERVER['PHP_SELF']}?browse=br_recipe\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_ID . "</a><br>\n";
	    echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_alpha\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_ALPHA . "</a><br>\n";
	    echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_dish\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_SERVING . "</a><br>\n";
	    echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_ingredient\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_MAIN . "</a><br>\n";
	    echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_cook\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_KIND . "</a><br>\n";
	    echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_origin\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_ORIGIN . "</a><br>\n";
	    echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_season\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_SEASON . "</a><br>\n";
	    echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_easy\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_EASY . "</a><br>\n";
	    echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_difficult\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_HARD . "</a><br>\n";
    }
}
else {

    $browse_check = array ('br_recipe', 'br_alpha', 'br_dish', 'br_ingredient', 'br_cook', 'br_season', 'br_easy', 'br_difficult', 'br_origin', 'br_letter'); 
    if (!in_array("{$_GET['browse']}", $browse_check)) {	
        echo "<p class=\"error\">" . ERROR_ILLEGAL_REQUEST ."!\n";
    }
    else {
        if ($_GET['browse'] == 'br_recipe') {
            $sql_db_browse = "SELECT id,name FROM main LIMIT {$offset},{$lines_per_page}";
        }
        else if ($_GET['browse'] == 'br_alpha') {
            $sql_db_browse = "SELECT id,name FROM main ORDER BY name ASC LIMIT {$offset},{$lines_per_page}";
        }
        else if ($_GET['browse'] == 'br_dish') {
            $sql_db_browse = "SELECT id,name,dish FROM main ORDER BY dish ASC, name ASC LIMIT {$offset},{$lines_per_page}";
            $browse_parameter = 'dish';
        }
        else if ($_GET['browse'] == 'br_ingredient') {
            $sql_db_browse = "SELECT id,name,mainingredient FROM main ORDER BY mainingredient ASC, name ASC LIMIT {$offset},{$lines_per_page}";
            $browse_parameter = 'mainingredient';
        }
        else if ($_GET['browse'] == 'br_cook') {
            $sql_db_browse = "SELECT id,name,kind FROM main ORDER BY kind ASC, name ASC LIMIT {$offset},{$lines_per_page}";
            $browse_parameter = 'kind';
        }
        else if ($_GET['browse'] == 'br_season') {
            $sql_db_browse = "SELECT id,name,season FROM main ORDER BY season ASC, name ASC LIMIT {$offset},{$lines_per_page}";
            $browse_parameter = 'season';
        }
        else if ($_GET['browse'] == 'br_easy') {
            $sql_db_browse = $sql_db_browse = "SELECT id,name,REPEAT('*',difficulty) AS diffstars FROM main ORDER BY difficulty ASC, name ASC LIMIT {$offset},{$lines_per_page}";
            $browse_parameter = 'diffstars';
        }
        else if ($_GET['browse'] == 'br_difficult') {
            $sql_db_browse = $sql_db_browse = "SELECT id,name,REPEAT('*',difficulty) AS diffstars FROM main ORDER BY difficulty DESC, name ASC LIMIT {$offset},{$lines_per_page}";
            $browse_parameter = 'diffstars';
        }
        else if ($_GET['browse'] == 'br_origin') {
            $sql_db_browse = "SELECT id,name,origin FROM main ORDER BY origin ASC LIMIT {$offset},{$lines_per_page}";
            $browse_parameter = 'origin';
        }
        else if ($_GET['browse'] == 'br_letter') {
            $sql_db_browse = "SELECT id,name FROM main WHERE name LIKE '{$letter}%' ORDER BY name ASC LIMIT {$offset},{$lines_per_page}";
            $letterarg = "&letter={$letter}";
        }


        if (!$browse_query = $dbconnect->query($sql_db_browse)) {
	        echo "<p class=\"error\">" . ERROR_BROWSE . "\n<br>";
	        echo $browse_query->error();
        }
        else {
            //Print alpha links
            if ($_GET['browse'] == 'br_letter' || $_GET['browse'] == 'br_alpha') {
                foodie_AlphaLinks("browse.php?browse=br_letter&");
            }
            //
            if ($_GET['browse'] == 'br_letter') {
	            $num_recipes = $browse_query->num_rows;
	            if ($num_recipes == "0")
	            {
		            echo "<p class=\"error\">" . MSG_RECIPES_INITIAL . " {$letter}\n";
	            }
            }
            foodie_PrintBrowseTable($browse_query, $browse_parameter);
            $browse_query->close();

            if ($num_recipes > 0) {
                //Print available pages
                echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
                if ($offset >= 1) 
                { 
	                $prevoffset=$offset - $lines_per_page;
	                echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset{$letterarg}\">" . MSG_PREVIOUS ."</a> - \n";
                }
                $pages=intval($num_recipes/$lines_per_page);
                if ($num_recipes%$lines_per_page) 
                {
	                $pages++;
                }
                for ($i = 1; $i <= $pages; $i++) { 
    	            $newoffset = $lines_per_page*($i-1);
	                echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset{$letterarg}\">$i</a> \n";
                }
                // check to see if last page
                if (!(($offset/$lines_per_page)==$pages) && $pages!=1) {
	                // more available, print NEXT link
	                $newoffset=$offset+$lines_per_page;
	                echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset{$letterarg}\">" . MSG_NEXT ."</a>\n";
                }
            } // more than one recipe
        } // SQL was successful
    } // Request was legal

} 
foodie_Footer();
?>

