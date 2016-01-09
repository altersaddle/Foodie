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
// Export plugin for MealMaster for DOS file format
if ($_POST['mode'] == "all")
//Export entire main table
{
	echo "<p>" . MSG_EXPORT_MM_EXPORTING_MAIN . "...\n";
	$sql_main = "SELECT * FROM main";
	if (!$exec_main = mysql_query($sql_main))
	{
		echo "<p class=\"error\">" . ERROR_RETRIEVE_MAIN_TABLE . "<br>\n". mysql_error();
		cs_AddFooter();
		exit();
	}
	$basedir = dirname(__FILE__);
	$basedir = str_replace("/plugins/$export_type", "", $basedir);
	$exportfile = fopen("$basedir/export/CR_mmast.txt", "w");
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
		fputs($exportfile,"---------- Recipe via Meal-Master (tm) v8.01\r\n\r\n");
		fputs($exportfile,"      Title: $main_data->name\r\n");
		fputs($exportfile," Categories: $main_data->dish\r\n");
		fputs($exportfile,"      Yield: $main_data->people\r\n\r\n");
		$mm_ingredients = wordwrap($main_data->ingredients, 70);
		$mm_ingredients = str_replace("\n", " ", $mm_ingredients);
		$mm_ingredients = str_replace("\r", " ", $mm_ingredients);
		fputs($exportfile,"      $mm_ingredients\r\n \r\n");
		$mm_description = wordwrap($main_data->description, 74);
		$mm_description = str_replace("\n", " ", $mm_description);
		$mm_description = str_replace("\r", " ", $mm_description);
		fputs($exportfile,"  $mm_description\r\n\r\n");
		fputs($exportfile,"-----\r\n\r\n");
	}	
	fclose($exportfile);
	echo "<p>" . MSG_EXPORT_FILE_DONE . " <a href=\"export/CR_mmast.txt\" target=\"_blank\">export/CR_mmast.txt</a>\n";
}
if ($_POST['mode'] == "single")
//Export single recipe
{
	echo "<p>" . MSG_EXPORT_MM_EXPORTING_SINGLE . "...\n";
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
	$exportfile = fopen("$basedir/export/CR_mm_$exported_filename.txt", "w");
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
		fputs($exportfile,"---------- Recipe via Meal-Master (tm) v8.01\r\n\r\n");
		fputs($exportfile,"      Title: $main_data->name\r\n");
		fputs($exportfile," Categories: $main_data->dish\r\n");
		fputs($exportfile,"      Yield: $main_data->people\r\n\r\n");
		$mm_ingredients = wordwrap($main_data->ingredients, 70);
		$mm_ingredients = str_replace("\n", " ", $mm_ingredients);
		$mm_ingredients = str_replace("\r", " ", $mm_ingredients);
		fputs($exportfile,"      $mm_ingredients\r\n\r\n");
		$mm_description = wordwrap($main_data->description, 74);
		$mm_description = str_replace("\n", " ", $mm_description);
		$mm_description = str_replace("\r", " ", $mm_description);
		fputs($exportfile,"  $mm_description\r\n\r\n");
		fputs($exportfile,"-----\r\n\r\n");
	}	
	fclose($exportfile);
	echo "<p>" . MSG_EXPORT_FILE_SINGLE . " <a href=\"export/CR_mm_$exported_filename.txt\" target=\"_blank\">export/CR_mm_$exported_filename.txt</a>\n";
}
?>
