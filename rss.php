<?php
/**
* Generating an RSS feed
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

/** Include the module's header for all pages */
include_once 'header.php';
include_once ICMS_ROOT_PATH.'/header.php';

$clean_faq_uid = isset($_GET['uid']) ? intval($_GET['uid']) : false;
$clean_faq_cid = isset($_GET['cid']) ? intval($_GET['cid']) : false;

include_once ICMS_ROOT_PATH.'/class/icmsfeed.php';
$faq_feed = new IcmsFeed();

if ($clean_faq_cid){
	$faq_cat_handler = icms_getModuleHandler('category');
	$category = $faq_cat_handler->get($clean_faq_cid);
}

$faq_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name().($clean_faq_cid?' - '.$category->getVar('cat_title','e'):'');
$faq_feed->url = ICMS_URL;
$faq_feed->description = $icmsConfig['slogan'];
$faq_feed->language = _LANGCODE;
$faq_feed->charset = _CHARSET;
$faq_feed->category = $icmsModule->name();

$faq_faq_handler = icms_getModuleHandler('faq');
$faqsArray = $faq_faq_handler->getFaqs(0, 20, $clean_faq_cid, false, $clean_faq_uid);

foreach($faqsArray as $faqArray) {
	$faq_feed->feeds[] = array (
	  'title' => $faqArray['faq_title'],
	  'link' => str_replace('&', '&amp;', $faqArray['itemUrl']),
	  'description' => htmlspecialchars(str_replace('&', '&amp;', $faqArray['faq_teaser']), ENT_QUOTES),
	  'pubdate' => $faqArray['faq_published_date_int'],
	  'guid' => str_replace('&', '&amp;', $faqArray['itemUrl']),
	  'category' => $faqArray['faq_cid'],
	  'author' => $faqArray['faq_uid']
	);
}

$faq_feed->render();
?>