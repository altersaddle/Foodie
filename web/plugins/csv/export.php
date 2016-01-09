<?php
/*
***************************************************************************
* CrisoftRicette is a GPL licensed free software sofware written
* by Lorenzo Pulici, Milano, Italy (Earth)
* You can read license terms reading COPYING file included in this
* package.
* In case this file is missing you can obtain license terms through WWW
* pointing your web browser at http://www.gnu.org or http:///www.fsf.org
* If you can't browse the web please write an email to the software author
* at snowdog@tiscali.it
****************************************************************************
*/
// Export plugin for CSV file format
if ($_POST['mode'] == "all")
//Export entire main table
{
	echo "<p>" . MSG_EXPORT_CSV_EXPORTING_MAIN . "...\n";
	$sql_main = "SELECT * FROM main";
	if (!$exec_main = mysql_query($sql_main))
	{
		echo "<p class=\"error\">" . ERROR_RETRIEVE_MAIN_TABLE . "<br>\n". mysql_error();
		cs_AddFooter();
		exit();
	}
	$basedir = dirname(__FILE__);
	$basedir = str_replace("/plugins/$export_type", "", $basedir);
	$exportfile = fopen("$basedir/export/CrisoftRicette.csv", "w");
	if (file_exists($exportfile))
	{
		echo "<p>" . MSG_EXPORT_DELETE_OLD . "\n";
		unlink($exportfile);
	}
	if (!$exportfile)
	{
 		echo "<p class=\"error\">" . ERROR_EXPORT_FILE_OPEN . "\n";
		cs_AddFooter();
		exit();
	}
	while ($main_data = mysql_fetch_object($exec_main))
	{
		fputs($exportfile,"$main_data->id;$main_data->name;$main_data->dish;$main_data->mainingredient;$main_data->people;$main_data->origin;$main_data->ingredients;$main_data->description;$main_data->kind;$main_data->season;$main_data->time;$main_data->difficulty;$main_data->notes;$main_data->wines\r\n");
	}
	fclose($exportfile);
	echo "<p>" . MSG_EXPORT_FILE_DONE . " <a href=\"export/CrisoftRicette.csv\" target=\"_blank\">export/CrisoftRicette.csv</a>\n";
}
if ($_POST['mode'] == "single")
{
	echo "<p>" . MSG_EXPORT_CSV_EXPORTING_SINGLE . "...\n";
	$sql_main = "SELECT * FROM main WHERE id = '{$_SESSION['recipe_id']}'";
	if (!$exec_main = mysql_query($sql_main))
	{
		echo "<p class=\"error\">" . ERROR_RETRIEVE_MAIN_TABLE . "<br>\n". mysql_error();
		cs_AddFooter();
		exit();
	}
	$exported_filename = $_SESSION['recipe_id'];
	$basedir = dirname(__FILE__);
	$basedir = str_replace("/plugins/$export_type", "", $basedir);
	$exportfile = fopen("$basedir/export/CR_$exported_filename.csv", "w");
	if (file_exists($exportfile))
	{
		echo "<p>" . MSG_EXPORT_DELETE_OLD . "\n";
		unlink($exportfile);
	}
	if (!$exportfile)
	{
 		echo "<p class=\"error\">" . ERROR_EXPORT_FILE_OPEN . "\n";
		cs_AddFooter();
		exit();
	}
	while ($main_data = mysql_fetch_object($exec_main))
	{
		fputs($exportfile,"$main_data->id;$main_data->name;$main_data->dish;$main_data->mainingredient;$main_data->people;$main_data->origin;$main_data->ingredients;$main_data->description;$main_data->kind;$main_data->season;$main_data->time;$main_data->difficulty;$main_data->notes;$main_data->wines\r\n");
	}
	fclose($exportfile);
	echo "<p>" . MSG_EXPORT_FILE_SINGLE . " <a href=\"export/CR_$exported_filename.csv\" target=\"_blank\">export/CR_$exported_filename.csv</a>\n";
}
?>
