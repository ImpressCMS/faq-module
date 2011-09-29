<?php
/**
 * Index page
 *
 * @copyright	INBOX International
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
 * @package		imfaq
 * @version		$Id$
 */

include_once 'header.php';

$clean_start = isset ( $_GET ['start'] ) ? intval ( $_GET ['start'] ) : 0;

$xoopsOption ['template_main'] = 'imfaq_index.html';
include_once ICMS_ROOT_PATH . '/header.php';

$imfaq_category_handler = icms_getModuleHandler ( 'category' );

/**
 * list categorys
 */
include_once ICMS_ROOT_PATH . "/kernel/icmspersistabletable.php";

$icmsTpl->assign ( 'imfaq_title', _MD_IMFAQ_ALL_CATEGORYS );

/**
 * Create Navbar
 */
include_once ICMS_ROOT_PATH . '/class/pagenav.php';
$cats_count = count ( $imfaq_category_handler->getCategories ( false, false, false, 0 ) );

$pagenav = new XoopsPageNav ( $cats_count, $imfaqConfig ['cats_limit'], $clean_start, 'start' );
$icmsTpl->assign ( 'navbar', $pagenav->renderNav () );

switch ($imfaqConfig ['categs_order']){
	case 'weight':
		$sort = 'cat_weight';
		$order = 'ASC';
		break;
	case 'pub_date_asc':
		$sort = 'cat_published_date';
		$order = 'ASC';
		break;
	case 'pub_date_desc':
		$sort = 'cat_published_date';
		$order = 'DESC';
		break;
}

$icmsTpl->assign ( 'imfaq_categories', $imfaq_category_handler->getCategories ( $clean_start, $imfaqConfig ['cats_limit'], 0, 0, $sort, $order ) );

$icmsTpl->assign ( 'imfaq_module_home', imfaq_getModuleName ( true, true ) );

$icmsTpl->assign ( 'displaytopcatdsc', $xoopsModuleConfig ['displaytopcatdsc'] );
$icmsTpl->assign ( 'displaysubcatonindex', $xoopsModuleConfig ['displaysubcatonindex'] );
$icmsTpl->assign ( 'displaysubcatdsc', $xoopsModuleConfig ['displaysubcatdsc'] );

$icmsTpl->assign ( 'module_header', $myts->displayTarea ( $xoopsModuleConfig ['module_header'], 1 ) );

$icmsTpl->assign ( 'imfaq_rss_url', IMFAQ_URL . 'rss.php' );
$icmsTpl->assign ( 'imfaq_rss_info', _MD_IMFAQ_RSS_GLOBAL );

include_once 'footer.php';
?>