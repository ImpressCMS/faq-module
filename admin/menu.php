<?php
/**
* Configuring the amdin side menu for the module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

$i = -1;

$i++;
$adminmenu[$i]['title'] = _MI_FAQ_INDEX;
$adminmenu[$i]['link'] = 'admin/index.php';
$i++;
$adminmenu[$i]['title'] = _MI_FAQ_FAQS;
$adminmenu[$i]['link'] = 'admin/faq.php';
$i++;
$adminmenu[$i]['title'] = _MI_FAQ_CATEGORYS;
$adminmenu[$i]['link'] = 'admin/category.php';


global $icmsModule;
if (isset($icmsModule)) {

	$i = -1;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $icmsModule->getVar('mid');

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_GOTOMODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/faq/';

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $icmsModule->getVar('dirname');

	$i++;
	$headermenu[$i]['title'] = _MI_FAQ_IMPORT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/faq/admin/import.php';

	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/faq/admin/about.php';
}
?>