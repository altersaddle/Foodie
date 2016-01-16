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
 *	Language: italiano
 *	Translated by: Lorenzo Pulici snowdog@tiscalinet.it
 *	File: lang/it.php
 */
//messages added 1.0pre15b
define("MSG_SEARCH_NORECIPESFOUND", "Nessuna ricetta trovata in base ai termini di ricerca inseriti");
define("MSG_SEARCH_RECIPESFOUND", "Numero di ricette trovate in base ai termini di ricerca inseriti");
//messages added 1.0pre15
define("MSG_RECIPE_IMAGE_UNAVAILABLE", "Immagine non disponibile, inseriscine una");
define("MSG_RECIPE_VIDEO_UNAVAILABLE", "Videoclip non disponibile, inseriscine uno");
define("MSG_RECIPE_VIDEO_FILE", "Videoclip di questa ricetta");
define("MSG_ADMIN_MENU_MULTIMEDIA", "Gestione immagini e video");
define("MSG_ADMIN_MULTIMEDIA_IMAGE_AVAILABLE", "C'è già disponibile un'immagine per la ricetta");
define("MSG_ADMIN_MULTIMEDIA_VIDEO_AVAILABLE", "C'è già disponibile un video per la ricetta");
define("BTN_MMEDIA_INSERT_IMAGE", "Aggiungi l'immagine alla ricetta");
define("BTN_MMEDIA_INSERT_VIDEOCLIP", "Aggiungi il videoclip alla ricetta");
define("ERROR_ADMIN_MMEDIA_IMAGE_ADD", "Impossibile aggiungere l'immagine alla ricetta");
define("MSG_ADMIN_MMEDIA_IMAGE_ADDED", "immagine aggiunta alla ricetta");
define("MSG_ADMIN_MMEDIA_BACK_RECIPE", "Torna alla ricetta");
define("MSG_ADMIN_MMEDIA_DISPLAY_RECIPE", "Guarda la ricetta");
define("ERROR_ADMIN_MMEDIA_VIDEOCLIP_ADD", "Impossibile aggiungere il video alla ricetta");
define("MSG_ADMIN_MMEDIA_VIDEOCLIP_ADDED", "video aggiunto alla ricetta");
define("MSG_ADMIN_MMEDIA_RECIPE_SELECT", "Seleziona la ricetta alla quale aggiungere immagine/video");
define("BTN_ADMIN_MMEDIA_SELECT", "Seleziona questa ricetta");
define("MSG_ADMIN_HEADER_INDEX", "Indice amministrazione");
//includes/header.inc.php
define("MSG_BROWSE", "Consultazione");
define("MSG_SEARCH", "Ricerca");
define("MSG_INSERT", "Inserimento");
define("MSG_COOKBOOK", "Ricettario personale");
define("MSG_SHOPPING", "Lista della spesa");
define("MSG_ADMIN", "Area amministrativa");
define("MSG_CLOSE", "Chiudi applicazione");
//includes/footer.inc.php
define("MSG_WRITTEN", "scritto da");
define("MSG_GPL_NOTICE", "Rilasciato sotto licenza GNU GPL");
//index.php
define("MSG_UNABLE_DELETE_CONFIG", "Impossibile cancellare il file di configurazione");
define("ERROR_DB_NOT_EXIST", "Il database non esiste");
define("MSG_REINSTALL", "É necessario reinstallare l'applicazione");
define("MSG_CONTAINS", "Il database contiene");
define("MSG_RECIPES", "ricette");
//logout.php
define("MSG_THANKS", "Grazie per avere usato");
//browse.php
define("ERROR_COUNT_RECIPES", "Impossibile contare le ricette presenti nel database");
define("MSG_NO_RECIPES", "Non ci sono ricette nel database");
define("MSG_RECIPES_INITIAL", "Non ci sono ricette nel database che inizino con");
define("MSG_SELECT_BROWSE", "Modalità di consultazione del database");
define("MSG_BROWSE_EMPTY", "Perchè voler consultare un database vuoto");
define("MSG_ORDER_ID", "ordinato per id");
define("MSG_ORDER_ALPHA", "in ordine alfabetico");
define("MSG_ORDER_SERVING", "ordinato per portata");
define("MSG_ORDER_MAIN", "ordinato per ingrediente principale");
define("MSG_ORDER_KIND", "ordinato per tipo di cucina");
define("MSG_ORDER_ORIGIN", "ordinato per origine");
define("MSG_ORDER_SEASON", "ordinato per stagione");
define("MSG_ORDER_EASY", "ordinato per difficoltà - dal più facile");
define("MSG_ORDER_HARD", "ordinato per difficoltà - dal più difficile");
define("ERROR_BROWSE", "Impossibile consultare il database");
define("MSG_AVAILABLE_PAGES", "Pagine disponibili");
define("MSG_PREVIOUS", "Pagina precedente");
define("MSG_NEXT", "Prossima pagina");
//crisoftlib.php
define("ERROR_PAGE_SIZE", "non valida come chiave di configurazione page_size");
define("MSG_USE_ONLY_VALUES", "Valori ammissibili");
define("ERROR_ILLEGAL_REQUEST", "Richiesta non consentita");
define("MSG_WARNING", "Attenzione");
define("MSG_PAGE_RESTRICTED", "Pagina non disponibile in quanto appartenente ad area riservata");
define("MSG_NOT_LOGGED", "Non siete stati riconosciuti dal sistema di autenticazione");
define("MSG_LOGIN_REQUEST", "Fornire nome utente e password entrando dall'area di amministrazione");
define("ERROR_MAIL_ADDRESS", "non è un indirizzo email valido");
define("MSG_BACK", "Indietro");
define("MSG_SECURITY_WARNING", "Avviso di sicurezza");
define("MSG_INPUT_FIELD", "Il campo con il valore");
define("MSG_INPUT_DANGER", "contiene caratteri pericolosi per la sicurezza del sistema");
define("ERROR_INPUT_REQUIRED", "Dato obbligatorio mancante");
define("ERROR_CONFIG_NOT_SET", "Uno o più valori mancanti nel file di configurazione");
define("MSG_RESTART_INSTALL", "Ripetere l'installazione");
define("BTN_COOKBOOK_DEL", "Cancella dal ricettario");
define("MSG_RECIPE_NAME", "Nome ricetta");
define("MSG_RECIPE_SERVING", "Portata");
define("MSG_RECIPE_MAIN", "Ingrediente principale");
define("MSG_RECIPE_PEOPLE", "Persone");
define("MSG_RECIPE_ORIGIN", "Origine");
define("MSG_RECIPE_SEASON", "Stagione");
define("MSG_RECIPE_COOKING", "Tipo di cucina");
define("MSG_RECIPE_TIME", "Tempo di preparazione");
define("MSG_RECIPE_DIFFICULTY", "Difficoltà");
define("MSG_RECIPE_WINES", "Vini consigliati");
define("MSG_RECIPE_INGREDIENTS", "Ingredienti");
define("MSG_RECIPE_DESCRIPTION", "Descrizione");
define("MSG_RECIPE_NOTES", "Note");
define("MSG_NO_COOKING_TYPE", "Nessun tipo di cucina definito");
define("MSG_NO_SERVING", "Nessuna portata definita");
//recipe.php
define("ERROR_RECIPE_RETRIEVE", "Impossibile recuperare la ricetta richiesta");
define("MSG_RECIPE_PRINTED", "Ricetta stampata con");
define("ERROR_UNEXPECTED", "Errore imprevisto");
define("ERROR_COUNT_VOTES", "Impossibile contare i voti registrati per");
define("MSG_RECIPE_VOTES_TOT", "Voti ottenuti");
define("MSG_RECIPE_VOTES_AVG", "Voto medio");
define("BTN_RATE_RECIPE", "Vota la ricetta");
define("BTN_EMAIL", "Invia la ricetta per e-mail");
define("BTN_ADD_COOKBOOK", "Aggiungi al ricettario");
define("BTN_ADD_SHOPPING", "Aggiungi alla lista della spesa");
define("BTN_PDF", "Genera PDF");
define("BTN_PRINT", "Versione stampabile");
define("MSG_RECIPE_NEVER_RATED", "Questa ricetta non ha ricevuto voti");
define("ERROR_CHECK_COOKBOOK", "Impossibile controllare il ricettario personale");
define("MSG_ALREADY_COOKBOOK", "Ricetta già presente nel ricettario");
define("MSG_EXPORT_ASK", "Esporta la ricetta in un file nel formato");
define("MSG_EXPORT", "Esporta");
define("ERROR_UNABLE_INSERT_TABLE", "Impossibile inserire i dati nella tabella");
//cookbook.php
define("ERROR_COOKBOOK_DUPLICATE" , "Impossibile cercare i duplicati nel ricettario personale");
define("ERROR_COOKBOOK_INSERT" , "Impossibile inserire la ricetta nel ricettario personale");
define("ERROR_COOKBOOK_SELECT" , "Impossibile recuperare dati dal ricettario personale");
define("ERROR_COOKBOOK_DELETE" , "Impossibile cancellare la ricetta richiesta dal ricettario personale");
define("MSG_RECIPE", "Ricetta");
define("MSG_COOKBOOK_PRESENT", "già inserita nel ricettario personale con id");
define("MSG_COOKBOOK_NORECIPES", "Non ci sono ricette nel ricettario personale");
define("MSG_COOKBOOK_NUMBER", "ricette inserite nel ricettario personale");
define("MSG_COOKBOOK_READ", "Leggi il ricettario personale");
define("MSG_COOKBOOK_DELETE", "Cancellazione dal ricettario");
define("MSG_COOKBOOK_DELETED", "cancellata dal ricettario personale");
define("MSG_COOKBOOK_WELCOME", "Benvenuti nel vostro ricettario personale");
define("MSG_COOKBOOK_INSERT", "inserito nel ricettario personale");
//export.php
define("MSG_EXPORT_SINGLE", "Esportazione ricetta singola");
define("ERROR_EXPORT_RECIPE_CALL", "Questo script può essere chiamato soltanto dalla pagina di visualizzazione ricetta");
//insert.php
define("ERROR_MISSING", "mancante");
define("ERROR_INSERT_RECIPE", "Impossibile inserire la ricetta");
define("ERROR_INVALID_CHAR", "Caratteri non validi");
define("ERROR_INVALID_IMAGE", "Tipo di immagine non valido");
define("ERROR_INVALID_VIDEO", "Tipo di video non valido");
define("ERROR_FILE_IMAGE", "nel nome del file dell'immagine");
define("ERROR_FILE_VIDEO", "nel nome del file del video");
define("ERROR_DUPLICATE_IMAGE", "Impossibile controllare se l'immagine sia un duplicato di una già esistente");
define("ERROR_DUPLICATE_VIDEO", "Impossibile controllare se il video sia un duplicato di uno già esistente");
define("ERROR_EXIST_IMAGE", "Il nome del file dell'immagine è già in uso e va modificato");
define("ERROR_EXIST_VIDEO", "Il nome del file dell'immagine è già in uso e va modificato");
define("ERROR_UPLOAD", "errore di caricamento");
define("MSG_INSERT_VIDEOCLIP", "Nome del file del video relativo alla ricetta");
define("BTN_INSERT_VIDEOCLIP", "Carica il videoclip ed inserisci la ricetta");
define("MSG_INSERT_IMAGE", "Nome del file dell'immagine relativa alla ricetta");
define("BTN_INSERT_IMAGE", "Carica l'immagine ed inserisci la ricetta");
define("BTN_INSERT_RECIPE", "Inserisci la ricetta senza video/immagine");
define("BTN_INSERT_PREVIEW", "Anteprima");
define("BTN_INSERT_CLEAR", "Azzera");
define("MSG_INSERT_OK", "inserita con successo nel database");
define("MSG_INSERT_IMAGE_OK", "inserita con successo nel database con l'immagine");
define("MSG_INSERT_VIDEO_OK", "inserita con successo nel database con il video");
define("MSG_VALID_FORMAT", "Sono consentiti solo i seguenti formati");
define("MSG_INSERT_HERE", "Inserimento di una nuova ricetta nel database");
define("MSG_SERVING_TABLE_EMPTY", "Non vi sono portate definite");
define("MSG_COOKING_TABLE_EMPTY", "Non vi sono tipi di cucina definiti");
define("MSG_DIFFICULTY_TABLE_EMPTY", "Non vi sono gradi di difficoltà definiti");
define("MSG_ASTERISK", "L'asterisco indica un campo obbligatorio");
define("MSG_GOTO_ADMIN", "Accedi all'area di amministrazione per farlo");
define("MSG_CHOOSE_SERVING", "Seleziona la portata");
define("MSG_CHOOSE_COOKING", "Seleziona il tipo di cucina");
define("MSG_CHOOSE_DIFFICULTY", "Seleziona la difficoltà");
define("MSG_NOT_SPECIFIED", "Non specificato");
//license.php
define("MSG_GPL_LICENSE", "Licenza GNU/GPL");
//mail.php
define("MSG_MAIL_TITLE", "Invia la ricetta per e-mail");
define("MSG_MAIL_ADDRESS_REQUEST", "Inserisci l'indirizzo di posta elettronica al quale inviare la ricetta");
define("MSG_MAIL_DIFF", "su un totale di");
define("BTN_MAIL_SEND", "Invia l'email");
define("MSG_MAIL_SENT", "Ricetta inviata tramite");
define("MSG_MAIL_DOWNLOAD", "Puoi scaricare sul tuo computer");
define("MSG_MAIL_WEBSITE", "collegandoti al sito");
define("MSG_MAIL_DELIVERED", "Il messaggio di posta elettronica con la ricetta è stato inviato al server SMTP");
define("MSG_MAIL_AGAIN", "Vuoi inviare ancora la ricetta a qualcun altro");
//rate.php
define("MSG_RATE_TITLE", "Vota la ricetta");
define("MSG_RATE_VOTE", "Dai il tuo voto alla ricetta");
define("MSG_RATE_POISON", "Venefica");
define("MSG_RATE_VERYBAD", "Pessima");
define("MSG_RATE_BAD", "Schifosa");
define("MSG_RATE_NOTSOBAD", "Non così schifosa");
define("MSG_RATE_AVERAGE", "Nella media");
define("MSG_RATE_QUITEGOOD", "Abbastanza buona");
define("MSG_RATE_GOOD", "Buona");
define("MSG_RATE_VERYGOOD", "Molto buona");
define("MSG_RATE_EXCELLENT", "Eccellente");
define("MSG_RATE_PERFECTION", "La perfezione");
define("BTN_RATE_THIS", "Vota questa ricetta");
define("MSG_RATE_RATED", "votata");
define("ERROR_RATE_REGISTERING", "Impossibile registrare il tuo voto per la ricetta");
define("MSG_RATE_YOURVOTE", "Il tuo voto");
define("MSG_RATE_REGISTERED", "è stato registrato per la ricetta");
define("ERROR_RATE_COUNT", "Impossibile contare i voti già espressi per la ricetta");
define("MSG_RATE_GOTVOTED", "Voti ricevuti dalla ricetta");
define("MSG_RATE_AVGVOTE", "Voto medio della ricetta");
//search.php
define("MSG_SEARCH_TITLE", "Ricerca nel database");
define("MSG_SEARCH_STRING", "Stringa di ricerca");
define("MSG_SEARCH_INSERT_STRING", "Inserisci uno o più termini, separati da spazi, da cercare nel database");
define("MSG_SEARCH_INSERT_FIELD", "Seleziona il campo in cui effettuare la ricerca");
define("MSG_SEARCH_ALLFIELDS", "Su tutti i campi");
define("MSG_SEARCH_INSERT_PARTIAL", "è possibile anche inserire solo una parte di stringa");
define("MSG_SEARCH_FOUND", "trovata nelle seguenti ricette");
define("MSG_SEARCH_FIELD", "trovata nel campo richiesto delle seguenti ricette");
define("ERROR_SEARCH_DATABASE", "Impossibile effettuare ricerche nel database");
define("BTN_SEARCH", "Inizia la ricerca");
//shopping.php
define("MSG_SHOPPING_TITLE", "Lista della spesa");
define("MSG_SHOPPING_ADDED", "aggiunti alla lista della spesa");
define("MSG_SHOPPING_DELETED", "Ricetta eliminata dalla lista della spesa");
define("ERROR_SHOPPING_RETRIEVE_LIST", "Impossibile recuperare la lista della spesa salvata");
define("ERROR_SHOPPING_RETRIEVE_RECIPE", "Impossibile recuperare i dati della ricetta da inserire nella lista della spesa");
define("ERROR_SHOPPING_INSERT", "Impossibile inserire i dati nella lista della spesa");
define("ERROR_SHOPPING_IDELETE", "Impossibile cancellare i dati dalla lista della spesa");
define("MSG_SHOPPING_NODATA", "La lista della spesa è vuota");
define("MSG_SHOPPING_SIGNATURE", "La lista della spesa è stata generata da");
define("BTN_SHOPPING_DELETE", "Cancella dalla lista");
define("BTN_SHOPPING_PRINT", "Versione stampabile");
//admin_login.php
define("MSG_ADMIN_USERPASS_REQUEST", "Inserire nome utente e password");
define("MSG_ADMIN_USER", "Nome utente");
define("MSG_ADMIN_PASS", "Password");
define("MSG_ADMIN_LOGIN", "Accedi");
define("MSG_ADMIN_MAIN_MENU", "Menu principale");
define("MSG_ADMIN_TITLE_RECIPE", "Amministrazione ricette");
define("MSG_ADMIN_TITLE_SERVING", "Amministrazione portate");
define("MSG_ADMIN_TITLE_COOKING", "Amministrazione tipi di cucina");
define("MSG_ADMIN_TITLE_CONFIG", "Configurazione");
define("MSG_ADMIN_TITLE_UTIL", "Utilità");
define("MSG_ADMIN_TITLE_BACKUP", "Salvataggi");
define("MSG_ADMIN_TITLE_LOGOUT", "Uscita dall'area");
define("MSG_ADMIN_MENU_RECIPE_ADD", "Aggiungi una ricetta");
define("MSG_ADMIN_MENU_RECIPE_MOD", "Modifica una ricetta");
define("MSG_ADMIN_MENU_RECIPE_DEL", "Elimina una ricetta");
define("MSG_ADMIN_MENU_SERVING_ADD", "Aggiungi una portata");
define("MSG_ADMIN_MENU_SERVING_DEL", "Elimina una portata");
define("MSG_ADMIN_MENU_SERVING_MOD", "Modifica una portata");
define("MSG_ADMIN_MENU_COOKING_ADD", "Aggiungi un tipo di cucina");
define("MSG_ADMIN_MENU_COOKING_MOD", "Modifica un tipo di cucina");
define("MSG_ADMIN_MENU_COOKING_DEL", "Elimina un tipo di cucina");
define("MSG_ADMIN_MENU_CONFIG_USR", "Modifica nome utente/password dell'amministratore");
define("MSG_ADMIN_MENU_CONFIG_CFG", "Modifica la configurazione");
define("MSG_ADMIN_MENU_UTIL_IMP07", "Importa ricette dal database della versione 0.7.x");
define("MSG_ADMIN_MENU_UTIL_IMPFILES", "Importa da vari formati di file");
define("MSG_ADMIN_MENU_UTIL_EXPMAIN", "Esporta tutte le ricette");
define("MSG_ADMIN_MENU_UTIL_OPT", "Compatta il database");
define("MSG_ADMIN_MENU_BACKUP_BKP", "Salva l'intero database");
define("MSG_ADMIN_MENU_BACKUP_RST", "Ripristina il database");
define("MSG_ADMIN_LOGOUT", "Esci dall'area di amministrazione");
define("MSG_ADMIN_LOGOUT_FAST", "Uscita rapida dall'area di amministrazione");
define("ERROR_ADMIN_CHECK_DB", "Impossibile verificare nome utente e password");
define("ERROR_ADMIN_CHANGE_DEFAULT", "Cambiare immediatamente nome utente e password predefiniti");
define("ERROR_ADMIN_INVALID_USERNAME", "Nome utente non valido o nullo");
define("ERROR_ADMIN_INVALID_PASSWORD", "Password non valida o nulla");
define("ERROR_ADMIN_AUTHFAIL", "Nome utente e/o password non corretti");
//admin_import07.php
define("MSG_ADMIN_IMP07_FILL", "Inserire i dati richiesti eventualmente modificando quelli predefiniti");
define("MSG_ADMIN_IMP07_HOSTNAME", "Nome del server/indirizzo IP MySQL col database della versione 0.7");
define("MSG_ADMIN_IMP07_PORT", "Porta TCP/IP del server MySQL col database della versione 0.7");
define("MSG_ADMIN_IMP07_USER", "Nome utente MySQL col database della versione 0.7");
define("MSG_ADMIN_IMP07_PASS", "Password MySQL col database della versione 0.7");
define("MSG_ADMIN_IMP07_DBNAME", "Nome database MySQL della versione 0.7");
define("MSG_ADMIN_IMP07_SUCCESS", "Copio la ricetta");
define("BTN_ADMIN_IMP07_IMPORT", "Importa le ricette");
define("ERROR_ADMIN_IMP07_TITLE", "Importazione database versione 0.7 - Errore");
define("ERROR_ADMIN_IMP07_HOSTNAME", "non valido come nome del server/indirizzo IP");
define("ERROR_ADMIN_IMP07_PORT", "La porta TCP/IP deve avere un valore numerico");
define("ERROR_ADMIN_IMP07_SERVER", "Impossibile accedere al server MySQL col database versione 0.7");
define("ERROR_ADMIN_IMP07_SELECT", "Impossibile accedere al database della versione 0.7");
define("ERROR_ADMIN_IMP07_COPY", "Impossibile copiare i dati dal database della versione 0.7");
//admin_config.php
define("ERROR_ADMIN_CFG_HOSTNAME", "non valido come nome del server/indirizzo IP");
define("ERROR_ADMIN_CFG_PORT", "La porta TCP/IP deve avere un valore numerico");
define("ERROR_ADMIN_CFG_LINES", "Il valore impostato per il massimo numero di righe per pagina deve essere numerico");
define("ERROR_ADMIN_CFG_DELETE", "Impossibile cancellare il file di configurazione");
define("ERROR_ADMIN_CFG_UPDATE", "Impossibile aggiornare il file di configurazione");
define("ERROR_ADMIN_CFG_BELOW", "Salvare il testo sottostante nel file");
define("ERROR_ADMIN_CFG_RESTART", "quindi riavviare l'applicazione");
define("MSG_ADMIN_CFG_HOSTNAME", "Nome/indirizzo IP del server MySQL");
define("MSG_ADMIN_CFG_PORT", "Porta TCP/IP del server MySQL");
define("MSG_ADMIN_CFG_USER", "Nome utente MySQL");
define("MSG_ADMIN_CFG_PASS", "Password MySQL");
define("MSG_ADMIN_CFG_DBNAME", "Nome database MySQL");
define("MSG_ADMIN_CFG_LOCALE", "Lingua");
define("MSG_ADMIN_CFG_LINES", "Righe per pagina");
define("MSG_ADMIN_CFG_EMAIL", "Indirizzo di posta elettronica");
define("MSG_ADMIN_CFG_PAGESIZE", "Dimensione pagina per i file PDF");
define("BTN_ADMIN_CFG_CHANGE", "Modifica la configurazione");
//admin_cooking.php
define("MSG_ADMIN_COOKING_INS", "Inserimento tipi di cucina");
define("MSG_ADMIN_COOKING_DEL", "Cancellazione tipi di cucina");
define("MSG_ADMIN_COOKING_MOD", "Modifica tipi di cucina");
define("MSG_ADMIN_COOKING_TYPE", "Tipo di cucina");
define("MSG_ADMIN_COOKING_SAME", "Non sono consentiti due tipi di cucina con lo stesso nome");
define("MSG_ADMIN_COOKING_SUCCESS", "inserito nel database");
define("MSG_ADMIN_COOKING_NEW", "Inserimento nuovo tipo di cucina");
define("MSG_ADMIN_COOKING_CHANGED", "Modificato tipo di cucina");
define("MSG_ADMIN_COOKING_DELETED", "eliminato dai tipi di cucina disponibili");
define("ERROR_ADMIN_COOKING_DUPES", "Impossibile controllare i duplicati per il tipo di cucina");
define("ERROR_ADMIN_COOKING_PRESENT", "già inserito in precedenza nel database");
define("ERROR_ADMIN_COOKING_INSERT", "Impossibile inserire il tipo di cucina nel database");
define("ERROR_ADMIN_COOKING_MODIFY", "Impossibile modificare il tipo di cucina");
define("ERROR_ADMIN_COOKING_SINGLE", "Impossibile recuperare il tipo di cucina selezionato");
define("ERROR_ADMIN_COOKING_RETRIEVE", "Impossibile recuperare l'elenco dei tipi di cucina disponibili");
define("ERROR_ADMIN_COOKING_DELETE", "Impossibile eliminare il tipo di cucina selezionato");
define("BTN_ADMIN_COOKING_INSERT", "Inserisci il tipo di cucina");
define("BTN_ADMIN_COOKING_MODIFY", "Modifica il tipo di cucina");
define("BTN_ADMIN_COOKING_DELETE", "Elimina il tipo di cucina");
//admin_delete.php
define("MSG_ADMIN_DELETE_SELECT", "Seleziona la ricetta da eliminare");
define("MSG_ADMIN_DELETE_SUCCESS", "Ricetta eliminata");
define("ERROR_ADMIN_DELETE_RECIPE", "Impossibile eliminare la ricetta");
define("ERROR_ADMIN_DELETE_LETTER", "Non ci sono ricette nel database che inizino con la lettera");
//admin_dish.php
define("MSG_ADMIN_SERVING_SUCCESS", "inserita con successo nelle portate disponibili");
define("MSG_ADMIN_SERVING_ASKNEW", "Inserimento nuova portata");
define("MSG_ADMIN_SERVING_CHANGED", "Portata modificata in");
define("MSG_ADMIN_SERVING_DELETED", "Portata eliminata con successo");
define("BTN_ADMIN_SERVING_CHANGE", "Modifica la portata");
define("BTN_ADMIN_SERVING_ADD", "Inserisci la portata");
define("ERROR_ADMIN_SERVING_INPUT", "Il nome della portata contiene caratteri non validi");
define("ERROR_ADMIN_SERVING_DUPES", "Impossibile controllare i duplicati per la portata");
define("ERROR_ADMIN_SERVING_INSERT", "Impossibile inserire la portata");
define("ERROR_ADMIN_SERVING_CHANGE", "Impossibile modificare la portata in");
define("ERROR_ADMIN_SERVING_DELETE", "Impossibile eliminare la portata richiesta");
define("ERROR_ADMIN_SERVING_RETRIEVE", "Impossibile recuperare i dati relativi alle portate");
//admin_export.php
define("MSG_ADMIN_EXPORT_ASKTYPE", "Seleziona il tipo di file nel quale esportare tutte le ricette presenti nel database");
define("BTN_ADMIN_EXPORT", "Esporta");
//admin_import.php
define("MSG_ADMIN_IMPORT_ASKTYPE", "Seleziona il tipo di file dal quale importare le ricette nel database");
define("MSG_ADMIN_IMPORT_FILE", "Seleziona il file o scrivi il percorso completo");
define("BTN_ADMIN_IMPORT", "Importa");
//admin_modify.php
define("MSG_ADMIN_MODIFY_MISSING_NAME", "Manca il nome della ricetta");
define("MSG_ADMIN_MODIFY_MISSING_MAIN", "Manca l'ingrediente principale della ricetta");
define("MSG_ADMIN_MODIFY_MISSING_INGREDIENTS", "Ingredienti della ricetta mancanti");
define("MSG_ADMIN_MODIFY_MISSING_DESCRIPTION", "Descrizione della ricetta mancante");
define("MSG_ADMIN_MODIFY_MISSING_COOKING", "Tipo di cucina della ricetta mancante");
define("MSG_ADMIN_MODIFY_MISSING_SERVING", "Portata della ricetta mancante");
define("MSG_ADMIN_MODIFY_MISSING_DIFFICULTY", "Grado di difficoltà della ricetta mancante");
define("MSG_ADMIN_MODIFY_SUCCESS", "modificata con successo");
define("MSG_ADMIN_MODIFY_IMAGE", "Immagine");
define("MSG_ADMIN_MODIFY_VIDEO", "Video");
define("MSG_ADMIN_MODIFY_SELECT", "Seleziona la ricetta da modificare");
define("ERROR_ADMIN_MODIFY_UNABLE", "Impossibile modificare la ricetta");
define("BTN_ADMIN_MODIFY_RECIPE", "Modifica la ricetta");
//admin_userpass.php 
define("ERROR_ADMIN_USERPASS_START", "Impossibile iniziare la procedura di modifica del nome utente amministratore e/o della sua password");
define("ERROR_ADMIN_USERPASS_END", "Impossibile terminare la procedura di modifica del nome utente amministratore e/o della sua password");
define("ERROR_ADMIN_USERPASS_RETRIEVE", "Impossibile verificare il nome utente amministratore e/o lla sua password");
define("BTN_ADMIN_USERPASS_CHANGE", "Modifica nome utente/password");
define("MSG_ADMIN_USERPASS_SUCCESS", "Modifica del nome utente amministratore e/o della sua password effettuata con successo");
define("MSG_ADMIN_USERPASS_LOGIN", "Accedere nuovamente all'area di amministrazione con il nuovo nome utente e/o password");
//admin_backup.php
define("MSG_ADMIN_BACKUP_SAVEDIR", "Il salvataggio sarà effettuato sottoforma di file SQL nella sottodirectory backup/");
define("MSG_ADMIN_BACKUP_OLDDEL", "Il file di salvataggio precedente è stato eliminato");
define("MSG_ADMIN_BACKUP_CRASHED", "Impossibile continare il salvataggio del database");
define("MSG_ADMIN_BACKUP_BACKING", "Sto salvando il database");
define("MSG_ADMIN_BACKUP_FILE", "Il salvataggio è stato effettuato nel file");
define("MSG_ADMIN_BACKUP_RESTORE", "e può essere recuperato dalla corrispondente opzione del menu di amministrazione");
define("BTN_ADMIN_BACKUP_PROCEED", "Salva il database");
define("ERROR_ADMIN_BACKUP_SUBDIR", "Impossibile scrivere nella sottodirectory backup/ o sottodirectory inesistente");
define("ERROR_ADMIN_BACKUP_TABLE", "Impossibile salvare la tabella");
//admin_restore.php
define("MSG_ADMIN_RESTORE_SUBDIR", "I dati salvati saranno recuperati da quelli presenti nella sottodirectory backup/");
define("MSG_ADMIN_RESTORE_SUCCESS", "I dati sono stati recuperati con successo");

