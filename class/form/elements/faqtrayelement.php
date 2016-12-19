<?php
/**
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

class FaqTrayElement extends XoopsFormElementTray {
    function render() {
    	$ret = '<div id="' . $this->getName() . '">';
    	$ret .= parent::render();
    	$ret .= '</div>';
    	return $ret;
    }
}
?>