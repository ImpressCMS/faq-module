<?php
/**
* Footer page included at the end of each page on user side of the mdoule
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

$icmsTpl->assign("faq_adminpage", faq_getModuleAdminLink());
$icmsTpl->assign("faq_is_admin", $faq_isAdmin);
$icmsTpl->assign('faq_url', FAQ_URL);
$icmsTpl->assign('faq_images_url', FAQ_IMAGES_URL);
$icmsTpl->assign('module_footer', $myts->displayTarea($xoopsModuleConfig['module_footer'], 1));

$xoTheme->addStylesheet(FAQ_URL . 'module'.(( defined("_ADM_USE_RTL") && _ADM_USE_RTL )?'_rtl':'').'.css');

include_once(ICMS_ROOT_PATH . '/footer.php');

?>