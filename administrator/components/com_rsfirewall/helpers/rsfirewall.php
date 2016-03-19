<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

define('_RSFIREWALL_VERSION', '44');
define('_RSFIREWALL_VERSION_LONG', '1.4.0');
define('_RSFIREWALL_KEY', 'FW6AL534B2');
define('_RSFIREWALL_PRODUCT', 'RSFirewall!');
define('_RSFIREWALL_COPYRIGHT', '&copy;2009-2012 www.rsjoomla.com');
define('_RSFIREWALL_LICENSE', 'GPL Commercial License');
define('_RSFIREWALL_AUTHOR', '<a href="http://www.rsjoomla.com" target="_blank">www.rsjoomla.com</a>');

class RSFirewallHelper
{
	function readConfig($force=false)
	{
		static $rsfirewall_config;
		
		if (!is_object($rsfirewall_config) || $force)
		{
			$rsfirewall_config 	= new stdClass();
			$db 				=& JFactory::getDBO();
			
			$db->setQuery("SELECT * FROM `#__rsfirewall_configuration`");
			$config = $db->loadObjectList();
			foreach ($config as $config_item)
			{
				if (in_array($config_item->name, array('verify_sql_skip', 'verify_php_skip', 'verify_js_skip', 'verify_upload_skip', 'monitor_users', 'backend_access_users', 'backend_access_components', 'blocked_countries')))
					$config_item->value = strlen($config_item->value) > 0 ? RSFirewallHelper::explode($config_item->value) : array();
				
				$rsfirewall_config->{$config_item->name} = $config_item->value;
			}
		}
		
		return $rsfirewall_config;
	}
	
	function getConfig($name = null)
	{
		$config = RSFirewallHelper::readConfig();
		if ($name != null)
		{
			if (isset($config->$name))
				return $config->$name;
			else
				return false;
		}
		else
			return $config;
	}
	
	function genKeyCode()
	{
		$code = RSFirewallHelper::getConfig('global_register_code');
		if ($code === false)
			$code = '';
		return md5($code._RSFIREWALL_KEY);
	}
	
	function isJ16()
	{
		return (version_compare('1.6.0', RSFirewallHelper::getCurrentJoomlaVersion()) <= 0);
	}
	
	function isJ17()
	{
		return (version_compare('1.7.0', RSFirewallHelper::getCurrentJoomlaVersion()) <= 0);
	}
	
	function isJ17beta()
	{
		$jversion = new JVersion();
		return (isset($jversion->STATUS) && $jversion->STATUS != 'Stable') || (isset($jversion->DEV_STATUS) && $jversion->DEV_STATUS != 'Stable');
	}
	
	function getComponents()
	{
		$db =& JFactory::getDBO();
		
		if (RSFirewallHelper::isJ16())
		{
			$db->setQuery("SELECT DISTINCT(`element`) AS `option` FROM #__extensions WHERE `type`='component' ORDER BY `element` ASC");
			$components = $db->loadObjectList();
		}
		else
		{
			$db->setQuery("SELECT DISTINCT(`option`) FROM #__components WHERE `option`!='' ORDER BY `option` ASC");
			$components = $db->loadObjectList();
			
			$tmps = array('com_admin', 'com_frontpage', 'com_trash', 'com_sections', 'com_categories', 'com_checkin');
			foreach ($tmps as $tmp)
			{
				$new = new stdClass();
				$new->option = $tmp;
				$components[] = $new;
			}
		}
		
		return $components;
	}
	
	function getAdminGroups()
	{
		$db =& JFactory::getDBO();
		
		// J! 1.6 only
		if (RSFirewallHelper::isJ16())
		{			
			$db->setQuery("SELECT id FROM #__usergroups");
			$groups = $db->loadResultArray();
			
			$admin_groups = array();
			foreach ($groups as $group_id)
			{
				if (JAccess::checkGroup($group_id, 'core.login.admin'))
					$admin_groups[] = $group_id;
				elseif (JAccess::checkGroup($group_id, 'core.admin'))
					$admin_groups[] = $group_id;
			}
			
			$admin_groups = array_unique($admin_groups);
			
			return $admin_groups;
		}
	}
	
	function getAdminUsers()
	{
		$db =& JFactory::getDBO();
		
		// J! 1.5
		if (!RSFirewallHelper::isJ16())
		{
			$db->setQuery("SELECT * FROM #__users WHERE gid > 22 ORDER BY username ASC");
			return $db->loadObjectList();
		}
		// J! 1.6 ACL
		else
		{
			$admin_groups = RSFirewallHelper::getAdminGroups();
			
			$db->setQuery("SELECT u.* FROM #__user_usergroup_map m RIGHT JOIN #__users u ON (u.id=m.user_id) WHERE m.group_id IN (".implode(',', $admin_groups).") ORDER BY u.username ASC");
			return $db->loadObjectList();
		}
	}
	
	function safeJavascript($string, $html=true)
	{
		$string = addcslashes($string, "'\\");
		if ($html)
			return htmlspecialchars($string);
		else
			return $string;
	}
	
	function getLatestJoomlaVersion()
	{
		$url = 'http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=version&version=joomla';
		if (RSFirewallHelper::isJ17())
			$url .= '17';
		elseif (RSFirewallHelper::isJ16())
			$url .= '16';
		
		return RSFirewallHelper::fopen($url);
	}
	
	function getCurrentJoomlaVersion()
	{
		$jversion = new JVersion();
		$version = $jversion->getShortVersion();
		if (RSFirewallHelper::isJ17beta())
			$version .= 'b';
		return $version;
	}
	
	function getLatestFirewallVersion()
	{
		$url = 'http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=version&version=firewall&current='.urlencode(RSFirewallHelper::getCurrentJoomlaVersion());
		return RSFirewallHelper::fopen($url);
	}
	
	function getCurrentFirewallVersion()
	{
		return _RSFIREWALL_VERSION;
	}
	
	function version_compare($current, $latest)
	{
		if (strpos($current, ' ') !== false)
		{
			$current = explode(' ', $current);
			$current = $current[0];
		}
		return version_compare($current, $latest, '>=');
	}
	
	function grade($amount)
	{
		$session =& JFactory::getSession();
		
		$grade = $session->get('grade', '0');
		$grade += $amount;
		
		$session->set('grade', $grade);
	}
	
	function saveGrade()
	{
		$session =& JFactory::getSession();
		
		$grade = $session->get('grade', '0');
		$grade = RSFirewallHelper::convertGrade($grade);
		
		$db = JFactory::getDBO();
		$db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".$grade."' WHERE `name`='grade' LIMIT 1");
		$db->query();
	}
	
	function getGrade()
	{
		$session =& JFactory::getSession();
		
		return $session->get('grade', '0');
	}
	
	function convertGrade($grade)
	{
		$maxgrade = 198;
		$grade = floor(99*$grade/$maxgrade);
		return $grade;
	}
	
	function explode($what)
	{
		$what = str_replace(array("\r\n", "\r"), "\n", $what);
		return explode("\n", $what);
	}
	
	function getIP($check_for_proxy=false)
	{
		static $ip;
		
		if (!$ip) {
			$ip = $_SERVER['REMOTE_ADDR'];
			
			if ($check_for_proxy)
			{
				$headers = array('HTTP_TRUE_CLIENT_IP', 'HTTP_X_FWD_IP_ADDR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_VIA', 'HTTP_X_COMING_FROM', 'HTTP_COMING_FROM');
				foreach ($headers as $header)
					if (!empty($_SERVER[$header])) {
						$proxy = $_SERVER[$header];
						// let's see if it's an IPv4
						$parts = explode('.', $proxy);
						if (count($parts) != 4) {
							// not IPv4, continue
							continue;
						}
						
						// is this a private network IP?
						if ($parts[0] == 10) { // 10.0.0.0 - 10.255.255.255
							continue;
						}
						if ($parts[0] == 172 && $parts[1] >= 16 && $parts[1] <= 31) { // 172.16.0.0 - 172.31.255.255
							continue;
						}
						if ($parts[0] == 192 && $parts[1] == 168) { // 192.168.0.0 - 192.168.255.255
							continue;
						}
						
						// looks like IPv4, let's see if we can convert it
						$long = ip2long($proxy);
						if ($long === false || $long == -1) {
							// not IPv4, continue
							continue;
						}
						
						$ip = $proxy;
						break;
					}
			}
		}
		
		return $ip;
	}
	
