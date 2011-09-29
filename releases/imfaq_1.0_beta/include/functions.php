<?php
/**
* Common functions used by the module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

/**
 * Get module admin link
 *
 * @todo to be move in icms core
 *
 * @param string $moduleName dirname of the moodule
 * @return string URL of the admin side of the module
 */
function imfaq_getModuleAdminLink($moduleName='imfaq') {
	global $icmsModule;
	if (!$moduleName && (isset ($icmsModule) && is_object($icmsModule))) {
		$moduleName = $icmsModule->getVar('dirname');
	}
	$ret = '';
	if ($moduleName) {
		$ret = "<a href='" . ICMS_URL . "/modules/$moduleName/admin/index.php'>" ._MD_IMFAQ_ADMIN_PAGE . "</a>";
	}
	return $ret;
}

/**
 * Get URL of previous page
 *
 * @todo to be moved in ImpressCMS 1.2 core
 *
 * @param string $default default page if previous page is not found
 * @return string previous page URL
 */
function imfaq_getPreviousPage($default=false) {
	global $impresscms;
	if (isset($impresscms->urls['previouspage'])) {
		return $impresscms->urls['previouspage'];
	} elseif($default) {
		return $default;
	} else {
		return ICMS_URL;
	}
}

/**
 * Get month name by its ID
 *
 * @todo to be moved in ImpressCMS 1.2 core
 *
 * @param int $month_id ID of the month
 * @return string month name
 */
function imfaq_getMonthNameById($month_id) {
	return Icms_getMonthNameById($month_id);
}

/**
* Return a linked username or full name for a specific $userid
*
* @todo this function is fixing a ucwords bug in icms_getLinkedUnameFromId so we will update this in icms 1.2
*
* @param integer $userid uid of the related user
* @param bool $name true to return the fullname, false to use the username; if true and the user does not have fullname, username will be used instead
* @param array $users array already containing XoopsUser objects in which case we will save a query
* @param bool $withContact true if we want contact details to be added in the value returned (PM and email links)
* @return string name of user with a link on his profile
*/
function imfaq_getLinkedUnameFromId($userid, $name = false, $users = array (), $withContact = false) {
	if(!is_numeric($userid)) {return $userid;}
	$userid = intval($userid);
	if($userid > 0)
	{
		if($users == array())
		{
			//fetching users
			$member_handler = & xoops_gethandler('member');
			$user = & $member_handler->getUser($userid);
		}
		else
		{
			if(!isset($users[$userid])) {return $GLOBALS['icmsConfig']['anonymous'];}
			$user = & $users[$userid];
		}
		if(is_object($user))
		{
			$ts = & MyTextSanitizer::getInstance();
			$username = $user->getVar('uname');
			$fullname = '';
			$fullname2 = $user->getVar('name');
			if(($name) && !empty($fullname2)) {$fullname = $user->getVar('name');}
			if(!empty ($fullname)) {$linkeduser = "$fullname [<a href='".ICMS_URL."/userinfo.php?uid=".$userid."'>".$ts->htmlSpecialChars($username)."</a>]";}
			else {$linkeduser = "<a href='".ICMS_URL."/userinfo.php?uid=".$userid."'>".$ts->htmlSpecialChars($username)."</a>";}
			// add contact info : email + PM
			if($withContact)
			{
				$linkeduser .= '<a href="mailto:'.$user->getVar('email').'"><img style="vertical-align: middle;" src="'.ICMS_URL.'/images/icons/email.gif'.'" alt="'._US_SEND_MAIL.'" title="'._US_SEND_MAIL.'"/></a>';
				$js = "javascript:openWithSelfMain('".ICMS_URL.'/pmlite.php?send2=1&to_userid='.$userid."', 'pmlite',450,370);";
				$linkeduser .= '<a href="'.$js.'"><img style="vertical-align: middle;" src="'.ICMS_URL.'/images/icons/pm.gif'.'" alt="'._US_SEND_PM.'" title="'._US_SEND_PM.'"/></a>';
			}
			return $linkeduser;
		}
	}
	return $GLOBALS['icmsConfig']['anonymous'];
}

/**
 * ICMS Seo functions are not implemented yet, so I'm using the smartobject version here
 */
