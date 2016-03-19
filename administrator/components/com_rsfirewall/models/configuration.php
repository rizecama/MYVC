<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelConfiguration extends JModel
{
	var $_log = null;
	
	function __construct()
	{
		parent::__construct();
		$this->_log = new RSFirewallLog();
	}
	
	function getAlertLevels()
	{
		return RSFirewallHelper::getAlertLevels();
	}
	
	function getAlertLevelsArray()
	{
		return RSFirewallHelper::getAlertLevelsArray();
	}
	
	function getConfiguration()
	{
		return RSFirewallHelper::getConfig();
	}
	
	function getUsers()
	{
		return RSFirewallHelper::getAdminUsers();
	}
	
	function getComponents()
	{
		return RSFirewallHelper::getComponents();
	}
	
	function getModules()
	{
		$query = "SELECT DISTINCT(module) FROM #__modules ORDER BY module ASC";
		
		return $this->_getList($query);
	}
	
	function getPlugins()
	{
		$query = "SELECT element, folder FROM #__plugins ORDER BY folder ASC";
		
		return $this->_getList($query);
	}
	
	function save()
	{
		$msg = '';
		$link = '';
		$config = RSFirewallHelper::getConfig();
		
		$post = JRequest::get('post', JREQUEST_ALLOWRAW);
		
		if (isset($post['enable_extra_logging'])) {
			$this->_db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".(int) $post['enable_extra_logging']."' WHERE `name`='enable_extra_logging'");
			$this->_db->query();
		}
		
		if (isset($post['master_password_enabled']))
		{
			if ($post['master_password_enabled'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='master_password_enabled'";
				$level = 'high';
				$code = 'MASTER_PASSWORD_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='master_password_enabled'";
				$level = 'low';
				$code = 'MASTER_PASSWORD_ENABLED';
			}
			
			if ($post['master_password_enabled'] != $config->master_password_enabled)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['master_password']))
		{
			if (strlen($post['master_password']) > 0 && strlen($post['master_password']) < 6)
				JError::raiseWarning(500, JText::_('RSF_MASTER_PASSWORD_ERROR'));
				
			if (strlen($post['master_password']) >= 6 && md5($post['master_password']) != $config->master_password)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".md5($post['master_password'])."' WHERE `name`='master_password'";
				$level = 'high';
				$code = 'MASTER_PASSWORD_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['global_register_code']))
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['global_register_code']."' WHERE `name`='global_register_code'";
			$this->_db->setQuery($query);
			$this->_db->query();
		}
		
		if (isset($post['active_scanner_status']))
		{
			if ($post['active_scanner_status'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='active_scanner_status'";
				$level = 'high';
				$code = 'ACTIVE_SCANNER_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='active_scanner_status'";
				$level = 'low';
				$code = 'ACTIVE_SCANNER_ENABLED';
			}
			
			if ($post['active_scanner_status'] != $config->active_scanner_status)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_generator']))
		{
			if ($post['verify_generator'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_generator'";
				$level = 'low';
				$code = 'VERIFY_GENERATOR_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_generator'";
				$level = 'low';
				$code = 'VERIFY_GENERATOR_ENABLED';
			}
			
			if ($post['verify_generator'] != $config->verify_generator)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_emails']))
		{
			if ($post['verify_emails'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_emails'";
				$level = 'low';
				$code = 'VERIFY_GENERATOR_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_emails'";
				$level = 'low';
				$code = 'VERIFY_GENERATOR_ENABLED';
			}
			
			if ($post['verify_emails'] != $config->verify_emails)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['enable_backend_captcha']))
		{
			if ($post['enable_backend_captcha'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='enable_backend_captcha'";
				$level = 'high';
				$code = 'BACKEND_CAPTCHA_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='enable_backend_captcha'";
				$level = 'low';
				$code = 'BACKEND_CAPTCHA_ENABLED';
			}
			
			if ($post['enable_backend_captcha'] != $config->enable_backend_captcha)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['backend_captcha']))
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".(int) $post['backend_captcha']."' WHERE `name`='backend_captcha'";
			$level = 'low';
			$code = 'BACKEND_CAPTCHA_CHANGED';
			
			if ($post['backend_captcha'] != $config->backend_captcha)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_dos']))
		{
			if ($post['verify_dos'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_dos'";
				$level = 'medium';
				$code = 'VERIFY_DOS_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_dos'";
				$level = 'low';
				$code = 'VERIFY_DOS_ENABLED';
			}
			
			if ($post['verify_dos'] != $config->verify_dos)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_agents']))
		{
			if ($post['verify_agents'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_agents'";
				$level = 'medium';
				$code = 'VERIFY_AGENTS_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_agents'";
				$level = 'low';
				$code = 'VERIFY_AGENTS_ENABLED';
			}
			
			if ($post['verify_agents'] != $config->verify_agents)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_sql']))
		{
			if ($post['verify_sql'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_sql'";
				$level = 'medium';
				$code = 'VERIFY_SQL_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_sql'";
				$level = 'low';
				$code = 'VERIFY_SQL_ENABLED';
			}
			
			if ($post['verify_sql'] != $config->verify_sql)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		// verify_sql_skip
		if(!empty($post['verify_sql_skip']))
			$verify_sql_skip = implode("\n",$post['verify_sql_skip']);
		else 
			$verify_sql_skip = '';
		$verify_sql_skip = $this->_db->getEscaped($verify_sql_skip);
		
		$config->verify_sql_skip = implode("\n", $config->verify_sql_skip);
		$config->verify_sql_skip = $this->_db->getEscaped($config->verify_sql_skip);
		
		if ($verify_sql_skip != $config->verify_sql_skip)
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".$verify_sql_skip."' WHERE `name`='verify_sql_skip'";
			$level = 'high';
			$code = 'VERIFY_SQL_SKIP_CHANGED';
			
			$this->_db->setQuery($query);
			$this->_db->query();
			$this->_log->addEvent($level, $code);
		}
		// verify_sql_skip - stop
		
		if (isset($post['verify_php']))
		{
			if ($post['verify_php'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_php'";
				$level = 'medium';
				$code = 'VERIFY_PHP_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_php'";
				$level = 'low';
				$code = 'VERIFY_PHP_ENABLED';
			}
			
			if ($post['verify_php'] != $config->verify_php)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		// verify_php_skip
		if(!empty($post['verify_php_skip']))
			$verify_php_skip = implode("\n",$post['verify_php_skip']);
		else
			$verify_php_skip = '';
		$verify_php_skip = $this->_db->getEscaped($verify_php_skip);
		
		$config->verify_php_skip = implode("\n", $config->verify_php_skip);
		$config->verify_php_skip = $this->_db->getEscaped($config->verify_php_skip);
		
		if ($verify_php_skip != $config->verify_php_skip)
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".$verify_php_skip."' WHERE `name`='verify_php_skip'";
			$level = 'high';
			$code = 'VERIFY_PHP_SKIP_CHANGED';
			
			$this->_db->setQuery($query);
			$this->_db->query();
			$this->_log->addEvent($level, $code);
		}
		// verify_php_skip - stop
		
		if (isset($post['verify_js']))
		{
			if ($post['verify_js'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_js'";
				$level = 'medium';
				$code = 'VERIFY_JS_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_js'";
				$level = 'low';
				$code = 'VERIFY_JS_ENABLED';
			}
			
			if ($post['verify_js'] != $config->verify_js)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		// verify_js_skip
		if(!empty($post['verify_js_skip']))
			$verify_js_skip = implode("\n",$post['verify_js_skip']);
		else
			$verify_js_skip = '';
		$verify_js_skip = $this->_db->getEscaped($verify_js_skip);
		
		$config->verify_js_skip = implode("\n", $config->verify_js_skip);
		$config->verify_js_skip = $this->_db->getEscaped($config->verify_js_skip);
		
		if ($verify_js_skip != $config->verify_js_skip)
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".$verify_js_skip."' WHERE `name`='verify_js_skip'";
			$level = 'high';
			$code = 'VERIFY_JS_SKIP_CHANGED';
			
			$this->_db->setQuery($query);
			$this->_db->query();
			$this->_log->addEvent($level, $code);
		}
		// verify_js_skip - stop
		
		if (isset($post['verify_multiple_exts']))
		{
			if ($post['verify_multiple_exts'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_multiple_exts'";
				$level = 'medium';
				$code = 'VERIFY_MULTIPLE_EXTS_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_multiple_exts'";
				$level = 'low';
				$code = 'VERIFY_MULTIPLE_EXTS_ENABLED';
			}
			
			if ($post['verify_multiple_exts'] != $config->verify_multiple_exts)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_upload']))
		{
			if ($post['verify_upload'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_upload'";
				$level = 'medium';
				$code = 'VERIFY_UPLOAD_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_upload'";
				$level = 'low';
				$code = 'VERIFY_UPLOAD_ENABLED';
			}
			
			if ($post['verify_upload'] != $config->verify_upload)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_upload_blacklist_exts']))
		{
			$post['verify_upload_blacklist_exts'] = $this->_db->getEscaped($post['verify_upload_blacklist_exts']);
			$config->verify_upload_blacklist_exts = $this->_db->getEscaped($config->verify_upload_blacklist_exts);
			
			if ($post['verify_upload_blacklist_exts'] != $config->verify_upload_blacklist_exts)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['verify_upload_blacklist_exts']."' WHERE `name`='verify_upload_blacklist_exts'";
				$level = 'medium';
				$code = 'VERIFY_EXTENSIONS_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['monitor_core']))
		{
			if ($post['monitor_core'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='monitor_core'";
				$level = 'medium';
				$code = 'MONITOR_CORE_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='monitor_core'";
				$level = 'low';
				$code = 'MONITOR_CORE_ENABLED';
			}
			
			if ($post['monitor_core'] != $config->monitor_core)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['monitor_files']))
		{
			$post['monitor_files'] = str_replace("\r", '', $post['monitor_files']);
			$monitor_files = explode("\n", $post['monitor_files']);
			foreach ($monitor_files as $i => $file)
			{
				$file = trim($file);
				if (!file_exists($file))
					unset($monitor_files[$i]);
				else
				{
					$query = "SELECT `id` FROM #__rsfirewall_hashes WHERE `file`='".$this->_db->getEscaped($file)."'";
					$this->_db->setQuery($query);
					$this->_db->query();
					if ($this->_db->getNumRows() == 0)
					{
						$query = "INSERT INTO #__rsfirewall_hashes SET `file`='".$this->_db->getEscaped($file)."', `hash`='".md5_file($file)."', `type`='protect'";
						$this->_db->setQuery($query);
						$this->_db->query();
					}
				}
			}
			
			$post['monitor_files'] = implode("\n", $monitor_files);
			$post['monitor_files'] = $this->_db->getEscaped($post['monitor_files']);
			$config->monitor_files = $this->_db->getEscaped($config->monitor_files);
			if ($post['monitor_files'] != $config->monitor_files)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['monitor_files']."' WHERE `name`='monitor_files'";
				$level = 'medium';
				$code = 'MONITOR_FILES_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		// Ignore files and folders
		if (isset($post['ignore_files_folders']))
		{
			$this->_db->setQuery("DELETE FROM #__rsfirewall_ignored WHERE `type`='ignore_files_folders'");
			$this->_db->query();
			
			$post['ignore_files_folders'] = str_replace("\r", '', $post['ignore_files_folders']);
			$ignore_files_folders = explode("\n", $post['ignore_files_folders']);
			foreach ($ignore_files_folders as $i => $file)
			{
				$file = trim($file);
				if (!file_exists($file))
					unset($ignore_files_folders[$i]);
				else
				{
					$this->_db->setQuery("INSERT INTO #__rsfirewall_ignored SET `path`='".$this->_db->getEscaped($file)."', `type`='ignore_files_folders'");
					$this->_db->query();
				}
			}
		}
		
		// monitor_users
		JArrayHelper::toInteger($post['monitor_users']);
			
		$monitor_users = implode("\n",$post['monitor_users']);
		$monitor_users = $this->_db->getEscaped($monitor_users);
		
		$config->monitor_users = implode("\n", $config->monitor_users);
		$config->monitor_users = $this->_db->getEscaped($config->monitor_users);
		
		if ($monitor_users != $config->monitor_users)
		{
			$this->_db->setQuery("DELETE FROM #__rsfirewall_snapshots WHERE `type`='protect'");
			$this->_db->query();
			
			foreach ($post['monitor_users'] as $user_id)
			{
				$user = JUser::getInstance($user_id);
				$snapshot = RSFirewallHelper::createSnapshot($user);
				$this->_db->setQuery("INSERT INTO #__rsfirewall_snapshots SET `user_id`='".$user_id."', `snapshot`='".$snapshot."', `type`='protect'");
				$this->_db->query();
			}
				
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".$monitor_users."' WHERE `name`='monitor_users'";
			$level = 'medium';
			$code = 'MONITOR_USERS_CHANGED';
			
			$this->_db->setQuery($query);
			$this->_db->query();
			$this->_log->addEvent($level, $code);
		}
		// monitor_users - stop
		
		if (isset($post['backend_access_control_enabled']))
		{
			if ($post['backend_access_control_enabled'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='backend_access_control_enabled'";
				$level = 'medium';
				$code = 'BACKEND_ACCESS_CONTROL_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='backend_access_control_enabled'";
				$level = 'low';
				$code = 'BACKEND_ACCESS_CONTROL_ENABLED';
			}
			
			if ($post['backend_access_control_enabled'] != $config->backend_access_control_enabled)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		// backend_access_users
		JArrayHelper::toInteger($post['backend_access_users']);

		$backend_access_users = implode("\n",$post['backend_access_users']);
		$backend_access_users = $this->_db->getEscaped($backend_access_users);
		
		$config->backend_access_users = implode("\n",$config->backend_access_users);
		$config->backend_access_users = $this->_db->getEscaped($config->backend_access_users);
		
		if ($backend_access_users != $config->backend_access_users)
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".$backend_access_users."' WHERE `name`='backend_access_users'";
			$level = 'high';
			$code = 'BACKEND_ACCESS_USERS_CHANGED';
			
			$this->_db->setQuery($query);
			$this->_db->query();
			$this->_log->addEvent($level, $code);
		}
		// backend_access_users - stop
		
		// backend_access_components
		if (!isset($post['backend_access_components']))
			$post['backend_access_components'] = array();
		$backend_access_components = implode("\n",@$post['backend_access_components']);
		$backend_access_components = $this->_db->getEscaped($backend_access_components);
		
		$config->backend_access_components = implode("\n",$config->backend_access_components);
		$config->backend_access_components = $this->_db->getEscaped($config->backend_access_components);
		
		if ($backend_access_components != $config->backend_access_components)
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".$backend_access_components."' WHERE `name`='backend_access_components'";
			$level = 'high';
			$code = 'BACKEND_ACCESS_COMPONENTS_CHANGED';
			
			$this->_db->setQuery($query);
			$this->_db->query();
			$this->_log->addEvent($level, $code);
		}
		// backend_access_components - stop
		
		if (isset($post['backend_password_enabled']))
		{
			if ($post['backend_password_enabled'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='backend_password_enabled'";
				$level = 'high';
				$code = 'BACKEND_PASSWORD_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='backend_password_enabled'";
				$level = 'low';
				$code = 'BACKEND_PASSWORD_ENABLED';
			}
			
			if ($post['backend_password_enabled'] != $config->backend_password_enabled)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['backend_password']))
		{
			if (strlen($post['backend_password']) > 0 && strlen($post['backend_password']) < 6)
				JError::raiseWarning(500, JText::_('RSF_BACKEND_PASSWORD_ERROR'));
				
			if (strlen($post['backend_password']) >= 6 && md5($post['backend_password']) != $config->backend_password)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".md5($post['backend_password'])."' WHERE `name`='backend_password'";
				$level = 'high';
				$code = 'BACKEND_PASSWORD_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['offset']))
		{
			$post['offset'] = (int) $post['offset'];
			if (!$post['offset'])
				$post['offset'] = 300;
			
			$this->_db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".$post['offset']."' WHERE `name`='offset'");
			$this->_db->query();
		}
		
		if (isset($post['log_emails']))
		{
			$log_emails = explode("\n", $post['log_emails']);
			foreach ($log_emails as $i => $email)
			{
				$email = trim($email);
				if (!RSFirewallHelper::is_email($email))
					unset($log_emails[$i]);
			}
			
			$post['log_emails'] = implode("\n", $log_emails);
			$post['log_emails'] = $this->_db->getEscaped($post['log_emails']);
			$config->log_emails = $this->_db->getEscaped($config->log_emails);
			if ($post['log_emails'] != $config->log_emails)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['log_emails']."' WHERE `name`='log_emails'";
				$level = 'high';
				$code = 'LOG_EMAILS_CHANGED';
			
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['log_alert_level']))
		{
			if (array_search($post['log_alert_level'], $this->getAlertLevelsArray()) !== false && $post['log_alert_level'] != $config->log_alert_level)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['log_alert_level']."' WHERE `name`='log_alert_level'";
				$level = 'medium';
				$code = 'LOG_ALERT_LEVEL_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['log_history']))
		{
			$post['log_history'] = intval($post['log_history']);
			if ($post['log_history'] == 0)
				$post['log_history'] = 30;
			if ($post['log_history'] != $config->log_history)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['log_history']."' WHERE `name`='log_history'";
				$level = 'low';
				$code = 'LOG_HISTORY_CHANGED';
			
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['log_overview']))
		{
			$post['log_overview'] = intval($post['log_overview']);
			if ($post['log_overview'] == 0)
				$post['log_overview'] = 5;
			if ($post['log_overview'] != $config->log_overview)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['log_overview']."' WHERE `name`='log_overview'";
				$level = 'low';
				$code = 'LOG_OVERVIEW_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		// country block
		if(!empty($post['blocked_countries']))
			$blocked_countries = implode("\n",$post['blocked_countries']);
		else 
			$blocked_countries = '';
		
		$config->blocked_countries = implode("\n", $config->blocked_countries);
		
		if ($blocked_countries != $config->blocked_countries)
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".$this->_db->getEscaped($blocked_countries)."' WHERE `name`='blocked_countries'";
			$level = 'high';
			$code = 'BLOCKED_COUNTRIES_CHANGED';
			
			$this->_db->setQuery($query);
			$this->_db->query();
			$this->_log->addEvent($level, $code);
		}
		// country block - stop
		
		if (isset($post['enable_autoban']))
		{
			if ($post['enable_autoban'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='enable_autoban'";
				$level = 'high';
				$code = 'AUTOBAN_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='enable_autoban'";
				$level = 'low';
				$code = 'AUTOBAN_ENABLED';
			}
			
			if ($post['enable_autoban'] != $config->enable_autoban)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['enable_autoban_login']))
		{
			if ($post['enable_autoban_login'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='enable_autoban_login'";
				$level = 'high';
				$code = 'AUTOBAN_LOGIN_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='enable_autoban_login'";
				$level = 'low';
				$code = 'AUTOBAN_LOGIN_ENABLED';
			}
			
			if ($post['enable_autoban_login'] != $config->enable_autoban_login)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['autoban_attempts']))
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".(int) $post['autoban_attempts']."' WHERE `name`='autoban_attempts'";
			$level = 'low';
			$code = 'AUTOBAN_ATTEMPTS_CHANGED';
			
			if ($post['autoban_attempts'] != $config->autoban_attempts)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['log_hour_limit']))
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".(int) $post['log_hour_limit']."' WHERE `name`='log_hour_limit'";
			$this->_db->setQuery($query);
			$this->_db->query();
		}
		
		RSFirewallHelper::readConfig(true);
	}
	
	function getIgnoredFilesFolders()
	{
		$this->_db->setQuery("SELECT `path` FROM #__rsfirewall_ignored WHERE `type`='ignore_files_folders'");
		$results = $this->_db->loadResultArray();
		if ($results)
			return implode("\n", $results);
		
		return '';
	}
	
	function uploadGeoIPDB()
	{
		$db_location = RSFirewallHelper::getGeoIPDB();
		if (file_exists($db_location) && !is_writable($db_location))
		{
			JError::raiseWarning(500, JText::sprintf('RSF_GEOIP_DB_EXISTS_NOT_WRITABLE', $db_location));
			return false;
		}
		if (!is_writable(dirname($db_location)))
		{
			JError::raiseWarning(500, JText::sprintf('RSF_GEOIP_DB_FOLDER_NOT_WRITABLE', dirname($db_location)));
			return false;
		}
		$file = JRequest::getVar('geoip_db', null, 'files');
		if ($file && !empty($file['tmp_name']))
		{
			$ext = JFile::getExt($file['name']);
			if ($ext != 'dat')
			{
				JError::raiseWarning(500, JText::_('RSF_GEOIP_DB_UNZIP_FIRST'));
				return false;
			}
			
			return JFile::upload($file['tmp_name'], $db_location);
		}
		return false;
	}
	
	function getCountries()
	{
		return array(JHTML::_('select.option', 'AF', 'Afghanistan'), JHTML::_('select.option', 'AX', 'Aland Islands'), JHTML::_('select.option', 'AL', 'Albania'), JHTML::_('select.option', 'DZ', 'Algeria'), JHTML::_('select.option', 'AS', 'American Samoa'), JHTML::_('select.option', 'AD', 'Andorra'), JHTML::_('select.option', 'AO', 'Angola'), JHTML::_('select.option', 'AI', 'Anguilla'), JHTML::_('select.option', 'AQ', 'Antarctica'), JHTML::_('select.option', 'AG', 'Antigua and Barbuda'), JHTML::_('select.option', 'AR', 'Argentina'), JHTML::_('select.option', 'AM', 'Armenia'), JHTML::_('select.option', 'AW', 'Aruba'), JHTML::_('select.option', 'AP', 'Asia/Pacific Region'), JHTML::_('select.option', 'AU', 'Australia'), JHTML::_('select.option', 'AT', 'Austria'), JHTML::_('select.option', 'AZ', 'Azerbaijan'), JHTML::_('select.option', 'BS', 'Bahamas'), JHTML::_('select.option', 'BH', 'Bahrain'), JHTML::_('select.option', 'BD', 'Bangladesh'), JHTML::_('select.option', 'BB', 'Barbados'), JHTML::_('select.option', 'BY', 'Belarus'), JHTML::_('select.option', 'BE', 'Belgium'), JHTML::_('select.option', 'BZ', 'Belize'), JHTML::_('select.option', 'BJ', 'Benin'), JHTML::_('select.option', 'BM', 'Bermuda'), JHTML::_('select.option', 'BT', 'Bhutan'), JHTML::_('select.option', 'BO', 'Bolivia'), JHTML::_('select.option', 'BA', 'Bosnia and Herzegovina'), JHTML::_('select.option', 'BW', 'Botswana'), JHTML::_('select.option', 'BV', 'Bouvet Island'), JHTML::_('select.option', 'BR', 'Brazil'), JHTML::_('select.option', 'IO', 'British Indian Ocean Territory'), JHTML::_('select.option', 'BN', 'Brunei Darussalam'), JHTML::_('select.option', 'BG', 'Bulgaria'), JHTML::_('select.option', 'BF', 'Burkina Faso'), JHTML::_('select.option', 'BI', 'Burundi'), JHTML::_('select.option', 'KH', 'Cambodia'), JHTML::_('select.option', 'CM', 'Cameroon'), JHTML::_('select.option', 'CA', 'Canada'), JHTML::_('select.option', 'CV', 'Cape Verde'), JHTML::_('select.option', 'KY', 'Cayman Islands'), JHTML::_('select.option', 'CF', 'Central African Republic'), JHTML::_('select.option', 'TD', 'Chad'), JHTML::_('select.option', 'CL', 'Chile'), JHTML::_('select.option', 'CN', 'China'), JHTML::_('select.option', 'CX', 'Christmas Island'), JHTML::_('select.option', 'CC', 'Cocos (Keeling) Islands'), JHTML::_('select.option', 'CO', 'Colombia'), JHTML::_('select.option', 'KM', 'Comoros'), JHTML::_('select.option', 'CG', 'Congo'), JHTML::_('select.option', 'CD', 'Congo, The Democratic Republic of the'), JHTML::_('select.option', 'CK', 'Cook Islands'), JHTML::_('select.option', 'CR', 'Costa Rica'), JHTML::_('select.option', 'CI', 'Cote d\'Ivoire'), JHTML::_('select.option', 'HR', 'Croatia'), JHTML::_('select.option', 'CU', 'Cuba'), JHTML::_('select.option', 'CY', 'Cyprus'), JHTML::_('select.option', 'CZ', 'Czech Republic'), JHTML::_('select.option', 'DK', 'Denmark'), JHTML::_('select.option', 'DJ', 'Djibouti'), JHTML::_('select.option', 'DM', 'Dominica'), JHTML::_('select.option', 'DO', 'Dominican Republic'), JHTML::_('select.option', 'EC', 'Ecuador'), JHTML::_('select.option', 'EG', 'Egypt'), JHTML::_('select.option', 'SV', 'El Salvador'), JHTML::_('select.option', 'GQ', 'Equatorial Guinea'), JHTML::_('select.option', 'ER', 'Eritrea'), JHTML::_('select.option', 'EE', 'Estonia'), JHTML::_('select.option', 'ET', 'Ethiopia'), JHTML::_('select.option', 'EU', 'Europe'), JHTML::_('select.option', 'FK', 'Falkland Islands (Malvinas)'), JHTML::_('select.option', 'FO', 'Faroe Islands'), JHTML::_('select.option', 'FJ', 'Fiji'), JHTML::_('select.option', 'FI', 'Finland'), JHTML::_('select.option', 'FR', 'France'), JHTML::_('select.option', 'GF', 'French Guiana'), JHTML::_('select.option', 'PF', 'French Polynesia'), JHTML::_('select.option', 'TF', 'French Southern Territories'), JHTML::_('select.option', 'GA', 'Gabon'), JHTML::_('select.option', 'GM', 'Gambia'), JHTML::_('select.option', 'GE', 'Georgia'), JHTML::_('select.option', 'DE', 'Germany'), JHTML::_('select.option', 'GH', 'Ghana'), JHTML::_('select.option', 'GI', 'Gibraltar'), JHTML::_('select.option', 'GR', 'Greece'), JHTML::_('select.option', 'GL', 'Greenland'), JHTML::_('select.option', 'GD', 'Grenada'), JHTML::_('select.option', 'GP', 'Guadeloupe'), JHTML::_('select.option', 'GU', 'Guam'), JHTML::_('select.option', 'GT', 'Guatemala'), JHTML::_('select.option', 'GG', 'Guernsey'), JHTML::_('select.option', 'GN', 'Guinea'), JHTML::_('select.option', 'GW', 'Guinea-Bissau'), JHTML::_('select.option', 'GY', 'Guyana'), JHTML::_('select.option', 'HT', 'Haiti'), JHTML::_('select.option', 'HM', 'Heard Island and McDonald Islands'), JHTML::_('select.option', 'VA', 'Holy See (Vatican City State)'), JHTML::_('select.option', 'HN', 'Honduras'), JHTML::_('select.option', 'HK', 'Hong Kong'), JHTML::_('select.option', 'HU', 'Hungary'), JHTML::_('select.option', 'IS', 'Iceland'), JHTML::_('select.option', 'IN', 'India'), JHTML::_('select.option', 'ID', 'Indonesia'), JHTML::_('select.option', 'IR', 'Iran, Islamic Republic of'), JHTML::_('select.option', 'IQ', 'Iraq'), JHTML::_('select.option', 'IE', 'Ireland'), JHTML::_('select.option', 'IM', 'Isle of Man'), JHTML::_('select.option', 'IL', 'Israel'), JHTML::_('select.option', 'IT', 'Italy'), JHTML::_('select.option', 'JM', 'Jamaica'), JHTML::_('select.option', 'JP', 'Japan'), JHTML::_('select.option', 'JE', 'Jersey'), JHTML::_('select.option', 'JO', 'Jordan'), JHTML::_('select.option', 'KZ', 'Kazakhstan'), JHTML::_('select.option', 'KE', 'Kenya'), JHTML::_('select.option', 'KI', 'Kiribati'), JHTML::_('select.option', 'KP', 'Korea, Democratic People\'s Republic of'), JHTML::_('select.option', 'KR', 'Korea, Republic of'), JHTML::_('select.option', 'KW', 'Kuwait'), JHTML::_('select.option', 'KG', 'Kyrgyzstan'), JHTML::_('select.option', 'LA', 'Lao People\'s Democratic Republic'), JHTML::_('select.option', 'LV', 'Latvia'), JHTML::_('select.option', 'LB', 'Lebanon'), JHTML::_('select.option', 'LS', 'Lesotho'), JHTML::_('select.option', 'LR', 'Liberia'), JHTML::_('select.option', 'LY', 'Libyan Arab Jamahiriya'), JHTML::_('select.option', 'LI', 'Liechtenstein'), JHTML::_('select.option', 'LT', 'Lithuania'), JHTML::_('select.option', 'LU', 'Luxembourg'), JHTML::_('select.option', 'MO', 'Macao'), JHTML::_('select.option', 'MK', 'Macedonia, Former Yugoslav Republic of'), JHTML::_('select.option', 'MG', 'Madagascar'), JHTML::_('select.option', 'MW', 'Malawi'), JHTML::_('select.option', 'MY', 'Malaysia'), JHTML::_('select.option', 'MV', 'Maldives'), JHTML::_('select.option', 'ML', 'Mali'), JHTML::_('select.option', 'MT', 'Malta'), JHTML::_('select.option', 'MH', 'Marshall Islands'), JHTML::_('select.option', 'MQ', 'Martinique'), JHTML::_('select.option', 'MR', 'Mauritania'), JHTML::_('select.option', 'MU', 'Mauritius'), JHTML::_('select.option', 'YT', 'Mayotte'), JHTML::_('select.option', 'MX', 'Mexico'), JHTML::_('select.option', 'FM', 'Micronesia, Federated States of'), JHTML::_('select.option', 'MD', 'Moldova, Republic of'), JHTML::_('select.option', 'MC', 'Monaco'), JHTML::_('select.option', 'MN', 'Mongolia'), JHTML::_('select.option', 'ME', 'Montenegro'), JHTML::_('select.option', 'MS', 'Montserrat'), JHTML::_('select.option', 'MA', 'Morocco'), JHTML::_('select.option', 'MZ', 'Mozambique'), JHTML::_('select.option', 'MM', 'Myanmar'), JHTML::_('select.option', 'NA', 'Namibia'), JHTML::_('select.option', 'NR', 'Nauru'), JHTML::_('select.option', 'NP', 'Nepal'), JHTML::_('select.option', 'NL', 'Netherlands'), JHTML::_('select.option', 'AN', 'Netherlands Antilles'), JHTML::_('select.option', 'NC', 'New Caledonia'), JHTML::_('select.option', 'NZ', 'New Zealand'), JHTML::_('select.option', 'NI', 'Nicaragua'), JHTML::_('select.option', 'NE', 'Niger'), JHTML::_('select.option', 'NG', 'Nigeria'), JHTML::_('select.option', 'NU', 'Niue'), JHTML::_('select.option', 'NF', 'Norfolk Island'), JHTML::_('select.option', 'MP', 'Northern Mariana Islands'), JHTML::_('select.option', 'NO', 'Norway'), JHTML::_('select.option', 'OM', 'Oman'), JHTML::_('select.option', 'PK', 'Pakistan'), JHTML::_('select.option', 'PW', 'Palau'), JHTML::_('select.option', 'PS', 'Palestinian Territory'), JHTML::_('select.option', 'PA', 'Panama'), JHTML::_('select.option', 'PG', 'Papua New Guinea'), JHTML::_('select.option', 'PY', 'Paraguay'), JHTML::_('select.option', 'PE', 'Peru'), JHTML::_('select.option', 'PH', 'Philippines'), JHTML::_('select.option', 'PN', 'Pitcairn'), JHTML::_('select.option', 'PL', 'Poland'), JHTML::_('select.option', 'PT', 'Portugal'), JHTML::_('select.option', 'PR', 'Puerto Rico'), JHTML::_('select.option', 'QA', 'Qatar'), JHTML::_('select.option', 'RE', 'Reunion'), JHTML::_('select.option', 'RO', 'Romania'), JHTML::_('select.option', 'RU', 'Russian Federation'), JHTML::_('select.option', 'RW', 'Rwanda'), JHTML::_('select.option', 'SH', 'Saint Helena'), JHTML::_('select.option', 'KN', 'Saint Kitts and Nevis'), JHTML::_('select.option', 'LC', 'Saint Lucia'), JHTML::_('select.option', 'PM', 'Saint Pierre and Miquelon'), JHTML::_('select.option', 'VC', 'Saint Vincent and the Grenadines'), JHTML::_('select.option', 'WS', 'Samoa'), JHTML::_('select.option', 'SM', 'San Marino'), JHTML::_('select.option', 'ST', 'Sao Tome and Principe'), JHTML::_('select.option', 'SA', 'Saudi Arabia'), JHTML::_('select.option', 'SN', 'Senegal'), JHTML::_('select.option', 'RS', 'Serbia'), JHTML::_('select.option', 'SC', 'Seychelles'), JHTML::_('select.option', 'SL', 'Sierra Leone'), JHTML::_('select.option', 'SG', 'Singapore'), JHTML::_('select.option', 'SK', 'Slovakia'), JHTML::_('select.option', 'SI', 'Slovenia'), JHTML::_('select.option', 'SB', 'Solomon Islands'), JHTML::_('select.option', 'SO', 'Somalia'), JHTML::_('select.option', 'ZA', 'South Africa'), JHTML::_('select.option', 'GS', 'South Georgia and the South Sandwich Islands'), JHTML::_('select.option', 'ES', 'Spain'), JHTML::_('select.option', 'LK', 'Sri Lanka'), JHTML::_('select.option', 'SD', 'Sudan'), JHTML::_('select.option', 'SR', 'Suriname'), JHTML::_('select.option', 'SJ', 'Svalbard and Jan Mayen'), JHTML::_('select.option', 'SZ', 'Swaziland'), JHTML::_('select.option', 'SE', 'Sweden'), JHTML::_('select.option', 'CH', 'Switzerland'), JHTML::_('select.option', 'SY', 'Syrian Arab Republic'), JHTML::_('select.option', 'TW', 'Taiwan'), JHTML::_('select.option', 'TJ', 'Tajikistan'), JHTML::_('select.option', 'TZ', 'Tanzania, United Republic of'), JHTML::_('select.option', 'TH', 'Thailand'), JHTML::_('select.option', 'TL', 'Timor-Leste'), JHTML::_('select.option', 'TG', 'Togo'), JHTML::_('select.option', 'TK', 'Tokelau'), JHTML::_('select.option', 'TO', 'Tonga'), JHTML::_('select.option', 'TT', 'Trinidad and Tobago'), JHTML::_('select.option', 'TN', 'Tunisia'), JHTML::_('select.option', 'TR', 'Turkey'), JHTML::_('select.option', 'TM', 'Turkmenistan'), JHTML::_('select.option', 'TC', 'Turks and Caicos Islands'), JHTML::_('select.option', 'TV', 'Tuvalu'), JHTML::_('select.option', 'UG', 'Uganda'), JHTML::_('select.option', 'UA', 'Ukraine'), JHTML::_('select.option', 'AE', 'United Arab Emirates'), JHTML::_('select.option', 'GB', 'United Kingdom'), JHTML::_('select.option', 'US', 'United States'), JHTML::_('select.option', 'UM', 'United States Minor Outlying Islands'), JHTML::_('select.option', 'UY', 'Uruguay'), JHTML::_('select.option', 'UZ', 'Uzbekistan'), JHTML::_('select.option', 'VU', 'Vanuatu'), JHTML::_('select.option', 'VE', 'Venezuela'), JHTML::_('select.option', 'VN', 'Vietnam'), JHTML::_('select.option', 'VG', 'Virgin Islands, British'), JHTML::_('select.option', 'VI', 'Virgin Islands, U.S.'), JHTML::_('select.option', 'WF', 'Wallis and Futuna'), JHTML::_('select.option', 'EH', 'Western Sahara'), JHTML::_('select.option', 'YE', 'Yemen'), JHTML::_('select.option', 'ZM', 'Zambia'), JHTML::_('select.option', 'ZW', 'Zimbabwe'));
	}
}