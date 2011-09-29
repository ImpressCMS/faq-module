<?php

/**
 * Classes responsible for managing FAQ category objects
 *
 * @copyright	INBOX International
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
 * @package		faq
 * @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
 */

if (! defined ( "ICMS_ROOT_PATH" ))
	die ( "ICMS root path not defined" );
	
// including the IcmsPersistabelSeoObject
include_once ICMS_ROOT_PATH . '/kernel/icmspersistableseoobject.php';
include_once (ICMS_ROOT_PATH . '/modules/faq/include/functions.php');

/**
 * Category status definitions
 */
define ( 'FAQ_CATEGORY_STATUS_ACTIVE', 1 );
define ( 'FAQ_CATEGORY_STATUS_INACTIVE', 2 );

class FaqCategory extends IcmsPersistableSeoObject {
	
	/**
	 * Constructor
	 *
	 * @param object $handler FaqPostHandler object
	 */
	public function __construct(& $handler) {
		global $icmsConfig;
		
		$this->IcmsPersistableObject ( $handler );
		
		$this->quickInitVar ( 'cat_id', XOBJ_DTYPE_INT, true );
		$this->quickInitVar ( 'cat_title', XOBJ_DTYPE_TXTBOX, true );
		$this->quickInitVar ( 'cat_menutitle', XOBJ_DTYPE_TXTBOX, false );
		$this->quickInitVar ( 'cat_pid', XOBJ_DTYPE_INT, false );
		$this->quickInitVar ( 'cat_summary', XOBJ_DTYPE_TXTAREA, false );
		$this->quickInitVar ( 'cat_description', XOBJ_DTYPE_TXTAREA, false );
		$this->quickInitVar ( 'cat_weight', XOBJ_DTYPE_INT, false, false, false, 0 );
		$this->quickInitVar ( 'cat_status', XOBJ_DTYPE_INT, true );
		
		$this->quickInitVar ( 'cat_published_date', XOBJ_DTYPE_LTIME, true, false, false, time () );
		$this->hideFieldFromForm ( 'cat_published_date' );
		
		$this->initCommonVar ( 'dohtml', false, true );
		$this->initCommonVar ( 'dobr', false, true );
		$this->initCommonVar ( 'doimage', false, true );
		$this->initCommonVar ( 'dosmiley', false, true );
		$this->initCommonVar ( 'doxcode', false, true );
		
		$this->initNonPersistableVar ( 'cat_subs', XOBJ_DTYPE_INT );
		
		$this->setControl ( 'cat_summary', 'dhtmltextarea' );
		$this->setControl ( 'cat_description', 'dhtmltextarea' );
		$this->setControl ( 'cat_status', array ('itemHandler' => 'category', 'method' => 'getCategory_statusArray', 'module' => 'faq' ) );
		$this->setControl ( 'cat_pid', array ('itemHandler' => 'category', 'method' => 'getCategoryList', 'module' => 'faq' ) );
		
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
		if ($format == 's' && in_array ( $key, array ('cat_title', 'cat_pid', 'cat_subs', 'cat_menutitle' ) )) {
			return call_user_func ( array ($this, $key ) );
		}
		return parent::getVar ( $key, $format );
	}
	
	function cat_title() {
		$ret = $this->getItemLink ( false );
		
		return $ret;
	}
	
	function cat_pid() {
		$pid = $this->getVar ( 'cat_pid', 'n' );
		
		if (! $pid) {
			return '';
		} else {
			$cat = $this->handler->get ( $pid );
			
			return $cat->getVar ( 'cat_title' );
		}
	}
	
	function cat_menutitle() {
		$ret = trim ( $this->getVar ( 'cat_menutitle', 'n' ) );
		
		if (empty ( $ret )) {
			return $this->getVar ( 'cat_title', 'n' );
		}
		
		return $ret;
	}
	
