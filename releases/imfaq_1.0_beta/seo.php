<?php
/**
* imFAQ seo feature
*
* This file holds the configuration information of this module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

include '../../mainfile.php';

if (empty($_GET['seoOp']))
{
	// SEO mode is path-info
	/*
	Sample URL for path-info
	http://localhost/modules/smartcontent/seo.php/item.2/can-i-turn-the-ads-off.html
	*/
	$data = explode("/",$_SERVER['PATH_INFO']);

	$seoParts = explode('.', $data[1]);
	$seoOp = $seoParts[0];
	$seoArg = $seoParts[1];
	// for multi-argument modules, where itemid and catid both are required.
	// $seoArg = substr($data[1], strlen($seoOp) + 1);
}

$seoMap = array(
	'category' => 'category.php',
	'faq' => 'faq.php',
	'print' => 'print.php'
);

if (! empty($_GET['seoOp']) && ! empty($seoMap[$_GET['seoOp']]))
{
	// module specific dispatching logic, other module must implement as
	// per their requirements.
	$newUrl = '/modules/imfaq/' . $seoMap[$_GET['seoOp']];
	if (substr($newUrl,-4) != '.php'){
		$newUrl .= '.php';
	}

	$newUrl = str_ireplace('http://'.$_SERVER['SERVER_NAME'],'',ICMS_URL.$newUrl); 

	$_ENV['PHP_SELF'] = $newUrl;
	$_SERVER['SCRIPT_NAME'] = $newUrl;
	$_SERVER['PHP_SELF'] = $newUrl;
	switch ($_GET['seoOp']) {
		case 'category':
			$_SERVER['REQUEST_URI'] = $newUrl . '?short_url=' . $_GET['seoArg'];
			$_GET['short_url'] = $_GET['seoArg'];
			break;
		case 'faq':
		case 'print':
		default:
			$_SERVER['REQUEST_URI'] = $newUrl . '?short_url=' . $_GET['seoArg'];
			$_GET['short_url'] = $_GET['seoArg'];
	}
	include($_GET['seoOp'] . ".php");
}

exit;

?>