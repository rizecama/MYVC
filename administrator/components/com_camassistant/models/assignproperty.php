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
class assignpropertyModelassignproperty extends JModel
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
	  
		//DEVNOTE: Get the pagination request variables
		//$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		//$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
		$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
         $filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		'affid',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'desc',			'word' );
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

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
	function getTotal()
	{
		//DEVNOTE: Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
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
	//echo "<pre>"; print_r($_REQUEST); exit;
	    $db =& JFactory::getDBO();
		$orderby	= $this->_buildContentOrderBy();
		$pid = JRequest::getVar( 'propertyname','' );
		$firmid = JRequest::getVar( 'camfirmname','' );
		$manager = JRequest::getVar( 'manager','' );
		$state = JRequest::getVar( 'state','' );
		$city = JRequest::getVar( 'city','' );

		if($firmid)
		$where[] = 'U.company_id='.$firmid.'';
		//echo $manager;
		if($manager)
		$where[] = 'U.property_manager_id='.$manager.'';
		if($state)
		$where[] = 'U.state="'.$state.'"';
		if($city)
		$where[] = 'U.city="'.$city.'"';
		if($pid)
		$where[] = 'U.id="'.$pid.'"';
		
		//echo $where[0];
		$where[] = 'V.id=U.property_manager_id and W.cust_id=U.property_manager_id';
		if(count($where)>1){
		$wherecon=implode(' and ',$where);
		}else{$wherecon=$where[0]; }
		
		$query = 'SELECT U.id as pid,U.*,V.name,V.lastname,V.user_type,V.id,W.comp_name, W.camfirm_license_no FROM #__cam_property as U, #__users as V,#__cam_customer_companyinfo as W where '.$wherecon.''.$orderby;
		
		return $query;
	}
	///All properties
	function getproperties(){
	 $db =& JFactory::getDBO();
	 $query = 'SELECT U.id as pid,U.*,V.name,V.lastname,V.user_type,V.id FROM #__cam_property as U, #__users as V where V.id=U.property_manager_id order by U.property_name';
	 $db->setQuery($query);
	 $properties=$db->loadObjectList();
	 return $properties;
	}
	//Completed
	//All firms
	function getcamfirms(){
	 $db =& JFactory::getDBO();
	 $query = 'SELECT id,comp_name from #__cam_camfirminfo order by comp_name ASC';
	 $db->setQuery($query);
	 $camfirms=$db->loadObjectList();

	 return $camfirms;
	}
	//Completed
	//All managers
	function getmanagers(){
	 $db =& JFactory::getDBO();
	 $query = 'SELECT id,name,lastname FROM #__users order by name ASC';
	 $db->setQuery($query);
	 $managers=$db->loadObjectList();
	 return $managers;
	}
	//Completed
	//All states
	function getstates_sort(){
	 $db =& JFactory::getDBO();
	 $query_states = "SELECT * FROM #__state order by state_name ASC";
	 $db->setQuery($query_states);
	 $states=$db->loadObjectList();
	 return $states;
	}
	//Completed
	//All cities
	function getcities_sort(){
	 $db =& JFactory::getDBO();
	 $query_cities = "SELECT DISTINCT(city) FROM #__cam_property order by city ASC";
	 $db->setQuery($query_cities);
	 $cities=$db->loadObjectList();
	 return $cities;
	}
	//Completed
	
	
	
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

	function remove($cid = array())
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
	/*function getcustmers(){
		$user =& JFactory::getUser();
		$user_id = $user->get('id');
		$db=&JFactory::getDBO();
		$query = "SELECT id FROM #__cam_camfirminfo";
		$db->setQuery($query);
		$comp_id = $db->loadResult();
//		$query = "SELECT name,lastname,id from #__users where user_type=13 or user_type=12 ORDER BY name ASC"; 
		$query = "SELECT name,lastname,id from #__users where (user_type=13 or user_type=12) and block=0 ORDER BY name ASC"; 
		$db->setQuery($query);
        $custmers=$db->loadObjectList();
		return $custmers;

		}*/
	function getcustmers(){
		
		$db=&JFactory::getDBO();
		$query_firm = "SELECT comp_name,cust_id,id FROM #__cam_camfirminfo order by comp_name ASC";
		$db->setQuery($query_firm);
		$custmers = $db->loadObjectList();
		
		return $custmers;

		}
	
}
?>