	/**
	 * Retrieving the count of sub-categories of this category
	 *
	 * @return int number of sub-categories
	 */
	function cat_subs() {
		$ret = $this->handler->getCategoriesSubsCount ( $this->getVar ( 'cat_id', 'e' ) );
		
		if ($ret > 0) {
			$ret = '<a href="' . $this->handler->_moduleUrl . 'admin/' . $this->handler->_itemname . '.php?cat_pid=' . $this->getVar ( 'cat_id', 'e' ) . '">' . $ret . ' <img src="' . ICMS_URL . '/images/open12.gif" align="absmiddle" /></a>';
		}
		
		return $ret;
	}
	
	function getCategory_weightControl() {
		include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
		$control = new XoopsFormText ( '', 'cat_weight[]', 5, 255, $this->getVar ( 'cat_weight', 'e' ) );
		$control->setExtra ( 'style="text-align:center;"' );
		
		return $control->render ();
	}
	
	function getCategory_statusControl() {
		include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
		$control = new XoopsFormSelect ( '', 'cat_status[]', $this->getVar ( 'cat_status', 'e' ) );
		$category_statusArray = $this->handler->getCategory_statusArray ();
		$control->addOptionArray ( $category_statusArray );
		
		return $control->render ();
	}
	
	/**
	 * Check is user has access to view this category
	 *
	 * User will be able to view the category if
	 * - the status of the category is Active AND
	 * - the user belongs at least one of the allowed groups to view the category OR
	 * - he is an admin
	 *
	 * @return bool true if user can view this category, false if not
	 */
	function accessGranted() {
		global $xoopsUser;
		
		$gperm_handler = & xoops_gethandler ( 'groupperm' );
		$groups = is_object ( $xoopsUser ) ? $xoopsUser->getGroups () : array (XOOPS_GROUP_ANONYMOUS );
		
		$module_handler = xoops_gethandler ( 'module' );
		$module = $module_handler->getByDirname ( 'faq' );
		
		$agroups = $gperm_handler->getGroupIds ( 'module_admin', $module->mid () );
		$allowed_groups = array_intersect ( $groups, $agroups );
		
		$viewperm = $gperm_handler->checkRight ( 'category_read', $this->getVar ( 'cat_id', 'e' ), $groups, $module->mid () );
		
		if ($viewperm && $this->getVar ( 'cat_status', 'e' ) == FAQ_CATEGORY_STATUS_ACTIVE) {
			return true;
		}
		
		if ($viewperm && count ( $allowed_groups ) > 0) {
			return true;
		}
		return false;
	}
	
	/**
	 * Check to see wether the current user can edit or delete this category
	 *
	 * @return bool true if he can, false if not
	 */
	function userCanEditAndDelete() {
		global $xoopsUser, $faq_isAdmin;
		if (! is_object ( $xoopsUser )) {
			return false;
		}
		if ($faq_isAdmin) {
			return true;
		}
		return false;
	}
	
	/**
	 * Overridding IcmsPersistable::getItemLink() method to add support for SEO
	 *
	 * @param bool $onlyUrl wether or not to return a simple URL or a full <a> link
	 * @return string user side link to the object
	 */
	function getItemLink($onlyUrl = true, $title = null) {
		$seoMode = faq_getModuleModeSEO ( $this->handler->_moduleName );
		$seoModuleName = faq_getModuleNameForSEO ( $this->handler->_moduleName );
		$seoIncludeId = faq_getModuleIncludeIdSEO ( $this->handler->_moduleName );
		
		if ($seoMode == 'rewrite') {
			$ret = XOOPS_URL . '/' . $seoModuleName . '/' . $this->getVar ( 'short_url' ) . '.html';
		} else if ($seoMode == 'pathinfo') {
			$ret = FAQ_URL . 'seo.php/' . $seoModuleName . '.' . $this->handler->_itemname . ($seoIncludeId ? '.' . $this->getVar ( $this->handler->keyName ) : '') . '/' . $this->getVar ( 'short_url' ) . '.html';
		} else {
			$ret = $this->handler->_moduleUrl . $this->handler->_page . "?" . $this->handler->keyName . "=" . $this->getVar ( $this->handler->keyName );
		}
		
		if (empty ( $title )) {
			$title = $this->getVar ( 'cat_title', 'n' );
		}
		
		if (! $onlyUrl) {
			$ret = "<a href='" . $ret . "'>" . $title . "</a>";
		}
		return $ret;
	}
	
