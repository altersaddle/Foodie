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

if (isset($_POST['action']))
{
	if ($_POST['action'] == "rec_pdf")
	{
		/*
		 *   PDF output with phppdf
		 *
		 */
		$sql_check_image = "SELECT image FROM main WHERE id = '{$_SESSION['recipe_id']}'";
		if (!$exec_check_image = mysql_query($sql_check_image)) 
		{
			cs_AddHeader();
			echo "<p>" . MSG_RECIPE_NO_RETRIEVE ."<br>\n" . mysql_error();
			cs_AddFooter();
			exit();
		}
		while ($row = mysql_fetch_row($exec_check_image))
		{
			$image = $row[0];
		}
		//PDF output only with image
		if (!empty($image))
		{
			define('FPDF_FONTPATH',dirname(__FILE__)."/font/");
			require(dirname(__FILE__)."/includes/fpdf.php");
			$sql_recipe = "SELECT * FROM main WHERE id = '{$_SESSION['recipe_id']}'";
			if (!$exec_recipe = mysql_query($sql_recipe)) 
			{
				cs_AddHeader();
				echo "<p>" . MSG_RECIPE_NO_RETRIEVE ."<br>\n" . mysql_error();
				cs_AddFooter();
				exit();
			}
			$pdf_filename = "{$_SESSION['recipe_id']}.pdf";
			$pagesize = $_SESSION['page_size'];
			$pdf=new FPDF('P','mm',$_SESSION['page_size']);
			$pdf->Open();
			$pdf->AddPage();
			$pdf->SetAutoPageBreak('on');
			$pdf->SetAuthor('CrisoftRicette');
			$pdf->SetFont('Arial','B',16);
			while ($data = mysql_fetch_object($exec_recipe)) 
			{
				$pdf->Cell(0,10,$data->name,1); 
				$pdf->Ln(1);
				$pdf->SetFont('Arial','B',10);
				$pdf->MultiCell(0,25, MSG_RECIPE_SERVING . ': '.$data->dish);
				if (stristr($data->image, '.jpg') OR stristr($data->image, '.jpeg') OR stristr($data->image, '.png'))
				{
					$pdf->Ln(1);
					$pdf->Image('images/'.$data->image,10,35,70);
					$pdf->Ln(100);
					$pdf->SetFont('Arial','',10);
					$pdf->MultiCell(0,5, MSG_RECIPE_MAIN .': '.$data->mainingredient);
					$pdf->Ln(1);
					$pdf->MultiCell(0,5, MSG_RECIPE_PEOPLE .': '.$data->people);
					$pdf->Ln(1);
					$pdf->MultiCell(0,5, MSG_RECIPE_ORIGIN .': '.$data->origin);
					$pdf->Ln(1);
					$pdf->MultiCell(0,5, MSG_RECIPE_SEASON .': '.$data->season);
					$pdf->Ln(1);
					$pdf->MultiCell(0,5, MSG_RECIPE_TIME .': '.$data->time);
					$pdf->Ln(1);
					$pdf->MultiCell(0,5, MSG_RECIPE_COOKING .': '.$data->kind);
					$pdf->Ln(1);
					if ($data->difficulty == 1)
					{
						$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': *');
					}
					if ($data->difficulty == 2)
					{
						$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': **');
					}
					if ($data->difficulty == 3)
					{
						$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': ***');
					}
					if ($data->difficulty == 4)
					{
						$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': ****');
					}
					if ($data->difficulty == 5)
					{
						$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': *****');
					}
					if ($data->difficulty == "-")
					{
						$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': ' . MSG_NOT_SPECIFIED );
					}
					$pdf->Ln(1);
					$pdf->MultiCell(0,5, MSG_RECIPE_INGREDIENTS .': '.$data->ingredients);
					$pdf->Ln(1);
					$pdf->MultiCell(0,5, MSG_RECIPE_DESCRIPTION .': '.$data->description);
					$pdf->Ln(1);
					$pdf->Ln(1);
					$pdf->MultiCell(0,5, MSG_RECIPE_WINES .': '.$data->wines);
					$pdf->Ln(1);
					$pdf->MultiCell(0,5, MSG_RECIPE_NOTES .': '.$data->notes);
					$pdf->Ln(20);
					$pdf->SetFont('Arial','I',8);
					$pdf->MultiCell(0,5, MSG_RECIPE_PRINTED . ': '.$_SESSION['software'] . $_SESSION['version']);

					$pdf->Output($pdf_filename, true);
				}
			}
			exit();
		} 
		//Print PDF without image
		define('FPDF_FONTPATH',dirname(__FILE__)."/font/");
		require(dirname(__FILE__)."/includes/fpdf.php");
		$sql_recipe = "SELECT * FROM main WHERE id = '{$_SESSION['recipe_id']}'";
		if (!$exec_recipe = mysql_query($sql_recipe)) 
		{
			cs_AddHeader();
			echo "<p>" . MSG_RECIPE_NO_RETRIEVE ."<br>\n" . mysql_error();
			cs_AddFooter();
			exit();
		}
		$pdf_filename = "{$_SESSION['recipe_id']}.pdf";
		$pagesize = $_SESSION['page_size'];
		$pdf=new FPDF('P','mm',$_SESSION['page_size']);
		$pdf->Open();
		$pdf->AddPage();
		$pdf->SetAutoPageBreak('on');
		$pdf->SetAuthor('CrisoftRicette');
		$pdf->SetFont('Arial','B',16);
		while ($data = mysql_fetch_object($exec_recipe)) 
		{
			$pdf->Cell(0,10,$data->name,1); 
			$pdf->Ln(1);
			$pdf->SetFont('Arial','B',10);
			$pdf->MultiCell(0,25, MSG_RECIPE_SERVING .': '.$data->dish);
			$pdf->Ln(1);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5, MSG_RECIPE_MAIN .': '.$data->mainingredient);
			$pdf->Ln(1);
			$pdf->MultiCell(0,5, MSG_RECIPE_PEOPLE .': '.$data->people);
			$pdf->Ln(1);
			$pdf->MultiCell(0,5, MSG_RECIPE_ORIGIN .': '.$data->origin);
			$pdf->Ln(1);
			$pdf->MultiCell(0,5, MSG_RECIPE_SEASON .': '.$data->season);
			$pdf->Ln(1);
			$pdf->MultiCell(0,5, MSG_RECIPE_TIME .': '.$data->time);
			$pdf->Ln(1);
			$pdf->MultiCell(0,5, MSG_RECIPE_COOKING .': '.$data->kind);
			$pdf->Ln(1);
			if ($data->difficulty == 1)
			{
				$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': *');
			}
			if ($data->difficulty == 2)
			{
				$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': **');
			}
			if ($data->difficulty == 3)
			{
				$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': ***');
			}
			if ($data->difficulty == 4)
			{
				$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': ****');
			}
			if ($data->difficulty == 5)
			{
				$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': *****');
			}
			if ($data->difficulty == "-")
			{
				$pdf->MultiCell(0,5, MSG_RECIPE_DIFFICULTY .': ' . MSG_NOT_SPECIFIED );
			}
			$pdf->Ln(1);
			$pdf->MultiCell(0,5, MSG_RECIPE_INGREDIENTS .': '.$data->ingredients);
			$pdf->Ln(1);
			$pdf->MultiCell(0,5, MSG_RECIPE_DESCRIPTION .': '.$data->description);
			$pdf->Ln(1);
			$pdf->Ln(1);
			$pdf->MultiCell(0,5, MSG_RECIPE_WINES .': '.$data->wines);
			$pdf->Ln(1);
			$pdf->MultiCell(0,5, MSG_RECIPE_NOTES .': '.$data->notes);
			$pdf->Ln(20);
			$pdf->SetFont('Arial','I',8);
			$pdf->MultiCell(0,5, MSG_RECIPE_PRINTED . ': '.$_SESSION['software'] . $_SESSION['version']);
			$pdf->Output($pdf_filename, true);
		}
		exit();	
	}
	//Printer friendly version
	if ($_POST['action'] == "rec_print")
	{
		$sql_recipe = "SELECT * FROM main WHERE id = '{$_SESSION['recipe_id']}'";
		if (!$exec_recipe = mysql_query($sql_recipe)) 
		{
			cs_AddHeader();
			echo "<p>" . MSG_RECIPE_NO_RETRIEVE ."<br>\n" . mysql_error();
			cs_AddFooter();
			exit();
		}
		while ($data = mysql_fetch_object($exec_recipe)) 
		{
			echo "<h2>$data->name</h2>\n";
			if (!empty($data->image)) 
			{
				echo "<div align=center><img src=\"images/$data->image\" alt=\"$data->name\"></div>\n";
			} 
			$_SESSION['recipe_name'] = $data->name;
			echo "<p>" . MSG_RECIPE_SERVING . ": $data->dish\n";
			echo "<br>" . MSG_RECIPE_MAIN . ": $data->mainingredient\n";
			echo "<br>" . MSG_RECIPE_PEOPLE . ": $data->people\n";
			echo "<br>" . MSG_RECIPE_ORIGIN . ": $data->origin\n";
			echo "<br>" . MSG_RECIPE_SEASON . ": $data->season\n";
			echo "<br>" . MSG_RECIPE_COOKING . ": $data->kind\n";
			echo "<br>" . MSG_RECIPE_TIME . ": $data->time\n";
			echo "<br>" . MSG_RECIPE_DIFFICULTY . ": \n";
			for ($i = 1; $i <= $data->difficulty; $i++) 
			{
				echo "*";
			}
			echo "<br>" . MSG_RECIPE_WINES . "Suggested wines: $data->wines\n";
			echo "<br>" . MSG_RECIPE_INGREDIENTS . "Ingredients: ". nl2br($data->ingredients) ."\n";
			echo "<br>" . MSG_RECIPE_DESCRIPTION . "Description: ". nl2br($data->description) ."\n";
			echo "<br>" . MSG_RECIPE_NOTES . ": $data->notes\n";
		}
		echo "<p class=small>" . MSG_RECIPE_PRINTED . " {$_SESSION['software']} {$_SESSION['version']}\n";
		exit();
	}
	else
	{
		//Display an error message if hidden post variable has
		//been tampered
		cs_AddHeader();
		echo "<p class=\"error\">" . ERROR_UNEXPECTED .".<br>\n";
		cs_AddFooter();
		exit();
	}
}
foodie_AddHeader();
$sql_recipe = "SELECT * FROM main WHERE id = '{$_GET['recipe']}'";

