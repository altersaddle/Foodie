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
    echo "<h3>" . MSG_ADMIN_MENU_UTIL_EXPMAIN . "</h3>\n";
    if (!isset($_POST['action']))
    {
	    echo "<p>" . MSG_ADMIN_EXPORT_ASKTYPE . ":\n";
	    echo "<br><form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	    echo "<input type=\"hidden\" name=\"action\" value=\"export_ok\">\n
	    <input type=\"hidden\" name=\"mode\" value=\"all\">\n
	    <select name=\"export_type\">\n";
	    //Read available directories into plugins subdir 
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
	    echo "</select>\n<p><input type=\"submit\" value=\"" . BTN_ADMIN_EXPORT . "\">\n
	    </form>\n";
    }
    else {
	    if ($_POST['action'] != "export_ok")
	    {
		    echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
	    }
        else {
	        $export_type = $_POST['export_type'];
	        require(dirname(__FILE__)."/plugins/$export_type/export.php");
        }
    }
    
    foodie_Footer();
}?>