	/**
	 * Overridding IcmsPersistable::toArray() method to add a few info
	 *
	 * @return array of category info
	 */
	function toArray() {
		global $faqConfig;
		$ret = parent::toArray ();
		
		$ret ['cat_name'] = $this->getVar ( 'cat_title', 'e' );
		$ret ['cat_parentid'] = $this->getVar ( 'cat_pid', 'e' );
		$ret ['cat_hassubs'] = (count ( $ret ['cat_subs'] ) > 0) ? true : false;
		
		switch ($faqConfig ['categs_order']) {
			case 'weight' :
				$sort = 'cat_weight';
				$order = 'ASC';
				break;
			case 'pub_date_asc' :
				$sort = 'cat_published_date';
				$order = 'ASC';
				break;
			case 'pub_date_desc' :
				$sort = 'cat_published_date';
				$order = 'DESC';
				break;
		}
		$ret ['categories'] = $this->handler->getCategorySubs ( $this->getVar ( 'cat_id', 'e' ), true, $sort, $order );
		$ret ['editItemLink'] = $this->getEditItemLink ( false, true, false );
		$ret ['deleteItemLink'] = $this->getDeleteItemLink ( false, true, false );
		$ret ['userCanEditAndDelete'] = $this->userCanEditAndDelete ();
		$ret ['itemLink'] = $this->getItemLink ();
		$ret ['cat_menutitle_link'] = $this->getItemLink ( false, $this->getVar ( 'cat_menutitle' ) );
		$ret ['accessgranted'] = $this->accessGranted ();
		
		return $ret;
	}
}
class FaqCategoryHandler extends IcmsPersistableObjectHandler {
	
	/**
	 * @public array of status
	 */
	public $_cat_statusArray = array ();
	
	/**
	 * Constructor
	 */
	public function __construct(& $db) {
		$this->IcmsPersistableObjectHandler ( $db, 'category', 'cat_id', 'cat_title', 'cat_decription', 'faq' );
		
		icms_loadLanguageFile ( 'faq', 'common' );
		$this->addPermission ( 'category_read', _CO_FAQ_CATEGORY_READ, _CO_FAQ_CATEGORY_READ_DSC );
		$this->addPermission ( 'category_write', _CO_FAQ_CATEGORY_WRITE, _CO_FAQ_CATEGORY_WRITE_DSC );
	}
	
	/**
	 * Retreive the possible status of a category object
	 *
	 * @return array of status
	 */
	function getCategory_statusArray() {
		if (! $this->_cat_statusArray) {
			$this->_cat_statusArray [FAQ_CATEGORY_STATUS_ACTIVE] = _CO_FAQ_CATEGORY_STATUS_ACTIVE;
			$this->_cat_statusArray [FAQ_CATEGORY_STATUS_INACTIVE] = _CO_FAQ_CATEGORY_STATUS_INACTIVE;
		}
		return $this->_cat_statusArray;
	}
	
	function getCategoryList($groups = array(), $perm = 'category_read', $status = null, $cat_id = null, $showNull = true) {
		$gperm_handler = & xoops_gethandler ( 'groupperm' );
		$module_handler = xoops_gethandler ( 'module' );
		$criteria = new CriteriaCompo ();
		if (is_array ( $groups ) && ! empty ( $groups )) {
			$module = $module_handler->getByDirname ( 'faq' );
			$categoriesID = $gperm_handler->getItemIds ( $perm, $groups, $module->mid () );
			$criteria->add ( new Criteria ( 'cat_id', '(' . implode ( ',', $categoriesID ) . ')', 'IN' ) );
		}
		if (isset ( $status )) {
			$criteria->add ( new Criteria ( 'cat_status', intval ( $status ) ) );
		}
		if (is_null ( $cat_id )) {
			$cat_id = 0;
		}
		$criteria->add ( new Criteria ( 'cat_pid', $cat_id ) );
		
		$categories = & $this->getObjects ( $criteria, true );
		
		$ret = array ();
		if ($showNull) {
			$ret [0] = '-----------------------';
		}
		foreach ( array_keys ( $categories ) as $i ) {
			$ret [$i] = $categories [$i]->getVar ( 'cat_title' );
			$subcategories = $this->getCategoryList ( $groups, $perm, $status, $categories [$i]->getVar ( 'cat_id' ), $showNull );
			foreach ( array_keys ( $subcategories ) as $j ) {
				$ret [$j] = '-' . $subcategories [$j];
			}
		}
		
		return $ret;
	}
	
