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
class propertyownerModelpropertyowner extends JModel
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
	  $this->_table_prefix = '#__users';	
	  
		//DEVNOTE: Get the pagination request variables
		//$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		//$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
       /* if($_REQUEST['limit'] == '' && $_REQUEST['limitstart'] == '')
		{
		 $limit = 20;
		 $limitstart = 0;
		}
		else
		{
		 $limit = $_REQUEST['limit'];
		 $limitstart = $_REQUEST['limitstart'];
		}
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);*/
		$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
         $filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		'affid',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'desc',			'word' );
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
if($_REQUEST['limit']){
		//echo 'anand';
		$limit=$limit;
		$limitstart=$limitstart;
		} else {
		$limit ='0';
		$this->_state->limit='0';
		$limitstart ='0';
		}
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
		//print_r($_REQUEST);
	   	 $db =& JFactory::getDBO();
		 $orderby	= $this->_buildContentOrderBy();
		 $userstatus  = JRequest::getVar('userstatus');
		 $search	  = JRequest::getVar('search');
		 $vendorlogs  = JRequest::getVar('vendorlogs');
		 if($search && $userstatus){
			  $where ="WHERE u.id=c.cust_id AND c.status='".$userstatus."'";
			  $where .= ' AND (LOWER(u.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			  $where .=  ' OR LOWER(u.lastname) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).')';
		} else if($userstatus){
		       $where ="WHERE u.id=c.cust_id AND c.status='".$userstatus."'";
		 } else if($search){
			  $where = " WHERE (LOWER(u.name) LIKE ".$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			  $where .=  " OR LOWER(u.lastname) LIKE ".$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).')';
			 //$where = ' WHERE LOWER(user.email) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
	     } 
		else if( $vendorlogs == 'log' ){
			$loggedusers = $this->getloggedids();
			$idslogs = implode( ',', $loggedusers );
			if( $idslogs )
			$where ="WHERE c.cust_id IN (" . $idslogs . ") ";
			else
			$where ="WHERE c.cust_id IN ('') ";
		}
		else if( $vendorlogs == 'notlog' ){
			$loggedusers = $this->getloggedids();
			$idslogs = implode( ',', $loggedusers );
			if( $idslogs )
			$where ="WHERE c.cust_id NOT IN (" . $idslogs . ") ";
			else
			$where ="WHERE c.cust_id NOT IN ('') ";
		}


		 else {
		      $where ="WHERE u.id=c.user_id "; 
		 } 
		 


		 $where.= " AND u.user_type!=11 ";
		 
		$usertpe = 'u.user_type=16';
		
		
		$query = 'SELECT u.user_type,u.id,u.lastname,u.name,u.email,u.registerDate,u.lastvisitDate,u.phone,u.username,u.accounttype,u.password,u.block as published,c.fax FROM #__users as u LEFT JOIN #__cam_propertyowner_info as c ON u.id=c.user_id  '.$where.' AND '.$usertpe.'';
		
	  // $orderby	= $this->_buildContentOrderBy();
	
		//echo $query;
		return $query;
	}

	function getloggedids(){
			$db =& JFactory::getDBO();
			$sql = "SELECT userid FROM jos_session WHERE guest='0' AND client_id='0' ";
			$db->Setquery($sql);
			$loguser = $db->loadResultArray();
			return $loguser;
	}
	
	function _buildContentOrderBy()
	{
		global $mainframe, $context;

		//DEVNOTE:give me ordering from request
		//$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order',      'filter_order', 	  'ordering' );
		if($_REQUEST['filter_order'] == '')
		$filter_order = 'u.registerDate';
		else
		$filter_order = $_REQUEST['filter_order'];
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
			$query = 'DELETE FROM '.$this->_table_prefix.' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			
			}
			$query = 'UPDATE #__cam_property SET property_link= 0 WHERE propertyowner_manage IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			
			}
			
		}
		return true;
	}
	
	
function getallmasterfirms(){
		$db =& JFactory::getDBO();
		$query = "SELECT u.id, u.name, u.lastname, v.comp_name from #__users as u, #__cam_customer_companyinfo as v where u.accounttype='master' and u.id=v.cust_id ";
		$db->Setquery($query);
		$masterfirms = $db->loadObjectList();
		return $masterfirms; 
	}
	function getfirmdetails($firmid){
		$db =& JFactory::getDBO();
		$query = "SELECT comp_name, mailaddress, comp_phno  from #__cam_customer_companyinfo where cust_id=".$firmid."";
		$db->Setquery($query);
		$firmdata = $db->loadObject();
		return $firmdata; 
	}
	
	// Function to get the district managers
	function dmanagers($camfirmid, $disid, $type){
		$db =& JFactory::getDBO();
		
		if($type == 'cm'){
			// To get all managers under the camfirm
			$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$camfirmid." ";
			$db->Setquery($sql);
			$compnayid = $db->loadResult();
			$sql = "SELECT cust_id, dmanager from #__cam_customer_companyinfo as u, #__users as v where u.comp_id=".$compnayid." and u.cust_id=v.id ";
			$db->Setquery($sql);
			$total_customers = $db->loadObjectList();
					for( $m=0; $m<count($total_customers++); $m++ ){
					// To check the manager is set to district  manager or not
					$sql_check = "SELECT DISTINCT(dmanager) from #__cam_invitemanagers where managerid=".$total_customers[$m]->cust_id." and dmanager!=0 and dmanager!=".$camfirmid." ";
					$db->Setquery($sql_check);
					$dmanagerexist = $db->loadResult();
					//Completed
					if($total_customers[$m]->dmanager == 'yes' ||  $dmanagerexist == '' ){
						$dmanagerss[] = $total_customers[$m]->cust_id;
					}
				}
		
		}
		else {
			$sql_mans = "SELECT managerid from #__cam_invitemanagers where dmanager=".$disid." and managerid!='0' ";
			$db->Setquery($sql_mans);
			$managers_dm = $db->loadObjectList();
				if($managers_dm){
					foreach($managers_dm as $mansids){
						$dmanagerss[] = $mansids->managerid;
					}
				}
		}
		
		$firmsarr = implode(',',$dmanagerss);
		//Completed
		$sql_firms = "SELECT u.user_type,u.id,u.lastname,u.name,u.email,u.registerDate,u.lastvisitDate,u.dmanager,u.phone,u.username,u.flag,u.suspend,u.password,u.block as published,c.camfirm_license_no,c.comp_id ,c.comp_name,c.tax_id,c.status,c.cust_id,u.accounttype FROM #__users as u LEFT JOIN #__cam_customer_companyinfo as c ON c.cust_id= u.id WHERE u.id=c.cust_id AND u.user_type!=11 AND u.id IN(".$firmsarr.") group by u.id ORDER BY u.registerDate desc";

		$db->Setquery($sql_firms);
		$districtmanagers = $db->loadObjectlist();
		return $districtmanagers; 
	}
	//Completed
}
?>
