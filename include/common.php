<?php
/**
* Common file of the module included on all pages of the module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("FAQ_DIRNAME"))		define("FAQ_DIRNAME", $modversion['dirname'] = basename(dirname(dirname(__FILE__))));
if(!defined("FAQ_URL"))			define("FAQ_URL", ICMS_URL.'/modules/'.FAQ_DIRNAME.'/');
if(!defined("FAQ_ROOT_PATH"))	define("FAQ_ROOT_PATH", ICMS_ROOT_PATH.'/modules/'.FAQ_DIRNAME.'/');
if(!defined("FAQ_IMAGES_URL"))	define("FAQ_IMAGES_URL", FAQ_URL.'images/');
if(!defined("FAQ_ADMIN_URL"))	define("FAQ_ADMIN_URL", FAQ_URL.'admin/');

// Include the common language file of the module
icms_loadLanguageFile('faq', 'common');

include_once(FAQ_ROOT_PATH . "include/functions.php");

// Creating the module object to make it available throughout the module
$faqModule = icms_getModuleInfo(FAQ_DIRNAME);

if (is_object($faqModule)){
	$faq_moduleName = $faqModule->getVar('name');
}

// Find if the user is admin of the module and make this info available throughout the module
$faq_isAdmin = icms_userIsAdmin(FAQ_DIRNAME);

// Creating the module config array to make it available throughout the module
$faqConfig = icms_getModuleConfig(FAQ_DIRNAME);

// creating the icmsPersistableRegistry to make it available throughout the module
global $icmsPersistableRegistry;
$icmsPersistableRegistry = IcmsPersistableRegistry::getInstance();

?>