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
echo "<h3>" . MSG_ADMIN_MENU_UTIL_EXPMAIN . "</h3>\n";
if (!isset($_POST['action']))
{
	echo "<p>" . MSG_ADMIN_EXPORT_ASKTYPE . ":\n";
	echo "<br><form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<input type=\"hidden\" name=\"action\" value=\"export_ok\">\n
	<input type=\"hidden\" name=\"mode\" value=\"all\">\n
	<select name=\"export_type\">\n";
	//Read available directories into plugins subdir 
	$plugins_dir = opendir(dirname(__FILE__)."/plugins");
	while (($plugin_item = readdir($plugins_dir)) !== false) 
	{ 
		if ($plugin_item == "." OR $plugin_item == "..") continue;
		$export_file = "plugins/".$plugin_item."/export.php";
		if (file_exists($export_file))
		{
			include(dirname(__FILE__)."/plugins/$plugin_item/definition.php");
			echo "<option value=\"$plugin_item\">$definition</option>\n";
		}
	}  
	closedir($plugins_dir);
	echo "</select>\n<p><input type=\"submit\" value=\"" . BTN_ADMIN_EXPORT . "\">\n
	</form>\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
if (isset($_POST['action']))
{
	if ($_POST['action'] != "export_ok")
	{
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	$export_type = $_POST['export_type'];
	require(dirname(__FILE__)."/plugins/$export_type/export.php");
}
//Fast logout from admin area
cs_AdminFastLogout();
cs_AddFooter();
?>
