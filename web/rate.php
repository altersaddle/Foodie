<?php
/*
***************************************************************************
* Foodie is a GPL licensed free software web application written
* and copyright 2016 by Malcolm Walker, malcolm@ipatch.ca
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* License terms can be read in COPYING file included in this package.
* If this file is missing you can obtain license terms through WWW
* pointing your web browser at http://www.gnu.org or http:///www.fsf.org
****************************************************************************
*/
session_name("foodie");
session_start();
require(dirname(__FILE__)."/config/foodie.ini.php");

if (!isset($_SESSION['locale'])) {
  $_SESSION['locale'] = $setting_locale;  
}
require_once(dirname(__FILE__)."/lang/".$_SESSION['locale'].".php");
require(dirname(__FILE__)."/foodielib.php");
require(dirname(__FILE__)."/includes/dbconnect.inc.php");

foodie_Begin();
foodie_Header();
if (isset($_POST['action']) && isset($_POST['recipe_id']))
{
    $recipe_id = $_POST['recipe_id'];
    $recipe_name = '';

    $stmt = $dbconnect->prepare("SELECT name FROM main WHERE id = ?");
    $stmt->bind_param('s', $recipe_id);
    $stmt->execute();
    if ($result = $stmt->get_result()) {
        $row = $result->fetch_object();
        $recipe_name = $result->name;
    }
    $stmt->close();

	if ($_POST['action'] == "v_rate")
	{
		echo "<h2>" . MSG_RATE_TITLE . "</h2>\n";
		echo "<p>" . MSG_RATE_VOTE . " {$recipe_name}\n";
		echo "<form method=\"post\" action=\"rate.php\">\n";
		echo "<p>Cast your vote:<br>\n<select name=\"vote\" value=\"\">\n";
        echo "<option value=\"1\">1 - " . MSG_RATE_POISON . "</option>\n";
        echo "<option value=\"2\">2 - " . MSG_RATE_VERYBAD . "</option>\n";
        echo "<option value=\"3\">3 - " . MSG_RATE_BAD . "</option>\n";
        echo "<option value=\"4\">4 - " . MSG_RATE_NOTSOBAD . "</option>\n";
        echo "<option value=\"5\">5 - " . MSG_RATE_AVERAGE . "</option>\n";
        echo "<option value=\"6\">6 - " . MSG_RATE_QUITEGOOD . "</option>\n";
        echo "<option value=\"7\">7 -" . MSG_RATE_GOOD . "</option>\n";
        echo "<option value=\"8\">8 - " . MSG_RATE_VERYGOOD . "</option>\n";
        echo "<option value=\"9\">9 - " . MSG_RATE_EXCELLENT . "</option>\n";
        echo "<option value=\"10\">10 - " . MSG_RATE_PERFECTION . "</option>\n";
        echo "</select>\n<br><input type=\"hidden\" name=\"action\" value=\"v_voted\">\n<input type=\"submit\" value=\"" . BTN_RATE_THIS . "\">\n</form>\n";
	}
	else if ($_POST['action'] == "v_voted")
	{
		echo "<h2>{$recipe_name} " . MSG_RATE_RATED . "!</h2>\n";

		// $sql_insert_vote = "INSERT INTO rating (id, vote) VALUES ('{$recipe_id}', '{$_POST['vote']}')";
        $stmt = $dbconnect->prepare("INSERT INTO rating (id, vote) VALUES (?, ?)");
        $stmt->bind_param("ss", $recipe_id, $_POST['vote']);
		if (!$stmt->execute())
		{
			echo "<p class=\"error\">" . ERROR_RATE_REGISTERING . " {$recipe_name}<br>" . $dbconnect->error;
			echo "<p><a href=\"recipe.php?recipe={$recipe_id}\">" . MSG_BACK . "</a>\n";
		}
        else {
            echo "<p>" . MSG_RATE_YOURVOTE . ": {$_POST['vote']} " . MSG_RATE_REGISTERED . " {$recipe_name}\n";

		    //Counts votes into database and displays number of votes 
		    $sql_count_votes = "SELECT vote FROM rating WHERE id = '{$recipe_id}'";
            $stmt = $dbconnect->prepare("SELECT count(vote), avg(vote) FROM rating WHERE id = ?");
            $stmt->bind_param("s", $recipe_id);
            $stmt->execute();
		    if (!$exec_count_votes = $stmt->get_result())
		    {
			    echo "<p class=\"error\">" . ERROR_RATE_COUNT . " {$recipe_name}<br>" . $dbconnect->error;
		    }
            else {
                $row = $exec_count_votes->fetch_row();
		        $num_votes = $row[0];
		        echo "<p>" . MSG_RATE_GOTVOTED . " $recipe_name: $num_votes.\n";
		        $avg_vote = $row[1];
		        echo "<p>" . MSG_RATE_AVGVOTE . " $recipe_name: $avg_vote\n";
            }
            $stmt->close();
        }
        $stmt->close();
		
        echo "<p><a href=\"recipe.php?recipe={$recipe_id}\">" . MSG_BACK . "</a>\n";
	}
	else {
		//Display an error message if hidden post variable has
		//been tampered
		echo "<p class=\"error\">" . ERROR_UNEXPECTED . "<br>\n";
	}
}
foodie_Footer();
?>