	function checkBlacklist()
	{
		$ip = RSFirewallHelper::getIP(true);
		$db = &JFactory::getDBO();
		
		$db->setQuery("SELECT `ip`, `reason` FROM #__rsfirewall_lists WHERE (`ip`=".$db->quote($ip)." OR `ip` LIKE ".$db->quote('%*%').") AND `type`=".$db->quote(0)." AND `published`=".$db->quote(1));
		$blacklisted = $db->loadObjectList();
		foreach ($blacklisted as $item)
		{
			$blacklist_ip = $item->ip;
			$reason		  = $item->reason;
			if ($blacklist_ip && RSFirewallHelper::ip_in($ip, $blacklist_ip))
				RSFirewallHelper::header(403, 'Your IP has been blacklisted.<br />'.$reason, false); // blacklist
		}
	}
	
	function checkOption()
	{
		if (!RSFirewallHelper::getConfig('backend_access_control_enabled')) return;
		
		$mainframe =& JFactory::getApplication();
		$option = JRequest::getVar('option');
		
		if (!$mainframe->isAdmin()) return;
		
		$components   = RSFirewallHelper::getConfig('backend_access_components');
		$components[] = 'com_cpanel';
		$components[] = 'com_login';
		$components[] = 'com_rsfirewall';
		
		//if (RSFirewallHelper::isJ16())
			$components[] = '';
			
		if ($option == 'community')
			$option = 'com_community';
		
		if (!in_array($option, $components))
		{
			$log = new RSFirewallLog();
			$log->addEvent('medium', 'BACKEND_OPTION_ERROR', $option);
			RSFirewallHelper::header(403, '&quot;'.$option.'&quot; is not in the allowed components list.', false); // component not allowed
		}
	}
	
	function checkBackendPassword()
	{
		$mainframe =& JFactory::getApplication();
		
		// If we're not requesting a backend page or the backend password is not enabled, just skip everything.
		if (!$mainframe->isAdmin() || !RSFirewallHelper::getConfig('backend_password_enabled')) return;
		
		// If the password has not been set, skip.
		if (strlen(RSFirewallHelper::getConfig('backend_password')) != 32) return;
		
		// If we're already logged in with the correct backend password, skip.
		if (RSFirewallHelper::isBackendLogged()) return;
		
		$password_sent = JRequest::getVar('rsf_backend_password', '', 'post', 'none', JREQUEST_ALLOWRAW);
		if ($password_sent)
		{
			if ($logged = md5($password_sent) == RSFirewallHelper::getConfig('backend_password'))
			{
				$session =& JFactory::getSession();
				if ($logged)
				{
					$session->set('rsfirewall_backend_logged', true);
					$level = 'low';
					$code = 'BACKEND_LOGIN_OK';
					return $logged;
				}
				else
				{
					$session->set('rsfirewall_backend_logged', false);
					$level = 'medium';
					$code = 'BACKEND_LOGIN_ERROR';
				}
				$log = new RSFirewallLog();
				$log->addEvent($level, $code);
			}
			else
				require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'assets'.DS.'login'.DS.'login.php');
		}
		
