<?php
/**
 * Print Faq page
 *
 * @copyright	INBOX International
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
 * @package		imfaq
 * @version		$Id$
 */

include_once 'header.php';
require_once XOOPS_ROOT_PATH.'/class/template.php';

$imfaq_faq_handler = icms_getModuleHandler ( 'faq' );

$clean_faq_id = isset ( $_GET ['faq_id'] ) ? intval ( $_GET ['faq_id'] ) : 0;
$clean_short_url = isset ( $_GET ['short_url'] ) ? $_GET ['short_url'] : '';

if ($clean_short_url != '' && $clean_faq_id == 0) {
	$criteria = new CriteriaCompo ( );
	$criteria->add ( new Criteria ( 'short_url', urlencode ( $clean_short_url ) ) );
	$faqObj = $imfaq_faq_handler->getObjects ( $criteria );
	$faqObj = $faqObj [0];
	$clean_faq_id = $faqObj->getVar ( 'faq_id' );
} else {
	$faqObj = $imfaq_faq_handler->get ( $clean_faq_id );
}

if (!$faqObj || !is_object( $faqObj ) || $faqObj->isNew ()) {
	redirect_header("javascript:history.go(-1)", 1, _MD_IMFAQ_NOFAQSELECTED);
}

// Check user permissions to access that category of the selected ITEM
if (!$faqObj->accessGranted ()){
	redirect_header("javascript:history.go(-1)", 1, _NOPERM);
}

$imfaq_cat_handler = icms_getModuleHandler('category');
$category = $imfaq_cat_handler->get($faqObj->getVar ( 'faq_cid','e' ));

$icmsTpl = new XoopsTpl();
global $xoopsConfig;
$myts = MyTextSanitizer::getInstance();
$faq=  $faqObj->toArray();
$printtitle = $xoopsConfig['sitename']." - ". $category->getVar('cat_title','e') . ' > ' . strip_tags($faqObj->getVar ( 'faq_question','n' ));
$who_where = $faq['faq_info'];

$icmsTpl->assign('printtitle', $printtitle);
$icmsTpl->assign('printlogourl', ICMS_URL.'/images/logo.gif');
$icmsTpl->assign('lang_author_date', $who_where);
$icmsTpl->assign('faq', $faq);

$icmsTpl->assign('current_language', $xoopsConfig['language']);
$icmsTpl->assign('theme_set', $xoopsConfig['theme_set']);

$icmsTpl->assign('display_whowhen_link', $xoopsModuleConfig['show_faq_info']);
$icmsTpl->assign('module_footer', $xoopsModuleConfig['module_footer']);

$icmsTpl->display('db:imfaq_print.html');

?>