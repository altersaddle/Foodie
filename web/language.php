<?php
require(dirname(__FILE__)."/crisoftlib.php");
cs_AddHeader();
//Check PHP version - software needs at least PHP 4.2.2 (PHP may be also
//4.1, but an upgrade to 4.2.2 is strongly suggested due a big security
//hole in previous releases
$php_version = phpversion();
if ($php_version < '4.1.1') 
{
	echo "<p class=\"error\">Sorry but you need at least PHP 4.2.1 in order to enjoy <strong>CrisoftRicette</strong>!<br><a href=\"http://www.php.net\">Upgrade now</a>!\n";
	exit();
}
//Check if register_globals is set to off
$registerglobals = ini_get('register_globals_foo');
if ($registerglobals == "1")
{
	echo "<p class=\"error\">Sorry but this application REQUIRES for security reasons that <tt>register_globals</tt> in <tt>php.ini</tt> is set to Off!\n";
	exit();
}
echo "<form method=\"post\" action=\"install.php\">\n
<table align=\"center\" border=\"0\" cellspacing =\"5\"><tr><td>
<p>Please choose your language:\n<select name=\"sw_locale\">\n";
$lang_dir = opendir(dirname(__FILE__)."/lang");
	while (($lang_item = readdir($lang_dir)) !== false) 
	{ 
		if ($lang_item == "." OR $lang_item == "..") continue;
		//Strip away dot and php extension
		$lang_file = str_replace(".php", "", $lang_item);
		if (ereg("^[a-z]{2}$", $lang_file))
		{
			echo "<option value=\"$lang_file\">$lang_file</option>\n";
		}
	}  
closedir($lang_dir);
echo "</select>\n";
?>
</td><td>&nbsp;<input type="submit" name="crisoft_install" value="Install"></td></tr></table>
</form>
</body>
</html>
