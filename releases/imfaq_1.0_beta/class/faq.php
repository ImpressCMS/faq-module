<?php

/**
* Classes responsible for managing imFAQ faq objects
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

/**
 * Faq status definitions
 */
define ( 'IMFAQ_FAQ_STATUS_PUBLISHED', 1 );
define ( 'IMFAQ_FAQ_STATUS_PENDING', 2 );
define ( 'IMFAQ_FAQ_STATUS_REJECTED', 3 );
define ( 'IMFAQ_FAQ_STATUS_OFFLINE', 4 );

class ImfaqFaq extends IcmsPersistableSeoObject {
	
	private $poster_info = false;
	public $updating_counter = false;
	public $original_status = false;
	
	/**
	 * Constructor
	 *
	 * @param object $handler ImfaqPostHandler object
	 */
	public function __construct(& $handler) {
		global $icmsConfig;
		
		$this->IcmsPersistableObject ( $handler );
		
		$this->quickInitVar ( 'faq_id', XOBJ_DTYPE_INT, true );
		$this->quickInitVar ( 'faq_uid', XOBJ_DTYPE_INT, true );
		$this->quickInitVar ( 'faq_cid', XOBJ_DTYPE_INT, true );
		$this->quickInitVar ( 'faq_menutitle', XOBJ_DTYPE_TXTBOX, false );
		$this->quickInitVar ( 'faq_question', XOBJ_DTYPE_TXTAREA, false );
		$this->quickInitVar ( 'faq_answer', XOBJ_DTYPE_TXTAREA, false );
		$this->quickInitVar ( 'faq_diduno', XOBJ_DTYPE_TXTBOX, false );
		$this->quickInitVar ( 'faq_cancomment', XOBJ_DTYPE_INT, false, false, false, 1 );
		$this->quickInitVar ( 'faq_weight', XOBJ_DTYPE_INT, false, false, false, 0 );
		$this->quickInitVar ( 'faq_status', XOBJ_DTYPE_INT, true );
		
		$this->quickInitVar ( 'faq_published_date', XOBJ_DTYPE_LTIME, true, false, false, time () );
		$this->hideFieldFromForm ( 'faq_published_date' );
		
		$this->quickInitVar ( 'faq_comments', XOBJ_DTYPE_INT );
		$this->hideFieldFromForm ( 'faq_comments' );
		$this->hideFieldFromSingleView ( 'faq_comments' );
		
		$this->quickInitVar ( 'faq_notification_sent', XOBJ_DTYPE_INT );
		$this->hideFieldFromForm ( 'faq_notification_sent' );
		$this->hideFieldFromSingleView ( 'faq_notification_sent' );
		
		$this->initCommonVar ( 'counter', false );
		$this->initCommonVar ( 'dohtml', false, true );
		$this->initCommonVar ( 'dobr', false, true );
		$this->initCommonVar ( 'doimage', false, true );
		$this->initCommonVar ( 'dosmiley', false, true );
		$this->initCommonVar ( 'doxcode', false, true );
		
		$this->initNonPersistableVar ( 'faq_attachments', XOBJ_DTYPE_TXTBOX, false, false, false, false, true );
		$this->setControl ( 'faq_attachments', 'addattachment' );
		
		$this->initNonPersistableVar ( 'faq_notifypub', XOBJ_DTYPE_INT, false, false, false, 1);
		$this->setControl ( 'faq_notifypub', 'yesno' );
		
		$this->setControl ( 'faq_uid', 'user' );
		$this->setControl ( 'faq_diduno', 'textarea' );
		$this->setControl ( 'faq_question', 'dhtmltextarea');
		$this->setControl ( 'faq_answer', 'dhtmltextarea' );
		$this->setControl ( 'faq_status', array ('itemHandler' => 'faq', 'method' => 'getFaq_statusArray', 'module' => 'imfaq' ) );
		$this->setControl ( 'faq_cid', array ('itemHandler' => 'faq', 'method' => 'getFaq_categoriesArray', 'module' => 'imfaq' ) );
		$this->setControl ( 'faq_cancomment', 'yesno' );
		
		
		$this->IcmsPersistableSeoObject ();
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
		if ($format == 's' && in_array ( $key, array ('faq_uid', 'faq_cid', 'faq_question', 'faq_menutitle', 'faq_status', 'faq_attachments' ) )) {
			return call_user_func ( array ($this, $key ) );
		}
		if ($format == 'nh' && in_array ( $key, array ('faq_question' ) )) {
			return call_user_func ( array ($this, $key . '_nohtml' ) );
		}
		return parent::getVar ( $key, $format );
	}
	
