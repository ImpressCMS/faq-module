<?php
/**
* Generating an RSS feed
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

/** Include the module's header for all pages */
include_once 'header.php';
include_once ICMS_ROOT_PATH.'/header.php';

$clean_faq_uid = isset($_GET['uid']) ? intval($_GET['uid']) : false;
$clean_faq_cid = isset($_GET['cid']) ? intval($_GET['cid']) : false;

include_once ICMS_ROOT_PATH.'/class/icmsfeed.php';
$imfaq_feed = new IcmsFeed();

if ($clean_faq_cid){
	$imfaq_cat_handler = icms_getModuleHandler('category');
	$category = $imfaq_cat_handler->get($clean_faq_cid);
}

$imfaq_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name().($clean_faq_cid?' - '.$category->getVar('cat_title','e'):'');
$imfaq_feed->url = ICMS_URL;
$imfaq_feed->description = $icmsConfig['slogan'];
$imfaq_feed->language = _LANGCODE;
$imfaq_feed->charset = _CHARSET;
$imfaq_feed->category = $icmsModule->name();

$imfaq_faq_handler = icms_getModuleHandler('faq');
$faqsArray = $imfaq_faq_handler->getFaqs(0, 20, $clean_faq_cid, false, $clean_faq_uid);

foreach($faqsArray as $faqArray) {
	$imfaq_feed->feeds[] = array (
	  'title' => $faqArray['faq_title'],
	  'link' => str_replace('&', '&amp;', $faqArray['itemUrl']),
	  'description' => htmlspecialchars(str_replace('&', '&amp;', $faqArray['faq_teaser']), ENT_QUOTES),
	  'pubdate' => $faqArray['faq_published_date_int'],
	  'guid' => str_replace('&', '&amp;', $faqArray['itemUrl']),
	  'category' => $faqArray['faq_cid'],
	  'author' => $faqArray['faq_uid']
	);
}

$imfaq_feed->render();
?>