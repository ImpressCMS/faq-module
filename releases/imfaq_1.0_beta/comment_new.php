<?php
/**
* New comment form
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

include_once 'header.php';
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
if ($com_itemid > 0) {
	$imfaq_faq_handler = icms_getModuleHandler('faq');
	$faqObj = $imfaq_faq_handler->get($com_itemid);
	$faq = $faqObj->toArray();
	if ($faqObj && !$faqObj->isNew()) {
		$com_replytext = _POSTEDBY.'&nbsp;<b>'.icms_getLinkedUnameFromId($faq['faq_uid']) . '</b>&nbsp;'._DATE.'&nbsp;<b>'.$faq['faq_published_date'].'</b>';
		$bodytext = $faq['faq_teaser'];
		if ($bodytext != '') {
			$com_replytext .= '<br /><br />'.$bodytext.'';
		}
		$com_replytitle = strip_tags($faq['faq_title']);
		include_once ICMS_ROOT_PATH .'/include/comment_new.php';
	}
}

?>