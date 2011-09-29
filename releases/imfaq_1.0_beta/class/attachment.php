<?php

/**
* Classes responsible for managing imFAQ attachment objects
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

if (! defined ( "ICMS_ROOT_PATH" ))
	die ( "ICMS root path not defined" );
	
// including the IcmsPersistabelSeoObject
include_once ICMS_ROOT_PATH . '/kernel/icmspersistableseoobject.php';
include_once (ICMS_ROOT_PATH . '/modules/imfaq/include/functions.php');
include_once (ICMS_ROOT_PATH . '/modules/imfaq/include/common.php');

/**
 * Attachment status definitions
 */
define ( 'IMFAQ_ATTACHMENT_STATUS_ACTIVE', 1 );
define ( 'IMFAQ_ATTACHMENT_STATUS_INACTIVE', 2 );

class ImfaqAttachment extends IcmsPersistableObject {
	
	/**
	 * Constructor
	 *
	 * @param object $handler ImfaqPostHandler object
	 */
	public function __construct(& $handler) {
		global $icmsConfig;
		
		$this->IcmsPersistableObject ( $handler );
		
		$this->quickInitVar ( 'attach_id', XOBJ_DTYPE_INT, true );
		$this->quickInitVar ( 'attach_fid', XOBJ_DTYPE_INT, false );
		$this->quickInitVar ( 'attach_module', XOBJ_DTYPE_TXTBOX, true );
		$this->quickInitVar ( 'attach_itemid', XOBJ_DTYPE_TXTBOX, true );
		$this->quickInitVar ( 'attach_weight', XOBJ_DTYPE_INT, false, false, false, 0 );
		$this->quickInitVar ( 'attach_status', XOBJ_DTYPE_INT, true );
		
		$this->initNonPersistableVar ( 'attach_title', XOBJ_DTYPE_TXTBOX );
		$this->initNonPersistableVar ( 'attach_link', XOBJ_DTYPE_TXTBOX );
		$this->initNonPersistableVar ( 'attach_url', XOBJ_DTYPE_TXTBOX );
		
		$this->setControl ( 'attach_status', array ('itemHandler' => 'attachment', 'method' => 'getAttachment_statusArray', 'module' => 'imfaq' ) );
		$this->setControl ( 'attach_fid', array ('itemHandler' => 'attachment', 'method' => 'getFaqList', 'module' => 'imfaq' ) );
		$this->setControl ( 'attach_module', array ('itemHandler' => 'attachment', 'method' => 'getModuleList', 'module' => 'imfaq', 'onSelect' => 'submit' ) );
	}
	
	/**
	 * Overriding the IcmsPersistableObject::getVar method to assign a custom method on some
	 * specific fields to handle the value before returning it
	 *
	 * @param str $key key of the field
	 * @param str $format format that is requested
	 * @return mixed value of the field that is requested
	 */
	function getVar($key, $format = 's') {
		if ($format == 's' && in_array ( $key, array ('attach_title', 'attach_link', 'attach_url', 'attach_module' ) )) {
			return call_user_func ( array ($this, $key ) );
		}
		return parent::getVar ( $key, $format );
	}
	
	function attach_title() {
		$module = $this->getVar ( 'attach_module', 'e' );
		$itemid = $this->getVar ( 'attach_itemid', 'e' );
		
		if (empty ( $module ) || ! file_exists ( IMFAQ_ROOT_PATH . 'plugins/' . $module . '.php' )) {
			return false;
		}
		
		include_once IMFAQ_ROOT_PATH . 'plugins/' . $module . '.php';
		
		$getItemTitle = 'imfaq_'.$module . '_getItemTitle';
		
		if (! function_exists ( $getItemTitle )) {
			return false;
		}
		
		return $getItemTitle($itemid);
	}
	
	function attach_link() {
		$ret = '<a href="'.$this->attach_url().'" target="_blank">'.$this->attach_title().'</a>';
		
		return $ret;
	}
	
