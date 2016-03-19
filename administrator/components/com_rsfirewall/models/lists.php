<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelLists extends JModel
{
	var $_data = null;
	var $_total = 0;
	var $_query = '';
	var $_pagination = null;
	
	var $limit = null;
	var $limitstart = null;
	
	function __construct()
	{
		parent::__construct();
		$app = &JFactory::getApplication();
		
		// Get pagination request variables
		$this->limit	  = $this->_getUserStateFromRequest('limit', $app->getCfg('list_limit'), 'int');
		$this->limitstart = $this->_getUserStateFromRequest('limitstart', 0, 'int');

		// In case limit has been changed, adjust it
		$this->limitstart = ($this->limit != 0 ? (floor($this->limitstart / $this->limit) * $this->limit) : 0);
		
		$this->_query = $this->_buildQuery();
	}
	
	function _buildQuery()
	{
		$db 		= &JFactory::getDBO();
		$filter 	= $this->getFilter();
		$type		= $this->getFilterType();
		$state		= $this->getFilterState();
		$sortColumn = $this->getSortColumn();
		$sortOrder 	= $this->getSortOrder();
		
		// select
		$query = "SELECT * FROM #__rsfirewall_lists WHERE 1";
		// searching?
		if ($filter)
			$query .= " AND `ip` LIKE ".$db->quote('%'.$db->getEscaped($filter, true).'%', false);
		// filtering by type?
		if ($type != '')
			$query .= " AND `type`=".$db->quote($type);
		// filtering by state?
		if ($state != '')
		{
			$state = $state == 'P' ? 1 : 0;
			$query .= " AND `published`=".$db->quote($state);
		}
		// ordering
		$query .= " ORDER BY `".$sortColumn."` ".$db->getEscaped($sortOrder);
		
		return $query;
	}
	
	function getRows()
	{
		if (empty($this->_data))
			$this->_data = $this->_getList($this->_query, $this->limitstart, $this->limit);
		
		return $this->_data;
	}
	
	function getTotal()
	{
		if (empty($this->_total))
			$this->_total = $this->_getListCount($this->_query); 
		
		return $this->_total;
	}
	
	function getPagination()
	{
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->limitstart, $this->limit);
		}
		
		return $this->_pagination;
	}
	
	function getRow()
	{
		$cid = $this->getCid();
		
		$row =& JTable::getInstance('RSFirewall_Lists','Table');
		$row->load($cid);
		
		return $row;
	}
	
	function getIp()
	{
		return RSFirewallHelper::getIP(true);
	}
	
	function getCid()
	{
		$cid = JRequest::getVar('cid', array(0), 'default', 'array');
		JArrayHelper::toInteger($cid);
		return $cid[0];
	}
	
	function publish($cid=array(), $publish=1)
	{
		if (!is_array($cid))
			$cid = array($cid);
		$publish = (int) $publish;
		$db		 = &JFactory::getDBO();

		$db->setQuery("UPDATE #__rsfirewall_lists SET `published`=".$db->quote($publish)." WHERE `id` IN (".implode(',', $cid).")");
		if (!$db->query())
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
			
		return $cid;
	}
	
	function remove($cids)
	{
		$cids = implode(',', $cids);
		$db	  = &JFactory::getDBO();
		
		$db->setQuery("DELETE FROM #__rsfirewall_lists WHERE `id` IN (".$cids.")");
		if (!$db->query())
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function save($post=null)
	{
		$row =& JTable::getInstance('RSFirewall_Lists','Table');
		if (empty($post))
			$post = JRequest::get('post');
		
		if (!$row->bind($post))
			return JError::raiseWarning(500, $row->getError());
		
		if (!$row->id)
		{
			$date =& JFactory::getDate();
			$row->date = $date->toMySQL();
		}
		
		if ($row->store())
			return $row;
		else
		{
			JError::raiseWarning(500, $row->getError());
			return false;
		}
	}
	
	function getSortColumn()
	{
		return $this->_getUserStateFromRequest('filter_order', 'date');
	}
	
	function getSortOrder()
	{
		return $this->_getUserStateFromRequest('filter_order_Dir', 'DESC');
	}
	
	function getFilter()
	{
		return $this->_getUserStateFromRequest('filter', '');
	}
	
	function getFilterType()
	{
		return $this->_getUserStateFromRequest('filter_type', '');
	}
	
	function getFilterState()
	{
		return $this->_getUserStateFromRequest('filter_state', '');
	}
	
	function _getUserStateFromRequest($key, $default=null, $type='none')
	{
		$app 	= &JFactory::getApplication();
		$group 	= 'lists';
		return $app->getUserStateFromRequest('com_rsfirewall.'.$group.'.'.$key, $key, $default, $type);
	}
}