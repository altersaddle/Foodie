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
define("MSG_BROWSE", "Böngészés");
define("MSG_SEARCH", "Keresõ");
define("MSG_INSERT", "Add");
define("MSG_COOKBOOK", "Kedvencek");
define("MSG_SHOPPING", "Bevásárlás");
define("MSG_ADMIN", "Admin");
define("MSG_CLOSE", "Alkalmazás bezárása");
define("MSG_ABOUT", "Névjegy");
//includes/footer.inc.php
define("MSG_WRITTEN", "írta");
define("MSG_GPL_NOTICE", "Kiadva a GNU GPL alatt");
//index.php
define("MSG_UNABLE_DELETE_CONFIG", "Nem törölhetõ a konfigurációs állomány");
define("ERROR_DB_NOT_EXIST", "Az adatbázis nem létezik");
define("MSG_REINSTALL", "Az alkalmazás újrateleítése szükséges");
define("MSG_CONTAINS", "Az adatbázis");
define("MSG_RECIPES", "receptet tartalmaz");
//logout.php
define("MSG_THANKS", "Remélem hasznos volt :D");
//browse.php
define("ERROR_COUNT_RECIPES", "Nem tudom, hogy az adatbázis hány receptet tartalmaz");
define("MSG_NO_RECIPES", "Az adatbázisban nincs recept");
define("MSG_RECIPES_INITIAL", "Nincs olyan recept, melyne elsõ betûje");
define("MSG_SELECT_BROWSE", "Hogyan szeretnél böngészni");
define("MSG_BROWSE_EMPTY", "Üres adatbázist nem böngészhetünk :D");
define("MSG_ORDER_ID", "azonosító szerint");
define("MSG_ORDER_ALPHA", "abc sorrendben");
define("MSG_ORDER_SERVING", "fogások szerint");
define("MSG_ORDER_MAIN", "fõ hozzávalók szerint");
define("MSG_ORDER_KIND", "az elkészítés módja szerint");
define("MSG_ORDER_ORIGIN", "származás szerint");
define("MSG_ORDER_SEASON", "szezon szerint");
define("MSG_ORDER_EASY", "nehézség szerint - a legkönnyebbtõl");
define("MSG_ORDER_HARD", "nehézség szerint - a legnehezebbtõl");
define("ERROR_BROWSE", "Nem böngészhetõ az adatbázis");
define("MSG_AVAILABLE_PAGES", "Oldal");
define("MSG_PREVIOUS", "Elõzõ oldal");
define("MSG_NEXT", "Következõ oldal");
//crisoftlib.php
define("ERROR_PAGE_SIZE", " nem valós beállítási kulcs az oldal méretét tekintve");
define("MSG_USE_ONLY_VALUES", "Érvényes értékek");
define("ERROR_ILLEGAL_REQUEST", "Kérés megtagadva");
define("MSG_WARNING", "Figyelem");
define("MSG_PAGE_RESTRICTED", "A védett oldal nem létezik");
define("MSG_NOT_LOGGED", "Nem vagyol naplózva");
define("MSG_LOGIN_REQUEST", "Belépés azonosító és jelszó megadásával");
define("ERROR_MAIL_ADDRESS", "nem valós email cím");
define("MSG_BACK", "Vissza");
define("MSG_SECURITY_WARNING", "Biztonsági figyelmeztetés");
define("MSG_INPUT_FIELD", "A beviteli mezõ értéke");
define("MSG_INPUT_DANGER", "potenciálisan veszélyes karaktereket tartalmaz");
define("ERROR_INPUT_REQUIRED", "Nincs meg a szükséges adat");
define("ERROR_CONFIG_NOT_SET", "Néhány konfigurációs kulcsszónak nincs értéke");
define("MSG_RESTART_INSTALL", "Újra kell engem telepíteni");
define("BTN_COOKBOOK_DEL", "Törlés a kedvencekbõl");
define("MSG_RECIPE_NAME", "Recept neve");
define("MSG_RECIPE_SERVING", "Fogás");
define("MSG_RECIPE_MAIN", "Fõbb hozzávalók");
define("MSG_RECIPE_PEOPLE", "Fõre");
define("MSG_RECIPE_ORIGIN", "Származás");
define("MSG_RECIPE_SEASON", "Szezon");
define("MSG_RECIPE_COOKING", "Elkészítés módja");
define("MSG_RECIPE_TIME", "Szükséges idõ");
define("MSG_RECIPE_DIFFICULTY", "Nehézség");
define("MSG_RECIPE_WINES", "Ajánlott bor");
define("MSG_RECIPE_INGREDIENTS", "Hozzávalók");
define("MSG_RECIPE_DESCRIPTION", "Leírás");
define("MSG_RECIPE_NOTES", "Megjegyzés");
define("MSG_NO_COOKING_TYPE", "Nincs megadva");
define("MSG_NO_SERVING", "Nincs megadva");
//recipe.php
define("ERROR_RECIPE_RETRIEVE", "A kért recept nem létezik");
define("MSG_RECIPE_PRINTED", "A recept forrása:");
define("ERROR_UNEXPECTED", "Csúnya hiba van valahol");
define("ERROR_COUNT_VOTES", "Nem tudom hányat szavazott");
define("MSG_RECIPE_VOTES_TOT", "Eddig");
define("MSG_RECIPE_VOTES_AVG", "szavazat érkezett, átlaguk jelenleg");
define("BTN_RATE_RECIPE", "Recept értékelése");
define("BTN_EMAIL", "Küldés emailben");
define("BTN_ADD_COOKBOOK", "Hozzáadás a kedvencekhez");
define("BTN_ADD_SHOPPING", "Hozzáadás a vásárló listához");
define("BTN_PDF", "PDF készítése");
define("BTN_PRINT", "Nyomtatóbarát megtekintés");
define("MSG_RECIPE_NEVER_RATED", "Ez a recept még nem kapott szavazatot");
define("ERROR_CHECK_COOKBOOK", "Nincsenek meg a kedvencek");
define("MSG_ALREADY_COOKBOOK", "Ez a recept a kedvenceid között van");
define("MSG_EXPORT_ASK", "Recept exportálása más formátumban");
define("MSG_EXPORT", "Export");
define("ERROR_UNABLE_INSERT_TABLE", "Nem tudom hozzáadni az adatot a táblához");
//cookbook.php
define("ERROR_COOKBOOK_DUPLICATE" , "Nem tudom van-e már ilyen a kedvenceid között");
define("ERROR_COOKBOOK_INSERT" , "Nem tudom betenni a kedvencek közé");
define("ERROR_COOKBOOK_SELECT" , "Nem tudok adatot kinyerni a kedvenceidbõl");
define("ERROR_COOKBOOK_DELETE" , "Nem tudom törölni a kedvenceid közül");
define("MSG_RECIPE", "A");
define("MSG_COOKBOOK_PRESENT", "már a kedvencek között van, azonosító");
define("MSG_COOKBOOK_NORECIPES", "Nincsenek kedvenc receptjeid");
define("MSG_COOKBOOK_NUMBER", "kedvenc recepted van jelenleg");
define("MSG_COOKBOOK_READ", "Kedvencek olvasása");
define("MSG_COOKBOOK_DELETE", "Törlés a kedvencekbõl");
define("MSG_COOKBOOK_DELETED", "törölve a kedvencekbõl");
define("MSG_COOKBOOK_WELCOME", "Ez itt kedvenc receptjeid gyüjteménye");
define("MSG_COOKBOOK_INSERT", "hozzáadva a kedvencekhez");
//export.php
define("MSG_EXPORT_SINGLE", "Recept exportálása");
define("ERROR_EXPORT_RECIPE_CALL", "Ez a script csak egy receptbõl hívható meg");
//insert.php
define("ERROR_MISSING", "nincs meg");
define("ERROR_INSERT_RECIPE", "Nem tudom létrehozni a receptet");
define("ERROR_INVALID_CHAR", "Hibás karakterek");
define("ERROR_INVALID_IMAGE", "Hibás képállomány");
define("ERROR_INVALID_VIDEO", "Hibás videóállomány");
define("ERROR_FILE_IMAGE", "a kép nevéhez");
define("ERROR_FILE_VIDEO", "a videó nevéhez");
define("ERROR_DUPLICATE_IMAGE", "Nem látom, hogy van-e már ilyen kép");
define("ERROR_DUPLICATE_VIDEO", "Nem látom, hogy van-e már ilyen videó");
define("ERROR_EXIST_IMAGE", "Ezen a néven már létezik kép");
define("ERROR_EXIST_VIDEO", "Ezen a néven már létezik videó");
define("ERROR_UPLOAD", "feltöltési hiba");
define("MSG_INSERT_VIDEOCLIP", "A recepthez kapcsolódó videóállomány");
define("BTN_INSERT_VIDEOCLIP", "Videó és recept felvitele");
define("MSG_INSERT_IMAGE", "A recepthez kapcsolódó képállomány");
define("BTN_INSERT_IMAGE", "Kép és recept felvitele");
define("BTN_INSERT_RECIPE", "Recept felvitele videó/kép nélkül");
define("BTN_INSERT_PREVIEW", "Elõnézet");
define("BTN_INSERT_CLEAR", "Újra");
define("MSG_INSERT_OK", "sikeresen bekerült az adatbázisba");
define("MSG_INSERT_IMAGE_OK", "sikeresen bekerült az adatbázisba, képpel együtt");
define("MSG_INSERT_VIDEO_OK", "sikeresen bekerült az adatbázisba, videóval együtt");
define("MSG_VALID_FORMAT", "Csak azok a formátumok használhatóak");
define("MSG_INSERT_HERE", "Új recept felvitele");
define("MSG_SERVING_TABLE_EMPTY", "Nincs megadott fogás");
define("MSG_COOKING_TABLE_EMPTY", "Nincs megadott mód");
define("MSG_DIFFICULTY_TABLE_EMPTY", "Nincs megadott nehézségi fok");
define("MSG_ASTERISK", "A csillaggal jelölt mezõk kitöltése szükséges");
define("MSG_GOTO_ADMIN", "Belépés az admin felületre");
define("MSG_CHOOSE_SERVING", "Add meg a megfelelõ fogást");
define("MSG_CHOOSE_COOKING", "Add meg az elkészítés módját");
define("MSG_CHOOSE_DIFFICULTY", "Add meg a bonyorultsági fokot");
define("MSG_NOT_SPECIFIED", "Nem megadott");
//license.php
define("MSG_GPL_LICENSE", "GNU/GPL Licensz");
//mail.php
define("MSG_MAIL_TITLE", "Recept küldése emailben");
define("MSG_MAIL_ADDRESS_REQUEST", "A célszemély email címe");
define("MSG_MAIL_DIFF", "on a total of");
define("BTN_MAIL_SEND", "Küldés");
define("MSG_MAIL_SENT", "A recept küldõje:");
define("MSG_MAIL_DOWNLOAD", "You can download it on you computer");
define("MSG_MAIL_WEBSITE", "connecting to website");
define("MSG_MAIL_DELIVERED", "A receptet sikeresen elküldtem.");
define("MSG_MAIL_AGAIN", "Esetleg el akarod küldeni még valakinek");
//rate.php
define("MSG_RATE_TITLE", "Recept értékelése");
define("MSG_RATE_VOTE", "Szavazz te is erre a receptre!");
define("MSG_RATE_POISON", "Mérgezõ");
define("MSG_RATE_VERYBAD", "Borzalmas");
define("MSG_RATE_BAD", "Rossz");
define("MSG_RATE_NOTSOBAD", "Nem is olyan rossz");
define("MSG_RATE_AVERAGE", "Átlagos");
define("MSG_RATE_QUITEGOOD", "Egész jó");
define("MSG_RATE_GOOD", " Jó");
define("MSG_RATE_VERYGOOD", "Nagyon jó");
define("MSG_RATE_EXCELLENT", "Menyjei");
define("MSG_RATE_PERFECTION", "Maga a tökély");
define("BTN_RATE_THIS", "Értékeld a receptet");
define("MSG_RATE_RATED", "szavazott");
define("ERROR_RATE_REGISTERING", "Nem tudom regisztrálni a szavazatodat");
define("MSG_RATE_YOURVOTE", "Választásod a következõ");
define("MSG_RATE_REGISTERED", ". Köszönöm, regisztráltam a véleményed.");
define("ERROR_RATE_COUNT", "Nem tudom megmondani neked hányan szavaztak a receptre");
define("MSG_RATE_GOTVOTED", "A receptre eddig ennyien szavaztak");
define("MSG_RATE_AVGVOTE", "Átlag eredmény");
//search.php
define("MSG_SEARCH_TITLE", "Recept keresése");
define("MSG_SEARCH_STRING", "Az általad keresett");
define("MSG_SEARCH_INSERT_STRING", "Írj egy, vagy több szót, szóközzel elválasztva");
define("MSG_SEARCH_INSERT_FIELD", "Hol keressek");
define("MSG_SEARCH_ALLFIELDS", "Mindenhol");
define("MSG_SEARCH_INSERT_PARTIAL", "elég, ha csak egy részét tudod megadni");
define("MSG_SEARCH_FOUND", "szó, a következõ receptekben szerepel");
define("MSG_SEARCH_FIELD", "szó, a kért helyen, a következõ receptekben szerepel");
define("ERROR_SEARCH_DATABASE", "Nem tudok keresni az adatbázisban");
define("BTN_SEARCH", "Keresés indítása");
//shopping.php
define("MSG_SHOPPING_TITLE", "Bevásárló lista");
define("MSG_SHOPPING_ADDED", "Vásárlási listához");
define("MSG_SHOPPING_DELETED", "A receptet töröltem a listából");
define("ERROR_SHOPPING_RETRIEVE_LIST", "Nem férek hozzá a listádhoz");
define("ERROR_SHOPPING_RETRIEVE_RECIPE", "Nem látom a receptet, amit hozzá kívánsz adni a listádhoz");
define("ERROR_SHOPPING_INSERT", "Nem tudom hozzáadni az adatokat a listádhoz");
define("ERROR_SHOPPING_IDELETE", "Nem tudom törölni a listából");
define("MSG_SHOPPING_NODATA", "A bevásárlólistád üres");
define("MSG_SHOPPING_SIGNATURE", "A listát én csináltam neked:");
define("BTN_SHOPPING_DELETE", "Törlés a listából");
define("BTN_SHOPPING_PRINT", "Nyomtatható verzió");
//admin_login.php
define("MSG_ADMIN_USERPASS_REQUEST", "Add meg az azonosítót és a hozzá tartozó jelszót!");
define("MSG_ADMIN_USER", "Azonosító");
define("MSG_ADMIN_PASS", "Jelszó");
define("MSG_ADMIN_LOGIN", "Belépés");
define("MSG_ADMIN_MAIN_MENU", "Fõmenü");
define("MSG_ADMIN_TITLE_RECIPE", "Recept adminisztráció");
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
define("MSG_APP_RESTART", "Alkalmazás újraindítása");
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
