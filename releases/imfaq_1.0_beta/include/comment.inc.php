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
* @package		imfaq
* @version		$Id$
*/

function imfaq_com_update($item_id, $total_num)
{
    $imfaq_faq_handler = icms_getModuleHandler('faq', 'imfaq');
    $imfaq_faq_handler->updateComments($item_id, $total_num);
}

function imfaq_com_approve(&$comment)
{
    // notification mail here
}

?>