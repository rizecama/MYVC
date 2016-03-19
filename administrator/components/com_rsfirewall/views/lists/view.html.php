<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class RSFirewallViewLists extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title('RSFirewall!','rsfirewall');
		
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_OVERVIEW'), 'index.php?option=com_rsfirewall');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_CHECK'), 'index.php?option=com_rsfirewall&view=check');
		JSubMenuHelper::addEntry(JText::_('RSF_DB_CHECK'), 'index.php?option=com_rsfirewall&view=dbcheck');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOGS'), 'index.php?option=com_rsfirewall&view=logs');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOCKDOWN'), 'index.php?option=com_rsfirewall&view=lockdown');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=configuration');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_LISTS'), 'index.php?option=com_rsfirewall&view=lists', true);
		JSubMenuHelper::addEntry(JText::_('RSF_FEEDS_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=feeds');
		JSubMenuHelper::addEntry(JText::_('RSF_UPDATES'), 'index.php?option=com_rsfirewall&view=updates');
		
		$layout = $this->getLayout();
		if ($layout == 'edit')
		{
			JToolBarHelper::apply();
			JToolBarHelper::save();
			if (RSFirewallHelper::isJ16())
			{
				JToolBarHelper::save2new();
				JToolBarHelper::save2copy();
			}
			JToolBarHelper::cancel();
			
			$this->assignRef('row', $this->get('Row'));
			$this->assignRef('ip', $this->get('Ip'));
			
			$lists['type'] 		= JHTML::_('select.booleanlist','type','class="inputbox"',$this->row->type, JText::_('RSF_LIST_TYPE_1'), JText::_('RSF_LIST_TYPE_0'));
			$lists['published'] = JHTML::_('select.booleanlist','published','class="inputbox"',$this->row->published);
			$this->assignRef('lists', $lists);
		}
		elseif ($layout == 'bulk')
		{
			JToolBarHelper::save('savebulk');
			JToolBarHelper::cancel();
			
			$this->assignRef('ip', $this->get('Ip'));
			
			$lists['type'] 		= JHTML::_('select.booleanlist','type','class="inputbox"', 0, JText::_('RSF_LIST_TYPE_1'), JText::_('RSF_LIST_TYPE_0'));
			$lists['published'] = JHTML::_('select.booleanlist','published','class="inputbox"', 1);
			$this->assignRef('lists', $lists);
		}
		else
		{
			JToolBarHelper::addNewX('add');
			JToolBarHelper::addNewX('bulkAdd', JText::_('RSF_BULK_ADD'));
			JToolBarHelper::editListX('edit');
			JToolBarHelper::spacer();
			
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::spacer();
			
			JToolBarHelper::deleteList('RSF_CONFIRM_DELETE');
			
			$lists['filter_state'] = JHTML::_('grid.state', $this->get('FilterState'));
			$lists['filter_type']  = JHTML::_('select.genericlist', array(
				JHTML::_('select.option', '', JText::_('RSF_SELECT_TYPE')),
				JHTML::_('select.option', 0, JText::_('RSF_LIST_TYPE_0')),
				JHTML::_('select.option', 1, JText::_('RSF_LIST_TYPE_1'))
			), 'filter_type', 'class="inputbox" size="1" onchange="this.form.submit();"', 'value', 'text', $this->get('FilterType'));
			$this->assignRef('lists', $lists);
			
			$this->assignRef('sortColumn', $this->get('SortColumn'));
			$this->assignRef('sortOrder', $this->get('SortOrder'));
			
			$this->assignRef('rows', $this->get('Rows'));
			$this->assignRef('pagination', $this->get('Pagination'));
			
			$this->assignRef('filter', $this->get('Filter'));
		}
		
		parent::display($tpl);
	}
}