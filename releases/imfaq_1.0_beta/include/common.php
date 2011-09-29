<?php
/**
* Common file of the module included on all pages of the module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("IMFAQ_DIRNAME"))		define("IMFAQ_DIRNAME", $modversion['dirname'] = basename(dirname(dirname(__FILE__))));
if(!defined("IMFAQ_URL"))			define("IMFAQ_URL", ICMS_URL.'/modules/'.IMFAQ_DIRNAME.'/');
if(!defined("IMFAQ_ROOT_PATH"))	define("IMFAQ_ROOT_PATH", ICMS_ROOT_PATH.'/modules/'.IMFAQ_DIRNAME.'/');
if(!defined("IMFAQ_IMAGES_URL"))	define("IMFAQ_IMAGES_URL", IMFAQ_URL.'images/');
if(!defined("IMFAQ_ADMIN_URL"))	define("IMFAQ_ADMIN_URL", IMFAQ_URL.'admin/');

// Include the common language file of the module
icms_loadLanguageFile('imfaq', 'common');

include_once(IMFAQ_ROOT_PATH . "include/functions.php");

// Creating the module object to make it available throughout the module
$imfaqModule = icms_getModuleInfo(IMFAQ_DIRNAME);

if (is_object($imfaqModule)){
	$imfaq_moduleName = $imfaqModule->getVar('name');
}

// Find if the user is admin of the module and make this info available throughout the module
$imfaq_isAdmin = icms_userIsAdmin(IMFAQ_DIRNAME);

// Creating the module config array to make it available throughout the module
$imfaqConfig = icms_getModuleConfig(IMFAQ_DIRNAME);

// creating the icmsPersistableRegistry to make it available throughout the module
global $icmsPersistableRegistry;
$icmsPersistableRegistry = IcmsPersistableRegistry::getInstance();

?>