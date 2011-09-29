<?php
/**
* imFAQ category list block
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/
if (! defined ( "ICMS_ROOT_PATH" ))
	die ( "ICMS root path not defined" );

function imfaq_categlist_show($options) {
	global $xoTheme;
	
	$xoTheme->addStylesheet ( IMFAQ_URL . 'module' . ((defined ( "_ADM_USE_RTL" ) && _ADM_USE_RTL) ? '_rtl' : '') . '.css' );
	
	$imfaq_category_handler = icms_getModuleHandler ( 'category', 'imfaq' );
	$imfaq_faq_handler = icms_getModuleHandler ( 'faq', 'imfaq' );
	
	$catArray = $imfaq_category_handler->getCategories ( false, false, false, 0, $options [0], $options [1] );
	
	$block = array ();
	$block ['categories'] = $catArray;
	$block ['displaysubs'] = $options [2];
	
	$current_id = - 1;
	
	if (! empty ( $_GET ['cat_id'] )) {
		$current_id = $_GET ['cat_id'];
	} elseif (! empty ( $_GET ['seoOp'] ) && $_GET ['seoOp'] == 'category' && ! empty ( $_GET ['short_url'] )) {
		$criteria = new CriteriaCompo ( new Criteria ( 'short_url', $_GET ['short_url'] ) );
		$categoryObj = $imfaq_category_handler->getObjects ( $criteria );
		$categoryObj = $categoryObj [0];
		if ($categoryObj->getVar ( 'cat_pid', 'e' ) != 0) {
			$categoryObj = $imfaq_category_handler->get ( $categoryObj->getVar ( 'cat_pid', 'e' ) );
		}
		$current_id = $categoryObj->getVar ( 'cat_id' );
	} elseif (! empty ( $_GET ['faq_id'] )) {
		$faqObj = $imfaq_faq_handler->get ( $_GET ['faq_id'] );
		$categoryObj = $imfaq_category_handler->get ( $faqObj->getVar ( 'faq_cid', 'e' ) );
		if ($categoryObj->getVar ( 'cat_pid', 'e' ) != 0) {
			$categoryObj = $imfaq_category_handler->get ( $categoryObj->getVar ( 'cat_pid', 'e' ) );
		}
		$current_id = $categoryObj->getVar ( 'cat_id' );
	} elseif (! empty ( $_GET ['seoOp'] ) && $_GET ['seoOp'] == 'faq' && ! empty ( $_GET ['short_url'] )) {
		$criteria = new CriteriaCompo ( new Criteria ( 'short_url', $_GET ['short_url'] ) );
		$faqObj = $imfaq_faq_handler->getObjects ( $criteria );
		$faqObj = $faqObj [0];
		$categoryObj = $imfaq_category_handler->get ( $faqObj->getVar ( 'faq_cid', 'e' ) );
		if ($categoryObj->getVar ( 'cat_pid', 'e' ) != 0) {
			$categoryObj = $imfaq_category_handler->get ( $categoryObj->getVar ( 'cat_pid', 'e' ) );
		}
		$current_id = $categoryObj->getVar ( 'cat_id' );
	}
	
	$block ['current'] = $current_id;
	
	return $block;
}

function imfaq_categlist_edit($options) {
	$form = "<table border='0'>";
	
	//sort
	$sort = array ('cat_title' => _MB_IMFAQ_CATEGORY_CAT_TITLE, 'cat_weight' => _MB_IMFAQ_CATEGORY_CAT_WEIGHT, 'cat_id' => _MB_IMFAQ_CATEGORY_CAT_ID );
	$selsort = new XoopsFormSelect ( '', 'options[0]', $options [0] );
	$selsort->addOptionArray ( $sort );
	
	//order
	$order = array ('ASC' => 'ASC', 'DESC' => 'DESC' );
	$selorder = new XoopsFormSelect ( '', 'options[1]', $options [1] );
	$selorder->addOptionArray ( $order );
	
	//displaysubs
	$opts = array ('0' => _ALL, '1' => _NONE, '2' => _MB_IMFAQ_ONLYCURRENTCATEG );
	$showsubs = new XoopsFormSelect ( '', 'options[2]', $options [2] );
	$showsubs->addOptionArray ( $opts );
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td width="20%">' . _MB_IMFAQ_CATLIST_SHOWSUBS . '</td>';
	$form .= '<td>' . $showsubs->render () . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_IMFAQ_CATLIST_SORT . '</td>';
	$form .= '<td>' . $selsort->render () . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_IMFAQ_CATLIST_ORDER . '</td>';
	$form .= '<td>' . $selorder->render () . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	
	return $form;
}
?>