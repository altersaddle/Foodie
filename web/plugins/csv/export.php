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
// Export plugin for CSV file format
function foodie_export($result)
{
	echo "<p>" . MSG_EXPORT_CSV_EXPORTING_MAIN . "...\n";
	$filename = "foodie.csv";

    $basedir = dirname(__FILE__);
	$basedir = str_replace("/plugins/$export_type", "", $basedir);
	$exportfile = fopen("$basedir/export/$filename", "w");
	if (file_exists($exportfile)) {
		echo "<p>" . MSG_EXPORT_DELETE_OLD . "\n";
		unlink($exportfile);
	}
	if (!$exportfile) {
		echo "<p class=\"error\">" . ERROR_EXPORT_FILE_OPEN . "\n";
	}
    else {
	    while ($main_data = $result->fetch_object()) {
            fputs($exportfile,"$main_data->id;$main_data->name;$main_data->dish;$main_data->mainingredient;$main_data->people;$main_data->origin;$main_data->ingredients;$main_data->description;$main_data->kind;$main_data->season;$main_data->time;$main_data->difficulty;$main_data->notes;$main_data->wines\r\n");
        }
    }
    fclose($exportfile);
	echo "<p>" . MSG_EXPORT_FILE_DONE . " <a href=\"export/$filename\" target=\"_blank\">export/$filename</a>\n";
}
?>
