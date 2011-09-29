<?php
/**
* Admin page to manage categorys
*
* List, add, edit and delete category objects
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

/**
 * Edit a Category
 *
 * @param int $cat_id Categoryid to be edited
 */
function editcategory($cat_id = 0, $cat_pid = 0) {
	global $imfaq_category_handler, $icmsModule, $icmsAdminTpl;
	
	$categoryObj = $imfaq_category_handler->get ( $cat_id );
	
	if (! $categoryObj->isNew ()) {
		$icmsModule->displayAdminMenu ( 2, _AM_IMFAQ_CATEGORYS . " > " . _CO_ICMS_EDITING );
		$sform = $categoryObj->getForm ( _AM_IMFAQ_CATEGORY_EDIT, 'addcategory' );
		$sform->assign ( $icmsAdminTpl );
	
	} else {
		$icmsModule->displayAdminMenu ( 2, _AM_IMFAQ_CATEGORYS . " > " . _CO_ICMS_CREATINGNEW );
		
		if ($cat_pid){
			$categoryObj->setVar('cat_pid',$cat_pid);
		}
		
		$sform = $categoryObj->getForm ( _AM_IMFAQ_CATEGORY_CREATE, 'addcategory' );
		$sform->assign ( $icmsAdminTpl );
	
	}
	$icmsAdminTpl->display ( 'db:imfaq_admin_category.html' );
}

include_once ("admin_header.php");

$imfaq_category_handler = icms_getModuleHandler ( 'category' );
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('mod', 'changedField', 'addcategory', 'del', 'view', 'showall', '' );

if (isset ( $_GET ['op'] ))
	$clean_op = htmlentities ( $_GET ['op'] );
if (isset ( $_POST ['op'] ))
	$clean_op = htmlentities ( $_POST ['op'] );

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_cat_id = isset ( $_GET ['cat_id'] ) ? ( int ) $_GET ['cat_id'] : 0;
$clean_cat_id = isset ( $_POST ['cat_id'] ) ? ( int ) $_POST ['cat_id'] : $clean_cat_id;
$clean_cat_pid = isset ( $_GET ['cat_pid'] ) ? ( int ) $_GET ['cat_pid'] : 0;
$clean_cat_pid = isset ( $_POST ['cat_pid'] ) ? ( int ) $_POST ['cat_pid'] : $clean_cat_pid;

$showall = isset ( $_GET ['showall'] ) ? ( int ) $_GET ['showall'] : 0;
$showall = isset ( $_POST ['showall'] ) ? ( int ) $_POST ['showall'] : $showall;

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
			
			editcategory ( $clean_cat_id, $clean_cat_pid );
		break;
		case "addcategory" :
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistablecontroller.php";
			$controller = new IcmsPersistableController ( $imfaq_category_handler );
			$controller->storeFromDefaultForm ( _AM_IMFAQ_CATEGORY_CREATED, _AM_IMFAQ_CATEGORY_MODIFIED );
		
		break;
		
		case "del" :
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistablecontroller.php";
			$controller = new IcmsPersistableController ( $imfaq_category_handler );
			$controller->handleObjectDeletion ();
		
		break;
		
		case "changedField" :
		    foreach ($_POST['ImfaqCategory_objects'] as $k=>$v){
		       $changed = false;
		       $obj = $imfaq_category_handler->get($v);
		       if ($obj->getVar('cat_status','e') != $_POST['cat_status'][$k]){
		           $obj->setVar('cat_status',intval($_POST['cat_status'][$k]));
		           $changed = true;
		       }
		       if ($obj->getVar('cat_weight','e') != $_POST['cat_weight'][$k]){
		           $obj->setVar('cat_weight',intval($_POST['cat_weight'][$k]));
		           $changed = true;
		       }
		       if ($changed){
		           $imfaq_category_handler->insert($obj);
		       }
		    }
		    if ($clean_cat_pid){
		    	$redir = '?cat_pid='.$clean_cat_pid;
		    }
		    redirect_header('category.php'.$redir,2,_AM_IMFAQ_CATEGORY_MODIFIED);
		
		break;
		case "showall" :
			$showall = 1;
		default :
			
			icms_cp_header ();
			
			$icmsModule->displayAdminMenu ( 2, _AM_IMFAQ_CATEGORYS );
			
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistabletable.php";
			
			$criteria = new CriteriaCompo ( );
			$criteria->add ( new Criteria ( 'cat_pid', $clean_cat_pid ) );
			
			if ($showall){
				$criteria = null;
			}
			
			$objectTable = new IcmsPersistableTable ( $imfaq_category_handler, $criteria );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'cat_title', 'left', '20%' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'cat_description' ) );
			if (!$showall){
				$objectTable->addColumn ( new IcmsPersistableColumn ( 'cat_subs', 'center', 80 ) );
			}
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'cat_weight', 'center', 80, 'getCategory_weightControl' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'cat_status', 'center', 80, 'getCategory_statusControl' ) );
			
			$objectTable->addIntroButton ( 'addcategory', 'category.php?op=mod'.($clean_cat_pid?'&amp;cat_pid='.$clean_cat_pid:''), _AM_IMFAQ_CATEGORY_CREATE );
				
			$objectTable->addActionButton ( (!$showall?'showall':''), false, ($showall?'Group Categories':'Ungroup Categories') );
			$objectTable->addActionButton ( 'changedField', false, _SUBMIT );
			
			$objectTable->addQuickSearch ( array ('cat_title', 'cat_description' ) );
			
			$objectTable->addFilter ( 'cat_status', 'getCategory_statusArray' );
			
			$icmsAdminTpl->assign ( 'imfaq_category_breadcrumb', $imfaq_category_handler->getBreadcrumbForPid ( $clean_cat_pid ) );			
			$icmsAdminTpl->assign ( 'imfaq_category_table', $objectTable->fetch () );
			$icmsAdminTpl->display ( 'db:imfaq_admin_category.html' );
		break;
	}
	icms_cp_footer ();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */
?>