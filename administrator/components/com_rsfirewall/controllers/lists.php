<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RSFirewallControllerLists extends RSFirewallController
{
	function __construct()
	{
		parent::__construct();
		$this->registerTask('apply', 'save');
		$this->registerTask('save2new', 'save');
		$this->registerTask('save2copy', 'save');
		$this->registerTask('publish', 'changestatus');
		$this->registerTask('unpublish', 'changestatus');
	}
	
	function add()
	{
		$this->setRedirect('index.php?option=com_rsfirewall&view=lists&layout=edit');
	}
	
	function bulkAdd()
	{
		$this->setRedirect('index.php?option=com_rsfirewall&view=lists&layout=bulk');
	}
	
	function cancel()
	{
		$this->setRedirect('index.php?option=com_rsfirewall&view=lists');
	}
	
	function changestatus()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Get the model
		$model = $this->getModel('lists');
		
		// Get the selected items
		$cid = JRequest::getVar('cid', array(0), 'post', 'array');

		// Get the task
		$task = JRequest::getCmd('task');
		
		// Force array elements to be integers
		JArrayHelper::toInteger($cid, array(0));
		
		$msg = '';
		
		// No items are selected
		if (!is_array($cid) || count($cid) < 1)
			JError::raiseWarning(500, JText::_('RSF_PLEASE_SELECT_ITEMS'));
		// Try to publish the item
		else
		{
			$value = $task == 'publish' ? 1 : 0;
			if (!$model->publish($cid, $value))
				JError::raiseError(500, $model->getError());

			$total = count($cid);
			if ($value)
				$msg = JText::sprintf('RSF_ITEMS_PUBLISHED', $total);
			else
				$msg = JText::sprintf('RSF_ITEMS_UNPUBLISHED', $total);
			
			// Clean the cache, if any
			$cache =& JFactory::getCache('com_rsfirewall');
			$cache->clean();
		}
		
		// Redirect
		$this->setRedirect('index.php?option=com_rsfirewall&view=lists', $msg);
	}
	
	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');

		// Get the model
		$model = $this->getModel('lists');
		
		// Get the selected items
		$cid = JRequest::getVar('cid', array(0), 'post', 'array');

		// Force array elements to be integers
		JArrayHelper::toInteger($cid, array(0));
		
		$msg = '';
		
		// No items are selected
		if (!is_array($cid) || count($cid) < 1)
			JError::raiseWarning(500, JText::_('RSF_PLEASE_SELECT_ITEMS'));
		// Try to remove the item
		else
		{
			if (!$model->remove($cid))
				JError::raiseError(500, $model->getError());
			
			$total = count($cid);
			$msg = JText::sprintf('RSF_ITEMS_DELETED', $total);
			
			// Clean the cache, if any
			$cache =& JFactory::getCache('com_rsticketspro');
			$cache->clean();
		}
		
		// Redirect
		$this->setRedirect('index.php?option=com_rsfirewall&view=lists', $msg);
	}
	
	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');

		// Get the model
		$model = $this->getModel('lists');
		
		// Save
		$result = $model->save();
		
		$task = JRequest::getCmd('task');
		switch($task)
		{			
			case 'save2new':
				$link = 'index.php?option=com_rsfirewall&view=lists&layout=edit';
				$msg  = $result ? JText::_('RSF_ITEM_SAVED_OK') : JText::_('RSF_ITEM_SAVED_ERROR');
				
				$this->setRedirect($link, $msg);
			break;
			
			case 'save2copy':
			case 'apply':
				$link = $result ? 'index.php?option=com_rsfirewall&view=lists&layout=edit&cid[]='.$result->id : 'index.php?option=com_rsfirewall&view=lists&layout=edit';
				$msg  = $result ? JText::_('RSF_ITEM_SAVED_OK') : JText::_('RSF_ITEM_SAVED_ERROR');
				
				$this->setRedirect($link, $msg);
			break;
		
			case 'save':
				$link = 'index.php?option=com_rsfirewall&view=lists';
				$msg  = $result ? JText::_('RSF_ITEM_SAVED_OK') : JText::_('RSF_ITEM_SAVED_ERROR');
				
				$this->setRedirect($link, $msg);
			break;
		}
	}
	
	function saveBulk()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');

		// Get the model
		$model = $this->getModel('lists');
		
		$ips = JRequest::getVar('ips');
		$ips = RSFirewallHelper::explode($ips);
		$post = JRequest::get('post');
		unset($post['ips']);
		
		$added = 0;
		foreach ($ips as $ip)
		{
			if ($ip)
			{
				$post['ip'] = $ip;
				if ($model->save($post))
					$added++;
			}
		}
		
		$link = 'index.php?option=com_rsfirewall&view=lists';
		$msg  = JText::sprintf('RSF_BULK_ITEM_SAVED_OK', $added);
		$this->setRedirect($link, $msg);
	}
}