	/**
	 * Retrieving the name of the author of the faq, linked to his profile
	 *
	 * @return str name of the author of the faq
	 */
	function faq_uid() {
		return icms_getLinkedUnameFromId ( $this->getVar ( 'faq_uid', 'e' ) );
	}
	
	function faq_cid() {
		$cid = $this->getVar ( 'faq_cid', 'e' );
		$imfaq_category_handler = icms_getModuleHandler ( 'category', 'imfaq' );
		$category = $imfaq_category_handler->get ( $cid );
		
		return $category->getVar ( 'cat_title' );
	}
	
	function faq_question() {
		$ret = $this->getItemLink ( false );
		
		return $ret;
	}
	
	function faq_menutitle (){
		$ret = trim($this->getVar('faq_menutitle','n'));
		
		if (empty($ret)){
			return $this->getVar('faq_question','nh');
		}
		
		return $ret;
	}
	
	function faq_question_nohtml() {
		$ret = strip_tags ( $this->getVar ( 'faq_question', 'n' ) );
		
		return $ret;
	}
	
	function faq_status() {
		$ret = $this->getVar ( 'faq_status', 'e' );
		$faq_statusArray = $this->handler->getFaq_statusArray ();
		return $faq_statusArray [$ret];
	}
	
	function faq_attachments() {
		$imfaq_attachment_handler = icms_getModuleHandler ( 'attachment','imfaq' );
		
		$attachments = $imfaq_attachment_handler->getAttachments ( false, false, false, $this->getVar ( 'faq_id' ) );
		if (count($attachments) <= 0){
			return false;
		}
		$html = '<ul id="uplist">';
		foreach ( $attachments as $attachment ) {
			$html .= '<li><a href="' . $attachment['attach_url'] . '" target="_self">' . $attachment['attach_title'] . '</a></li>';
		}
		$html .= '</ul>';
		
		return $html;
	}
	
	function getFaq_weightControl() {
		include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
		$control = new XoopsFormText ( '', 'faq_weight[]', 5, 255, $this->getVar ( 'faq_weight', 'e' ) );
		$control->setExtra ( 'style="text-align:center;"' );
		
		return $control->render ();
	}
	
	function getFaq_statusControl() {
		include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
		$control = new XoopsFormSelect ( '', 'faq_status[]', $this->getVar ( 'faq_status', 'e' ) );
		$faq_statusArray = $this->handler->getFaq_statusArray ();
		$control->addOptionArray ( $faq_statusArray );
		
		return $control->render ();
	}
	
	function getReads() {
		return $this->getVar ( 'counter' );
	}
	
	function setReads($qtde = null) {
		$t = $this->getVar ( 'counter' );
		if (isset ( $qtde )) {
			$t += $qtde;
		} else {
			$t ++;
		}
		$this->setVar ( 'counter', $t );
	}
	
	function getPreviousFaq($asObject = false) {
		$ret = $this->handler->getPreviousFaq ( $this->getVar ( 'faq_id', 'e' ) );
		
		if (is_object ( $ret )) {
			if (! $asObject) {
				$ret = $ret->toArray ();
			}
		}
		
		return $ret;
	}
	
	function getNextFaq($asObject = false) {
		$ret = $this->handler->getNextFaq ( $this->getVar ( 'faq_id', 'e' ) );
		
		if (is_object ( $ret )) {
			if (! $asObject) {
				$ret = $ret->toArray ();
			}
		}
		
		return $ret;
	}
	
	/**
	 * Get the poster
	 *
	 * @param bool $link with link or not
	 * @return str poster name linked on his module poster page, or simply poster name
	 */
	function getPoster($link = false) {
		if (! $this->poster_info) {
			$member_handler = xoops_getHandler ( 'member' );
			$poster_uid = $this->getVar ( 'faq_uid', 'e' );
			$userObj = $member_handler->getuser ( $poster_uid );
			
			/**
			 * We need to make sure the poster is a valid user object. It is possible the user no longer
			 * exists if, for example, he was previously deleted. In that case, we will return Anonymous
			 */
			if (is_object ( $userObj )) {
				$this->poster_info ['uid'] = $poster_uid;
				$this->poster_info ['uname'] = $userObj->getVar ( 'uname' );
				$this->poster_info ['link'] = '<a href="' . $this->handler->_moduleUrl . 'index.php?uid=' . $this->poster_info ['uid'] . '">' . $this->poster_info ['uname'] . '</a>';
			} else {
				global $xoopsConfig;
				$this->poster_info ['uid'] = 0;
				$this->poster_info ['uname'] = $xoopsConfig ['anonymous'];
			}
		}
		if ($link && $this->poster_info ['uid']) {
			return $this->poster_info ['link'];
		} else {
			return $this->poster_info ['uname'];
		}
	}
	
