<?php
/**
 * Fix for the comment system when the SEO mode is enable
 *
 *
 * @copyright	INBOX International
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
 * @package		imfaq
 * @version		$Id$
 */

include_once 'header.php';

include_once ICMS_ROOT_PATH . '/include/comment_view.php';

$commentsnav = $icmsTpl->get_template_vars ( 'commentsnav' );
$editcomment_link = $icmsTpl->get_template_vars ( 'editcomment_link' );
$deletecomment_link = $icmsTpl->get_template_vars ( 'deletecomment_link' );
$replycomment_link = $icmsTpl->get_template_vars ( 'replycomment_link' );

if (preg_match ( '/onclick="self.location.href=\'(.*)\'/', $commentsnav, $arr )) {
	$commentsnav = str_replace ( $arr [1], IMFAQ_URL . $arr [1], $commentsnav );
}

if (substr ( $editcomment_link, 0, 7 ) != 'http://') {
	$editcomment_link = IMFAQ_URL . $editcomment_link;
}
if (substr ( $deletecomment_link, 0, 7 ) != 'http://') {
	$deletecomment_link = IMFAQ_URL . $deletecomment_link;
}
if (substr ( $replycomment_link, 0, 7 ) != 'http://') {
	$replycomment_link = IMFAQ_URL . $replycomment_link;
}

$icmsTpl->assign ( 'commentsnav', $commentsnav );
$icmsTpl->assign ( 'editcomment_link', $editcomment_link );
$icmsTpl->assign ( 'deletecomment_link', $deletecomment_link );
$icmsTpl->assign ( 'replycomment_link', $replycomment_link );

?>