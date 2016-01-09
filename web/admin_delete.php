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
echo "<h3>" . MSG_ADMIN_MENU_RECIPE_DEL . "</h3>\n";
//If is set GET recipe delete from database
if (isset($_GET['recipe']))
{
	$sql_delete_recipe = "DELETE FROM main WHERE id = '{$_GET['recipe']}'";
	if (!$exec_delete_recipe = mysql_query($sql_delete_recipe))
	{
		echo "<p class=\"error\">" . ERROR_ADMIN_DELETE_RECIPE . "<br>\n" . mysql_error();
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	echo "<p>" . MSG_ADMIN_DELETE_SUCCESS . "\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
echo "<p>" . MSG_ADMIN_DELETE_SELECT . "\n";
// Print browse list
if (!isset($_GET['offset'])) 
{
	$_GET['offset'] = 0;
}
if (!isset($_GET['letter'])) 
{
	$_GET['letter'] = "A";
}
//Count recipes into database
$sql_db_recipe_number = mysql_query("SELECT * FROM main");
$recipe_number = mysql_num_rows($sql_db_recipe_number);
//Retrieve recipe names and ID's
$sql_db_browse_letter = "SELECT id,name FROM main WHERE name LIKE '{$_GET['letter']}%' ORDER BY name ASC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
if (!$exec_db_browse = mysql_query($sql_db_browse_letter)) 
{
	echo "<p class=\"error\">" . ERROR_BROWSE . "\n<br>" . mysql_error();
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
};
cs_AlphaLinksDel();
//Count recipes in query, if == 0 print that no recipes are
//available
$num_letter = mysql_num_rows($exec_db_browse);
if ($num_letter == "0")
{
	echo "<p class=\"error\">" . ERROR_ADMIN_DELETE_LETTER . " {$_GET['letter']}\n";
	//Fast logout from admin area
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
$num_color_rows = cs_CountRowsRecipePage();
cs_PrintDeleteTable();
echo "<p>" . MSG_AVAILABLE_PAGES . ": \n";
if ($_GET['offset'] >= 1) 
{ // bypass PREV link if offset is 0
	$prevoffset = $_GET['offset'] - $_SESSION['max_lines_page'];
	echo "<p align=\"center\"><a href=\"admin_delete.php?&letter={$_GET['letter']}&offset=$prevoffset"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">" . MSG_PREVIOUS . "</a> - \n";
}
// calculate number of pages needing links
$pages = intval ($recipe_number / $_SESSION['max_lines_page']);
// $pages now contains int of pages needed unless there is a remainder from division
if ($recipe_number%$_SESSION['max_lines_page']) 
{
	// has remainder so add one page
	$pages++;
}
for ($i = 1; $i <= $pages; $i++) 
{ // loop thru
	$newoffset=$_SESSION['max_lines_page']*($i-1);
	echo "<a href=\"admin_delete.php?letter={$_GET['letter']}&offset=$newoffset"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">$i</a> \n";
}
// check to see if last page
if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) 
{
	// not last page so give NEXT link
	$newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
	echo "&nbsp;-&nbsp;<a href=\"admin_delete.php?letter={$_GET['letter']}&offset=$newoffset"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">" . MSG_NEXT . "</a>\n";
}
//Fast logout from admin area
cs_AdminFastLogout();
cs_AddFooter();
?>
