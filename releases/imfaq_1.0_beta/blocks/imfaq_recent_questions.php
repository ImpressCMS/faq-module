<?php
/**
* imFAQ recent FAQs block
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/
if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function imfaq_recent_questions_show($options){
	$imfaq_faq_handler = icms_getModuleHandler ( 'faq', 'imfaq' );

	$limit = $options[0];

	$cid = array();
	for ( $i = 1; $i < count($options); $i++ ) {
		$cid[] = $options[$i];
	}
	$cid = in_array(0,$cid)?false:$cid;
	
	$faqsArray = $imfaq_faq_handler->getFaqs ( false, $limit, $cid, false, false, 'faq_id', 'DESC' );
	
	$block = array();
	$block['faqs'] = $faqsArray;
	
	return $block;
}

function imfaq_recent_questions_edit($options){
	$imfaq_faq_handler = icms_getModuleHandler ( 'faq', 'imfaq' );
	
	//limit
	$limit = new XoopsFormText ( '', 'options[0]', 5, 255, $options [0] );
	
	//Category list
	$catArr = $imfaq_faq_handler->getFaq_categoriesArray('category_read',true);
	$catArr[0] = _MB_IMFAQ_ALLCATEGS;
	$size = count($options);
	$value = array();
	for ( $i = 1; $i < $size; $i++ ) {
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
	$form .= '<td>' . _MB_IMFAQ_DIDUNO_CATEG . '</td>';
	$form .= '<td>' . $selcategs->render () . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	
	return $form;
}
?>