	/**
	 * Create the criteria that will be used by getCategories and getCategoriesCount
	 *
	 * @param int $start to which record to start
	 * @param int $limit limit of categories to return
	 * @param int $cat_id ID of a single category to retrieve
	 * @param int $cat_pid ID of a single parent category to retrieve
	 * @return CriteriaCompo $criteria
	 */
	function getCategoriesCriteria($start = 0, $limit = 0, $cat_id = false, $cat_pid = false, $order = 'cat_published_date', $sort = 'DESC') {
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
		
		$criteria->add ( new Criteria ( 'cat_status', FAQ_CATEGORY_STATUS_ACTIVE ) );
		
		if ($cat_id) {
			$crit = new CriteriaCompo ( new Criteria ( 'short_url', $cat_id, 'LIKE' ) );
			$crit->add ( new Criteria ( 'cat_id', $cat_id ), 'OR' );
			$criteria->add ( $crit );
		}
		
		if ($cat_pid !== false) {
			$criteria->add ( new Criteria ( 'cat_pid', $cat_pid ) );
		}
		return $criteria;
	}
	
	/**
	 * Get single category object
	 *
	 * @param int $cat_id
	 * @return object Category object
	 */
	function getCategory($cat_id) {
		$ret = $this->getCategories ( 0, 0, $cat_id );
		return isset ( $ret [$cat_id] ) ? $ret [$cat_id] : false;
	}
	
	/**
	 * Get categories as array, ordered by cat_published_date DESC
	 *
	 * @param int $start to which record to start
	 * @param int $limit limit of categories to return
	 * @param int $cat_id ID of a single category to retrieve
	 * @param int $cat_pid ID of a single parent category to retrieve
	 * 
	 * @return array of contents
	 */
	function getCategories($start = 0, $limit = 0, $cat_id = false, $cat_pid = false, $order = 'cat_published_date', $sort = 'DESC') {
		$criteria = $this->getCategoriesCriteria ( $start, $limit, $cat_id, $cat_pid, $order, $sort );
		$categories = $this->getObjects ( $criteria, true, false );
		$ret = array ();
		foreach ( $categories as $category ) {
			if ($category ['accessgranted']) {
				$ret [$category ['cat_id']] = $category;
			}
		}
		return $ret;
	}
	
	/**
	 * Get Categories requested by the global search feature
	 *
	 * @param array $queryarray array containing the searched keywords
	 * @param bool $andor wether the keywords should be searched with AND or OR
	 * @param int $limit maximum results returned
	 * @param int $offset where to start in the resulting dataset
	 * @param int $userid should we return faqs by specific poster ?
	 * @return array array of faqs
	 */
	function getCategoriesForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = new CriteriaCompo ();
		
		$criteria->setStart ( $offset );
		$criteria->setLimit ( $limit );
		
		if ($queryarray) {
			$criteriaKeywords = new CriteriaCompo ();
			for($i = 0; $i < count ( $queryarray ); $i ++) {
				$criteriaKeyword = new CriteriaCompo ();
				$criteriaKeyword->add ( new Criteria ( 'cat_title', '%' . $queryarray [$i] . '%', 'LIKE' ), 'OR' );
				$criteriaKeyword->add ( new Criteria ( 'cat_description', '%' . $queryarray [$i] . '%', 'LIKE' ), 'OR' );
				$criteriaKeyword->add ( new Criteria ( 'cat_summary', '%' . $queryarray [$i] . '%', 'LIKE' ), 'OR' );
				$criteriaKeywords->add ( $criteriaKeyword, $andor );
				unset ( $criteriaKeyword );
			}
			$criteria->add ( $criteriaKeywords );
		}
		$criteria->add ( new Criteria ( 'cat_status', FAQ_CATEGORY_STATUS_ACTIVE ) );
		$cats = $this->getObjects ( $criteria );
		
