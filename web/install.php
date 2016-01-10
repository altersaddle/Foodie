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
require(dirname(__FILE__)."/crisoftlib.php");
//define arrays for page sizes and locale
$page_size_array = array ('A4', 'legal', 'letter'); 
//If install key does not exist in $_POST print a configuration form
if (!array_key_exists("installation", $_POST))
{
cs_AddHeader();
//Check locale setting for tampered input
	$lang_avail_dir = opendir(dirname(__FILE__)."/lang");
	while (($lang_avail_item = readdir($lang_avail_dir)) !== false) 
	{ 
		if ($lang_avail_item == "." OR $lang_avail_item == "..") continue;
		//Strip away dot and php extension
		$locales_array[] = str_replace(".php", "", $lang_avail_item);
	}  
	closedir($lang_avail_dir);
	if (!in_array("{$_POST['sw_locale']}", $locales_array))
	{	
		echo "<h2>Installation failure</h2>";
	    echo "<p class=\"error\">{$_POST['sw_locale']} as locale configuration keyword not valid!\n";
	    echo "<p>Please use ONLY one of following locales:<br>\n";
      	//Displays content of array $image_type
	    foreach ($locales_array as $available_locale)
		{
			echo "$available_locale \n";
		}
		echo "<p><a href=\"language.php\">Restart installation</a>\n";
		exit();
	}
	require(dirname(__FILE__)."/lang/".$_POST['sw_locale'].".php");
	if (!isset($_POST['crisoft_install']))
	{
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "</p>\n";
		exit();
	}
	if ($_POST['crisoft_install'] != "Install")
	{
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "</p>\n";
		exit();
	}
	echo "<h2>" . MSG_INSTALL_TITLE . "</h2>\n";
	$installpath = dirname(__FILE__);
	echo "<p>" . MSG_INSTALL_FORM . "\n";
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n
	<h3>" . MSG_INSTALL_SERVER . "</h3>\n<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_CFG_HOSTNAME . ":\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_hostname\" value=\"localhost\"></td>\n
	<td><p>" . MSG_ADMIN_CFG_PORT . ":\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_port\" value=\"3306\"></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_CFG_USER . "\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_username\" value=\"MYSQL_USERNAME\"></td>\n
	<td><p>" . MSG_ADMIN_CFG_PASS . "\n</td><td><input type=\"password\" size=\"30\" name=\"db_password\" value=\"PASSWORD\"></td></tr>
	<tr><td><p>" . MSG_ADMIN_CFG_DBNAME . "\n</td>
	<td><input type=\"text\" size=\"30\" name=\"db_name\" value=\"ricette\"></td>
	<td colspan=\"2\">&nbsp;</td></tr>\n</table>\n
	<h3>" . MSG_INSTALL_APPLICATION . "</h3>\n
	<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_CFG_LINES . ":\n</td>
	<td><input type=\"text\" size=\"3\" name=\"sw_lines_per_page\" value=\"25\"></td>\n
	<td><p>" . MSG_ADMIN_CFG_PAGESIZE . ":\n</td><td><select name=\"sw_page_size\">\n";
	foreach ($page_size_array as $available_size)
	{
		echo "<option value=\"$available_size\">$available_size</option>\n";
	}
	echo "</select></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_CFG_EMAIL . ":\n</td>
	<td colspan=\"3\"><input type=\"text\" size=\"50\" name=\"sw_email_address\" value=\"YOUR_EMAIL_ADDRESS_HERE\">
	</td></tr></table>\n
	<br><h3>" . MSG_INSTALL_ADMIN . "</h3>\n
	<table width=\"100%\">
	<tr><td><p>" . MSG_ADMIN_USER . ":</td>
	<td><input type=\"text\" size=\"20\" name=\"sw_admin_user\" value=\"admin\"></td>
	<td><p>" . MSG_ADMIN_PASS . ":</td>
	<td><input type=\"password\" size=\"20\" name=\"sw_admin_password\" value=\"admin\"></td></tr></table>\n
	<input type=\"hidden\" name=\"installation\" value=\"ok\">\n
	<input type=\"hidden\" name=\"sw_locale\" value=\"{$_POST['sw_locale']}\">
	<div align=center><input type=\"submit\" value=\"" . BTN_INSTALL . "\"></div></form>\n";
	exit();
} 
if (array_key_exists("installation", $_POST))
{
	if ($_POST['installation'] == "ok")
	{
		require_once(dirname(__FILE__)."/lang/".$_POST['sw_locale'].".php");
		//Check some fields for empty values
		cs_CheckEmptyValueInstall($_POST['db_hostname']);
		cs_CheckEmptyValueInstall($_POST['db_port']);
		cs_CheckEmptyValueInstall($_POST['db_name']);
		cs_CheckEmptyValueInstall($_POST['sw_email_address']);
		cs_CheckEmptyValueInstall($_POST['sw_page_size']);
		cs_CheckEmptyValueInstall($_POST['sw_lines_per_page']);
		cs_CheckAdminDefault($_POST['sw_admin_user']);
		cs_CheckAdminDefault($_POST['sw_admin_password']);
		//Check username and password for admin 
		if ($_POST['sw_admin_user'] == $_POST['sw_admin_password'])
		{
			cs_AddHeader();
			echo "<p class=\"error\">" . ERROR_INSTALL_IDENTICAL . "!\n";
			cs_PrintInstallationForm();
		}
		//Check all fields for dangerous input
		foreach($_POST as $danger_field)
		{
			cs_CheckDangerousInputInstall($danger_field);
		}
		
		//Check email field for valid input
		if (!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]+))*$", $_POST['sw_email_address']))
		{
			cs_AddHeader();
			echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
			echo "<p class=\"error\">{$_POST['sw_email_address']} " . ERROR_MAIL_ADDRESS . "\n";
			cs_PrintInstallationForm();
		}
		//Checking TCP/IP port value for numeric value
		if (!is_numeric($_POST['db_port']))
		{	
			cs_AddHeader();
			echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
			echo "<p class=\"error\">" . ERROR_ADMIN_IMP07_PORT . "!\n";
			cs_PrintInstallationForm();
		}
		//Checking lines per page value for numeric value
		if (!is_numeric($_POST['sw_lines_per_page']))
		{	
			cs_AddHeader();
			echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
			echo "<p class=\"error\">" . ERROR_INSTALL_LINES . "!\n";
			cs_PrintInstallationForm();
		}
		//check hostname for a theoretical valid hostname or ip
		//with a regexp that allows only characters, numbers and
		//dots if not localhost
		if ($_POST['db_hostname'] != "localhost")
		{
			if (!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)", $_POST['db_hostname']))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">{$_POST['db_hostname']} " . ERROR_ADMIN_IMP07_HOSTNAME . "\n";
				cs_PrintInstallationForm();
			}
		}
		//Tries to connect to server database with submitted
		//username and password, if it fails displays an error
		//message
		$dbconnect = mysql_connect("{$_POST['db_hostname']}:{$_POST['db_port']}", "{$_POST['db_username']}", "{$_POST['db_password']}");
		if (!$dbconnect) 
		{
			cs_AddHeader();
			echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
			echo "<p class=\"error\">" . ERROR_INSTALL_CONNECTION . "!</strong><br>\n" . mysql_error();
			echo "<p><a href=\"{$_SERVER['HTTP_REFERER']}\">" . MSG_BACK . "</a>\n";
			exit();
		}
		//Check if database exist. If it does not exist create it.
		//Routine assigns a 1 value if database already exists, and 0 if it has been created to $create_db_flag
		if (!$db_control=mysql_select_db("{$_POST['db_name']}")) 
		{
			cs_AddHeader();
	       	$sql_create_database = "CREATE DATABASE {$_POST['db_name']}";
			//Assign a 1 flag to 
			$create_db_flag = 0;
			if (!$exec_create_database = mysql_query($sql_create_database))
			{
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_DATABASE . "<br>\n" . mysql_error();
				exit();				
			}
		} else {
			$create_db_flag = 1;
		}
		//If $create_db_flag is set to 0 then create all tables adding default values and submitted username/password for admin
		if ($create_db_flag == 0)
		{
			//Select the database to create tables or check for them
			//Since database was just created we have to select it before starting to create tables
			if (!$db_control=mysql_select_db("{$_POST['db_name']}")) 
			{
				cs_AddHeader();
				echo "<p>" . ERROR_INSTALL_SELECT . "!<br>\n" . mysql_error();
				exit();
			}
			/*
			 *  Create tables
			 */
			//Admin table
			$sql_table_admin = "CREATE TABLE admin (user varchar(50) NOT NULL default '', password varchar(50) NOT NULL default '') TYPE=MyISAM";
			if (!$exec_table_admin = mysql_query($sql_table_admin))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " admin<br>\n" . mysql_error();
				exit();
			}
			//Cooking type table
			$sql_table_cooking = "CREATE TABLE cooking (id int(3) unsigned zerofill NOT NULL auto_increment, type varchar(255) NOT NULL default '', PRIMARY KEY  (id)) TYPE=MyISAM";
  			if (!$exec_table_cooking = mysql_query($sql_table_cooking))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " cooking<br>\n" . mysql_error();
				exit();
			}
			//Difficulty grade table
  			$sql_table_difficulty = "CREATE TABLE difficulty (id int(1) unsigned zerofill NOT NULL auto_increment, difficulty int(1) NOT NULL default '0', PRIMARY KEY  (id)) TYPE=MyISAM";
			if (!$exec_table_difficulty = mysql_query($sql_table_difficulty))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " difficulty<br>\n" . mysql_error();
				exit();
			}
			//Dish (Serving) table
			$sql_table_dish = "CREATE TABLE dish (id int(3) unsigned zerofill NOT NULL auto_increment, dish varchar(255) NOT NULL default '', PRIMARY KEY  (id)) TYPE=MyISAM";
			if (!$exec_table_dish = mysql_query($sql_table_dish))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " dish<br>\n" . mysql_error();
				exit();
			}
			//Main table
			$sql_table_main = "CREATE TABLE main (id int(8) unsigned zerofill NOT NULL auto_increment, name varchar(255) NOT NULL default '', dish varchar(255) NOT NULL default '', mainingredient varchar(255) NOT NULL default '', people varchar(4) NOT NULL default '', origin varchar(255) NOT NULL default '', ingredients text NOT NULL, description text NOT NULL, kind varchar(255) NOT NULL default '', season varchar(255) NOT NULL default '', time varchar(255) NOT NULL default '', difficulty varchar(255) NOT NULL default '', notes text NOT NULL, image varchar(255) NOT NULL default '', video varchar(255) NOT NULL default '', wines varchar(255) NOT NULL default '', PRIMARY KEY  (id), KEY id (id)) TYPE=MyISAM";
			if (!$exec_table_main = mysql_query($sql_table_main))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " main<br>\n" . mysql_error();
				exit();
			}
			//Personal cookbook table
			$sql_table_cookbook = "CREATE TABLE personal_book (id int(8) unsigned zerofill NOT NULL default '00000000', recipe_name varchar(255) NOT NULL default '', KEY id (id)) TYPE=MyISAM";
			if (!$exec_table_cookbook = mysql_query($sql_table_cookbook))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " cookbook<br>\n" . mysql_error();
				exit();
			}
			//Rating table
			$sql_table_rating = "CREATE TABLE rating (id int(8) unsigned zerofill NOT NULL default '00000000', vote smallint(1) NOT NULL default '0', KEY id (id)) TYPE=MyISAM";
			if (!$exec_table_rating = mysql_query($sql_table_rating))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " rating<br>\n" . mysql_error();
				exit();
			}
			//Shopping list table
			$sql_table_shopping = "CREATE TABLE shopping (id int(8) unsigned zerofill NOT NULL auto_increment, recipe varchar(255) NOT NULL default '0', ingredients text NOT NULL, PRIMARY KEY  (id)) TYPE=MyISAM";
			if (!$exec_table_shopping = mysql_query($sql_table_shopping))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " shopping<br>\n" . mysql_error();
				exit();
			}
			/*
			 *  Add default values
			 */
			//Admin username and password
			$sql_table_admin_data = "INSERT INTO admin (user, password) VALUES ('{$_POST['sw_admin_user']}', '{$_POST['sw_admin_password']}')";
			if (!$exec_table_admin_data = mysql_query($sql_table_admin_data))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_DATA . " admin<br>\n" . mysql_error();
				exit();
			}
			//Difficulty grades
			$sql_table_difficulty_data = "INSERT INTO difficulty (id, difficulty) VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 5)";
			if (!$exec_table_difficulty_data = mysql_query($sql_table_difficulty_data))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
				echo "<p class=\"error\">" . ERROR_INSTALL_DATA . " difficulty <br>\n" . mysql_error();
				exit();
			}
		}
		//If $create_db_flag is set to 1
		//Check if tables exist and create them , filling them with
		//default values
		if ($create_db_flag == 1)
		{
			//If table admin and difficulty exist check if they have values into them
			//compare submitted username and password with already existing ones
			//and terminate with error if not equal
			$sql_check_table_admin = "DESCRIBE admin";
			if ($exec_check_table_admin = mysql_query($sql_check_table_admin))
			{
				$sql_check_admin = "SELECT * FROM admin";
				if (!$exec_check_admin = mysql_query($sql_check_admin))
				{
					cs_AddHeader();
					echo "<p class=\"error\">" . ERROR_INSTALL_USERPASS ."<br>\n" . mysql_error();
					exit();
				}
				//Check number of records into admin table
				$rows_admin = mysql_num_rows($exec_check_admin);
				//if 1 compare them with submitted ones
				if ($rows_admin == 1)
				{
					while ($row = mysql_fetch_row($exec_check_admin))
					{
						if ($row[0] != $_POST['sw_admin_user'] OR $row[1] != $_POST['sw_admin_password'])
						{
							cs_AddHeader();
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
					if (!$exec_table_admin_data = mysql_query($sql_table_admin_data))
					{
						cs_AddHeader();
						echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
						echo "<p class=\"error\">" . ERROR_INSTALL_ADMIN . "<br>\n" . mysql_error();
						exit();
					}
				}
				//if more than 1 zap them and insert submitted ones
				if ($rows_admin >= 2)
				{
					$sql_zap_admin = "DELETE FROM admin";
					if (!$exec_zap_admin = mysql_query($sql_zap_admin))
					{
						cs_AddHeader();
						echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
						echo "<p class=\"error\">" . ERROR_INSTALL_MANAGE . "<br>" . MSG_INSTALL_FULL . "<br>\n" . mysql_error();
						exit();
					}
					$sql_table_admin_data = "INSERT INTO admin (user, password) VALUES ('{$_POST['sw_admin_user']}', '{$_POST['sw_admin_password']}')";
					if (!$exec_table_admin_data = mysql_query($sql_table_admin_data))
					{
						cs_AddHeader();
						echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
						echo "<p class=\"error\">" . ERROR_INSTALL_ADMIN . "<br>\n" . mysql_error();
						exit();
					}
				}
			}
			//For difficulty grade check number of records, if == 0 add defaults.
			$sql_check_table_difficulty = "DESCRIBE difficulty";
			if ($exec_check_table_difficulty = mysql_query($sql_check_table_difficulty))
			{
				$sql_check_difficulty = "SELECT * FROM difficulty";
				if (!$exec_check_difficulty = mysql_query($sql_check_difficulty))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_CHECK . " difficulty<br>\n" . mysql_error();
					exit();
				}
				//Check number of records into admin table
				$rows_difficulty = mysql_num_rows($exec_check_difficulty);
				//if 0 insert default values
				if ($rows_difficulty == 0)
				{
					$sql_table_difficulty_data = "INSERT INTO difficulty (id, difficulty) VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 5)";
					if (!$exec_table_difficulty_data = mysql_query($sql_table_difficulty_data))
					{
						cs_AddHeader();
						echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
						echo "<p class=\"error\">" . ERROR_INSTALL_DEFAULT . " difficulty<br>\n" . mysql_error();
						exit();
					}
				}
			}
			
			//Check if tables exist and operate only if not
			$sql_check_table_admin = "DESCRIBE admin";
			if (!$exec_check_table_admin = mysql_query($sql_check_table_admin))
			{
				//Admin table
				$sql_table_admin = "CREATE TABLE admin (user varchar(50) NOT NULL default '', password varchar(50) NOT NULL default '') TYPE=MyISAM";
				if (!$exec_table_admin = mysql_query($sql_table_admin))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " admin<br>\n" . mysql_error();
					exit();
				}
				//Add admin username and password
				$sql_table_admin_data = "INSERT INTO admin (user, password) VALUES ('{$_POST['sw_admin_user']}', '{$_POST['sw_admin_password']}')";
				if (!$exec_table_admin_data = mysql_query($sql_table_admin_data))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_ADMIN . "<br>\n" . mysql_error();
					exit();
				}
			}
			$sql_check_table_cooking = "DESCRIBE cooking";
			if (!$exec_check_table_cooking = mysql_query($sql_check_table_cooking))
			{
				//Cooking type table
				$sql_table_cooking = "CREATE TABLE cooking (id int(3) unsigned zerofill NOT NULL auto_increment, type varchar(255) NOT NULL default '', PRIMARY KEY  (id)) TYPE=MyISAM";
				if (!$exec_table_cooking = mysql_query($sql_table_cooking))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " cooking<br>\n" . mysql_error();
					exit();
				}
			}
			$sql_check_table_difficulty = "DESCRIBE difficulty";
			if (!$exec_check_table_difficulty = mysql_query($sql_check_table_difficulty))
			{
				//Difficulty grade table
				$sql_table_difficulty = "CREATE TABLE difficulty (id int(1) unsigned zerofill NOT NULL auto_increment, difficulty int(1) NOT NULL default '0', PRIMARY KEY  (id)) TYPE=MyISAM";
				if (!$exec_table_difficulty = mysql_query($sql_table_difficulty))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " difficulty<br>\n" . mysql_error();
					exit();
				}
				//Add default values
				$sql_table_difficulty_data = "INSERT INTO difficulty (id, difficulty) VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 5)";
				if (!$exec_table_difficulty_data = mysql_query($sql_table_difficulty_data))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_DEFAULT . " difficulty<br>\n" . mysql_error();
					exit();
				}
			}
			$sql_check_table_dish = "DESCRIBE dish";
			if (!$exec_check_table_dish = mysql_query($sql_check_table_dish))
			{
				//Dish (Serving) table
				$sql_table_dish = "CREATE TABLE dish (id int(3) unsigned zerofill NOT NULL auto_increment, dish varchar(255) NOT NULL default '', PRIMARY KEY  (id)) TYPE=MyISAM";
				if (!$exec_table_dish = mysql_query($sql_table_dish))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " dish<br>\n" . mysql_error();
					exit();
				}
			}
			$sql_check_table_main = "DESCRIBE main";
			if (!$exec_check_table_main = mysql_query($sql_check_table_main))
			{
				//Main table
				$sql_table_main = "CREATE TABLE main (id int(8) unsigned zerofill NOT NULL auto_increment, name varchar(255) NOT NULL default '', dish varchar(255) NOT NULL default '', mainingredient varchar(255) NOT NULL default '', people varchar(4) NOT NULL default '', origin varchar(255) NOT NULL default '', ingredients text NOT NULL, description text NOT NULL, kind varchar(255) NOT NULL default '', season varchar(255) NOT NULL default '', time varchar(255) NOT NULL default '', difficulty varchar(255) NOT NULL default '', notes text NOT NULL, image varchar(255) NOT NULL default '', video varchar(255) NOT NULL default '', wines varchar(255) NOT NULL default '', PRIMARY KEY  (id), KEY id (id)) TYPE=MyISAM";
				if (!$exec_table_main = mysql_query($sql_table_main))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " main<br>\n" . mysql_error();
					exit();
				}
			}
			$sql_check_table_cookbook = "DESCRIBE personal_book";
			if (!$exec_check_table_cookbook = mysql_query($sql_check_table_cookbook))
			{
				//Personal cookbook table
				$sql_table_cookbook = "CREATE TABLE personal_book (id int(8) unsigned zerofill NOT NULL default '00000000', recipe_name varchar(255) NOT NULL default '', KEY id (id)) TYPE=MyISAM";
				if (!$exec_table_cookbook = mysql_query($sql_table_cookbook))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " cookbook<br>\n" . mysql_error();
					exit();
				}
			}
			$sql_check_table_rating = "DESCRIBE rating";
			if (!$exec_check_table_rating = mysql_query($sql_check_table_rating))
			{
				//Rating table
				$sql_table_rating = "CREATE TABLE rating (id int(8) unsigned zerofill NOT NULL default '00000000', vote smallint(1) NOT NULL default '0', KEY id (id)) TYPE=MyISAM";
				if (!$exec_table_rating = mysql_query($sql_table_rating))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " rating<br>\n" . mysql_error();
					exit();
				}
			}
			$sql_check_table_shopping = "DESCRIBE shopping";
			if (!$exec_check_table_shopping = mysql_query($sql_check_table_shopping))
			{
				//Shopping list table
				$sql_table_shopping = "CREATE TABLE shopping (id int(8) unsigned zerofill NOT NULL auto_increment, recipe varchar(255) NOT NULL default '0', ingredients text NOT NULL, PRIMARY KEY  (id)) TYPE=MyISAM";
				if (!$exec_table_shopping = mysql_query($sql_table_shopping))
				{
					cs_AddHeader();
					echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>";
					echo "<p class=\"error\">" . ERROR_INSTALL_TABLE . " shopping<br>\n" . mysql_error();
					exit();
				}
			}
		}
		//Write down configuration file then call index.php page
		$config_file = @fopen(dirname(__FILE__)."/config/crisoftricette.ini.php", "w");
		if (!$config_file)
		{	
			//Since configuration directory is not writable,
			//the content of configuration file is printed
			//on screen 
			header("Content-Type: text/plain");
			echo "Unable write down configuration file!\n";			
			echo "Please save all text here below in file\n";
			echo "config/crisoftricette.ini.php\n";
			echo "then restart application\n\n";
			echo "<--------- CUT HERE -------->\n";
echo ";<?php PLEASE DO NOT REMOVE THIS LINE FOR YOUR SECURITY
; This section contains runtime options
[Directives]
; locale setting
locale = {$_POST['sw_locale']}
; set here number of recipes per page
max_lines_page = {$_POST['sw_lines_per_page']}
; set here your email address
email_address = {$_POST['sw_email_address']}
; set here your preferred page size for PDF generation
; legal values: A4, legal, letter
page_size = {$_POST['sw_page_size']}
[Database Configuration]
; set here hostname of MySQL server
server = {$_POST['db_hostname']}
; set here TCP/IP port of MySQL server (3306 is default)
port = {$_POST['db_port']}
; set here your MySQL username
user = {$_POST['db_username']}
; set here your MySQL password, leave empty if none
pass = {$_POST['db_password']}
;set here database name
dbname = {$_POST['db_name']}\n
; DO NOT ALTER FOLLOWING SECTION
; ALTERING IT WILL LEAD TO SOFTWARE FAILURE
[Software Parameters]
software = CrisoftRicette
version = $sw_version
author = Lorenzo Pulici
website = http://crisoftricette.sourceforge.net
contact = snowdog@tiscali.it
;PLEASE DO NOT REMOVE THIS LINE FOR YOUR SECURITY ?>\n";
			echo "<--------- CUT HERE -------->\n";
			exit();
		}
		fputs($config_file, ";<?php PLEASE DO NOT REMOVE THIS LINE FOR YOUR SECURITY\n");
		fputs($config_file, "; This section contains runtime options\n");
		fputs($config_file, "[Directives]\n");
		fputs($config_file, "; locale settings\n");
		fputs($config_file, "locale = {$_POST['sw_locale']}\n");
		fputs($config_file, "; set here number of recipes per page\n");
		fputs($config_file, "max_lines_page = {$_POST['sw_lines_per_page']}\n");
		fputs($config_file, "; set here your email address\n");
		fputs($config_file, "email_address = {$_POST['sw_email_address']}\n");
		fputs($config_file, "; set here your preferred page size for PDF generation\n");
		fputs($config_file, "; legal values: A4, legal, letter\n");
		fputs($config_file, "page_size = {$_POST['sw_page_size']}\n");
		fputs($config_file, "[Database Configuration]\n");
		fputs($config_file, "; set here hostname of MySQL server\n");
		fputs($config_file, "server = {$_POST['db_hostname']}\n");
		fputs($config_file, "; set here TCP/IP port of MySQL server (3306 is default)\n");
		fputs($config_file, "port = {$_POST['db_port']}\n");
		fputs($config_file, "; set here your MySQL username\n");
		fputs($config_file, "user = {$_POST['db_username']}\n");
		fputs($config_file, "; set here your MySQL password, leave empty if none\n");
		fputs($config_file, "pass = {$_POST['db_password']}\n");
		fputs($config_file, ";set here database name\n");
		fputs($config_file, "dbname = {$_POST['db_name']}\n\n\n");
		fputs($config_file, "; DO NOT ALTER FOLLOWING SECTION\n");
		fputs($config_file, "; ALTERING IT WILL LEAD TO SOFTWARE FAILURE\n");
		fputs($config_file, "[Software Parameters]\n");
		fputs($config_file, "software = CrisoftRicette\n");
		fputs($config_file, "version = $sw_version\n");
		fputs($config_file, "author = Lorenzo Pulici\n");
		fputs($config_file, "website = http://crisoftricette.sourceforge.net\n");
		fputs($config_file, "contact = snowdog@tiscali.it\n");
		fputs($config_file, ";PLEASE DO NOT REMOVE THIS LINE FOR YOUR SECURITY ?>\n");
		fclose($config_file);
		header("Location: index.php");
	} 
	//if install value differs from ok prints out an error message
	//since this variable has been tampered
	if ($_POST['installation'] != "ok")
	{
		cs_AddHeader();
		require_once(dirname(__FILE__)."/lang/".$_POST['sw_locale'].".php");
		echo "<h2>" . ERROR_INSTALL_FAILURE . "</h2>\n
		<p>" . ERROR_UNEXPECTED . "\n";
		exit();
	}
}
?>