function &imfaq_getModuleInfo($moduleName = false) {
	static $imfaqModules;
	if (isset ($imfaqModules[$moduleName])) {
		$ret =& $imfaqModules[$moduleName];
		return $ret;
	}
	global $xoopsModule;
	if (!$moduleName) {
		if (isset ($xoopsModule) && is_object($xoopsModule)) {
			$imfaqModules[$xoopsModule->getVar('dirname')] = & $xoopsModule;
			return $imfaqModules[$xoopsModule->getVar('dirname')];
		}
	}
	if (!isset ($imfaqModules[$moduleName])) {
		if (isset ($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $moduleName) {
			$imfaqModules[$moduleName] = & $xoopsModule;
		} else {
			$hModule = & xoops_gethandler('module');
			if ($moduleName != 'xoops') {
				$imfaqModules[$moduleName] = & $hModule->getByDirname($moduleName);

			} else {
				$imfaqModules[$moduleName] = & $hModule->getByDirname('system');
			}
		}
	}
	return $imfaqModules[$moduleName];
}

function &imfaq_getModuleConfig($moduleName = false) {
	static $imfaqConfigs;
		if (isset ($imfaqConfigs[$moduleName])) {
		$ret = & $imfaqConfigs[$moduleName];
		return $ret;
	}
	global $xoopsModule, $xoopsModuleConfig;
	if (!$moduleName) {
		if (isset ($xoopsModule) && is_object($xoopsModule)) {
			$imfaqConfigs[$xoopsModule->getVar('dirname')] = & $xoopsModuleConfig;
			return $imfaqConfigs[$xoopsModule->getVar('dirname')];
		}
	}
	// if we still did not found the xoopsModule, this is because there is none
	if (!$moduleName) {
		$ret = false;
		return $ret;
	}
	if (isset ($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $moduleName) {
		$imfaqConfigs[$moduleName] = & $xoopsModuleConfig;
	} else {
		$module = & imfaq_getModuleInfo($moduleName);
		if (!is_object($module)) {
			$ret = false;
			return $ret;
		}
		$hModConfig = & xoops_gethandler('config');
		$imfaqConfigs[$moduleName] = & $hModConfig->getConfigsByCat(0, $module->getVar('mid'));
	}
	return $imfaqConfigs[$moduleName];
}

function imfaq_getModuleName($withLink = true, $forBreadCrumb = false, $moduleName = false) {
	if (!$moduleName) {
		global $xoopsModule;
		$moduleName = $xoopsModule->getVar('dirname');
	}
	$imfaqModule = & imfaq_getModuleInfo($moduleName);
	$imfaqModuleConfig = & imfaq_getModuleConfig($moduleName);
	if (!isset ($imfaqModule)) {
		return '';
	}

	if ($forBreadCrumb && (isset ($imfaqModuleConfig['show_mod_name_breadcrumb']) && !$imfaqModuleConfig['show_mod_name_breadcrumb'])) {
		return '';
	}
	if (!$withLink) {
		return $imfaqModule->getVar('name');
	} else {
	    $seoMode = imfaq_getModuleModeSEO($moduleName);
	    if ($seoMode == 'rewrite') {
	    	$seoModuleName = imfaq_getModuleNameForSEO($moduleName);
	    	$ret = XOOPS_URL . '/' . $seoModuleName . '/';
	    } elseif ($seoMode == 'pathinfo') {
	    	$ret = XOOPS_URL . '/modules/' . $moduleName . '/seo.php/' . $seoModuleName . '/';
	    } else {
			$ret = XOOPS_URL . '/modules/' . $moduleName . '/';
	    }

		return '<a href="' . $ret . '">' . $imfaqModule->getVar('name') . '</a>';
	}
}

function imfaq_getModuleNameForSEO($moduleName = false) {
	$imfaqModule = & imfaq_getModuleInfo($moduleName);
	$imfaqModuleConfig = & imfaq_getModuleConfig($moduleName);
	if (isset ($imfaqModuleConfig['seo_module_name'])) {
		return $imfaqModuleConfig['seo_module_name'];
	}
	$ret = imfaq_getModuleName(false, false, $moduleName);
	return (strtolower($ret));
}

function imfaq_getModuleModeSEO($moduleName = false) {
	$imfaqModule = & imfaq_getModuleInfo($moduleName);
	$imfaqModuleConfig = & imfaq_getModuleConfig($moduleName);
	return isset ($imfaqModuleConfig['seo_mode']) ? $imfaqModuleConfig['seo_mode'] : false;
}

function imfaq_getModuleIncludeIdSEO($moduleName = false) {
	$imfaqModule = & imfaq_getModuleInfo($moduleName);
	$imfaqModuleConfig = & imfaq_getModuleConfig($moduleName);
	return !empty ($imfaqModuleConfig['seo_inc_id']);
}

function imfaq_get_page_before_form()
{
	global $impresscms;
	return !empty($_POST['icms_page_before_form']) ? $_POST['icms_page_before_form'] : (!empty($impresscms->urls['previouspage'])?$impresscms->urls['previouspage']:false);
}

function json_encode_string($in_str)
  {
    mb_internal_encoding("UTF-8");
    $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
    $str = "";
    for($i=mb_strlen($in_str)-1; $i>=0; $i--)
    {
      $mb_char = mb_substr($in_str, $i, 1);
      if(mb_ereg("&#(\\d+);", mb_encode_numericentity($mb_char, $convmap, "UTF-8"), $match))
      {
        $str = sprintf("\\u%04x", $match[1]) . $str;
      }
      else
      {
        $str = $mb_char . $str;
      }
    }
    return $str;
  }

  function php_json_encode($arr)
  {
    $json_str = "";
    if(is_array($arr))
    {
      $pure_array = true;
      $array_length = count($arr);
      for($i=0;$i<$array_length;$i++)
      {
        if(! isset($arr[$i]))
        {
          $pure_array = false;
          break;
        }
      }
      if($pure_array)
      {
        $json_str ="[";
        $temp = array();
        for($i=0;$i<$array_length;$i++)       
        {
          $temp[] = sprintf("%s", php_json_encode($arr[$i]));
        }
        $json_str .= implode(",",$temp);
        $json_str .="]";
      }
      else
      {
        $json_str ="{";
        $temp = array();
        foreach($arr as $key => $value)
        {
          $temp[] = sprintf("\"%s\":%s", $key, php_json_encode($value));
        }
        $json_str .= implode(",",$temp);
        $json_str .="}";
      }
    }
    else
    {
      if(is_string($arr))
      {
        $json_str = "\"". json_encode_string($arr) . "\"";
      }
      else if(is_numeric($arr))
      {
        $json_str = $arr;
      }
      else
      {
        $json_str = "\"". json_encode_string($arr) . "\"";
      }
    }
    return $json_str;
  }
?>