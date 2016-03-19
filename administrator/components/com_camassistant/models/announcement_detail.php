<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
error_reporting(0);
// import MODEL object class
jimport('joomla.application.component.model');


class announcement_detailModelannouncement_detail extends JModel
{
	var $_id = null;

	var $_data = null;

	var $_table_prefix = null;
	
	function __construct()
	{
		parent::__construct();

		//initialize class property
	  $this->_table_prefix = '#__cam_announcement';		
	  
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);

	}


	function setId($id)
	{
		$this->_id		= $id;
		$this->_data	= null;
	}


	function checkout($uid = null)
	{
		if ($this->_id)
		{
			// Make sure we have a user id to checkout the article with
			if (is_null($uid)) {
				$user	=& JFactory::getUser();
				$uid	= $user->get('id');
			}
			// Lets get to it and checkout the thing...
			$_detail = & $this->getTable();
			
			
			if(!$_detail->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}

			return true;
		}
		return false;
	}
	/**
	 * Method to checkin/unlock the _detail
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function checkin()
	{
		if ($this->_id)
		{
			$_detail = & $this->getTable();
			if(! $_detail->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}	
	/**
	 * Tests if _detail is checked out
	 *
	 * @access	public
	 * @param	int	A user id
	 * @return	boolean	True if checked out
	 * @since	1.5
	 */
	function isCheckedOut( $uid=0 )
	{
		if ($this->_loadData())
		{
			if ($uid) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		}
	}	

	function getData()
	{
		//DEVNOTE: Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			 $query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}


		return $this->_data;
}

	function _buildQuery()
	{

		$orderby	= $this->_buildContentOrderBy();
				
		$query = 'SELECT * FROM #__cam_announcement WHERE id='.$_REQUEST[cid][0];

		return $query;
	}
	
	function _buildContentOrderBy()
	{
		global $mainframe, $context;

		//DEVNOTE:give me ordering from request
		$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order',      'filter_order', 	  'ordering' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir', '' );		

		//DEVNOTE: all countries are in the same category(no category)  
		$orderby 	= ' ORDER BY  id ';			

		return $orderby;
	}
	
	/**
	 * Method to load content _detail data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
		 $query = 'SELECT * FROM '.$this->_table_prefix.''.
 			' ' .
		  ' WHERE id = '. $this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data; 
		}
		return true;
	}
  	
 function getIndustry() 
	{
		global $mainframe;
	 	$db=&JFactory::getDBO();
		$query = "SELECT id as value,industry_name as text FROM #__cam_industries ORDER BY industry_name ASC";
		$db->setQuery($query);
		$industryList = $db->loadObjectList();
		return $industryList;
	}
	function getstates()
	{
		$db = JFactory::getDBO();
		$sql = "SELECT id as value,state_name as text FROM #__state ORDER BY state_name ASC";
		$db->Setquery($sql);
		$states = $db->loadObjectList();
		return $states;
	}	
	function store($data)
	{
	
	 	// give me JTable object			 	
		$row = & $this->getTable('announcement_detail');
		
		// Bind the form fields to the  table
		if (!$row->bind($data)) {
		//echo "<pre>"; print_r($row); exit;
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// Create the timestamp for the date field
		// Store the  detail record into the database
		if (!$row->store()) {
		//echo "<pre>"; print_r($row); exit;
			$this->setError($this->_db->getErrorMsg());
			return false;
			
		}

		return true;
	}
	
	function store_camfirm($data)
	{
	 	// give me JTable object			 	
		$row = & $this->getTable('camfirm');
		
		// Bind the form fields to the  table
		if (!$row->bind($data)) {
			//echo "<pre>"; print_r($row); 	
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// Create the timestamp for the date field
		// Store the  detail record into the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
	function delete($cid = array())
	{
		$result = false;
		if (count( $cid ))
		{
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM '.$this->_table_prefix.' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}
	
	
			
}

?>