	/**
	 * Returns the need to br
	 *
	 * @return bool true | false
	 */
	function need_do_br() {
		global $xoopsConfig, $xoopsUser;
		
		$module = icms_getModuleInfo ( 'imfaq' );
		$groups = $xoopsUser->getGroups ();
		
		$editor_default = $xoopsConfig ['editor_default'];
		$gperm_handler = xoops_getHandler ( 'groupperm' );
		if (file_exists ( ICMS_EDITOR_PATH . "/" . $editor_default . "/xoops_version.php" ) && $gperm_handler->checkRight ( 'use_wysiwygeditor', $module->mid (), $groups )) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Retrieve faq info (author and date)
	 *
	 * @return str faq info
	 */
	function getFaqInfo() {
		$ret = sprintf ( _CO_IMFAQ_FAQ_INFO, $this->getPoster ( true ), $this->getVar ( 'faq_published_date' ), $this->getVar ( 'counter' ) );
		return $ret;
	}
	
	/**
	 * Sending the notification related to a faq being published
	 *
	 * @return VOID
	 */
	function sendNotifications($category) {
		$module_handler = xoops_gethandler ( 'module' );
		$module = $module_handler->getByDirname ( 'imfaq' );
		$module_id = $module->getVar ( 'mid' );
		$notification_handler = xoops_gethandler ( 'notification' );
		
		$tags ['MODULE_NAME'] = $module->getVar ( 'name' );
		$tags ['FAQ_TITLE'] = $this->getVar ( 'faq_question' );
		
		switch ($category){
			case 'submitted':
				$tags ['FAQ_REVIEW_URL'] = $this->getEditItemLink ( true );
				$notification_handler->triggerEvent ( 'global_faq', 0, 'submitted', $tags, array ( ), $module_id );
				break;
			case 'approved':
				$tags ['FAQ_URL'] = $this->getItemLink ( true );
				$notification_handler->triggerEvent ( 'faq', $this->id(), 'approved', $tags, array ( ), $module_id );
				break;
			case 'new_faq':
				$tags ['FAQ_URL'] = $this->getItemLink ( true );
				$notification_handler->triggerEvent ( 'global_faq', 0, 'new_faq', $tags, array ( ), $module_id );
				break;
		}
	}
	
	/**
	 * Overridding IcmsPersistable::getItemLink() method to add support for SEO
	 *
	 * @param bool $onlyUrl wether or not to return a simple URL or a full <a> link
	 * @return string user side link to the object
	 */
	function getItemLink($onlyUrl = true, $forprint = false, $title = null) {

		$seoMode = imfaq_getModuleModeSEO ( $this->handler->_moduleName );
		$seoModuleName = imfaq_getModuleNameForSEO ( $this->handler->_moduleName );
		$seoIncludeId = imfaq_getModuleIncludeIdSEO ( $this->handler->_moduleName );

		$imfaq_category_handler = icms_getModuleHandler ( 'category', 'imfaq' );
		
		$categoryObj = $imfaq_category_handler->get ( $this->getVar ( 'faq_cid', 'e' ) );
		
		if (is_object ( $categoryObj )) {
			$category = $categoryObj->getVar ( 'short_url' ) . '/';
		} else {
			$category = '';
		}

		if ($forprint) {
			if ($seoMode == 'rewrite') {
				$ret = XOOPS_URL . '/' . $seoModuleName . '/' . $category . 'print/' . $this->getVar ( 'short_url' ) . '.html';
			} else if ($seoMode == 'pathinfo') {
				$ret = IMFAQ_URL . 'seo.php/' . $seoModuleName . '.' . $this->handler->_itemname . ($seoIncludeId ? '.' . $this->getVar ( $this->handler->keyName ) : '') . '/' . $this->getVar ( 'short_url' ) . '.html';
			} else {
				$ret = $this->handler->_moduleUrl . 'print.php' . "?" . $this->handler->keyName . "=" . $this->getVar ( $this->handler->keyName );
			}
			$ret = "javascript:openWithSelfMain('" . $ret . "','imfaq_print','700','519');";
		} else {
			if ($seoMode == 'rewrite') {
				$ret = XOOPS_URL . '/' . $seoModuleName . '/' . $category . $this->getVar ( 'short_url' ) . '.html';
			} else if ($seoMode == 'pathinfo') {
				$ret = IMFAQ_URL . 'seo.php/' . $seoModuleName . '.' . $this->handler->_itemname . ($seoIncludeId ? '.' . $this->getVar ( $this->handler->keyName ) : '') . '/' . $this->getVar ( 'short_url' ) . '.html';
			} else {
				$ret = $this->handler->_moduleUrl . $this->handler->_page . "?" . $this->handler->keyName . "=" . $this->getVar ( $this->handler->keyName );
			}
		}
		
		if(empty($title)){
			$title = $this->getVar ( $this->handler->identifierName, 'n' );
		}
		
		if (! $onlyUrl) {
			$ret = "<a href='" . $ret . "'>" . $title . "</a>";
		}
		return $ret;
	}
	
	/**
	 * Retrieve faq comment info (number of comments)
	 *
	 * @return str faq comment info
	 */
	function getCommentsInfo() {
		$faq_comments = $this->getVar ( 'faq_comments' );
		if ($faq_comments) {
			return '<a href="' . $this->getItemLink ( true ) . '#comments_container">' . sprintf ( _CO_IMFAQ_FAQ_COMMENTS_INFO, $faq_comments ) . '</a>';
		} else {
			return _CO_IMFAQ_FAQ_NO_COMMENT;
		}
	}
	
	/**
	 * Check is user has access to view this faq
	 *
	 * User will be able to view the faq if
	 *	- the status of the faq is Published OR
	 *	- he is an admin OR
	 * 	  - he is the poster of this faq
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
		$viewperm = $gperm_handler->checkRight ( 'category_read', $this->getVar ( 'faq_cid', 'e' ), $groups, $module->mid () );
		
		if (is_object ( $xoopsUser ) && $xoopsUser->uid () == $this->getVar ( 'faq_uid', 'e' )) {
			return true;
		}
		
		if ($viewperm && $this->getVar ( 'faq_status', 'e' ) == IMFAQ_FAQ_STATUS_PUBLISHED) {
			return true;
		}
		
		if ($viewperm && count ( $allowed_groups ) > 0) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Check to see wether the current user can edit or delete this faq
	 *
	 * @return bool true if he can, false if not
	 */
	function userCanEditAndDelete() {
		global $xoopsUser, $imfaq_isAdmin;
		if (! is_object ( $xoopsUser )) {
			return false;
		}
		if ($imfaq_isAdmin) {
			return true;
		}
		return $this->getVar ( 'faq_uid', 'e' ) == $xoopsUser->uid ();
	}

	/**
	 * Overridding IcmsPersistable::toArray() method to add a few info
	 *
	 * @return array of article info
	 */
	function toArray() {
		$ret = parent::toArray ();
		
		$ret ['faq_title'] = $this->getVar ( 'faq_question', 'n' );
		$ret ['faq_menutitle_link'] = $this->getItemLink ( false, false, $this->getVar('faq_menutitle') );
		$ret ['faq_info'] = $this->getFaqInfo ();
		$ret ['faq_teaser'] = icms_substr ( icms_cleanTags ( $this->getVar ( 'faq_answer' ), array ( ) ), 0, 500 );
		$ret ['faq_answer_forprint'] = $this->getVar ( 'faq_answer','n' );
		$ret ['faq_comment_info'] = $this->getCommentsInfo ();
		$ret ['editItemLink'] = $this->getEditItemLink ( false, true );
		$ret ['deleteItemLink'] = $this->getDeleteItemLink ( false, true );
		$ret ['userCanEditAndDelete'] = $this->userCanEditAndDelete ();
		$ret ['faq_posterid'] = $this->getVar ( 'faq_uid', 'e' );
		$ret ['itemLink'] = $this->getItemLink ( true );
		$ret ['itemUrl'] = $this->getItemLink ( false );
		$ret ['printLink'] = $this->getItemLink ( true, true );
		$ret ['accessgranted'] = $this->accessGranted ();
		$ret ['faq_published_date_int'] = $this->getVar ( 'faq_published_date', 'e' );
		
		return $ret;
	}
}
class ImfaqFaqHandler extends IcmsPersistableObjectHandler {
	
