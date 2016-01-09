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
cs_DestroyAdmin();
cs_AddHeader();
if (isset($_SESSION['recipe_id']))
{
	unset($_SESSION['recipe_id']);
}
if (isset($_SESSION['recipe_name']))
{
	unset($_SESSION['recipe_name']);
}
echo "<h2>" . MSG_SEARCH_TITLE . "</h2>\n";

if (isset($_POST['action']))
{
	if(empty($_POST['search_text']))
	{
		echo "<p class=\"error\">" . ERROR_INPUT_REQUIRED . "!\n";
		echo "<form method=\"post\" action=\"search.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"search\">\n
		<p>" . MSG_SEARCH_INSERT_STRING . ":<br>\n
		(" . MSG_SEARCH_INSERT_PARTIAL . ")<br>\n
		<input type=\"text\" name=\"search_text\" size=\"80\">\n
		<p>" . MSG_SEARCH_INSERT_FIELD . ":<br>\n
		<select name=\"search_field\">\n
		<option value=\"name\">" . MSG_RECIPE_NAME . "</option>\n
		<option value=\"mainingredient\">" . MSG_RECIPE_MAIN . "</option>\n
		<option value=\"ingredients\">" . MSG_RECIPE_INGREDIENTS . "</option>\n
		<option value=\"description\">" . MSG_RECIPE_DESCRIPTION . "</option>\n
		<option value=\"notes\">" . MSG_RECIPE_NOTES . "</option>\n
		<option value=\"wines\">" . MSG_RECIPE_WINES . "</option>\n
		<option value=\"all\">" . MSG_SEARCH_ALLFIELDS . "</option>\n
		</select>\n
		<p><input type=\"submit\" value=\"" . BTN_SEARCH . "\">\n
		</form>\n";
		cs_AddFooter();
		exit();
	}
	if (eregi("[!|#§+*<>^?£$%&\/\\]", $_POST['search_text']))
	{
		echo "<p class=\"error\">" . MSG_INPUT_FIELD ." <em>{$_POST['search_text']}</em> " . MSG_INPUT_DANGER .".<br>\n";	
		echo "<form method=\"post\" action=\"search.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"search\">\n
		<p>" . MSG_SEARCH_INSERT_STRING . ":<br>\n
		(" . MSG_SEARCH_INSERT_PARTIAL . ")<br>\n
		<input type=\"text\" name=\"search_text\" size=\"80\">\n
		<p>" . MSG_SEARCH_INSERT_FIELD . ":<br>\n
		<select name=\"search_field\">\n
		<option value=\"name\">" . MSG_RECIPE_NAME . "</option>\n
		<option value=\"mainingredient\">" . MSG_RECIPE_MAIN . "</option>\n
		<option value=\"ingredients\">" . MSG_RECIPE_INGREDIENTS . "</option>\n
		<option value=\"description\">" . MSG_RECIPE_DESCRIPTION . "</option>\n
		<option value=\"notes\">" . MSG_RECIPE_NOTES . "</option>\n
		<option value=\"wines\">" . MSG_RECIPE_WINES . "</option>\n
		<option value=\"all\">" . MSG_SEARCH_ALLFIELDS . "</option>\n
		</select>\n
		<p><input type=\"submit\" value=\"" . BTN_SEARCH . "\">\n
		</form>\n";
		cs_AddFooter();
		exit();
	}
	if ($_POST['action'] == "search")
	{
		//Split search_text variable entering it into an array
		//only if contains spaces
		if (strstr($_POST['search_text'], " "))
		{
			$search_terms = explode(" ", $_POST['search_text']);
		}
		//Execute this code only if more than one term was
		//entered
		//Revise this code since it gives a warning for
		//undefined variable with single term searches
		if (@is_array($search_terms))
		{
			if ($_POST['search_field'] == "all")
			{
				echo "<p>" . MSG_SEARCH_STRING . " <strong>{$_POST['search_text']}</strong> " . MSG_SEARCH_FOUND . ":<br>\n";
				foreach ($search_terms as $single_term)
				{
					$sql_multi_search_all = "SELECT * FROM main WHERE name LIKE '$single_term' OR mainingredient LIKE '$single_term' OR ingredients LIKE '$single_term' OR description LIKE '$single_term' OR notes LIKE '$single_term' OR wines LIKE '$single_term' ORDER BY name DESC";
					if (!$exec_multi_search_all = mysql_query($sql_multi_search_all))
					{
						echo "<p class=\"error\">" . ERROR_SEARCH_DATABASE . "<br>\n" . mysql_error();
						cs_AddFooter();
						exit();
					}
					//count results
					$num_hits = mysql_num_rows($exec_multi_search_all);
					//if result == 0
					if ($num_hits == 0)
					{
						echo "<p class=\"error\">" . MSG_SEARCH_NORECIPESFOUND . "</p>\n";
					}
					else
					{
						echo "<p class=\"error\">" . MSG_SEARCH_RECIPESFOUND . ": $num_hits</p>\n";
					}
					
					while ($search_multi_all_item = mysql_fetch_object($exec_multi_search_all))
					{
						echo "<p><a href=\"recipe.php?recipe=$search_multi_all_item->id"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">$search_multi_all_item->name</a>\n";
					}
				}
				cs_AddFooter();
				exit();
			}
			else
			{
				foreach ($search_terms as $single_term)
				{
					//Search on single fields		
					echo "<p>" . MSG_SEARCH_STRING . " <strong>$single_term</strong> " . MSG_SEARCH_FIELD . ":<br>\n";
					//Insert here code
					$sql_multi_search = "SELECT * FROM main WHERE {$_POST['search_field']} LIKE '%$single_term%' ORDER BY name DESC";
					if (!$exec_multi_search = mysql_query($sql_multi_search))
					{
						echo "<p class=\"error\">" . ERROR_SEARCH_DATABASE . "<br>\n" . mysql_error();
						cs_AddFooter();
						exit();
					}
					//count results
					$num_hits = mysql_num_rows($exec_multi_search);
					//if result == 0
					if ($num_hits == 0)
					{
						echo "<p class=\"error\">" . MSG_SEARCH_NORECIPESFOUND . "</p>\n";
					}
					else
					{
						echo "<p class=\"error\">" . MSG_SEARCH_RECIPESFOUND . ": $num_hits</p>\n";
					}

					while ($search_multi_item = mysql_fetch_object($exec_multi_search))
					{
						echo "<p><a href=\"recipe.php?recipe=$search_multi_item->id"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">$search_multi_item->name</a>\n";
					}
				}
				cs_AddFooter();
				exit();
			}
		}
		//Search text into all searchable fields
		if ($_POST['search_field'] == "all")
		{
			$sql_search_all = "SELECT * FROM main WHERE name LIKE '%{$_POST['search_text']}%' OR mainingredient LIKE '%{$_POST['search_text']}%' OR ingredients LIKE '%{$_POST['search_text']}%' OR description LIKE '%{$_POST['search_text']}%' OR notes LIKE '%{$_POST['search_text']}%' OR wines LIKE '%{$_POST['search_text']}%' ORDER BY name DESC";
			if (!$exec_search_all = mysql_query($sql_search_all))
			{
				echo "<p class=\"error\">" . ERROR_SEARCH_DATABASE . "<br>\n" . mysql_error();
				cs_AddFooter();
				exit();
			}
			echo "<p>" . MSG_SEARCH_STRING . " <strong>{$_POST['search_text']}</strong> " . MSG_SEARCH_FOUND . ":\n";
			//count results
			$num_hits = mysql_num_rows($exec_search_all);
			//if result == 0
			if ($num_hits == 0)
			{
				echo "<p class=\"error\">" . MSG_SEARCH_NORECIPESFOUND . "</p>\n";
			}
			else
			{
				echo "<p class=\"error\">" . MSG_SEARCH_RECIPESFOUND . ": $num_hits</p>\n";
			}
			while ($search_all_item = mysql_fetch_object($exec_search_all))
			{
				echo "<p><a href=\"recipe.php?recipe=$search_all_item->id"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">$search_all_item->name</a>\n";
			}
			cs_AddFooter();
			exit();
		}
		//Search on specified field
		$sql_search = "SELECT * FROM main WHERE {$_POST['search_field']} LIKE '%{$_POST['search_text']}%' ORDER BY name DESC";
		if (!$exec_search = mysql_query($sql_search))
		{
			echo "<p class=\"error\">" . ERROR_SEARCH_DATABASE . "<br>\n" . mysql_error();
			cs_AddFooter();
			exit();
		}
		echo "<p>" . MSG_SEARCH_STRING . " <strong>{$_POST['search_text']}</strong> " . MSG_SEARCH_FOUND . ":\n";
		//count results
		$num_hits = mysql_num_rows($exec_search);
		//if result == 0
		if ($num_hits == 0)
		{
			echo "<p class=\"error\">" . MSG_SEARCH_NORECIPESFOUND . "</p>\n";
			}
		else
		{
			echo "<p class=\"error\">" . MSG_SEARCH_RECIPESFOUND . ": $num_hits</p>\n";
		}
		while ($search_item = mysql_fetch_object($exec_search))
		{
			echo "<p><a href=\"recipe.php?recipe=$search_item->id"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">$search_item->name</a>\n";
		}
		cs_AddFooter();
		exit();
	}
	else
	{
		//Display an error message if hidden post variable has
		//been tampered
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "<br>\n";
		cs_AddFooter();
		exit();
	}

}
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
echo "<form method=\"post\" action=\"search.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"search\">\n
<p>" . MSG_SEARCH_INSERT_STRING . ":<br>\n
(" . MSG_SEARCH_INSERT_PARTIAL . ")<br>\n
<input type=\"text\" name=\"search_text\" size=\"80\">\n
<p>" . MSG_SEARCH_INSERT_FIELD . ":<br>\n
<select name=\"search_field\">\n
<option value=\"name\">" . MSG_RECIPE_NAME . "</option>\n
<option value=\"mainingredient\">" . MSG_RECIPE_MAIN . "</option>\n
<option value=\"ingredients\">" . MSG_RECIPE_INGREDIENTS . "</option>\n
<option value=\"description\">" . MSG_RECIPE_DESCRIPTION . "</option>\n
<option value=\"notes\">" . MSG_RECIPE_NOTES . "</option>\n
<option value=\"wines\">" . MSG_RECIPE_WINES . "</option>\n
<option value=\"all\">" . MSG_SEARCH_ALLFIELDS . "</option>\n
</select>\n
<p><input type=\"submit\" value=\"" . BTN_SEARCH . "\">\n
</form>\n";
cs_AddFooter();
?>
