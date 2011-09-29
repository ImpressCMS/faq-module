<?php
/**
* Comment include file
*
* File holding functions used by the module to hook with the comment system of ImpressCMS
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

function faq_com_update($item_id, $total_num)
{
    $faq_faq_handler = icms_getModuleHandler('faq', 'faq');
    $faq_faq_handler->updateComments($item_id, $total_num);
}

function faq_com_approve(&$comment)
{
    // notification mail here
}

?>