		if (!headers_sent())
		{
			header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			header('Pragma: no-cache');
			header('Content-Type: text/html; charset=utf-8');
		}
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'assets'.DS.'login'.DS.'login.php');
		jexit();
	}
	
	function checkBackendUser()
	{
		$mainframe =& JFactory::getApplication();
		if (!RSFirewallHelper::getConfig('backend_access_control_enabled')) return;
		$users = RSFirewallHelper::getConfig('backend_access_users');
		
		if (count($users) == 0 || empty($users)) return;
		
		$user =& JFactory::getUser();
		if ($mainframe->isAdmin() && $user->id > 0 && !in_array($user->id,$users))
		{
			$log = new RSFirewallLog();
			$log->addEvent('medium', 'BACKEND_LOGIN_USER_ERROR', $user->username);
			RSFirewallHelper::header(403, '&quot;'.$user->username.'&quot; is not in the allowed users list.', false); // user forbidden
		}
	}
	
	function checkDoS()
	{
		if (!RSFirewallHelper::getConfig('active_scanner_status')) return;
		if (!RSFirewallHelper::getConfig('verify_dos')) return;
		// PayPal check
		if (!empty($_POST['txn_type']) || !empty($_POST['txn_id'])) return;
		if (empty($_SERVER['HTTP_USER_AGENT']) || $_SERVER['HTTP_USER_AGENT'] == '-' || !isset($_SERVER['HTTP_USER_AGENT']))
			RSFirewallHelper::header(403, 'DoS Protection'); // DoS
	}
	
	function checkAgents()
	{
		if (!RSFirewallHelper::getConfig('active_scanner_status')) return;
		if (!RSFirewallHelper::getConfig('verify_agents')) return;
		if (empty($_SERVER['HTTP_USER_AGENT'])) return;
		
		$patterns = array('#c0li\.m0de\.0n#', '#libwww-perl#', '#<\?(.*)\?>#', '#curl#', '#^Mozilla\/5\.0$#', '#^Mozilla$#', '#^Java#');
		
		foreach ($patterns as $i => $pattern)
		{
			// libwww-perl fix for w3c
			if ($i == 1)
			{
				if (preg_match($pattern, $_SERVER['HTTP_USER_AGENT']) && !preg_match('#^W3C-checklink#', $_SERVER['HTTP_USER_AGENT']))
					RSFirewallHelper::header(403, 'Malware detected'); // Malware
				continue;
			}
			
			if (preg_match($pattern, $_SERVER['HTTP_USER_AGENT']))
				RSFirewallHelper::header(403, 'Malware detected'); // Malware
		}
			
		unset($patterns);
	}
	
	// Verify arrays for JS injections (any <tags> found in a variable)
	function checkJSInjection($array)
	{
		$merger = new RSFirewallMerger($array);
		$results = $merger->getArray();
		
		foreach ($results as $element => $value)
		{
			if (empty($value)) continue;
			if (!is_string($value)) continue;
	
			if (preg_match("#<[^>]*\w*\"?[^>]*>#is", $value)) return true;
		}
		return false;
	}
	
	function checkXSSInjection($type)
	{
		$mainframe =& JFactory::getApplication();
		if ($mainframe->isAdmin())
			return;
		$option = JRequest::getVar('option');
		$task 	= JRequest::getVar('task');
		if ($option == 'com_content' && $task == 'edit')
			return true;
		
		if ($type == 'get')
			foreach ($_GET as $name => $value)
				$_GET[$name] = RSFirewallHelper::stripsXSSRecursive($value);
		elseif ($type == 'post')
			foreach ($_POST as $name => $value)
				$_POST[$name] = RSFirewallHelper::stripsXSSRecursive($value);
		elseif ($type == 'request')
			foreach ($_REQUEST as $name => $value)
				$_REQUEST[$name] = RSFirewallHelper::stripsXSSRecursive($value);
	}
	
	function stripsXSSRecursive($val)
	{
		if (is_array($val))
			foreach ($val as $name => $value)
				$val[$name] = RSFirewallHelper::stripsXSSRecursive($value);
		else
			$val = RSFirewallHelper::stripXSS($val);
		
		return $val;
	}
	
	// optimize to ignore false alerts
	function stripXSS($val)
	{
	   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	   // this prevents some character re-spacing such as <java\0script>
	   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
	   $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

	   // straight replacements, the user should never need these since they're normal characters
	   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
	   $search = 'abcdefghijklmnopqrstuvwxyz';
	   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	   $search .= '1234567890!@#$%^&*()';
	   $search .= '~`";:?+/={}[]-_|\'\\';
	   for ($i = 0; $i < strlen($search); $i++) {
		  // ;? matches the ;, which is optional
		  // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

		  // &#x0040 @ search for the hex values
		  $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
		  // &#00064 @ 0{0,7} matches '0' zero to seven times
		  $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
	   }

	   // now the only remaining whitespace attacks are \t, \n, and \r
	   // ([ \t\r\n]+)?
	   $ra1 = Array('\/([ \t\r\n]+)?javascript', '\/([ \t\r\n]+)?vbscript', ':([ \t\r\n]+)?expression', '<([ \t\r\n]+)?applet', '<([ \t\r\n]+)?meta', '<([ \t\r\n]+)?xml', '<([ \t\r\n]+)?blink', '<([ \t\r\n]+)?link', '<([ \t\r\n]+)?style', '<([ \t\r\n]+)?script', '<([ \t\r\n]+)?embed', '<([ \t\r\n]+)?object', '<([ \t\r\n]+)?iframe', '<([ \t\r\n]+)?frame', '<([ \t\r\n]+)?frameset', '<([ \t\r\n]+)?ilayer', '<([ \t\r\n]+)?layer', '<([ \t\r\n]+)?bgsound', '<([ \t\r\n]+)?title', '<([ \t\r\n]+)?base');
	   $ra2 = Array('onabort([ \t\r\n]+)?=', 'onactivate([ \t\r\n]+)?=', 'onafterprint([ \t\r\n]+)?=', 'onafterupdate([ \t\r\n]+)?=', 'onbeforeactivate([ \t\r\n]+)?=', 'onbeforecopy([ \t\r\n]+)?=', 'onbeforecut([ \t\r\n]+)?=', 'onbeforedeactivate([ \t\r\n]+)?=', 'onbeforeeditfocus([ \t\r\n]+)?=', 'onbeforepaste([ \t\r\n]+)?=', 'onbeforeprint([ \t\r\n]+)?=', 'onbeforeunload([ \t\r\n]+)?=', 'onbeforeupdate([ \t\r\n]+)?=', 'onblur([ \t\r\n]+)?=', 'onbounce([ \t\r\n]+)?=', 'oncellchange([ \t\r\n]+)?=', 'onchange([ \t\r\n]+)?=', 'onclick([ \t\r\n]+)?=', 'oncontextmenu([ \t\r\n]+)?=', 'oncontrolselect([ \t\r\n]+)?=', 'oncopy([ \t\r\n]+)?=', 'oncut([ \t\r\n]+)?=', 'ondataavailable([ \t\r\n]+)?=', 'ondatasetchanged([ \t\r\n]+)?=', 'ondatasetcomplete([ \t\r\n]+)?=', 'ondblclick([ \t\r\n]+)?=', 'ondeactivate([ \t\r\n]+)?=', 'ondrag([ \t\r\n]+)?=', 'ondragend([ \t\r\n]+)?=', 'ondragenter([ \t\r\n]+)?=', 'ondragleave([ \t\r\n]+)?=', 'ondragover([ \t\r\n]+)?=', 'ondragstart([ \t\r\n]+)?=', 'ondrop([ \t\r\n]+)?=', 'onerror([ \t\r\n]+)?=', 'onerrorupdate([ \t\r\n]+)?=', 'onfilterchange([ \t\r\n]+)?=', 'onfinish([ \t\r\n]+)?=', 'onfocus([ \t\r\n]+)?=', 'onfocusin([ \t\r\n]+)?=', 'onfocusout([ \t\r\n]+)?=', 'onhelp([ \t\r\n]+)?=', 'onkeydown([ \t\r\n]+)?=', 'onkeypress([ \t\r\n]+)?=', 'onkeyup([ \t\r\n]+)?=', 'onlayoutcomplete([ \t\r\n]+)?=', 'onload([ \t\r\n]+)?=', 'onlosecapture([ \t\r\n]+)?=', 'onmousedown([ \t\r\n]+)?=', 'onmouseenter([ \t\r\n]+)?=', 'onmouseleave([ \t\r\n]+)?=', 'onmousemove([ \t\r\n]+)?=', 'onmouseout([ \t\r\n]+)?=', 'onmouseover([ \t\r\n]+)?=', 'onmouseup([ \t\r\n]+)?=', 'onmousewheel([ \t\r\n]+)?=', 'onmove([ \t\r\n]+)?=', 'onmoveend([ \t\r\n]+)?=', 'onmovestart([ \t\r\n]+)?=', 'onpaste([ \t\r\n]+)?=', 'onpropertychange([ \t\r\n]+)?=', 'onreadystatechange([ \t\r\n]+)?=', 'onreset([ \t\r\n]+)?=', 'onresize([ \t\r\n]+)?=', 'onresizeend([ \t\r\n]+)?=', 'onresizestart([ \t\r\n]+)?=', 'onrowenter([ \t\r\n]+)?=', 'onrowexit([ \t\r\n]+)?=', 'onrowsdelete([ \t\r\n]+)?=', 'onrowsinserted([ \t\r\n]+)?=', 'onscroll([ \t\r\n]+)?=', 'onselect([ \t\r\n]+)?=', 'onselectionchange([ \t\r\n]+)?=', 'onselectstart([ \t\r\n]+)?=', 'onstart([ \t\r\n]+)?=', 'onstop([ \t\r\n]+)?=', 'onsubmit([ \t\r\n]+)?=', 'onunload([ \t\r\n]+)?=');
	   $ra = array_merge($ra1, $ra2);
	   
		foreach ($ra as $tag)
		{
			$pattern = '#'.$tag.'#i';
			preg_match_all($pattern, $val, $matches);
			
			foreach ($matches[0] as $match)
				$val = str_replace($match, substr($match, 0, 2).'-'.substr($match, 2), $val);
		}
		
		return $val;
	}
	
	// Verify arrays for PHP Injections: remote file inclusion and directory browsing ../../
	function checkPHPInjection($array)
	{
		$merger = new RSFirewallMerger($array);
		$results = $merger->getArray();
		
		foreach ($results as $element => $value)
		{
			if (empty($value)) continue;
			if (!is_string($value)) continue;
			
			if (preg_match('#^https?:\/\/.*#is', $value)) return true;
			if (preg_match('#\.\/#i', $value)) return true;
		}
		return false;
	}
	
	// Verify URI for PHP Injections: remote file inclusion and directory browsing ../../
	function checkPHPInjectionURI($uri)
	{
		if (preg_match('#=https?:\/\/.*#is', $uri)) return true;
		if (preg_match('#\.\/#is', $uri)) return true;
		
		return false;
	}
	
	// Array of words containing SQL commands
	function getSQLInjectionWords()
	{
		return array('union', 'union select', 'insert', 'from', 'where', 'concat', 'into', 'cast', 'truncate', 'select', 'delete', 'having');
	}
	
	// Verify URI for SQL Injections: any SQL command that's not coming from com_search
	function checkSQLInjectionURI($uri)
	{
		$sql_injections = RSFirewallHelper::getSQLInjectionWords();
		$jconfig = new JConfig();
		$db_prefix = $jconfig->dbprefix;
		
		// Check for UNION without any other table name
		if (preg_match('#[\d\W](union select|union join|union distinct)[\d\W]#is',$uri)) return true;
		
		// Check for an SQL query in the full string
		if (preg_match('#[\d\W]('.implode('|', $sql_injections).')[\d\W]#is',$uri) && preg_match('#'.$db_prefix.'(\w+)#s',$uri) && !preg_match('#\Wsearchphrase\b#is',$uri)) return true;
		
		return false;
	}
	
	// Verify arrays for SQL Injections: any SQL command that's not coming from com_search and contains a database prefix 
	function checkSQLInjection($array)
	{
		$option = JRequest::getVar('option');
		
		$merger = new RSFirewallMerger($array);
		$results = $merger->getArray();
		
		$sql_injections = RSFirewallHelper::getSQLInjectionWords();
		$jconfig = new JConfig();
		$db_prefix = $jconfig->dbprefix;
		
		foreach ($results as $value)
		{
			if (empty($value)) continue;
			if (!is_string($value)) continue;
			
			// Check for UNION without any other table name
			if (preg_match('#[\d\W](union select|union join|union distinct)[\d\W]#is',$value)) return true;
			
			// Check for the database name and an SQL command in the value			
			if (preg_match('#[\d\W]('.implode('|', $sql_injections).')[\d\W]#is',$value) && preg_match('#'.$db_prefix.'(\w+)#s',$value) && $option != 'com_search')
				return true;
		}
		return false;
	}
	
	function removeGenerator()
	{
		if (RSFirewallHelper::getConfig('verify_generator'))
		{
			$document =& JFactory::getDocument();
			$document->setGenerator('');
		}
	}
	
	function checkActiveScannerInjections()
	{
		if (!RSFirewallHelper::getConfig('active_scanner_status')) return;
		
		$option = JRequest::getVar('option');
		
		if (RSFirewallHelper::getConfig('verify_sql'))
		{
			$sql_skip = RSFirewallHelper::getConfig('verify_sql_skip');
			if (!in_array($option, $sql_skip))
			{
				if (!empty($_SERVER['REQUEST_URI']) && RSFirewallHelper::checkSQLInjectionURI(urldecode($_SERVER['REQUEST_URI']))) RSFirewallHelper::header(403, 'Attempted SQL injection in REQUEST_URI'); // SQL Injection
				if (!empty($_GET) && RSFirewallHelper::checkSQLInjection($_GET)) RSFirewallHelper::header(403, 'Attempted SQL injection in GET'); // SQL Injection
				if (!empty($_POST) && RSFirewallHelper::checkSQLInjection($_POST)) RSFirewallHelper::header(403, 'Attempted SQL injection in POST'); // SQL Injection
				if (!empty($_REQUEST) && RSFirewallHelper::checkSQLInjection($_REQUEST)) RSFirewallHelper::header(403, 'Attempted SQL injection in REQUEST'); // SQL Injection
			}
		}
		
		if (RSFirewallHelper::getConfig('verify_php'))
		{
			$php_skip = RSFirewallHelper::getConfig('verify_php_skip');
			if (!in_array($option, $php_skip))
			{
				if (!empty($_SERVER['REQUEST_URI']) && RSFirewallHelper::checkPHPInjectionURI(urldecode($_SERVER['REQUEST_URI']))) RSFirewallHelper::header(403, 'LFI/directory traversal in REQUEST_URI'); // PHP Injection
				if (!empty($_GET) && RSFirewallHelper::checkPHPInjection($_GET)) RSFirewallHelper::header(403, 'LFI/directory traversal in GET'); // PHP Injection
				if (!empty($_POST['controller']) && RSFirewallHelper::checkPHPInjection($_POST['controller'])) RSFirewallHelper::header(403, 'LFI/directory traversal in controller (POST)'); // PHP Injection
				if (!empty($_GET['controller']) && RSFirewallHelper::checkPHPInjection($_GET['controller'])) RSFirewallHelper::header(403, 'LFI/directory traversal in controller (GET)'); // PHP Injection
				if (!empty($_REQUEST['controller']) && RSFirewallHelper::checkPHPInjection($_REQUEST['controller'])) RSFirewallHelper::header(403, 'LFI/directory traversal in controller (REQUEST)'); // PHP Injection
			}
		}
		
		if (RSFirewallHelper::getConfig('verify_js'))
		{
			$js_skip = RSFirewallHelper::getConfig('verify_js_skip');
			if (!in_array($option, $js_skip))
			{
				if (!empty($_GET) && RSFirewallHelper::checkJSInjection($_GET)) RSFirewallHelper::header(403, 'Attempted XSS in GET'); // JS Injection
			}
		}
	}
	
	function checkActiveScanner()
	{
		if (!RSFirewallHelper::getConfig('active_scanner_status')) return;
		
		if (RSFirewallHelper::getConfig('verify_js'))
		{
			$js_skip = RSFirewallHelper::getConfig('verify_js_skip');
			$option = JRequest::getVar('option');
			if (!in_array($option, $js_skip))
			{
				if (!empty($_POST)) RSFirewallHelper::checkXSSInjection('post');
				if (!empty($_GET)) RSFirewallHelper::checkXSSInjection('get');
				if (!empty($_REQUEST)) RSFirewallHelper::checkXSSInjection('request');
			}
		}
		
		
		jimport('joomla.filesystem.file');
		
		$db =& JFactory::getDBO();
		
		if (RSFirewallHelper::getConfig('verify_upload') && !empty($_FILES))
		{
			$blacklist_exts = RSFirewallHelper::explode(RSFirewallHelper::getConfig('verify_upload_blacklist_exts'));
			$log = new RSFirewallLog();
			foreach ($_FILES as $i => $file)
			{
				$filenames = RSFirewallHelper::recursive($file['name']);
				
				if (empty($filenames)) continue;
				if (!is_array($filenames)) $filenames = array($filenames);
				
				$tempfiles = RSFirewallHelper::recursive($file['tmp_name']);
				if (!is_array($tempfiles)) $tempfiles = array($tempfiles);
				
				foreach ($filenames as $i => $filename)
				{
					if (empty($filename)) continue;
					if (is_array($filename)) $filename = reset($filename);
					if (empty($filename) || is_array($filename)) continue;
					$info = pathinfo($filename);
					
					if (RSFirewallHelper::getConfig('verify_multiple_exts'))
					{
						$parts = explode('.', $filename);
						if (count($parts) > 0)
							foreach ($parts as $part)
								if (in_array($part, $blacklist_exts))
								{
									@unlink($tempfiles[$i]);
									$log->addEvent('medium', 'UPLOAD_MULTIPLE_EXTS_ERROR', $part);
									continue;
								}
					}
					
					if (in_array($info['extension'], $blacklist_exts))
					{
						@unlink($tempfiles[$i]);
						$log->addEvent('medium', 'UPLOAD_EXTENSION_ERROR', $info['extension']);
						continue;
					}
					$patterns = RSFirewallHelper::checkShellPatterns($tempfiles[$i]);
					if (!empty($patterns))
					{
						@unlink($tempfiles[$i]);
						$log->addEvent('high', 'UPLOAD_SHELL', $filename);
						continue;
					}
				}
			}
		}
		
		// check core joomla files
		$hashes = RSFirewallHelper::getCoreFiles();
		$log = new RSFirewallLog();
		if (!empty($hashes))
			foreach ($hashes as $hash)
			{
				if ($hash->flag == 'C') continue;
				$file = realpath(JPATH_SITE.DS.$hash->file);
				$db_hash = $hash->hash;
				if (JFile::exists($file))
				{
					$curr_hash = md5_file($file);
					if ($db_hash != $curr_hash)
					{
						$db->setQuery("UPDATE #__rsfirewall_hashes SET `flag`='C', `date`='".time()."' WHERE `id`='".(int)$hash->id."' LIMIT 1");
						$db->query();
						$log->addEvent('critical', 'CORE_FILES_MODIFIED', $file);
					}
				}
			}
		
		// monitor files
		$hashes = RSFirewallHelper::getProtectedFiles();
		
		$log = new RSFirewallLog();
		if (!empty($hashes))
			foreach ($hashes as $hash)
			{
				if ($hash->flag == 'C') continue;
				$file = realpath($hash->file);
				$db_hash = $hash->hash;
				if (JFile::exists($file))
				{
					$curr_hash = md5_file($file);
					if ($db_hash != $curr_hash)
					{
						$db->setQuery("UPDATE #__rsfirewall_hashes SET `flag`='C', `date`='".time()."' WHERE `id`='".(int)$hash->id."' LIMIT 1");
						$db->query();
						$log->addEvent('critical', 'PROTECTED_FILES_MODIFIED', $file);
					}
				}
			}
		
		// protect users
		$users = RSFirewallHelper::getConfig('monitor_users');
		if (!empty($users))
		{
			$snapshots = RSFirewallHelper::getUsersSnapshot('protect');
			foreach ($users as $user_id)
			{
				if (!array_key_exists($user_id, $snapshots)) continue;
				$user = JUser::getInstance($user_id);
				$snapshot = $snapshots[$user_id];
				
				if (!RSFirewallHelper::checkSnapshot($user, $snapshot))
					RSFirewallHelper::replaceFromSnapshot($snapshot);
			}
		}
	}
	
	function getUsersSnapshot($type='protect')
	{
		$db =& JFactory::getDBO();
		$type = $db->getEscaped($type);
		$db->setQuery("SELECT * FROM #__rsfirewall_snapshots WHERE `type`='".$type."'");
		$result = $db->loadObjectList();
		$return = array();
		
		if (!empty($result))
		foreach ($result as $user)
			$return[$user->user_id] = unserialize(base64_decode($user->snapshot));
		
		return $return;
	}
	
	function createSnapshot($user)
	{
		$db =& JFactory::getDBO();
		$snapshot = new stdClass();
		$snapshot->adjacent = array();
		
		if (RSFirewallHelper::isJ16())
		{
			// #__users
			$snapshot->user_id = $user->id;
			$snapshot->name = $user->name;
			$snapshot->username = $user->username;
			$snapshot->email = $user->email;
			$snapshot->password = $user->password;
			$snapshot->usertype = $user->usertype;
			$snapshot->block = $user->block;
			$snapshot->sendEmail = $user->sendEmail;
			$snapshot->params = $user->params;
			
			// #__user_usergroup_map
			$db->setQuery("SELECT * FROM #__user_usergroup_map WHERE user_id='".(int) $user->id."'");
			$snapshot->adjacent['user_usergroup_map'] = $db->loadObject();
		}
		else
		{
			// #__users
			$snapshot->user_id = $user->id;
			$snapshot->name = $user->name;
			$snapshot->username = $user->username;
			$snapshot->email = $user->email;
			$snapshot->password = $user->password;
			$snapshot->usertype = $user->usertype;
			$snapshot->block = $user->block;
			$snapshot->sendEmail = $user->sendEmail;
			$snapshot->gid = $user->gid;
			$snapshot->params = $user->params;
		
			// #__core_acl_aro
			$db->setQuery("SELECT * FROM #__core_acl_aro WHERE `section_value`='users' AND `value`='".(int) $user->id."'");
			$snapshot->adjacent['core_acl_aro'] = $db->loadObject();
			
			// #__core_acl_groups_aro_map
			$db->setQuery("SELECT * FROM #__core_acl_groups_aro_map WHERE `aro_id`='".((int) $snapshot->adjacent['core_acl_aro']->id)."'");
			$snapshot->adjacent['core_acl_groups_aro_map'] = $db->loadObject();
		}
		
		$snapshot = base64_encode(serialize($snapshot));
		
		return $snapshot;
	}
	
	function checkSnapshot($current, $snapshot)
	{		
		foreach ($snapshot as $key => $value)
		{
			if ($key == 'user_id') continue;
			if ($key == 'adjacent') continue;
			if ($current->$key != $value)
				return false;
		}
		
		return true;
	}
	
	function replaceFromSnapshot($snapshot)
	{
		$db = JFactory::getDBO();
		$gid_query = '';
		if (!RSFirewallHelper::isJ16())
			$gid_query = ", `gid`='".(int) $snapshot->gid."'";
		$db->setQuery("REPLACE INTO #__users SET `id`='".(int) $snapshot->user_id."', `name`='".$db->getEscaped($snapshot->name)."', `username`='".$db->getEscaped($snapshot->username)."', `email`='".$db->getEscaped($snapshot->email)."', `password`='".$db->getEscaped($snapshot->password)."', `usertype`='".$db->getEscaped($snapshot->usertype)."', `block`='".(int) $snapshot->block."', `sendEmail`='".(int) $snapshot->sendEmail."', `params`='".$db->getEscaped($snapshot->params)."'".$gid_query);
		$db->query();
		
		if (!empty($snapshot->adjacent))
			foreach ($snapshot->adjacent as $adjacent_table => $values)
			{
				$query = "REPLACE INTO #__".$adjacent_table." SET ";
				foreach ($values as $key => $value)
					$query .= " `".$db->getEscaped($key)."`='".$db->getEscaped($value)."',";
				$query = rtrim($query, ',');
				$db->setQuery($query);
				$db->query();
			}
	}
	
	function checkLockdown()
	{
		if (!RSFirewallHelper::getConfig('lockdown')) return;
		
		$option = JRequest::getVar('option');
		// Joomla! updater should be working
		if (RSFirewallHelper::isJ16() && $option == 'com_installer' && JRequest::getVar('task') == 'update.ajax') return;
		if ($option == 'com_installer' || ($option == 'com_akeeba' && JRequest::getVar('view') == 'installer')) RSFirewallHelper::header(403, 'You are not allowed to use &quot;com_installer&quot; during lockdown mode.', false); // Lockdown - no new extensions
		
		$db =& JFactory::getDBO();
		$users = array();
		$snapshots = RSFirewallHelper::getUsersSnapshot('lockdown');
		foreach ($snapshots as $user_id => $snapshot)
		{
			$users[] = $user_id;
			if (!array_key_exists($user_id, $snapshots)) continue;
			$user = JUser::getInstance($user_id);
			$snapshot = $snapshots[$user_id];
				
			if (!RSFirewallHelper::checkSnapshot($user, $snapshot))
				RSFirewallHelper::replaceFromSnapshot($snapshot);
		}
		if (count($users))
		{
			if (RSFirewallHelper::isJ16())
			{
				$groups = RSFirewallHelper::getAdminGroups();
				$db->setQuery("DELETE FROM #__users WHERE `id` IN (SELECT user_id FROM #__user_usergroup_map WHERE user_id NOT IN (".implode(',', $users).") AND group_id IN (".implode(',', $groups)."))");
				$db->query();
			}
			else
			{
				$db->setQuery("DELETE FROM #__users WHERE `id` NOT IN (".implode(',', $users).") AND `gid` > 22");
				$db->query();
			}
		}
	}
	
	function checkLogHistory()
	{
		$log_history = (int) RSFirewallHelper::getConfig('log_history');
		if ($log_history == 0)
			$log_history = 30;
		
		$db =& JFactory::getDBO();
		$db->setQuery("DELETE FROM #__rsfirewall_logs WHERE `date`+'".($log_history*24*60*60)."'<='".time()."'");
		$db->query();
	}	
	
	function getCoreFiles()
	{
		$db =& JFactory::getDBO();
		$jversion = new JVersion();
		$jv = $jversion->getShortVersion();
		$db->setQuery("SELECT * FROM #__rsfirewall_hashes WHERE `type`='".$db->getEscaped($jv)."'");
		$db->query();
		return $db->loadObjectList();
	}
	
	function getProtectedFiles()
	{
		$db =& JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__rsfirewall_hashes WHERE `type`='protect'");
		$db->query();
		return $db->loadObjectList();
	}
	
	function getIgnoredFiles()
	{
		$db =& JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__rsfirewall_hashes WHERE `type`='ignore'");
		$db->query();
		return $db->loadObjectList();
	}
	
	function getOptionalFiles()
	{
		return array(
			'administrator/components/com_banners/',
			'administrator/components/com_newsfeeds/',
			'administrator/components/com_poll/',
			'administrator/components/com_weblinks/',
			'administrator/modules/mod_latest/',
			'administrator/modules/mod_logged/',
			'administrator/modules/mod_menu/',
			'administrator/modules/mod_popular/',
			'administrator/modules/mod_stats/',
			'administrator/modules/mod_status/',
			'administrator/modules/mod_submenu/',
			'administrator/modules/mod_title/',
			'administrator/templates/khepri/',
			'administrator/templates/bluestork/',
			'administrator/templates/hathor/',
			'components/com_banners/',
			'components/com_newsfeeds/',
			'components/com_poll/',
			'components/com_weblinks/',
			'modules/mod_breadcrumbs/',
			'modules/mod_login/',
			'templates/ja_purity/',
			'templates/rhuk_milkyway/',
			'templates/beez/',
			'templates/atomic/',
			'templates/beez5/',
			'templates/beez_20/'
		);
	}
	
	function recursive($array)
	{
		$return = array();
		if (is_array($array))
			foreach ($array as $item)
				$return[] = RSFirewallHelper::recursive($item);
		else
			$return = $array;
		
		return $return;
	}
	
	function header($code=200, $msg='', $count_autoban=true)
	{
		switch ($code)
		{
			case 200:
			header('HTTP/1.1 200 OK');
			echo $code;
			break;
			
			case 301:
			header('HTTP/1.1 301 Moved Permanently');
			echo $code;
			break;
			
			case 500:
			header('HTTP/1.1 500 Internal Server Error');
			echo $code;
			break;
			
			case 403:
			header('HTTP/1.1 403 Forbidden');
			include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'assets'.DS.'headers'.DS.$code.'.php');
			
			if ($count_autoban) {
				// extra logging
				if (RSFirewallHelper::getConfig('enable_extra_logging')) {
					$log = new RSFirewallLog();
					$log->addEvent('low', $msg);
				}
				
				// counting autoban
				if (RSFirewallHelper::getConfig('enable_autoban')) {
					RSFirewallHelper::countAutoban();
				}
			}
			
			break;
			
			case 404:
			header('HTTP/1.1 404 Not Found');
			echo $code;
			break;
		}
		die();
	}
	
	function countAutoban($reason='')
	{
		$db 	= &JFactory::getDBO();
		$ip		= RSFirewallHelper::getIP(true);
		$date 	= &JFactory::getDate();
		$db->setQuery("INSERT INTO #__rsfirewall_offenders SET `ip`='".$db->getEscaped($ip)."', `date`='".$db->getEscaped($date->toMySQL())."'");
		$db->query();
		
		if (!$reason)
			$reason = 'Repeat offender (Autobanned)';
		
		$db->setQuery("SELECT COUNT(id) FROM #__rsfirewall_offenders WHERE `ip`='".$db->getEscaped($ip)."'");
		if ($db->loadResult() >= RSFirewallHelper::getConfig('autoban_attempts'))
		{
			$db->setQuery("DELETE FROM #__rsfirewall_offenders WHERE `ip`='".$db->getEscaped($ip)."'");
			$db->query();
			$db->setQuery("INSERT INTO #__rsfirewall_lists SET `ip`='".$db->getEscaped($ip)."', `type`='0', `published`='1', `date`='".$db->getEscaped($date->toMySQL())."', `reason`='".$db->getEscaped($reason)."'");
			$db->query();
		}
	}
	
	function isMasterLogged()
	{
		if (RSFirewallHelper::getConfig('master_password_enabled') == 0 || strlen(RSFirewallHelper::getConfig('master_password')) != 32)
			return true;
		$session =& JFactory::getSession();
		return $session->get('rsfirewall_master_logged', false);
	}
	
	function isBackendLogged()
	{
		$session =& JFactory::getSession();
		return $session->get('rsfirewall_backend_logged', false);
	}
	
	function getAlertLevelsArray()
	{
		return array('low', 'medium', 'high', 'critical');
	}
	
	function getAlertLevels()
	{
		$levels = array();
		
		$level = new stdClass();
		$level->value = 'low';
		$level->text = JText::_('RSF_LOW');
		$levels[] = $level;
		
		$level = new stdClass();
		$level->value = 'medium';
		$level->text = JText::_('RSF_MEDIUM');
		$levels[] = $level;
		
		$level = new stdClass();
		$level->value = 'high';
		$level->text = JText::_('RSF_HIGH');
		$levels[] = $level;
		
		$level = new stdClass();
		$level->value = 'critical';
		$level->text = JText::_('RSF_CRITICAL');
		$levels[] = $level;
		
		return $levels;
	}
	
	function is_ip($ip)
	{
		if (strpos($ip, '*') !== false)
		{
			$ip = explode('.', $ip);
			if (count($ip) != 4) return false;
			foreach ($ip as $i => $part)
			{
				if ($part == '*' || strpos($part, '*') !== false)
				{
					$ip[$i] = '*';
					continue;
				}
				if ($part < 0 || $part > 255)
					return false;
			}
			return true;
		}
		else
		{
			$pattern = '/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/';
			return (preg_match($pattern, $ip) == 1);
		}
	}
	
	function ip_in($needle, $haystack)
	{
		if ($needle == $haystack) return true;
		if (strpos($haystack, '*') === false) return false;
		
		$haystack = explode('.', $haystack);
		$needle = explode('.', $needle);
		
		foreach ($haystack as $i => $fragment)
			if ($fragment != '*' && $fragment != $needle[$i])
				return false;
		
		return true;
	}
	
	function is_email($email)
	{
		jimport('joomla.mail.helper');
		return JMailHelper::isEmailAddress($email);
	}
	
	/**
	 * Open a connection through several methods
	*/
	function fopen($url)
	{
		$url_info = parse_url($url);

		$data = false;

		// cURL
		if (extension_loaded('curl'))
		{
			// Init cURL
			$ch = @curl_init();
			
			// Set options
			@curl_setopt($ch, CURLOPT_URL, $url);
			@curl_setopt($ch, CURLOPT_HEADER, 0);
			@curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			// Set timeout
			@curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			
			// Grab data
			$data = @curl_exec($ch);
			
			// Clean up
			@curl_close($ch);
			
			// Return data
			if ($data !== false)
				return $data;
		}

		// fsockopen
		if (function_exists('fsockopen'))
		{
			$errno = 0;
			$errstr = '';

			// Set timeout
			$fsock = @fsockopen($url_info['host'], 80, $errno, $errstr, 5);

			if ($fsock)
			{
				@fputs($fsock, 'GET '.$url_info['path'].(!empty($url_info['query']) ? '?'.$url_info['query'] : '').' HTTP/1.1'."\r\n");
				@fputs($fsock, 'HOST: '.$url_info['host']."\r\n");
				@fputs($fsock, 'Connection: close'."\r\n\r\n");

				// Set timeout
				@stream_set_blocking($fsock, 1);
				@stream_set_timeout($fsock, 5);
				
				$data = '';
				$passed_header = false;
				while (!@feof($fsock))
				{
					if ($passed_header)
						$data .= @fread($fsock, 1024);
					else
					{
						if (@fgets($fsock, 1024) == "\r\n")
							$passed_header = true;
					}
				}
				
				// Clean up
				@fclose($fsock);
				
				// Return data
				if ($data !== false)
					return $data;
			}
		}

		// fopen
		if (function_exists('fopen') && ini_get('allow_url_fopen'))
		{
			// Set timeout
			if (ini_get('default_socket_timeout') < 5)
				ini_set('default_socket_timeout', 5);
			@stream_set_blocking($handle, 1);
			@stream_set_timeout($handle, 5);
			
			$handle = @fopen ($url, 'r');
			
			if ($handle)
			{
				$data = '';
				while (!feof($handle))
					$data .= @fread($handle, 8192);
			
				// Clean up
				@fclose($handle);
			
				// Return data
				if ($data !== false)
					return $data;
			}
		}
						
		// file_get_contents
		if(function_exists('file_get_contents') && ini_get('allow_url_fopen'))
		{
			$data = @file_get_contents($url);
			
			// Return data
			if ($data !== false)
				return $data;
		}

		return $data;
	}
	 
	function checkJavascriptPatterns($file)
	{
		if (!is_file($file) || !is_readable($file)) return false;
		$lines = file($file);
		$return = array();
		foreach ($lines as $i => $line)
		{
			$line = trim($line);
			if ((preg_match('#<[^>]*script*"?[^>]*>#is', $line)) || (preg_match('#<[^>]*object*"?[^>]*>#is', $line)) || (preg_match('#<[^>]*iframe*"?[^>]*>#is', $line)) || (preg_match('#<[^>]*applet*"?[^>]*>#is', $line)))
				$return[] = array('i' => $i, 'line' => htmlspecialchars($line));
		}
		
		return $return;
	}
	
	function checkShellPatterns($file)
	{
		$return = array();
		if (!is_file($file) || !is_readable($file) || $file == __FILE__) return $return;
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT name FROM #__rsfirewall_patterns WHERE type='file'");
		$shells = $db->loadResultArray();
		
		$lines = file($file);
		foreach ($lines as $i => $line)
		{
			$line = trim($line);
			foreach ($shells as $shell)
				if (strpos($line, $shell) !== false)
					$return[] = array('i' => $i, 'line' => htmlspecialchars($line));
				
			//if (preg_match('#<\?(php)?([ \t\r\n]+)#is', $line))
			//	$return[] = array('i' => $i, 'line' => htmlspecialchars($line));
		}
		return $return;
	}
	
	function checkPatternsInFilename($file)
	{
		$db = JFactory::getDBO();
		$db->setQuery("SELECT name FROM #__rsfirewall_patterns WHERE type='filename'");
		$_patterns = '('.implode('|', $db->loadResultArray()).')';
		
		preg_match($_patterns, basename($file), $matches);
		$pattern = count($matches) > 0 ? $matches[0] : '';
		
		return $pattern;
	}
	
	function checkLoginAttempts()
	{
		$mainframe =& JFactory::getApplication();
		if (!$mainframe->isAdmin()) return;
		if (!RSFirewallHelper::getConfig('active_scanner_status')) return;
		
		$task = JRequest::getVar('task', '');
		if ($task == 'rsfirewall_captcha')
		{
			$captcha = new RSFirewallCaptcha();
			$captcha->generate_image(80,45,4,1,1);
			die();
		}
		
		$post = JRequest::get('post', JREQUEST_ALLOWRAW);
		if (empty($post['option']) || $post['option'] != 'com_login') return;
		if (empty($post['username']) || empty($post['passwd'])) return;
		
		if (RSFirewallHelper::getConfig('enable_backend_captcha')) 
		{
			$session =& JFactory::getSession();
			$captcha = $session->get('rsfirewall_captcha');
			$attempts = $session->get('rsfirewall_attempts', 0);
			if ($attempts >= RSFirewallHelper::getConfig('backend_captcha'))
			{
				if (empty($post['captcha']) || empty($captcha) || strtolower($post['captcha']) != strtolower($captcha))
				{
					JRequest::setVar('passwd', '');
					$lang = JFactory::getLanguage();
					$lang->load('com_rsfirewall');
					JError::raiseWarning(500, JText::_('RSF_PLEASE_CAPTCHA_ERROR'));
				}
			}
		}
		
		$username = $post['username'];
		$password = $post['passwd'];
		
		$db =& JFactory::getDBO();
		$db->setQuery("SELECT `password` FROM `#__users` WHERE `username` LIKE '".$db->getEscaped($username)."'");
		$db_password = $db->loadResult();
		$log = new RSFirewallLog();
		
		// the username was not found in the database, log this as a possible hack attempt
		if (!$db_password)
		{
			$log->addEvent('medium', 'BACKEND_LOGIN_ATTEMPT_UNKNOWN', 'username='.$username."\n".'password='.$password);
			if (RSFirewallHelper::getConfig('enable_autoban_login') && RSFirewallHelper::getConfig('enable_autoban'))
				RSFirewallHelper::countAutoban('Too many login attempts (Autobanned)');
		}
		else
		{
			jimport('joomla.user.helper');
			$parts	= explode(':', $db_password);
			$crypt	= $parts[0];
			$salt	= @$parts[1];
			$testcrypt = JUserHelper::getCryptedPassword($password, $salt);
			// the username was found but the password is incorrect, log this as a possible hack attempt
			if ($crypt != $testcrypt)
			{
				$log->addEvent('high', 'BACKEND_LOGIN_ATTEMPT_KNOWN', 'username='.$username."\n".'password='.$password);
				if (RSFirewallHelper::getConfig('enable_autoban_login') && RSFirewallHelper::getConfig('enable_autoban'))
					RSFirewallHelper::countAutoban('Too many login attempts (Autobanned)');
			}
			elseif (RSFirewallHelper::getConfig('enable_backend_captcha')) 
				$session->set('rsfirewall_attempts', -1);
		}
		if (RSFirewallHelper::getConfig('enable_backend_captcha')) 
		{
			$attempts += 1;
			$session->set('rsfirewall_attempts', $attempts);
		}
	}
	
	function showPasswordStrength()
	{
		$mainframe =& JFactory::getApplication();
		$option = JRequest::getVar('option');
		if (!$mainframe->isAdmin()) return;
		
		if ($option != 'com_users') return;
		
		$text =& JResponse::getBody();
		$input = '<input class="inputbox" type="password" name="password" id="password" size="40" value=""/>';
		
		if (RSFirewallHelper::isJ16())
			$input = '<input type="password" name="jform[password]" id="jform_password" value="" autocomplete="off" class="inputbox" size="30"/>';
		
		$inputonkey = str_replace('/>', ' onkeyup="rsfirewall_strength(this.value)" />', $input);
		
		$strength = JText::_('RSF_PASSWORD_STRENGTH', true);
		$info = JText::_('RSF_PASSWORD_INFO', true);
		$type = JText::_('RSF_PLEASE_TYPE', true);
		$strong = JText::_('RSF_STRONG', true);
		$medium = JText::_('RSF_MEDIUM', true);
		$weak = JText::_('RSF_WEAK', true);
		$more = JText::_('RSF_MORE_CHARACTERS', true);
		
		$js = 
<<<END
		<script type="text/javascript">
		function rsfirewall_strength(value)
		{
			var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\\W).*$", "g");
			var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
			var enoughRegex = new RegExp("(?=.{6,}).*", "g");
			
			if (value.length==0)
				message = '$type';
			else if (false == enoughRegex.test(value))
				message = '$more';
			else if (strongRegex.test(value))
				message = '<span style="color:green">$strong</span>';
			else if (mediumRegex.test(value))
				message = '<span style="color:orange">$medium</span>';
			else
				message = '<span style="color:red">$weak</span>';
			
			$('rsfirewall_strength_message').innerHTML = message;
		}
		</script>
