<?php
/**
 * Faq page
 *
 * @copyright	INBOX International
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
 * @package		faq
 * @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
 */

/**
 * Edit a Faq
 *
 * @param int $faq_id Faqid to be edited
 */
function editfaq($faqObj, $resquest = false) {
	global $faq_faq_handler, $icmsTpl, $xoopsUser, $faqConfig;
	
	if (! $faqObj->isNew ()) {
		if (! $faqObj->userCanEditAndDelete ()) {
			redirect_header ( $faqObj->getItemLink ( true ), 3, _NOPERM );
		}
		$faqObj->hideFieldFromForm(array('faq_attachments'));
		$sform = $faqObj->getSecureForm ( _MD_FAQ_FAQ_EDIT, 'addfaq' );
		$sform->assign ( $icmsTpl, 'faq_faqform' );
		$icmsTpl->assign ( 'faq_category_path', $faqObj->getVar ( 'faq_question', 'nh' ) . ' > ' . _EDIT );
	} else {
		if (! $faq_faq_handler->userCanSubmit ()) {
			redirect_header ( FAQ_URL, 3, _NOPERM );
		}
		$faqObj->setVar ( 'faq_uid', $xoopsUser->uid () );
		$faqObj->setVar ( 'faq_published_date', time () );
		$faqObj->setVar ( 'faq_status', ($faqConfig ['autoapprove_submitted_faq'] ? FAQ_FAQ_STATUS_ACTIVE : FAQ_FAQ_STATUS_PENDING) );
		if ($resquest) {
			$faqObj->hideFieldFromForm ( array ('faq_attachments','faq_published_date', 'faq_uid', 'meta_keywords', 'meta_description', 'short_url', 'faq_weight', 'faq_status', 'faq_cancomment', 'faq_diduno', 'faq_answer' ) );
			$title = _MD_FAQ_FAQ_REQUEST;
			$icmsTpl->assign ( 'module_requestintromsg', $faqConfig ['module_requestintromsg'] );
		} else {
			$faqObj->hideFieldFromForm ( array ('faq_attachments','faq_published_date', 'faq_uid', 'meta_keywords', 'meta_description', 'short_url', 'faq_weight', 'faq_status', 'faq_cancomment', 'faq_diduno' ) );
			$title = _MD_FAQ_FAQ_SUBMIT;
		}
		if (!$faqConfig ['autoapprove_submitted_faq']){
			$faqObj->showFieldOnForm('faq_notifypub');
		}
		$sform = $faqObj->getSecureForm ( $title, 'addfaq' );
		$sform->assign ( $icmsTpl, 'faq_faqform' );
		$icmsTpl->assign ( 'faq_category_path', _SUBMIT );
	}
}

include_once 'header.php';

$faq_category_handler = icms_getModuleHandler ( 'category' );
$faq_faq_handler = icms_getModuleHandler ( 'faq' );

/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';
if (isset ( $_GET ['op'] ))
	$clean_op = htmlentities ( $_GET ['op'] );
if (isset ( $_POST ['op'] ))
	$clean_op = htmlentities ( $_POST ['op'] );
$clean_faq_id = isset ( $_GET ['faq_id'] ) ? intval ( $_GET ['faq_id'] ) : 0;
$clean_short_url = isset ( $_GET ['short_url'] ) ? $_GET ['short_url'] : '';

/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('mod', 'addfaq', 'request', 'view', 'del', '' );

$xoopsOption ['template_main'] = 'faq_faq.html';
include_once ICMS_ROOT_PATH . '/header.php';

if ($clean_short_url != '' && $clean_faq_id == 0) {
	$criteria = new CriteriaCompo ();
	$criteria->add ( new Criteria ( 'short_url', urlencode ( $clean_short_url ) ) );
	$faqObj = $faq_faq_handler->getObjects ( $criteria );
	$faqObj = $faqObj [0];
	$clean_faq_id = $faqObj->getVar ( 'faq_id' );

	/**
	 * Setting the value for faq_id in the $_GET array to fix the comments problems
	 */
	$_GET ['faq_id'] = $clean_faq_id;
} else {
	$faqObj = $faq_faq_handler->get ( $clean_faq_id );
}

/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
 */
if (in_array ( $clean_op, $valid_op, true )) {
	switch ($clean_op) {
		case "mod" :
			editfaq ( $faqObj );
			break;
		
		case "request" :
			editfaq ( $faqObj, true );
			break;
		
		case "addfaq" :
			if (! $xoopsSecurity->check ()) {
				redirect_header ( faq_getPreviousPage ( 'index.php' ), 3, _MD_FAQ_SECURITY_CHECK_FAILED . implode ( '<br />', $xoopsSecurity->getErrors () ) );
			}
			include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
			$controller = new IcmsPersistableController ( $faq_faq_handler );
			$controller->storeFromDefaultForm ( _MD_FAQ_FAQ_CREATED, _MD_FAQ_FAQ_MODIFIED );
			break;
		
		case "del" :
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistablecontroller.php";
			$controller = new IcmsPersistableController ( $faq_faq_handler );
			$controller->handleObjectDeletionFromUserSide ();
		
		break;
			
		default :
			if ($faqObj && ! $faqObj->isNew () && $faqObj->accessGranted ()) {
				/**
				 * display this faq
				 */
				$faq = $faqObj->toArray ();
				if (!$faqConfig ['enable_attachments']){
					$faq['faq_attachments'] = false;
				}
				$faq ['prev'] = $faqObj->getPreviousFaq ();
				$faq ['next'] = $faqObj->getNextFaq ();
				$icmsTpl->assign ( 'faq_faq', $faq );
				
				/**
				 * Update page counter
				 */
				$faq_faq_handler->updateCounter ( $clean_faq_id );
				
				$icmsTpl->assign ( 'show_faq_info', $faqConfig ['show_faq_info'] );
				
				$categoryObj = $faq_category_handler->get( $faqObj->getVar('faq_cid','e') );
				$parent = '';
				if ($categoryObj->getVar('cat_pid','e') != 0){
					$parentCategoryObj = $faq_category_handler->get( $categoryObj->getVar('cat_pid','e') );
					$parent = $parentCategoryObj->getItemLink ( false, $parentCategoryObj->cat_menutitle()).' > ';
				}
				
				$icmsTpl->assign ( 'faq_category_path', $parent.$categoryObj->getItemLink ( false, $categoryObj->cat_menutitle()) );
				
				$icmsTpl->assign ( 'faq_rss_url', FAQ_URL . 'rss.php?cid=' . $faqObj->getVar ( 'faq_cid', 'e' ) );
				$icmsTpl->assign ( 'faq_rss_info', _MD_FAQ_RSS_GLOBAL );
				
				if ($faqConfig ['com_rule'] && $faqObj->getVar ( 'faq_cancomment' )) {
					$icmsTpl->assign ( 'faq_faq_comment', true );
					/**
					 * Fix the comment system when the SEO mode is active.
					 */
					if ($faqConfig ['seo_mode'] == 'disabled'){
					    include_once ICMS_ROOT_PATH . '/include/comment_view.php';
					}else{
						include_once 'comment_view.php';
					}
				}
				
				/**
				 * Generating meta information for this page
				 */
				$icms_metagen = new IcmsMetagen ( $faqObj->getVar ( 'faq_menutitle' ), $faqObj->getVar ( 'meta_keywords', 'n' ), $faqObj->getVar ( 'meta_description', 'n' ) );
				$icms_metagen->createMetaTags ();
			}
			break;
	}
	
	$icmsTpl->assign ( 'faq_module_home', faq_getModuleName ( true, true ) );
	
	include_once 'footer.php';
}
?>