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
    echo "<h3>" . MSG_ADMIN_MENU_UTIL_IMPFILES . "</h3>\n";
    if (!isset($_POST['action']))
    {
	    echo "<p>" . MSG_ADMIN_IMPORT_ASKTYPE . ":\n";
	    echo "<br><form method=\"post\" enctype=\"multipart/form-data\" action=\"{$_SERVER['PHP_SELF']}\">\n";
	    echo "<input type=\"hidden\" name=\"action\" value=\"import_ok\">\n
	    <select name=\"import_type\">\n";
	    //Read available directories into plugins subdir 
	    $plugins_dir = opendir(dirname(__FILE__)."/plugins");
	    while (($plugin_item = readdir($plugins_dir)) !== false) 
	    { 
		    if ($plugin_item == "." OR $plugin_item == "..") continue;
		    $import_file = "plugins/".$plugin_item."/import.php";
		    if (file_exists($import_file))
		    {
			    include(dirname(__FILE__)."/plugins/$plugin_item/definition.php");
			    echo "<option value=\"$plugin_item\">$definition</option>\n";
		    }
	    }  
	    closedir($plugins_dir);
	
    	    echo "</select>\n
	    <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"8000000\">
	    <p>" . MSG_ADMIN_IMPORT_FILE . " :<br>\n
	    <input type=\"file\" name=\"import_file\">\n
	    <p><input type=\"submit\" value=\"" . BTN_ADMIN_IMPORT . "\">\n
	    </form>\n";
    }
    else {
	    if ($_POST['action'] != "import_ok") {
		    echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
	    }
        else {
	        $import_type = $_POST['import_type'];
	        require(dirname(__FILE__)."/plugins/$import_type/import.php");
        }
    }
    foodie_Footer();
}
?>
