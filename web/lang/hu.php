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
/*
 *	CrisoftRicette language file
 *	Language: Hungarian
 *	Translated by: Miklos Bagi Jr. joschy@mbjr.dyndns.org
 *	File: lang/hu.php
 */
//messages added 1.0pre15b
define("MSG_SEARCH_NORECIPESFOUND", "No recipes found for requested search terms");
define("MSG_SEARCH_RECIPESFOUND", "Recipes found matching requested search terms");
//messages added into 1.0pre15
define("MSG_RECIPE_IMAGE_UNAVAILABLE", "Image unavailable, add a new one");
define("MSG_RECIPE_VIDEO_UNAVAILABLE", "Video unavailable, add a new one");
define("MSG_RECIPE_VIDEO_FILE", "Video of this recipe");
define("MSG_ADMIN_MENU_MULTIMEDIA", "Image and video management");
define("MSG_ADMIN_MULTIMEDIA_IMAGE_AVAILABLE", "Image already available for recipe");
define("MSG_ADMIN_MULTIMEDIA_VIDEO_AVAILABLE", "Video already available for recipe");
define("BTN_MMEDIA_INSERT_IMAGE", "Add image to recipe");
define("BTN_MMEDIA_INSERT_VIDEOCLIP", "Add video to recipe");
define("ERROR_ADMIN_MMEDIA_IMAGE_ADD", "Unable to add image to recipe");
define("MSG_ADMIN_MMEDIA_IMAGE_ADDED", "image added to recipe");
define("MSG_ADMIN_MMEDIA_BACK_RECIPE", "Back to recipe");
define("MSG_ADMIN_MMEDIA_DISPLAY_RECIPE", "Look at recipe");
define("ERROR_ADMIN_MMEDIA_VIDEOCLIP_ADD", "Unable to add video to recipe");
define("MSG_ADMIN_MMEDIA_VIDEOCLIP_ADDED", "video added to recipe");
define("MSG_ADMIN_MMEDIA_RECIPE_SELECT", "Select recipe to add image/video");
define("BTN_ADMIN_MMEDIA_SELECT", "Select this recipe");
define("MSG_ADMIN_HEADER_INDEX", "Admin home");
//includes/header.inc.php
define("MSG_BROWSE", "B�ng�sz�s");
define("MSG_SEARCH", "Keres�");
define("MSG_INSERT", "Add");
define("MSG_COOKBOOK", "Kedvencek");
define("MSG_SHOPPING", "Bev�s�rl�s");
define("MSG_ADMIN", "Admin");
define("MSG_CLOSE", "Alkalmaz�s bez�r�sa");
define("MSG_ABOUT", "N�vjegy");
//includes/footer.inc.php
define("MSG_WRITTEN", "�rta");
define("MSG_GPL_NOTICE", "Kiadva a GNU GPL alatt");
//index.php
define("MSG_UNABLE_DELETE_CONFIG", "Nem t�r�lhet� a konfigur�ci�s �llom�ny");
define("ERROR_DB_NOT_EXIST", "Az adatb�zis nem l�tezik");
define("MSG_REINSTALL", "Az alkalmaz�s �jratele�t�se sz�ks�ges");
define("MSG_CONTAINS", "Az adatb�zis");
define("MSG_RECIPES", "receptet tartalmaz");
//logout.php
define("MSG_THANKS", "Rem�lem hasznos volt :D");
//browse.php
define("ERROR_COUNT_RECIPES", "Nem tudom, hogy az adatb�zis h�ny receptet tartalmaz");
define("MSG_NO_RECIPES", "Az adatb�zisban nincs recept");
define("MSG_RECIPES_INITIAL", "Nincs olyan recept, melyne els� bet�je");
define("MSG_SELECT_BROWSE", "Hogyan szeretn�l b�ng�szni");
define("MSG_BROWSE_EMPTY", "�res adatb�zist nem b�ng�szhet�nk :D");
define("MSG_ORDER_ID", "azonos�t� szerint");
define("MSG_ORDER_ALPHA", "abc sorrendben");
define("MSG_ORDER_SERVING", "fog�sok szerint");
define("MSG_ORDER_MAIN", "f� hozz�val�k szerint");
define("MSG_ORDER_KIND", "az elk�sz�t�s m�dja szerint");
define("MSG_ORDER_ORIGIN", "sz�rmaz�s szerint");
define("MSG_ORDER_SEASON", "szezon szerint");
define("MSG_ORDER_EASY", "neh�zs�g szerint - a legk�nnyebbt�l");
define("MSG_ORDER_HARD", "neh�zs�g szerint - a legnehezebbt�l");
define("ERROR_BROWSE", "Nem b�ng�szhet� az adatb�zis");
define("MSG_AVAILABLE_PAGES", "Oldal");
define("MSG_PREVIOUS", "El�z� oldal");
define("MSG_NEXT", "K�vetkez� oldal");
//crisoftlib.php
define("ERROR_PAGE_SIZE", " nem val�s be�ll�t�si kulcs az oldal m�ret�t tekintve");
define("MSG_USE_ONLY_VALUES", "�rv�nyes �rt�kek");
define("ERROR_ILLEGAL_REQUEST", "K�r�s megtagadva");
define("MSG_WARNING", "Figyelem");
define("MSG_PAGE_RESTRICTED", "A v�dett oldal nem l�tezik");
define("MSG_NOT_LOGGED", "Nem vagyol napl�zva");
define("MSG_LOGIN_REQUEST", "Bel�p�s azonos�t� �s jelsz� megad�s�val");
define("ERROR_MAIL_ADDRESS", "nem val�s email c�m");
define("MSG_BACK", "Vissza");
define("MSG_SECURITY_WARNING", "Biztons�gi figyelmeztet�s");
define("MSG_INPUT_FIELD", "A beviteli mez� �rt�ke");
define("MSG_INPUT_DANGER", "potenci�lisan vesz�lyes karaktereket tartalmaz");
define("ERROR_INPUT_REQUIRED", "Nincs meg a sz�ks�ges adat");
define("ERROR_CONFIG_NOT_SET", "N�h�ny konfigur�ci�s kulcssz�nak nincs �rt�ke");
define("MSG_RESTART_INSTALL", "�jra kell engem telep�teni");
define("BTN_COOKBOOK_DEL", "T�rl�s a kedvencekb�l");
define("MSG_RECIPE_NAME", "Recept neve");
define("MSG_RECIPE_SERVING", "Fog�s");
define("MSG_RECIPE_MAIN", "F�bb hozz�val�k");
define("MSG_RECIPE_PEOPLE", "F�re");
define("MSG_RECIPE_ORIGIN", "Sz�rmaz�s");
define("MSG_RECIPE_SEASON", "Szezon");
define("MSG_RECIPE_COOKING", "Elk�sz�t�s m�dja");
define("MSG_RECIPE_TIME", "Sz�ks�ges id�");
define("MSG_RECIPE_DIFFICULTY", "Neh�zs�g");
define("MSG_RECIPE_WINES", "Aj�nlott bor");
define("MSG_RECIPE_INGREDIENTS", "Hozz�val�k");
define("MSG_RECIPE_DESCRIPTION", "Le�r�s");
define("MSG_RECIPE_NOTES", "Megjegyz�s");
define("MSG_NO_COOKING_TYPE", "Nincs megadva");
define("MSG_NO_SERVING", "Nincs megadva");
//recipe.php
define("ERROR_RECIPE_RETRIEVE", "A k�rt recept nem l�tezik");
define("MSG_RECIPE_PRINTED", "A recept forr�sa:");
define("ERROR_UNEXPECTED", "Cs�nya hiba van valahol");
define("ERROR_COUNT_VOTES", "Nem tudom h�nyat szavazott");
define("MSG_RECIPE_VOTES_TOT", "Eddig");
define("MSG_RECIPE_VOTES_AVG", "szavazat �rkezett, �tlaguk jelenleg");
define("BTN_RATE_RECIPE", "Recept �rt�kel�se");
define("BTN_EMAIL", "K�ld�s emailben");
define("BTN_ADD_COOKBOOK", "Hozz�ad�s a kedvencekhez");
define("BTN_ADD_SHOPPING", "Hozz�ad�s a v�s�rl� list�hoz");
define("BTN_PDF", "PDF k�sz�t�se");
define("BTN_PRINT", "Nyomtat�bar�t megtekint�s");
define("MSG_RECIPE_NEVER_RATED", "Ez a recept m�g nem kapott szavazatot");
define("ERROR_CHECK_COOKBOOK", "Nincsenek meg a kedvencek");
define("MSG_ALREADY_COOKBOOK", "Ez a recept a kedvenceid k�z�tt van");
define("MSG_EXPORT_ASK", "Recept export�l�sa m�s form�tumban");
define("MSG_EXPORT", "Export");
define("ERROR_UNABLE_INSERT_TABLE", "Nem tudom hozz�adni az adatot a t�bl�hoz");
//cookbook.php
define("ERROR_COOKBOOK_DUPLICATE" , "Nem tudom van-e m�r ilyen a kedvenceid k�z�tt");
define("ERROR_COOKBOOK_INSERT" , "Nem tudom betenni a kedvencek k�z�");
define("ERROR_COOKBOOK_SELECT" , "Nem tudok adatot kinyerni a kedvenceidb�l");
define("ERROR_COOKBOOK_DELETE" , "Nem tudom t�r�lni a kedvenceid k�z�l");
define("MSG_RECIPE", "A");
define("MSG_COOKBOOK_PRESENT", "m�r a kedvencek k�z�tt van, azonos�t�");
define("MSG_COOKBOOK_NORECIPES", "Nincsenek kedvenc receptjeid");
define("MSG_COOKBOOK_NUMBER", "kedvenc recepted van jelenleg");
define("MSG_COOKBOOK_READ", "Kedvencek olvas�sa");
define("MSG_COOKBOOK_DELETE", "T�rl�s a kedvencekb�l");
define("MSG_COOKBOOK_DELETED", "t�r�lve a kedvencekb�l");
define("MSG_COOKBOOK_WELCOME", "Ez itt kedvenc receptjeid gy�jtem�nye");
define("MSG_COOKBOOK_INSERT", "hozz�adva a kedvencekhez");
//export.php
define("MSG_EXPORT_SINGLE", "Recept export�l�sa");
define("ERROR_EXPORT_RECIPE_CALL", "Ez a script csak egy receptb�l h�vhat� meg");
//insert.php
define("ERROR_MISSING", "nincs meg");
define("ERROR_INSERT_RECIPE", "Nem tudom l�trehozni a receptet");
define("ERROR_INVALID_CHAR", "Hib�s karakterek");
define("ERROR_INVALID_IMAGE", "Hib�s k�p�llom�ny");
define("ERROR_INVALID_VIDEO", "Hib�s vide��llom�ny");
define("ERROR_FILE_IMAGE", "a k�p nev�hez");
define("ERROR_FILE_VIDEO", "a vide� nev�hez");
define("ERROR_DUPLICATE_IMAGE", "Nem l�tom, hogy van-e m�r ilyen k�p");
define("ERROR_DUPLICATE_VIDEO", "Nem l�tom, hogy van-e m�r ilyen vide�");
define("ERROR_EXIST_IMAGE", "Ezen a n�ven m�r l�tezik k�p");
define("ERROR_EXIST_VIDEO", "Ezen a n�ven m�r l�tezik vide�");
define("ERROR_UPLOAD", "felt�lt�si hiba");
define("MSG_INSERT_VIDEOCLIP", "A recepthez kapcsol�d� vide��llom�ny");
define("BTN_INSERT_VIDEOCLIP", "Vide� �s recept felvitele");
define("MSG_INSERT_IMAGE", "A recepthez kapcsol�d� k�p�llom�ny");
define("BTN_INSERT_IMAGE", "K�p �s recept felvitele");
define("BTN_INSERT_RECIPE", "Recept felvitele vide�/k�p n�lk�l");
define("BTN_INSERT_PREVIEW", "El�n�zet");
define("BTN_INSERT_CLEAR", "�jra");
define("MSG_INSERT_OK", "sikeresen beker�lt az adatb�zisba");
define("MSG_INSERT_IMAGE_OK", "sikeresen beker�lt az adatb�zisba, k�ppel egy�tt");
define("MSG_INSERT_VIDEO_OK", "sikeresen beker�lt az adatb�zisba, vide�val egy�tt");
define("MSG_VALID_FORMAT", "Csak azok a form�tumok haszn�lhat�ak");
define("MSG_INSERT_HERE", "�j recept felvitele");
define("MSG_SERVING_TABLE_EMPTY", "Nincs megadott fog�s");
define("MSG_COOKING_TABLE_EMPTY", "Nincs megadott m�d");
define("MSG_DIFFICULTY_TABLE_EMPTY", "Nincs megadott neh�zs�gi fok");
define("MSG_ASTERISK", "A csillaggal jel�lt mez�k kit�lt�se sz�ks�ges");
define("MSG_GOTO_ADMIN", "Bel�p�s az admin fel�letre");
define("MSG_CHOOSE_SERVING", "Add meg a megfelel� fog�st");
define("MSG_CHOOSE_COOKING", "Add meg az elk�sz�t�s m�dj�t");
define("MSG_CHOOSE_DIFFICULTY", "Add meg a bonyorults�gi fokot");
define("MSG_NOT_SPECIFIED", "Nem megadott");
//license.php
define("MSG_GPL_LICENSE", "GNU/GPL Licensz");
//mail.php
define("MSG_MAIL_TITLE", "Recept k�ld�se emailben");
define("MSG_MAIL_ADDRESS_REQUEST", "A c�lszem�ly email c�me");
define("MSG_MAIL_DIFF", "on a total of");
define("BTN_MAIL_SEND", "K�ld�s");
define("MSG_MAIL_SENT", "A recept k�ld�je:");
define("MSG_MAIL_DOWNLOAD", "You can download it on you computer");
define("MSG_MAIL_WEBSITE", "connecting to website");
define("MSG_MAIL_DELIVERED", "A receptet sikeresen elk�ldtem.");
define("MSG_MAIL_AGAIN", "Esetleg el akarod k�ldeni m�g valakinek");
//rate.php
define("MSG_RATE_TITLE", "Recept �rt�kel�se");
define("MSG_RATE_VOTE", "Szavazz te is erre a receptre!");
define("MSG_RATE_POISON", "M�rgez�");
define("MSG_RATE_VERYBAD", "Borzalmas");
define("MSG_RATE_BAD", "Rossz");
define("MSG_RATE_NOTSOBAD", "Nem is olyan rossz");
define("MSG_RATE_AVERAGE", "�tlagos");
define("MSG_RATE_QUITEGOOD", "Eg�sz j�");
define("MSG_RATE_GOOD", " J�");
define("MSG_RATE_VERYGOOD", "Nagyon j�");
define("MSG_RATE_EXCELLENT", "Menyjei");
define("MSG_RATE_PERFECTION", "Maga a t�k�ly");
define("BTN_RATE_THIS", "�rt�keld a receptet");
define("MSG_RATE_RATED", "szavazott");
define("ERROR_RATE_REGISTERING", "Nem tudom regisztr�lni a szavazatodat");
define("MSG_RATE_YOURVOTE", "V�laszt�sod a k�vetkez�");
define("MSG_RATE_REGISTERED", ". K�sz�n�m, regisztr�ltam a v�lem�nyed.");
define("ERROR_RATE_COUNT", "Nem tudom megmondani neked h�nyan szavaztak a receptre");
define("MSG_RATE_GOTVOTED", "A receptre eddig ennyien szavaztak");
define("MSG_RATE_AVGVOTE", "�tlag eredm�ny");
//search.php
define("MSG_SEARCH_TITLE", "Recept keres�se");
define("MSG_SEARCH_STRING", "Az �ltalad keresett");
define("MSG_SEARCH_INSERT_STRING", "�rj egy, vagy t�bb sz�t, sz�k�zzel elv�lasztva");
define("MSG_SEARCH_INSERT_FIELD", "Hol keressek");
define("MSG_SEARCH_ALLFIELDS", "Mindenhol");
define("MSG_SEARCH_INSERT_PARTIAL", "el�g, ha csak egy r�sz�t tudod megadni");
define("MSG_SEARCH_FOUND", "sz�, a k�vetkez� receptekben szerepel");
define("MSG_SEARCH_FIELD", "sz�, a k�rt helyen, a k�vetkez� receptekben szerepel");
define("ERROR_SEARCH_DATABASE", "Nem tudok keresni az adatb�zisban");
define("BTN_SEARCH", "Keres�s ind�t�sa");
//shopping.php
define("MSG_SHOPPING_TITLE", "Bev�s�rl� lista");
define("MSG_SHOPPING_ADDED", "V�s�rl�si list�hoz");
define("MSG_SHOPPING_DELETED", "A receptet t�r�ltem a list�b�l");
define("ERROR_SHOPPING_RETRIEVE_LIST", "Nem f�rek hozz� a list�dhoz");
define("ERROR_SHOPPING_RETRIEVE_RECIPE", "Nem l�tom a receptet, amit hozz� k�v�nsz adni a list�dhoz");
define("ERROR_SHOPPING_INSERT", "Nem tudom hozz�adni az adatokat a list�dhoz");
define("ERROR_SHOPPING_IDELETE", "Nem tudom t�r�lni a list�b�l");
define("MSG_SHOPPING_NODATA", "A bev�s�rl�list�d �res");
define("MSG_SHOPPING_SIGNATURE", "A list�t �n csin�ltam neked:");
define("BTN_SHOPPING_DELETE", "T�rl�s a list�b�l");
define("BTN_SHOPPING_PRINT", "Nyomtathat� verzi�");
//admin_login.php
define("MSG_ADMIN_USERPASS_REQUEST", "Add meg az azonos�t�t �s a hozz� tartoz� jelsz�t!");
define("MSG_ADMIN_USER", "Azonos�t�");
define("MSG_ADMIN_PASS", "Jelsz�");
define("MSG_ADMIN_LOGIN", "Bel�p�s");
define("MSG_ADMIN_MAIN_MENU", "F�men�");
define("MSG_ADMIN_TITLE_RECIPE", "Recept adminisztr�ci�");
define("MSG_ADMIN_TITLE_SERVING", "Servings administration");
define("MSG_ADMIN_TITLE_COOKING", "Cooking types administration");
define("MSG_ADMIN_TITLE_CONFIG", "Configuration");
define("MSG_ADMIN_TITLE_UTIL", "Utilities");
define("MSG_ADMIN_TITLE_BACKUP", "Backups");
define("MSG_ADMIN_TITLE_LOGOUT", "Logout");
define("MSG_ADMIN_MENU_RECIPE_ADD", "Add a recipe");
define("MSG_ADMIN_MENU_RECIPE_MOD", "Modify a recipe");
define("MSG_ADMIN_MENU_RECIPE_DEL", "Delete a recipe");
define("MSG_ADMIN_MENU_SERVING_ADD", "Add a serving");
define("MSG_ADMIN_MENU_SERVING_DEL", "Delete a serving");
define("MSG_ADMIN_MENU_SERVING_MOD", "Modify a serving");
define("MSG_ADMIN_MENU_COOKING_ADD", "Add a cooking type");
define("MSG_ADMIN_MENU_COOKING_MOD", "Modify a cooking type");
define("MSG_ADMIN_MENU_COOKING_DEL", "Delete a cooking type");
define("MSG_ADMIN_MENU_CONFIG_USR", "Modify administrator username/password");
define("MSG_ADMIN_MENU_CONFIG_CFG", "Change configuration");
define("MSG_ADMIN_MENU_UTIL_IMP07", "Import recipe from a 0.7 version database");
define("MSG_ADMIN_MENU_UTIL_IMPFILES", "Import recipes from various file formats");
define("MSG_ADMIN_MENU_UTIL_EXPMAIN", "Export all recipes");
define("MSG_ADMIN_MENU_UTIL_OPT", "Optimize database");
define("MSG_ADMIN_MENU_BACKUP_BKP", "Backup entire database");
define("MSG_ADMIN_MENU_BACKUP_RST", "Restore database");
define("MSG_ADMIN_LOGOUT", "Logout from admin area");
define("MSG_ADMIN_LOGOUT_FAST", "Fast logout from admin area");
define("ERROR_ADMIN_CHECK_DB", "Unable to verify username/password");
define("ERROR_ADMIN_CHANGE_DEFAULT", "Please immediately change default username/password");
define("ERROR_ADMIN_INVALID_USERNAME", "Empty or invalid username");
define("ERROR_ADMIN_INVALID_PASSWORD", "Empty or invalid password");
define("ERROR_ADMIN_AUTHFAIL", "Invalid username/password");
//admin_import07.php
define("MSG_ADMIN_IMP07_FILL", "Type data modifying defaults if needed");
define("MSG_ADMIN_IMP07_HOSTNAME", "0.7 version MySQL database server name/IP address");
define("MSG_ADMIN_IMP07_PORT", "0.7 version MySQL database server TCP/IP port");
define("MSG_ADMIN_IMP07_USER", "0.7 version MySQL database username");
define("MSG_ADMIN_IMP07_PASS", "0.7 version MySQL database password");
define("MSG_ADMIN_IMP07_DBNAME", "0.7 version MySQL database name");
define("MSG_ADMIN_IMP07_SUCCESS", "Copy recipe");
define("BTN_ADMIN_IMP07_IMPORT", "Import recipe");
define("ERROR_ADMIN_IMP07_TITLE", "Import from version 0.7 - Error");
define("ERROR_ADMIN_IMP07_HOSTNAME", "invalid as server name/IP address");
define("ERROR_ADMIN_IMP07_PORT", "TCP/IP port number should be a numeric value");
define("ERROR_ADMIN_IMP07_SERVER", "Unable to connect to MySQL server with 0.7 version database");
define("ERROR_ADMIN_IMP07_SELECT", "Unable to connect to 0.7 version database");
define("ERROR_ADMIN_IMP07_COPY", "IUnable to copy data from 0.7 version database");
//admin_config.php
define("ERROR_ADMIN_CFG_HOSTNAME", "invalid as server name/IP address");
define("ERROR_ADMIN_CFG_PORT", "TCP/IP port number should be a numeric value");
define("ERROR_ADMIN_CFG_LINES", "Maximum lines per page should be a numeric value");
define("ERROR_ADMIN_CFG_DELETE", "Unable to delete configuration file");
define("ERROR_ADMIN_CFG_UPDATE", "Unable to update configuration file");
define("ERROR_ADMIN_CFG_BELOW", "Save the text below in file");
define("ERROR_ADMIN_CFG_RESTART", "then restart application");
define("MSG_ADMIN_CFG_HOSTNAME", "MySQL server name/IP address");
define("MSG_ADMIN_CFG_PORT", "MySQL server TCP/IP port");
define("MSG_ADMIN_CFG_USER", "MySQL username");
define("MSG_ADMIN_CFG_PASS", "MySQL password");
define("MSG_ADMIN_CFG_DBNAME", "MySQL database");
define("MSG_ADMIN_CFG_LOCALE", "Language");
define("MSG_ADMIN_CFG_LINES", "Lines per page");
define("MSG_ADMIN_CFG_EMAIL", "E-mail address");
define("MSG_ADMIN_CFG_PAGESIZE", "PDF files page size");
define("BTN_ADMIN_CFG_CHANGE", "Change configuration");
//admin_cooking.php
define("MSG_ADMIN_COOKING_INS", "Add cooking types");
define("MSG_ADMIN_COOKING_DEL", "Delete cooking types");
define("MSG_ADMIN_COOKING_MOD", "Modify cooking types");
define("MSG_ADMIN_COOKING_TYPE", "Cooking type");
define("MSG_ADMIN_COOKING_SAME", "Two cooking types with the same name are forbidden");
define("MSG_ADMIN_COOKING_SUCCESS", "added to database");
define("MSG_ADMIN_COOKING_NEW", "Add a new cooking type");
define("MSG_ADMIN_COOKING_CHANGED", "Cooking type modified");
define("MSG_ADMIN_COOKING_DELETED", "deleted from available cooking types");
define("ERROR_ADMIN_COOKING_DUPES", "Unable to check for cooking type duplicates");
define("ERROR_ADMIN_COOKING_PRESENT", "already into database");
define("ERROR_ADMIN_COOKING_INSERT", "Unable to add cooking type");
define("ERROR_ADMIN_COOKING_MODIFY", "Unable to change cooking type");
define("ERROR_ADMIN_COOKING_SINGLE", "Unable to retrieve selected cooking type");
define("ERROR_ADMIN_COOKING_RETRIEVE", "Unable to retrieve the list of available cooking types");
define("ERROR_ADMIN_COOKING_DELETE", "Unable to delete requested cooking type");
define("BTN_ADMIN_COOKING_INSERT", "Add cooking type");
define("BTN_ADMIN_COOKING_MODIFY", "Change cooking type");
define("BTN_ADMIN_COOKING_DELETE", "Delete cooking type");
//admin_delete.php
define("MSG_ADMIN_DELETE_SELECT", "Select the recipe to be deleted");
define("MSG_ADMIN_DELETE_SUCCESS", "Recipe deleted");
define("ERROR_ADMIN_DELETE_RECIPE", "Unable to delete recipe");
define("ERROR_ADMIN_DELETE_LETTER", "No recipe in database beginning with letter");
//admin_dish.php
define("MSG_ADMIN_SERVING_SUCCESS", "successfully added to available servings");
define("MSG_ADMIN_SERVING_ASKNEW", "Add new serving");
define("MSG_ADMIN_SERVING_CHANGED", "Serving changed to");
define("MSG_ADMIN_SERVING_DELETED", "Serving deleted");
define("BTN_ADMIN_SERVING_CHANGE", "Modify serving");
define("BTN_ADMIN_SERVING_ADD", "Add serving");
define("ERROR_ADMIN_SERVING_INPUT", "Serving name contains invalid characters");
define("ERROR_ADMIN_SERVING_DUPES", "Unable to check for duplicate servings");
define("ERROR_ADMIN_SERVING_INSERT", "Unable to add serving");
define("ERROR_ADMIN_SERVING_CHANGE", "Unable to change serving to");
define("ERROR_ADMIN_SERVING_DELETE", "Unable to delete requested serving");
define("ERROR_ADMIN_SERVING_RETRIEVE", "Unable to retrieve the list");
//admin_export.php
define("MSG_ADMIN_EXPORT_ASKTYPE", "Select filetype where you want to export all recipes");
define("BTN_ADMIN_EXPORT", "Export");
//admin_import.php
define("MSG_ADMIN_IMPORT_ASKTYPE", "Select filetype with recipes to be imported");
define("MSG_ADMIN_IMPORT_FILE", "Select filename or type full path");
define("BTN_ADMIN_IMPORT", "Importa");
//admin_modify.php
define("MSG_ADMIN_MODIFY_MISSING_NAME", "Recipe name is missing");
define("MSG_ADMIN_MODIFY_MISSING_MAIN", "Recipe main ingredient is missing");
define("MSG_ADMIN_MODIFY_MISSING_INGREDIENTS", "Recipe ingredients are missing");
define("MSG_ADMIN_MODIFY_MISSING_DESCRIPTION", "Recipe description is missing");
define("MSG_ADMIN_MODIFY_MISSING_COOKING", "Cooking type is missing");
define("MSG_ADMIN_MODIFY_MISSING_SERVING", "Serving is missing");
define("MSG_ADMIN_MODIFY_MISSING_DIFFICULTY", "Recipe difficulty grade is missing");
define("MSG_ADMIN_MODIFY_SUCCESS", "modified");
define("MSG_ADMIN_MODIFY_IMAGE", "Image");
define("MSG_ADMIN_MODIFY_VIDEO", "Video");
define("MSG_ADMIN_MODIFY_SELECT", "Select recipe you want to change");
define("ERROR_ADMIN_MODIFY_UNABLE", "Unable to change recipe");
define("BTN_ADMIN_MODIFY_RECIPE", "Change recipe");
//admin_userpass.php 
define("ERROR_ADMIN_USERPASS_START", "Unable to start admin username/password change procedure");
define("ERROR_ADMIN_USERPASS_END", "Unable to complete admin username/password change procedure");
define("ERROR_ADMIN_USERPASS_RETRIEVE", "Unable to verify admin username/password");
define("BTN_ADMIN_USERPASS_CHANGE", "Change admin username/password");
define("MSG_ADMIN_USERPASS_SUCCESS", "Admin username/password changed");
define("MSG_ADMIN_USERPASS_LOGIN", "Please login with the new admin username/password");
//admin_backup.php
define("MSG_ADMIN_BACKUP_SAVEDIR", "IBackup will be done in a SQL file saved into backup/ subdirectory");
define("MSG_ADMIN_BACKUP_OLDDEL", "Old backup file was deleted");
define("MSG_ADMIN_BACKUP_CRASHED", "Unable to continue backup");
define("MSG_ADMIN_BACKUP_BACKING", "Backing up database");
define("MSG_ADMIN_BACKUP_FILE", "Backup was saved into file");
define("MSG_ADMIN_BACKUP_RESTORE", "and can be restored from corresponding admin menu option");
define("BTN_ADMIN_BACKUP_PROCEED", "Backup database");
define("ERROR_ADMIN_BACKUP_SUBDIR", "Unable to write into backup/ subdirectory or subdirectory does not exist");
define("ERROR_ADMIN_BACKUP_TABLE", "Unable to backup table");
//admin_restore.php
define("MSG_ADMIN_RESTORE_SUBDIR", "Backed up data will be restored from backup/ subdirectory");
define("MSG_ADMIN_RESTORE_SUCCESS", "Data successfully restored");
define("BTN_ADMIN_RESTORE_PROCEED", "Restore data");
define("ERROR_ADMIN_RESTORE_FILE", "Backup file not found");
//includes/header_admin.inc.php
define("MSG_SITE_TITLE", "Foodie");
define("MSG_ADMIN_HEADER_RECIPES", "Recipes");
define("MSG_ADMIN_HEADER_SERVING", "Servings");
define("MSG_ADMIN_HEADER_COOKING", "Cooking types");
define("MSG_ADMIN_HEADER_CONFIG", "Setup");
define("MSG_ADMIN_HEADER_UTIL", "Utilities");
define("MSG_ADMIN_HEADER_BACKUP", "Backup");
define("MSG_ADMIN_HEADER_LOGOUT", "Logout from admin area");
define("MSG_ADMIN_HEADER_CLOSE", "Close application");
define("MSG_ADMIN_HEADER_INS", "Add");
define("MSG_ADMIN_HEADER_MOD", "Modify");
define("MSG_ADMIN_HEADER_DEL", "Delete");
define("MSG_ADMIN_HEADER_SETUP", "Change setup");
define("MSG_ADMIN_HEADER_USERPASS", "Change admin username/password");
define("MSG_ADMIN_HEADER_EXPORT", "Export database");
define("MSG_ADMIN_HEADER_IMP07", "Import recipes from CrisoftRicette 0.7");
define("MSG_ADMIN_HEADER_IMPORT", "Import from other file formats");
define("MSG_ADMIN_HEADER_OPT", "Optimize database");
define("MSG_ADMIN_HEADER_BKP", "Backup data");
define("MSG_ADMIN_HEADER_RST", "Restore data");
//includes/header_logout.inc.php
define("MSG_APP_RESTART", "Alkalmaz�s �jraind�t�sa");
//Export plugins
define("MSG_EXPORT_TXT_EXPORTING_MAIN", "Export main table to plain ASCII text file");
define("MSG_EXPORT_DELETE_OLD", "Deleting old file");
define("MSG_EXPORT_FILE_DONE", "Main table has been exported to file");
define("MSG_EXPORT_FILE_SINGLE", "Selected recipe has been exported to file");
define("MSG_EXPORT_BACK", "Back to export page");
define("MSG_EXPORT_TXT_EXPORTING_SINGLE", "Export selected recipe to plain ASCII text file");
define("ERROR_RETRIEVE_MAIN_TABLE", "Unable to retrieve data from main table");
define("ERROR_EXPORT_FILE_OPEN", "Unable to open file");
define("MSG_EXPORT_CSV_EXPORTING_MAIN", "Export main table to CSV file");
define("MSG_EXPORT_CSV_EXPORTING_SINGLE", "Export selected recipe into CSV file");
define("MSG_EXPORT_CW_EXPORTING_MAIN", "Export main table to Cookbook Wizard file");
define("MSG_EXPORT_CW_EXPORTING_SINGLE", "Export selected recipe into Cookbook Wizard file");
define("MSG_EXPORT_MM_EXPORTING_MAIN", "Export main table to MealMaster file");
define("MSG_EXPORT_MM_EXPORTING_SINGLE", "Export selected recipe to MealMaster file");
define("MSG_EXPORT_DBR_EXPORTING_MAIN", "Export main table to dbricette.it/Bekon Idealist Natural file");
define("MSG_EXPORT_DBR_EXPORTING_SINGLE", "Export selected recipe to dbricette.it/Bekon Idealist Natural file");
//Import plugins
define("ERROR_IMPORT_NOFILE", "Missing filename");
define("ERROR_IMPORT_FILESIZE_EXCEEDED", "Import file exceeds maximum filesize of 8 megabytes and is refused by the server"); 
define("ERROR_IMPORT_FILENAME_INVALID", "Illegal characters in filename");
define("ERROR_IMPORT_FILE_NOTFOUND", "File not found or not readable");
define("ERROR_IMPORT_FILE_UNREADABLE", "File not readable");
define("ERROR_IMPORT_FAILED", "Unable to import data into database");
define("ERROR_IMPORT_RECIPE_SUCCESS", "successfully imported");
define("ERROR_IMPORT_FILE_NORECIPES", "No recipes into the file or invaild file format");
define("MSG_IMPORT_MM_MAIN", "Import recipes from a file in MealMaster format");
define("MSG_IMPORT_DBR_MAIN", "Import recipes from a file in dbricette.it/Bekon Idealist Natural format");
define("MSG_IMPORT_COUNT_RECIPES", "Number of recipes in imported file");
//install.php
define("MSG_INSTALL_TITLE", "Installation");
define("MSG_INSTALL_FORM", "Fill in data to complete installation");
define("MSG_INSTALL_SERVER", "MySQL Configuration");
define("MSG_INSTALL_APPLICATION", "Software configuration");
define("MSG_INSTALL_ADMIN", "Administrator data");
define("MSG_INSTALL_FULL", "Please delete the database and reinstall");
define("BTN_INSTALL", "Install");
define("ERROR_INSTALL_IDENTICAL", "Administrator username could not be the same as the password");
define("ERROR_INSTALL_FAILURE", "Installation failure");
define("ERROR_INSTALL_LINES", "Lines per page should be a numeric value");
define("ERROR_INSTALL_CONNECTION", "Unable to connect to MySQL server");
define("ERROR_INSTALL_DATABASE", "Unable to create database");
define("ERROR_INSTALL_SELECT", "Unable to connect to database");
define("ERROR_INSTALL_TABLE", "Unable to create table");
define("ERROR_INSTALL_DATA", "Unable to add data to table");
define("ERROR_INSTALL_USERPASS", "Unable to verify already existing administrator username/password");
define("ERROR_INSTALL_NOMATCH", "Administrator username/password are not the same as already existing ones");
define("ERROR_INSTALL_ADMIN", "Unable to add administrator data");
define("ERROR_INSTALL_MANAGE", "Unable to manage administrator data");
define("ERROR_INSTALL_CHECK", "Unable to check if default data are already available in table");
define("ERROR_INSTALL_DEFAULT", "Unable to add default data to table");
define("ERROR_INSTALL_ADMINDEFAULT", "Do not use default administrator username and/or password");
define("ERROR_GENERIC", "Hiba");
define("ERROR_MAIL_SENDER", "Missing sender email address, can't continue");
?>
