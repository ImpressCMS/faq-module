<?php
/**
* Admin page to manage faqs
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

include_once ("admin_header.php");

$imfaq_faq_handler = icms_getModuleHandler ( 'faq' );
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
			
			$icmsModule->displayAdminMenu ( 0, _AM_IMFAQ_FAQS );
				
			include_once ICMS_ROOT_PATH . "/kernel/icmspersistabletable.php";

			$icmsAdminTpl->assign ( 'imfaq_admin_index', true );
			
			/**
			 * User's submitted FAQs
			 */
			$criteria = new CriteriaCompo(new Criteria('faq_status',IMFAQ_FAQ_STATUS_PENDING));
			$criteria->add(new Criteria('faq_answer','[^\w\.\s][^0-9]','REGEXP'));
			
  			$objectTable = new IcmsPersistableTable ( $imfaq_faq_handler, $criteria );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_cid', _LEFT, 200 ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_question',false,false,'faq_question' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_published_date', _CENTER, 150 ) );
			
			$objectTable->addFilter ( 'faq_uid', 'getPostersArray' );
			$objectTable->addFilter ( 'faq_status', 'getFaq_statusArray' );
			$objectTable->addFilter ( 'faq_cid', 'getFaq_categoriesArray' );
			
			$objectTable->setDefaultSort('faq_published_date');
			$objectTable->setDefaultOrder('DESC');
			
			$objectTable->addHeader(_CO_IMFAQ_SUBMITTED_FAQS);
			
			$icmsAdminTpl->assign ( 'imfaq_submitted_faqs_table', $objectTable->fetch () );
			

			/**
			 * User's requested FAQs
			 */
			$criteria = new CriteriaCompo(new Criteria('faq_status',IMFAQ_FAQ_STATUS_PENDING));
			$criteria->add(new Criteria('faq_answer','[^\w\.\s][^0-9]','NOT REGEXP'));
			
  			$objectTable = new IcmsPersistableTable ( $imfaq_faq_handler, $criteria );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_cid', _LEFT, 200 ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_question',false,false,'faq_question' ) );
			$objectTable->addColumn ( new IcmsPersistableColumn ( 'faq_published_date', _CENTER, 150 ) );
			
			$objectTable->addFilter ( 'faq_uid', 'getPostersArray' );
			$objectTable->addFilter ( 'faq_status', 'getFaq_statusArray' );
			$objectTable->addFilter ( 'faq_cid', 'getFaq_categoriesArray' );
			
			$objectTable->setDefaultSort('faq_published_date');
			$objectTable->setDefaultOrder('DESC');
			
			$objectTable->addHeader(_CO_IMFAQ_REQUESTED_FAQS);
			
			$icmsAdminTpl->assign ( 'imfaq_requested_faqs_table', $objectTable->fetch () );
			
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