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
header('Content-type: text/plain');
$ini_directives = parse_ini_file(dirname(__FILE__)."/config/crisoftricette.ini.php");
extract ($ini_directives, EXTR_OVERWRITE);
$_SESSION['locale'] = $locale;
$_SESSION['max_lines_page'] = $max_lines_page;
$_SESSION['email_address'] = $email_address;
$_SESSION['page_size'] = $page_size;
$_SESSION['server'] = $server;
$_SESSION['port'] = $port;
$_SESSION['user'] = $user;
$_SESSION['pass'] = $pass;
$_SESSION['dbname'] = $dbname;
$_SESSION['software'] = $software;
$_SESSION['version'] = $version;
$_SESSION['author'] = $author;
$_SESSION['website'] = $website;
$_SESSION['contact'] = $contact;
require_once(dirname(__FILE__)."/lang/en.php");
require(dirname(__FILE__)."/crisoftlib.php");
$trans_sid = cs_IsTransSid();
cs_DestroyAdmin();
# cs_AddHeader();
# echo "<h2>" . MSG_BROWSE . "</h2>\n";
require(dirname(__FILE__)."/includes/db_connection.inc.php");
//check for session variables 'recipe_id and recipe_name and unset them if they exist
//in order to clear them if someone calls this page from rated.php
if (isset($_SESSION['recipe_id']))
{
	unset($_SESSION['recipe_id']);
}
if (isset($_SESSION['recipe_name']))
{
	unset($_SESSION['recipe_name']);
}
//If GET browse variable is not set print links to choose kind of
//browsing
if (!isset($_GET['browse']))
{
	//Count recipes into main table: if result = 0 exit with message, else print search form
	$sql_recipes = "SELECT id FROM main";
	if (!$exec_count_recipes = mysql_query($sql_recipes))
	{
		echo "<p class=\"error\">" . ERROR_COUNT_RECIPES . "<br>\n" . mysql_error();
		cs_AddFooter();
		exit();
	}
	$num_recipes = cs_CountRecipes();
	if ($num_recipes == 0)
	{
		echo "<p class=\"error\">" . MSG_NO_RECIPES . "<br>\n" . MSG_BROWSE_EMPTY . "?\n";
		cs_AddFooter();
		exit();
	}
	echo "<p>" . MSG_SELECT_BROWSE . "\n";
	echo "<p><a href=\"{$_SERVER['PHP_SELF']}?browse=br_recipe";if ($trans_sid == 0){ echo "&" . SID;} echo "\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_ID . "</a><br>\n";
	echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_alpha";if ($trans_sid == 0){ echo "&" . SID;} echo "\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_ALPHA . "</a><br>\n";
	echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_dish";if ($trans_sid == 0){ echo "&" . SID;} echo "\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_SERVING . "</a><br>\n";
	echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_ingredient";if ($trans_sid == 0){ echo "&" . SID;} echo "\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_MAIN . "</a><br>\n";
	echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_cook";if ($trans_sid == 0){ echo "&" . SID;} echo "\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_KIND . "</a><br>\n";
	echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_origin";if ($trans_sid == 0){ echo "&" . SID;} echo "\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_ORIGIN . "</a><br>\n";
	echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_season";if ($trans_sid == 0){ echo "&" . SID;} echo "\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_SEASON . "</a><br>\n";
	echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_easy";if ($trans_sid == 0){ echo "&" . SID;} echo "\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_EASY . "</a><br>\n";
	echo "<a href=\"{$_SERVER['PHP_SELF']}?browse=br_difficult";if ($trans_sid == 0){ echo "&" . SID;} echo "\"><img border=\"0\" src=\"layout/arrow.gif\" align=\"middle\"> " . MSG_ORDER_HARD . "</a><br>\n";
	cs_AddFooter();
	exit();
}
cs_CheckForBrowseType();
/*
 *
 *	browse by recipe
 *
 */
if ($_GET['browse'] == 'br_recipe')
{
	if (!isset($_GET['offset'])) 
	{
		$_GET['offset'] = 0;
	}
	//Count recipes into database
	$sql_db_recipe_number = mysql_query("SELECT * FROM main");
	$recipe_number = mysql_num_rows($sql_db_recipe_number);
	//Retrieve recipe names and ID's
	$sql_db_browse = "SELECT id,name FROM main LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
	if (!$exec_db_browse = mysql_query($sql_db_browse)) 
	{
		echo "<p class=\"error\">" . ERROR_BROWSE . "\n<br>";
		echo mysql_error();
		cs_AddFooter();
		exit();
	};
	//Print on screen recipe table
	$num_color_rows = cs_CountRowsRecipePage();
	cs_PrintBrowseTable();
	//Print available pages
	echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
	if ($_GET['offset']>=1) 
	{ 
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_PREVIOUS ."</a> - \n";
	}
	$pages=intval($recipe_number/$_SESSION['max_lines_page']);
	if ($recipe_number%$_SESSION['max_lines_page']) 
	{
	    $pages++;
	}
	for ($i=1;$i<=$pages;$i++) 
	{ 
    		$newoffset=$_SESSION['max_lines_page']*($i-1);
		echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">$i</a> \n";
	}
	// check to see if last page
	if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) 
	{
		// not last page so give NEXT link
		$newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
		echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_NEXT ."</a>\n";
	}
