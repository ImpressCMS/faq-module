<?php
/**
* imFAQ version infomation
*
* This file holds the configuration information of this module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

/**  General Information  */
$modversion = array(
  'name'=> _MI_IMFAQ_MD_NAME,
  'version'=> 1.0,
  'description'=> _MI_IMFAQ_MD_DESC,
  'author'=> "TheRplima (Rodrigo Pereira Lima)",
  'credits'=> "INBOX International",
  'help'=> "",
  'license'=> "GNU General Public License (GPL)",
  'official'=> 0,
  'dirname'=> basename( dirname( __FILE__ ) ),

/**  Images information  */
  'iconsmall'=> "images/icon_small.png",
  'iconbig'=> "images/icon_big.png",
  'image'=> "images/icon_big.png", /* for backward compatibility */

/**  Development information */
  'status_version'=> "1.0",
  'status'=> "Beta",
  'date'=> "Unreleased",
  'author_word'=> "",

/** Contributors */
  'developer_website_url' => "http://inboxinternational.com",
  'developer_website_name' => "INBOX International",
  'developer_email' => "rodrigo@inboxinternational.com");

$modversion['people']['developers'][] = "[url=http://br.linkedin.com/in/therplima]TheRplima (Rodrigo Pereira Lima)[/url]";
$modversion['people']['testers'][] = "Andy Cleff";
//$modversion['people']['translators'][] = "";
//$modversion['people']['documenters'][] = "";
//$modversion['people']['other'][] = "";

/** Manual */
$modversion['manual']['wiki'][] = "<a href='http://wiki.impresscms.org/index.php?title=imFAQ' target='_blank'>English</a>";

$modversion['warning'] = _CO_ICMS_WARNING_BETA;

/** Administrative information */
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

/** Database information */
$modversion['object_items'][1] = 'faq';
$modversion['object_items'][] = 'category';
$modversion['object_items'][] = 'attachment';

$modversion["tables"] = icms_getTablesArray($modversion['dirname'], $modversion['object_items']);

/** Install and update informations */
$modversion['onInstall'] = "include/onupdate.inc.php";
$modversion['onUpdate'] = "include/onupdate.inc.php";

/** Search information */
$modversion['hasSearch'] = 1;
$modversion['search'] = array (
  'file' => "include/search.inc.php",
  'func' => "imfaq_search");

/** Menu information */
$modversion['hasMain'] = 1;
global $xoopsModule, $xoopsUser, $xoopsModuleConfig;
if (is_object($xoopsModule) && $xoopsModule->dirname() == $modversion['dirname']) {
	$imfaq_faq_handler = icms_getModuleHandler('faq', $modversion['dirname']);

	if (isset($xoopsModuleConfig['faqs_allowsubmit']) && $xoopsModuleConfig['faqs_allowsubmit'] == 1 && $imfaq_faq_handler->userCanSubmit()) {
		$modversion['sub'][1]['name'] = _MI_IMFAQ_FAQ_ADD;
		$modversion['sub'][1]['url'] = 'faq.php?op=mod';
	}

	if (isset($xoopsModuleConfig['faqs_allowrequest']) && $xoopsModuleConfig['faqs_allowrequest'] == 1 && $imfaq_faq_handler->userCanSubmit()) {
		$modversion['sub'][2]['name'] = _MI_IMFAQ_REQUEST_ADD;
		$modversion['sub'][2]['url'] = 'faq.php?op=request';
	}
}

/** Blocks information */

$modversion['blocks'][1] = array(
  'file' => 'imfaq_categlist.php',
  'name' => _MI_IMFAQ_CATEGLIST,
  'description' => _MI_IMFAQ_CATEGLISTDSC,
  'show_func' => 'imfaq_categlist_show',
  'edit_func' => 'imfaq_categlist_edit',
  'options' => 'cat_title|ASC|1',
  'template' => 'imfaq_categlist.html');

$modversion['blocks'][] = array(
  'file' => 'imfaq_random_diduno.php',
  'name' => _MI_IMFAQ_RANDOM_DIDUNO,
  'description' => _MI_IMFAQ_RANDOM_DIDUNODSC,
  'show_func' => 'imfaq_random_diduno_show',
  'edit_func' => 'imfaq_random_diduno_edit',
  'options' => 'RAND|ASC|1|0',
  'template' => 'imfaq_random_diduno.html');

