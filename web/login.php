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

if (isset($_POST['admin_user']) && isset($_POST['admin_pass'])) {
	if (empty($_POST['admin_user'])) {
		echo "<p class=\"error\">" . ERROR_ADMIN_INVALID_USERNAME . "!\n";
	}
	if (empty($_POST['admin_pass'])) {
		echo "<p class=\"error\">" . ERROR_ADMIN_INVALID_PASSWORD . "!\n";
	}
    // Check if credentials match
    // TODO: Convert this function to use stored procedure and single select
    $sql_stored_user = "SELECT user, password FROM admin";
	if (!$auth_result = $dbconnect->query($sql_stored_user)) {
		echo "<p class=\"error\">" . ERROR_ADMIN_CHECK_DB . "!\n";
		cs_AddFooter();
		exit();
	}
	while ($auth_data = $auth_result->fetch_object()) {
		if ($auth_data->user == $_POST['admin_user']) {
			if ($auth_data->password == $_POST['admin_pass']) {
				$_SESSION['admin_user'] = $_POST['admin_user'];
				break;
			} else {
				echo "<p class=centerwarn>" . ERROR_ADMIN_AUTHFAIL . "\n";
			}
		}
	}
}

if (isset($_SESSION['admin_user'])) {
    if (!empty($_POST['redirect'])) {
        header("Location: {$_POST['redirect']}");
    }
    else {
        header("Location: admin_index.php");
    }
}
else {
    foodie_AddHeader();
    echo "<h2>" . MSG_ADMIN . "</h2>\n";
    echo "<p class=centerwarn>" . MSG_ADMIN_USERPASS_REQUEST . ":\n";
    echo "<form method=\"post\" action=\"#\">\n";
    echo "<div align=center><table border=0>\n
    <tr><td><p class=centermsg>" . MSG_ADMIN_USER . ": </td><td><input type=text width=20 name=\"admin_user\"></td></tr>\n
    <tr><td><p class=centermsg>" . MSG_ADMIN_PASS . ": </td><td><input type=password width=20 name=\"admin_pass\"></td></tr>\n
    <tr><td colspan=2 align=center><input type=submit value=\"" . MSG_ADMIN_LOGIN . "\"></form></td></tr></table>\n";
    if (!empty($_GET['redirect'])) {
        echo "<input type=\"hidden\" width=20 name=\"redirect\" value=\"{$_GET['redirect']}\">";
    }
    //Query the database for default admin username and password and display an alert if stored ones are as default
    $sql_check_default = "SELECT * FROM admin WHERE user = 'admin' OR password = 'admin'";
    if (!$query_admin = $dbconnect->query($sql_check_default))
    {
	    echo "<p class=\"error\">" . ERROR_ADMIN_CHECK_DB . "\n";
    }
    else {
        $num_default = $query_admin->num_rows;
        if ($num_default >= 1)
        {
	        echo "<p class=\"error\">" . ERROR_ADMIN_CHANGE_DEFAULT . "!\n";

        }
    }
    foodie_AddFooter();
}
?>

