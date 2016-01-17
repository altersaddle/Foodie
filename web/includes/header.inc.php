<?php
$filename = $_SERVER['PHP_SELF'];
/* Every page has this content */
?>
<html>
  <head>
    <meta http-equiv="Cache-Control" content="private, pre-check=0, post-check=0, max-age=0">
	<meta http-equiv="Expires" content="Tue, 17 Nov 2002, 00:00:00 GMT">
	<title>How to Cook Like a Pirate</title>
    <link href="foodie.css" rel="stylesheet" type="text/css">
<?php
if (strstr($_SERVER['SCRIPT_NAME'], "/index.php")) {
?>
<script type='text/javascript' src='unitegallery/js/jquery-11.0.min.js'></script>
<!-- Include Unite Gallery -->
<script type='text/javascript' src='unitegallery/js/unitegallery.min.js'></script>		
<link rel='stylesheet' href='unitegallery/css/unite-gallery.css' type='text/css' />	
<script type='text/javascript' src='unitegallery/themes/tiles/ug-theme-tiles.js'></script>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#foodie-index").unitegallery({
                  tile_as_link:true,
				  tile_link_newpage:false,
				  tile_enable_textpanel:true,
                });
			});
		</script>
<?php
}
/*
 *   Header for admin_*.php scripts
 */
if (strstr($filename, "admin_"))
{
    echo "<script type='text/javascript' src='unitegallery/js/jquery-11.0.min.js'></script>";
    echo "<script src=\"//code.jquery.com/ui/1.11.4/jquery-ui.js\"></script>";
    echo "<link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css\">";
?>

<style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
</style>
  <script>
  $(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  });
  </script>
  <?php
    echo "</head><body><h1><a href=\"index.php\">". MSG_SITE_TITLE . "</a></h1>";
	echo "<table width=\"100%\" bgcolor=\"#dddddd\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\">
	<tr bgcolor=\"#eeeeee\"><td valign=\"top\"><p class=\"menu_admin\"><strong>" . MSG_ADMIN_HEADER_RECIPES . "</strong><br>
	<a href=\"admin_insert.php\">" . MSG_ADMIN_HEADER_INS . "</a><br>
	<a href=\"admin_modify.php\">" . MSG_ADMIN_HEADER_MOD . "</a><br>
	<a href=\"admin_delete.php\">" . MSG_ADMIN_HEADER_DEL . "</a><br>
	<a href=\"admin_mmedia.php\">" . MSG_ADMIN_MENU_MULTIMEDIA . "</a></td>
	<td valign=\"top\"><p class=\"menu_admin\"><strong>" . MSG_ADMIN_HEADER_SERVING . "</strong><br>
	<a href=\"admin_dish.php?action=adm_insert\">" . MSG_ADMIN_HEADER_INS . "</a><br>
	<a href=\"admin_dish.php?action=adm_modify\">" . MSG_ADMIN_HEADER_MOD . "</a></a><br>
	<a href=\"admin_dish.php?action=adm_delete\">" . MSG_ADMIN_HEADER_DEL . "</a></td>
	<td valign=\"top\"><p class=\"menu_admin\"><strong>" . MSG_ADMIN_HEADER_COOKING . "</strong><br>
	<a href=\"admin_cook.php?action=adm_insert\">" . MSG_ADMIN_HEADER_INS . "</a><br>
	<a href=\"admin_cook.php?action=adm_modify\">" . MSG_ADMIN_HEADER_MOD . "</a><br>
	<a href=\"admin_cook.php?action=adm_delete\">" . MSG_ADMIN_HEADER_DEL . "</a></td>
	<td valign=\"top\"><p class=\"menu_admin\"><strong>" . MSG_ADMIN_HEADER_CONFIG . "</strong><br>
	<a href=\"admin_config.php\">" . MSG_ADMIN_HEADER_SETUP . "</a><br>
	<a href=\"admin_userpass.php\">" . MSG_ADMIN_HEADER_USERPASS . "</a></td>
	<td valign=\"top\"><p class=\"menu_admin\"><strong>" . MSG_ADMIN_HEADER_UTIL . "</strong><br>
	<a href=\"admin_export.php\">" . MSG_ADMIN_HEADER_EXPORT . "</a><br>
	<a href=\"admin_import.php\">" . MSG_ADMIN_HEADER_IMPORT . "</a></td>
	<td valign=\"top\"><p class=\"menu_admin\"><strong>" . MSG_ADMIN_HEADER_BACKUP . "</strong><br>
	<a href=\"admin_backup.php\">" . MSG_ADMIN_HEADER_BKP . "</a><br>
	<a href=\"admin_restore.php\">" . MSG_ADMIN_HEADER_RST . "</a></td>
	<td valign=\"top\"><p class=\"menu_admin\"><strong>" . MSG_ADMIN . "</strong><br>
	<a href=\"admin_index.php\">" . MSG_ADMIN_HEADER_INDEX . "</a><br>
	<a href=\"admin_logout.php\">" . MSG_ADMIN_HEADER_LOGOUT . "</a></td>
	</tr>
	</table>";
}
/*
 *	Header for install.php/language.php script
 */
else if (strstr($filename, "install"))
{
    echo "</head><body><h1>". MSG_SITE_TITLE . "</h1>";
	echo "<h2>Installation</h2>";
}
/*
 *	Header for all other scripts
 */
else
{
?>
  </head>
  <body>
    <h1><a href="index.php"><?= MSG_SITE_TITLE ?></a></h1>
    <p class="menu">
      <table border="0" width="95%" cellpadding=0 cellspacing=0>
        <tr>
          <td class="menu" align="left">
            <a href="browse.php"><?= MSG_BROWSE ?></a> - 
	        <a href="search.php"><?= MSG_SEARCH ?></a> - 
	        <a href="cookbook.php"><?= MSG_COOKBOOK ?></a> - 
	        <a href="shoppinglist.php"><?= MSG_SHOPPING ?></a>
	     </td>
         <td align="right" class="menu">
            <a href="admin_index.php"><?= MSG_ADMIN ?></a> 
         </td>
       </tr>
     </table>
<?php
}

?>