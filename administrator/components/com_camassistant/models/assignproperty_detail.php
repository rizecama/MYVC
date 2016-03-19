<?php
/**
* @package HelloWorld
* @version 1.5
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software and parts of it may contain or be derived from the
* GNU General Public License or other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
error_reporting(0);
//DEVNOTE: import MODEL object class
jimport('joomla.application.component.model');

/**
 * helloworld Component helloworld Model
 *
 * @author wojta <vojtechovsky@gmail.com>
 * @package		Joomla
 * @subpackage	helloworld
 * @since 1.5
 */
class assignproperty_detailModelassignproperty_detail extends JModel
{

	/**
	 * helloworld data
	 *
	 * @var array
	 */
	var $_data = null;
	/**
	 * Category total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

  /**
	 * table_prefix - table prefix for all component table
	 * 
	 * @var string
	 */
	var $_table_prefix = null;
	
	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		global $mainframe, $context;

		//initialize class property
	  $this->_table_prefix = '#__cam_property';	
	  
		
	
	
	}
	
	
	/**
	 * Method to get a helloworld data
	 *
	 * this method is called from the owner VIEW by VIEW->get('Data');
	 * - get list of all helloworld for the current data page.
	 * - pagination is spec. by variables limitstart,limit.
	 * - ordering of list is build in _buildContentOrderBy  	 	 	  	 
	 * @since 1.5
	 */
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
			$_detail = & $this->getTable('property');
			
			
			if(!$_detail->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}

			return true;
		}
		return false;
	}
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
	/**
	 * Method to get the total number of helloworld items
	 *
	 * @access public
	 * @return integer
	 */
	function store($data)
	{

	 	// give me JTable object	
		$row =& $this->getTable('property');
		
		jimport('joomla.user.helper');
		
		// Bind the form fields to the  table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the  detail record into the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
	function getTotal()
	{
		//DEVNOTE: Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			//$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	
	/**
	 * Method to get a pagination object for the helloworld
	 *
	 * @access public
	 * @return integer
	 */
	 //Getting states list by anandkumar on 02-08-11
function getStates(){
		$db =& JFactory::getDBO();
//		$query = "SELECT code,state FROM #__cam_vendor_states ";
		$query = "SELECT * FROM #__state";
		$db->setQuery($query);
        $states=$db->loadObjectList();
		//echo "<pre>"; print_r($states);
		return $states;

}
//Getting states list by anandkumar on 02-08-11 completed
//Getting Board members list
function getboardmembers(){
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
        $user_id = $user->get('id');

		$query = "SELECT id,firstname,lastname,email,board_position FROM #__cam_board_mem where user_id= ".$user_id." ";
		$db->setQuery($query);
        $bmembers=$db->loadObjectList();

		return $bmembers;


}
	function getusers(){
		$db =& JFactory::getDBO();
		//$user =& JFactory::getUser();
        //$user_id = $user->get('id');
//		$query = 'SELECT  CONCAT(name," " ,lastname) "username",id,user_type FROM #__users where user_type=12 or user_type=13 order by name';
		$query = 'SELECT  CONCAT(name," " ,lastname) "username",id,user_type FROM #__users where user_type=13 order by name';
		$db->setQuery($query);
        $users=$db->loadObjectList();

		return $users;


}
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
	function _buildQuery()
	{  
	 //code added on 06-02-2010
	    $db =& JFactory::getDBO();
		$orderby	= $this->_buildContentOrderBy();
		//$search		= JRequest::getWord('search');
	   // $where = ' WHERE LOWER(C.catname) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
	   // $where .=  ' OR LOWER(C.catdescription) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
	  // $query = 'SELECT * FROM #__cam_customer_companyinfo as C LEFT JOIN #__users as U ON U.id=C.cust_id WHERE U.id='.$_REQUEST[cid][0];
	//		$query = "SELECT * FROM #__cam_property where id='".$_REQUEST['cid'][0]."'";
		$query = "SELECT U.*, V.id as cid, V.County FROM #__cam_property as U, #__cam_counties as V where U.id=".$_REQUEST['cid'][0]." and U.state = V.State ";
		//code added on 06-02-2010
	    /*$orderby	= $this->_buildContentOrderBy();
		$query = ' SELECT * FROM '.$this->_table_prefix.'category'.$orderby;
		*/
		return $query;
	}
	function &getvendorslist() 
	{
	  global $mainframe;
	  $javascript		= ' onchange="document.adminForm.submit();" ';
	  $catlist[] = JHTML::_('select.option', '0', '-Choose Category-');
	  $this->_filter_catlist			= $mainframe->getUserStateFromRequest( $context.'filter_catlist', 'filter_catlist', 0,	'string' );	
	  $query = 'SELECT id,catname FROM #__symaffiliate_category order by catname asc' ;
	  $this->_db->setQuery($query);
	  $objects = $this->_db->loadObjectList() ; 
		foreach( $objects as $obj ) 
		{
			$catlist[] = JHTML::_('select.option',  $obj->id, $obj->catname);
		}
	 $result = JHTML::_('select.genericlist',	$catlist, 'filter_catlist', 'class="inputbox" size="1" ' . $javascript , 'value', 'text', $this->_filter_catlist);	
	 
	 return $result;
	}
	function _buildContentOrderBy()
	{
		global $mainframe, $context;
		//DEVNOTE:give me ordering from request
		//$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order',      'filter_order', 	  'ordering' );
		$filter_order		= JRequest::getWord('filter_order');
		if($filter_order == '')
		$filter_order = 'property_name';
		else
		$filter_order = $filter_order;
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir', '' );		

		//DEVNOTE: all countries are in the same category(no category)  
		$orderby 	= ' ORDER BY  '. $filter_order .' '. $filter_order_Dir;				
		return $orderby;
	}

	function delete($cid = array())
	{
		
		$result = false;
		if (count( $cid ))
		{
		 $cids = implode( ',', $cid );
		 $query = 'DELETE FROM #__cam_property WHERE id IN ( '.$cids.' )';
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
