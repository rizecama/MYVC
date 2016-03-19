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
//error_reporting(0);
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
class vendorsModelvendors extends JModel
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
	  $this->_table_prefix = '#__cam_';	
	  
		//DEVNOTE: Get the pagination request variables
		//$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		//$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
		$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
         $filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		'affid',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'desc',			'word' );
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		/*$limit		= JRequest::getWord('limit');
		$limitstart		= JRequest::getWord('limitstart');
        if($limit == '' && $limitstart == '')
		{
		 $limit = 20;
		 $limitstart = 0;
		}
		else
		{
		 $limit = $limit;
		 $limitstart = $limitstart;
		}
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
*/
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
		//echo '<pre>'; print_r($_REQUEST); exit;
		 $db =& JFactory::getDBO();
		 $vendorstatus  = JRequest::getVar('vendorstatus');
		 $vendorlogs  = JRequest::getVar('vendorlogs');
		 $search	  = JRequest::getVar('search');
		$orderby	= $this->_buildContentOrderBy();
		$filter_companylist		= JRequest::getWord('companies');
		$filter_vendorslist		= JRequest::getWord('filter_vendorslist');
		
		if( $vendorlogs == 'log' ){
			$loggedusers = $this->getloggedids();
			$idslogs = implode( ',', $loggedusers );
				if( $idslogs )
				$where =" AND U.id IN (".$idslogs.")";
				else
				$where =" AND U.id IN ('')";
			
			
		}
		else if( $vendorlogs == 'notlog' ){
			$loggedusers = $this->getloggedids();
			$idslogs = implode( ',', $loggedusers );
			if( $idslogs )
			$where =" AND U.id NOT IN (".$idslogs.")";
			else
			$where =" AND U.id NOT IN ('')";
		}
		else if($_REQUEST['companies'] == '' && $filter_vendorslist != ''){
		if(isset($filter_vendorslist) && $filter_vendorslist == 'IH')
		$where = ' AND in_house_vendor = "yes"';
		else if(isset($filter_vendorslist) && $filter_vendorslist == 'PF')
		$where = ' AND preferred_vendors = "yes"';
		else if(isset($filter_vendorslist) && $filter_vendorslist == 'EX')
		$where = ' AND not_interest_RFP  = "yes"';
		
		} else if($_REQUEST['companies'] != '' && $filter_vendorslist == ''){
		$where = ' AND in_house_parent_company =' ."'".$_REQUEST['companies']."'";
		
		} else if($search && $vendorstatus){ 
			  $where = ' AND V.status="'.$vendorstatus.'" AND (LOWER(U.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).' OR LOWER(U.lastname) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).' OR LOWER(V.company_name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).')';
		   } else if($vendorstatus){
		$where =" AND V.status='".$vendorstatus."'";
		} else if($search){
			 $where = ' AND (LOWER(U.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).' OR LOWER(U.lastname) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).' OR LOWER(V.company_name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).')';
		} 
		else {
		if(isset($filter_vendorslist) && $filter_vendorslist == 'IH' && isset($filter_companylist))
		$where = ' AND in_house_vendor = "yes" AND in_house_parent_company =' ."'".$_REQUEST['companies']."'";
		else if(isset($filter_vendorslist) && $filter_vendorslist == 'PF' && isset($filter_companylist))
		$where = ' AND preferred_vendors = "yes" AND in_house_parent_company =' ."'".$_REQUEST['companies']."'";
		else if(isset($filter_vendorslist) && $filter_vendorslist == 'EX' && isset($filter_companylist))
		$where = ' AND not_interest_RFP  = "yes" AND in_house_parent_company =' ."'".$_REQUEST['companies']."'";
		}
	   	
		
		//$search		= JRequest::getWord('search');
	   	// $where = ' WHERE LOWER(C.catname) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
	    //$where .=  ' OR LOWER(C.catdescription) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		if($filter_vendorslist == '' && $filter_companylist == ''&& $vendorstatus=='' && !$search && $vendorlogs == '')
		$query = ' SELECT V.id,V.user_id,V.status,V.company_name,V.tax_id,V.company_phone,V.in_house_parent_company,U.name,U.lastname,U.email,U.ccemail,U.username,U.salutation,U.phone,U.extension,U.cellphone,U.user_type,U.password,U.lastvisitDate,U.registerDate,U.flag,U.suspend,U.subscribe,U.subscribe_type,U.block as published  FROM #__users as U LEFT JOIN #__cam_vendor_company as V ON U.id = V.user_id WHERE U.user_type = 11'.$orderby;
		 else
		 $query = ' SELECT  V.id,V.user_id,V.status,V.company_name,V.tax_id,V.company_phone, V.in_house_parent_company,U.name,U.lastname,U.email,U.ccemail,U.salutation,U.phone,U.username,U.extension,U.cellphone,U.user_type,U.password,U.lastvisitDate,U.registerDate,U.flag,U.suspend,U.subscribe,U.subscribe_type,U.block as published  FROM #__users as U LEFT JOIN #__cam_vendor_company as V ON U.id = V.user_id WHERE U.user_type = 11'.$where.$orderby; 
		
		//code added on 06-02-2010
	    /*$orderby	= $this->_buildContentOrderBy();
		$query = ' SELECT * FROM '.$this->_table_prefix.'category'.$orderby;
		*/
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
	
		
	function &getvendorslist() 
	{  
		global $mainframe;
		$javascript		= ' onchange="document.adminForm.submit();" ';
		$vendorslist[] = JHTML::_('select.option', '0', '-Choose Vendors-');
		$this->_filter_vendorslist	= $mainframe->getUserStateFromRequest( $context.'filter_vendorslist', 'filter_vendorslist', 0,	'string' );	
		$objects[0]->id 	= 'IH';
		$objects[0]->type = 'In-House Vendors';
		$objects[1]->id 	= 'PF';
		$objects[1]->type = 'Preffered Vendors';
		$objects[2]->id 	= 'EX';
		$objects[2]->type = 'Excluded Vendors';
		foreach( $objects as $obj ) 
		{
			$vendorslist[] = JHTML::_('select.option',  $obj->id, $obj->type);
		}
		
		//echo "<pre>"; print_r($vendorslist); exit;
		$result = JHTML::_('select.genericlist',$vendorslist, 'filter_vendorslist', 'class="inputbox" size="1" ' . $javascript , 'value', 'text', $this->_filter_vendorslist);	
	 return $result;
	}
	
