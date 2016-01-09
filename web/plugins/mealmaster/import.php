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
// Import plugin for MealMaster file format
echo "<p>" . MSG_IMPORT_MM_MAIN . "\n";
if (!$_FILES['import_file']['name'])
{
	echo "<p class=\"error\">" . ERROR_IMPORT_NOFILE . "!\n";
	cs_AddFooter();
	exit();
}
//File size check: if 8millions of bytes abort with error since PHP
//accept by default a maximum file size of 8MB
if ($_FILES['import_file']['size'] > 8000000)
{
	echo "<p class=\"error\">" . ERROR_IMPORT_FILESIZE_EXCEEDED . "\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//Check input file name
if (eregi("[@!|#§+*<>^?£$%&\/\\]", $_FILES['import_file']['name'])) 
{
	echo "<p class=\"error\">" . ERROR_IMPORT_FILENAME_INVALID . "!\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//Copy the file into tmp/
$imported_file = $_FILES['import_file']['name'];
$temp_file = $_FILES['import_file']['tmp_name'];
$upload_path = dirname(__FILE__)."/temp/";
$upload_path = str_replace("/plugins/$import_type", "", $upload_path);
if (!$upload_error = copy($temp_file, $upload_path.$imported_file))
{
	echo "<p class=\"error\">" . ERROR_IMPORT_FILE_NOTFOUND . "\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
/*
Check if file is readable
*/
$read_filename = $upload_path . $imported_file;
if(!$workfile = fopen("$read_filename", "r"))
{
	echo "<p class=\"error\">" . ERROR_IMPORT_FILE_UNREADABLE . "\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
fclose($workfile);
//Read the file counting how many :Ricette recurrences are into it
$count_recipes = fopen("$read_filename", "r");
$count = 0;
while (!feof ($count_recipes)) {
	$newbuffer = fgets($count_recipes, 4096);
	if ($newbuffer = strstr($newbuffer, "---------- Recipe via Meal-Master"))
	{
		$count++;
	}
}
if ($count == 0)
{
	echo "<p class=\"error\">" . ERROR_IMPORT_FILE_NORECIPES . "!\n";
	unlink($read_filename);
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
echo "<p>" . MSG_IMPORT_COUNT_RECIPES . " $count\n";
fclose ($count_recipes);
/*
If only one recipe is into the file process it
*/
if ($count == 1)
{
	$elements = implode("", file($read_filename));
	$elements = str_replace("---------- Recipe via Meal-Master (tm) ", "", $elements);
	//Strip away MM version number
	$elements = ereg_replace("v[0-9]\.[0-9]*", "", $elements);
	$elements = str_replace("      Title: ", "", $elements);
	$elements = str_replace(" Categories: ", "|", $elements);
	$elements = str_replace("      Yield: ", "|", $elements);
	$elements = str_replace(" servings\r\n", "|", $elements);
	$elements = str_replace("\r\n \r\n", "|", $elements);
	$elements = str_replace("-----", "", $elements);
	$elements = str_replace("\r", "", $elements);
	$elements = str_replace("\n", "", $elements);
	$elements = explode("|", $elements);
	$name = addslashes($elements[1]);
	$dish = addslashes($elements[2]);
	$ingredients = addslashes($elements[4]);
	$description = addslashes($elements[5]);
	$sql_import = "INSERT INTO main (id, name, dish, people, ingredients, description) VALUES ('', '$name', '$dish', '$elements[3]', '$ingredients', '$description')";
	if (!$exec_import = mysql_query($sql_import))
	{
		echo "<p class=\"error\">" . ERROR_IMPORT_FAILED . "<br>\n" . mysql_query();
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	echo "<p>$elements[1] " . MSG_IMPORT_RECIPE_SUCCESS . ".\n";
}
//If more than one recipe
if ($count >= 2)
{
	$elements = implode("", file($read_filename));
	$elements = str_replace("---------- Recipe via Meal-Master (tm) ", "", $elements);
	//Strip away MM version number
	$elements = ereg_replace("v[0-9]\.[0-9]*", "", $elements);
	$elements = str_replace(" Categories: ", "|", $elements);
	$elements = str_replace("      Yield: ", "|", $elements);
	$elements = str_replace(" servings\r\n", "|", $elements);
	$elements = str_replace("\r\n \r\n", "|", $elements);
	$elements = str_replace("-----", "", $elements);
	$elements = str_replace("\r", "", $elements);
	$elements = str_replace("\n", "", $elements);
	$elements = str_replace("      Title: ", "\r\n", $elements);
	//Write data to a temporary file
	$write_tempfile = fopen("temp/import.tmp", "w");
	fputs($write_tempfile, $elements);
	fputs($write_tempfile, "\r\n");
	fclose($write_tempfile);
	//read data from temporary file
	$read_tempfile = fopen("temp/import.tmp", "r");
	while (!feof ($read_tempfile)) {
		$read_buffer = fgets($read_tempfile);
		$read_buffer = str_replace("\r\n", "", $read_buffer);
		if (!empty($read_buffer))
		{
			$elements = explode("|", $read_buffer);
			if (!empty($elements[0]))
			{	
				$name = addslashes($elements[0]);
				$dish = addslashes($elements[1]);
				$ingredients = addslashes($elements[3]);
				$description = addslashes($elements[4]);
				$sql_import = "INSERT INTO main (id, name, dish, people, ingredients, description) VALUES ('', '$name', '$dish', '$elements[2]', '$ingredients', '$description')";
				if (!$exec_import = mysql_query($sql_import))
				{
					echo "<p class=\"error\">" . ERROR_IMPORT_FAILED . "<br>\n" . mysql_query();
					fclose($read_tempfile);
					//At the very end unlink temporary file
					unlink("temp/import.tmp");
					cs_AdminFastLogout();
					cs_AddFooter();
					exit();
				}
				echo "<p>$elements[0] " . MSG_IMPORT_RECIPE_SUCCESS ".\n";
				}
		}
	}
	fclose($read_tempfile);
	//At the very end unlink temporary file
	//unlink("temp/import.tmp");
}
unlink($read_filename);
?>
	
