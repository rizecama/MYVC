<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewRSFirewall extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title('RSFirewall!','rsfirewall');

		// Options button.
		$jversion 	= new JVersion();
		if ($jversion->isCompatible('1.6.0')) {
			$user 		=& JFactory::getUser();
			if ($user->authorise('core.admin', 'com_rsfirewall')) {
				JToolBarHelper::preferences('com_rsfirewall');
			}
		}

		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_OVERVIEW'), 'index.php?option=com_rsfirewall', true);
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_CHECK'), 'index.php?option=com_rsfirewall&view=check');
		JSubMenuHelper::addEntry(JText::_('RSF_DB_CHECK'), 'index.php?option=com_rsfirewall&view=dbcheck');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOGS'), 'index.php?option=com_rsfirewall&view=logs');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOCKDOWN'), 'index.php?option=com_rsfirewall&view=lockdown');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=configuration');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_LISTS'), 'index.php?option=com_rsfirewall&view=lists');
		JSubMenuHelper::addEntry(JText::_('RSF_FEEDS_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=feeds');
		JSubMenuHelper::addEntry(JText::_('RSF_UPDATES'), 'index.php?option=com_rsfirewall&view=updates');
		
		$this->assignRef('pluginEnabled', $this->get('pluginEnabled'));
		$this->assignRef('isJ17beta', RSFirewallHelper::isJ17beta());
		
		$this->assignRef('grade', $this->get('grade'));
		
		parent::display($tpl);
		
		$this->assignRef('files', $this->get('files'));
		parent::display('files');
		
		$this->assignRef('logs', $this->get('logs'));
		parent::display('logs');
		
		$this->assignRef('components',$this->get('components'));
		$this->assignRef('feeds',$this->get('feeds'));
		
		parent::display('feeds');
		
		$this->assignRef('code', $this->get('code'));
		
		parent::display('version');
	}
}