cs_AddFooter();
exit();
}
/*
 *
 * End browse by recipe
 *
 */
/*
 *
 *	browse sorted alphabetically
 *
 */
if ($_GET['browse'] == 'br_alpha')
{
	if (!isset($_GET['offset'])) 
	{
		$_GET['offset'] = 0;
	}
	$sql_db_recipe_number = mysql_query("SELECT * FROM main");
	$recipe_number = mysql_num_rows($sql_db_recipe_number);
	$sql_db_browse = "SELECT id,name FROM main ORDER BY name ASC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
	if (!$exec_db_browse = mysql_query($sql_db_browse)) 
	{
		echo "<p class=\"error\">" . ERROR_BROWSE ."\n<br>";
		echo mysql_error();
		cs_AddFooter();
		exit();
	};
	cs_AlphaLinks();
	$num_color_rows = cs_CountRowsRecipePage();
	cs_PrintBrowseTable();
	echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
	if ($_GET['offset']>=1) 
	{ 
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_PREVIOUS ."</a> - \n";
	}
	$pages=intval($recipe_number/$_SESSION['max_lines_page']);
	if ($recipe_number%$_SESSION['max_lines_page']) 
	{
    		$pages++;
	}
	for ($i=1;$i<=$pages;$i++) 
	{
	    $newoffset=$_SESSION['max_lines_page']*($i-1);
		echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">$i</a> \n";
	}
	if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) 
	{
		$newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
		echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_NEXT ."</a>\n";
	}
	cs_AddFooter();
	exit();
}
/*
 *
 * End browse sorted alphabetically
 *
 */
/*
 *
 *	browse sorted by dish
 *
 */
if ($_GET['browse'] == 'br_dish')
{
if (!isset($_GET['offset'])) {
	$_GET['offset'] = 0;
}
$sql_db_recipe_number = mysql_query("SELECT * FROM main");
$recipe_number = mysql_num_rows($sql_db_recipe_number);
$sql_db_browse = "SELECT id,name,dish FROM main";
if (isset($_GET['dish'])) {
  $sql_db_browse = $sql_db_browse." WHERE dish='{$_GET['dish']}'";
}
else {
  $sql_db_browse .= " ORDER BY dish ASC";
}
if (!$exec_db_browse = mysql_query($sql_db_browse)) {
	echo "<p class=\"error\">" . ERROR_BROWSE ."\n<br>";
	echo mysql_error();
	cs_AddFooter();
	exit();
};
while ($recipe_list = mysql_fetch_object($exec_db_browse)) {
  echo $recipe_list->id."|".html_entity_decode($recipe_list->name, ENT_QUOTES);
  echo "\n";
}



exit();
}
/*
 *
 * End browse sorted by dish
 *
 */
/*
 *
 *	browse sorted by dish
 *
 */
if ($_GET['browse'] == 'br_ingredient')
{
if (!isset($_GET['offset'])) {
	$_GET['offset'] = 0;
}
$sql_db_recipe_number = mysql_query("SELECT * FROM main");
$recipe_number = mysql_num_rows($sql_db_recipe_number);
$sql_db_browse = "SELECT id,name,mainingredient FROM main ORDER BY mainingredient ASC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
if (!$exec_db_browse = mysql_query($sql_db_browse)) {
	echo "<p class=\"error\">" . ERROR_BROWSE ."\n<br>";
	echo mysql_error();
	cs_AddFooter();
	exit();
};
$num_color_rows = cs_CountRowsRecipePage();
cs_PrintBrowseTableParameter("mainingredient");
echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
if ($_GET['offset']>=1) { 
    $prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_PREVIOUS ."</a> - \n";
}
$pages=intval($recipe_number/$_SESSION['max_lines_page']);
if ($recipe_number%$_SESSION['max_lines_page']) {
    $pages++;
}
	for ($i=1;$i<=$pages;$i++) 
	{ 
		$newoffset=$_SESSION['max_lines_page']*($i-1);
		echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">$i</a> \n";
	}
if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) {
    $newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
		echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_NEXT ."</a>\n";
}
cs_AddFooter();
exit();
}
/*
 *
 * End browse sorted by main ingredient
 *
 */