		$ret = array ();
		foreach ( $cats as $cat ) {
			if ($cat->accessGranted ()) {
				$ret [$cat->getVar ( 'cat_id' )] = $cat;
			}
		}
		
		return $ret;
	}
	
	/**
	 * Get sub-categories count
	 *
	 * @param int $cat_id, if specifid, only the subcategories of this category will be returned
	 * @return array of categories
	 */
	function getCategoriesSubsCount($cat_id = 0) {
		$criteria = $this->getCategoriesCriteria ();
		$criteria->add ( new Criteria ( 'cat_pid', $cat_id ) );
		return $this->getCount ( $criteria );
	}
	
	/**
	 * Get the sub-categories of the category
	 *
	 * @return array of categories
	 */
	function getCategorySubs($cat_id = 0, $toarray = false, $sort = 'cat_weight', $order = 'ASC') {
		$criteria = $this->getCategoriesCriteria ();
		$criteria->add ( new Criteria ( 'cat_pid', $cat_id ) );
		$criteria->setSort ( $sort );
		$criteria->setOrder ( $order );
		$categories = $this->getObjects ( $criteria );
		if (! $toarray) {
			return $categories;
		}
		$ret = array ();
		foreach ( array_keys ( $categories ) as $i ) {
			if ($categories [$i]->accessGranted ()) {
				$ret [$i] = $categories [$i]->toArray ();
				$ret [$i] ['cat_summary'] = $categories [$i]->getVar ( 'cat_summary', 'n' )?$categories [$i]->getVar ( 'cat_summary', 'n' ):icms_substr ( icms_cleanTags ( $categories [$i]->getVar ( 'cat_description', 'n' ), array () ), 0, 300 );
				$ret [$i] ['cat_url'] = $categories [$i]->getItemLink ();
			}
		}
		return $ret;
	}
	
	/**
	 * Function to create a navigation menu
	 * This function was based on the function that do the same in mastop publish module
	 * 
	 * @param integer $cat_id
	 * @return string
	 */
	function getBreadcrumbForPid($cat_id) {
		$url = $_SERVER ['PHP_SELF'];
		$ret = false;
		
		if ($cat_id == false) {
			return $ret;
		} else {
			if ($cat_id > 0) {
				$category = $this->get ( $cat_id );
				if ($category->getVar ( 'cat_id', 'e' ) > 0) {
					$ret = "<a href='" . $url . "?cat_pid=" . $category->getVar ( 'cat_id', 'e' ) . "'>" . $category->getVar ( 'cat_title', 'e' ) . "</a>";
					if ($category->getVar ( 'cat_pid', 'e' ) == 0) {
						return "<a href='" . $url . "?cat_pid=0'>" . _MI_FAQ_CATEGORYS . "</a> &gt; " . $ret;
					} elseif ($category->getVar ( 'cat_pid', 'e' ) > 0) {
						$ret = $this->getBreadcrumbForPid ( $category->getVar ( 'cat_pid', 'e' ) ) . " &gt; " . $ret;
					}
				}
			} else {
				return $ret;
			}
		}
		return $ret;
	}
	
	/**
	 * Change a value for categories with a certain criteria
	 *
	 * @param   string  $fieldname  Name of the field
	 * @param   string  $fieldvalue Value to write
	 * @param   object  $criteria   {@link CriteriaElement}
	 *
	 * @return  bool
	 **/
	function updateAll($fieldname, $fieldvalue, $criteria = null) {
		$set_clause = is_numeric ( $fieldvalue ) ? $fieldname . ' = ' . $fieldvalue : $fieldname . ' = ' . $this->db->quoteString ( $fieldvalue );
		$sql = 'UPDATE ' . $this->db->prefix ( 'faq_category' ) . ' SET ' . $set_clause;
		if (isset ( $criteria ) && is_subclass_of ( $criteria, 'criteriaelement' )) {
			$sql .= ' ' . $criteria->renderWhere ();
		}
		if (! $this->db->queryF ( $sql )) {
			return false;
		}
		return true;
	}
}
?>