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
require(dirname(__FILE__)."/crisoftricette.php");
require(dirname(__FILE__)."/includes/dbconnect.inc.php");
$trans_sid = cs_IsTransSid();
cs_AddHeader();
cs_CheckLoginAdmin();
echo "<h2>" . MSG_ADMIN . "</h2>\n";
echo "<h3>" . MSG_ADMIN_MENU_RECIPE_MOD . "</h3>\n";
if (isset($_POST['action']))
{
	//if is set to modify let modify recipe as wanted
	if ($_POST['action'] == "modify")
	{
		//Check for empty required fields
		cs_CheckEmptyModifyInput($_POST['name']);
		cs_CheckEmptyModifyInput($_POST['dish']);
		cs_CheckEmptyModifyInput($_POST['mainingredient']);
		cs_CheckEmptyModifyInput($_POST['people']);
		cs_CheckEmptyModifyInput($_POST['time']);
		cs_CheckEmptyModifyInput($_POST['difficulty']);
		cs_CheckEmptyModifyInput($_POST['ingredients']);
		cs_CheckEmptyModifyInput($_POST['description']);

		//Check for dangerous input
		cs_CheckDangerousModifyInput($_POST['dish']);
		cs_CheckDangerousModifyInput($_POST['mainingredient']);
		cs_CheckDangerousModifyInput($_POST['people']);
		cs_CheckDangerousModifyInput($_POST['origin']);
		cs_CheckDangerousModifyInput($_POST['season']);
		cs_CheckDangerousModifyInput($_POST['kind']);
		cs_CheckDangerousModifyInputNoSlash($_POST['time']);
		cs_CheckDangerousModifyInput($_POST['difficulty']);
		cs_CheckDangerousModifyInput($_POST['wines']);
		cs_CheckDangerousModifyInputNoSlash($_POST['ingredients']);
		//Modify recipe
		$sql_modify_recipe = sprintf("UPDATE main SET name='%s', dish='{$_POST['dish']}', mainingredient='{$_POST['mainingredient']}', people='{$_POST['people']}', origin='{$_POST['origin']}', kind='{$_POST['kind']}', season='{$_POST['season']}', time='{$_POST['time']}', difficulty='{$_POST['difficulty']}', ingredients='{$_POST['ingredients']}', description='%s', notes='%s', wines='{$_POST['wines']}', image='{$_POST['image']}', video='{$_POST['video']}' WHERE id = '{$_POST['id']}'",
			mysqli_real_escape_string($dbconnect, $_POST['name']),
 			mysqli_real_escape_string($dbconnect, $_POST['description']),
			mysqli_real_escape_string($dbconnect, $_POST['notes'])
			);
echo "<!-- " . $sql_modify_recipe . " -->";
echo "<!-- " . $_POST['name'] . " -->";
		if (!$exec_modify_recipe = mysqli_query($dbconnect, $sql_modify_recipe))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_MODIFY_UNABLE . " {$_POST['name']}<br>\n" . mysqli_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit(); 
		}
		echo "<p>{$_POST['name']} " . MSG_ADMIN_MODIFY_SUCCESS . "\n";
		//Print modified recipe
		$sql_recipe = "SELECT * FROM main WHERE id = '{$_POST['id']}'";
		if (!$exec_recipe = mysqli_query($dbconnect, $sql_recipe)) 
		{
			echo "<p>" . ERROR_RECIPE_RETRIEVE  ."<br>\n" . mysqli_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		cs_PrintRecipeData();
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	} else
	{
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
}


//If is set GET recipe variable display selected recipe
if (isset($_GET['recipe']))
{
	$sql_modify_recipe = "SELECT * FROM main WHERE id = '{$_GET['recipe']}'";
	if (!$exec_modify_recipe = mysqli_query($dbconnect, $sql_modify_recipe))
	{
		echo "<p class=\"error\">" . ERROR_RECIPE_RETRIEVE . "<br>\n" . mysqli_error();
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	while ($recipe_data = mysqli_fetch_object($exec_modify_recipe))
	{
		//query database for dish types, difficulty grades and cooking types
 		$dish_number = mysqli_query($dbconnect, "SELECT * FROM dish");
		$difficulty_number = mysqli_query($dbconnect, "SELECT * FROM difficulty");
		$cooking_number = mysqli_query($dbconnect, "SELECT * FROM cooking");
		//Print the form
		echo "<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"modify\">\n
		<input type=\"hidden\" name=\"id\" value=\"$recipe_data->id\">\n
		<p>" . MSG_RECIPE_NAME . ": <input type=\"text\" size=\"50\" name=\"name\" value=\"$recipe_data->name\">\n
		<p>" . MSG_RECIPE_SERVING . ": <select name=\"dish\"><option value=\"$recipe_data->dish\">$recipe_data->dish</option>\n";
		while ($data_dish=mysqli_fetch_object($dish_number)) 
		{
			if ($data_dish->dish != $recipe_data->dish)
			{
				echo "<option value=\"$data_dish->dish\">$data_dish->dish</option>\n";
			}
		}
		echo "</select>
		<p>" . MSG_RECIPE_MAIN . ": <input type=\"text\" size=\"30\" name=\"mainingredient\" value=\"$recipe_data->mainingredient\">\n
		<p>" . MSG_RECIPE_PEOPLE . ": <input type=\"text\" size=\"30\" name=\"people\" value=\"$recipe_data->people\">\n
		<p>" . MSG_RECIPE_ORIGIN . ": <input type=\"text\" size=\"30\" name=\"origin\" value=\"$recipe_data->origin\">\n
		<p>" . MSG_RECIPE_COOKING . ":<select name=kind><option value=\"$recipe_data->kind\">$recipe_data->kind</option>\n";
		while ($data_cook=mysqli_fetch_object($cooking_number)) {
			if ($data_cook->type != $recipe_data->kind)
			{
				echo "<option value=\"$data_cook->type\">$data_cook->type</option>\n";
			}
		}
		echo "</select>\n
		<p>" . MSG_RECIPE_SEASON . ": <input type=\"text\" size=\"30\" name=\"season\" value=\"$recipe_data->season\">\n
		<p>" . MSG_RECIPE_TIME . ": <input type=\"text\" size=\"10\" name=\"time\" value=\"$recipe_data->time\">\n
		<p>" . MSG_RECIPE_DIFFICULTY . ": <select name=\"difficulty\">\n";
		if ($recipe_data->difficulty == "-")
		{
			echo "<option value=\"$recipe_data->difficulty\">" . MSG_NOT_SPECIFIED . "</option>\n";
		}
		else {
			echo "<option value=\"$recipe_data->difficulty\">$recipe_data->difficulty</option>\n";
		}
		while ($data_diff=mysqli_fetch_object($difficulty_number)) {
			if ($data_diff->difficulty != $recipe_data->difficulty)
			{
				echo "<option value=\"$data_diff->difficulty\">$data_diff->difficulty</option>\n";
			}
		}
		if ($recipe_data->difficulty != "-")
		{
			echo "<option value=\"-\">" . MSG_NOT_SPECIFIED . "</option>\n";
		}
		echo "</select>\n
		<p>" . MSG_RECIPE_INGREDIENTS . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"ingredients\">$recipe_data->ingredients</textarea>\n
		<p>" . MSG_RECIPE_DESCRIPTION . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"description\">$recipe_data->description</textarea>\n
		<p>" . MSG_RECIPE_NOTES . ": <textarea cols=\"60\" rows=\"10\" wrap=\"virtual\" name=\"notes\">$recipe_data->notes</textarea>\n
		<p>" . MSG_RECIPE_WINES . ": <input type=\"text\" size=\"30\" name=\"wines\" value=\"$recipe_data->wines\">\n
		<p>" . MSG_ADMIN_MODIFY_IMAGE . ": <input type=\"text\" size=\"30\" name=\"image\" value=\"$recipe_data->image\">\n
		<p>" . MSG_ADMIN_MODIFY_VIDEO . ": <input type=\"text\" size=\"30\" name=\"video\" value=\"$recipe_data->video\">\n
		<p><input type=\"submit\" value=\"" . BTN_ADMIN_MODIFY_RECIPE . "\">\n
		";
	}
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}

echo "<p>" . MSG_ADMIN_MODIFY_SELECT . ":\n";
// Print browse list
if (!isset($_GET['offset'])) {
	$_GET['offset'] = 0;
}
if (!isset($_GET['letter'])) {
	$_GET['letter'] = "A";
}
//Count recipes into database
$sql_db_recipe_number = mysqli_query($dbconnect, "SELECT * FROM main");
$recipe_number = mysqli_num_rows($sql_db_recipe_number);
//Retrieve recipe names and ID's
$sql_db_browse_letter = "SELECT id,name FROM main WHERE name LIKE '{$_GET['letter']}%' ORDER BY name ASC LIMIT {$_GET['offset']},{$_SESSION['max_lines_page']}";
if (!$exec_db_browse = mysqli_query($dbconnect, $sql_db_browse_letter)) {
	echo "<p class=\"error\">" . ERROR_BROWSE . "\n<br>" . mysqli_error();
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
};
foodie_AlphaLinks("admin_modify.php?");
//Count recipes in query, if == 0 print that no recipes are
//available
$num_letter = mysqli_num_rows($exec_db_browse);
if ($num_letter == "0")
{
	if (!is_numeric($_GET['letter']))
	{
	echo "<p class=\"error\">" . ERROR_ADMIN_DELETE_LETTER . " {$_GET['letter']}\n";
	//Fast logout from admin area
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
	}
	echo "<p class=\"error\">" . ERROR_ADMIN_DELETE_LETTER . " {$_GET['letter']}\n";
	//Fast logout from admin area
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
$num_color_rows = cs_CountRowsRecipePage();
cs_PrintModifyTable();
echo "<p>" . MSG_AVAILABLE_PAGES . "Available pages: \n";
if ($_GET['offset']>=1) 
{ // bypass PREV link if offset is 0
	$prevoffset=$_GET['offset'] - $_SESSION['max_lines_page'];
	echo "<p align=center><a href=\"admin_modify.php?&letter={$_GET['letter']}&offset=$prevoffset"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">" . MSG_PREVIOUS . "</a> - \n";
}
// calculate number of pages needing links
$pages=intval($recipe_number/$_SESSION['max_lines_page']);
// $pages now contains int of pages needed unless there is a remainder from division
if ($recipe_number%$_SESSION['max_lines_page']) {
    // has remainder so add one page
    $pages++;
}
for ($i=1;$i<=$pages;$i++) { // loop thru
    $newoffset=$_SESSION['max_lines_page']*($i-1);
    echo "<a href=\"admin_modify.php?letter={$_GET['letter']}&offset=$newoffset"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">$i</a> \n";
}
// check to see if last page
if (!(($_GET['offset']/$_SESSION['max_lines_page'])==$pages) && $pages!=1) {
    // not last page so give NEXT link
	$newoffset=$_GET['offset']+$_SESSION['max_lines_page'];
	echo "&nbsp;-&nbsp;<a href=\"admin_modify.php?letter={$_GET['letter']}&offset=$newoffset"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">" . MSG_NEXT . "</a>\n";
}
//Fast logout from admin area
cs_AdminFastLogout();
cs_AddFooter();
?>
