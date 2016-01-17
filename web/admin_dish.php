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
    // 
    echo "<div id=\"dish\"><ul id=\"sortable\">";
    
    $sql = "SELECT id, dish FROM dish ORDER BY id";
    $dbquery = $dbconnect->query($sql);
    
    while ($row = $dbquery->fetch_object()) {
        echo "<li id=\"{$row->id}\" class=\"ui-state-default\"><span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span>{$row->dish}</li>";
    }
    echo "</ul></div>";
    echo "<form action=\"\"><p>";
    echo "<input type=\"button\" onClick=\"JavaScript:addDish('".MSG_ADMIN_NEW_SERVING."')\" value=\"". MSG_ADMIN_SERVING_ASKNEW . "\">\n";
    echo "<input type=\"button\" onClick=\"JavaScript:submitDish();\" value=\"" . BTN_SUBMIT_CHANGES . "\">\n</form>\n";

    foodie_AddFooter();
}?>
