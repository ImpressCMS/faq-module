<?php
/**
* Import Script
* 
* Import data from SmartFAQ 1.0.x to imFAQ
* 
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

include_once ("admin_header.php");

$importFromModuleName = "SmartFAQ " . $_POST ['sf_version'];

$scriptname = "smartfaq.php";

$op = 'start';

$myts = MyTextSanitizer::getInstance ();

if (isset ( $_POST ['op'] ) && ($_POST ['op'] == 'go')) {
	$op = $_POST ['op'];
}

if ($op == 'start') {
	icms_cp_header ();
	include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
	$icmsModule->displayAdminMenu ( - 1, _AM_IMFAQ_IMPORT );
	
	$result = $xoopsDB->query ( "SELECT COUNT(*) FROM " . $xoopsDB->prefix ( "smartfaq_categories" ) );
	list ( $totalCat ) = $xoopsDB->fetchRow ( $result );
	
	if ($totalCat == 0) {
		$errs [] = _AM_IMFAQ_IMPORT_NO_CATEGORY;
		$error = true;
	} else {
		include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
		
		$result = $xoopsDB->query ( "SELECT COUNT(*) FROM " . $xoopsDB->prefix ( "smartfaq_faq" ) );
		list ( $totalArticles ) = $xoopsDB->fetchRow ( $result );
		
		if ($totalArticles == 0) {
			$errs [] = sprintf ( _AM_IMFAQ_IMPORT_MODULE_FOUND_NO_ITEMS, $importFromModuleName, $totalArticles );
			$error = true;
		} else {
			echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . sprintf ( _AM_IMFAQ_IMPORT_MODULE_FOUND, $importFromModuleName, $totalArticles, $totalCat ) . "</span>";
			
			$form = new XoopsThemeForm ( _AM_IMFAQ_IMPORT_SETTINGS, 'import_form', IMFAQ_ADMIN_URL . "$scriptname" );
			
			// Categories to be imported
			$sql = "SELECT cat.categoryid, cat.parentid, cat.name, COUNT(art.faqid) FROM " . $xoopsDB->prefix ( "smartfaq_categories" ) . " AS cat LEFT JOIN " . $xoopsDB->prefix ( "smartfaq_faq" ) . " AS art ON cat.categoryid=art.categoryid GROUP BY cat.categoryid";
			
			$result = $xoopsDB->query ( $sql );
			$cat_cbox_options = array ( );
			while ( list ( $cid, $pid, $cat_title, $art_count ) = $xoopsDB->fetchRow ( $result ) ) {
				$cat_title = $myts->displayTarea ( $cat_title );
				$cat_cbox_options [$cid] = "$cat_title ($art_count)";
			}
			$cat_label = new XoopsFormLabel ( _AM_IMFAQ_IMPORT_CATEGORIES, implode ( "<br />", $cat_cbox_options ) );
			$cat_label->setDescription ( _AM_IMFAQ_IMPORT_CATEGORIES_DSC );
			$form->addElement ( $cat_label );
			
			// SmartFAQ parent category
			$imfaq_category_handler = icms_getModuleHandler ( 'category' );
			$parent_cat_sel = new XoopsFormSelect(_AM_IMFAQ_IMPORT_PARENT_CATEGORY,'parent_category');
			$parent_cat_sel->setDescription ( _AM_IMFAQ_IMPORT_PARENT_CATEGORY_DSC );
			$parent_cat_sel->addOptionArray($imfaq_category_handler->getCategoryList());
			$form->addElement ( $parent_cat_sel );
				
			$form->addElement ( new XoopsFormHidden ( 'op', 'go' ) );
			$form->addElement ( new XoopsFormButton ( '', 'import', _AM_IMFAQ_IMPORT, 'submit' ) );
			
			$form->addElement ( new XoopsFormHidden ( 'from_module_version', $_POST ['sf_version'] ) );
			
			$form->display ();
			
			icms_cp_footer ();
			exit ();
		}
	}
}

if ($op == 'go') {
	icms_cp_header ();
	$icmsModule->displayAdminMenu ( - 1, _AM_IMFAQ_IMPORT );
	
	$imfaq_faq_handler = icms_getModuleHandler ( 'faq' );
	$imfaq_category_handler = icms_getModuleHandler ( 'category' );
	$gperm_handler = & xoops_gethandler ( 'groupperm' );
	
	$cnt_imported_cat = 0;
	$cnt_imported_articles = 0;
	
	$parentId = $_POST ['parent_category'];
	
	$sql = "SELECT * FROM " . $xoopsDB->prefix ( "smartfaq_categories" ) . "";
	
	$resultCat = $xoopsDB->query ( $sql );
	
	$newCatArray = array ( );
	$newArticleArray = array ( );
	
	while ( $arrCat = $xoopsDB->fetchArray ( $resultCat ) ) {
		// insert category into imFAQ
		$categoryObj = $imfaq_category_handler->create ();
		
		$newCat = array ( );
		
		$newCat ['oldid'] = $arrCat ['categoryid'];
		$newCat ['oldpid'] = $arrCat ['parentid'];
		
		$categoryObj->setVar ( 'cat_pid', $arrCat ['parentid'] );
		$categoryObj->setVar ( 'cat_weight', $arrCat ['weight'] );
		$categoryObj->setVar ( 'cat_title', $arrCat ['name'] );
		$categoryObj->setVar ( 'cat_description', $arrCat ['description'] );
		$categoryObj->setVar ( 'cat_published_date', $arrCat ['created'] );
		$categoryObj->setVar ( 'cat_status', 1 );
		
		if (! $imfaq_category_handler->insert ( $categoryObj, true )) {
			$errs [] = sprintf ( _AM_IMFAQ_IMPORT_CATEGORY_ERROR, $arrCat ['name'] );
			$error = true;
			continue;
		}
		
		$newCat ['newid'] = $categoryObj->getVar ( 'cat_id' );
		
		// Saving category permissions
		$moduleObj = $module_handler->getByDirname ( 'smartfaq' );
		$groups = $gperm_handler->getGroupIds ( 'category_read', $arrCat ['categoryid'], $moduleObj->mid () );
		
		if (! in_array ( 1, $groups )) {
			$groups [] = 1;
		}
		
		foreach ( $groups as $group ) {
			if (! $gperm_handler->addRight ( 'category_read', $newCat ['newid'], $group, $imfaqModule->mid () )) {
				$errs [] = sprintf ( _AM_IMFAQ_IMPORT_CATEGORY_PERMISSION_ERROR, $arrCat ['name'] );
				$error = true;
				continue;
			}
		}
		if (! $gperm_handler->addRight ( 'category_write', $newCat ['newid'], 1, $imfaqModule->mid () )) {
			$errs [] = sprintf ( _AM_IMFAQ_IMPORT_CATEGORY_PERMISSION_ERROR, $arrCat ['name'] );
			$error = true;
			continue;
		}
		
		$cnt_imported_cat ++;
		
		$sql = 'SELECT f.* , a.answer FROM '.$xoopsDB->prefix ( "smartfaq_faq" ).' f LEFT JOIN '.$xoopsDB->prefix ( "smartfaq_answers" ).' a ON f.faqid = a.faqid WHERE f.categoryid='.$arrCat ['categoryid'].' AND ((a.status =1 AND a.datesub >= (SELECT MAX( datesub ) FROM '.$xoopsDB->prefix ( "smartfaq_answers" ).' WHERE faqid = f.faqid )) OR a.answer IS NULL)';
		$resultArticles = $xoopsDB->query ( $sql );
		while ( $arrArticle = $xoopsDB->fetchArray ( $resultArticles ) ) {
			// insert article
			$itemObj = & $imfaq_faq_handler->create ();
			
			$sts = $arrArticle ['status'];
			if ($sts < 5 || $sts == 6){
				$sts = IMFAQ_FAQ_STATUS_PENDING;
			}elseif ($sts == 5){
				$sts = IMFAQ_FAQ_STATUS_PUBLISHED;
			}elseif ($sts == 7){
				$sts = IMFAQ_FAQ_STATUS_OFFLINE;
			}elseif ($sts > 7){
				$sts = IMFAQ_FAQ_STATUS_REJECTED;
			}
			echo $arrArticle ['datesub'].'<br />';
			$itemObj->setVar ( 'faq_cid', $categoryObj->getVar ( 'cat_id' ) );
			$itemObj->setVar ( 'faq_question', $arrArticle ['question'] );
			$itemObj->setVar ( 'faq_uid', $arrArticle ['uid'] );
			$itemObj->setVar ( 'faq_answer', $arrArticle ['answer'] );
			$itemObj->setVar ( 'faq_diduno', $arrArticle ['diduno'] );
			$itemObj->setVar ( 'faq_cancomment', $arrArticle ['cancomment'] );
			$itemObj->setVar ( 'faq_weight', $arrArticle ['weight'] );
			$itemObj->setVar ( 'faq_status', $sts );
			$itemObj->setVar ( 'faq_published_date', $arrArticle ['datesub'] );
			$itemObj->setVar ( 'faq_comments', $arrArticle ['comments'] );
			$itemObj->setVar ( 'faq_notification_sent', $arrArticle ['notifypub'] );
			$itemObj->setVar ( 'counter', $arrArticle ['counter'] );
			$itemObj->setVar ( 'dohtml', $arrArticle ['html'] );
			$itemObj->setVar ( 'dobr', $arrArticle ['linebreak'] );
			$itemObj->setVar ( 'doimage', $arrArticle ['image'] );
			$itemObj->setVar ( 'dosmiley', $arrArticle ['smiley'] );
			$itemObj->setVar ( 'doxcode', $arrArticle ['xcodes'] );

			if (! $imfaq_faq_handler->insert ($itemObj, true)) {
				$errs [] = sprintf ( "  " . _AM_IMFAQ_IMPORT_ARTICLE_ERROR, $arrArticle ['question'] );
				$error = true;
				continue;
			}
			
			$newArticleArray [$arrArticle ['faqid']] = $itemObj->getVar('faq_id');
			$cnt_imported_articles ++;
		}
		$newCatArray [$newCat ['oldid']] = $newCat;
		unset ( $newCat );
	}
	
	// Looping through cat to change the pid to the new pid
	foreach ( $newCatArray as $oldid => $newCat ) {
		$criteria = new CriteriaCompo ( );
		$criteria->add ( new Criteria ( 'cat_id', $newCat ['newid'] ) );
		$oldpid = $newCat ['oldpid'];
		if ($oldpid == 0) {
			$newpid = $parentId;
		} else {
			$newpid = $newCatArray [$oldpid] ['newid'];
		}
		$imfaq_category_handler->updateAll ( 'cat_pid', $newpid, $criteria );
		unset ( $criteria );
	}

	// Looping through the comments to link them to the new articles and module
	$module_handler = & xoops_gethandler ( 'module' );
	$moduleObj = $module_handler->getByDirname ( 'smartfaq' );
	$sf_module_id = $moduleObj->getVar ( 'mid' );
	
	$moduleObj = $module_handler->getByDirname ( 'imfaq' );
	$imfaq_module_id = $moduleObj->getVar ( 'mid' );
	
	$comment_handler = xoops_gethandler ( 'comment' );
	$criteria = new CriteriaCompo ( );
	$criteria->add ( new Criteria ( 'com_modid', $sf_module_id ) );
	$comments = $comment_handler->getObjects ( $criteria );
	foreach ( $comments as $comment ) {
		$comment->setVar ( 'com_itemid', $newArticleArray [$comment->getVar ( 'com_itemid' )] );
		$comment->setVar ( 'com_modid', $imfaq_module_id );
		$comment->setNew ();
		if (! $comment_handler->insert ( $comment )) {
			$errs [] = sprintf ( _AM_IMFAQ_IMPORTED_COMMENT_ERROR, $comment->getVar ( 'com_title' ) );
			$error = true;
		}	
	}
	
	if ($error == true) {
		$endMsg = _AM_IMFAQ_IMPORT_ERROR . '<br />' . _ERROR . '<br />' . implode ( '<br />', $errs );
	} else {
		$endMsg = _AM_IMFAQ_IMPORT_SUCCESS;
	}
	
	redirect_header ( 'index.php', 3, $endMsg );
}
?>