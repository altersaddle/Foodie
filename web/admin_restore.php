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
echo "<h2>" . MSG_ADMIN . "</h2>\n";
echo "<h3>" . MSG_ADMIN_MENU_BACKUP_RST. "</h3>\n";
if (!isset($_POST['restore_action']))
{
	echo "<p>" . MSG_ADMIN_RESTORE_SUBDIR . "\n";
	echo "<p><form method=\"post\" action=\"admin_restore.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<input type=\"hidden\" name=\"restore_action\" value=\"do_restore\">
	<p><input type=\"submit\" value=\"" . BTN_ADMIN_RESTORE_PROCEED . "\">
	</form>\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
if (isset($_POST['restore_action']))
{
	//If $_POST variable is correctly set restore sql backup file
	if ($_POST['restore_action'] == "do_restore")
	{
		$restore_file = dirname(__FILE__)."/backup/crisoftricette.sql";
		if (!file_exists($restore_file))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_RESTORE_FILE . ".\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$sql_queries = join("", file($restore_file));
		$sql_queries = explode(";", $sql_queries);
		foreach ($sql_queries as $single_query)
		{
			$exec_query = mysql_query($single_query);
		}
		echo "<p>" . MSG_ADMIN_RESTORE_SUCCESS . ".\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
}
//Fast logout from admin area
cs_AdminFastLogout();
cs_AddFooter();
?>
