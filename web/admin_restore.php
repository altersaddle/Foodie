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

$filename = "foodie.sql";

if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php?redirect=".urlencode($_SERVER["REQUEST_URI"]));
}
else {
    foodie_Begin();
foodie_AdminHeader();
    echo "<h2>" . MSG_ADMIN . "</h2>\n";
    echo "<h3>" . MSG_ADMIN_MENU_BACKUP_RST. "</h3>\n";
    if (!isset($_POST['restore_action']))
    {
	    echo "<p>" . MSG_ADMIN_RESTORE_SUBDIR . "\n";
	    echo "<p><form method=\"post\" action=\"admin_restore.php\">\n";
	    echo "<input type=\"hidden\" name=\"restore_action\" value=\"do_restore\">
	    <p><input type=\"submit\" value=\"" . BTN_ADMIN_RESTORE_PROCEED . "\">
	    </form>\n";
    }
    else {
	    //If $_POST variable is correctly set restore sql backup file
	    if ($_POST['restore_action'] == "do_restore")
	    {
		    $restore_file = dirname(__FILE__)."/backup/$filename";
		    if (!file_exists($restore_file))
		    {
			    echo "<p class=\"error\">" . ERROR_ADMIN_RESTORE_FILE . ".\n";
		    }
            else {
                // First line is a comment, shift it
                $sql_queries = file($restore_file);
                array_shift($sql_queries);
		        
		        foreach ($sql_queries as $single_query)
		        {
			        $exec_query = $dbconnect->query($single_query);
		        }
		        echo "<p>" . MSG_ADMIN_RESTORE_SUCCESS . ".\n";
            }
	    }
        else {
	        echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
        }
    }
    foodie_Footer();
}
?>
