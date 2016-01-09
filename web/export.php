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
echo "<h3>" . MSG_EXPORT_SINGLE . "</h3>\n";
if (!isset($_POST['action']))
{
	echo "<p class=\"error\">" . ERROR_EXPORT_RECIPE_CALL . "\n";
	cs_AddFooter();
	exit();
}
if (isset($_POST['action']))
{
	if ($_POST['action'] != "export_ok")
	{
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
		cs_AddFooter();
		exit();
	}
	$export_type = $_POST['export_type'];
	require(dirname(__FILE__)."/plugins/$export_type/export.php");
}
cs_AddFooter();
?>
