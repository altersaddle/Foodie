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
//Session initialization
srand((double)microtime()*1000000);
$sess_id = md5(rand(0,9999999));
session_id($sess_id);
session_name("foodie");
session_start();

require(dirname(__FILE__)."/config/foodie.ini.php");

if (!isset($_SESSION['locale'])) {
  $_SESSION['locale'] = $setting_locale;  
}
require_once(dirname(__FILE__)."/lang/".$_SESSION['locale'].".php");

require(dirname(__FILE__)."/foodielib.php");
//header markup
foodie_AddHeader();
//DB server connection test
require(dirname(__FILE__)."/includes/dbconnect.inc.php");
//Database check. If it doesn't exist, invite to create it

if (!($dbconnect->select_db($db_name))) {
	        echo "<p class=\"error\">" . ERROR_DB_NOT_EXIST . "<br>\n";
	        echo "<p><a href=\"install.php\">" . MSG_REINSTALL . "</a>\n";
}
else {
		//Display number of recipes into database
		$dbquery = $dbconnect->query("SELECT COUNT(*) FROM main");
		$result = $dbquery->fetch_row();
		$number = $result[0];
		echo "<p>" . MSG_CONTAINS . " $number " . MSG_RECIPES . "</p>";

		$dbquery->close();
		$dbquery = $dbconnect->query("SELECT id, name, image, dish FROM main");
		?>
       <div id="foodie-index" style="margin:0px auto;display:none;">
	   <?php // loop through results 
	   while ($row = $dbquery->fetch_object()) {

	   $imgsrc = "images/".$row->image;

	   if (!$row->image) {
	     $imgsrc = "images/placeholder-".strtolower($row->dish).".png";
	   }
       ?>
         <a href="recipe.php?recipe=<?= $row->id ?>">
			<img alt="<?= $row->name ?>"
			     src="<?= $imgsrc ?>"
			     data-image="images/<?= $row->image ?>"
			     data-description="<?= $row->name ?> (<?= $row->dish ?>)"
			     style="display:none">
		</a>
		<?php } 
		$dbquery->close();
        ?>
		</div>
		<?php
}
foodie_AddFooter();
?>
