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
    echo "<h3>" . MSG_ADMIN_MENU_RECIPE_DEL . "</h3>\n";
    //If is set GET recipe delete from database
    if (isset($_GET['recipe']))
    {
	    $sql_delete_recipe = "DELETE FROM main WHERE id = '{$_GET['recipe']}'";
	    if (!$exec_delete_recipe = $dbconnect->query($sql_delete_recipe)) {
		    echo "<p class=\"error\">" . ERROR_ADMIN_DELETE_RECIPE . "<br>\n" . $exec_delete_recipe->error;
	    }
        else {
	        echo "<p>" . MSG_ADMIN_DELETE_SUCCESS . "\n";
        }
    }
    else {
        echo "<p>" . MSG_ADMIN_DELETE_SELECT . "\n";
        // Print browse list
        if (!isset($_GET['offset'])) 
        {
	        $_GET['offset'] = 0;
        }
        
        $letter_where = '';
        $letter_arg = '';
        $sql = "SELECT id,name FROM main ORDER BY name ASC LIMIT {$_GET['offset']},{$setting_max_lines_page}";
        //Retrieve recipe names and ID's
        if (isset($_GET['letter'])) {
	        $sql = "SELECT id,name FROM main WHERE name LIKE '{$_GET['letter']}%' ORDER BY name ASC LIMIT {$_GET['offset']},{$setting_max_lines_page}";
            $letter_arg = "&letter=".$_GET['letter'];
            $letter_where = " WHERE name LIKE '{$_GET['letter']}%'";
        }

        //Count recipes in database
        $dbquery = $dbconnect->query("SELECT COUNT(*) FROM main $letter_where");
        $result = $dbquery->fetch_row();
        $recipe_number = $result[0];
        $dbquery->close();
        
        if (!$query = $dbconnect->query($sql)) 
        {
	        echo "<p class=\"error\">" . ERROR_BROWSE . "\n<br>" . $query->error;
        };
        foodie_AlphaLinks("admin_delete.php?");
        //Count recipes in query, if == 0 print that no recipes are
        //available
        $num_letter = $query->num_rows;
        if ($num_letter == "0")
        {
	        echo "<p class=\"error\">" . ERROR_ADMIN_DELETE_LETTER . " {$_GET['letter']}\n";
        }
        //Print browse table used to delete recipes
	    echo "<table class=\"browse\">";
        while ($row = $query->fetch_object()) 
	    {
		    echo "<tr><td>\n<a href=\"admin_delete.php?recipe=$row->id\">$row->name</a></td></tr>\n";
	    }
	    echo "</table>\n";

        echo "<p>" . MSG_AVAILABLE_PAGES . ": \n";
        if ($_GET['offset'] >= 1) 
        { // bypass PREV link if offset is 0
	        $prevoffset = $_GET['offset'] - $setting_max_lines_page;
	        echo "<p align=\"center\"><a href=\"admin_delete.php?offset=$prevoffset$letter_arg\">" . MSG_PREVIOUS . "</a> - \n";
        }
        // calculate number of pages needing links
        $pages = intval ($recipe_number / $setting_max_lines_page);
        // $pages now contains int of pages needed unless there is a remainder from division
        if ($recipe_number%$setting_max_lines_page) 
        {
	        // has remainder so add one page
	        $pages++;
        }
        for ($i = 1; $i <= $pages; $i++) 
        { // loop thru
	        $newoffset=$setting_max_lines_page*($i-1);
	        echo "<a href=\"admin_delete.php?offset=$newoffset$letter_arg\">$i</a> \n";
        }
        // check to see if last page
        if (!(($_GET['offset']/$setting_max_lines_page)==$pages) && $pages!=1) 
        {
	        // not last page so give NEXT link
	        $newoffset=$_GET['offset']+$setting_max_lines_page;
	        echo "&nbsp;-&nbsp;<a href=\"admin_delete.php?offset=$newoffset$letter_arg\">" . MSG_NEXT . "</a>\n";
        }
    }
}
?>
