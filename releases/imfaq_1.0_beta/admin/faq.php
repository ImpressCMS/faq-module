<?php
/**
* Admin page to manage faqs
*
* List, add, edit and delete faq objects
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

/**
 * Edit a Faq
 *
 * @param int $faq_id Faqid to be edited
 */
function editfaq($faq_id = 0) {
	global $imfaq_faq_handler, $icmsModule, $icmsAdminTpl, $imfaqConfig, $xoopsUser;
	
	$faqObj = $imfaq_faq_handler->get ( $faq_id );
	
	if (!$imfaqConfig['enable_attachments']){
		$faqObj->hideFieldFromForm ( array ('faq_attachments'));
	}
	
	if (! $faqObj->isNew ()) {
		$icmsModule->displayAdminMenu ( 1, _AM_IMFAQ_FAQS . " > " . _CO_ICMS_EDITING );
		$sform = $faqObj->getForm ( _AM_IMFAQ_FAQ_EDIT, 'addfaq' );
		$sform->assign ( $icmsAdminTpl );
	
	} else {
		$icmsModule->displayAdminMenu ( 1, _AM_IMFAQ_FAQS . " > " . _CO_ICMS_CREATINGNEW );
		$faqObj->setVar('faq_published_date',time());
		$faqObj->setVar ( 'faq_uid', $xoopsUser->uid () );
		$sform = $faqObj->getForm ( _AM_IMFAQ_FAQ_CREATE, 'addfaq' );
		$sform->assign ( $icmsAdminTpl );
	
	}
	$icmsAdminTpl->display ( 'db:imfaq_admin_faq.html' );
}

include_once ("admin_header.php");

$imfaq_faq_handler = icms_getModuleHandler ( 'faq' );
$imfaq_attachment_handler = icms_getModuleHandler ( 'attachment' );

/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('mod', 'changedField', 'addfaq', 'del', 'view', 'changedField_attach', '' );

if (isset ( $_GET ['op'] ))
	$clean_op = htmlentities ( $_GET ['op'] );
if (isset ( $_POST ['op'] ))
	$clean_op = htmlentities ( $_POST ['op'] );

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_faq_id = isset ( $_GET ['faq_id'] ) ? ( int ) $_GET ['faq_id'] : 0;
if ($clean_faq_id && empty($clean_op)){
	$clean_op = 'view';
}
/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
 */
