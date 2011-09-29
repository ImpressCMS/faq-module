<?php
/**
* English language constants used in admin section of the module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/
if (!defined("ICMS_ROOT_PATH")) die("ImpressCMS Basispfad ist nicht definiert");

// Requirements
define("_AM_FAQ_REQUIREMENTS", "FAQ Voraussetzungen");
define("_AM_FAQ_REQUIREMENTS_INFO", "We've reviewed your system, unfortunately it doesn't meet all the requirements needed for FAQ to function. Below are the requirements needed.");
define("_AM_FAQ_REQUIREMENTS_ICMS_BUILD", "FAQ requires at least ImpressCMS 1.1.1 RC 1.");
define("_AM_FAQ_REQUIREMENTS_SUPPORT", "Should you have any question or concerns, please visit our forums at <a href='http://community.impresscms.org'>http://community.impresscms.org</a>.");

// general
define("_AM_FAQ_FIRST_USE", "This is the first time you access this module. Please update the module in order to dynamically create the database scheme.");
define("_AM_FAQ_ATTACH", "Attach");
define("_AM_FAQ_ATTACH_WARNING", "Warnung");
define("_AM_FAQ_ATTACH_WARNING_MSG", "You need to select at least one item to Attach!");
define("_AM_FAQ_ATTACH_WARNING_HAS_ATTACH", "You attached some items to this FAQ, are you sure that want to cancel the FAQ creation?<br />The attached items will be deleted!");

define("_AM_FAQ_NOPLUGINS", "<h2>Keine passende Plugins gefunden.</h2>");

// Faq
define("_AM_FAQ_FAQS", "FAQs");
define("_AM_FAQ_FAQS_DSC", "Alle FAQs im Modul");
define("_AM_FAQ_FAQ_CREATE", "FAQ hinzufügen");
define("_AM_FAQ_FAQ", "FAQ");
define("_AM_FAQ_FAQ_CREATE_INFO", "Fill-out the following form to create a new faq.");
define("_AM_FAQ_FAQ_EDIT", "FAQ bearbeiten");
define("_AM_FAQ_FAQ_EDIT_INFO", "Fill-out the following form in order to edit this faq.");
define("_AM_FAQ_FAQ_MODIFIED", "The faq was successfully modified.");
define("_AM_FAQ_FAQ_CREATED", "The faq has been successfully created.");
define("_AM_FAQ_FAQ_VIEW", "FAQ info");
define("_AM_FAQ_FAQ_VIEW_DSC", "Here is the info about this faq.");
define("_AM_FAQ_FAQ_ATTACH", "Anhang hinzufügen");

// Category
define("_AM_FAQ_CATEGORYS", "Kategorien");
define("_AM_FAQ_CATEGORYS_DSC", "Alle Kategorien in diesem Modul");
define("_AM_FAQ_CATEGORY_CREATE", "Kategorie hinzufügen");
define("_AM_FAQ_CATEGORY", "Kategorie");
define("_AM_FAQ_CATEGORY_CREATE_INFO", "Fill-out the following form to create a new category.");
define("_AM_FAQ_CATEGORY_EDIT", "Kategorie bearbeiten");
define("_AM_FAQ_CATEGORY_EDIT_INFO", "Fill-out the following form in order to edit this category.");
define("_AM_FAQ_CATEGORY_MODIFIED", "The category was successfully modified.");
define("_AM_FAQ_CATEGORY_CREATED", "The category has been successfully created.");
define("_AM_FAQ_CATEGORY_VIEW", "Kategorieinfo");
define("_AM_FAQ_CATEGORY_VIEW_DSC", "Here is the info about this category.");

// Attachment
define("_AM_FAQ_ATTACHMENTS", "Attachments");
define("_AM_FAQ_ATTACHMENT_CREATE", "Add an attachment");
define("_AM_FAQ_ATTACHMENT", "Attachment");
define("_AM_FAQ_ATTACHMENT_CREATE_INFO", "Fill-out the following form to create a new attachment.");
define("_AM_FAQ_ATTACHMENT_EDIT", "Edit this attachment");
define("_AM_FAQ_ATTACHMENT_EDIT_INFO", "Fill-out the following form in order to edit this attachment.");
define("_AM_FAQ_ATTACHMENT_MODIFIED", "The attachment was successfully modified.");
define("_AM_FAQ_ATTACHMENT_CREATED", "The attachment has been successfully created.");
define("_AM_FAQ_ATTACHMENT_VIEW", "Attachment info");
define("_AM_FAQ_ATTACHMENT_VIEW_DSC", "Here is the info about this attachment.");

define("_AM_FAQ_ATTACHMENT_DELETE", "Click to delete this attachment");
define("_AM_FAQ_ATTACHMENT_HIDE", "Click to hide this attachment on User-side");
define("_AM_FAQ_ATTACHMENT_SHOW", "Click to show this attachment on User-side");
define("_AM_FAQ_ATTACHMENT_SORT", "Drag to sort this attachment");



define("_AM_FAQ_CANCEL", "Abbrechen");
define("_AM_FAQ_IMPORT", "Importieren");
define("_AM_FAQ_IMPORTED_COMMENT", "Kommentare '%s' importiert.");
define("_AM_FAQ_IMPORTED_COMMENT_ERROR", "Error while importing comment '%s'");
define("_AM_FAQ_IMPORT_COMMENTS", "Importing comments of the module");
define("_AM_FAQ_IMPORT_ALL_PARTNERS", "All articles");
define("_AM_FAQ_IMPORTED_ARTICLE_FILE", "Linked file %s was imported");
define("_AM_FAQ_IMPORT_ARTICLE_ERROR", "Error while importing article <em>%s</em>");
define("_AM_FAQ_IMPORT_ARTICLE_WRAP", "The pagewraped file %s has been copied in the module's content folder.");
define("_AM_FAQ_IMPORT_AUTOAPPROVE", "Auto-approve");
define("_AM_FAQ_IMPORT_BACK", "Back to the import page");
define("_AM_FAQ_IMPORT_CATEGORIES", "Categories to be imported");
define("_AM_FAQ_IMPORT_CATEGORIES_DSC", "Here are the categories that will be imported in SmartSection");
define("_AM_FAQ_IMPORT_CATEGORY_ERROR", "Error while importing category <em>%s</em>.");
define("_AM_FAQ_IMPORT_CATEGORY_PERMISSION_ERROR", "Error while importing category <em>%s</em> permissions.");
define("_AM_FAQ_IMPORT_CATEGORY_SUCCESS", "Category <em>%s</em> imported successfully.");
define("_AM_FAQ_IMPORT_ERROR", "An error occured while importing the article.");
define("_AM_FAQ_IMPORT_FILE_NOT_FOUND", "Import file not found at <b>%s</b>");
define("_AM_FAQ_IMPORT_FROM", "Importieren von %s");
define("_AM_FAQ_IMPORT_GOTOMODULE", "Go SmartSection's index page");
define("_AM_FAQ_IMPORT_INFO", "You can import articles directly in SmartSection. Simply select from which module you would like to import the articles and click on the 'Import' button.<br><b>Run this operation only once, otherwise, the articles will be dupplicated</b>");
define("_AM_FAQ_IMPORT_MODULE_FOUND", "%s module was found. There are %s articles and %s categories that can be imported.");
define("_AM_FAQ_IMPORT_MODULE_FOUND_NO_ITEMS", "%s module was found but there are no article to import.");
define("_AM_FAQ_IMPORT_NOCATSELECTED", "No category was selected for import.");
define("_AM_FAQ_IMPORT_NO_MODULE", "Da kein anderes unterstütztes Modul installiert wurde, können keine Artikel importiert werden.");
define("_AM_FAQ_IMPORT_NO_CATEGORY", "There are no categories to import.");
define("_AM_FAQ_IMPORT_PARENT_CATEGORY", "Hauptkategorie");
define("_AM_FAQ_IMPORT_PARENT_CATEGORY_DSC", "Import selected categories in this parent category.");
define("_AM_FAQ_IMPORT_PARTNER_ERROR", "An error occured while importing '%s'.");
define("_AM_FAQ_IMPORT_RESULT", "Here is the result of the import.");
define("_AM_FAQ_IMPORT_SETTINGS", "Import Settings");
define("_AM_FAQ_IMPORT_SUCCESS", "The articles were successfully imported in the module.");
define("_AM_FAQ_IMPORT_TITLE", "Import Articles");
define("_AM_FAQ_IMPORTED_ARTICLE", "Imported article : <em>%s</em>");
define("_AM_FAQ_IMPORTED_ARTICLES", "Articles imported : <em>%s</em>");
define("_AM_FAQ_IMPORTED_CATEGORY", "Imported category : <em>%s</em>");
define("_AM_FAQ_IMPORTED_CATEGORIES", "Categories imported : <em>%s</em>");
define("_AM_FAQ_IMPORT_SELECTION", "Import Selection");
define("_AM_FAQ_IMPORT_SELECT_FILE", "Articles");
define("_AM_FAQ_IMPORT_SELECT_FILE_DSC", "Choose the module from which to import the articles.");
?>