	function attach_url() {
		$module = $this->getVar ( 'attach_module', 'e' );
		$itemid = $this->getVar ( 'attach_itemid', 'e' );
		
		if (empty ( $module ) || ! file_exists ( IMFAQ_ROOT_PATH . 'plugins/' . $module . '.php' )) {
			return false;
		}
		
		include_once IMFAQ_ROOT_PATH . 'plugins/' . $module . '.php';
		
		$getItemUrl = 'imfaq_'.$module . '_getItemUrl';
		
		if (! function_exists ( $getItemUrl )) {
			return false;
		}
		
		return $getItemUrl($itemid);
	}
	
	function attach_module() {
		$module = $this->getVar ( 'attach_module', 'e' );	
	
		$modules = $this->handler->getModuleList();
		
		return $modules[$module]; 
	}
	
	function getAttachment_weightControl() {
		include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
		$control = new XoopsFormText ( '', 'attach_weight[]', 5, 255, $this->getVar ( 'attach_weight', 'e' ) );
		$control->setExtra ( 'style="text-align:center;"' );
		
		return $control->render ();
	}
	
	function getAttachment_statusControl() {
		include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
		$control = new XoopsFormSelect ( '', 'attach_status[]', $this->getVar ( 'attach_status', 'e' ) );
		$attachment_statusArray = $this->handler->getAttachment_statusArray ();
		$control->addOptionArray ( $attachment_statusArray );
		
		return $control->render ();
	}
	
	/**
	 * Check is user has access to view this attachment
	 *
	 * User will be able to view the attachment if
	 *	- the status of the attachment is Published (here AND on the source module) OR
	 *	- he is an admin OR
	 *  - he is the poster of this faq
	 *
	 * @return bool true if user can view this faq, false if not
	 */
	function accessGranted() {
		global $xoopsUser;
		
		$gperm_handler = & xoops_gethandler ( 'groupperm' );
		$groups = is_object ( $xoopsUser ) ? $xoopsUser->getGroups () : array (XOOPS_GROUP_ANONYMOUS );
		
		$module_handler = xoops_gethandler ( 'module' );
		$module = $module_handler->getByDirname ( 'imfaq' );
		
		$agroups = $gperm_handler->getGroupIds ( 'module_admin', $module->mid () );
		$allowed_groups = array_intersect ( $groups, $agroups );
		
		$module = $this->getVar ( 'attach_module', 'e' );
		$itemid = $this->getVar ( 'attach_itemid', 'e' );
		
		if (empty ( $module ) || ! file_exists ( IMFAQ_ROOT_PATH . 'plugins/' . $module . '.php' )) {
			return false;
		}
		
		include_once IMFAQ_ROOT_PATH . 'plugins/' . $module . '.php';
		
		$accessGranted = 'imfaq_'.$module . '_accessGranted';
		
		if (! function_exists ( $accessGranted )) {
			return false;
		}
		
		$viewperm = $accessGranted($itemid) && ($this->getVar ( 'attach_status', 'e' ) == IMFAQ_ATTACHMENT_STATUS_ACTIVE);
		
		if ($viewperm) {
			return true;
		}
		
		if ($viewperm && count ( $allowed_groups ) > 0) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Overridding IcmsPersistable::toArray() method to add a few info
	 *
	 * @return array of attachment info
	 */
	function toArray() {
		$ret = parent::toArray ();
		
		$ret ['editItemLink'] = $this->getEditItemLink ( false, true, false );
		$ret ['deleteItemLink'] = $this->getDeleteItemLink ( false, true, false );
		$ret ['itemLink'] = $this->getItemLink ();
		$ret ['attach_title'] = $this->attach_title ();
		$ret ['attach_url'] = $this->attach_url ();
		$ret ['accessGranted'] = $this->accessGranted ();
		
		return $ret;
	}
}
class ImfaqAttachmentHandler extends IcmsPersistableObjectHandler {
	
	/**
	 * @public array of status
	 */
	public $_attach_statusArray = array ();
	
	/**
	 * Constructor
	 */
	public function __construct(& $db) {
		$this->IcmsPersistableObjectHandler ( $db, 'attachment', 'attach_id', 'attach_fid', false, 'imfaq' );
	}
	