function getCompanies() 
	{ 
		//echo '<pre>'; print_r($_REQUEST); exit;
		//print_r($_REQUEST['companies']);
		global $mainframe;
		$db = JFactory::getDBO(); 
		
		$companies[] = JHTML::_('select.option', '0', '-Select Companies-');
		$sql = "SELECT id,comp_name FROM #__cam_camfirminfo order by id";
		$db->Setquery($sql);
		$objects = $db->loadObjectList();
		//echo '<pre>'; print_r($objects); exit;
		foreach( $objects as $obj ) 
		{
			$companies[] = JHTML::_('select.option',  $obj->comp_name, $obj->comp_name);
		}
			$javascript = "onchange=\"document.adminForm.submit(this.value)\"";
		//echo "<pre>"; print_r($vendorslist); exit;
		$result = JHTML::_('select.genericlist',$companies, 'companies', 'class="inputbox" size="1" ' . $javascript , 'value','text',$_REQUEST['companies']);
	   return $result;
	}
		
	function _buildContentOrderBy()
	{
		global $mainframe, $context;

		//DEVNOTE:give me ordering from request
		//$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order',      'filter_order', 	  'ordering' );
		$filter_order		= JRequest::getWord('filter_order');
		if($filter_order == '')
		$filter_order = 'name';
		else
		$filter_order = $filter_order;
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir', '' );		

		//DEVNOTE: all countries are in the same category(no category)  
		$orderby 	= ' ORDER BY  '. $filter_order .' '. $filter_order_Dir;				

		return $orderby;
	}
	
	function  proposalCentre_active_inactive($id)
	{
		$db = JFactory::getDBO();
		$user = JFactory::getUser($id);
		$today = date('Y-m-d');
		$query ="select industry_id from #__cam_vendor_industries Where user_id =".$user->id;
		$db->setQuery($query);
		$getindustryids = $db->loadResultArray();
		if($getindustryids)
		{
		if(in_array('56',$getindustryids))
		$PLN_needed = 'yes';
		else $PLN_needed = 'no';
		}
		else
		$PLN_needed = 'no';
		$alert['PLN_needed'] = $PLN_needed;
		$user_type = $user->get('user_type');
		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence  WHERE GLI_end_date  >= '".$today."' AND GLI_upld_cert!= '' AND GLI_policy_occurence!='' AND GLI_policy_aggregate!='' AND GLI_status!='-1' AND vendor_id=".$user->id; //validation to exists of docs
		$db->Setquery($alert_sql);
		$res = $db->loadResult();
		$alert['GLI_exist']= $res;
		
		$alert_sql ="SELECT count(*) from #__cam_vendor_compliance_w9docs  WHERE w9_upld_cert!='' AND w9_status!='-1' AND vendor_id=".$user->id; //validation to exists of docs
		$db->Setquery($alert_sql);
		$res2 = $db->loadResult();
		$alert['W9_exist']= $res2;
		
		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence  WHERE GLI_status = 1 AND vendor_id=".$user->id;
		//$alert_sql = "SELECT count(*) from #__cam_vendor_liability_insurence WHERE GLI_status = 1 AND vendor_id=".$user->id."  AND id=(SELECT MIN(id) from #__cam_vendor_liability_insurence where vendor_id=".$user->id.")";
		$db->Setquery($alert_sql);
		$res3 = $db->loadResult();
		if($res3 != 0) $res3=0; else $res3=1;
		$alert['GLI_status']= $res3;
		
		$alert_sql ="SELECT count(*) from #__cam_vendor_compliance_w9docs  WHERE w9_upld_cert=''  AND ein_number='' AND vendor_id=".$user->id; //validation to status of docs
		$db->Setquery($alert_sql);
		$res4 = $db->loadResult();
		$alert['W9_status']= $res4;
		$today = date('Y-m-d');

		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE PLN_status = 1 AND vendor_id=".$user->id;
		$db->Setquery($alert_sql);
		$res5 = $db->loadResult();
		if($res5 != 0) $res5=0; else $res5=1;
		$alert['PLN_status']= $res5;
		
		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE PLN_expdate  >= '".$today."' AND PLN_status = 1 AND vendor_id=".$user->id; 
		$db->Setquery($alert_sql);
		$res6 = $db->loadResult();
		if($res6 != 0) $res6=0; else $res6=1;
		$alert['PLN_exp']= $res6;
		
		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE PLN_expdate  >= '".$today."' AND PLN_state!='' AND PLN_type!='' AND PLN_upld_cert!='' AND PLN_status!='-1' AND vendor_id=".$user->id;
		$db->Setquery($alert_sql);
		$res7 = $db->loadResult();
		$alert['PLN_exist']= $res7;
		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence   WHERE GLI_end_date  >= '".$today."' AND GLI_upld_cert!= '' AND GLI_policy_occurence!='' AND GLI_policy_aggregate!='' AND vendor_id=".$user->id; 
		$db->Setquery($alert_sql);
		$res8 = $db->loadResult();
		if($res8 != 0) $res8=0; else $res8=1;
		$alert['GLI_exp']= $res8;
		//echo "<pre>"; print_r($vendor_GLI_compliance_alert);
		return $alert;
	}
	
	function delete($cid = array())
	{
	 	// $post = JRequest::get('post');
		$db = & JFactory::getDBO();
		$result = false;
               // echo '<pre>'; print_r($_REQUEST); exit;
                $useremail = JRequest::getVar( 'userid','');
		if (count( $cid )||$useremail)
		{ 
			
			$cids = implode( ',', $cid );
                        if($cids){
	 		$query = 'SELECT user_id FROM '.$this->_table_prefix.'vendor_company WHERE id  IN ('.$cids.')';
			$db->setQuery($query);
			$result = $db->loadObjectList();
			//$userid = $result[0]->user_id;
                        } else {
                         $query = "SELECT id FROM #__users WHERE email='".$useremail."'";
			$db->setQuery($query);
			$result = $db->loadresult();
			$userid = $result;   
                        }
			
			for( $r=0; $r < count( $result ); $r++ ){
			$userid = $result[$r]->user_id;
			//to delete records from vendors table
			$query = 'DELETE FROM '.$this->_table_prefix.'vendor_company WHERE user_id IN ( '.$userid.' )'; 
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				//return false;
			} 
			
			//to delete records from users table
			$query = 'DELETE FROM #__users WHERE id IN ( '.$userid.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				//return false;				
			}
			//to delete rocords from cam_rfpsow_addexception table
			$query = 'DELETE FROM '.$this->_table_prefix.'rfpsow_addexception WHERE  vendor_id  IN ( '.$userid.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				//return false;				
			}
			//to delete records from 
			$query = 'DELETE FROM '.$this->_table_prefix.'rfpsow_addnotes WHERE  vendor_id  IN ( '.$userid.' )'; 
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				//return false;				
			}
			//to delete records from 
 			$query = 'DELETE FROM '.$this->_table_prefix.'rfpsow_uploadfiles WHERE  vendor_id  IN ( '.$userid.' )'; 
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				//return false;				
			}
			//to delete records from 
 			$query = 'DELETE FROM '.$this->_table_prefix.'vendor_inviteinfo WHERE  v_id  IN ( '.$userid.' )'; 
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				//return false;				
			}
		}	
	}

		return true;
	}
	
	
}
?>
