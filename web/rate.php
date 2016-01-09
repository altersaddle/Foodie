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
cs_DestroyAdmin();
cs_AddHeader();
if (isset($_POST['action']))
{
	if ($_POST['action'] == "v_rate")
	{
		echo "<h2>" . MSG_RATE_TITLE . "</h2>\n";
		echo "<p>" . MSG_RATE_VOTE . " {$_SESSION['recipe_name']}\n";
		echo "<form method=\"post\" action=\"rate.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
		echo "<p>Cast your vote:<br>\n<select name=\"vote\" value=\"\">\n<option value=\"1\">1 - " . MSG_RATE_POISON . "</option>\n<option value=\"2\">2 - " . MSG_RATE_VERYBAD . "</option>\n<option value=\"3\">3 - " . MSG_RATE_BAD . "</option>\n<option value=\"4\">4 - " . MSG_RATE_NOTSOBAD . "</option>\n<option value=\"5\">5 - " . MSG_RATE_AVERAGE . "</option>\n<option value=\"6\">6 - " . MSG_RATE_QUITEGOOD . "</option>\n<option value=\"7\">7 -" . MSG_RATE_GOOD . "</option>\n<option value=\"8\">8 - " . MSG_RATE_VERYGOOD . "</option>\n<option value=\"9\">9 - " . MSG_RATE_EXCELLENT . "</option>\n<option value=\"10\">10 - " . MSG_RATE_PERFECTION . "</option>\n</select>\n<br><input type=\"hidden\" name=\"action\" value=\"v_voted\">\n<input type=\"submit\" value=\"" . BTN_RATE_THIS . "\">\n</form>\n";
		cs_AddFooter();
		exit();
	}
	if ($_POST['action'] == "v_voted")
	{
		echo "<h2>{$_SESSION['recipe_name']} " . MSG_RATE_RATED . "!</h2>\n";
		require(dirname(__FILE__)."/includes/db_connection.inc.php");
		//Register vote into database
		$sql_insert_vote = "INSERT INTO rating (id, vote) VALUES ('{$_SESSION['recipe_id']}', '{$_POST['vote']}')";
		if (!$exec_insert_vote = mysql_query($sql_insert_vote))
		{
			echo "<p class=\"error\">" . ERROR_RATE_REGISTERING . " {$_SESSION['recipe_name']}<br>" . mysql_error();
			echo "<p><a href=\"recipe.php?recipe={$_SESSION['recipe_id']}"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">" . MSG_BACK . "</a>\n";
			unset($_SESSION['recipe_name']);
			unset($_SESSION['recipe_id']);
			cs_AddFooter();
			exit();
		}
		echo "<p>" . MSG_RATE_YOURVOTE . ": {$_POST['vote']} " . MSG_RATE_REGISTERED . " {$_SESSION['recipe_name']}\n";
		//Counts votes into database and displays number of votes 
		$sql_count_votes = "SELECT vote FROM rating WHERE id = '{$_SESSION['recipe_id']}'";
		if (!$exec_count_votes = mysql_query($sql_count_votes))
		{
			echo "<p class=\"error\">" . ERROR_RATE_COUNT . " {$_SESSION['recipe_name']}<br>" . mysql_error();
			echo "<p><a href=\"recipe.php?recipe={$_SESSION['recipe_id']}"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">" . MSG_BACK . "</a>\n";
			unset($_SESSION['recipe_name']);
			unset($_SESSION['recipe_id']);
			cs_AddFooter();
			exit();
		}
		$num_votes = mysql_num_rows($exec_count_votes);
		echo "<p>" . MSG_RATE_GOTVOTED . " {$_SESSION['recipe_name']}: $num_votes.\n";
		//Calculate average vote
		$sum_votes = 0;
		while ($rate_data = mysql_fetch_object($exec_count_votes))
		{
			$sum_votes = $sum_votes + $rate_data->vote;
		}
		$avg_vote = $sum_votes / $num_votes;
		echo "<p>" . MSG_RATE_AVGVOTE . " {$_SESSION['recipe_name']}: $avg_vote\n";
		echo "<p><a href=\"recipe.php?recipe={$_SESSION['recipe_id']}"; if ($trans_sid == 0) { echo "&" . SID; } echo "\">" . MSG_BACK . "</a>\n";
		unset($_SESSION['recipe_name']);
		unset($_SESSION['recipe_id']);
		cs_AddFooter();
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
?>
