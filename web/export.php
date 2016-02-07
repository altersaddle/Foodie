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
foodie_AddHeader();
echo "<h3>" . MSG_EXPORT_SINGLE . "</h3>\n";
if (!isset($_POST['action'])) {
	echo "<p class=\"error\">" . ERROR_EXPORT_RECIPE_CALL . "\n";
}
else {
	if ($_POST['action'] != "export_ok") {
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
	}
    else {
	    $export_type = $_POST['export_type'];
	    require(dirname(__FILE__)."/plugins/$export_type/export.php");
        // if recipe_id is set, export just that recipe
        if (isset($_POST['recipe'])) { 
            $stmt = $dbconnect->prepare("SELECT * FROM main WHERE id = ?");
            $stmt->bind_param('s', $_GET['recipe'] );
            $stmt->execute();

            foodie_export($stmt->get_result());
        }
        else if ($_POST['mode'] == "all") {
            foodie_export($dbconnect->query("SELECT * FROM main"));
        }
        else {
            echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
        }
    }
}
foodie_Footer();
?>
