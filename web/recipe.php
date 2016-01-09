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
if (isset($_SESSION['locale'])) {
  require_once(dirname(__FILE__)."/lang/".$_SESSION['locale'].".php");
  require(dirname(__FILE__)."/crisoftlib.php");
}
else {
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
//read version.php and compare version number to $_SESSION variable
require_once(dirname(__FILE__)."/lang/".$_SESSION['locale'].".php");
//destroy admin session variables if exist
require(dirname(__FILE__)."/crisoftlib.php");
cs_DestroyAdmin();
}
$trans_sid = cs_IsTransSid();
cs_DestroyAdmin();
require(dirname(__FILE__)."/includes/db_connection.inc.php");
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
cs_AddHeader();
$sql_recipe = "SELECT * FROM main WHERE id = '{$_GET['recipe']}'";
$_SESSION['recipe_id'] = $_GET['recipe'];
if (!$exec_recipe = mysql_query($sql_recipe)) {
	echo "<p>" . ERROR_RECIPE_RETRIEVE ."<br>\n";
	echo mysql_error();
	cs_AddFooter();
	exit();
}
cs_PrintRecipeData();
//Counts votes into database and displays number of votes 
$sql_count_votes = "SELECT vote FROM rating WHERE id = '{$_SESSION['recipe_id']}'";
if (!$exec_count_votes = mysql_query($sql_count_votes))
{
	echo "<p class=\"error\">" . ERROR_COUNT_VOTES . " {$_SESSION['recipe_name']}<br>" . mysql_error();
	unset($_SESSION['recipe_id']);
	unset($_SESSION['recipe_name']);
	cs_AddFooter();
	exit();
}
$num_votes = mysql_num_rows($exec_count_votes);
//Calculate average vote
if ($num_votes >= 1)
{
$sum_votes = 0;
while ($rate_data = mysql_fetch_object($exec_count_votes))
{
	$sum_votes = $sum_votes + $rate_data->vote;
}
$avg_vote = $sum_votes / $num_votes;
echo "<table><tr><td><p>" . MSG_RECIPE_VOTES_TOT . " $num_votes " . MSG_RECIPE_VOTES_AVG . ": $avg_vote\n</td><td>\n";
echo "<form method=\"post\" action=\"rate.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"v_rate\">\n<input type=\"submit\" value=\"" . BTN_RATE_RECIPE ."\"></form></td><tr></table>\n";
} 
else
{
	echo "<table><tr><td><p>" . MSG_RECIPE_NEVER_RATED . "\n -</td><td>\n";
	echo "<form method=\"post\" action=\"rate.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
	echo "<input type=\"hidden\" name=\"action\" value=\"v_rate\">\n<input type=\"submit\" value=\"" . BTN_RATE_RECIPE ."\"></form></td><tr></table>\n";
}
//Link to mail this recipe page
echo "<table><tr><td>";
echo "<form method=\"post\" action=\"mail.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
echo "<input type=\"submit\" value=\"" . BTN_EMAIL ."\"></form></td>\n";
//Print link to add selected recipe to personal cookbook only if it does
//not exist and referer is not cookbook.php
if (!strstr($_SERVER['HTTP_REFERER'], "cookbook.php"))
{
	$sql_query_cookbook = "SELECT id FROM personal_book WHERE id = '{$_SESSION['recipe_id']}'";
	if (!$exec_query_cookbook = mysql_query($sql_query_cookbook))
	{
		echo "<td><p class=\"error\">" . ERROR_CHECK_COOKBOOK . "</td></tr></table><br>\n" . mysql_error();
		exit();
	}
	$num_cookbook = mysql_num_rows($exec_query_cookbook);
	if (0 == $num_cookbook)
	{
		echo "<td><form method=\"post\" action=\"cookbook.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"cook_add\">\n<input type=\"submit\" value=\"" . BTN_ADD_COOKBOOK . "\"></form></td>\n";
	}
	if (1 == $num_cookbook)
	{
		echo "<td><p>" . MSG_ALREADY_COOKBOOK . "</td>\n";
	}
}
//Print link to pdf version of the recipe 
echo "<td><form method=\"post\" action=\"recipe.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"rec_pdf\">\n<input type=\"submit\" value=\"" . BTN_PDF . "\"></form></td>\n";
echo "<td><form method=\"post\" action=\"recipe.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\" target=\"_blank\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"rec_print\">\n<input type=\"submit\" value=\"" . BTN_PRINT . "\"></form></td>\n";
echo "<td><form method=\"post\" action=\"shoppinglist.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"sl_add\">\n<input type=\"submit\" value=\"" . BTN_ADD_SHOPPING . "\"></form></td>\n</tr></table>\n";
//Export single recipe
echo "<p>" . MSG_EXPORT_ASK .":\n";
echo "<form method=\"post\" action=\"export.php"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">\n";
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
echo "<p><a href=\"{$_SERVER['HTTP_REFERER']}"; if ($trans_sid == 0) { echo "?" . SID; } echo "\">" . MSG_BACK . "</a>\n";
//}
cs_AddFooter();
?>