/*
 *
 *	browse sorted by season
 *
 */
if ($_GET['browse'] == 'br_season')
{
if (!isset($_GET['offset'])) {
	$_GET['offset'] = 0;
}
$sql_db_recipe_number = mysql_query("SELECT * FROM main");
$recipe_number = mysql_num_rows($sql_db_recipe_number);
$sql_db_browse = "SELECT id,name,season FROM main ORDER BY season ASC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
if (!$exec_db_browse = mysql_query($sql_db_browse)) {
	echo "<p class=\"error\">" . ERROR_BROWSE ."\n<br>";
	echo mysql_error();
	cs_AddFooter();
	exit();
};
$num_color_rows = cs_CountRowsRecipePage();
cs_PrintBrowseTableParameter("season");
echo "</table>\n";
echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
if ($_GET['offset']>=1) {
    $prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_PREVIOUS ."</a> - \n";
}
$pages=intval($recipe_number/$_SESSION['max_lines_page']);
if ($recipe_number%$_SESSION['max_lines_page']) {
    $pages++;
}
for ($i=1;$i<=$pages;$i++) { 
    $newoffset=$_SESSION['max_lines_page']*($i-1);
		echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">$i</a> \n";
}
if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) {
    $newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
		echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_NEXT ."</a>\n";
}
cs_AddFooter();
exit();
}
/*
 *
 * End browse sorted by season
 *
 */
/*
 *
 *	browse sorted by cooking type
 *
 */
if ($_GET['browse'] == 'br_cook')
{
if (!isset($_GET['offset'])) {
	$_GET['offset'] = 0;
}
$sql_db_recipe_number = mysql_query("SELECT * FROM main");
$recipe_number = mysql_num_rows($sql_db_recipe_number);
$sql_db_browse = "SELECT id,name,kind FROM main ORDER BY kind ASC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
if (!$exec_db_browse = mysql_query($sql_db_browse)) {
	echo "<p class=\"error\">" . ERROR_BROWSE ."\n<br>";
	echo mysql_error();
	cs_AddFooter();
	exit();
};
$num_color_rows = cs_CountRowsRecipePage();
cs_PrintBrowseTableParameter("kind");
echo "</table>\n";
echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
if ($_GET['offset']>=1) { 
    $prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_PREVIOUS ."</a> - \n";
}
$pages=intval($recipe_number/$_SESSION['max_lines_page']);
if ($recipe_number%$_SESSION['max_lines_page']) {
    $pages++;
}
for ($i=1;$i<=$pages;$i++) { 
    $newoffset=$_SESSION['max_lines_page']*($i-1);
		echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">$i</a> \n";
}
if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) {
    $newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
			echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_NEXT ."</a>\n";
}
cs_AddFooter();
exit();
}
/*
 *
 * End browse sorted by kind of cooking
 *
 */
/*
 *
 *	browse sorted by difficult, from easiest to most difficult
 *
 */
if ($_GET['browse'] == 'br_easy')
{
if (!isset($_GET['offset'])) {
	$_GET['offset'] = 0;
}
$sql_db_recipe_number = mysql_query("SELECT * FROM main");
$recipe_number = mysql_num_rows($sql_db_recipe_number);
$sql_db_browse = "SELECT id,name,difficulty FROM main ORDER BY difficulty ASC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
if (!$exec_db_browse = mysql_query($sql_db_browse)) {
	echo "<p class=\"error\">" . ERROR_BROWSE ."\n<br>";
	echo mysql_error();
	cs_AddFooter();
	exit();
};
$num_color_rows = cs_CountRowsRecipePage();
cs_PrintBrowseTableDifficulty();
echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
if ($_GET['offset']>=1) { 
    $prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_PREVIOUS ."</a> - \n";
}
$pages=intval($recipe_number/$_SESSION['max_lines_page']);
if ($recipe_number%$_SESSION['max_lines_page']) {
    $pages++;
}
for ($i=1;$i<=$pages;$i++) { 
    $newoffset=$_SESSION['max_lines_page']*($i-1);
		echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">$i</a> \n";
}
if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) {
    $newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
		echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_NEXT ."</a>\n";
}
cs_AddFooter();
exit();
}
/*
 *
 * End browse sorted by difficult, from easiest to most difficult
 *
 */
/*
 *
 *	browse sorted by difficult, from most difficult to easiest
 *
 */
