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
session_name("crisoftricette");
session_start();
require_once(dirname(__FILE__)."/lang/".$_SESSION['locale'].".php");
require(dirname(__FILE__)."/crisoftlib.php");
require(dirname(__FILE__)."/includes/db_connection.inc.php");
$trans_sid = cs_IsTransSid();
cs_AddHeader();
cs_CheckLoginAdmin();
//If no action defined print form to be filled in 
if (!isset($_POST['import_action']))
{
	echo "<h2>" . MSG_ADMIN . "</h2>\n";
	echo "<h3>" . MSG_ADMIN_MENU_UTIL_IMP07 . "</h3>\n";
	echo "<p>" . MSG_ADMIN_IMP07_FILL . "\n";
	echo "<form method=\"post\" action=\"admin_07import.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<input type=\"hidden\" name=\"import_action\" value=\"import_ok\">\n
	<table>
	<tr><td><p>" . MSG_ADMIN_IMP07_HOSTNAME . "</td><td><input type=\"text\" name=\"import_dbhostname\" size=\"20\" value=\"localhost\"></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_IMP07_PORT . "</td><td><input type=\"text\" name=\"import_dbport\" size=\"20\" value=\"3306\"></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_IMP07_USER . "</td><td><input type=\"text\" name=\"import_dbuser\" size=\"20\"></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_IMP07_PASS . "</td><td><input type=\"password\" name=\"import_dbpass\" size=\"20\"></td></tr>\n
	<tr><td><p>" . MSG_ADMIN_IMP07_DBNAME . "</td><td><input type=\"text\" name=\"import_dbname\" size=\"20\" value=\"ricette\"></td></tr>\n
	<tr><td colspan=\"2\" align=center><input type=\"submit\" value=\"" . BTN_ADMIN_IMP07_IMPORT . "\"></td></tr></table>\n
	</form>";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//If import_action defined check its value
if (isset($_POST['import_action']))
{
	//If import_action is import_ok get data from 0.7 main table then copy into 1.0 main
	//table
	if ($_POST['import_action'] == "import_ok")
	{
		//Check all _POST input!!!
		//Check if hostname, port, user and db name are empty
		cs_CheckEmptyFormField($_POST['import_dbhostname']);
		cs_CheckEmptyFormField($_POST['import_dbport']);
		cs_CheckEmptyFormField($_POST['import_dbuser']);
		cs_CheckEmptyFormField($_POST['import_dbname']);
		//check hostname for a theoretical valid hostname or ip
		//with a regexp that allows only characters, numbers and
		//dots if not localhost
		if ($_POST['import_dbhostname'] != "localhost")
		{
			if (!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)", $_POST['db_hostname']))
			{
				cs_AddHeader();
				echo "<h2>" . ERROR_ADMIN_IMP07_TITLE . "</h2>";
				echo "<p class=\"error\">{$_POST['import_dbhostname']} " . ERROR_ADMIN_IMP07_HOSTNAME . "\n";
				echo "<p>Please <a href=\"{$_SERVER['HTTP_REFERER']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_BACK . "</a>\n";
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
		}
		cs_CheckDangerousInput($_POST['import_dbhostname']);
		//Check if mysql port is a numeric value
		if (!is_numeric($_POST['import_dbport']))
		{	
			cs_AddHeader();
			echo "<h2>" . ERROR_ADMIN_IMP07_TITLE . "</h2>";
			echo "<p class=\"error\">" . ERROR_ADMIN_IMP07_PORT . "!\n";
			echo "<p>Please <a href=\"{$_SERVER['HTTP_REFERER']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_BACK . "</a>\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Check all other inputs
		cs_CheckDangerousInput($_POST['import_dbport']);
		cs_CheckDangerousInput($_POST['import_dbuser']);
		cs_CheckDangerousInput($_POST['import_dbpassword']);
		cs_CheckDangerousInput($_POST['import_dbname']);
		//Try connection to 0.7.x database
		$get_data_connection = mysql_connect("{$_POST['import_dbhostname']}:{$_POST['import_dbport']}", "{$_POST['import_dbuser']}", "{$_POST['import_dbpass']}");
		if (!$get_data_connection)
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_IMP07_SERVER . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		if (!($get_data_select = mysql_select_db("{$_POST['import_dbname']}")))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_IMP07_SELECT . "!<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$sql_get_data = "SELECT * FROM principale";
		if (!$exec_get_data = mysql_query($sql_get_data, $get_data_connection))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_IMP07_COPY . ".\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		while ($get_data = mysql_fetch_object($exec_get_data)) 
		{
			$piatto = mysql_escape_string($get_data->Piatto);
			$portata = mysql_escape_string($get_data->Portata);
			$ingprinc = mysql_escape_string($get_data->IngPrinc);
			$persone = mysql_escape_string($get_data->Persone);
			$origine = mysql_escape_string($get_data->Origine);
			$ingredienti = mysql_escape_string($get_data->Ingredienti);
			$preparazione = mysql_escape_string($get_data->Preparazione);
			$sql_move_data = "INSERT INTO main (name, dish, mainingredient, people, origin, ingredients, description) VALUES ('$piatto', '$portata', '$ingprinc', '$persone', '$origine', '$ingredienti', '$preparazione')";
			echo "<p>$piatto\n";
			if (!$exec_move_data = mysql_query($sql_move_data, $dbconnect))
			{
				echo "<p class=\"error\">Unable to copy recipes<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
			}
			echo "<p>" . MSG_ADMIN_IMP07_SUCCESS . " $get_data->Piatto";
		}
		cs_AddFooter();
		exit();
	}
	//If import_action is different from required abort with error
	echo "<p class=\"error\">" . ERROR_UNEXPECTED . "<br>\n";
}
cs_AdminFastLogout();
cs_AddFooter();
?>