	/**
	 * @public array of status
	 */
	public $_faq_statusArray = array ( );
	
	/**
	 * Constructor
	 */
	public function __construct(& $db) {
		$this->IcmsPersistableObjectHandler ( $db, 'faq', 'faq_id', 'faq_question', 'faq_answer', 'imfaq' );
	}
	
	/**
	 * Retreive the possible status of a faq object
	 *
	 * @return array of status
	 */
	function getFaq_statusArray() {
		if (! $this->_faq_statusArray) {
			$this->_faq_statusArray [IMFAQ_FAQ_STATUS_PUBLISHED] = _CO_IMFAQ_FAQ_STATUS_PUBLISHED;
			$this->_faq_statusArray [IMFAQ_FAQ_STATUS_PENDING] = _CO_IMFAQ_FAQ_STATUS_PENDING;
			$this->_faq_statusArray [IMFAQ_FAQ_STATUS_REJECTED] = _CO_IMFAQ_FAQ_STATUS_REJECTED;
			$this->_faq_statusArray [IMFAQ_FAQ_STATUS_OFFLINE] = _CO_IMFAQ_FAQ_STATUS_OFFLINE;
		}
		return $this->_faq_statusArray;
	}
	
	function getFaq_categoriesArray($permission='category_write', $shownull = false) {
		global $xoopsUser;
		
		$imfaq_category_handler = icms_getModuleHandler ( 'category', 'imfaq' );
		
		$gperm_handler = & xoops_gethandler ( 'groupperm' );
		$groups = is_object ( $xoopsUser ) ? $xoopsUser->getGroups () : array (XOOPS_GROUP_ANONYMOUS );
		
		$categories = $imfaq_category_handler->getCategoryList ( $groups, $permission, null, null, $shownull );
		
		return $categories;
	}
	
