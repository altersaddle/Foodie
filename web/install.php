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
			//Admin table
			$sql_table_admin = "CREATE TABLE admin (user varchar(50) NOT NULL default '', password varchar(50) NOT NULL default '') ENGINE=MyISAM";
			if (!$exec_table_admin = $dbconnect->query($sql_table_admin))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " admin<br>\n" . $dbconnect->error;
				exit();
			}
			//Cooking type table
			$sql_table_cooking = "CREATE TABLE cooking (id int(3) unsigned NOT NULL auto_increment, type varchar(255) NOT NULL default '', PRIMARY KEY  (id)) ENGINE=MyISAM";
  			if (!$exec_table_cooking = $dbconnect->query($sql_table_cooking))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " cooking<br>\n" . $exec_table_cooking->error();
				exit();
			}
			//Difficulty grade table
  			$sql_table_difficulty = "CREATE TABLE difficulty (id int(1) unsigned NOT NULL auto_increment, difficulty int(1) NOT NULL default '0', PRIMARY KEY  (id)) ENGINE=MyISAM";
			if (!$exec_table_difficulty = $dbconnect->query($sql_table_difficulty))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " difficulty<br>\n" . $exec_table_difficulty->error();
				exit();
			}
			//Dish (Serving) table
			$sql_table_dish = "CREATE TABLE dish (id int(3) unsigned NOT NULL auto_increment, dish varchar(255) NOT NULL default '', PRIMARY KEY  (id)) ENGINE=MyISAM";
			if (!$exec_table_dish = $dbconnect->query($sql_table_dish))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " dish<br>\n" . $exec_table_dish->error();
				exit();
			}
			//Main table
			$sql_table_main = "CREATE TABLE main (id int(8) unsigned NOT NULL auto_increment, name varchar(255) NOT NULL default '', dish varchar(255) NOT NULL default '', mainingredient varchar(255) NOT NULL default '', people varchar(4) NOT NULL default '', origin varchar(255) NOT NULL default '', ingredients text NOT NULL, description text NOT NULL, kind varchar(255) NOT NULL default '', season varchar(255) NOT NULL default '', time varchar(255) NOT NULL default '', difficulty varchar(255) NOT NULL default '', notes text NOT NULL, image varchar(255) NOT NULL default '', video varchar(255) NOT NULL default '', wines varchar(255) NOT NULL default '', PRIMARY KEY  (id), KEY id (id)) ENGINE=MyISAM";
			if (!$exec_table_main = $dbconnect->query($sql_table_main))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " main<br>\n" . $exec_table_main->error();
				exit();
			}
			//Personal cookbook table
			$sql_table_cookbook = "CREATE TABLE personal_book (id int(8) unsigned NOT NULL default 0, recipe_name varchar(255) NOT NULL default '', KEY id (id)) ENGINE=MyISAM";
			if (!$exec_table_cookbook = $dbconnect->query($sql_table_cookbook))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " cookbook<br>\n" . $exec_table_cookbook->error();
				exit();
			}
			//Rating table
			$sql_table_rating = "CREATE TABLE rating (id int(8) unsigned NOT NULL default 0, vote smallint(1) NOT NULL default '0', KEY id (id)) ENGINE=MyISAM";
			if (!$exec_table_rating = $dbconnect->query($sql_table_rating))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " rating<br>\n" . $exec_table_rating->error();
				exit();
			}
			//Shopping list table
			$sql_table_shopping = "CREATE TABLE shopping (id int(8) unsigned NOT NULL auto_increment, recipe varchar(255) NOT NULL default '0', ingredients text NOT NULL, PRIMARY KEY (id)) ENGINE=MyISAM";
			if (!$exec_table_shopping = $dbconnect->query($sql_table_shopping))
			{
				foodie_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " shopping<br>\n" . $exec_table_shopping->error();
				exit();
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
			//If table admin and difficulty exist check if they have values into them
			//compare submitted username and password with already existing ones
			//and terminate with error if not equal
			$sql_check_table_admin = "DESCRIBE admin";
			if ($exec_check_table_admin = $dbconnect->query($sql_check_table_admin))
			{
				$sql_check_admin = "SELECT * FROM admin";
				if (!$exec_check_admin = $dbconnect->query($sql_check_admin))
				{
					foodie_AddHeader();
					echo "<p class=\"error\">" . ERROR_INSTALL_USERPASS ."<br>\n" . $exec_check_admin->error();
					exit();
				}
				//Check number of records into admin table
				$rows_admin = $exec_check_admin->num_rows;
				//if 1 compare them with submitted ones
				if ($rows_admin == 1)
				{
					while ($row = $exec_check_admin->fetch_row)
					{
						if ($row[0] != $_POST['sw_admin_user'] OR $row[1] != $_POST['sw_admin_password'])
						{
							foodie_AddHeader();
							echo "<p class=\"error\">" . ERROR_INSTALL_NOMATCH . "\n";
							echo "<p><a href=\"{$_SERVER['HTTP_REFERER']}\">" . MSG_BACK . "</a>\n";
							exit();
						}
					}
				}
				//if 0 insert submitted ones
				if ($rows_admin == 0)
				{
					$sql_table_admin_data = "INSERT INTO admin (user, password) VALUES ('{$_POST['sw_admin_user']}', '{$_POST['sw_admin_password']}')";
					if (!$exec_table_admin_data = $dbconnect->query($sql_table_admin_data))
					{
						foodie_AddHeader();
						echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
						echo "<p class=\"error\">" . ERROR_INSTALL_ADMIN . "<br>\n" . $exec_table_admin_data->error();
						exit();
					}
				}
				//if more than 1 zap them and insert submitted ones
				if ($rows_admin >= 2)
				{
					$sql_zap_admin = "DELETE FROM admin";
					if (!$exec_zap_admin = $dbconnect->query($sql_zap_admin))
					{
						foodie_AddHeader();
						echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
						echo "<p class=\"error\">" . ERROR_INSTALL_MANAGE . "<br>" . MSG_INSTALL_FULL . "<br>\n" . $exec_zap_admin->error();
						exit();
					}
					$sql_table_admin_data = "INSERT INTO admin (user, password) VALUES ('{$_POST['sw_admin_user']}', '{$_POST['sw_admin_password']}')";
					if (!$exec_table_admin_data = $dbconnect->query($sql_table_admin_data))
					{
						foodie_AddHeader();
						echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
						echo "<p class=\"error\">" . ERROR_INSTALL_ADMIN . "<br>\n" . $exec_table_admin_data->error();
						exit();
					}
				}
			}
			//For difficulty grade check number of records, if == 0 add defaults.
			$sql_check_table_difficulty = "DESCRIBE difficulty";
			if ($exec_check_table_difficulty = $dbconnect->query($sql_check_table_difficulty))
			{
				$sql_check_difficulty = "SELECT * FROM difficulty";
				if (!$exec_check_difficulty = $dbconnect->query($sql_check_difficulty))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_CHECK . " difficulty<br>\n" . $exec_check_difficulty->error();
					exit();
				}
				//Check number of records into admin table
				$rows_difficulty = $exec_check_difficulty->num_rows;
				//if 0 insert default values
				if ($rows_difficulty == 0)
				{
					$sql_table_difficulty_data = "INSERT INTO difficulty (id, difficulty) VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 5)";
					if (!$exec_table_difficulty_data = $dbconnect->query($sql_table_difficulty_data))
					{
						foodie_AddHeader();
						echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
						echo "<p class=\"error\">" . ERROR_INSTALL_DEFAULT . " difficulty<br>\n" . $exec_table_difficulty_data->error();
						exit();
					}
				}
			}
			
			//Check if tables exist and operate only if not
			$sql_check_table_admin = "DESCRIBE admin";
			if (!$exec_check_table_admin = $dbconnect->query($sql_check_table_admin))
			{
				//Admin table
				$sql_table_admin = "CREATE TABLE admin (user varchar(50) NOT NULL default '', password varchar(50) NOT NULL default '') ENGINE=MyISAM";
				if (!$exec_table_admin = $dbconnect->query($sql_table_admin))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " admin<br>\n" . $exec_table_admin->error();
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
			}
			$sql_check_table_cooking = "DESCRIBE cooking";
			if (!$exec_check_table_cooking = $dbconnect->query($sql_check_table_cooking))
			{
				//Cooking type table
				$sql_table_cooking = "CREATE TABLE cooking (id int(3) unsigned NOT NULL auto_increment, type varchar(255) NOT NULL default '', PRIMARY KEY  (id)) ENGINE=MyISAM";
				if (!$exec_table_cooking = $dbconnect->query($sql_table_cooking))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " cooking<br>\n" . $exec_table_cooking->error();
					exit();
				}
			}
			$sql_check_table_difficulty = "DESCRIBE difficulty";
			if (!$exec_check_table_difficulty = $dbconnect->query($sql_check_table_difficulty))
			{
				//Difficulty grade table
				$sql_table_difficulty = "CREATE TABLE difficulty (id int(1) unsigned NOT NULL auto_increment, difficulty int(1) NOT NULL default '0', PRIMARY KEY  (id)) ENGINE=MyISAM";
				if (!$exec_table_difficulty = $dbconnect->query($sql_table_difficulty))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " difficulty<br>\n" . $exec_table_difficulty->error();
					exit();
				}
				//Add default values
				$sql_table_difficulty_data = "INSERT INTO difficulty (id, difficulty) VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 5)";
				if (!$exec_table_difficulty_data = $dbconnect->query($sql_table_difficulty_data))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_DEFAULT . " difficulty<br>\n" . $exec_table_difficulty_data->error();
					exit();
				}
			}
			$sql_check_table_dish = "DESCRIBE dish";
			if (!$exec_check_table_dish = $dbconnect->query($sql_check_table_dish))
			{
				//Dish (Serving) table
				$sql_table_dish = "CREATE TABLE dish (id int(3) unsigned NOT NULL auto_increment, dish varchar(255) NOT NULL default '', PRIMARY KEY  (id)) ENGINE=MyISAM";
				if (!$exec_table_dish = $dbconnect->query($sql_table_dish))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " dish<br>\n" . $exec_table_dish->error();
					exit();
				}
			}
			$sql_check_table_main = "DESCRIBE main";
			if (!$exec_check_table_main = $dbconnect->query($sql_check_table_main))
			{
				//Main table
				$sql_table_main = "CREATE TABLE main (id int(8) unsigned NOT NULL auto_increment, name varchar(255) NOT NULL default '', dish varchar(255) NOT NULL default '', mainingredient varchar(255) NOT NULL default '', people varchar(4) NOT NULL default '', origin varchar(255) NOT NULL default '', ingredients text NOT NULL, description text NOT NULL, kind varchar(255) NOT NULL default '', season varchar(255) NOT NULL default '', time varchar(255) NOT NULL default '', difficulty varchar(255) NOT NULL default '', notes text NOT NULL, image varchar(255) NOT NULL default '', video varchar(255) NOT NULL default '', wines varchar(255) NOT NULL default '', PRIMARY KEY  (id), KEY id (id)) ENGINE=MyISAM";
				if (!$exec_table_dish = $dbconnect->query($sql_table_main))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " main<br>\n" . $exec_table_dish->error();
					exit();
				}
			}
			$sql_check_table_cookbook = "DESCRIBE personal_book";
			if (!$exec_check_table_cookbook = $dbconnect->query($sql_check_table_cookbook))
			{
				//Personal cookbook table
				$sql_table_cookbook = "CREATE TABLE personal_book (id int(8) unsigned NOT NULL default 0, recipe_name varchar(255) NOT NULL default '', KEY id (id)) ENGINE=MyISAM";
				if (!$exec_table_cookbook = $dbconnect->query($sql_table_cookbook))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " cookbook<br>\n" . $exec_table_cookbook->error();
					exit();
				}
			}
			$sql_check_table_rating = "DESCRIBE rating";
			if (!$exec_check_table_rating = $dbconnect->query($sql_check_table_rating))
			{
				//Rating table
				$sql_table_rating = "CREATE TABLE rating (id int(8) unsigned NOT NULL default 0, vote smallint(1) NOT NULL default '0', KEY id (id)) ENGINE=MyISAM";
				if (!$exec_table_rating = $dbconnect->query($sql_table_rating))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " rating<br>\n" . $exec_table_rating->error();
					exit();
				}
			}
			$sql_check_table_shopping = "DESCRIBE shopping";
			if (!$exec_check_table_shopping = $dbconnect->query($sql_check_table_shopping))
			{
				//Shopping list table
				$sql_table_shopping = "CREATE TABLE shopping (id int(8) unsigned NOT NULL auto_increment, recipe varchar(255) NOT NULL default '0', ingredients text NOT NULL, PRIMARY KEY  (id)) ENGINE=MyISAM";
				if (!$exec_table_shopping = $dbconnect->query($sql_table_shopping))
				{
					foodie_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " shopping<br>\n" . $exec_table_shopping->error();
					exit();
				}
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

