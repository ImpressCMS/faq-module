<?php
/**
* Notification lookup function of the module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

/**
 * Notification lookup function
 *
 * This function is called by the notification process to get an array contaning information
 * about the item for which there is a notification
 *
 * @param string $category category of the notification
 * @param int $item_id id f the item related to this notification
 *
 * @return array containing 'name' and 'url' of the related item
 */
function faq_notify_iteminfo($category, $item_id){
    global $icmsModule, $icmsModuleConfig, $icmsConfig;

	// This must contain the name of the folder in which reside SmartPartner
	if( !defined("FAQ_DIRNAME") ){
		define("FAQ_DIRNAME", 'faq');
	}    

    if (empty($icmsModule) || $icmsModule->getVar('dirname') != FAQ_DIRNAME) {
        $module_handler = &xoops_gethandler('module');
        $module = &$module_handler->getByDirname(FAQ_DIRNAME);
        $config_handler = &xoops_gethandler('config');
        $config = &$config_handler->getConfigsByCat(0, $module->getVar('mid'));
    } else {
        $module = &$icmsModule;
        $config = &$icmsModuleConfig;
    } 
    
    if ($category == 'global_faq') {
        $item['name'] = '';
        $item['url'] = '';
    }
    
    if ($category == 'faq') {
    	$faq_faq_handler = icms_getModuleHandler ( 'faq','faq' );
    	
    	$faqObj = $faq_faq_handler->get($item_id);
    	
    	if ($faqObj->isNew()){
        	$item['name'] = '';
        	$item['url'] = '';
    	}else{
        	$item['name'] = $faqObj->getVar('faq_question','nh');
        	$item['url'] = $faqObj->getItemLink ( true );
    	}
    }
    
    return $item;
}
?>