	/**
	 * Get a list of users
	 *
	 * @return array list of users
	 */
	function getPostersArray() {
		$member_handler = xoops_getHandler ( 'member' );
		return $member_handler->getUserList ();
	}
	
	/**
	 * Create the criteria that will be used by getFaqs and getFaqsCount
	 *
	 * @param int $start to which record to start
	 * @param int $limit limit of faqs to return
	 * @param int $faq_id ID of a single faq to retrieve
	 * @return CriteriaCompo $criteria
	 */
	function getFaqsCriteria($start = 0, $limit = 0, $faq_cid = false, $faq_id = false, $faq_uid = false, $order = 'faq_published_date', $sort = 'DESC') {
		global $xoopsUser;
		
		$criteria = new CriteriaCompo ( );
		if ($start) {
			$criteria->setStart ( $start );
		}
		if ($limit) {
			$criteria->setLimit ( intval ( $limit ) );
		}
		
		if ($order == 'RAND'){
			$order = 'RAND()';
		}
		
		$criteria->setSort ( $order );
		$criteria->setOrder ( $sort );
		
		$criteria->add ( new Criteria ( 'faq_status', IMFAQ_FAQ_STATUS_PUBLISHED ) );
		
		if ($faq_cid) {
			if (!is_array($faq_cid)){
				$faq_cid = array($faq_cid);
			}
			$criteria->add ( new Criteria ( 'faq_cid', '('.implode(',',$faq_cid).')','IN' ) );
		}
		
		if ($faq_id) {
			$crit = new CriteriaCompo ( new Criteria ( 'short_url', $faq_id, 'LIKE' ) );
			$crit->add ( new Criteria ( 'faq_id', $faq_id ), 'OR' );
			$criteria->add ( $crit );
		}
		
		if ($faq_uid) {
			$criteria->add ( new Criteria ( 'faq_uid', $faq_uid ) );
		}
		
		return $criteria;
	}
	
	/**
	 * Get single faq object
	 *
	 * @param int $faq_id
	 * @return object Faq object
	 */
	function getFaq($faq_id) {
		$ret = $this->getFaqs ( 0, 0, false, $faq_id );
		return isset ( $ret [$faq_id] ) ? $ret [$faq_id] : false;
	}
	
	/**
	 * Get faqs as array, ordered by faq_published_date DESC
	 *
	 * @param int $start to which record to start
	 * @param int $limit limit of faqs to return
	 * @param int $faq_id ID of a single faq to retrieve
	 * 
	 * @return array of contents
	 */
	function getFaqs($start = 0, $limit = 0, $faq_cid = false, $faq_id = false, $faq_uid = false, $order = 'faq_published_date', $sort = 'DESC') {
		$criteria = $this->getFaqsCriteria ( $start, $limit, $faq_cid, $faq_id, $faq_uid, $order, $sort );
		$faqs = $this->getObjects ( $criteria );
		
		$ret = array ( );
		foreach ( $faqs as $faq ) {
			if ($faq->accessGranted ()) {
				$ret [$faq->getVar ( 'faq_id' )] = $faq->toArray ();
			}
		}
		
		return $ret;
	}
	
	/**
	 * Get Faqs requested by the global search feature
	 *
	 * @param array $queryarray array containing the searched keywords
	 * @param bool $andor wether the keywords should be searched with AND or OR
	 * @param int $limit maximum results returned
	 * @param int $offset where to start in the resulting dataset
	 * @param int $userid should we return faqs by specific poster ?
	 * @return array array of faqs
	 */
	function getFaqsForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = new CriteriaCompo();

