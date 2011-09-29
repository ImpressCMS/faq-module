<?php
/**
* English language constants used in admin section of the module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/
if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

// Requirements
define("_AM_IMFAQ_REQUIREMENTS", "imFAQ Requirements");
define("_AM_IMFAQ_REQUIREMENTS_INFO", "We've reviewed your system, unfortunately it doesn't meet all the requirements needed for imFAQ to function. Below are the requirements needed.");
define("_AM_IMFAQ_REQUIREMENTS_ICMS_BUILD", "imFAQ requires at least ImpressCMS 1.1.1 RC 1.");
define("_AM_IMFAQ_REQUIREMENTS_SUPPORT", "Should you have any question or concerns, please visit our forums at <a href='http://community.impresscms.org'>http://community.impresscms.org</a>.");

// general
define("_AM_IMFAQ_FIRST_USE", "This is the first time you access this module. Please update the module in order to dynamically create the database scheme.");
define("_AM_IMFAQ_ATTACH", "Attach");
define("_AM_IMFAQ_ATTACH_WARNING", "Warning");
define("_AM_IMFAQ_ATTACH_WARNING_MSG", "You need to select at least one item to Attach!");
define("_AM_IMFAQ_ATTACH_WARNING_HAS_ATTACH", "You attached some items to this FAQ, are you sure that want to cancel the FAQ creation?<br />The attached items will be deleted!");

define("_AM_IMFAQ_NOPLUGINS", "<h2>You don't have any avaliable plugins.</h2>");

// Faq
define("_AM_IMFAQ_FAQS", "Faqs");
define("_AM_IMFAQ_FAQS_DSC", "All faqs in the module");
define("_AM_IMFAQ_FAQ_CREATE", "Add a faq");
define("_AM_IMFAQ_FAQ", "Faq");
define("_AM_IMFAQ_FAQ_CREATE_INFO", "Fill-out the following form to create a new faq.");
define("_AM_IMFAQ_FAQ_EDIT", "Edit this faq");
define("_AM_IMFAQ_FAQ_EDIT_INFO", "Fill-out the following form in order to edit this faq.");
define("_AM_IMFAQ_FAQ_MODIFIED", "The faq was successfully modified.");
define("_AM_IMFAQ_FAQ_CREATED", "The faq has been successfully created.");
define("_AM_IMFAQ_FAQ_VIEW", "Faq info");
define("_AM_IMFAQ_FAQ_VIEW_DSC", "Here is the info about this faq.");
define("_AM_IMFAQ_FAQ_ATTACH", "Add attachments");

// Category
define("_AM_IMFAQ_CATEGORYS", "Categorys");
define("_AM_IMFAQ_CATEGORYS_DSC", "All categorys in the module");
define("_AM_IMFAQ_CATEGORY_CREATE", "Add a category");
define("_AM_IMFAQ_CATEGORY", "Category");
define("_AM_IMFAQ_CATEGORY_CREATE_INFO", "Fill-out the following form to create a new category.");
define("_AM_IMFAQ_CATEGORY_EDIT", "Edit this category");
define("_AM_IMFAQ_CATEGORY_EDIT_INFO", "Fill-out the following form in order to edit this category.");
define("_AM_IMFAQ_CATEGORY_MODIFIED", "The category was successfully modified.");
define("_AM_IMFAQ_CATEGORY_CREATED", "The category has been successfully created.");
define("_AM_IMFAQ_CATEGORY_VIEW", "Category info");
define("_AM_IMFAQ_CATEGORY_VIEW_DSC", "Here is the info about this category.");

// Attachment
define("_AM_IMFAQ_ATTACHMENTS", "Attachments");
define("_AM_IMFAQ_ATTACHMENT_CREATE", "Add an attachment");
define("_AM_IMFAQ_ATTACHMENT", "Attachment");
define("_AM_IMFAQ_ATTACHMENT_CREATE_INFO", "Fill-out the following form to create a new attachment.");
define("_AM_IMFAQ_ATTACHMENT_EDIT", "Edit this attachment");
define("_AM_IMFAQ_ATTACHMENT_EDIT_INFO", "Fill-out the following form in order to edit this attachment.");
define("_AM_IMFAQ_ATTACHMENT_MODIFIED", "The attachment was successfully modified.");
define("_AM_IMFAQ_ATTACHMENT_CREATED", "The attachment has been successfully created.");
define("_AM_IMFAQ_ATTACHMENT_VIEW", "Attachment info");
define("_AM_IMFAQ_ATTACHMENT_VIEW_DSC", "Here is the info about this attachment.");

define("_AM_IMFAQ_ATTACHMENT_DELETE", "Click to delete this attachment");
define("_AM_IMFAQ_ATTACHMENT_HIDE", "Click to hide this attachment on User-side");
define("_AM_IMFAQ_ATTACHMENT_SHOW", "Click to show this attachment on User-side");
define("_AM_IMFAQ_ATTACHMENT_SORT", "Drag to sort this attachment");



define("_AM_IMFAQ_CANCEL", "Cancel");
define("_AM_IMFAQ_IMPORT", "Import");
define("_AM_IMFAQ_IMPORTED_COMMENT", "Comment '%s' imported.");
define("_AM_IMFAQ_IMPORTED_COMMENT_ERROR", "Error while importing comment '%s'");
define("_AM_IMFAQ_IMPORT_COMMENTS", "Importing comments of the module");
define("_AM_IMFAQ_IMPORT_ALL_PARTNERS", "All articles");
define("_AM_IMFAQ_IMPORTED_ARTICLE_FILE", "Linked file %s was imported");
define("_AM_IMFAQ_IMPORT_ARTICLE_ERROR", "Error while importing article <em>%s</em>");
define("_AM_IMFAQ_IMPORT_ARTICLE_WRAP", "The pagewraped file %s has been copied in the module's content folder.");
define("_AM_IMFAQ_IMPORT_AUTOAPPROVE", "Auto-approve");
define("_AM_IMFAQ_IMPORT_BACK", "Back to the import page");
define("_AM_IMFAQ_IMPORT_CATEGORIES", "Categories to be imported");
define("_AM_IMFAQ_IMPORT_CATEGORIES_DSC", "Here are the categories that will be imported in SmartSection");
define("_AM_IMFAQ_IMPORT_CATEGORY_ERROR", "Error while importing category <em>%s</em>.");
define("_AM_IMFAQ_IMPORT_CATEGORY_PERMISSION_ERROR", "Error while importing category <em>%s</em> permissions.");
define("_AM_IMFAQ_IMPORT_CATEGORY_SUCCESS", "Category <em>%s</em> imported successfully.");
define("_AM_IMFAQ_IMPORT_ERROR", "An error occured while importing the article.");
define("_AM_IMFAQ_IMPORT_FILE_NOT_FOUND", "Import file not found at <b>%s</b>");
define("_AM_IMFAQ_IMPORT_FROM", "Importing from %s");
define("_AM_IMFAQ_IMPORT_GOTOMODULE", "Go SmartSection's index page");
define("_AM_IMFAQ_IMPORT_INFO", "You can import articles directly in SmartSection. Simply select from which module you would like to import the articles and click on the 'Import' button.<br><b>Run this operation only once, otherwise, the articles will be dupplicated</b>");
define("_AM_IMFAQ_IMPORT_MODULE_FOUND", "%s module was found. There are %s articles and %s categories that can be imported.");
define("_AM_IMFAQ_IMPORT_MODULE_FOUND_NO_ITEMS", "%s module was found but there are no article to import.");
define("_AM_IMFAQ_IMPORT_NOCATSELECTED", "No category was selected for import.");
define("_AM_IMFAQ_IMPORT_NO_MODULE", "As no other supported article module are installed on this site, no article can be imported.");
define("_AM_IMFAQ_IMPORT_NO_CATEGORY", "There are no categories to import.");
define("_AM_IMFAQ_IMPORT_PARENT_CATEGORY", "Parent category");
define("_AM_IMFAQ_IMPORT_PARENT_CATEGORY_DSC", "Import selected categories in this parent category.");
define("_AM_IMFAQ_IMPORT_PARTNER_ERROR", "An error occured while importing '%s'.");
define("_AM_IMFAQ_IMPORT_RESULT", "Here is the result of the import.");
define("_AM_IMFAQ_IMPORT_SETTINGS", "Import Settings");
define("_AM_IMFAQ_IMPORT_SUCCESS", "The articles were successfully imported in the module.");
define("_AM_IMFAQ_IMPORT_TITLE", "Import Articles");
define("_AM_IMFAQ_IMPORTED_ARTICLE", "Imported article : <em>%s</em>");
define("_AM_IMFAQ_IMPORTED_ARTICLES", "Articles imported : <em>%s</em>");
define("_AM_IMFAQ_IMPORTED_CATEGORY", "Imported category : <em>%s</em>");
define("_AM_IMFAQ_IMPORTED_CATEGORIES", "Categories imported : <em>%s</em>");
define("_AM_IMFAQ_IMPORT_SELECTION", "Import Selection");
define("_AM_IMFAQ_IMPORT_SELECT_FILE", "Articles");
define("_AM_IMFAQ_IMPORT_SELECT_FILE_DSC", "Choose the module from which to import the articles.");
?>