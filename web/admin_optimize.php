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
echo "<h3>" . MSG_ADMIN_MENU_UTIL_OPT . "</h3>\n";
$sql_optimize = "OPTIMIZE TABLE admin, cooking, difficulty, dish, main, personal_book, rating, shopping";
if (!$exec_optimize = mysql_query($sql_optimize))
{
	echo "<p class=\"error\">" . ERROR_ADMIN_OPTIMIZE . "<br>\n" . mysql_error();
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
echo "<p>" . MSG_ADMIN_OPTIMIZE . "\n";
//Fast logout from admin area
cs_AdminFastLogout();
cs_AddFooter();
?>