END;
		
		$newinput = $js.$inputonkey.'</td></tr>
		<tr>
		<td class="key">'.$strength.'</td>
		<td><span id="rsfirewall_strength_message">'.$info.'</span>';
		
		if (RSFirewallHelper::isJ16())
		{
			$newinput = $js.$inputonkey.'</li>
			<li>
			<label>'.$strength.'</label>
			<span style="float: left" id="rsfirewall_strength_message">'.$info.'</span>';
		}
		
		$text = str_replace($input, $newinput, $text);
		
		JResponse::setBody($text);
	}
	
	function showCaptcha()
	{
		$mainframe =& JFactory::getApplication();
		$option = JRequest::getVar('option');
		if (!$mainframe->isAdmin()) return;
		if ($option != 'com_login') return;
		
		$session =& JFactory::getSession();
		$attempts = $session->get('rsfirewall_attempts', 0);
		
		if (RSFirewallHelper::isInWhiteList()) return;
		if ($attempts < RSFirewallHelper::getConfig('backend_captcha')) return;
		
		$lang = JFactory::getLanguage();
		$lang->load('com_rsfirewall');
		$please = JText::_('RSF_PLEASE_CAPTCHA');
		
		$replace = '<p id="form-login-lang" style="clear: both;">';
		if (RSFirewallHelper::isJ16())
			$replace = '<fieldset class="loginform">';
		$with = 
<<<END
<p id="">
<label for="modlgn_captcha">&nbsp;</label>
<img src="index.php?option=com_rsfirewall&task=rsfirewall_captcha" alt="" style="margin-left: 10px" />
</p>
<p id="form-login-captcha">
<label for="modlgn_captcha">$please</label>
<input name="captcha" id="modlgn_captcha" type="text" class="inputbox" size="15" />
</p>
<p id="form-login-lang" style="clear: both;">
END;
	
		$original_text =& JResponse::getBody();
		$text = str_replace($replace, $with, $original_text);
		
		if ($text == $original_text) // no change has happened, captcha won't be able to show
		{
			JError::raiseWarning(500, JText::_('RSF_CAPTCHA_HAS_BEEN_DISABLED_INCOMPATIBLE'));
			$db =& JFactory::getDBO();
			$db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='enable_backend_captcha'");
			$db->query();
		}
		
		JResponse::setBody($text);
	}
	
	function isIE()
	{
		if (!empty($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7') !== false))
			return true;
		else
			return false;
	}
	
	function isInWhiteList($ip=null)
	{
		static $cache;
		
		if (is_null($ip))
			$ip = RSFirewallHelper::getIP(true);
		
		if (!isset($cache[$ip]))
		{
			$cache[$ip] = 0;
			$db =& JFactory::getDBO();			
			$db->setQuery("SELECT `ip` FROM #__rsfirewall_lists WHERE (`ip`=".$db->quote($ip)." OR `ip` LIKE ".$db->quote('%*%').") AND `type`=".$db->quote(1)." AND `published`=".$db->quote(1));
			$whitelist_ips = $db->loadResultArray();
			foreach ($whitelist_ips as $whitelist_ip)
				if ($whitelist_ip && RSFirewallHelper::ip_in($ip, $whitelist_ip))
				{
					$cache[$ip] = 1;
					break;
				}
			
			$cache[$ip] = $db->loadResult();
		}
		
		return $cache[$ip];
	}
	
	function getGeoIPDB()
	{
		return JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'assets'.DS.'geoip'.DS.'GeoIP.dat';
	}
	
	function checkGeoIPBlocking()
	{
		$code 				= '';
		$ip   				= RSFirewallHelper::getIP(true);
		$blocked_countries 	= RSFirewallHelper::getConfig('blocked_countries');
		$session 			= &JFactory::getSession();
		
		// no countries blocked, no need to continue logic
		if (empty($blocked_countries))
			return;
		
		// result already cached in the session so grab it to avoid reparsing the database
		if ($session->get('com_rsfirewall.geoip'))
			$code = $session->get('com_rsfirewall.geoip');
		// not in cache
		else
		{
			// detect if there's a built-in function
			if (!function_exists('geoip_database_info')) // check for this function since it's not in the wrapper
			{
				$file = RSFirewallHelper::getGeoIPDB();
				// do we have our database?
				if (file_exists($file))
				{
					// load our own wrapper functions
					require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'helpers'.DS.'geoip.php';
					// open database
					if ($handle = rsfirewall_geoip_open($file, RSF_GEOIP_STANDARD))
						$code = rsfirewall_geoip_country_code_by_addr($handle, $ip); // ... and match ip
				}
			}
			// use the built in functions if available
			else
			{
				$code = geoip_country_code_by_name($ip);
			}
			
			$session->set('com_rsfirewall.geoip', $code);
		}
		
		if ($code != '' && in_array($code, $blocked_countries))
			RSFirewallHelper::header(403, 'Your country ('.$code.') has been blacklisted.', false); // blacklist
	}
}

class RSFirewallLog
{
	var $_db = null;
	var $_emails = null;
	var $level = 'low';
	var $date = null;
	var $ip = null;
	var $userid = 0;
	var $username = null;
	var $page = null;
	var $code = 1;
	var $debug_variables = null;
	
	var $mailfrom = null;
	var $fromname = null;
	
	var $config = null;
	
	var $root = null;
	
	function RSFirewallLog()
	{
		$lang =& JFactory::getLanguage();
		$lang->load('com_rsfirewall', JPATH_ADMINISTRATOR);
		
		// Create the JDatabase Object
		$this->_db =& JFactory::getDBO();
		
		// Get emails to be notified
		$this->config = RSFirewallHelper::getConfig();
		$this->_emails = explode("\n",$this->config->log_emails);
		
		// Set current time in unix format
		$this->date = time();
		
		// Set the client's IP address
		$this->ip = RSFirewallHelper::getIP(true);
		
		// Set the current user's id
		$user =& JFactory::getUser();
		$this->userid = $user->id;
		
		$this->username = $user->username;
		
		// Set the current page
		$this->page = JRequest::getURI();
		
		$jconfig = new JConfig();
		
		$this->mailfrom = $jconfig->mailfrom;
		$this->fromname = $jconfig->fromname;
		
		$this->root = JURI::root();
	}
	
	function addEvent($level='low', $code=1, $debug_variables=null)
	{
		$this->level = $level;
		$this->code = $code;
		$this->debug_variables = $debug_variables;
		
		$this->saveEvent();
	}
	
	function saveEvent()
	{
		$q = "INSERT INTO #__rsfirewall_logs SET `level`='".$this->_db->getEscaped($this->level)."', `date`='".$this->_db->getEscaped($this->date)."', `ip`='".$this->_db->getEscaped($this->ip)."', `userid`='".(int) $this->userid."', `username`='".$this->_db->getEscaped($this->username)."', `page`='".$this->_db->getEscaped(htmlentities($this->page, ENT_COMPAT, 'utf-8'))."', `code`='".$this->_db->getEscaped($this->code)."', `debug_variables`='".$this->_db->getEscaped(htmlentities($this->debug_variables, ENT_COMPAT, 'utf-8'))."'";
		$this->_db->setQuery($q);
		$this->_db->query();
		
		if (array_search($this->level, RSFirewallHelper::getAlertLevelsArray()) >= array_search($this->config->log_alert_level, RSFirewallHelper::getAlertLevelsArray()))
			$this->sendAlert();
		
		return $this->_db->insertid();
	}
	
	function sendAlert()
	{
		$subject = '['.JText::_('RSF_'.strtoupper($this->level)).'] RSFirewall! for '.$this->root;
		
		$body  = '<p>'.JText::_('RSF_WEBSITE').': <strong><a href="'.$this->root.'">'.$this->root.'</a></strong></p>';
		$body .= '<p>'.JText::_('RSF_PAGE').': <strong>'.$this->page.'</strong></p>';
		$body .= '<p>'.JText::_('RSF_DESCRIPTION').': <strong>'.JText::_('RSF_EVENT_'.$this->code).'</strong></p>';
		$body .= '<p>'.JText::_('RSF_ALERT_LEVEL').': <strong>'.JText::_('RSF_'.strtoupper($this->level)).'</strong></p>';
		$body .= '<p>'.JText::_('RSF_DATE_EVENT').': <strong>'.date('d.m.Y H:i:s',$this->date).'</strong></p>';
		$body .= '<p>'.JText::_('RSF_USERIP').': <strong>'.$this->ip.'</strong></p>';
		$body .= '<p>'.JText::_('RSF_USERID').': <strong>'.$this->userid.'</strong></p>';
		$body .= '<p>'.JText::_('RSF_USERNAME').': <strong>'.$this->username.'</strong></p>';
		$body .= '<hr />';
		$body .= '<small>'.JText::_('RSF_EMAIL_NOTICE').'</small>';
		
		// sent so far
		$sent = (int) RSFirewallHelper::getConfig('log_emails_count');
		// limit per hour
		$limit = RSFirewallHelper::getConfig('log_hour_limit');
		// after the hour we're allowed to send
		$after = RSFirewallHelper::getConfig('log_emails_send_after');
		// the start of the current hour
		$start = gmmktime(gmdate('H'), 0, 0, gmdate('n'), gmdate('j'), gmdate('Y'));
		// now
		$now   = gmmktime();
		
		// are we allowed to send?
		if ($now > $after)
		{
			// do we have emails set?
			if (count($this->_emails) > 0 || !empty($this->_emails))
			{
				// loop through emails and attempt sending
				foreach ($this->_emails as $email)
				{
					$email = trim($email);
					if (RSFirewallHelper::is_email($email) && $sent < $limit)
					{
						JUtility::sendMail($this->mailfrom, $this->fromname, $email, $subject, $body, true);
						// increment number of sent emails
						$sent++;
					}
				}
				
				// reached the limit?
				if ($sent >= $limit)
				{
					// allow to send in the next hour
					$next_after = gmmktime(gmdate('H')+1, 0, 0, gmdate('n'), gmdate('j'), gmdate('Y'));
					$this->_db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".$next_after."' WHERE `name`='log_emails_send_after'");
					$this->_db->query();
					$this->_db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='log_emails_count'");
					$this->_db->query();
				}
				else
				{
					// we've sent emails this time, update the email count
					$this->_db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".$sent."' WHERE `name`='log_emails_count'");
					$this->_db->query();
				}
				
				// force reload the configuration since we've modified it
				RSFirewallHelper::readConfig(true);
			}
		}
	}
}

class RSFirewallMerger
{
	var $_array = array();
	
	function __construct($array)
	{
		$this->recursive($array);
	}
	
	function recursive($array)
	{
		if (is_array($array))
			foreach ($array as $item)
				$this->recursive($item);
		else
		{
			if (!is_bool($array) && !is_null($array) && !is_object($array) && !is_resource($array))
				$this->_array[] = $array;
		}
	}
	
	function getArray()
	{
		return $this->_array;
	}
}

class RSFirewallCaptcha
{
	function generate_font()
	{
		$font = '/components/com_rsfirewall/assets/fonts/monofont.ttf';
		return $font;
	}
	
	function generate_code($chars=6)
	{
		$possible = 'bBcCdDfFgGhHjJkKmMnNpPqQrRsStTvVwWxXyYzZ23456789';
		$count = strlen($possible) - 1;
		$code = '';
		for ($i=0;$i<$chars;$i++)
			$code .= substr($possible, mt_rand(0, $count), 1);
		
		$session =& JFactory::getSession();
		$session->set('rsfirewall_captcha', $code);
		return $code;
	}
	
	function generate_image($width,$height,$chars=6,$dots=1,$lines=1)
	{
		$root = JURI::root();
		
		if(!function_exists('imagecreate'))
		{
			header('Location:'.$root.'/img/nogd.gif');
			exit();
		}
		
		if(!function_exists('imagettfbbox'))
		{
			header('Location:'.$root.'/img/nofreetype.gif');
			exit();
		}
		
		$code = $this->generate_code($chars);
		$font = $this->generate_font();
		
		$font_size = $height * 0.80;
		$image = @imagecreate($width, $height) or die('imagecreate() function error');
		
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 0, 50, 50);
		$noise_color = imagecolorallocate($image, 0, 10, 38);
		
		if ($dots == 1)
			for ($i=0; $i<($width*$height)/3; $i++)
				imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		
		if ($lines == 1)
			for ($i=0; $i<($width*$height)/150; $i++)
				imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		
		$textbox = imagettfbbox($font_size, 0, JPATH_SITE.$font, $code) or die('imagettfbbox() function error');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, JPATH_SITE.$font, $code) or die('imagettftext() function error');
		
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
}
?>