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
$trans_sid = cs_IsTransSid();
cs_AddHeader();
cs_CheckLoginAdmin();
echo "<h2>" . MSG_ADMIN . "</h2>\n";
echo "<h3>" . MSG_ADMIN_MENU_CONFIG_CFG . "</h3>\n";
if (isset($_POST['change']))
{
	if ($_POST['change'] != "ok")
	{
		//if post variable has been tampered print an error message
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
		cs_AddFooter();
		exit();
	}
	//checks for empty form fields - do not check mysql user and
	//pass
	cs_CheckEmptyInputConfig($_POST['config_server']);
	cs_CheckEmptyInputConfig($_POST['config_port']);
	cs_CheckEmptyInputConfig($_POST['config_dbname']);
	cs_CheckEmptyInputConfig($_POST['config_locale']);
	cs_CheckEmptyInputConfig($_POST['config_max_lines_page']);
	cs_CheckEmptyInputConfig($_POST['config_page_size']);
	cs_CheckEmptyInputConfig($_POST['config_email_address']);
	//security checks
	cs_CheckDangerousInputConfig($_POST['config_user']);
	cs_CheckDangerousInputConfig($_POST['config_pass']);
	cs_CheckDangerousInputConfig($_POST['config_server']);
	cs_CheckDangerousInputConfig($_POST['config_port']);
	cs_CheckDangerousInputConfig($_POST['config_dbname']);
	cs_CheckDangerousInputConfig($_POST['config_locale']);
	cs_CheckDangerousInputConfig($_POST['config_max_lines_page']);
	cs_CheckDangerousInputConfig($_POST['config_page_size']);
	//email address is valid?
	if (!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]+))*$", $_POST['config_email_address']))
	{
		echo "<p class=\"error\">{$_POST['config_email_address']} " . ERROR_MAIL_ADDRESS . "\n";
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
		echo "<table>\n<tr><td><p>" . MSG_ADMIN_CFG_HOSTNAME . ":</td><td><input type=\"text\" name=\"config_server\" value=\"{$_POST['config_server']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_PORT . ":</td><td><input type=\"text\" name=\"config_port\" value=\"{$_POST['config_port']}\" size=\"5\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_DBNAME . ":</td><td><input type=\"text\" name=\"config_dbname\" value=\"{$_POST['config_dbname']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_USER . ":</td><td><input type=\"text\" name=\"config_user\" value=\"{$_POST['config_user']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_PASS . ":</td><td><input type=\"text\" name=\"config_pass\" value=\"{$_POST['config_pass']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_EMAIL . ":</td><td><input type=\"text\" name=\"config_email_address\" value=\"{$_POST['config_email_address']}\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_LOCALE . ":</td><td><select name=\"config_locale\"><option value=\"{$_POST['config_locale']}\">{$_POST['config_locale']}</option>\n";
		$lang_dir = opendir(dirname(__FILE__)."/lang");
		while (($lang_item = readdir($lang_dir)) !== false) 
		{ 
			if ($lang_item == "." OR $lang_item == "..") continue;
			//Strip away dot and php extension
			$lang_file = str_replace(".php", "", $lang_item);
			if ($lang_file != $_POST['config_locale'])
			{
				if (ereg("^[a-z]{2}$", $lang_file))
				{
					echo "<option value=\"$lang_file\">$lang_file</option>\n";
				}
			}
		}  
		closedir($lang_dir);
		echo "
		</select></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_LINES . ":</td><td><input type=\"text\" name=\"config_max_lines_page\" value=\"{$_POST['config_max_lines_page']}\" size=\"3\"></td></tr>\n
		<tr><td><p>" . MSG_ADMIN_CFG_PAGESIZE . ":</td><td><select name=\"config_page_size\">
		<option value=\"{$_POST['config_page_size']}\">{$_POST['config_page_size']}</option>\n";
		$avail_pagesize = array ('A4', 'letter', 'legal'); 
		foreach ($avail_pagesize as $pagesize)
		{
			if ($pagesize != $_POST['config_page_size'])
			{
				echo "<option value=\"$pagesize\">$pagesize</option>\n";
			}
		}
		echo "
		</select></td></tr>\n
		</table>\n
		<input type=\"hidden\" name=\"change\" value=\"ok\">\n
		<div align=center><input type=\"submit\" value=\"" . BTN_ADMIN_CFG_CHANGE . "\"></div>\n
		</form>\n\n";
		//Fast logout from admin area
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}

	//check hostname
	if ($_POST['config_server'] != "localhost")
	{
		if (!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)", $_POST['config_server']))
		{
			echo "<p>{$_POST['config_server']} <span class=\"error\">" . ERROR_ADMIN_CFG_HOSTNAME . "</span>\n";
			echo "<p><a href=\"{$_SERVER['HTTP_REFERER']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_BACK . "</a>\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
	}
	if (!is_numeric($_POST['config_port']))
	{
		echo "<p class=\"error\">" . ERROR_ADMIN_CFG_PORT . "!\n";
		echo "<p><a href=\"{$_SERVER['HTTP_REFERER']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_BACK . "</a>\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	if (!is_numeric($_POST['config_max_lines_page']))
	{
		echo "<p class=\"error\">" . ERROR_ADMIN_CFG_LINES . "!\n";
		echo "<p><a href=\"{$_SERVER['HTTP_REFERER']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_BACK . "</a>\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	//modify configuration and when finished unset all session variables then reload index.php
	include("version.php");
	if (!unlink(dirname(__FILE__)."/config/crisoftricette.ini.php"))
	{
		cs_AddHeader();
		echo "<p class=\"error\">" . ERROR_ADMIN_CFG_DELETE . "\n";
	}
	$config_file = fopen(dirname(__FILE__)."/config/crisoftricette.ini.php", "w");
	if (!$config_file)
	{	
		//Since configuration directory is not writable,
		//the content of configuration file is printed
		//on screen 
		header("Content-Type: text/plain");
		echo "\n" . ERROR_ADMIN_CFG_DELETE . "!\n";			
		echo "\n" . ERROR_ADMIN_CFG_BELOW . "\n";
		echo "config/crisoftricette.ini.php\n";
		echo "\n" . ERROR_ADMIN_CFG_RESTART . "\n\n";
		echo "<--------- CUT HERE -------->\n";
echo ";<?php PLEASE DO NOT REMOVE THIS LINE FOR YOUR SECURITY
; This section contains runtime options
[Directives]
; locale setting
locale = {$_POST['config_locale']}
; set here number of recipes per page
max_lines_page = {$_POST['config_max_lines_page']}
; set here your email address
email_address = {$_POST['config_email_address']}
; set here your preferred page size for PDF generation
; legal values: A4, legal, letter
page_size = {$_POST['config_page_size']}
[Database Configuration]
; set here hostname of MySQL server
server = {$_POST['config_server']}
; set here TCP/IP port of MySQL server (3306 is default)
port = {$_POST['config_port']}
; set here your MySQL username
user = {$_POST['config_user']}
; set here your MySQL password, leave empty if none
pass = {$_POST['config_pass']}
;set here database name
dbname = {$_POST['config_dbname']}\n
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
	fputs($config_file, "; locale setting\n");
	fputs($config_file, "locale = {$_POST['config_locale']}\n");
	fputs($config_file, "; set here number of recipes per page\n");
	fputs($config_file, "max_lines_page = {$_POST['config_max_lines_page']}\n");
	fputs($config_file, "; set here your email address\n");
	fputs($config_file, "email_address = {$_POST['config_email_address']}\n");
	fputs($config_file, "; set here your preferred page size for PDF generation\n");
	fputs($config_file, "; legal values: A4, legal, letter\n");
	fputs($config_file, "page_size = {$_POST['config_page_size']}\n");
	fputs($config_file, "[Database Configuration]\n");
	fputs($config_file, "; set here hostname of MySQL server\n");
	fputs($config_file, "server = {$_POST['config_server']}\n");
	fputs($config_file, "; set here TCP/IP port of MySQL server (3306 is default)\n");
	fputs($config_file, "port = {$_POST['config_port']}\n");
	fputs($config_file, "; set here your MySQL username\n");
	fputs($config_file, "user = {$_POST['config_user']}\n");
	fputs($config_file, "; set here your MySQL password, leave empty if none\n");
	fputs($config_file, "pass = {$_POST['config_pass']}\n");
	fputs($config_file, ";set here database name\n");
	fputs($config_file, "dbname = {$_POST['config_dbname']}\n\n\n");
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
	if ($trans_sid == 0)
	{
		header("Location: logout.php". SID);
	}
	if ($trans_sid == 1)
	{
		header("Location: logout.php");
	}
	exit();
}
//Form output
$ini_directives = parse_ini_file(dirname(__FILE__)."/config/crisoftricette.ini.php");
extract ($ini_directives, EXTR_OVERWRITE);
echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
echo "<table>\n<tr><td><p>" . MSG_ADMIN_CFG_HOSTNAME . ":</td><td><input type=\"text\" name=\"config_server\" value=\"$server\"></td></tr>\n
<tr><td><p>" . MSG_ADMIN_CFG_PORT . ":</td><td><input type=\"text\" name=\"config_port\" value=\"$port\" size=\"5\"></td></tr>\n
<tr><td><p>" . MSG_ADMIN_CFG_DBNAME . ":</td><td><input type=\"text\" name=\"config_dbname\" value=\"$dbname\"></td></tr>\n
<tr><td><p>" . MSG_ADMIN_CFG_USER . ":</td><td><input type=\"text\" name=\"config_user\" value=\"$user\"></td></tr>\n
<tr><td><p>" . MSG_ADMIN_CFG_PASS . ":</td><td><input type=\"text\" name=\"config_pass\" value=\"$pass\"></td></tr>\n
<tr><td><p>" . MSG_ADMIN_CFG_EMAIL . ":</td><td><input type=\"text\" name=\"config_email_address\" value=\"$email_address\"></td></tr>\n
<tr><td><p>" . MSG_ADMIN_CFG_LOCALE . ":</td><td><select name=\"config_locale\"><option value=\"$locale\">$locale</option>\n";
$lang_dir = opendir(dirname(__FILE__)."/lang");
while (($lang_item = readdir($lang_dir)) !== false) 
{ 
	if ($lang_item == "." OR $lang_item == "..") continue;
	//Strip away dot and php extension
	$lang_file = str_replace(".php", "", $lang_item);
	if ($lang_file != $locale)
	{
		echo "<option value=\"$lang_file\">$lang_file</option>\n";
	}
}  
closedir($lang_dir);
echo "
</select></td></tr>\n
<tr><td><p>" . MSG_ADMIN_CFG_LINES . ":</td><td><input type=\"text\" name=\"config_max_lines_page\" value=\"$max_lines_page\" size=\"3\"></td></tr>\n
<tr><td><p>" . MSG_ADMIN_CFG_PAGESIZE . ":</td><td><select name=\"config_page_size\">
<option value=\"$page_size\">$page_size</option>\n";
$avail_pagesize = array ('A4', 'letter', 'legal'); 
foreach ($avail_pagesize as $pagesize)
	{
		if ($pagesize != $page_size)
		{
			echo "<option value=\"$pagesize\">$pagesize</option>\n";
		}
	}
echo "
</select></td></tr>\n
</table>\n
<input type=\"hidden\" name=\"change\" value=\"ok\">\n
<div align=center><input type=\"submit\" value=\"" . BTN_ADMIN_CFG_CHANGE . "\"></div>\n
</form>\n
\n";
//Fast logout from admin area
cs_AdminFastLogout();
cs_AddFooter();
?>
