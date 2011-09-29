<?php
/**
* imFAQ plugin for Smartpartner
*
* This file holds functions to allow imFAQ use Smartpartner items as attachment.
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

include_once (XOOPS_ROOT_PATH . "/modules/smartpartner/include/common.php");
icms_loadLanguageFile ( 'smartpartner', 'common' );
icms_loadLanguageFile ( 'smartpartner', 'admin' );
icms_loadLanguageFile ( 'smartpartner', 'modinfo' );

function imfaq_smartpartner_getItemTitle($itemid = 0) {
	// Creating the partner handler object
	$smartpartner_partner_handler = & smartpartner_gethandler ( 'partner' );
	
	$partner = $smartpartner_partner_handler->get ( $itemid );
	
	if (! is_object ( $partner )) {
		return false;
	}
	
	return $partner->title ();
}

function imfaq_smartpartner_getItemUrl($itemid = 0) {
	// Creating the partner handler object
	$smartpartner_partner_handler = & smartpartner_gethandler ( 'partner' );
	
	$partner = $smartpartner_partner_handler->get ( $itemid );
	
	if (! is_object ( $partner )) {
		return false;
	}
	
	return $partner->getUrlLink ( false, true );
}

function imfaq_smartpartner_showItemsTable($startpartner = 0, $query = '') {
	
	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
	include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
	
	global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule;
	
	$smartpartner_partner_handler = & smartpartner_gethandler ( 'partner' );
	// Get the total number of published PARTNER
	$criteria = new CriteriaCompo ();
	if (! empty ( $query )) {
		$criteriaKeyword = new CriteriaCompo ();
		$criteriaKeyword->add ( new Criteria ( 'title', '%' . $query . '%', 'LIKE' ), 'OR' );
		$criteriaKeyword->add ( new Criteria ( 'summary', '%' . $query . '%', 'LIKE' ), 'OR' );
		$criteriaKeyword->add ( new Criteria ( 'description', '%' . $query . '%', 'LIKE' ), 'OR' );
		$criteria->add ( $criteriaKeyword );
	}
	$totalpartners = $smartpartner_partner_handler->getCount ( $criteria );
	
	$criteria->setLimit ( 10 );
	$criteria->setStart ( $startpartner );
	$criteria->setOrder ( 'ASC' );
	$criteria->setSort ( 'title' );
	$partnersObj = $smartpartner_partner_handler->getObjects ( $criteria );
	$totalPartnersOnPage = count ( $partnersObj );
	echo '<div style="text-align:right; padding:5px;"><input type="text" name="query" id="query" size="30" value="' . $query . '" /> <input id="query_btn" type="button" value="Search" /></div>';
	echo '<form name="smartpartners_select_items" id="smartpartners_select_items">';
	echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
	echo "<tr>";
	echo "<th align='left'><b>" . _AM_SPARTNER_NAME . "</b></th>";
	echo "<th width='60' align='center'><b>" . _AM_SPARTNER_STATUS . "</b></th>";
	echo "<th width='20' align='center'><b>Select</b></th>";
	echo "</tr>";
	if ($totalpartners > 0) {
		for($i = 0; $i < $totalPartnersOnPage; $i ++) {
			$class = (empty ( $class ) || $class == 'even') ? 'odd' : 'even';
			echo "<tr class='" . $class . "'>";
			echo "<td align='left'>" . $partnersObj [$i]->getUrlLink ( 'index' ) . "" . $partnersObj [$i]->title () . "</a></td>";
			echo "<td align='center'>" . $partnersObj [$i]->getStatusName () . "</td>";
			echo "<td align='center'><input type='checkbox' name='id[]' value='" . $partnersObj [$i]->id () . "' /></td>";
			echo "</tr>";
		}
	} else {
		$id = 0;
		echo "<tr>";
		echo "<td class='head' align='center' colspan= '3'>" . _AM_SPARTNER_NOPARTNERS . "</td>";
		echo "</tr>";
	}
	echo "</table>\n";
	echo '</form>';
	echo "<br />\n";
	
	$pagenav = new XoopsPageNav ( $totalpartners, 10, $startpartner, 'startpartner' );
	echo '<div style="text-align:right;" id="pagenav">' . $pagenav->renderNav () . '</div>';
}

function imfaq_smartpartner_accessGranted($itemid=0) {
	global $xoopsUser;
	
	$gperm_handler = & xoops_gethandler ( 'groupperm' );
	$groups = is_object ( $xoopsUser ) ? $xoopsUser->getGroups () : array (XOOPS_GROUP_ANONYMOUS );
	
	$module_handler = xoops_gethandler ( 'module' );
	$module = $module_handler->getByDirname ( 'smartpartner' );
	
	$agroups = $gperm_handler->getGroupIds ( 'module_admin', $module->mid () );
	$allowed_groups = array_intersect ( $groups, $agroups );
	
	// Creating the partner handler object
	$smartpartner_partner_handler = & smartpartner_gethandler ( 'partner' );
	
	$partner = $smartpartner_partner_handler->get ( $itemid );
	
	if (! is_object ( $partner )) {
		return false;
	}
	
	$viewperm = $partner->status() == _SPARTNER_STATUS_ACTIVE?true:false;
	
	if ($viewperm) {
		return true;
	}
	
	if ($viewperm && count ( $allowed_groups ) > 0) {
		return true;
	}
	
	return false;
}
?>