$modversion['blocks'][] = array(
  'file' => 'imfaq_recent_questions.php',
  'name' => _MI_IMFAQ_RECENT_QUESTIONS,
  'description' => _MI_IMFAQ_RECENT_QUESTIONSDSC,
  'show_func' => 'imfaq_recent_questions_show',
  'edit_func' => 'imfaq_recent_questions_edit',
  'options' => '1|0',
  'template' => 'imfaq_recent_questions.html');

/** Templates information */
$modversion['templates'][1] = array(
  'file' => 'imfaq_header.html',
  'description' => 'Module Header');

$modversion['templates'][] = array(
  'file' => 'imfaq_footer.html',
  'description' => 'Module Footer');

$modversion['templates'][]= array(
  'file' => 'imfaq_admin_faq.html',
  'description' => 'faq Admin Index');

$modversion['templates'][]= array(
  'file' => 'imfaq_faq.html',
  'description' => 'faq Index');

$modversion['templates'][]= array(
  'file' => 'imfaq_admin_category.html',
  'description' => 'category Admin Index');

$modversion['templates'][]= array(
  'file' => 'imfaq_category.html',
  'description' => 'category Index');

$modversion['templates'][]= array(
  'file' => 'imfaq_index.html',
  'description' => 'module Index');

$modversion['templates'][]= array(
  'file' => 'imfaq_print.html',
  'description' => 'print faq page');

$modversion['templates'][]= array(
  'file' => 'imfaq_admin_attachment.html',
  'description' => 'attachment admin page');

