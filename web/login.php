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
if (isset($_SESSION['recipe_id']))
{
	unset($_SESSION['recipe_id']);
}
if (isset($_SESSION['recipe_name']))
{
	unset($_SESSION['recipe_name']);
}
if (isset($_SESSION['admin_user']) AND isset($_SESSION['admin_pass']))
{
	if ($trans_sid == 0)
	{
		header("Location: admin_index.php?".SID);
	}
	if ($trans_sid == 1)
	{
		header("Location: admin_index.php");
	}
}
cs_AddHeader();
echo "<h2>" . MSG_ADMIN . "</h2>\n";
echo "<p class=centerwarn>" . MSG_ADMIN_USERPASS_REQUEST . ":\n";
if ($trans_sid == 0)
{
	echo "<form method=\"post\" action=\"admin_index.php?" . SID . "\">\n";
}
if ($trans_sid == 1)
{
	echo "<form method=\"post\" action=\"admin_index.php\">\n";
}
echo "<div align=center><table border=0>\n
<tr><td><p class=centermsg>" . MSG_ADMIN_USER . ": </td><td><input type=text width=20 name=\"admin_user\"></td></tr>\n
<tr><td><p class=centermsg>" . MSG_ADMIN_PASS . ": </td><td><input type=password width=20 name=\"admin_pass\"></td></tr>\n
<tr><td colspan=2 align=center><input type=submit value=\"" . MSG_ADMIN_LOGIN . "\"></form></td></tr></table>\n";
//Query the database for default admin username and password and display an alert if stored ones are as default
$sql_check_default = "SELECT * FROM admin WHERE user = 'admin' OR password = 'admin'";
if (!$exec_check_default = mysql_query($sql_check_default))
{
	echo "<p class=\"error\">" . ERROR_ADMIN_CHECK_DB . "\n";
	cs_AddFooter();
	exit();
}
$num_default = mysql_num_rows($exec_check_default);
if ($num_default >= 1)
{
	echo "<p class=\"error\">" . ERROR_ADMIN_CHANGE_DEFAULT . "!\n";

}
cs_AddFooter();
?>

