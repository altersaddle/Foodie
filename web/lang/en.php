<?php
/*
***************************************************************************
* CrisoftRicette is a GPL licensed free software sofware written
* by Lorenzo Pulici, Milano, Italy (Earth) and is copyrighted by the
* author, 2002.
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
* If you can't browse the web please write an email to the software author
* at snowdog@tiscali.it
****************************************************************************
*/
/*
 *	Foodie language file
 *	Language: English
 *	Translated by: Lorenzo Pulici snowdog@tiscalinet.it
 *	File: lang/en.php
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
define("MSG_BROWSE", "Browse");
define("MSG_SEARCH", "Search");
define("MSG_INSERT", "Add");
define("MSG_COOKBOOK", "Personal cookbook");
define("MSG_SHOPPING", "Shopping list");
define("MSG_ADMIN", "Administration");
define("MSG_CLOSE", "Close application");
//includes/footer.inc.php
define("MSG_WRITTEN", "written by");
define("MSG_GPL_NOTICE", "Released under GNU GPL");
//index.php
define("MSG_UNABLE_DELETE_CONFIG", "Unable to delete configuration file");
define("ERROR_DB_NOT_EXIST", "Database does not exist");
define("MSG_REINSTALL", "Please reinstall the application");
define("MSG_CONTAINS", "Database contains");
define("MSG_RECIPES", "recipes");
//logout.php
define("MSG_THANKS", "Thanks for using");
//browse.php
define("ERROR_COUNT_RECIPES", "Unable to count number of recipes in database");
define("MSG_NO_RECIPES", "No recipes in database");
define("MSG_RECIPES_INITIAL", "No recipes in database beginning with letter");
define("MSG_SELECT_BROWSE", "Select how to browse database");
define("MSG_BROWSE_EMPTY", "Why browse an empty database");
define("MSG_ORDER_ID", "sorted by id");
define("MSG_ORDER_ALPHA", "alphabetically sorted");
define("MSG_ORDER_SERVING", "sorted by serving");
define("MSG_ORDER_MAIN", "sorted by main ingredent");
define("MSG_ORDER_KIND", "sorted by cooking type");
define("MSG_ORDER_ORIGIN", "sorted by origin");
define("MSG_ORDER_SEASON", "sorted by season");
define("MSG_ORDER_EASY", "sorted by difficulty - from the easiest");
define("MSG_ORDER_HARD", "sorted by difficulty - from the hardest");
define("ERROR_BROWSE", "Unable to browse database");
define("MSG_AVAILABLE_PAGES", "Available pages");
define("MSG_PREVIOUS", "Previous page");
define("MSG_NEXT", "Next page");
//foodielib.php
define("ERROR_PAGE_SIZE", " is not a valid configuration key for page_size");
define("MSG_USE_ONLY_VALUES", "Valid values");
define("ERROR_ILLEGAL_REQUEST", "Forbidden request");
define("MSG_WARNING", "Warning");
define("MSG_PAGE_RESTRICTED", "Restricted page not available");
define("MSG_NOT_LOGGED", "You are not logged in");
define("MSG_LOGIN_REQUEST", "Enter from admin area with username and password");
define("ERROR_MAIL_ADDRESS", "is not a valid email address");
define("MSG_BACK", "Back");
define("MSG_SECURITY_WARNING", "Security warning");
define("MSG_INPUT_FIELD", "Input field with value");
define("MSG_INPUT_DANGER", "has potentially dangerous characters");
define("ERROR_INPUT_REQUIRED", "Missing required data");
define("ERROR_CONFIG_NOT_SET", "One or more configuration kewords not set");
define("MSG_RESTART_INSTALL", "Please reinstall");
define("MSG_RECIPE_NAME", "Recipe name");
define("MSG_RECIPE_SERVING", "Meal");
define("MSG_RECIPE_MAIN", "Main ingredient");
define("MSG_RECIPE_PEOPLE", "Number of servings");
define("MSG_RECIPE_ORIGIN", "Origin");
define("MSG_RECIPE_SEASON", "Season");
define("MSG_RECIPE_COOKING", "Cooking type");
define("MSG_RECIPE_TIME", "Time required");
define("MSG_RECIPE_DIFFICULTY", "Difficulty");
define("MSG_RECIPE_WINES", "Suggested wines");
define("MSG_RECIPE_INGREDIENTS", "Ingredients");
define("MSG_RECIPE_DESCRIPTION", "Directions");
define("MSG_RECIPE_NOTES", "Notes");
define("MSG_NO_COOKING_TYPE", "No cooking type defined");
define("MSG_NO_SERVING", "No meal defined");
//recipe.php
define("ERROR_RECIPE_RETRIEVE", "Unable to retrieve requested recipe");
define("MSG_RECIPE_PRINTED", "Recipe printed by");
define("ERROR_UNEXPECTED", "Unexpected error");
define("ERROR_COUNT_VOTES", "Unable to count votes registered for");
define("MSG_RECIPE_VOTES_TOT", "Votes");
define("MSG_RECIPE_VOTES_AVG", "Average votes");
define("BTN_RATE_RECIPE", "Rate the recipe");
define("BTN_EMAIL", "Send by e-mail");
define("BTN_ADD_COOKBOOK", "Add to recipe book");
define("BTN_ADD_SHOPPING", "Add to shopping list");
define("BTN_PDF", "Create PDF");
define("BTN_PRINT", "Printer friendly");
define("MSG_RECIPE_NEVER_RATED", "This recipe has no votes");
define("ERROR_CHECK_COOKBOOK", "Unable to check personal cookbook");
define("MSG_ALREADY_COOKBOOK", "This recipe is already in your personal cookbook");
define("MSG_EXPORT_ASK", "Export this recipe into file format");
define("MSG_EXPORT", "Export");
define("ERROR_UNABLE_INSERT_TABLE", "Unable to add data to table");
//cookbook.php
define("ERROR_COOKBOOK_DUPLICATE" , "Unable to search for duplicates in personal cookbook");
define("ERROR_COOKBOOK_INSERT" , "Unable to add recipe to personal cookbook");
define("ERROR_COOKBOOK_SELECT" , "Unable to retrieve data from personal cookbook");
define("ERROR_COOKBOOK_DELETE" , "Unable to delete selected recipe from personal cookbook");
define("MSG_RECIPE", "Recipe");
define("MSG_COOKBOOK_PRESENT", "already in personal cookbook with id");
define("MSG_COOKBOOK_NORECIPES", "No recipes exist in personal cookbook");
define("MSG_COOKBOOK_NUMBER", "recipes in your personal cookbook");
define("MSG_COOKBOOK_READ", "Read personal cookbook");
define("MSG_COOKBOOK_DELETE", "Remove from personal cookbook");
define("MSG_COOKBOOK_DELETED", "removed from personal cookbook");
define("MSG_COOKBOOK_WELCOME", "Welcome to your personal cookbook");
define("MSG_COOKBOOK_INSERT", "added to your personal cookbook");
//export.php
define("MSG_EXPORT_SINGLE", "Export single recipe");
define("ERROR_EXPORT_RECIPE_CALL", "This script can be called only from recipe page");
//insert.php
define("ERROR_MISSING", "missing");
define("ERROR_INSERT_RECIPE", "Unable to insert recipe");
define("ERROR_INVALID_CHAR", "Invalid characters");
define("ERROR_INVALID_IMAGE", "Invalid image type");
define("ERROR_INVALID_VIDEO", "Invalid video type");
define("ERROR_FILE_IMAGE", "into image filename");
define("ERROR_FILE_VIDEO", "into video filename");
define("ERROR_DUPLICATE_IMAGE", "Unable to check if image is already in dabatase");
define("ERROR_DUPLICATE_VIDEO", "Unable to check if video is already in dabatase");
define("ERROR_EXIST_IMAGE", "Image filename already in use, please change it");
define("ERROR_EXIST_VIDEO", "Video filename already in use, please change it");
define("ERROR_UPLOAD", "upload error");
define("MSG_INSERT_VIDEOCLIP", "Video filename referring to recipe");
define("BTN_INSERT_VIDEOCLIP", "Upload video and add recipe");
define("MSG_INSERT_IMAGE", "Image filename referring to recipe");
define("BTN_INSERT_IMAGE", "Upload image and add recipe");
define("BTN_INSERT_RECIPE", "Insert recipe without video/image");
define("BTN_INSERT_PREVIEW", "Preview");
define("BTN_INSERT_CLEAR", "Reset");
define("MSG_INSERT_OK", "successfully inserted into database");
define("MSG_INSERT_IMAGE_OK", "successfully added to database with image");
define("MSG_INSERT_VIDEO_OK", "successfully added to database with video");
define("MSG_VALID_FORMAT", "Only those file formats are legal");
define("MSG_INSERT_HERE", "Add a new recipe to database");
define("MSG_SERVING_TABLE_EMPTY", "No servings defined");
define("MSG_COOKING_TABLE_EMPTY", "Non cooking types defined");
define("MSG_DIFFICULTY_TABLE_EMPTY", "No difficulty grades defined");
define("MSG_ASTERISK", "The asterisk indicates a required field");
define("MSG_GOTO_ADMIN", "Log in to admin area");
define("MSG_CHOOSE_SERVING", "Select serving");
define("MSG_CHOOSE_COOKING", "Select cooking type");
define("MSG_CHOOSE_DIFFICULTY", "Select difficulty");
define("MSG_NOT_SPECIFIED", "Not specified");
//license.php
define("MSG_GPL_LICENSE", "GNU/GPL License");
define("MSG_COPYRIGHT_NOTICE", "Copyright notice");
//mail.php
define("MSG_MAIL_TITLE", "Send recipe by e-mail");
define("MSG_MAIL_ADDRESS_REQUEST", "Insert recipient email address");
define("MSG_MAIL_DIFF", "on a total of");
define("BTN_MAIL_SEND", "Send email");
define("MSG_MAIL_SENT", "Recipe sent by");
define("MSG_MAIL_DOWNLOAD", "You can download it on you computer");
define("MSG_MAIL_WEBSITE", "connecting to website");
define("MSG_MAIL_DELIVERED", "Email with recipe has been delivered to SMTP server");
define("MSG_MAIL_AGAIN", "Send this recipe to another recipient");
//rate.php
define("MSG_RATE_TITLE", "Rate a recipe");
define("MSG_RATE_VOTE", "Cast your vote for this recipe");
define("MSG_RATE_POISON", "Poisonous");
define("MSG_RATE_VERYBAD", "Very bad");
define("MSG_RATE_BAD", "Bad");
define("MSG_RATE_NOTSOBAD", "Not so bad");
define("MSG_RATE_AVERAGE", "Average");
define("MSG_RATE_QUITEGOOD", "Quite good");
define("MSG_RATE_GOOD", "Good");
define("MSG_RATE_VERYGOOD", "Very good");
define("MSG_RATE_EXCELLENT", "Excellent");
define("MSG_RATE_PERFECTION", "The perfection");
define("BTN_RATE_THIS", "Rate this recipe");
define("MSG_RATE_RATED", "voted");
define("ERROR_RATE_REGISTERING", "Unable to register the vote for recipe");
define("MSG_RATE_YOURVOTE", "Your vote");
define("MSG_RATE_REGISTERED", "has been registered for recipe");
define("ERROR_RATE_COUNT", "Unable to count existing votes for recipe");
define("MSG_RATE_GOTVOTED", "Votes got from recipe");
define("MSG_RATE_AVGVOTE", "Average vote");
//search.php
define("MSG_SEARCH_TITLE", "Recipe search");
define("MSG_SEARCH_STRING", "Search string");
define("MSG_SEARCH_INSERT_STRING", "Enter one or more search terms, separated by spaces");
define("MSG_SEARCH_INSERT_FIELD", "Select search field");
define("MSG_SEARCH_ALLFIELDS", "On all fields");
define("MSG_SEARCH_INSERT_PARTIAL", "substrings are also allowed");
define("MSG_SEARCH_FOUND", "found in following recipes");
define("MSG_SEARCH_FIELD", "found in requested field of following recipes");
define("ERROR_SEARCH_DATABASE", "Unable to perform database search");
define("BTN_SEARCH", "Begin search");
//shopping.php
define("MSG_SHOPPING_TITLE", "Shopping list");
define("MSG_SHOPPING_ADDED", "add to shopping list");
define("MSG_SHOPPING_DELETED", "Recipe deleted from shopping list");
define("ERROR_SHOPPING_RETRIEVE_LIST", "Unable to retrieve shopping list");
define("ERROR_SHOPPING_RETRIEVE_RECIPE", "Unable to retrieve data of recipe you want to insert into shopping list");
define("ERROR_SHOPPING_INSERT", "Unable to add data to shopping list");
define("ERROR_SHOPPING_IDELETE", "Unable to delete data from shopping list");
define("MSG_SHOPPING_NODATA", "Shopping list is empty");
define("MSG_SHOPPING_SIGNATURE", "Shopping list generated by");
define("BTN_SHOPPING_DELETE", "Remove from shopping list");
define("BTN_SHOPPING_PRINT", "Printable version");
//admin_login.php
define("MSG_ADMIN_USERPASS_REQUEST", "Type username and password");
define("MSG_ADMIN_USER", "Username");
define("MSG_ADMIN_PASS", "Password");
define("MSG_ADMIN_LOGIN", "Login");
define("MSG_ADMIN_MAIN_MENU", "Main menu");
define("MSG_ADMIN_TITLE_RECIPE", "Recipes administration");
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
define("ERROR_ADMIN_COOKING_PRESENT", "already in database");
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
define("MSG_ADMIN_BACKUP_FILE", "Backup was saved to file");
define("MSG_ADMIN_BACKUP_RESTORE", "and can be restored from corresponding admin menu option");
define("BTN_ADMIN_BACKUP_PROCEED", "Backup database");
define("ERROR_ADMIN_BACKUP_SUBDIR", "Unable to write to backup/ subdirectory or subdirectory does not exist");
define("ERROR_ADMIN_BACKUP_TABLE", "Unable to backup table");
//admin_restore.php
define("MSG_ADMIN_RESTORE_SUBDIR", "Backed up data will be restored from backup/ subdirectory");
define("MSG_ADMIN_RESTORE_SUCCESS", "Data successfully restored");
define("BTN_ADMIN_RESTORE_PROCEED", "Restore data");
define("ERROR_ADMIN_RESTORE_FILE", "Backup file not found");
//includes/header_admin.inc.php
define("MSG_SITE_TITLE", "iPatch Chest o' Cookery");
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
define("MSG_APP_RESTART", "Restart application");
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
define("MSG_EXPORT_CSV_EXPORTING_SINGLE", "Export selected recipe to CSV file");
define("MSG_EXPORT_CW_EXPORTING_MAIN", "Export main table to Cookbook Wizard file");
define("MSG_EXPORT_CW_EXPORTING_SINGLE", "Export selected recipe to Cookbook Wizard file");
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
define("ERROR_IMPORT_FILE_NORECIPES", "No recipes in the file or invalid file format");
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
define("ERROR_GENERIC", "Error");
define("ERROR_MAIL_SENDER", "Missing sender email address, can't continue");
?>
