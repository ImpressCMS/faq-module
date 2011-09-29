<?php
/**
 * Category page
 *
 * @copyright	INBOX International
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
 * @package		imfaq
 * @version		$Id$
 */

include_once 'header.php';

$xoopsOption ['template_main'] = 'imfaq_category.html';
include_once ICMS_ROOT_PATH . '/header.php';

$imfaq_category_handler = icms_getModuleHandler ( 'category' );
$imfaq_faq_handler = icms_getModuleHandler ( 'faq' );

/** Use a naming convention that indicates the source of the content of the variable */
$clean_category_id = isset ( $_GET ['cat_id'] ) ? intval ( $_GET ['cat_id'] ) : 0;
$clean_short_url = isset ( $_GET ['short_url'] ) ? $_GET ['short_url'] : '';
$clean_start = isset ( $_GET ['start'] ) ? intval ( $_GET ['start'] ) : 0;

if ($clean_short_url != '' && $clean_category_id == 0) {
	$criteria = new CriteriaCompo ();
	$criteria->add ( new Criteria ( 'short_url', $clean_short_url ) );
	$categoryObj = $imfaq_category_handler->getObjects ( $criteria );
	$categoryObj = $categoryObj [0];
	$clean_category_id = $categoryObj->getVar ( 'cat_id' );
} else {
	$categoryObj = $imfaq_category_handler->get ( $clean_category_id );
}

if ($categoryObj && ! $categoryObj->isNew () && $categoryObj->accessGranted ()) {
	/**
	 * display this category
	 */
	$icmsTpl->assign ( 'imfaq_category', $categoryObj->toArray () );
	
	/**
	 * Getting all the Faqs of this category
	 */
	
	switch ($imfaqConfig ['faqs_order']) {
		case 'weight' :
			$sort = 'faq_weight';
			$order = 'ASC';
			break;
		case 'pub_date_asc' :
			$sort = 'faq_published_date';
			$order = 'ASC';
			break;
		case 'pub_date_desc' :
			$sort = 'faq_published_date';
			$order = 'DESC';
			break;
	}
	
	$faqs = $imfaq_faq_handler->getFaqs ( $clean_start, $imfaqConfig ['faqs_limit'], $clean_category_id, false, false, $sort, $order );
	$icmsTpl->assign ( 'imfaq_faqs', $faqs );
	
	/**
	 * Create Navbar
	 */
	include_once ICMS_ROOT_PATH . '/class/pagenav.php';
	$faqs_count = $imfaq_faq_handler->getFaqsCount ( $clean_category_id );
	
	$pagenav = new XoopsPageNav ( $faqs_count, $imfaqConfig ['faqs_limit'], $clean_start, 'start', 'category_id=' . $clean_category_id );
	$icmsTpl->assign ( 'navbar', $pagenav->renderNav () );
	
	/**
	 * Breadcrumb
	 */
	if ($clean_category_id) {
		
		$parent = '';
		if ($categoryObj->getVar ( 'cat_pid', 'e' ) != 0) {
			$parentCategoryObj = $imfaq_category_handler->get ( $categoryObj->getVar ( 'cat_pid', 'e' ) );
			$parent = $parentCategoryObj->getItemLink ( false, $parentCategoryObj->cat_menutitle () );
		}
		
		$icmsTpl->assign ( 'imfaq_category_path', $parent );
	}
	
	$icmsTpl->assign ( 'displaytopcatdsc', $xoopsModuleConfig ['displaytopcatdsc'] );
	$icmsTpl->assign ( 'displaysubcatdsc', $xoopsModuleConfig ['displaysubcatdsc'] );
	
	$icmsTpl->assign ( 'imfaq_rss_url', IMFAQ_URL . 'rss.php?cid=' . $categoryObj->getVar ( 'cat_id', 'e' ) );
	$icmsTpl->assign ( 'imfaq_rss_info', _MD_IMFAQ_RSS_CATEGORY );
	
	/**
	 * Generating meta information for this page
	 */
	$icms_metagen = new IcmsMetagen ( $categoryObj->getVar ( 'cat_title' ), $categoryObj->getVar ( 'meta_keywords', 'n' ), $categoryObj->getVar ( 'meta_description', 'n' ) );
	$icms_metagen->createMetaTags ();
}

$icmsTpl->assign ( 'imfaq_module_home', imfaq_getModuleName ( true, true ) );

include_once 'footer.php';
?>