<?php
/**
* FAQ random did you know block
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/
if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function faq_random_diduno_show($options){
	$faq_faq_handler = icms_getModuleHandler ( 'faq', 'faq' );

	$order = $options[0];
	$sort = $options[1];
	$limit = $options[2];

	$cid = array();
	for ( $i = 3; $i < count($options); $i++ ) {
		$cid[] = $options[$i];
	}
	$cid = in_array(0,$cid)?false:$cid;
	
	$faqsArray = $faq_faq_handler->getFaqs ( false, $limit, $cid, false, false, $order, $sort, true );
	
	$block = array();
	$block['faqs'] = $faqsArray;
	
	return $block;
}

function faq_random_diduno_edit($options){
	$faq_faq_handler = icms_getModuleHandler ( 'faq', 'faq' );
	
	//sort
	$sort = array('faq_question'=>_CO_FAQ_FAQ_FAQ_QUESTION,'faq_weight'=>_CO_FAQ_FAQ_FAQ_WEIGHT,'faq_id'=>_CO_FAQ_FAQ_FAQ_ID,'RAND'=>_MB_FAQ_ORDERBYRAND);
	$selsort = new XoopsFormSelect ( '', 'options[0]', $options [0] );
	$selsort->addOptionArray ( $sort );
		
	//order
	$order = array('ASC'=>'ASC','DESC'=>'DESC');
	$selorder = new XoopsFormSelect ( '', 'options[1]', $options [1] );
	$selorder->addOptionArray ( $order );
	
	//displaysubs
	$limit = new XoopsFormText ( '', 'options[2]', 5, 255, $options [2] );
	
	//Category list
	$catArr = $faq_faq_handler->getFaq_categoriesArray('category_read',true);
	$catArr[0] = _MB_FAQ_ALLCATEGS;
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
	$form .= '<td width="20%">' . _MB_FAQ_DIDUNO_LIMIT . '</td>';
	$form .= '<td>' . $limit->render () . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_FAQ_CATLIST_SORT . '</td>';
	$form .= '<td>' . $selsort->render () . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_FAQ_CATLIST_ORDER . '</td>';
	$form .= '<td>' . $selorder->render () . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_FAQ_DIDUNO_CATEG . '</td>';
	$form .= '<td>' . $selcategs->render () . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	
	return $form;
}
?>