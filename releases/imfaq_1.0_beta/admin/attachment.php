<?php
/**
 * Admin page to manage attachments
 *
 * List, add, edit and delete attachment objects
 *
 * @copyright	INBOX International
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
 * @package		imfaq
 * @version		$Id$
 */

include_once ("admin_header.php");

$imfaq_attachment_handler = icms_getModuleHandler ( 'attachment' );
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('addattachment', 'del', 'select_plugin', 'list_module_items', 'remove', 'addattachments', 'sort_attachments', 'show_hide_attachments', '' );

if (isset ( $_GET ['op'] ))
	$clean_op = htmlentities ( $_GET ['op'] );
if (isset ( $_POST ['op'] ))
	$clean_op = htmlentities ( $_POST ['op'] );

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_attach_id = isset ( $_GET ['attach_id'] ) ? ( int ) $_GET ['attach_id'] : 0;
$clean_attach_id = isset ( $_POST ['attach_id'] ) ? ( int ) $_POST ['attach_id'] : $clean_attach_id;
$clean_attach_fid = isset ( $_GET ['attach_fid'] ) ? ( int ) $_GET ['attach_fid'] : 0;
$clean_attach_fid = isset ( $_POST ['attach_fid'] ) ? ( int ) $_POST ['attach_fid'] : $clean_attach_fid;

/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
 */
