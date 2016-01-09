<?php
/*
 ***************************************************************************
 * CrisoftRicette is a GPL licensed free software written
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
echo "<h2>" . MSG_ADMIN . "</h2>\n";
if (!isset($_SESSION['admin_user']) AND !isset($_SESSION['admin_pass']))
{
	if (!isset($_POST['admin_user']) || !isset($_POST['admin_pass'])) 
	{
		cs_CheckLoginAdmin();
	}
	if (empty($_POST['admin_user'])) {
		echo "<p class=\"error\">" . ERROR_ADMIN_INVALID_USERNAME . "!\n";
		cs_AddFooter();
		exit();
	}
	if (empty($_POST['admin_pass'])) {
		echo "<p class=\"error\">" . ERROR_ADMIN_INVALID_PASSWORD . "!\n";
		cs_AddFooter();
		exit();
	}
	//Regex to check username/password fields - escaping dangerous
	//characters
	cs_CheckDangerousInput($_POST['admin_user']);
	cs_CheckDangerousInput($_POST['admin_pass']);
	//Checking for valid admin user/password pair only if user/password pair
	//have passed above checks
	$sql_stored_user = "SELECT * FROM admin";
	if (!$exec_stored_user = mysql_query($sql_stored_user)) {
		echo "<p class=\"error\">" . ERROR_ADMIN_CHECK_DB . "!\n";
		cs_AddFooter();
		exit();
	}
	while ($auth_data = mysql_fetch_object($exec_stored_user)) {
		if ($auth_data->user == $_POST['admin_user']) {
			if ($auth_data->password == $_POST['admin_pass']) {
				$_SESSION['admin_user'] = $_POST['admin_user'];
				$_SESSION['admin_pass'] = $_POST['admin_pass'];
				break;
			} else {
				echo "<p class=centerwarn>" . ERROR_ADMIN_AUTHFAIL . "\n";
				cs_AddFooter();
				exit();
			}
		}

	}
	if (!isset($_SESSION['admin_user'])) {
		echo "<p class=centerwarn>".ERROR_ADMIN_AUTHFAIL . "\n";
		cs_AddFooter();
		exit();
	}
}
echo "<h3>" . MSG_ADMIN_MAIN_MENU . "</h3>\n";
echo "<table width=\"100%\" bgcolor=\"#dddddd\" cellspacing=\"1\" cellpadding=\"1\">\n
<tr bgcolor=\"#ffffff\"><td valign=top><p class=\"menu_title\">" . MSG_ADMIN_TITLE_RECIPE . "</td>
<td valign=top><p>";
echo "<a href=\"admin_insert.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_RECIPE_ADD . "</a><br>
<a href=\"admin_modify.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_RECIPE_MOD . "</a><br>
<a href=\"admin_delete.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_RECIPE_DEL . "</a><br>
<a href=\"admin_mmedia.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_MULTIMEDIA . "</a>

</td></tr>\n";
echo "<tr bgcolor=\"#ffffff\"><td valign=top><p class=\"menu_title\">" . MSG_ADMIN_TITLE_SERVING . "</td><td valign=top>\n
<p><a href=\"admin_dish.php?action=adm_insert";
if ($trans_sid == 0)
{
	echo "&" . SID;
}
echo "\">" . MSG_ADMIN_MENU_SERVING_ADD . "</a><br>\n
<a href=\"admin_dish.php?action=adm_modify";
if ($trans_sid == 0)
{
	echo "&" . SID;
}
echo "\">" . MSG_ADMIN_MENU_SERVING_MOD . "</a><br>\n
<a href=\"admin_dish.php?action=adm_delete";
if ($trans_sid == 0)
{
	echo "&" . SID;
}
echo "\">" . MSG_ADMIN_MENU_SERVING_DEL . "</a></td></tr>\n
<tr bgcolor=\"#ffffff\"><td valign=top><p class=\"menu_title\">" . MSG_ADMIN_TITLE_COOKING . "</td><td valign=top>\n
<p><a href=\"admin_cook.php?action=adm_insert";
if ($trans_sid == 0)
{
	echo "&" . SID;
}
echo "\">" . MSG_ADMIN_MENU_COOKING_ADD . "</a><br>\n
<a href=\"admin_cook.php?action=adm_modify";
if ($trans_sid == 0)
{
	echo "&" . SID;
}
echo "\">" . MSG_ADMIN_MENU_COOKING_MOD . "</a><br>\n
<a href=\"admin_cook.php?action=adm_delete";
if ($trans_sid == 0)
{
	echo "&" . SID;
}
echo "\">" . MSG_ADMIN_MENU_COOKING_DEL . "</a><br></td></tr>\n
<tr bgcolor=\"#ffffff\"><td valign=top><p class=\"menu_title\">" . MSG_ADMIN_TITLE_CONFIG . "</td><td valign=top>\n
<p><a href=\"admin_userpass.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_CONFIG_USR . "</a><br>\n
<a href=\"admin_config.php";
if ($trans_sid == 0)
{
	echo "&" . SID;
}
echo "\">" . MSG_ADMIN_MENU_CONFIG_CFG . "</a><br></td></tr>\n
<tr bgcolor=\"#ffffff\"><td valign=top><p class=\"menu_title\">" . MSG_ADMIN_TITLE_UTIL . "</td><td valign=top>\n
<p><a href=\"admin_export.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_UTIL_EXPMAIN . "</a><br>\n
<a href=\"admin_07import.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_UTIL_IMP07 . "</a><br>\n
<a href=\"admin_import.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_UTIL_IMPFILES . "</a><br>\n
<a href=\"admin_optimize.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_UTIL_OPT . "</a><br></td></tr>\n
<tr bgcolor=\"#ffffff\"><td valign=top><p class=\"menu_title\">" . MSG_ADMIN_TITLE_BACKUP . "</td><td valign=top>\n
<p><a href=\"admin_backup.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_BACKUP_BKP . "</a><br>\n
<a href=\"admin_restore.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_MENU_BACKUP_RST . "</a><br></td></tr>\n
<tr bgcolor=\"#ffffff\"><td valign=top><p class=\"menu_title\">" . MSG_ADMIN_TITLE_LOGOUT . "</td><td valign=top>\n
<p><a href=\"admin_logout.php";
if ($trans_sid == 0)
{
	echo "?" . SID;
}
echo "\">" . MSG_ADMIN_LOGOUT . "</a></td></tr></table>\n";
cs_AddFooter();
?>
