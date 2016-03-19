<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: defines.php 2150 2011-11-17 20:45:49Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

if (!defined('sh404SEF_ADMIN_ABS_PATH')) {
  define('sh404SEF_ADMIN_ABS_PATH', str_replace('\\','/',dirname(__FILE__)).'/');
}
if (!defined('sh404SEF_ABS_PATH')) {
  define('sh404SEF_ABS_PATH', str_replace( '/administrator/components/com_sh404sef', '', sh404SEF_ADMIN_ABS_PATH) );
}
if (!defined('sh404SEF_FRONT_ABS_PATH')) {
  define('sh404SEF_FRONT_ABS_PATH', sh404SEF_ABS_PATH.'components/com_sh404sef/');
}

defined('SH404SEF_OPTION_VALUE_NO') or define ('SH404SEF_OPTION_VALUE_NO', 0);
defined('SH404SEF_OPTION_VALUE_YES') or define ('SH404SEF_OPTION_VALUE_YES', 1);
defined('SH404SEF_OPTION_VALUE_USE_DEFAULT') or define ('SH404SEF_OPTION_VALUE_USE_DEFAULT', 2);