if (in_array ( $clean_op, $valid_op, true )) {
	switch ($clean_op) {
		case "addattachments" :
			// the logger needs to be disabled in an AJAX request
			$xoopsLogger->disableLogger ();
			
			$attach_module = isset ( $_GET ['attach_module'] ) ? $_GET ['attach_module'] : '';
			$attach_module = isset ( $_POST ['attach_module'] ) ? $_POST ['attach_module'] : $attach_module;
			$attach_itemid = isset ( $_GET ['attach_itemid'] ) ? $_GET ['attach_itemid'] : '';
			$attach_itemid = isset ( $_POST ['attach_itemid'] ) ? $_POST ['attach_itemid'] : $attach_itemid;

			$criteria = new CriteriaCompo ( new Criteria ( 'attach_fid', $clean_attach_fid ) );
			$criteria->setSort ( 'attach_weight' );
			$criteria->setOrder ( 'ASC' );
			$count = $imfaq_attachment_handler->getCount ( $criteria );
			
			$attachmentObj = $imfaq_attachment_handler->create ();
			$attachmentObj->setVar ( 'attach_fid', $clean_attach_fid );
			$attachmentObj->setVar ( 'attach_module', $attach_module );
			$attachmentObj->setVar ( 'attach_itemid', $attach_itemid );
			$attachmentObj->setVar ( 'attach_weight', $count );
			$attachmentObj->setVar ( 'attach_status', 1 );
			$imfaq_attachment_handler->insert ( $attachmentObj, true );
			
			$attachments = $imfaq_attachment_handler->getObjects ( $criteria, true, false );
			$ids = array_keys ( $attachments );
			
			$ret = array ();
			foreach ( $attachments as $id => $attachment ) {
				$ret [$attachment ['attach_itemid']] ['attach_id'] = $id;
				$ret [$attachment ['attach_itemid']] ['attach_title'] = $attachment ['attach_title'];
				$ret [$attachment ['attach_itemid']] ['attach_url'] = $attachment ['attach_url'];
				$ret [$attachment ['attach_itemid']] ['attach_status'] = $attachment ['attach_status'];
			}
			
			$ret ['ids'] = implode ( "|", $ids );
			
			echo php_json_encode ( $ret );
			
			exit ();
			break;
		
		case "sort_attachments" :
			// the logger needs to be disabled in an AJAX request
			$xoopsLogger->disableLogger ();
			
			$order = $_GET ['attachment'];
			
			foreach ( $order as $k => $v ) {
				$attachmentObj = $imfaq_attachment_handler->get ( $v );
				$attachmentObj->setVar ( 'attach_weight', $k );
				$imfaq_attachment_handler->insert ( $attachmentObj, true );
			}
			
			$criteria = new CriteriaCompo ( new Criteria ( 'attach_fid', $clean_attach_fid ) );
			$criteria->setSort ( 'attach_weight' );
			$criteria->setOrder ( 'ASC' );
			$attachments = $imfaq_attachment_handler->getObjects ( $criteria, true, false );
			$ids = array_keys ( $attachments );
			
			$ret = $attach_ids = array ();
			foreach ( $attachments as $id => $attachment ) {
				$ret [$attachment ['attach_itemid']] ['attach_id'] = $id;
				$ret [$attachment ['attach_itemid']] ['attach_title'] = $attachment ['attach_title'];
				$ret [$attachment ['attach_itemid']] ['attach_url'] = $attachment ['attach_url'];
				$ret [$attachment ['attach_itemid']] ['attach_status'] = $attachment ['attach_status'];
				$attach_ids [$id] = $attachment ['attach_itemid'];
			}
			
			$ret ['ids'] = implode ( "|", $ids );
			$ret ['attach_ids'] = $attach_ids;
			
			echo php_json_encode ( $ret );
			
			exit ();
			
			break;
		
		case "show_hide_attachments" :
			// the logger needs to be disabled in an AJAX request
			$xoopsLogger->disableLogger ();
			
			$attachmentObj = $imfaq_attachment_handler->get ( $clean_attach_id );
			$sts = $attachmentObj->getVar ( 'attach_status', 'e') == 1?0:1;
			$attachmentObj->setVar ( 'attach_status', $sts );
			$imfaq_attachment_handler->insert ( $attachmentObj, true );
			
			$criteria = new CriteriaCompo ( new Criteria ( 'attach_fid', $clean_attach_fid ) );
			$criteria->setSort ( 'attach_weight' );
			$criteria->setOrder ( 'ASC' );
			$attachments = $imfaq_attachment_handler->getObjects ( $criteria, true, false );
			$ids = array_keys ( $attachments );
			
			$ret = $attach_ids = array ();
			foreach ( $attachments as $id => $attachment ) {
				$ret [$attachment ['attach_itemid']] ['attach_id'] = $id;
				$ret [$attachment ['attach_itemid']] ['attach_title'] = $attachment ['attach_title'];
				$ret [$attachment ['attach_itemid']] ['attach_url'] = $attachment ['attach_url'];
				$ret [$attachment ['attach_itemid']] ['attach_status'] = $attachment ['attach_status'];
				$attach_ids [$id] = $attachment ['attach_itemid'];
			}
			
			$ret ['ids'] = implode ( "|", $ids );
			$ret ['attach_ids'] = $attach_ids;
			
			echo php_json_encode ( $ret );
			
			exit ();
			
			break;
		
		case "del" :
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistablecontroller.php";
			$controller = new IcmsPersistableController ( $imfaq_attachment_handler );
			$controller->handleObjectDeletion ();
			
			break;
		
		case "remove" :
			// the logger needs to be disabled in an AJAX request
			$xoopsLogger->disableLogger ();
			$attachmentObj = $imfaq_attachment_handler->get ( $clean_attach_id );
			if ($imfaq_attachment_handler->delete ( $attachmentObj, true )) {
				echo 1;
			} else {
				echo 0;
			}
			exit ();
			break;
		
		case 'select_plugin' :
			// the logger needs to be disabled in an AJAX request
			$xoopsLogger->disableLogger ();
			
			include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
			$control = new XoopsFormSelect ( '', 'attach_module' );
			$attachment_pluginsArray = $imfaq_attachment_handler->getModuleList ();
			$control->addOptionArray ( $attachment_pluginsArray );
			$control->setExtra ( 'onchange="add_module_list(this.value,0,\'\')"' );
			echo '<h2 style="margin-top:2px;">' . _CO_IMFAQ_ATTACHMENT_SEL_MODULE;
			echo $control->render () . '</h2>';
			
			exit ();
			break;
		
		case 'list_module_items' :
			// the logger needs to be disabled in an AJAX request
			$xoopsLogger->disableLogger ();
			
			$modname = isset ( $_GET ['module'] ) ? $_GET ['module'] : '';
			$modname = isset ( $_POST ['module'] ) ? $_POST ['module'] : $modname;
			
			$start = isset ( $_GET ['start'] ) ? ( int ) $_GET ['start'] : 0;
			$start = isset ( $_POST ['start'] ) ? ( int ) $_POST ['start'] : $start;
			
			$query = isset ( $_GET ['query'] ) ? $_GET ['query'] : '';
			$query = isset ( $_POST ['query'] ) ? $_POST ['query'] : $query;
			
			if (empty ( $modname ) || ! file_exists ( IMFAQ_ROOT_PATH . 'plugins/' . $modname . '.php' )) {
				echo '<h2 style="text-align:center;">Can\'t find the Plugin</h2>';
				exit ();
			}
			
			include_once IMFAQ_ROOT_PATH . 'plugins/' . $modname . '.php';
			
			$showItemsTable = 'imfaq_'.$modname . '_showItemsTable';
			
			if (! function_exists ( $showItemsTable )) {
				echo '<h2 style="text-align:center;">Can\'t find the Plugin</h2>';
				exit ();
			}
			
			$attachment_statusArray = $imfaq_attachment_handler->getModuleList ();
			
			echo '<h2 style="text-align:center;">' . sprintf ( _CO_IMFAQ_ATTACHMENT_AVALIABLE_ITEMS, $attachment_statusArray [$modname] ) . '</h2>';
			echo '<p>' . _CO_IMFAQ_ATTACHMENT_AVALIABLE_ITEMS_DSC . '</p>';
			
			echo $showItemsTable ( $start, $query );
			
			echo '<script>
					jQuery(document).ready(function() {
						jQuery( "#imfaq_addattachments_container" ).dialog( "option", "buttons", { "' . _AM_IMFAQ_ATTACH . '": function() { attach_items("' . $modname . '"); }, "' . _AM_IMFAQ_CANCEL . '": function() { jQuery(this).dialog("close"); } } );
						
						jQuery(\'#imfaq_addattachments_module_list a\').bind(\'click\',function () {
							jQuery(this).attr("target","_blank");
						});
					    jQuery(\'#pagenav a\').bind(\'click\',function () {
							getPagenavClick(jQuery(this),"' . $modname . '",jQuery(\'#imfaq_addattachments_module_list #query\').val());
							return false;
						});
						
						jQuery(\'#imfaq_addattachments_module_list #query\').focus();
						jQuery(\'#imfaq_addattachments_module_list #query_btn\').click(function(){
							add_module_list("' . $modname . '","' . $start . '",jQuery(\'#imfaq_addattachments_module_list #query\').val());
						});
					});
				  </script>';
			
			exit ();
			break;
	}
	icms_cp_footer ();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */
?>