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
    echo "<h3>" . MSG_ADMIN_MENU_CONFIG_USR . "</h3>\n";
    //Update the database
    if (isset($_POST['adm_change'])) {

	    $sql_adm_chg = "UPDATE admin SET (password = ?) WHERE user = ?"; //VALUES ('{$_POST['adminuser']}', '{$_POST['adminpass']}')";
        $stmt = $dbconnect->prepare($sql_adm_chg);
        $stmt->bind_param("ss", $_POST['adminpass'], $_POST['adminuser']);
        $stmt->execute();
	    if (!$exec_adm_chg = $stmt->get_result())
	    {
		    echo "<p class=\"error\">" . ERROR_ADMIN_USERPASS_END . "<br>\n" . $exec_adm_chg->error();
	    }
	    echo "<p>" . MSG_ADMIN_USERPASS_SUCCESS . ".\n";
    }
    else {
    //Retrieve admin user and pass
        $sql_admin = "SELECT * FROM admin WHERE user = ?";
		$stmt = $dbconnect->prepare($sql_admin);
        $stmt->bind_param('s', $_SESSION['admin_user'] );
        $stmt->execute();
		if (!$recipe_result = $stmt->get_result()) 
        {
	        echo "<p class=\"error\">" . ERROR_ADMIN_USERPASS_RETRIEVE . "\n<br>" . $recipe_result();
	    }
        //Print the form - should only be one row here !
        else {
            while ($admindata = $recipe_result->fetch_object())
            {
	            echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n";
	            echo "<p>Admin username: <input type=\"text\" size=\"20\" name=\"adminuser\" value=\"$admindata->user\">\n<p>Admin password: <input type=\"text\" size=\"20\" name=\"adminpass\" value=\"$admindata->password\">\n<p><input type=\"submit\" name=\"adm_change\" value=\"" . BTN_ADMIN_USERPASS_CHANGE . "\">\n";
	        }
        }
    }
    foodie_AddFooter();
}?>