	/**
	 * Retreive the possible status of a attachment object
	 *
	 * @return array of status
	 */
	function getAttachment_statusArray() {
		if (! $this->_attach_statusArray) {
			$this->_attach_statusArray [IMFAQ_ATTACHMENT_STATUS_ACTIVE] = _CO_IMFAQ_ATTACHMENT_STATUS_ACTIVE;
			$this->_attach_statusArray [IMFAQ_ATTACHMENT_STATUS_INACTIVE] = _CO_IMFAQ_ATTACHMENT_STATUS_INACTIVE;
		}
		return $this->_attach_statusArray;
	}
	
	function getFaqList($faq_id = false, $showNull = true) {
		
		$imfaq_faq_handler = icms_getModuleHandler ( 'faq', 'imfaq' );
		$faqs = & $imfaq_faq_handler->getFaqs ( false, false, false, $faq_id, false, 'faq_menutitle', 'ASC' );
		
		$ret = array ();
		if ($showNull) {
			$ret [0] = '-----------------------';
		}
		foreach ( array_keys ( $faqs ) as $i ) {
			$ret [$i] = $faqs [$i] ['faq_menutitle'];
		}
		
		return $ret;
	}
	
	/**
	 * Create the criteria that will be used by getAttachments and getAttachmentsCount
	 *
	 * @param int $start to which record to start
	 * @param int $limit limit of attachments to return
	 * @param int $attach_id ID of a single attachment to retrieve
	 * @param int $attach_pid ID of a single parent attachment to retrieve
	 * @return CriteriaCompo $criteria
	 */
	function getAttachmentsCriteria($start = 0, $limit = 0, $attach_id = false, $attach_fid = false, $order = 'attach_weight', $sort = 'ASC') {
		global $xoopsUser;
		
		$criteria = new CriteriaCompo ();
		if ($start) {
			$criteria->setStart ( $start );
		}
		if ($limit) {
			$criteria->setLimit ( intval ( $limit ) );
		}
		$criteria->setSort ( $order );
		$criteria->setOrder ( $sort );
		
		$criteria->add ( new Criteria ( 'attach_status', IMFAQ_ATTACHMENT_STATUS_ACTIVE ) );
		
		if ($attach_id) {
			$criteria->add ( new Criteria ( 'attach_id', $attach_id ) );
		}
		
		if ($attach_fid !== false) {
			$criteria->add ( new Criteria ( 'attach_fid', $attach_fid ) );
		}
		
		return $criteria;
	}
	
	/**
	 * Get single attachment object
	 *
	 * @param int $attach_id
	 * @return object Attachment object
	 */
	function getAttachment($attach_id) {
		$ret = $this->getAttachments ( 0, 0, $attach_id );
		return isset ( $ret [$attach_id] ) ? $ret [$attach_id] : false;
	}
	
	/**
	 * Get categories as array, ordered by attach_published_date DESC
	 *
	 * @param int $start to which record to start
	 * @param int $limit limit of attachments to return
	 * @param int $attach_id ID of a single attachment to retrieve
	 * @param int $attach_pid ID of a single parent attachment to retrieve
	 * 
	 * @return array of contents
	 */
	function getAttachments($start = 0, $limit = 0, $attach_id = false, $attach_fid = false, $order = 'attach_weight', $sort = 'ASC') {
		$criteria = $this->getAttachmentsCriteria ( $start, $limit, $attach_id, $attach_fid, $order, $sort );
		$attachments = $this->getObjects ( $criteria, true, false );
		$ret = array ();
		foreach ( $attachments as $attachment ) {
			if ($attachment['accessGranted']){
				$ret [$attachment ['attach_id']] = $attachment;
			}
		}
		return $ret;
	}
	
	function getModuleList($showNull = true) {
		include_once ICMS_ROOT_PATH . '/class/xoopslists.php';
		
		$files = IcmsLists::getFileListAsArray ( IMFAQ_ROOT_PATH . 'plugins/' );
		$mhandler = xoops_gethandler ( 'module' );
		
		$ret = array ();
		if ($showNull){
			$ret ['--'] = '-----------------------';
		}
		
		foreach ( $files as $file ) {
			$file = substr ( $file, 0, - 4 );
			$module = $mhandler->getByDirName ( $file );
			if (! is_object ( $module ) || ! $module->getVar ( 'isactive' )) {
				continue;
			}
			$ret [$file] = $module->name ();
		}
		asort ( $ret );
		
		return $ret;
	}
}
?>