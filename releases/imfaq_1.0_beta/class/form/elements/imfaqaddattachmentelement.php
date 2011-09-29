<?php
/**
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

if (! defined ( "ICMS_ROOT_PATH" ))
	die ( "ICMS root path not defined" );

include_once (ICMS_ROOT_PATH . "/modules/imfaq/class/form/elements/imfaqtrayelement.php");

class ImfaqAddattachmentElement extends ImfaqTrayElement {
	function ImfaqAddattachmentElement($object, $key, $attach_fid = false) {
		global $xoTheme;
		
		// Creating Tray
		$var = $object->vars [$key];
		
		$this->XoopsFormElementTray ( $var ['form_caption'], '', $key );
		
		include_once ICMS_ROOT_PATH . "/kernel/icmspersistabletable.php";
		$imfaq_attachment_handler = icms_getModuleHandler ( 'attachment' );
		
		$attachment_pluginsArray = $imfaq_attachment_handler->getModuleList (false);
		if (!count($attachment_pluginsArray)){
			$add_attachments_label = new XoopsFormLabel ( null, _AM_IMFAQ_NOPLUGINS );
			$this->addElement ( $add_attachments_label );
			return false;
		}
		
		$id = $object->getVar ( 'faq_id', 'e' );
		if (empty ( $id ) && ! $attach_fid) {
			$id = rand ( 1, 1000 );
		} elseif (empty ( $id ) && $attach_fid) {
			$id = $attach_fid;
		}
		
		$btn = new XoopsFormButton('','attach_btn',_AM_IMFAQ_FAQ_ATTACH);

		$add_attachments_label = new XoopsFormLabel ( null, '<a name="auto_attach" />'.$btn->render() . '<br />' );
		$this->addElement ( $add_attachments_label );
		
		/**
		 * Getting the actual attachments
		 */
		$criteria = new CriteriaCompo ( new Criteria ( 'attach_fid', $id ) );
		$criteria->setSort('attach_weight');
		$criteria->setOrder('ASC');
		$attachments = $imfaq_attachment_handler->getObjects ( $criteria, true, false );
		
		$html = '<h2 style="padding:0; margin:0;">'._MI_IMFAQ_ATTACHMENTS.'</h2>';
		$html .= '<ul id="uplist">';
		foreach ( $attachments as $attachment ) {
			$html .= '<li id="attachment_' . $attachment ['attach_id'] . '">';
			$html .= '  <a href="' . $attachment ['attach_url'] . '" target="_blank">' . $attachment ['attach_title'] . '</a>';
			$html .= '  <img class="sort_attachment" src="'.ICMS_URL.'/modules/imfaq/images/arrow.png" width="10" alt="'._AM_IMFAQ_ATTACHMENT_SORT.'" title="'._AM_IMFAQ_ATTACHMENT_SORT.'" />';
			$html .= '  <img class="show_hide_attachment" id="sh_' . $attachment ['attach_id'] . '" src="'.ICMS_URL.'/modules/imfaq/images/'.($attachment ['attach_status'] == 1?'hide':'show').'.gif" width="12" alt="'.($attachment ['attach_status'] == 1?_AM_IMFAQ_ATTACHMENT_HIDE:_AM_IMFAQ_ATTACHMENT_SHOW).'" title="'.($attachment ['attach_status'] == 1?_AM_IMFAQ_ATTACHMENT_HIDE:_AM_IMFAQ_ATTACHMENT_SHOW).'" />';
			$html .= '  <img class="delete_attachment" id="' . $attachment ['attach_id'] . '" src="'.ICMS_IMAGES_SET_URL.'/actions/button_cancel.png" width="10" alt="'._AM_IMFAQ_ATTACHMENT_DELETE.'" title="'._AM_IMFAQ_ATTACHMENT_DELETE.'" />';
			$html .= '</li>';
		}
		$html .= '</ul>';
		$attachments_label = new XoopsFormLabel ( '', $html, 'lb_' . $key );
		$this->addElement ( $attachments_label );
		
		$attachments = $imfaq_attachment_handler->getObjects ( $criteria, true, false );
		$attachmentsids = array_keys ( $attachments );
		unset ( $attachments );
		
		$this->addElement ( new XoopsFormHidden ( 'attach_fid', $id ) );
		$this->addElement ( new XoopsFormHidden ('original_'.$key, implode ( '|', $attachmentsids ) ) );
		$this->addElement ( new XoopsFormHidden ($key, implode ( '|', $attachmentsids ) ) );
	
		$js = 'var ICMS_IMAGES_SET_URL = "'.ICMS_IMAGES_SET_URL.'";'."\r\n";
		$js .= 'var ICMS_URL = "'.ICMS_URL.'";'."\r\n";
		$js .= 'var _AM_IMFAQ_FAQ_ATTACH = "'._AM_IMFAQ_FAQ_ATTACH.'";'."\r\n";
		$js .= 'var _AM_IMFAQ_CANCEL = "'._AM_IMFAQ_CANCEL.'";'."\r\n";
		$js .= 'var _AM_IMFAQ_ATTACH_WARNING = "'._AM_IMFAQ_ATTACH_WARNING.'";'."\r\n";
		$js .= 'var _AM_IMFAQ_ATTACH_WARNING_MSG = "'._AM_IMFAQ_ATTACH_WARNING_MSG.'";'."\r\n";
		$js .= 'var _CO_ICMS_DELETE_CONFIRM = "'._CO_ICMS_DELETE_CONFIRM.'";'."\r\n";
		$js .= 'var _CO_ICMS_DELETE = "'._CO_ICMS_DELETE.'";'."\r\n";
		$js .= 'var _AM_IMFAQ_ATTACH_WARNING_HAS_ATTACH = "'._AM_IMFAQ_ATTACH_WARNING_HAS_ATTACH.'";'."\r\n";
		$js .= 'var _AM_IMFAQ_ATTACHMENT_SORT = "'._AM_IMFAQ_ATTACHMENT_SORT.'";'."\r\n";
		$js .= 'var _AM_IMFAQ_ATTACHMENT_HIDE = "'._AM_IMFAQ_ATTACHMENT_HIDE.'";'."\r\n";
		$js .= 'var _AM_IMFAQ_ATTACHMENT_SHOW = "'._AM_IMFAQ_ATTACHMENT_SHOW.'";'."\r\n";
		$js .= 'var _AM_IMFAQ_ATTACHMENT_DELETE = "'._AM_IMFAQ_ATTACHMENT_DELETE.'";'."\r\n";
		$xoTheme->addScript('', array('type' => 'text/javascript'),$js);
		$xoTheme->addScript(ICMS_URL . "/modules/imfaq/include/jquery.json-2.2.min.js", array('type' => 'text/javascript'));
		$xoTheme->addScript(ICMS_URL.'/modules/imfaq/include/jquery-ui-1.7.3.custom.js', array('type' => 'text/javascript'));
		$xoTheme->addScript(ICMS_URL.'/modules/imfaq/include/ui.sortable.js', array('type' => 'text/javascript'));
		$xoTheme->addScript(ICMS_URL . "/modules/imfaq/class/form/elements/imfaqaddattachmentelement.js", array('type' => 'text/javascript'));
	}
}
?>