if (in_array ( $clean_op, $valid_op, true )) {
	switch ( $clean_op) {
		case "mod" :		
			icms_cp_header ();
			
			editfaq ( $clean_faq_id );
		break;
		case "addfaq" :
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistablecontroller.php";
			$controller = new IcmsPersistableController ( $imfaq_faq_handler );
			$controller->storeFromDefaultForm ( _AM_IMFAQ_FAQ_CREATED, _AM_IMFAQ_FAQ_MODIFIED, imfaq_get_page_before_form() );

		break;
		
		case "del" :
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistablecontroller.php";
			$controller = new IcmsPersistableController ( $imfaq_faq_handler );
			$controller->handleObjectDeletion ();
		
		break;
		
		case "changedField" :
		    foreach ($_POST['ImfaqFaq_objects'] as $k=>$v){
		       $changed = false;
		       $obj = $imfaq_faq_handler->get($v);
		       if ($obj->getVar('faq_status','e') != $_POST['faq_status'][$k]){
		           $obj->setVar('faq_status',intval($_POST['faq_status'][$k]));
		           $changed = true;
		       }
		       if ($obj->getVar('faq_weight','e') != $_POST['faq_weight'][$k]){
		           $obj->setVar('faq_weight',intval($_POST['faq_weight'][$k]));
		           $changed = true;
		       }
		       if ($changed){
		           $imfaq_faq_handler->insert($obj);
		       }
		    }

		    redirect_header('faq.php',2,_AM_IMFAQ_FAQ_MODIFIED);
		
		break;
		
		case "changedField_attach" :
			foreach ( $_POST ['ImfaqAttachment_objects'] as $k => $v ) {
				$changed = false;
				$obj = $imfaq_attachment_handler->get ( $v );
				if ($obj->getVar ( 'attach_status', 'e' ) != $_POST ['attach_status'] [$k]) {
					$obj->setVar ( 'attach_status', intval ( $_POST ['attach_status'] [$k] ) );
					$changed = true;
				}
				if ($obj->getVar ( 'attach_weight', 'e' ) != $_POST ['attach_weight'] [$k]) {
					$obj->setVar ( 'attach_weight', intval ( $_POST ['attach_weight'] [$k] ) );
					$changed = true;
				}
				if ($changed) {
					$imfaq_attachment_handler->insert ( $obj );
				}
			}
			if ($clean_faq_id) {
				$redir = '?faq_id=' . $clean_faq_id;
			}
			redirect_header ( 'faq.php'.$redir, 2, _AM_IMFAQ_ATTACHMENT_MODIFIED );
			break;
		
		case "view" :
			$faqObj = $imfaq_faq_handler->get ( $clean_faq_id );
			
			icms_cp_header ();
			
			$xoopsModule->displayAdminMenu ( 1, _AM_IMFAQ_FAQS . " > " . _PREVIEW .' > '. $faqObj->getVar('faq_question','nh') );
			
			$faqObj->displayFieldOnSingleView('counter');
			$faqObj->displaySingleObject ( false, false, array('edit','delete') );
		
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistabletable.php";
			
			$criteria = new CriteriaCompo ( new Criteria ( 'attach_fid', $clean_faq_id ) );
			
			$objectTable = new IcmsPersistableTable ( $imfaq_attachment_handler, $criteria, array('delete') );
			
			$objectTable->addHeader ( '<h2>'._MI_IMFAQ_ATTACHMENTS.'</h2>' );
			
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'attach_module', 'left', 150 ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'attach_link' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'attach_weight', 'center', 80, 'getAttachment_weightControl' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'attach_status', 'center', 80, 'getAttachment_statusControl' ) );
			
			$objectTable->addFilter ( 'attach_status', 'getAttachment_statusArray' );
			$objectTable->addIntroButton ( 'addattachment', 'faq.php?op=mod&faq_id='.$clean_faq_id.'#auto_attach', _AM_IMFAQ_FAQ_ATTACH );
			$objectTable->addActionButton ( 'changedField_attach', false, _SUBMIT );
			
			$icmsAdminTpl->assign ( 'imfaq_attachment_table', $objectTable->fetch () );
			$icmsAdminTpl->display ( 'db:imfaq_admin_attachment.html' );

		break;
		
		default :
			
			icms_cp_header ();
			
			$icmsModule->displayAdminMenu ( 1, _AM_IMFAQ_FAQS );
				
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistabletable.php";
			$objectTable = new IcmsPersistableTable ( $imfaq_faq_handler );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_cid', _LEFT, 200 ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_question',false,false,'faq_question' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_published_date', _CENTER, 150 ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'counter', _CENTER, 80 ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_weight', 'center', 80, 'getFaq_weightControl' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_status', 'center', 80, 'getFaq_statusControl' ) );
			
			$objectTable->addIntroButton ( 'addfaq', 'faq.php?op=mod', _AM_IMFAQ_FAQ_CREATE );
			$objectTable->addActionButton ( 'changedField', false, _SUBMIT );
			if ($imfaqConfig ['enable_attachments']){
				$objectTable->addCustomAction('getViewItemLink');
			}
			
			$objectTable->addQuickSearch ( array ('faq_question', 'faq_answer', 'faq_diduno' ) );
			
			$objectTable->addFilter ( 'faq_uid', 'getPostersArray' );
			$objectTable->addFilter ( 'faq_status', 'getFaq_statusArray' );
			$objectTable->addFilter ( 'faq_cid', 'getFaq_categoriesArray' );
			
			$objectTable->setDefaultSort('faq_published_date');
			$objectTable->setDefaultOrder('DESC');
			
			$icmsAdminTpl->assign ( 'imfaq_faq_table', $objectTable->fetch () );
			$icmsAdminTpl->display ( 'db:imfaq_admin_faq.html' );
		break;
	}
	icms_cp_footer ();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */
?>