if (!$recipequery = $dbconnect->query($sql_recipe)) {
	echo "<p>" . ERROR_RECIPE_RETRIEVE ."<br>\n";
	echo mysql_error();
	foodie_AddFooter();
	exit();
}
$reciperow = $recipequery->fetch_assoc();
$recipename = $reciperow['name'];
foodie_PrintRecipeData($reciperow);
$recipequery->close();
//Counts votes into database and displays number of votes 
$sql_count_votes = "SELECT vote FROM rating WHERE id = '{$_GET['recipe']}'";
if (!$votes_result = $dbconnect->query($sql_count_votes))
{
	echo "<p class=\"error\">" . ERROR_COUNT_VOTES . " {$recipename}<br>" . mysql_error();
	foodie_AddFooter();
	exit();
}
$num_votes = $votes_result->num_rows;
//Calculate average vote
if ($num_votes >= 1)
{
$sum_votes = 0;
while ($rate_data = $votes_result->fetch_object())
{
	$sum_votes = $sum_votes + $rate_data->vote;
}
$avg_vote = $sum_votes / $num_votes;
echo "<table><tr><td><p>" . MSG_RECIPE_VOTES_TOT . " $num_votes " . MSG_RECIPE_VOTES_AVG . ": $avg_vote\n</td><td>\n";
echo "<form method=\"post\" action=\"rate.php\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"v_rate\">\n<input type=\"submit\" value=\"" . BTN_RATE_RECIPE ."\"></form></td><tr></table>\n";
} 
else
{
	echo "<table><tr><td><p>" . MSG_RECIPE_NEVER_RATED . "\n -</td><td>\n";
	echo "<form method=\"post\" action=\"rate.php\">\n";
	echo "<input type=\"hidden\" name=\"action\" value=\"v_rate\">\n<input type=\"submit\" value=\"" . BTN_RATE_RECIPE ."\"></form></td><tr></table>\n";
}
//Link to mail this recipe page
echo "<table><tr><td>";
echo "<form method=\"post\" action=\"mail.php\">\n";
echo "<input type=\"submit\" value=\"" . BTN_EMAIL ."\"></form></td>\n";
//Print link to add selected recipe to personal cookbook only if it does
//not exist and referer is not cookbook.php
if (!strstr($_SERVER['HTTP_REFERER'], "cookbook.php"))
{
	$sql_query_cookbook = "SELECT id FROM personal_book WHERE id = '{$_GET['recipe']}'";
	if (!$cookbook_result = $dbconnect->query($sql_query_cookbook))
	{
		echo "<td><p class=\"error\">" . ERROR_CHECK_COOKBOOK . "</td></tr></table><br>\n" . mysql_error();
		exit();
	}
	$num_cookbook = $cookbook_result->num_rows;
	if (0 == $num_cookbook)
	{
		echo "<td><form method=\"post\" action=\"cookbook.php\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"cook_add\">\n<input type=\"submit\" value=\"" . BTN_ADD_COOKBOOK . "\"></form></td>\n";
	}
	else
	{
		echo "<td><p>" . MSG_ALREADY_COOKBOOK . "</td>\n";
	}
    $cookbook_result->close();
}
//Print link to pdf version of the recipe 
echo "<td><form method=\"post\" action=\"recipe.php\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"rec_pdf\">\n<input type=\"submit\" value=\"" . BTN_PDF . "\"></form></td>\n";
echo "<td><form method=\"post\" action=\"recipe.php\" target=\"_blank\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"rec_print\">\n<input type=\"submit\" value=\"" . BTN_PRINT . "\"></form></td>\n";
echo "<td><form method=\"post\" action=\"shoppinglist.php\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"sl_add\">\n<input type=\"submit\" value=\"" . BTN_ADD_SHOPPING . "\"></form></td>\n</tr></table>\n";
//Export single recipe
echo "<p>" . MSG_EXPORT_ASK .":\n";
echo "<form method=\"post\" action=\"export.php\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"export_ok\">\n
<input type=\"hidden\" name=\"mode\" value=\"single\">\n
<select name=\"export_type\">\n";
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
echo "</select>\n<input type=\"submit\" value=\"" . MSG_EXPORT . "\"></form></td>\n";
//Go back
echo "<p><a href=\"{$_SERVER['HTTP_REFERER']}\">" . MSG_BACK . "</a>\n";
//}
foodie_AddFooter();
?>
