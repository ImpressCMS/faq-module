<?php
/**
* English language constants related to module information
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

// Module Info
// The name of this module

global $icmsModule;
define("_MI_IMFAQ_MD_NAME", "imFAQ");
define("_MI_IMFAQ_MD_DESC", "Advanced Questions and Answers Management System for your ImpressCMS Site");

define("_MI_IMFAQ_INDEX", "Index");
define("_MI_IMFAQ_FAQS", "Faqs");
define("_MI_IMFAQ_CATEGORYS", "Categories");
define("_MI_IMFAQ_ATTACHMENTS", "Attachments");
define("_MI_IMFAQ_IMPORT", "Import");

//Menu
define('_MI_IMFAQ_FAQ_ADD','Submit new FAQ');
define('_MI_IMFAQ_REQUEST_ADD','Request an answer');

//Blocks
define('_MI_IMFAQ_CATEGLIST','Category List');
define('_MI_IMFAQ_CATEGLISTDSC','Block to show a simple category list');
define('_MI_IMFAQ_RANDOM_DIDUNO','Random "Did you know?"');
define('_MI_IMFAQ_RANDOM_DIDUNODSC','Block to show a random Did you know question');
define('_MI_IMFAQ_RECENT_QUESTIONS','Recent Questions');
define('_MI_IMFAQ_RECENT_QUESTIONSDSC','Block to show the recent questions');

// Configs
define("_MI_IMFAQ_ALLOWSUBMIT", "User submissions");
define("_MI_IMFAQ_ALLOWSUBMITDSC", "Allow users to submit FAQs on your website?");
define("_MI_IMFAQ_ALLOWREQUEST", "User requests");
define("_MI_IMFAQ_ALLOWREQUESTDSC", "Allow users to request FAQs on your website?");
define('_MI_IMFAQ_DATEFORMAT', 'Date format');
define('_MI_IMFAQ_DATEFORMATDSC', 'Use the final part of language/english/global.php to select a display style. Example: "d-M-Y H:i" translates to "30-Mar-2004 22:35"');
define('_MI_IMFAQ_DISPLAY_TOPCAT_DSC', 'Display top categories description?');
define('_MI_IMFAQ_DISPLAY_TOPCAT_DSCDSC', "Select 'Yes' to display the description of top categories in the index and category page.");
define('_MI_IMFAQ_TOPCAT_DSC_COUNT', 'Max-length of the top category description');
define('_MI_IMFAQ_TOPCAT_DSC_COUNTDSC', "Define how much characters will be displayed in the top category description.");
define('_MI_IMFAQ_DISPLAY_SUBCAT_INDEX', 'Display sub-categories on index?');
define('_MI_IMFAQ_DISPLAY_SUBCAT_INDEXDSC', "Select 'Yes' to display subcategories on the index page.");
define('_MI_IMFAQ_DISPLAY_SUBCAT_DSC', 'Display sub-categories description?');
define('_MI_IMFAQ_DISPLAY_SUBCAT_DSCDSC', "Select 'Yes' to display the description of sub-categories in the index and category page.");
define('_MI_IMFAQ_SUBCAT_DSC_COUNT', 'Max-length of the top category description');
define('_MI_IMFAQ_SUBCAT_DSC_COUNTDSC', "Define how much characters will be displayed in the top category description.");
define('_MI_IMFAQ_DISPLAY_FAQ_ANSWER_SUBCAT', 'Display FAQ answers on sub-categories page?');
define('_MI_IMFAQ_DISPLAY_FAQ_ANSWER_SUBCATDSC', " ");
define('_MI_IMFAQ_FAQ_ANSWER_COUNT_SUBCAT', 'Max-length of the FAQ Answer on sub-categories page');
define('_MI_IMFAQ_FAQ_ANSWER_COUNT_SUBCATDSC', "Define how much characters will be displayed in the FAQ Answer on sub-categories page.");
define('_MI_IMFAQ_AUTOAPPROVE_SUB_FAQ', 'Auto approve submitted FAQs?');
define('_MI_IMFAQ_AUTOAPPROVE_SUB_FAQDSC', 'Auto approves submitted FAQs without admin intervention.');
define('_MI_IMFAQ_SHOW_FAQ_INFO', 'Show FAQs info?');
define('_MI_IMFAQ_SHOW_FAQ_INFO_DSC', 'Select "YES" to show the FAQ author, published date and counter.');
define("_MI_IMFAQ_LIMIT", "Faqs limit");
define("_MI_IMFAQ_LIMITDSC", "Number of faqs to display on user side.");
define("_MI_IMFAQ_CATSLIMIT", "Categories limit");
define("_MI_IMFAQ_CATSLIMITDSC", "Number of cateogries to display on user side.");
define("_MI_IMFAQ_SEOMODNAME", "SEO module name");
define("_MI_IMFAQ_SEOMODNAMEDSC", "This will be used when generating SEO URL. The name you choose here also needs to be used to customize your htaccess file.");
define("_MI_IMFAQ_SEOMODE", "SEO mode");
define("_MI_IMFAQ_SEOMODEDSC", "Choose from SEO technique.");
define('_MI_IMFAQ_REQUESTINTROMSG', 'Request introduction message');
define('_MI_IMFAQ_REQUESTINTROMSGDSC', 'Introduction message to be displayed in the Request a FAQ page of the module.');
define('_MI_IMFAQ_REQUESTINTROMSG_DEF', "You did not find the answer to the question you were looking for? No problem! Simply fill the following form in order to request the answer for a new question. The site administrator will review your request and publish this new question in the Open Questions section for someone to answer it!"); 
define("_MI_IMFAQ_HEADER", "Index welcome message");
define("_MI_IMFAQ_HEADERDSC", "Welcome message to be displayed in the index page of the module.");
define('_MI_IMFAQ_HEADER_DEF', "In this area of our site, you will find the answers to the frequently asked questions. Please feel free to post a comment on any FAQ.");
define("_MI_IMFAQ_FOOTER", "Module Footer Text");
define("_MI_IMFAQ_FOOTERDSC", "The content you put here will be shown in all pages of the module on user side. Leave empty to not show.");
define("_MI_IMFAQ_FOOTER_DEF", "");
define('_MI_IMFAQ_USEREALNAME', 'Use the Real Name of users?');
define('_MI_IMFAQ_USEREALNAMEDSC', 'When displaying a username, use the real name of that user if he has a set his real name.');
define('_MI_IMFAQ_DEFAULT_CATVIEWPERM', 'Default Category View Permission');
define('_MI_IMFAQ_DEFAULT_CATVIEWPERMDSC', 'Define the groups that will have by default view permission of each category. When creating or editing a category you can always change the permissions.');
define('_MI_IMFAQ_DEFAULT_CATWRITEPERM', 'Default Category Write Permission');
define('_MI_IMFAQ_DEFAULT_CATWRITEPERMDSC', 'Define the groups that will have by default write permission of each category. When creating or editing a category you can always change the permissions.');
define('_MI_IMFAQ_ENABLEATTACHMENTS', 'Enable the Attachment feature?');
define('_MI_IMFAQ_ENABLEATTACHMENTSDSC', 'The attachment feature allow you "attach" items for other modules in the FAQ. The attachment feature uses plugins to connect other modules and allow select and show their contents. Select "'._YES.'" to show the option in the FAQ form on admin side.');

define('_MI_IMFAQ_CATEGS_ORDER', 'Sort Categories/Subcategories by');
define('_MI_IMFAQ_CATEGS_ORDERDSC', 'Select how to sort the categories/subcategories list on index page.');
define('_MI_IMFAQ_FAQS_ORDER', 'Sort FAQs by');
define('_MI_IMFAQ_FAQS_ORDERDSC', 'Select how tp sort the FAQs list on categories page.');

define('_MI_IMFAQ_SORT_WEIGHT', 'Weight');
define('_MI_IMFAQ_SORT_PUBDATEASC', 'Published Date ASC');
define('_MI_IMFAQ_SORT_PUBDATEDESC', 'Published Date DESC');

// Notifications
define('_MI_IMFAQ_GLOBAL_FAQ_NOTIFY', "Global Faqs");
define('_MI_IMFAQ_GLOBAL_FAQ_NOTIFY_DSC', "Notification options that apply to all FAQs.");

define('_MI_IMFAQ_FAQ_NOTIFY', "FAQ");
define('_MI_IMFAQ_FAQ_NOTIFY_DSC', "Notification options that apply to the current FAQ.");

define('_MI_IMFAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY', "FAQ submitted");
define('_MI_IMFAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY_CAP', "Notify me when any FAQ is submitted and is awaiting approval.");
define('_MI_IMFAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY_DSC', "Receive notification when any FAQ is submitted and is waiting approval.");
define('_MI_IMFAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} auto-notify : New FAQ submitted");

define('_MI_IMFAQ_FAQ_APPROVED_NOTIFY', "FAQ approved");
define('_MI_IMFAQ_FAQ_APPROVED_NOTIFY_CAP', "Notify me when this FAQ is approved.");
define('_MI_IMFAQ_FAQ_APPROVED_NOTIFY_DSC', "Receive notification when this FAQ is approved.");
define('_MI_IMFAQ_FAQ_APPROVED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} auto-notify : FAQ approved");

define("_MI_IMFAQ_GLOBAL_FAQ_NEW_NOTIFY", "New FAQ");
define("_MI_IMFAQ_GLOBAL_FAQ_NEW_NOTIFY_CAP", "Notify me when any new FAQ is published.");
define("_MI_IMFAQ_GLOBAL_FAQ_NEW_NOTIFY_DSC", "");
define("_MI_IMFAQ_GLOBAL_FAQ_NEW_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New FAQ published");
?>