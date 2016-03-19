<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//error_reporting(0);
// import MODEL object class
jimport('joomla.application.component.model');


class vendorcompliancesModelvendorcompliances extends JModel
{
	var $_id = null;

	var $_data = null;

	var $_table_prefix = null;
	
	function __construct()
	{
		parent::__construct();

		//initialize class property
	  $this->_table_prefix = '#__cam_';		
	  
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);

	}


	function setId($id)
	{
		$this->_id		= $id;
		$this->_data	= null;
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
		//if($user->id=='1313'){ print_r($res);} 
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
		
		$alert_sql ="SELECT count(*) from #__cam_vendor_compliance_w9docs  WHERE w9_status != 1 AND vendor_id=".$user->id; //validation to status of docs
		$db->Setquery($alert_sql);
		$res4 = $db->loadResult();
		$alert['W9_status']= $res4;
		

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
		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence   WHERE GLI_end_date  >= '".$today."' AND GLI_status = 1 AND vendor_id=".$user->id; 
		$db->Setquery($alert_sql);
		$res8 = $db->loadResult();
		if($res8 != 0) $res8=0; else $res8=1;
		$alert['GLI_exp']= $res8;
		//echo "<pre>"; print_r($vendor_GLI_compliance_alert);
		return $alert;
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
		// echo "<pre>"; print_r($this->_data);
		return $this->_data;
}

	function _buildQuery()
	{  
	 //code added on 06-02-2010
	    $db =& JFactory::getDBO();
		$orderby	= $this->_buildContentOrderBy();
		$search	  = JRequest::getVar('search');
		
		 if($search) {
		  $where = " and (LOWER(U.name) LIKE " .$db->Quote( '%'.$db->getEscaped( $search, true ). '%' );
		   $where .=  " OR LOWER(U.lastname) LIKE " .$db->Quote( '%'.$db->getEscaped( $search, true ). '%').'  OR LOWER(V.company_name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ). '%').')';
		 }
		//$W9query = "SELECT U.id, U.name,U.email, U.lastname,V.w9_upld_cert FROM #__users as U LEFT JOIN #__cam_vendor_compliance_w9docs as V ON V.vendor_id = U.id WHERE V.vendor_id = U.id  ".$orderby;
		$W9query = "SELECT U.id, U.name,U.email, U.lastname, V.company_name, V.id as vid FROM #__users as U LEFT JOIN #__cam_vendor_company as V ON V.user_id = U.id WHERE U.block=0 AND U.user_type = 11 AND V.status = 'approved' ".$where." ".$orderby;
		return $W9query;
	}
	
	function _buildContentOrderBy()
	{

		global $mainframe, $context;

		if($_REQUEST['filter_order'] == '')
		$filter_order = 'V.user_id';
		elseif($_REQUEST['filter_order'] == 'V.vendor_id')
		$filter_order = 'V.user_id';
		else
		$filter_order = $_REQUEST['filter_order'];
		//$filter_order = 'V.user_id';
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir', '' );		

		//DEVNOTE: all countries are in the same category(no category)  
		$orderby 	= ' ORDER BY  '. $filter_order .' '. $filter_order_Dir;				

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
			$query = 'SELECT h.*, c.published AS cat_pub FROM '.$this->_table_prefix.' AS h'.
 			' LEFT JOIN '.$this->_table_prefix.'country AS c ON c.id_country = h.catid' .
		  ' WHERE h.id = '. $this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}
  	

	function store($data)
	{
	 	// give me JTable object	
		//echo "<pre>"; print_r($data);	 exit;	 	
		$row =& $this->getTable('configuration');
		
		// Bind the form fields to the  table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		//echo "<pre>"; print_r($data);	 	
		// Create the timestamp for the date field
		// Store the  detail record into the database
		if (!$row->store()) {
			echo $this->setError($this->_db->getErrorMsg()); 
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
			$query = 'DELETE FROM '.$this->_table_prefix.'configuration WHERE id IN ( '.$cids.' )';
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
