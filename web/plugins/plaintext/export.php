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
// Export plugin for plain text format
function foodie_export($result)
{
	echo "<p>" . MSG_EXPORT_TXT_EXPORTING_MAIN . "...\n";
	$filename = "foodie.txt";

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
		    $text_description = wordwrap($main_data->description, 72);
		    $text_ingredients = wordwrap($main_data->ingredients, 72);
		    $text_notes = wordwrap($main_data->notes, 72);
		    fputs($exportfile,"$main_data->id\r\n$main_data->name\r\n$main_data->dish\r\n$main_data->mainingredient\r\n$main_data->people\r\n$main_data->origin\r\n$text_ingredients\r\n$text_description\r\n$main_data->kind\r\n$main_data->season\r\n$main_data->time\r\n$main_data->difficulty\r\n$text_notes\r\n$main_data->wines\r\n\r\n");
	    }
    }
	fclose($exportfile);
	echo "<p>" . MSG_EXPORT_FILE_DONE . " <a href=\"export/$filename\" target=\"_blank\">export/$filename</a>\n";
}
?>
