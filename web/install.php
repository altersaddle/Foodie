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
//define arrays for page sizes and locale
$page_size_array = array ('A4', 'legal', 'letter'); 
//If install key does not exist in $_POST print a configuration form
require(dirname(__FILE__)."/config/foodie.ini.php");
require(dirname(__FILE__)."/foodielib.php");

if (!array_key_exists("installation", $_POST))
{
    foodie_AddHeader();
    //Check locale setting for tampered input
	$lang_avail_dir = opendir(dirname(__FILE__)."/lang");
	while (($lang_avail_item = readdir($lang_avail_dir)) !== false) 
	{ 
		if ($lang_avail_item == "." OR $lang_avail_item == "..") continue;
		//Strip away dot and php extension
		$locales_array[] = str_replace(".php", "", $lang_avail_item);
	}  
	closedir($lang_avail_dir);
	if (!in_array($setting_locale, $locales_array))
	{	
		echo "<h2>Installation failure</h2>";
	    echo "<p class=\"error\">{$setting_locale} as locale configuration keyword not valid!\n";
	    echo "<p>Please use ONLY one of following locales:<br>\n";
      	foreach ($locales_array as $available_locale)
		{
			echo "$available_locale \n";
		}
		echo "<p><a href=\"language.php\">Restart installation</a>\n";
		exit();
	}
	require(dirname(__FILE__)."/lang/".$setting_locale.".php");

    // Connect to db, see if we already have one or more admins

	echo "<h2>" . MSG_INSTALL_TITLE . "</h2>\n";
	$installpath = dirname(__FILE__);
	echo "<p>" . MSG_INSTALL_FORM . "\n";
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n
	<br><h3>" . MSG_INSTALL_ADMIN . "</h3>\n
	<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_USER . ":</td>
	<td><input type=\"text\" size=\"20\" name=\"sw_admin_user\" value=\"admin\"></td>
	<td><p>" . MSG_ADMIN_PASS . ":</td>
	<td><input type=\"password\" size=\"20\" name=\"sw_admin_password\" value=\"admin\"></td></tr></table>\n
	<input type=\"hidden\" name=\"installation\" value=\"ok\">\n
	<div align=center><input type=\"submit\" value=\"" . BTN_INSTALL . "\"></div></form>\n";
	exit();
} 
else {
	if ($_POST['installation'] == "ok")
	{
		require_once(dirname(__FILE__)."/lang/".$setting_locale.".php");
		//Check username and password for admin 
		if ($_POST['sw_admin_user'] == $_POST['sw_admin_password'])
		{
			foodie_AddHeader();
			echo "<p class=\"error\">" . ERROR_INSTALL_IDENTICAL . "!\n";
			cs_PrintInstallationForm();
		}
		
		require(dirname(__FILE__)."/includes/dbconnect.inc.php");
        require(dirname(__FILE__)."/includes/dbcommands.inc.php");
		if (!$dbconnect) 
		{
			foodie_AddHeader();
			echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
			echo "<p class=\"error\">" . ERROR_INSTALL_CONNECTION . "!</strong><br>\n" . $dbconnect->error;
			echo "<p><a href=\"{$_SERVER['HTTP_REFERER']}\">" . MSG_BACK . "</a>\n";
			exit();
		}
		
			//Select the database to create tables or check for them
			//Since database was just created we have to select it before starting to create tables
			if (!$db_control=$dbconnect->select_db($db_name)) 
			{
				foodie_AddHeader();
				echo "<p>" . ERROR_INSTALL_SELECT . "!<br>\n" . $db_control->error();
				exit();
			}
			/*
			 *  Create tables
			 */
            foreach(array_keys($dbcreatecommands) as $tablename) { 
			//Create table
			    if (!$exec_table_create = $dbconnect->query($dbcreatecommands[$tablename]))
			    {
				    foodie_AddHeader();
				    echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				    echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " $tablename<br>\n" . $dbconnect->error;
				    exit();
			    }
            }
			/*
			 *  Add default values
			 */
			//Admin username and password
			$sql_table_admin_data = "INSERT INTO admin (user, password) VALUES ('{$_POST['sw_admin_user']}', '{$_POST['sw_admin_password']}')";
			if (!$exec_table_admin_data = $dbconnect->query($sql_table_admin_data))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_DATA . " admin<br>\n" . $exec_table_admin_data->error();
				exit();
			}
			//Difficulty grades
			$sql_table_difficulty_data = "INSERT INTO difficulty (id, difficulty) VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 5)";
			if (!$exec_table_difficulty_data = $dbconnect->query($sql_table_difficulty_data))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_DATA . " difficulty <br>\n" . $exec_table_difficulty_data->error();
				exit();
			}

			//For difficulty grade check number of records, if == 0 add defaults.
			$sql_table_difficulty_data = "INSERT INTO difficulty (id, difficulty) VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 5)";
			if (!$exec_table_difficulty_data = $dbconnect->query($sql_table_difficulty_data))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_DEFAULT . " difficulty<br>\n" . $exec_table_difficulty_data->error();
				exit();
			}

			//Add admin username and password
			$sql_table_admin_data = "INSERT INTO admin (user, password) VALUES ('{$_POST['sw_admin_user']}', '{$_POST['sw_admin_password']}')";
			if (!$exec_table_admin_data = $dbconnect->query($sql_table_admin_data))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_ADMIN . "<br>\n" . $exec_table_admin_data->error();
				exit();
			}

			//Add default difficulty values
			$sql_table_difficulty_data = "INSERT INTO difficulty (id, difficulty) VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 5)";
			if (!$exec_table_difficulty_data = $dbconnect->query($sql_table_difficulty_data))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_DEFAULT . " difficulty<br>\n" . $exec_table_difficulty_data->error();
				exit();
			}
		}
        else {
		    foodie_AddHeader();
		    require_once(dirname(__FILE__)."/lang/".$setting_locale.".php");
		    echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>\n
		    <p>" . ERROR_UNEXPECTED . "\n";
		    exit();
        }
        // If we got this far, redirect to the index
		header("Location: index.php");
	} 
?>

