<?php
/**
* imFAQ random did you know block
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/
if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function imfaq_random_diduno_show($options){
	$imfaq_faq_handler = icms_getModuleHandler ( 'faq', 'imfaq' );

	$order = $options[0];
	$sort = $options[1];
	$limit = $options[2];

	$cid = array();
	for ( $i = 3; $i < count($options); $i++ ) {
		$cid[] = $options[$i];
	}
	$cid = in_array(0,$cid)?false:$cid;
	
	$faqsArray = $imfaq_faq_handler->getFaqs ( false, $limit, $cid, false, false, $order, $sort );
	
	$block = array();
	$block['faqs'] = $faqsArray;
	
	return $block;
}

function imfaq_random_diduno_edit($options){
	$imfaq_faq_handler = icms_getModuleHandler ( 'faq', 'imfaq' );
	
	//sort
	$sort = array('faq_question'=>_CO_IMFAQ_FAQ_FAQ_QUESTION,'faq_weight'=>_CO_IMFAQ_FAQ_FAQ_WEIGHT,'faq_id'=>_CO_IMFAQ_FAQ_FAQ_ID,'RAND'=>_MB_IMFAQ_ORDERBYRAND);
	$selsort = new XoopsFormSelect ( '', 'options[0]', $options [0] );
	$selsort->addOptionArray ( $sort );
		
	//order
	$order = array('ASC'=>'ASC','DESC'=>'DESC');
	$selorder = new XoopsFormSelect ( '', 'options[1]', $options [1] );
	$selorder->addOptionArray ( $order );
	
	//displaysubs
	$limit = new XoopsFormText ( '', 'options[2]', 5, 255, $options [2] );
	
	//Category list
	$catArr = $imfaq_faq_handler->getFaq_categoriesArray('category_read',true);
	$catArr[0] = _MB_IMFAQ_ALLCATEGS;
	$size = count($options);
	$value = array();
	for ( $i = 3; $i < $size; $i++ ) {
		if (in_array($options[$i],array_keys($catArr))) {
			$value[] = $options[$i];
		}
	}	
	$selcategs = new XoopsFormSelect ( '', 'options', $value, 5, true );
	$selcategs->addOptionArray ( $catArr );
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td width="20%">' . _MB_IMFAQ_DIDUNO_LIMIT . '</td>';
	$form .= '<td>' . $limit->render () . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_IMFAQ_CATLIST_SORT . '</td>';
	$form .= '<td>' . $selsort->render () . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_IMFAQ_CATLIST_ORDER . '</td>';
	$form .= '<td>' . $selorder->render () . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_IMFAQ_DIDUNO_CATEG . '</td>';
	$form .= '<td>' . $selcategs->render () . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	
	return $form;
}
?>