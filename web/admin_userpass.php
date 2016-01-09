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
echo "<h3>" . MSG_ADMIN_MENU_CONFIG_USR . "</h3>\n";
//Update the database, unset session variables then ask to login
if (isset($_POST['adm_change']))
{
	$sql_adm_del = "DELETE FROM admin";
	if (!$exec_adm_del = mysql_query($sql_adm_del))
	{
		echo "<p class=\"error\">" . ERROR_ADMIN_USERPASS_START . "<br>\n" . mysql_error();
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	cs_CheckDangerousFormField($_POST['adminuser']);
	cs_CheckEmptyFormField($_POST['adminuser']);
	cs_CheckDangerousFormField($_POST['adminpass']);
	cs_CheckEmptyFormField($_POST['adminpass']);
	$sql_adm_chg = "INSERT admin (user, password) VALUES ('{$_POST['adminuser']}', '{$_POST['adminpass']}')";
	if (!$exec_adm_chg = mysql_query($sql_adm_chg))
	{
		echo "<p class=\"error\">" . ERROR_ADMIN_USERPASS_END . "<br>\n" . mysql_error();
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	cs_DestroyAdmin();
	echo "<p>" . MSG_ADMIN_USERPASS_SUCCESS . ".\n";
	echo "<p><a href=\"login.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_ADMIN_USERPASS_LOGIN . "</a>.\n";
	cs_AddFooter();
	exit();
}
//Retrieve admin user and pass
$sql_admin = "SELECT * FROM admin";
if (!$exec_admin = mysql_query($sql_admin))
{
	echo "<p class=\"error\">" . ERROR_ADMIN_USERPASS_RETRIEVE . "\n<br>" . mysql_error();
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//Print the form
while ($admindata = mysql_fetch_object($exec_admin))
{
	echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<p>Admin username: <input type=\"text\" size=\"20\" name=\"adminuser\" value=\"$admindata->user\">\n<p>Admin password: <input type=\"text\" size=\"20\" name=\"adminpass\" value=\"$admindata->password\">\n<p><input type=\"submit\" name=\"adm_change\" value=\"" . BTN_ADMIN_USERPASS_CHANGE . "\">\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//Fast logout from admin area
cs_AdminFastLogout();
cs_AddFooter();
?>
