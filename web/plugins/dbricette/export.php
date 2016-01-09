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
// Export plugin for dbricette.it Bekon Idealist Natural file format
if ($_POST['mode'] == "all")
//Export entire main table
{
	echo "<p>" . MSG_EXPORT_DBR_EXPORTING_MAIN . "...\n";
	$sql_main = "SELECT * FROM main";
	if (!$exec_main = mysql_query($sql_main))
	{
		echo "<p class=\"error\">" . ERROR_RETRIEVE_MAIN_TABLE . "<br>\n". mysql_error();
		cs_AddFooter();
		exit();
	}
	$basedir = dirname(__FILE__);
	$basedir = str_replace("/plugins/$export_type", "", $basedir);
	$exportfile = fopen("$basedir/export/CR_dbricette.txt", "w");
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
		fputs($exportfile,":Ricette\r\n");
		fputs($exportfile,"-Nome\r\n");
		fputs($exportfile,"$main_data->name\r\n");
		fputs($exportfile,"-Tipo_Piatto\r\n");
		fputs($exportfile,"$main_data->dish\r\n");
		fputs($exportfile,"-Ing_Principale\r\n");
		fputs($exportfile,"$main_data->mainingredient\r\n");
		fputs($exportfile,"-Persone\r\n");
		fputs($exportfile,"$main_data->people\r\n");
		fputs($exportfile,"-Note\r\n");
		fputs($exportfile,"$main_data->notes\r\n");
		fputs($exportfile,"-Ingredienti\r\n");
		fputs($exportfile,"$main_data->ingredients\r\n");
		fputs($exportfile,"-Preparazione\r\n");
		fputs($exportfile,"$main_data->description\r\n");
	}	
	fclose($exportfile);
	echo "<p>" . MSG_EXPORT_FILE_DONE . " <a href=\"export/CR_dbricette.txt\" target=\"_blank\">export/CR_dbricette.txt</a>\n";
}
if ($_POST['mode'] == "single")
//Export single recipe
{
	echo "<p>" . MSG_EXPORT_DBR_EXPORTING_SINGLE . "...\n";
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
	$exportfile = fopen("$basedir/export/CR_dbr_$exported_filename.txt", "w");
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
		fputs($exportfile,":Ricette\r\n");
		fputs($exportfile,"-Nome\r\n");
		fputs($exportfile,"$main_data->name\r\n");
		fputs($exportfile,"-Tipo_Piatto\r\n");
		fputs($exportfile,"$main_data->dish\r\n");
		fputs($exportfile,"-Ing_Principale\r\n");
		fputs($exportfile,"$main_data->mainingredient\r\n");
		fputs($exportfile,"-Persone\r\n");
		fputs($exportfile,"$main_data->people\r\n");
		fputs($exportfile,"-Note\r\n");
		fputs($exportfile,"$main_data->notes\r\n");
		fputs($exportfile,"-Ingredienti\r\n");
		fputs($exportfile,"$main_data->ingredients\r\n");
		fputs($exportfile,"-Preparazione\r\n");
		fputs($exportfile,"$main_data->description\r\n");
	}	
	fclose($exportfile);
	echo "<p>" . MSG_EXPORT_FILE_SINGLE . " <a href=\"export/CR_dbr_$exported_filename.txt\" target=\"_blank\">export/CR_dbr_$exported_filename.txt</a>\n";
}

?>
	