		$criteria->setStart($offset);
		$criteria->setLimit($limit);

		if ($userid != 0) {
			$criteria->add(new Criteria('faq_uid', $userid));
		}
		if ($queryarray) {
			$criteriaKeywords = new CriteriaCompo();
			for ($i = 0; $i < count($queryarray); $i++) {
				$criteriaKeyword = new CriteriaCompo();
				$criteriaKeyword->add(new Criteria('faq_question', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new Criteria('faq_answer', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new Criteria('faq_diduno', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset ($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		$criteria->add(new Criteria('faq_status', IMFAQ_FAQ_STATUS_PUBLISHED));
		$faqs = $this->getObjects($criteria);
		
		$ret = array ( );
		foreach ( $faqs as $faq ) {
			if ($faq->accessGranted ()) {
				$ret [$faq->getVar ( 'faq_id' )] = $faq;
			}
		}
		
		return $ret;
	}

	
	
	function getFaqsCount($faq_cid = 0) {
		$criteria = $this->getFaqsCriteria ( 0, 0, $faq_cid );
		
		return $this->getCount ( $criteria );
	}
	
	function getPreviousFaq($faq_id) {
		$faqObj = $this->get ( $faq_id );
		
		if (! $faqObj) {
			return false;
		}
		
		$criteria = $this->getFaqsCriteria ( 0, 0, $faqObj->getVar ( 'faq_cid', 'e' ), false, false, 'faq_id', 'ASC' );
		$faqs = $this->getObjects ( $criteria, true );
		
		$faqids = array_keys ( $faqs );
		
		$prev = false;
		
		foreach ( $faqids as $k => $v ) {
			if ($v == $faq_id) {
				$k = $k - 1;
				$prev = isset($faqids [$k])?$faqids [$k]:0;
			}
		}
		
		if ($prev && isset ( $faqs [$prev] )) {
			return $faqs [$prev];
		} else {
			return false;
		}
	}
	
	function getNextFaq($faq_id) {
		$faqObj = $this->get ( $faq_id );
		
		if (! $faqObj) {
			return false;
		}
		
		$criteria = $this->getFaqsCriteria ( 0, 0, $faqObj->getVar ( 'faq_cid', 'e' ), false, false, 'faq_id', 'ASC' );
		$faqs = $this->getObjects ( $criteria, true );
		
		$faqids = array_keys ( $faqs );
		
		$next = false;
		
		foreach ( $faqids as $k => $v ) {
			if ($v == $faq_id) {
				$k = $k + 1;
				$next = isset($faqids [$k])?$faqids [$k]:0;
				break;
			}
		}
		
		if ($next && isset ( $faqs [$next] )) {
			return $faqs [$next];
		} else {
			return false;
		}
	}
	
	/**
	 * Check wether the current user can submit a new faq or not
	 *
	 * @return bool true if he can false if not
	 */
	function userCanSubmit() {
		global $xoopsUser, $imfaq_isAdmin;

		if (! is_object ( $xoopsUser )) {
			return false;
		}
		
		if ($imfaq_isAdmin) {
			return true;
		}

		$gperm_handler = & xoops_gethandler ( 'groupperm' );
		$module_handler = xoops_gethandler ( 'module' );
		$groups = is_object ( $xoopsUser ) ? $xoopsUser->getGroups () : array (XOOPS_GROUP_ANONYMOUS );
		$module = $module_handler->getByDirname ( 'imfaq' );
		$writeperm = $gperm_handler->getItemIds ( 'category_write', $groups, $module->mid () );

		return count ( $writeperm ) > 0;
	}
	
	/**
	 * Update the counter field of the faq object
	 *
	 * @param int $faq_id
	 *
	 * @return VOID
	 */
	function updateCounter($id) {
		global $xoopsUser, $imfaq_isAdmin;
		
		$faqObj = $this->get ( $id );
		if (! is_object ( $faqObj )) {
			return false;
		}
		if (! is_object ( $xoopsUser ) || (! $imfaq_isAdmin && $faqObj->getVar ( 'faq_uid', 'e' ) != $xoopsUser->uid ())) {
			$faqObj->updating_counter = true;
			$faqObj->setVar ( 'counter', $faqObj->getVar ( 'counter', 'n' ) + 1 );
			$this->insert ( $faqObj, true );
		}
		
		return true;
	}
	
	/**
	 * Update number of comments on a faq
	 *
	 * This method is triggered by imfaq_com_update in include/functions.php which is
	 * called by ImpressCMS when updating comments
	 *
	 * @param int $faq_id id of the faq to update
	 * @param int $total_num total number of comments so far in this faq
	 * @return VOID
	 */
	function updateComments($faq_id, $total_num) {
		$faqObj = $this->get ( $faq_id );
		if ($faqObj && ! $faqObj->isNew ()) {
			$faqObj->setVar ( 'faq_comments', $total_num );
			$this->insert ( $faqObj, true );
		}
	}
	
	/**
	 * Overridding IcmsPersistableObjectHandler::insert() method to change some aspects
	 */
    function insert(&$obj, $force = false, $checkObject = true, $debug=false)
    {
    	if ($checkObject != false) {
            if (!is_object($obj)) {
                return false;
            }
            /**
        * @TODO: Change to if (!(class_exists($this->className) && $obj instanceof $this->className)) when going fully PHP5
        */
            if (!is_a($obj, $this->className)) {
            	$obj->setErrors(get_class($obj)." Differs from ".$this->className);
                return false;
            }
            if (!$obj->isDirty()) {
                $obj->setErrors("Not dirty"); //will usually not be outputted as errors are not displayed when the method returns true, but it can be helpful when troubleshooting code - Mith
                return true;
            }
        }

		if ($obj->seoEnabled) {
	        // Auto create meta tags if empty
			$icms_metagen = new IcmsMetagen($obj->getVar ( 'faq_question', 'nh' ), $obj->getVar('meta_keywords'), $obj->summary());

			if (!$obj->getVar('meta_keywords') || !$obj->getVar('meta_description')) {

				if (!$obj->meta_keywords()) {
					$obj->setVar('meta_keywords', $icms_metagen->_keywords);
				}

				if (!$obj->meta_description()) {
					$obj->setVar('meta_description', $icms_metagen->_meta_description);
				}
			}

			// Auto create short_url if empty
			if (!$obj->short_url()) {
   				$obj->setVar('short_url', $icms_metagen->generateSeoTitle($obj->getVar ( 'faq_question', 'nh' ), false));
			}
		}

        $eventResult = $this->executeEvent('beforeSave', $obj);
    	if (!$eventResult) {
        	$obj->setErrors("An error occured during the BeforeSave event");
        	return false;
        }

        if ($obj->isNew()) {
	        $eventResult = $this->executeEvent('beforeInsert', $obj);
	    	if (!$eventResult) {
	        	$obj->setErrors("An error occured during the BeforeInsert event");
	        	return false;
	        }

        }	else {
	        $eventResult = $this->executeEvent('beforeUpdate', $obj);
	    	if (!$eventResult) {
	        	$obj->setErrors("An error occured during the BeforeUpdate event");
	        	return false;
	        }
        }
        if (!$obj->cleanVars()) {
        	$obj->setErrors('Variables were not cleaned properly.');
            return false;
        }
		$fieldsToStoreInDB = array();
        foreach ($obj->cleanVars as $k => $v) {
            if ($obj->vars[$k]['data_type'] == XOBJ_DTYPE_INT) {
                $cleanvars[$k] = intval($v);
            } elseif (is_array($v) ) {
            	$cleanvars[ $k ] = $this->db->quoteString( implode( ',', $v ) );
            } else {
                $cleanvars[$k] = $this->db->quoteString($v);
            }
            if ($obj->vars[$k]['persistent']) {
            	$fieldsToStoreInDB[$k] = $cleanvars[$k];
            }

        }
        if ($obj->isNew()) {
            if (!is_array($this->keyName)) {
                if ($cleanvars[$this->keyName] < 1) {
                    $cleanvars[$this->keyName] = $this->db->genId($this->table.'_'.$this->keyName.'_seq');
                }
            }

            $sql = "INSERT INTO ".$this->table." (".implode(',', array_keys($fieldsToStoreInDB)).") VALUES (".implode(',', array_values($fieldsToStoreInDB)) .")";

        } else {

            $sql = "UPDATE ".$this->table." SET";
            foreach ($fieldsToStoreInDB as $key => $value) {
                if ((!is_array($this->keyName) && $key == $this->keyName) || (is_array($this->keyName) && in_array($key, $this->keyName))) {
                    continue;
                }
                if (isset($notfirst) ) {
                    $sql .= ",";
                }
                $sql .= " ".$key." = ".$value;
                $notfirst = true;
            }
            if (is_array($this->keyName)) {
                $whereclause = "";
                for ($i = 0; $i < count($this->keyName); $i++) {
                    if ($i > 0) {
                        $whereclause .= " AND ";
                    }
                    $whereclause .= $this->keyName[$i]." = ".$obj->getVar($this->keyName[$i]);
                }
            }
            else {
                $whereclause = $this->keyName." = ".$obj->getVar($this->keyName);
            }
            $sql .= " WHERE ".$whereclause;
        }

        if ($debug) {
        	icms_debug($sql);
        }

        if (false != $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }

        if (!$result) {
        	$obj->setErrors($this->db->error());
            return false;
        }

        if ($obj->isNew() && !is_array($this->keyName)) {
            $obj->assignVar($this->keyName, $this->db->getInsertId());
    	}
        $eventResult = $this->executeEvent('afterSave', $obj);
    	if (!$eventResult) {
        	$obj->setErrors("An error occured during the AfterSave event");
        	return false;
        }

        if ($obj->isNew()) {
        	$obj->unsetNew();
	        $eventResult = $this->executeEvent('afterInsert', $obj);
	    	if (!$eventResult) {
	        	$obj->setErrors("An error occured during the AfterInsert event");
	        	return false;
	        }
        } else {
	        $eventResult = $this->executeEvent('afterUpdate', $obj);
	    	if (!$eventResult) {
	        	$obj->setErrors("An error occured during the AfterUpdate event");
	        	return false;
	        }
        }
        return true;
    }
	
	/**
	 * BeforeSave event
	 *
	 * Event automatically triggered by IcmsPersistable Framework before the object is inserted or updated.
	 *
	 * @param object $obj Faq object
	 * @return true
	 */
	function beforeSave(& $obj) {
		if ($obj->updating_counter)
			return true;
		
		$obj->setVar ( 'dobr', $obj->need_do_br () );
		if ($obj->getVar('faq_published_date','e') == 0){
			$obj->setVar ( 'faq_published_date', time() );
		}
		
		$originalObj = $this->get($obj->id());
		$obj->original_status = $originalObj->getVar('faq_status','e');
		unset($originalObj);
		
		return true;
	}
	
	/**
	 * AfterSave event
	 *
	 * Event automatically triggered by IcmsPersistable Framework after the object is inserted or updated
	 *
	 * @param object $obj Content object
	 * @return true
	 */
	function afterSave(& $obj) {
		if ($obj->updating_counter)
			return true;
		
		if ($obj->getVar ( 'faq_status', 'e' ) == IMFAQ_FAQ_STATUS_PENDING && $obj->getVar ( 'faq_notifypub', 'e' )) {
			include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
			$notification_handler = &xoops_gethandler('notification');
			$notification_handler->subscribe('faq', $obj->getVar('faq_id','e'), 'approved', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
			$obj->sendNotifications ('submitted');
		}
			
		if (! $obj->getVar ( 'faq_notification_sent', 'e' ) && $obj->getVar ( 'faq_status', 'e' ) == IMFAQ_FAQ_STATUS_PUBLISHED) {
			$obj->sendNotifications ('approved');
			$obj->sendNotifications ('new_faq');
			$obj->setVar ( 'faq_notification_sent', true );
			$this->insert ( $obj, true );
		}
		
		$imfaq_attachment_handler = icms_getModuleHandler ( 'attachment','imfaq' );
		$attachmentids = explode ( '|', $obj->getVar ( 'faq_attachments', 'e' ) );
		$criteria = new CriteriaCompo ( new Criteria ( 'attach_id', '(' . implode ( ',', $attachmentids ) . ')', 'IN' ) );
		$criteria->add ( new Criteria ( 'attach_fid', $obj->getVar ( 'faq_id' ), '<>' ) );
		$attachments = $imfaq_attachment_handler->getObjects ( $criteria, true, true );
		
		if (count ( $attachments ) > 0) {
			foreach ( $attachments as $attachment ) {
				$attachment->setVar ( 'attach_fid', $obj->getVar ( 'faq_id' ) );
				$imfaq_attachment_handler->insert ( $attachment, true );
			}
		}
		
		return true;
	}
	
	/**
	 * AfterDelete event
	 *
	 * Event automatically triggered by IcmsPersistable Framework after the object is deleted
	 *
	 * @param object $obj Content object
	 * @return true
	 */
	function beforeDelete(& $obj) {
		$imfaq_attachment_handler = icms_getModuleHandler ( 'attachment','imfaq' );
		$criteria = new CriteriaCompo ( new Criteria ( 'attach_fid', $obj->getVar ( 'faq_id' ) ) );
		$attachments = $imfaq_attachment_handler->getObjects ( $criteria, true, true );
		if (count ( $attachments ) > 0) {
			foreach ( $attachments as $attachment ) {
				if (! $imfaq_attachment_handler->delete ( $attachment, true )) {
					return false;
				}
			}
		}
		
		return true;
	}
}
?>