<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pane');

class RSFirewallViewConfiguration extends JView
{
	function display( $tpl = null )
	{	
		JToolBarHelper::title('RSFirewall!','rsfirewall');
		
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_OVERVIEW'), 'index.php?option=com_rsfirewall');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_CHECK'), 'index.php?option=com_rsfirewall&view=check');
		JSubMenuHelper::addEntry(JText::_('RSF_DB_CHECK'), 'index.php?option=com_rsfirewall&view=dbcheck');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOGS'), 'index.php?option=com_rsfirewall&view=logs');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOCKDOWN'), 'index.php?option=com_rsfirewall&view=lockdown');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=configuration', true);
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_LISTS'), 'index.php?option=com_rsfirewall&view=lists');
		JSubMenuHelper::addEntry(JText::_('RSF_FEEDS_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=feeds');
		JSubMenuHelper::addEntry(JText::_('RSF_UPDATES'), 'index.php?option=com_rsfirewall&view=updates');
		
		JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		
		$this->assignRef('config', RSFirewallHelper::getConfig());
		$this->assignRef('levels', $this->get('alertlevels'));
		$this->assignRef('users', $this->get('users'));
		$this->assignRef('components', $this->get('components'));
		$this->assignRef('countries', $this->get('countries'));
		$this->assign('geoip_built_in', function_exists('geoip_database_info'));
		if (!$this->geoip_built_in)
		{
			$this->assign('geoip_db_file', RSFirewallHelper::getGeoIPDB());
			$this->assign('geoip_db_exists', file_exists($this->geoip_db_file));
		}
		
		$pane =& JPane::getInstance('Tabs', array(), true);
		$this->assignRef('pane', $pane);
		
		$this->assignRef('ignore_files_folders', $this->get('ignoredFilesFolders'));
		
		parent::display($tpl);
	}
}