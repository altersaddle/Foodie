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
//If referer script is recipe.php
if (strstr($_SERVER['HTTP_REFERER'], '/recipe.php'))
{
	echo "<h2>" . MSG_ADMIN . "</h2>\n";
	echo "<h3>" . MSG_ADMIN_MENU_MULTIMEDIA . "</h3>\n";
	//Print the login form
	echo "<p class=centerwarn>" . MSG_ADMIN_USERPASS_REQUEST . ":\n";
	echo "<form method=\"post\" action=\"admin_mmedia.php";
	if ($trans_sid == 0)
	{
		echo "?" . SID;
	}
	echo "\">";
	echo "<div align=center><table border=0>\n
	<tr><td><p class=centermsg>" . MSG_ADMIN_USER . ": </td><td><input type=text width=20 name=\"admin_user\"></td></tr>\n
	<tr><td><p class=centermsg>" . MSG_ADMIN_PASS . ": </td><td><input type=password width=20 name=\"admin_pass\"></td></tr>\n
	<input type=\"hidden\" name=\"login\" value=\"ask\">\n
	<tr><td colspan=2 align=center><input type=submit value=\"" . MSG_ADMIN_LOGIN . "\"></form></td></tr></table>\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//if referer is admin_mmedia.php
if (strstr($_SERVER['HTTP_REFERER'], '/admin_mmedia.php'))
{
	if (isset($_POST['login']) && ($_POST['login'] == "ask"))
	{
		echo "<h2>" . MSG_ADMIN . "</h2>\n";
		echo "<h3>" . MSG_ADMIN_MENU_MULTIMEDIA . "</h3>\n";
		//check admin login data
		if (empty($_POST['admin_user'])) 
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_INVALID_USERNAME . "!\n";
			cs_AddFooter();
			exit();
		}
		if (empty($_POST['admin_pass'])) 
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_INVALID_PASSWORD . "!\n";
			cs_AddFooter();
			exit();
		}
		//Regex to check username/password fields - escaping dangerous
		//characters
		cs_CheckDangerousInput($_POST['admin_user']);
		cs_CheckDangerousInput($_POST['admin_pass']);
		//Checking for valid admin user/password pair only if user/password pair
		//have passed above checks
		$sql_stored_user = "SELECT * FROM admin";
		if (!$exec_stored_user = mysql_query($sql_stored_user)) 
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_CHECK_DB . "!\n";
			cs_AddFooter();
			exit();
		}
		while ($auth_data = mysql_fetch_object($exec_stored_user)) 
		{
			if ($auth_data->user == $_POST['admin_user']) 
			{
				$_SESSION['admin_user'] = $_POST['admin_user'];
			} else 
			{
				echo "<p class=centerwarn>" . ERROR_ADMIN_AUTHFAIL . "\n";
				cs_AddFooter();
				exit();
			}
			if ($auth_data->password == $_POST['admin_pass']) 
			{
				$_SESSION['admin_pass'] = $_POST['admin_pass'];
			} else 
			{
				echo "<p class=centerwarn>" . ERROR_ADMIN_AUTHFAIL . "\n";
				cs_AddFooter();
				exit();
			}
		}
		//query database for image availability
		echo "<h3>{$_SESSION['recipe_name']}</h3>\n";
		$sql_image = "SELECT image FROM main WHERE id = '{$_SESSION['recipe_id']}'";
		if (!$exec_image = mysql_query($sql_image))
		{
			echo "<p class=\"error\">" . ERROR_BROWSE . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		while ($image_data = mysql_fetch_object($exec_image))
		{
			if (empty($image_data->image))
			{
				echo "<p>" . MSG_INSERT_IMAGE . ":\n";
				echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"admin_mmedia.php";
				if ($trans_sid == 0)
				{
					echo "?" . SID;
				}
				echo "\">\n";
				echo "<input type=\"hidden\" name=\"action\" value=\"insert_image\">\n<input type=\"file\" name=\"recipe_image\">\n<p><input type=\"submit\" value=\"" . BTN_MMEDIA_INSERT_IMAGE . "\">\n</form>\n";
			} else
			{
				echo "<p>" . MSG_ADMIN_MULTIMEDIA_IMAGE_AVAILABLE . "\n";
			}
		}
		//query database for video availability
		$sql_video = "SELECT video FROM main WHERE id = '{$_SESSION['recipe_id']}'";
		if (!$exec_video = mysql_query($sql_video))
		{
			echo "<p class=\"error\">" . ERROR_BROWSE . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		while ($video_data = mysql_fetch_object($exec_video))
		{
			if (empty($image_data->video))
			{
				echo "<p>" . MSG_INSERT_VIDEOCLIP . ":\n";
				echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"admin_mmedia.php";
				if ($trans_sid == 0)
				{
					echo "?" . SID;
				}	
				echo "\">\n";
				echo "<input type=\"hidden\" name=\"action\" value=\"insert_video\">\n<input type=\"file\" name=\"recipe_video\">\n<p><input type=\"submit\" value=\"" . BTN_MMEDIA_INSERT_VIDEOCLIP . "\">\n</form>\n";
			} else
			{
				echo "<p>" . MSG_ADMIN_MULTIMEDIA_VIDEO_AVAILABLE . "\n";
			}
		}
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	//insert image
	if (isset($_POST['action']) && ($_POST['action'] == "insert_image"))
	{
		cs_CheckLoginAdmin();
		//Check input file name
		if (eregi("[@!|#§+*<>^?£$%&\/\\]", $_FILES['recipe_image']['name'])) 
		{
			echo "<p class=\"error\">" . ERROR_INVALID_CHAR . "&nbsp;" . ERROR_FILE_IMAGE . "!\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$image_type = array ('.jpg', '.JPG', '.jpeg', '.JPEG','.gif', '.GIF','.tif', '.TIF','.tiff', '.TIFF', '.png', '.PNG', '.bmp', '.BMP'); 
		$image_extension = substr(strrchr($_FILES['recipe_image']['name'], "."), 0);
		if (!in_array("$image_extension", $image_type))
		{
		        echo "<p class=\"error\">" . ERROR_INVALID_IMAGE . "!\n";
		        echo "<p>" . MSG_VALID_FORMAT . ":<br>\n";
	        //Displays content of array $image_type
		        foreach ($image_type as $extension)
			{
				echo "$extension/\n";
			}
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Check for duplicate image file
		$sql_duplicate_image = "SELECT image FROM main where image = '{$_FILES['recipe_image']['name']}'";
		if (!$exec_duplicate_image = mysql_query($sql_duplicate_image))
		{
			echo "<p class=\"error\">" . ERROR_DUPLICATE_IMAGE . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$num_images = mysql_num_rows($exec_duplicate_image);
		if ($num_images >= "1")
		{
			echo "<p class=\"error\">" . ERROR_EXIST_IMAGE . ".\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Extract from environment the script path
		$path = dirname(__FILE__);
		$upload_path = "$path/images";
		$check_name = $_FILES['recipe_image']['name'];
		$upload_error = copy ("{$_FILES['recipe_image']['tmp_name']}", "$upload_path/{$_FILES['recipe_image']['name']}");
		if ($upload_error == 0) 
		{
			echo "<p class=\"error\">" . ERROR_UNEXPECTED . ": " . ERROR_UPLOAD . "!\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Insert data into database
		$sql_add = "UPDATE main SET image = '{$_FILES['recipe_image']['name']}' WHERE id = '{$_SESSION['recipe_id']}'";
		if (!$exec_sql_add = mysql_query($sql_add))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_MMEDIA_IMAGE_ADD . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p>{$_FILES['recipe_image']['name']} " . MSG_ADMIN_MMEDIA_IMAGE_ADDED . " {$_SESSION['recipe_name']}\n";
		echo "<p>" . MSG_ADMIN_MMEDIA_BACK_RECIPE . " <a href=\"recipe.php?recipe={$_SESSION['recipe_id']}";
		if ($trans_sid == 0)
		{
			echo "&" . SID;
		}
		echo "\">{$_SESSION['recipe_name']}</a>\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	//insert video
	if (isset($_POST['action']) && ($_POST['action'] == "insert_video"))
	{
		cs_CheckLoginAdmin();
		//Check input file name
		if (eregi("[@!|#§+*<>^?£$%&\/\\]", $_FILES['recipe_video']['name'])) 
		{
			echo "<p class=\"error\">" . ERROR_INVALID_CHAR . "&nbsp;" . ERROR_FILE_VIDEO . "!\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$video_type = array ('.avi', '.AVI', '.mpeg', '.MPEG','.mpg', '.MPG','.asf', '.ASF','.wmv', '.WMV', '.qt', '.QT', '.qtx', '.QTX'); 
		$video_extension = substr(strrchr($_FILES['recipe_video']['name'], "."), 0);
		if (!in_array("$video_extension", $video_type))
		{
		        echo "<p class=\"error\">" . ERROR_INVALID_VIDEO . "!\n";
		        echo "<p>" . MSG_VALID_FORMAT . ":<br>\n";
	        //Displays content of array $video_type
		        foreach ($video_type as $extension)
			{
				echo "$extension/\n";
			}
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Check for duplicate video file
		$sql_duplicate_video = "SELECT image FROM main where video = '{$_FILES['recipe_video']['name']}'";
		if (!$exec_duplicate_video = mysql_query($sql_duplicate_video))
		{
			echo "<p class=\"error\">" . ERROR_DUPLICATE_VIDEO . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		$num_video = mysql_num_rows($exec_duplicate_video);
		if ($num_video >= "1")
		{
			echo "<p class=\"error\">" . ERROR_EXIST_VIDEO . ".\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Extract from environment the script path
		$path = dirname(__FILE__);
		$upload_path = "$path/video";
		$check_name = $_FILES['recipe_video']['name'];
		$upload_error = copy ("{$_FILES['recipe_video']['tmp_name']}", "$upload_path/{$_FILES['recipe_video']['name']}");
		if ($upload_error == 0) 
		{
			echo "<p class=\"error\">" . ERROR_UNEXPECTED . ": " . ERROR_UPLOAD . "!\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//Insert data into database
		$sql_add = "UPDATE main SET video = '{$_FILES['recipe_video']['name']}' WHERE id = '{$_SESSION['recipe_id']}'";
		if (!$exec_sql_add = mysql_query($sql_add))
		{
			echo "<p class=\"error\">" . ERROR_ADMIN_MMEDIA_VIDEOCLIP_ADD . "<br>\n" . mysql_error();
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		echo "<p>{$_FILES['recipe_video']['name']} " . MSG_ADMIN_MMEDIA_VIDEOCLIP_ADDED . " {$_SESSION['recipe_name']}\n";
		echo "<p>" . MSG_ADMIN_MMEDIA_BACK_RECIPE . " <a href=\"recipe.php?recipe={$_SESSION['recipe_id']}";
		if ($trans_sid == 0)
		{
			echo "&" . SID;
		}
		echo "\">{$_SESSION['recipe_name']}</a>\n";
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}
	//Administrator stuff
	if (isset($_POST['admin']))
	{
		echo "<h2>" . MSG_ADMIN . "</h2>\n";
		echo "<h3>" . MSG_ADMIN_MENU_MULTIMEDIA . "</h3>\n";
		cs_CheckLoginAdmin();
		//print forms to add multimedia stuff
		if ($_POST['admin'] == 'select_mmedia')
		{
			$sql_image = "SELECT * FROM main WHERE id = '{$_POST['recipe_id']}'";
			if (!$exec_image = mysql_query($sql_image))
			{
				echo "<p class=\"error\">" . ERROR_BROWSE . "<br>\n" . mysql_error();
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			while ($image_data = mysql_fetch_object($exec_image))
			{
				echo "<h3>$image_data->name</h3>\n";
				if (empty($image_data->image))
				{
					echo "<p>" . MSG_INSERT_IMAGE . ":\n";
					echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"admin_mmedia.php";
					if ($trans_sid == 0)
					{
						echo "?" . SID;
					}
					echo "\">\n";
					echo "<input type=\"hidden\" name=\"admin\" value=\"insert_image\"><input type=\"hidden\" name=\"recipe_id\" value=\"$image_data->id\"><input type=\"hidden\" name=\"recipe_name\" value=\"$image_data->name\">\n<input type=\"file\" name=\"recipe_image\">\n<p><input type=\"submit\" value=\"" . BTN_MMEDIA_INSERT_IMAGE . "\">\n</form>\n";
				} else
				{
					echo "<p>" . MSG_ADMIN_MULTIMEDIA_IMAGE_AVAILABLE . " {$_POST['recipe_name']}\n";
				}
			}
			//query database for video availability
			$sql_video = "SELECT * FROM main WHERE id = '{$_POST['recipe_id']}'";
			if (!$exec_video = mysql_query($sql_video))
			{
				echo "<p class=\"error\">" . ERROR_BROWSE . "<br>\n" . mysql_error();
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			while ($video_data = mysql_fetch_object($exec_video))
			{
				if (empty($video_data->video))
				{
					echo "<p>" . MSG_INSERT_VIDEOCLIP . ":\n";
					echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"admin_mmedia.php";
					if ($trans_sid == 0)
					{
						echo "?" . SID;
					}	
					echo "\">\n";
					echo "<input type=\"hidden\" name=\"admin\" value=\"insert_video\"><input type=\"hidden\" name=\"recipe_id\" value=\"$video_data->id\"><input type=\"hidden\" name=\"recipe_name\" value=\"$video_data->name\">\n<input type=\"file\" name=\"recipe_video\">\n<p><input type=\"submit\" value=\"" . BTN_MMEDIA_INSERT_VIDEOCLIP . "\">\n</form>\n";
				} else
				{
					echo "<p>" . MSG_ADMIN_MULTIMEDIA_VIDEO_AVAILABLE . " {$_POST['recipe_name']}\n";
				}
			}
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
		//add image
		if ($_POST['admin'] == "insert_image")
		{
			//Check input file name
			if (eregi("[@!|#§+*<>^?£$%&\/\\]", $_FILES['recipe_image']['name'])) 
			{
				echo "<p class=\"error\">" . ERROR_INVALID_CHAR . "&nbsp;" . ERROR_FILE_IMAGE . "!\n";
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			$image_type = array ('.jpg', '.JPG', '.jpeg', '.JPEG','.gif', '.GIF','.tif', '.TIF','.tiff', '.TIFF', '.png', '.PNG', '.bmp', '.BMP'); 
			$image_extension = substr(strrchr($_FILES['recipe_image']['name'], "."), 0);
			if (!in_array("$image_extension", $image_type))
			{
			        echo "<p class=\"error\">" . ERROR_INVALID_IMAGE . "!\n";
			        echo "<p>" . MSG_VALID_FORMAT . ":<br>\n";
			        //Displays content of array $image_type
			        foreach ($image_type as $extension)
				{
					echo "$extension/\n";
				}
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			//Check for duplicate image file
			$sql_duplicate_image = "SELECT image FROM main where image = '{$_FILES['recipe_image']['name']}'";
			if (!$exec_duplicate_image = mysql_query($sql_duplicate_image))
			{
				echo "<p class=\"error\">" . ERROR_DUPLICATE_IMAGE . "<br>\n" . mysql_error();
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			$num_images = mysql_num_rows($exec_duplicate_image);
			if ($num_images >= "1")
			{
				echo "<p class=\"error\">" . ERROR_EXIST_IMAGE . ".\n";
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			//Extract from environment the script path
			$path = dirname(__FILE__);
			$upload_path = "$path/images";
			$check_name = $_FILES['recipe_image']['name'];
			$upload_error = copy ("{$_FILES['recipe_image']['tmp_name']}", "$upload_path/{$_FILES['recipe_image']['name']}");
			if ($upload_error == 0) 
			{
				echo "<p class=\"error\">" . ERROR_UNEXPECTED . ": " . ERROR_UPLOAD . "!\n";
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			//Insert data into database
			$sql_add = "UPDATE main SET image = '{$_FILES['recipe_image']['name']}' WHERE id = '{$_POST['recipe_id']}'";
			if (!$exec_sql_add = mysql_query($sql_add))
				{
				echo "<p class=\"error\">" . ERROR_ADMIN_MMEDIA_IMAGE_ADD . "<br>\n" . mysql_error();
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			echo "<p>{$_FILES['recipe_image']['name']} " . MSG_ADMIN_MMEDIA_IMAGE_ADDED . " {$_POST['recipe_name']}\n";
			echo "<p>" . MSG_ADMIN_MMEDIA_DISPLAY_RECIPE . " <a href=\"recipe.php?recipe={$_POST['recipe_id']}";
			if ($trans_sid == 0)
			{
				echo "&" . SID;
			}
			echo "\">{$_POST['recipe_name']}</a>\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();

		}
		//add video
		if ($_POST['admin'] == "insert_video")
		{
			if (eregi("[@!|#§+*<>^?£$%&\/\\]", $_FILES['recipe_video']['name'])) 
			{
				echo "<p class=\"error\">" . ERROR_INVALID_CHAR . "&nbsp;" . ERROR_FILE_VIDEO . "!\n";
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			$video_type = array ('.avi', '.AVI', '.mpeg', '.MPEG','.mpg', '.MPG','.asf', '.ASF','.wmv', '.WMV', '.qt', '.QT', '.qtx', '.QTX'); 
			$video_extension = substr(strrchr($_FILES['recipe_video']['name'], "."), 0);
			if (!in_array("$video_extension", $video_type))
			{
		        	echo "<p class=\"error\">" . ERROR_INVALID_VIDEO . "!\n";
			        echo "<p>" . MSG_VALID_FORMAT . ":<br>\n";
		        //Displays content of array $video_type
			        foreach ($video_type as $extension)
				{
					echo "$extension/\n";
				}
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			//Check for duplicate video file
			$sql_duplicate_video = "SELECT image FROM main where video = '{$_FILES['recipe_video']['name']}'";
			if (!$exec_duplicate_video = mysql_query($sql_duplicate_video))
			{
				echo "<p class=\"error\">" . ERROR_DUPLICATE_VIDEO . "<br>\n" . mysql_error();
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			$num_video = mysql_num_rows($exec_duplicate_video);
			if ($num_video >= "1")
			{
				echo "<p class=\"error\">" . ERROR_EXIST_VIDEO . ".\n";
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			//Extract from environment the script path
			$path = dirname(__FILE__);
			$upload_path = "$path/video";
			$check_name = $_FILES['recipe_video']['name'];
			$upload_error = copy ("{$_FILES['recipe_video']['tmp_name']}", "$upload_path/{$_FILES['recipe_video']['name']}");
			if ($upload_error == 0) 
			{
				echo "<p class=\"error\">" . ERROR_UNEXPECTED . ": " . ERROR_UPLOAD . "!\n";
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			//Insert data into database
			$sql_add = "UPDATE main SET video = '{$_FILES['recipe_video']['name']}' WHERE id = '{$_POST['recipe_id']}'";
			if (!$exec_sql_add = mysql_query($sql_add))
			{
				echo "<p class=\"error\">" . ERROR_ADMIN_MMEDIA_VIDEOCLIP_ADD . "<br>\n" . mysql_error();
				cs_AdminFastLogout();
				cs_AddFooter();
				exit();
			}
			echo "<p>{$_FILES['recipe_video']['name']} " . MSG_ADMIN_MMEDIA_VIDEOCLIP_ADDED . " {$_POST['recipe_name']}\n";
			echo "<p>" . MSG_ADMIN_MMEDIA_DISPLAY_RECIPE . " <a href=\"recipe.php?recipe={$_POST['recipe_id']}";
			if ($trans_sid == 0)
			{
				echo "&" . SID;
			}
			echo "\">{$_POST['recipe_name']}</a>\n";
			cs_AdminFastLogout();
			cs_AddFooter();
			exit();
		}
	}
	//If no previous contitions are met print out the form with
	//recipe list
	echo "<h2>" . MSG_ADMIN . "</h2>\n";
	echo "<h3>" . MSG_ADMIN_MENU_MULTIMEDIA . "</h3>\n";
	cs_CheckLoginAdmin();
	echo "<p>" . MSG_ADMIN_MMEDIA_RECIPE_SELECT . ":<br>\n"; 
	$sql_list = "SELECT * FROM main";
	if (!$exec_list = mysql_query($sql_list))
	{
		echo "<p class=\"error\">" . ERROR_BROWSE . "<br>\n" . mysql_error();
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}	
	echo "<form method=\"post\" action=\"admin_mmedia.php";
	if ($trans_sid == 0)
	{
		echo "?" . SID;
	}
	echo "\">\n
	<select name=\"recipe_id\">\n
	";
	while ($recipe_data = mysql_fetch_object($exec_list))
	{
		echo "<option value=\"$recipe_data->id\">$recipe_data->name</option>\n";
	}
	echo "</select>\n";
	echo "<input type=\"hidden\" name=\"admin\" value=\"select_mmedia\">\n
	<input type=\"hidden\" name=\"recipe_name\" value=\"$recipe_data->name\">
	<p><input type=\"submit\" value=\"" . BTN_ADMIN_MMEDIA_SELECT . "\"></form>\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//if referer script is admin_* except admin_mmedia.php
if (strstr($_SERVER['HTTP_REFERER'], '/admin_') AND !strstr($_SERVER['HTTP_REFERER'], '/admin_mmedia.php'))
{
	echo "<h2>" . MSG_ADMIN . "</h2>\n";
	echo "<h3>" . MSG_ADMIN_MENU_MULTIMEDIA . "</h3>\n";
	cs_CheckLoginAdmin();
	echo "<p>" . MSG_ADMIN_MMEDIA_RECIPE_SELECT . ":<br>\n"; 
	$sql_list = "SELECT * FROM main";
	if (!$exec_list = mysql_query($sql_list))
	{
		echo "<p class=\"error\">" . ERROR_BROWSE . "<br>\n" . mysql_error();
		cs_AdminFastLogout();
		cs_AddFooter();
		exit();
	}	
	echo "<form method=\"post\" action=\"admin_mmedia.php";
	if ($trans_sid == 0)
	{
		echo "?" . SID;
	}
	echo "\">\n
	<select name=\"recipe_id\">\n
	";
	while ($recipe_data = mysql_fetch_object($exec_list))
	{
		echo "<option value=\"$recipe_data->id\">$recipe_data->name</option>\n";
		$_SESSION['recipe_id'] == $recipe_data->id;
	}
	echo "</select>\n";
	echo "<input type=\"hidden\" name=\"admin\" value=\"select_mmedia\"><input type=\"hidden\" name=\"recipe_name\" value=\"$recipe_data->name\">\n
	<p><input type=\"submit\" value=\"" . BTN_ADMIN_MMEDIA_SELECT . "\"></form>\n";
	cs_AdminFastLogout();
	cs_AddFooter();
	exit();
}
//if referer script is any other
cs_CheckLoginAdmin();
cs_AdminFastLogout();
cs_AddFooter();
?>
