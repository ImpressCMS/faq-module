<?php
/**
* English language constants related to module information
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

if (!defined("ICMS_ROOT_PATH")) die("ImpressCMS Basispfad ist nicht definiert");

// Module Info
// The name of this module

global $icmsModule;
define("_MI_FAQ_MD_NAME", "FAQ");
define("_MI_FAQ_MD_DESC", "Erweitertes Fragen und Antworten Management System für Deine ImpressCMS Website");

define("_MI_FAQ_INDEX", "Modulübersicht");
define("_MI_FAQ_FAQS", "FAQs");
define("_MI_FAQ_CATEGORYS", "Kategorien");
define("_MI_FAQ_ATTACHMENTS", "Attachments");
define("_MI_FAQ_IMPORT", "Importieren");

//Menu
define('_MI_FAQ_FAQ_ADD','Neu FAQ hinzufügen');
define('_MI_FAQ_REQUEST_ADD','Frage erstellen');

//Blocks
define('_MI_FAQ_CATEGLIST','Kategorieliste');
define('_MI_FAQ_CATEGLISTDSC','Dieser Block zeigt eine Kategorieliste mit Unterkategorien');
define('_MI_FAQ_RANDOM_DIDUNO','Zufall "Wußten Sie schon?"');
define('_MI_FAQ_RANDOM_DIDUNODSC','Block to show a random Did you know question');
define('_MI_FAQ_RECENT_QUESTIONS','Aktuelle Fragen');
define('_MI_FAQ_RECENT_QUESTIONSDSC','Block zum Anzeigen der letzten Fragen');

// Configs
define("_MI_FAQ_ALLOWSUBMIT", "Benutzer - FAQs einreichen");
define("_MI_FAQ_ALLOWSUBMITDSC", "Dürfen Benutzer neue FAQs in die Website einreichen?");
define("_MI_FAQ_ALLOWREQUEST", "Benutzer - Um Antwort bitten");
define("_MI_FAQ_ALLOWREQUESTDSC", "Dürfen Benutzer zu FAQs um Antworten bitten?");
define('_MI_FAQ_DATEFORMAT', 'Datumsformat');
define('_MI_FAQ_DATEFORMATDSC', 'Use the final part of language/english/global.php to select a display style. Example: "d-M-Y H:i" translates to "30-Mar-2004 22:35"');
define('_MI_FAQ_DISPLAY_TOPCAT_DSC', 'Zeigen die Beschreibung der Kategorien an?');
define('_MI_FAQ_DISPLAY_TOPCAT_DSCDSC', "Select 'Yes' to display the description of top categories in the index and category page.");
define('_MI_FAQ_TOPCAT_DSC_COUNT', 'Max. Länge der Beschreibung von den Hauptkategorien');
define('_MI_FAQ_TOPCAT_DSC_COUNTDSC', "Define how much characters will be displayed in the top category description.");
define('_MI_FAQ_DISPLAY_SUBCAT_INDEX', 'Zeige Unterkategorien in der Hauptseite an?');
define('_MI_FAQ_DISPLAY_SUBCAT_INDEXDSC', "Select 'Yes' to display subcategories on the index page.");
define('_MI_FAQ_DISPLAY_SUBCAT_DSC', 'Zeige die Beschreibungen der Unterkategorien an?');
define('_MI_FAQ_DISPLAY_SUBCAT_DSCDSC', "Select 'Yes' to display the description of sub-categories in the index and category page.");
define('_MI_FAQ_SUBCAT_DSC_COUNT', 'Max. Länge der Beschreibung von den Unterkategorie');
define('_MI_FAQ_SUBCAT_DSC_COUNTDSC', "Define how much characters will be displayed in the top category description.");
define('_MI_FAQ_DISPLAY_FAQ_ANSWER_SUBCAT', 'Display FAQ answers on sub-categories page?');
define('_MI_FAQ_DISPLAY_FAQ_ANSWER_SUBCATDSC', " ");
define('_MI_FAQ_FAQ_ANSWER_COUNT_SUBCAT', 'Max-length of the FAQ Answer on sub-categories page');
define('_MI_FAQ_FAQ_ANSWER_COUNT_SUBCATDSC', "Define how much characters will be displayed in the FAQ Answer on sub-categories page.");
define('_MI_FAQ_AUTOAPPROVE_SUB_FAQ', 'Neue FAQs automatisch veröffentlichen?');
define('_MI_FAQ_AUTOAPPROVE_SUB_FAQDSC', 'Bei JA werden neu hinzugefügte FAQs ohne Eingriff des Admins in der Website veröffentlicht.');
define('_MI_FAQ_SHOW_FAQ_INFO', 'Zeige FAQs Info?');
define('_MI_FAQ_SHOW_FAQ_INFO_DSC', 'Bei "JA" werden Zusatzinformationen angezeigt: Autor, Veröffentlichungsdatum und ein Zähler.');
define("_MI_FAQ_LIMIT", "FAQs Limit");
define("_MI_FAQ_LIMITDSC", "Anzahl der FAQs die in der Benutzerseite angezeigt werden soll.");
define("_MI_FAQ_CATSLIMIT", "Limit für Kategorien");
define("_MI_FAQ_CATSLIMITDSC", "Anzahl der Kategorien die in der Benutzerseite angezeigt werden sollen.");
define("_MI_FAQ_SEOMODNAME", "SEO module name");
define("_MI_FAQ_SEOMODNAMEDSC", "This will be used when generating SEO URL. The name you choose here also needs to be used to customize your htaccess file.");
define("_MI_FAQ_SEOMODE", "SEO mode");
define("_MI_FAQ_SEOMODEDSC", "Choose from SEO technique.");
define('_MI_FAQ_REQUESTINTROMSG', 'Request introduction message');
define('_MI_FAQ_REQUESTINTROMSGDSC', 'Introduction message to be displayed in the Request a FAQ page of the module.');
define('_MI_FAQ_REQUESTINTROMSG_DEF', "Sie haben schon die Suche als Hilfe verwendet, aber keine Antwort auf Ihre Frage gefunden? Kein Problem! Einfach das folgende Formular ausfüllen und somit eine neue Anfrage erstellen. Vergewissern Sie sich bitte, das Ihre frage aussagekräftig ist! Der Admin wird sich Ihre Frage ansehen und veröffentlichen, so können andere Benutzer schnell auf Ihre Frage reagieren."); 
define("_MI_FAQ_HEADER", "Willkommensnachricht in der Startseite des Modules");
define("_MI_FAQ_HEADERDSC", "Welcome message to be displayed in the index page of the module.");
define('_MI_FAQ_HEADER_DEF', "In this area of our site, you will find the answers to the frequently asked questions. Please feel free to post a comment on any FAQ.");
define("_MI_FAQ_FOOTER", "Fusszeile im Modul");
define("_MI_FAQ_FOOTERDSC", "The content you put here will be shown in all pages of the module on user side. Leave empty to not show.");
define("_MI_FAQ_FOOTER_DEF", "");
define('_MI_FAQ_USEREALNAME', 'Zeige den echten Namen der Benutzer an?');
define('_MI_FAQ_USEREALNAMEDSC', 'When displaying a username, use the real name of that user if he has a set his real name.');
define('_MI_FAQ_DEFAULT_CATVIEWPERM', 'Default Category View Permission');
define('_MI_FAQ_DEFAULT_CATVIEWPERMDSC', 'Define the groups that will have by default view permission of each category. When creating or editing a category you can always change the permissions.');
define('_MI_FAQ_DEFAULT_CATWRITEPERM', 'Default Category Write Permission');
define('_MI_FAQ_DEFAULT_CATWRITEPERMDSC', 'Define the groups that will have by default write permission of each category. When creating or editing a category you can always change the permissions.');
define('_MI_FAQ_ENABLEATTACHMENTS', 'Enable the Attachment feature?');
define('_MI_FAQ_ENABLEATTACHMENTSDSC', 'The attachment feature allow you "attach" items for other modules in the FAQ. The attachment feature uses plugins to connect other modules and allow select and show their contents. Select "'._YES.'" to show the option in the FAQ form on admin side.');

define('_MI_FAQ_CATEGS_ORDER', 'Sortiere Kategorien/Unterkategorien nach');
define('_MI_FAQ_CATEGS_ORDERDSC', 'Select how to sort the categories/subcategories list on index page.');
define('_MI_FAQ_FAQS_ORDER', 'Sortiere FAQs nach');
define('_MI_FAQ_FAQS_ORDERDSC', 'Select how tp sort the FAQs list on categories page.');

define('_MI_FAQ_SORT_WEIGHT', 'Sortierung auswählen');
define('_MI_FAQ_SORT_PUBDATEASC', 'Veröffentlichungsdatum aufsteigend');
define('_MI_FAQ_SORT_PUBDATEDESC', 'Veröffentlichungsdatum absteigend');

// Notifications
define('_MI_FAQ_GLOBAL_FAQ_NOTIFY', "Globale FAQs");
define('_MI_FAQ_GLOBAL_FAQ_NOTIFY_DSC', "Notification options that apply to all FAQs.");

define('_MI_FAQ_FAQ_NOTIFY', "FAQ");
define('_MI_FAQ_FAQ_NOTIFY_DSC', "Notification options that apply to the current FAQ.");

define('_MI_FAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY', "FAQ vorgeschlagen");
define('_MI_FAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY_CAP', "Notify me when any FAQ is submitted and is awaiting approval.");
define('_MI_FAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY_DSC', "Receive notification when any FAQ is submitted and is waiting approval.");
define('_MI_FAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} auto-notify : New FAQ submitted");

define('_MI_FAQ_FAQ_APPROVED_NOTIFY', "FAQ genehmigt");
define('_MI_FAQ_FAQ_APPROVED_NOTIFY_CAP', "Notify me when this FAQ is approved.");
define('_MI_FAQ_FAQ_APPROVED_NOTIFY_DSC', "Receive notification when this FAQ is approved.");
define('_MI_FAQ_FAQ_APPROVED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} auto-notify : FAQ approved");

define("_MI_FAQ_GLOBAL_FAQ_NEW_NOTIFY", "Neue FAQ");
define("_MI_FAQ_GLOBAL_FAQ_NEW_NOTIFY_CAP", "Notify me when any new FAQ is published.");
define("_MI_FAQ_GLOBAL_FAQ_NEW_NOTIFY_DSC", "");
define("_MI_FAQ_GLOBAL_FAQ_NEW_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New FAQ published");
?>