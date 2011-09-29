<?php
/**
 * Import Script
 * 
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
 */

include_once ("admin_header.php");

$op = 'none';

if (isset ( $_GET ['op'] ))
	$op = $_GET ['op'];
if (isset ( $_POST ['op'] ))
	$op = $_POST ['op'];

switch ( $op) {
	
	case "importExecute" :
		
		$importfile = (isset ( $_POST ['importfile'] )) ? $_POST ['importfile'] : 'nonselected';
		$importfile_path = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar ( 'dirname' ) . "/admin/" . $importfile . ".php";
		if (! file_exists ( $importfile_path )) {
			$errs [] = sprintf ( _AM_IMFAQ_IMPORT_FILE_NOT_FOUND, $importfile_path );
			$error = true;
		} else {
			include_once ($importfile_path);
		}
		
		if ($error == true) {
			$endMsg = _AM_IMFAQ_IMPORT_ERROR . '<br />' . _ERROR . '<br />' . implode ( '<br />', $errs );
		} else {
			$endMsg = _AM_IMFAQ_IMPORT_SUCCESS;
		}
		
		redirect_header ( 'import.php', 3, $endMsg );
	break;
	
	case "default" :
	default :
		
		$importfile = 'none';
		
		icms_cp_header ();
		
		$icmsModule->displayAdminMenu ( - 1, _AM_IMFAQ_IMPORT );
		
		include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
		
		$module_handler = & xoops_gethandler ( 'module' );
		
		// SmartFAQ
		$moduleObj = $module_handler->getByDirname ( 'smartfaq' );
		if ($moduleObj) {
			$from_module_version = round ( $moduleObj->getVar ( 'version' ) / 100, 2 );
			if ($from_module_version == 1.08) {
				$importfile_select_array ["smartfaq"] = "SmartFAQ " . $from_module_version;
				$sf_version = $from_module_version;
			}
		}
/*		
		// XoopsFAQ
		$moduleObj = $module_handler->getByDirname ( 'xoopsfaq' );
		if ($moduleObj) {
			$from_module_version = round ( $moduleObj->getVar ( 'version' ) / 100, 2 );
			if ($from_module_version == 1.10) {
				$importfile_select_array ["xoopsfaq"] = "XoopsFAQ " . $from_module_version;
				$xf_version = $from_module_version;
			}
		}
		
		// WF-FAQ
		$moduleObj = $module_handler->getByDirname ( 'wffaq' );
		if ($moduleObj) {
			$from_module_version = round ( $moduleObj->getVar ( 'version' ) / 100, 2 );
			if ($from_module_version == 1.05) {
				$importfile_select_array ["wffaq"] = "WF-FAQ " . $from_module_version;
				$wff_version = $from_module_version;
			}
		}
*/
		if (isset ( $importfile_select_array ) && count ( $importfile_select_array ) > 0) {
			
			$sform = new XoopsThemeForm ( _AM_IMFAQ_IMPORT_SELECTION, "op", xoops_getenv ( 'PHP_SELF' ) );
			$sform->setExtra ( 'enctype="multipart/form-data"' );
			
			// Partners to import
			$importfile_select = new XoopsFormSelect ( '', 'importfile', $importfile );
			$importfile_select->addOptionArray ( $importfile_select_array );
			$importfile_tray = new XoopsFormElementTray ( _AM_IMFAQ_IMPORT_SELECT_FILE, '&nbsp;' );
			$importfile_tray->addElement ( $importfile_select );
			$importfile_tray->setDescription ( _AM_IMFAQ_IMPORT_SELECT_FILE_DSC );
			$sform->addElement ( $importfile_tray );
			
			// Buttons
			$button_tray = new XoopsFormElementTray ( '', '' );
			$hidden = new XoopsFormHidden ( 'op', 'importExecute' );
			$button_tray->addElement ( $hidden );
			
			$butt_import = new XoopsFormButton ( '', '', _AM_IMFAQ_IMPORT, 'submit' );
			$butt_import->setExtra ( 'onclick="this.form.elements.op.value=\'importExecute\'"' );
			$button_tray->addElement ( $butt_import );
			
			$butt_cancel = new XoopsFormButton ( '', '', _AM_IMFAQ_CANCEL, 'button' );
			$butt_cancel->setExtra ( 'onclick="history.go(-1)"' );
			$button_tray->addElement ( $butt_cancel );
			
			$sform->addElement ( $button_tray );
			if (! empty ( $sf_version )) {
				$sform->addElement ( new XoopsFormHidden ( 'sf_version', $sf_version ) );
			}
			/*
			if (! empty ( $xf_version )) {
				$sform->addElement ( new XoopsFormHidden ( 'xf_version', $xf_version ) );
			}
			if (! empty ( $wff_version )) {
				$sform->addElement ( new XoopsFormHidden ( 'wff_version', $wff_version ) );
			}
			*/
			$sform->display ();
			unset ( $hidden );
		} else {
			echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-weight: bold; font-size: small; display: block; \">" . _AM_IMFAQ_IMPORT_NO_MODULE . "</span>";
		}
		icms_cp_footer ();
	break;
}
?>