define("BTN_ADMIN_RESTORE_PROCEED", "Recupera i dati");
define("ERROR_ADMIN_RESTORE_FILE", "Impossibile trovare il file con il salvataggio");
//includes/header_admin.inc.php
define("MSG_SITE_TITLE", "Foodie");
define("MSG_ADMIN_HEADER_RECIPES", "Ricette");
define("MSG_ADMIN_HEADER_SERVING", "Portate");
define("MSG_ADMIN_HEADER_COOKING", "Tipi di cucina");
define("MSG_ADMIN_HEADER_CONFIG", "Configurazione");
define("MSG_ADMIN_HEADER_UTIL", "Utilità");
define("MSG_ADMIN_HEADER_BACKUP", "Salvataggi");
define("MSG_ADMIN_HEADER_LOGOUT", "Esci dall'area amministrativa");
define("MSG_ADMIN_HEADER_CLOSE", "Chiudi l'applicazione");
define("MSG_ADMIN_HEADER_INS", "Inserimento");
define("MSG_ADMIN_HEADER_MOD", "Modifica");
define("MSG_ADMIN_HEADER_DEL", "Eliminazione");
define("MSG_ADMIN_HEADER_SETUP", "Modifica configurazione");
define("MSG_ADMIN_HEADER_USERPASS", "Modifica utente/password");
define("MSG_ADMIN_HEADER_EXPORT", "Esporta database");
define("MSG_ADMIN_HEADER_IMP07", "Importa da CrisoftRicette 0.7");
define("MSG_ADMIN_HEADER_IMPORT", "Importa da altri formati");
define("MSG_ADMIN_HEADER_OPT", "Compatta il database");
define("MSG_ADMIN_HEADER_BKP", "Salvataggio dati");
define("MSG_ADMIN_HEADER_RST", "Recupera dati");
//includes/header_logout.inc.php
define("MSG_APP_RESTART", "Riavvia l'applicazione");
//Export plugins
define("MSG_EXPORT_TXT_EXPORTING_MAIN", "Esportazione della tabella principale in un file di testo");
define("MSG_EXPORT_DELETE_OLD", "Sto eliminando il file già esistente");
define("MSG_EXPORT_FILE_DONE", "La tabella principale del database è stata esportata nel file");
define("MSG_EXPORT_FILE_SINGLE", "La ricetta selezionata è stata esportata nel file");
define("MSG_EXPORT_BACK", "Torna alla pagina di esportazione dati");
define("MSG_EXPORT_TXT_EXPORTING_SINGLE", "Esportazione della ricetta selezionata in un file di testo");
define("ERROR_RETRIEVE_MAIN_TABLE", "Impossibile recuperare i dati dalla tabella principale");
define("ERROR_EXPORT_FILE_OPEN", "Impossibile aprire il file");
define("MSG_EXPORT_CSV_EXPORTING_MAIN", "Esportazione della tabella principale in un file CSV");
define("MSG_EXPORT_CSV_EXPORTING_SINGLE", "Esportazione della ricetta selezionata in un file CSV");
define("MSG_EXPORT_CW_EXPORTING_MAIN", "Esportazione della tabella principale in un file per Cookbook Wizard");
define("MSG_EXPORT_CW_EXPORTING_SINGLE", "Esportazione della ricetta selezionata in un file per Cookbook Wizard");
define("MSG_EXPORT_MM_EXPORTING_MAIN", "Esportazione della tabella principale in un file per MealMaster");
define("MSG_EXPORT_MM_EXPORTING_SINGLE", "Esportazione della ricetta selezionata in un file per Mealmaster");
define("MSG_EXPORT_DBR_EXPORTING_MAIN", "Esportazione della tabella principale in un file per dbricette.it/Bekon Idealist Natural");
define("MSG_EXPORT_DBR_EXPORTING_SINGLE", "Esportazione della ricetta selezionata in un file per dbricette.it/Bekon Idealist Natural");
//Import plugins
define("ERROR_IMPORT_NOFILE", "Non è stato indicato il nome del file");
define("ERROR_IMPORT_FILESIZE_EXCEEDED", "Il file da importare eccede la dimensione massima di 8 megabytes e sarà rifiutato dal server"); 
define("ERROR_IMPORT_FILENAME_INVALID", "Caratteri illegali nel nome del file");
define("ERROR_IMPORT_FILE_NOTFOUND", "File non trovato o illeggibile");
define("ERROR_IMPORT_FILE_UNREADABLE", "File illeggibile");
define("ERROR_IMPORT_FAILED", "Impossibile importare dati nel database");
define("ERROR_IMPORT_RECIPE_SUCCESS", "importata con successo");
define("ERROR_IMPORT_FILE_NORECIPES", "Non ci sono ricette nel file o il formato del file non è corretto");
define("MSG_IMPORT_MM_MAIN", "Importazione ricette da file in formato MealMaster");
define("MSG_IMPORT_DBR_MAIN", "Importazione ricette da file in formato dbricette.it/Bekon Idealist Natural");
define("MSG_IMPORT_COUNT_RECIPES", "Numero di ricette presenti nel file da importare");
//install.php
define("MSG_INSTALL_TITLE", "Installazione");
define("MSG_INSTALL_FORM", "Inserire i dati richiesti per effettuare l'installazione");
define("MSG_INSTALL_SERVER", "Configurazione MySQL");
define("MSG_INSTALL_APPLICATION", "Configurazione applicazione");
define("MSG_INSTALL_ADMIN", "Dati dell'amministratore");
define("MSG_INSTALL_FULL", "Eliminare il database e reinstallare");
define("BTN_INSTALL", "Installa");
define("ERROR_INSTALL_IDENTICAL", "Nome utente e password dell'amministratore non possono essere identici");
define("ERROR_INSTALL_FAILURE", "Errore nell'installazione");
define("ERROR_INSTALL_LINES", "Righe per pagina deve essere un valore numerico");
define("ERROR_INSTALL_CONNECTION", "Impossibile stabilire un collegamento col server MySQL");
define("ERROR_INSTALL_DATABASE", "Impossibile creare il database");
define("ERROR_INSTALL_SELECT", "Impossibile accedere il database");
define("ERROR_INSTALL_TABLE", "Impossibile creare la tabella");
define("ERROR_INSTALL_DATA", "Impossibile inserire i dati nella tabella");
define("ERROR_INSTALL_USERPASS", "Impossibile verificare nome utente e password già esistenti");
define("ERROR_INSTALL_NOMATCH", "Nome utente/password per l'amministratore forniti non corrispondono a quelli già presenti");
define("ERROR_INSTALL_ADMIN", "Impossibile inserire i dati dell'amministratore");
define("ERROR_INSTALL_MANAGE", "Impossibile gestire i dati dell'amministratore");
define("ERROR_INSTALL_CHECK", "Impossibile verificare se esistano già dati nella tabella");
define("ERROR_INSTALL_DEFAULT", "Impossibile inserire i dati predefiniti nella tabella");
define("ERROR_INSTALL_ADMINDEFAULT", "Non utilizzare nome utente e/o password predefiniti per l'amministratore");
define("ERROR_GENERIC", "Errore");
define("ERROR_MAIL_SENDER", "Indirizzo del mittente non presente, impossibile continuare");
?>