if ($_GET['browse'] == 'br_difficult')
{
if (!isset($_GET['offset'])) {
	$_GET['offset'] = 0;
}
$sql_db_recipe_number = mysql_query("SELECT * FROM main");
$recipe_number = mysql_num_rows($sql_db_recipe_number);
$sql_db_browse = "SELECT id,name,difficulty FROM main ORDER BY difficulty DESC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
if (!$exec_db_browse = mysql_query($sql_db_browse)) {
	echo "<p class=\"error\">" . ERROR_BROWSE ."\n<br>";
	echo mysql_error();
	cs_AddFooter();
	exit();
};
$num_color_rows = cs_CountRowsRecipePage();
cs_PrintBrowseTableDifficulty();
echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
if ($_GET['offset']>=1) 
{
    $prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_PREVIOUS ."</a> - \n";
}
$pages=intval($recipe_number/$_SESSION['max_lines_page']);
if ($recipe_number%$_SESSION['max_lines_page']) {
    $pages++;
}
for ($i=1;$i<=$pages;$i++) {
    $newoffset=$_SESSION['max_lines_page']*($i-1);
		echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">$i</a> \n";
}
if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) {
    $newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
			echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_NEXT ."</a>\n";
}
cs_AddFooter();
exit();
}
/*
 *
 * End browse sorted by difficult, from most difficult to easiest
 *
 */
/*
 *
 *	browse sorted by origin
 *
 */
if ($_GET['browse'] == 'br_origin')
{
if (!isset($_GET['offset'])) {
	$_GET['offset'] = 0;
}
$sql_db_recipe_number = mysql_query("SELECT * FROM main");
$recipe_number = mysql_num_rows($sql_db_recipe_number);
$sql_db_browse = "SELECT id,name,origin FROM main ORDER BY origin ASC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
if (!$exec_db_browse = mysql_query($sql_db_browse)) {
	echo "<p class=\"error\">" . ERROR_BROWSE ."\n<br>";
	echo mysql_error();
	cs_AddFooter();
	exit();
};
$num_color_rows = cs_CountRowsRecipePage();
cs_PrintBrowseTableParameter("origin");
echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
if ($_GET['offset']>=1) { 
    $prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
			echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_PREVIOUS ."</a> - \n";
}
$pages=intval($recipe_number/$_SESSION['max_lines_page']);
if ($recipe_number%$_SESSION['max_lines_page']) {
    $pages++;
}
for ($i=1;$i<=$pages;$i++) { 
    $newoffset=$_SESSION['max_lines_page']*($i-1);
		echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">$i</a> \n";
}
if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) {
    $newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
		echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_NEXT ."</a>\n";
}
cs_AddFooter();
exit();
}
/*
 *
 * End browse sorted by origin
 *
 */
/*
 *
 *	browse sorted by letter
 *
 */
if ($_GET['browse'] == 'br_letter')
{
	if (!isset($_GET['offset'])) {
		$_GET['offset'] = 0;
	}
	$sql_db_recipe_number = mysql_query("SELECT * FROM main");
	$recipe_number = mysql_num_rows($sql_db_recipe_number);
	$sql_db_browse_letter = "SELECT id,name FROM main WHERE name LIKE '{$_GET['letter']}%' ORDER BY name ASC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
	if (!$exec_db_browse = mysql_query($sql_db_browse_letter)) {
		echo "<p class=\"error\">" . ERROR_BROWSE ."\n<br>";
		echo mysql_error();
		cs_AddFooter();
		exit();
	};
	cs_AlphaLinks();
	$num_letter = mysql_num_rows($exec_db_browse);
	if ($num_letter == "0")
	{
		if (!is_numeric($_GET['letter']))
		{
		echo "<p class=\"error\">" . MSG_RECIPES_INITIAL . " {$_GET['letter']}\n";
		cs_AddFooter();
		exit();
		}
		echo "<p class=\"error\">" . MSG_RECIPES_INITIAL . " {$_GET['letter']}\n";
		cs_AddFooter();
		exit();

	}
	$num_color_rows = cs_CountRowsRecipePage();
	cs_PrintBrowseTable();
	echo "<p>" . MSG_AVAILABLE_PAGES .": \n";
	if ($_GET['offset']>=1) 
	{ 
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
		echo "<p align=center><a href=\"browse.php?browse={$_GET['browse']}&offset=$prevoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_PREVIOUS ."</a> - \n";
	}
$pages=intval($recipe_number/$_SESSION['max_lines_page']);
if ($recipe_number%$_SESSION['max_lines_page']) {
    $pages++;
}
for ($i=1;$i<=$pages;$i++) { 
    $newoffset=$_SESSION['max_lines_page']*($i-1);
		echo "<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">$i</a> \n";
}
if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) {
    $newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
		echo "&nbsp;-&nbsp;<a href=\"browse.php?browse={$_GET['browse']}&offset=$newoffset";if ($trans_sid == 0){ echo "&" . SID;} echo "\">" . MSG_NEXT ."</a>\n";
}
}
/*
 *
 * End browse sorted by letter
 *
 */
cs_AddFooter();
?>