$modversion['config'][] = array(
  'name' => 'faqs_allowsubmit',
  'title' => '_MI_IMFAQ_ALLOWSUBMIT',
  'description' => '_MI_IMFAQ_ALLOWSUBMITDSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 1);

$modversion['config'][] = array(
  'name' => 'faqs_allowrequest',
  'title' => '_MI_IMFAQ_ALLOWREQUEST',
  'description' => '_MI_IMFAQ_ALLOWREQUESTDSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 1);

$modversion['config'][] = array(
  'name' => 'faqs_dateformat',
  'title' => '_MI_IMFAQ_DATEFORMAT',
  'description' => '_MI_IMFAQ_DATEFORMATDSC',
  'formtype' => 'textbox',
  'valuetype' => 'text',
  'default' => 'd-M-Y H:i');

$modversion['config'][] = array(
  'name' => 'displaytopcatdsc',
  'title' => '_MI_IMFAQ_DISPLAY_TOPCAT_DSC',
  'description' => '_MI_IMFAQ_DISPLAY_TOPCAT_DSCDSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 1);

$modversion['config'][] = array(
  'name' => 'topcatdsc_count',
  'title' => '_MI_IMFAQ_TOPCAT_DSC_COUNT',
  'description' => '_MI_IMFAQ_TOPCAT_DSC_COUNTDSC',
  'formtype' => 'textbox',
  'valuetype' => 'int',
  'default' => 300);

$modversion['config'][] = array(
  'name' => 'displaysubcatonindex',
  'title' => '_MI_IMFAQ_DISPLAY_SUBCAT_INDEX',
  'description' => '_MI_IMFAQ_DISPLAY_SUBCAT_INDEXDSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 1);

$modversion['config'][] = array(
  'name' => 'displaysubcatdsc',
  'title' => '_MI_IMFAQ_DISPLAY_SUBCAT_DSC',
  'description' => '_MI_IMFAQ_DISPLAY_SUBCAT_DSCDSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 1);

$modversion['config'][] = array(
  'name' => 'subcatdsc_count',
  'title' => '_MI_IMFAQ_SUBCAT_DSC_COUNT',
  'description' => '_MI_IMFAQ_SUBCAT_DSC_COUNTDSC',
  'formtype' => 'textbox',
  'valuetype' => 'int',
  'default' => 300);

$modversion['config'][] = array(
  'name' => 'displayfaqanswersubcat',
  'title' => '_MI_IMFAQ_DISPLAY_FAQ_ANSWER_SUBCAT',
  'description' => '_MI_IMFAQ_DISPLAY_FAQ_ANSWER_SUBCATDSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 1);

$modversion['config'][] = array(
  'name' => 'faq_answer_count_subcat',
  'title' => '_MI_IMFAQ_FAQ_ANSWER_COUNT_SUBCAT',
  'description' => '_MI_IMFAQ_FAQ_ANSWER_COUNT_SUBCATDSC',
  'formtype' => 'textbox',
  'valuetype' => 'int',
  'default' => 300);

$modversion['config'][] = array(
  'name' => 'categs_order',
  'title' => '_MI_IMFAQ_CATEGS_ORDER',
  'description' => '_MI_IMFAQ_CATEGS_ORDERDSC',
  'formtype' => 'select',
  'valuetype' => 'text',
  'options' => array(_MI_IMFAQ_SORT_WEIGHT  => 'weight', _MI_IMFAQ_SORT_PUBDATEASC => 'pub_date_asc', _MI_IMFAQ_SORT_PUBDATEDESC => 'pub_date_desc'),
  'default' =>  'weight');

$modversion['config'][] = array(
  'name' => 'faqs_order',
  'title' => '_MI_IMFAQ_FAQS_ORDER',
  'description' => '_MI_IMFAQ_FAQS_ORDERDSC',
  'formtype' => 'select',
  'valuetype' => 'text',
  'options' => array(_MI_IMFAQ_SORT_WEIGHT  => 'weight', _MI_IMFAQ_SORT_PUBDATEASC => 'pub_date_asc', _MI_IMFAQ_SORT_PUBDATEDESC => 'pub_date_desc'),
  'default' =>  'weight');

$modversion['config'][] = array(
  'name' => 'faqs_limit',
  'title' => '_MI_IMFAQ_LIMIT',
  'description' => '_MI_IMFAQ_LIMITDSC',
  'formtype' => 'textbox',
  'valuetype' => 'text',
  'default' => 5);

$modversion['config'][] = array(
  'name' => 'cats_limit',
  'title' => '_MI_IMFAQ_CATSLIMIT',
  'description' => '_MI_IMFAQ_CATSLIMITDSC',
  'formtype' => 'textbox',
  'valuetype' => 'text',
  'default' => 5);

$modversion['config'][] = array(
  'name' => 'autoapprove_submitted_faq',
  'title' => '_MI_IMFAQ_AUTOAPPROVE_SUB_FAQ',
  'description' => '_MI_IMFAQ_AUTOAPPROVE_SUB_FAQDSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 0);

$modversion['config'][] = array(
  'name' => 'show_faq_info',
  'title' => '_MI_IMFAQ_SHOW_FAQ_INFO',
  'description' => '_MI_IMFAQ_SHOW_FAQ_INFO_DSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 1);

$modversion['config'][] = array(
  'name' => 'seo_module_name',
  'title' => '_MI_IMFAQ_SEOMODNAME',
  'description' => '_MI_IMFAQ_SEOMODNAMEDSC',
  'formtype' => 'textbox',
  'valuetype' => 'text',
  'default' => $modversion['dirname']);

$modversion['config'][] = array(
  'name' => 'seo_mode',
  'title' => '_MI_IMFAQ_SEOMODE',
  'description' => '_MI_IMFAQ_SEOMODEDSC',
  'formtype' => 'select',
  'valuetype' => 'text',
  'options' => array('Disabled'  => 'disabled', 'Path Info' => 'pathinfo', 'URL Rewrite' => 'rewrite'),
  'default' =>  'disabled');

$modversion['config'][] = array(
  'name' => 'module_header',
  'title' => '_MI_IMFAQ_HEADER',
  'description' => '_MI_IMFAQ_HEADERDSC',
  'formtype' => 'textarea',
  'valuetype' => 'text',
  'default' => _MI_IMFAQ_HEADER_DEF);

$modversion['config'][] = array(
  'name' => 'module_footer',
  'title' => '_MI_IMFAQ_FOOTER',
  'description' => '_MI_IMFAQ_FOOTERDSC',
  'formtype' => 'textarea',
  'valuetype' => 'text',
  'default' => _MI_IMFAQ_FOOTER_DEF);

$modversion['config'][] = array(
  'name' => 'module_requestintromsg',
  'title' => '_MI_IMFAQ_REQUESTINTROMSG',
  'description' => '_MI_IMFAQ_REQUESTINTROMSGDSC',
  'formtype' => 'textarea',
  'valuetype' => 'text',
  'default' => _MI_IMFAQ_REQUESTINTROMSG_DEF);

$modversion['config'][] = array(
  'name' => 'userealname',
  'title' => '_MI_IMFAQ_USEREALNAME',
  'description' => '_MI_IMFAQ_USEREALNAMEDSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 0);

$member_handler = &xoops_gethandler('member');
$group_list = &$member_handler->getGroupList();
foreach ($group_list as $key=>$group) {
	$groups[$group] = $key;
}

$modversion['config'][] = array(
  'name' => 'default_cat_viewperm',
  'title' => '_MI_IMFAQ_DEFAULT_CATVIEWPERM',
  'description' => '_MI_IMFAQ_DEFAULT_CATVIEWPERMDSC',
  'formtype' => 'select_multi',
  'valuetype' => 'array',
  'options' => $groups,
  'default' => array(1,2,3));

$modversion['config'][] = array(
  'name' => 'default_cat_writeperm',
  'title' => '_MI_IMFAQ_DEFAULT_CATWRITEPERM',
  'description' => '_MI_IMFAQ_DEFAULT_CATWRITEPERMDSC',
  'formtype' => 'select_multi',
  'valuetype' => 'array',
  'options' => $groups,
  'default' => array(1));

$modversion['config'][] = array(
  'name' => 'enable_attachments',
  'title' => '_MI_IMFAQ_ENABLEATTACHMENTS',
  'description' => '_MI_IMFAQ_ENABLEATTACHMENTSDSC',
  'formtype' => 'yesno',
  'valuetype' => 'int',
  'default' => 1);

/** Comments information */
$modversion['hasComments'] = 1;

$modversion['comments'] = array(
  'itemName' => 'faq_id',
  'pageName' => 'faq.php',
  /* Comment callback functions */
  'callbackFile' => 'include/comment.inc.php',
  'callback' => array(
    'approve' => 'imfaq_com_approve',
    'update' => 'imfaq_com_update')
    );

/** Notification information */
$modversion['hasNotification'] = 1;

$modversion['notification'] = array (
  'lookup_file' => 'include/notification.inc.php',
  'lookup_func' => 'imfaq_notify_iteminfo');

$modversion['notification']['category'][1] = array (
  'name' => 'global_faq',
  'title' => _MI_IMFAQ_GLOBAL_FAQ_NOTIFY,
  'description' => _MI_IMFAQ_GLOBAL_FAQ_NOTIFY_DSC,
  'subscribe_from' => array('index.php','category.php'));

$modversion['notification']['category'][] = array (
  'name' => 'faq',
  'title' => _MI_IMFAQ_FAQ_NOTIFY,
  'description' => _MI_IMFAQ_FAQ_NOTIFY_DSC,
  'subscribe_from' => array('faq.php'),
  'item_name','faq_id');

$modversion['notification']['event'][1] = array(
  'name' => 'submitted',
  'category'=> 'global_faq',
  'admin_only'=> 1,
  'title'=> _MI_IMFAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY,
  'caption'=> _MI_IMFAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY_CAP,
  'description'=> _MI_IMFAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY_DSC,
  'mail_template'=> 'global_faq_submitted',
  'mail_subject'=> _MI_IMFAQ_GLOBAL_FAQ_SUBMITTED_NOTIFY_SBJ);

$modversion['notification']['event'][] = array(
  'name' => 'new_faq',
  'category'=> 'global_faq',
  'title'=> _MI_IMFAQ_GLOBAL_FAQ_NEW_NOTIFY,
  'caption'=> _MI_IMFAQ_GLOBAL_FAQ_NEW_NOTIFY_CAP,
  'description'=> _MI_IMFAQ_GLOBAL_FAQ_NEW_NOTIFY_DSC,
  'mail_template'=> 'global_faq_new',
  'mail_subject'=> _MI_IMFAQ_GLOBAL_FAQ_NEW_NOTIFY_SBJ);

$modversion['notification']['event'][] = array(
  'name' => 'approved',
  'category'=> 'faq',
  'invisible'=> 1,
  'title'=> _MI_IMFAQ_FAQ_APPROVED_NOTIFY,
  'caption'=> _MI_IMFAQ_FAQ_APPROVED_NOTIFY_CAP,
  'description'=> _MI_IMFAQ_FAQ_APPROVED_NOTIFY_DSC,
  'mail_template'=> 'faq_approved',
  'mail_subject'=> _MI_IMFAQ_FAQ_APPROVED_NOTIFY_SBJ);
?>