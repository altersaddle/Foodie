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

if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
}
else {
    foodie_AddHeader();
    echo "<h2><?= MSG_ADMIN ?></h2>\n";
    echo "<h3><?= MSG_ADMIN_MAIN_MENU ?></h3>\n";
    ?>
    <table width="100%" bgcolor="#dddddd" cellspacing="1" cellpadding="1">
    <tr bgcolor="#ffffff">
      <td valign=top>
        <p class="menu_title"><?= MSG_ADMIN_TITLE_RECIPE ?></p>
      </td>
      <td valign="top"><p>
        <a href="admin_insert.php"><?= MSG_ADMIN_MENU_RECIPE_ADD ?></a><br>
        <a href="admin_modify.php"><?= MSG_ADMIN_MENU_RECIPE_MOD ?></a><br>
        <a href="admin_delete.php"><?= MSG_ADMIN_MENU_RECIPE_DEL ?></a><br>
        <a href="admin_mmedia.php"><?= MSG_ADMIN_MENU_MULTIMEDIA ?></a></p>
      </td>
    </tr>
    <tr bgcolor="#ffffff">
      <td valign="top">
        <p class="menu_title"><?= MSG_ADMIN_TITLE_SERVING ?></p>
      </td>
      <td valign=top>
        <p><a href="admin_dish.php?action=adm_insert"><?= MSG_ADMIN_MENU_SERVING_ADD ?></a><br>
        <a href="admin_dish.php?action=adm_modify"><?= MSG_ADMIN_MENU_SERVING_MOD ?></a><br>
        <a href="admin_dish.php?action=adm_delete"><?= MSG_ADMIN_MENU_SERVING_DEL ?></a></p>
      </td>
    </tr>
    <tr bgcolor="#ffffff">
      <td valign="top">
        <p class="menu_title"><?= MSG_ADMIN_TITLE_COOKING ?></p>
      </td>
      <td valign="top">
        <p><a href="admin_cook.php?action=adm_insert"><?= MSG_ADMIN_MENU_COOKING_ADD ?></a><br>
        <a href="admin_cook.php?action=adm_modify"><?= MSG_ADMIN_MENU_COOKING_MOD ?></a><br>
        <a href="admin_cook.php?action=adm_delete"><?= MSG_ADMIN_MENU_COOKING_DEL ?></a><br></p>
      </td>
    </tr>
    <tr bgcolor="#ffffff">
      <td valign=top>
        <p class="menu_title"><?= MSG_ADMIN_TITLE_CONFIG ?></p>
      </td>
      <td valign=top>
        <p><a href="admin_userpass.php"><?= MSG_ADMIN_MENU_CONFIG_USR ?></a><br>
        <a href="admin_config.php"><?= MSG_ADMIN_MENU_CONFIG_CFG ?></a><br></p>
      </td>
    </tr>
    <tr bgcolor="#ffffff">
      <td valign=top>
        <p class="menu_title"><?= MSG_ADMIN_TITLE_UTIL ?></p>
      </td>
      <td valign=top>
        <p><a href="admin_export.php"><?= MSG_ADMIN_MENU_UTIL_EXPMAIN ?></a><br>
        <a href="admin_import.php"><?= MSG_ADMIN_MENU_UTIL_IMPFILES ?></a><br></p>
      </td>
    </tr>
    <tr bgcolor="#ffffff">
      <td valign=top>
        <p class="menu_title"><?= MSG_ADMIN_TITLE_BACKUP ?></p>
      </td>
      <td valign=top>
        <p><a href="admin_backup.php"><?= MSG_ADMIN_MENU_BACKUP_BKP ?></a><br>
        <a href="admin_restore.php"><?= MSG_ADMIN_MENU_BACKUP_RST ?></a><br></p>
      </td>
    </tr>
    <tr bgcolor="#ffffff">
      <td valign=top>
        <p class="menu_title"><?= MSG_ADMIN_TITLE_LOGOUT ?></p>
      </td>
      <td valign=top>
        <p><a href="admin_logout.php"><?= MSG_ADMIN_LOGOUT ?></a></p>
      </td>
    </tr>
  </table>
<?php
foodie_AddFooter();
}
?>
