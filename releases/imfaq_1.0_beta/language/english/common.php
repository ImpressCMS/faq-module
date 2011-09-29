<?php
/**
* English language constants commonly used in the module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

define("_CO_IMFAQ_READMORE", "Read more...");

// faq
define("_CO_IMFAQ_FAQ_FAQ_ID", "Id");
define("_CO_IMFAQ_FAQ_FAQ_ID_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_QUESTION", "Question");
define("_CO_IMFAQ_FAQ_FAQ_QUESTION_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_MENUTITLE", "Title in menu");
define("_CO_IMFAQ_FAQ_FAQ_MENUTITLE_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_ANSWER", "Answer");
define("_CO_IMFAQ_FAQ_FAQ_ANSWER_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_UID", "Author");
define("_CO_IMFAQ_FAQ_FAQ_UID_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_CID", "Category");
define("_CO_IMFAQ_FAQ_FAQ_CID_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_DIDUNO", "Did you know?");
define("_CO_IMFAQ_FAQ_FAQ_DIDUNO_DSC", "This will be used in the Did You Know block.");
define("_CO_IMFAQ_FAQ_FAQ_STATUS", "Status");
define("_CO_IMFAQ_FAQ_FAQ_STATUS_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_PUBLISHED_DATE", "Published Date");
define("_CO_IMFAQ_FAQ_FAQ_PUBLISHED_DATE_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_CANCOMMENT", "Can Comment?");
define("_CO_IMFAQ_FAQ_FAQ_CANCOMMENT_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_WEIGHT", "Weight");
define("_CO_IMFAQ_FAQ_FAQ_WEIGHT_DSC", " ");
define("_CO_IMFAQ_FAQ_FAQ_ATTACHMENTS", "Attachments");
define("_CO_IMFAQ_FAQ_FAQ_ATTACHMENTS_DSC", "Click the button \"add attachments\" to select and attach items to this faq");
define("_CO_IMFAQ_FAQ_LEARNMORE", "To learn more, download the following NAIMA Publications:");
define("_CO_IMFAQ_FAQ_FAQ_NOTIFYPUB", "Notify on approval?");

define("_CO_IMFAQ_FAQ_STATUS_PUBLISHED", "Published");
define("_CO_IMFAQ_FAQ_STATUS_PENDING", "Pending");
define("_CO_IMFAQ_FAQ_STATUS_REJECTED", "Rejected");
define("_CO_IMFAQ_FAQ_STATUS_OFFLINE", "Offline");

define("_CO_IMFAQ_FAQ_READ", "View Permission");
define("_CO_IMFAQ_FAQ_READ_DSC", "Select wich groups will have view permission for this faq. This means that a user belonging to one of these groups will be able to view the faq when it is activated in the site.");

define("_CO_IMFAQ_FAQ_INFO", "Published by %s on %s. (%u reads)");
define("_CO_IMFAQ_FAQ_FROM_USER", "All contents of %s");
define("_CO_IMFAQ_FAQ_COMMENTS_INFO", "%d comments");
define("_CO_IMFAQ_FAQ_NO_COMMENT", "No comment");

define("_CO_IMFAQ_SUBMITTED_FAQS", "<h1>User's submitted FAQs</h1>");
define("_CO_IMFAQ_REQUESTED_FAQS", "<h1>User's requested FAQs</h1>");

// category
define("_CO_IMFAQ_CATEGORY_CAT_ID", "Id");
define("_CO_IMFAQ_CATEGORY_CAT_ID_DSC", " ");
define("_CO_IMFAQ_CATEGORY_CAT_TITLE", "Title");
define("_CO_IMFAQ_CATEGORY_CAT_TITLE_DSC", " ");
define("_CO_IMFAQ_CATEGORY_CAT_MENUTITLE", "Title in menu");
define("_CO_IMFAQ_CATEGORY_CAT_MENUTITLE_DSC", " ");
define("_CO_IMFAQ_CATEGORY_CAT_PID", "Parent category");
define("_CO_IMFAQ_CATEGORY_CAT_PID_DSC", "If you want this new category to be a sub-category, select a parent here. If it is to be a top level category, leave this blank.");
define("_CO_IMFAQ_CATEGORY_CAT_SUMMARY", "Summary");
define("_CO_IMFAQ_CATEGORY_CAT_SUMMARY_DSC", " ");
define("_CO_IMFAQ_CATEGORY_CAT_DESCRIPTION", "Description");
define("_CO_IMFAQ_CATEGORY_CAT_DESCRIPTION_DSC", " ");
define("_CO_IMFAQ_CATEGORY_CAT_WEIGHT", "Weight");
define("_CO_IMFAQ_CATEGORY_CAT_WEIGHT_DSC", " ");
define("_CO_IMFAQ_CATEGORY_CAT_PUBLISHED_DATE", "Published Date");
define("_CO_IMFAQ_CATEGORY_CAT_PUBLISHED_DATE_DSC", " ");
define("_CO_IMFAQ_CATEGORY_CAT_STATUS", "Status");
define("_CO_IMFAQ_CATEGORY_CAT_STATUS_DSC", " ");
define("_CO_IMFAQ_CATEGORY_CAT_SUBS", "SubCategories");
define("_CO_IMFAQ_CATEGORY_CAT_SUBS_DSC", " ");

define("_CO_IMFAQ_CATEGORY_STATUS_ACTIVE", "Active");
define("_CO_IMFAQ_CATEGORY_STATUS_INACTIVE", "Inactive");

define("_CO_IMFAQ_CATEGORY_READ", "View Permission");
define("_CO_IMFAQ_CATEGORY_READ_DSC", "Select wich groups will have view permission for this category. This means that a user belonging to one of these groups will be able to view the category when it is activated in the site.");
define("_CO_IMFAQ_CATEGORY_WRITE", "Write Permission");
define("_CO_IMFAQ_CATEGORY_WRITE_DSC", "Select the groups which are allowed to create new faqs on this category. This means that a user belonging to one of these groups will be able to add new faqs in this category directly on the site.");

// Attachments
define("_CO_IMFAQ_ATTACHMENT_ATTACH_ID", "Id");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_ID_DSC", " ");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_FID", "Faq");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_FID_DSC", " ");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_MODULE", "Module");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_MODULE_DSC", " ");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_ITEMID", "Item");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_ITEMID_DSC", " ");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_WEIGHT", "Weight");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_WEIGHT_DSC", " ");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_STATUS", "Status");
define("_CO_IMFAQ_ATTACHMENT_ATTACH_STATUS_DSC", " ");

define("_CO_IMFAQ_ATTACHMENT_STATUS_ACTIVE", "Show");
define("_CO_IMFAQ_ATTACHMENT_STATUS_INACTIVE", "Hide");

define("_CO_IMFAQ_ATTACHMENT_READ", "View Permission");
define("_CO_IMFAQ_ATTACHMENT_READ_DSC", "Select wich groups will have view permission for this attachment. This means that a user belonging to one of these groups will be able to view the attachment when it is activated in the site.");

define("_CO_IMFAQ_ATTACHMENT_SEL_MODULE", "Select a module plugin: ");
define("_CO_IMFAQ_ATTACHMENT_AVALIABLE_ITEMS", "Avaliable Items from %s");
define("_CO_IMFAQ_ATTACHMENT_AVALIABLE_ITEMS_DSC", "Bellow is a list of all avaliable items for the selected module. Select the desired items and click on the add button to attach it in the FAQ.");
?>