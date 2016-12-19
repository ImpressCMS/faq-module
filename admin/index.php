<?php
/**
* Admin page to manage faqs
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

include_once ("admin_header.php");

$faq_faq_handler = icms_getModuleHandler ( 'faq' );
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('view', '' );

if (isset ( $_GET ['op'] ))
	$clean_op = htmlentities ( $_GET ['op'] );
if (isset ( $_POST ['op'] ))
	$clean_op = htmlentities ( $_POST ['op'] );

/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
 */
if (in_array ( $clean_op, $valid_op, true )) {
	switch ( $clean_op) {
		default :
			
			icms_cp_header ();
			
			$icmsModule->displayAdminMenu ( 0, _AM_FAQ_FAQS );
				
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistabletable.php";

			$icmsAdminTpl->assign ( 'faq_admin_index', true );
			
			/**
			 * User's submitted FAQs
			 */
			$criteria = new CriteriaCompo(new Criteria('faq_status',FAQ_FAQ_STATUS_PENDING));
			$criteria->add(new Criteria('faq_answer','[^\w\.\s][^0-9]','REGEXP'));
			
  			$objectTable = new IcmsPersistableTable ( $faq_faq_handler, $criteria );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_cid', _LEFT, 200 ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_question',false,false,'faq_question' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_published_date', _CENTER, 150 ) );
			
			$objectTable->addFilter ( 'faq_uid', 'getPostersArray' );
			$objectTable->addFilter ( 'faq_status', 'getFaq_statusArray' );
			$objectTable->addFilter ( 'faq_cid', 'getFaq_categoriesArray' );
			
			$objectTable->setDefaultSort('faq_published_date');
			$objectTable->setDefaultOrder('DESC');
			
			$objectTable->addHeader(_CO_FAQ_SUBMITTED_FAQS);
			
			$icmsAdminTpl->assign ( 'faq_submitted_faqs_table', $objectTable->fetch () );
			

			/**
			 * User's requested FAQs
			 */
			$criteria = new CriteriaCompo(new Criteria('faq_status',FAQ_FAQ_STATUS_PENDING));
			$criteria->add(new Criteria('faq_answer','[^\w\.\s][^0-9]','NOT REGEXP'));
			
  			$objectTable = new IcmsPersistableTable ( $faq_faq_handler, $criteria );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_cid', _LEFT, 200 ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_question',false,false,'faq_question' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_published_date', _CENTER, 150 ) );
			
			$objectTable->addFilter ( 'faq_uid', 'getPostersArray' );
			$objectTable->addFilter ( 'faq_status', 'getFaq_statusArray' );
			$objectTable->addFilter ( 'faq_cid', 'getFaq_categoriesArray' );
			
			$objectTable->setDefaultSort('faq_published_date');
			$objectTable->setDefaultOrder('DESC');
			
			$objectTable->addHeader(_CO_FAQ_REQUESTED_FAQS);
			
			$icmsAdminTpl->assign ( 'faq_requested_faqs_table', $objectTable->fetch () );
			
			$icmsAdminTpl->display ( 'db:faq_admin_faq.html' );
		break;
	}
	icms_cp_footer ();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */
?>