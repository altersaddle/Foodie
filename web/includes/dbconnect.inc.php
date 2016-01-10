<?php
{
	$dbconnect = @new mysqli($db_server, $db_user, $db_password, $db_name, $db_port);
	if ($dbconnect->connect_errno) 
	{
		echo "<p><strong>" . ERROR_BROWSE . "!</strong><br>" . $dbconnect->connect_error;
	exit();
	}
}
?>
