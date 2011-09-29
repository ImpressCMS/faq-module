<?php
/**
* Footer page included at the end of each page on user side of the mdoule
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

$icmsTpl->assign("imfaq_adminpage", imfaq_getModuleAdminLink());
$icmsTpl->assign("imfaq_is_admin", $imfaq_isAdmin);
$icmsTpl->assign('imfaq_url', IMFAQ_URL);
$icmsTpl->assign('imfaq_images_url', IMFAQ_IMAGES_URL);
$icmsTpl->assign('module_footer', $myts->displayTarea($xoopsModuleConfig['module_footer'], 1));

$xoTheme->addStylesheet(IMFAQ_URL . 'module'.(( defined("_ADM_USE_RTL") && _ADM_USE_RTL )?'_rtl':'').'.css');

include_once(ICMS_ROOT_PATH . '/footer.php');

?>