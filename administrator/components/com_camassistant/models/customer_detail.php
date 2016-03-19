<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
error_reporting(0);
// import MODEL object class
jimport('joomla.application.component.model');


class customer_detailModelcustomer_detail extends JModel
{
	var $_id = null;

	var $_data = null;

	var $_table_prefix = null;
	
	function __construct()
	{
		parent::__construct();

		//initialize class property
	  $this->_table_prefix = '#__cam_customer_companyinfo';		
	  
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
				
		$query = 'SELECT * FROM #__cam_customer_companyinfo as C LEFT JOIN #__users as U ON U.id=C.cust_id WHERE C.cust_id='.$_REQUEST[cid][0];

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
	 function get_thumbnail_dimensions()
	{
		$db = JFactory::getDBO();
		$sql = "SELECT vendor_logo_height,vendor_logo_width FROM #__cam_configuration";
		$db->Setquery($sql);
		$dimensions = $db->loadObjectList();
		return $dimensions;
	}
	// This is the function to Covert Thubnail Image 
	function image_resize_to_max($uploadfile,$max_width,$max_height,$uploadDir,$file)
	{
		/******* To Get the size and MIME type of the requested image ****/
		$size		= getimagesize($uploadfile);
		$mime		= $size['mime'];
		/********** To Create the New Image from the Restricted Image ********/
		switch($mime)
		{
			case	'image/gif'		:	$src = imagecreatefromgif($uploadfile);
										break;
			case	'image/png'		:	$src = imagecreatefrompng($uploadfile);
										break;
			default					:	$src = imagecreatefromjpeg($uploadfile);
										break;						
		}
		$width		= $size[0];
		$height		= $size[1];
		
		//for large images
		/*********** Assiging The Maximum Width & Height of Image ****/
		if($width > $max_width || $height > $max_height)
		{
			$newwidth	= $max_width;
			$newheight	= ($height/$width)*$newwidth;
		}
		else
		{
			$newwidth	= $width;
			$newheight	= $height;
		}
		$tmp	= imagecreatetruecolor($max_width,$max_height);
		imagecopyresampled($tmp,$src,0,0,0,0,$max_width,$max_height,$width,$height);
		$filename = $uploadDir.DS.$file;
		switch($mime)
		{
			case	'image/gif'		:	imagegif($tmp,$filename);
										break;
			case	'image/x-png'	:
			case	'image/png'		:	imagepng($tmp,$filename);
										break;
			default					:	imagejpeg($tmp,$filename,100);
										break;						
		}
		imagedestroy($src);
		imagedestroy($tmp);
	}//end of function
	
	function getcompanylist()
	{
			$db		= &JFactory::getDBO();
			$query1 = 'SELECT u.*, v.name, v.lastname FROM #__cam_camfirminfo as u, #__users as v where u.cust_id=v.id and v.accounttype!="master" GROUP BY id ORDER BY u.comp_name';
			$db->setQuery($query1);
			$cdata= $db->loadObjectList();
			return $cdata;
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
  	

	function store($data)
	{
	
	 	// give me JTable object			 	
		$row = & $this->getTable('customer_detail');
		/*echo "<pre>";
		print_r($data);
		print_r($row);exit;*/
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
	
	function store_camfirm($data1)
	{
	 	// give me JTable object	
		$row1 = & $this->getTable('camfirm');
//		echo "<pre>";  print_r($data); print_r($data1); exit;
		// Bind the form fields to the  table
		if (!$row1->bind($data1)) {
			//echo "<pre>"; print_r($row); 	
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// Create the timestamp for the date field
		// Store the  detail record into the database
		if (!$row1->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
	
		function getstates()
	{
		$db = JFactory::getDBO();
		 $db->setQuery("SELECT id as value,state_name as text FROM #__state ORDER BY text ASC");
		$states = $db->loadObjectList();
		return $states;	
	}
	function delete($cid = array())
	{
		//exit;
		$db = & JFactory::getDBO();
			$result = false;
		if (count( $cid ))
		{ 
			
			$cids = implode( ',', $cid );
	 		/*$query = 'SELECT cust_id FROM #__cam_customer_companyinfo WHERE cust_id  IN ('.$cids.')';
			$db->setQuery($query);
			$result = $db->loadObjectList();
			$userid = $result[0]->cust_id;*/
		
		$userid = $cids;
			//to delete records from vendors table
			$query1 = 'DELETE FROM #__cam_customer_companyinfo WHERE cust_id IN ( '.$userid.' )';
			$this->_db->setQuery( $query1 );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			} 
		
			//to delete records from users table
			$query2 = 'DELETE FROM #__users WHERE id IN ( '.$userid.' )';
			$this->_db->setQuery( $query2 );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;				
			}
			//to delete rocords from cam_rfpsow_addexception table
			 $query3 = 'DELETE FROM #__cam_camfirminfo WHERE  cust_id  IN ( '.$userid.' )';
			$this->_db->setQuery( $query3 );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;	
							
			}
			 $query4 = 'DELETE FROM #__cam_invitemanagers WHERE  managerid  IN ( '.$userid.' )';
			$this->_db->setQuery( $query4 );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;	
							
			}
			//exit;
		}

		return true;
		/*$result = false;
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
		return true;*/
	}
		//function to add questions
	function getquestions()
	{
		$db =& JFactory::getDBO();
		$ques = "SELECT  id as value, question  as text  FROM #__questions where published=1";
		$db->setQuery($ques);
		$questions = $db->loadObjectList();
		return $questions;
	}
	//completed
	
	function updatesuspend($userid,$suspend,$flag){
		$db =& JFactory::getDBO();
		$userinfo = "SELECT  user_type, accounttype, dmanager FROM #__users where id=".$userid." ";
		$db->setQuery($userinfo);
		$user = $db->loadObject();
			if($user->user_type == 13 && $user->accounttype != 'master') {
			$totalmanagers = $this->gettotalmanagersofcamfirm($userid);
			$whereas[] = "id IN (".implode( ' , ' , $totalmanagers).") ";
			}
			else if($user->dmanager == 'yes'){
			$total_mangrs = $this->gettotalmanagersofdm($userid) ;	
			$whereas[] = "id IN (".implode( ' , ' , $total_mangrs).") ";
			}
			else if($user->user_type ==13 && $user->accounttype == 'master')
			{
			$total_mangrs = $this->getmastermanagers($userid) ;
			$whereas[] = "id IN (".implode( ' , ' , $total_mangrs).") ";
			}
			else{
			$whereas[] = "id IN (".$userid.") ";
			}
			$update_rfpinfo="UPDATE #__users SET suspend='".$suspend."', flag='".$flag."' where ".  implode( ' AND ', $whereas ) ;
			
			$db->setQuery($update_rfpinfo);
			$res=$db->query();
		
			return $res;
	}
	
	function gettotalmanagersofcamfirm($useridu){
	$db = JFactory::getDBO();
	$query = "SELECT id FROM #__cam_camfirminfo WHERE cust_id=".$useridu;
	$db->setQuery($query);
	$comp_id = $db->loadResult();
	$userid=array($useridu);
	$query_mans = "SELECT cust_id from #__cam_customer_companyinfo where comp_id = ".$comp_id." ";
	$db->setQuery($query_mans);
    $Managers_list = $db->loadObjectList();
	
	foreach( $Managers_list as $cf_mans)
		{
			$total_mangrs[] = $cf_mans->cust_id ;
		}
	if($total_mangrs){
		$totalcust_id1 = array_merge($userid,$total_mangrs); 
	}
	else{
		$totalcust_id1[] = $userid; 
	}
	
	return $totalcust_id1; 	
	}
	
	function gettotalmanagersofdm($useridu){
	$db = JFactory::getDBO();
	$dmmanagers = "SELECT DISTINCT managerid FROM #__cam_invitemanagers WHERE dmanager=".$useridu;
	$db->setQuery($dmmanagers);
	$dm_managers = $db->loadObjectlist();
					
		for($i=0; $i<count($dm_managers);$i++){
			$query = "SELECT id from #__users where id='".$dm_managers[$i]->managerid."'" ;
			$db->setQuery($query);
			$total_mangrs[]=$db->loadResult();
			}
	$userid=array($useridu);		
	if($total_mangrs){
		$totalcust_id1 = array_merge($userid,$total_mangrs); 
	}
	else{
		$totalcust_id1[] = $userid; 
	}
	
	 return $totalcust_id1; 		
	}
		
	function getmastermanagers($useridu){
			$db=&JFactory::getDBO();
			$sql1 = "SELECT firmid from #__cam_masteraccounts where masterid=".$useridu." ";
			$db->Setquery($sql1);
			$subfirms = $db->loadObjectlist();
			
	if($subfirms)
		{
			for( $a=0; $a<count($subfirms); $a++ )
				{
					$firmid1[] = $subfirms[$a]->firmid;
					$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$subfirms[$a]->firmid." ";
					$db->Setquery($sql);
					$companyid[] = $db->loadResult();
											
				}
				
        }
			
	if($companyid)
		{
         	for( $c=0; $c<count($companyid); $c++ )
				{
					$sql_cid = "SELECT cust_id from #__cam_customer_companyinfo where comp_id=".$companyid[$c]." ";
					$db->Setquery($sql_cid);
					$managerids = $db->loadObjectList();
						if($managerids) {
							foreach( $managerids as $last_mans){
								$total_mangrs[] = $last_mans->cust_id ;
							}
						}
               }
        }
	
	if($firmid1 && $total_mangrs )
		{
            $total_mangrs = array_merge($total_mangrs,$firmid1); 
        }
        if($firmid1){
            for( $d=0; $d<count($firmid1); $d++ ){
        $query = "SELECT id FROM #__cam_camfirminfo WHERE cust_id=".$firmid1[$d];
	$db->setQuery($query);
	$comp_id = $db->loadResult();
	$userid = array($useridu);
	$query_mans = "SELECT cust_id from #__cam_customer_companyinfo where comp_id = ".$comp_id." ";
	$db->setQuery($query_mans);
        $Managers_list1 = $db->loadObjectList();
                if($Managers_list1) {
                        foreach( $Managers_list1 as $Managers_list2){
                                $Managers_list[] = $Managers_list2->cust_id ;
                        }
                }
            }
            if($Managers_list){
        $total_mangrs = array_merge($Managers_list,$firmid1);
            } else {
         $total_mangrs = $firmid1;        
            }
        }
	/*if($firmid1){
            $total_mangrs = $firmid1;
        }
         */
        $userid=array($useridu);
        if($total_mangrs){
        $total_mangrs = array_merge($userid,$total_mangrs); 
		}
		else{
		$total_mangrs[] = $userid; 
		}
		return $total_mangrs;
	}	
	
	// Get all preferred vendor codes
	function getallcodes(){
		$db = & JFactory::getDBO();
		$sql_codes = "SELECT * FROM #__cam_master_vendorcodes where masterid ='".$_REQUEST[cid][0]."' and publish='1' ";
		$db->setQuery( $sql_codes );
		$totalcodes = $db->loadObjectList();
		
		for( $t=0; $t<count($totalcodes); $t++ ){
			// Check total earned and balance
			$paymentdata = $this->getpaymentdata($totalcodes[$t]->id,$_REQUEST[cid][0]);
			$paidinfo = explode('---',$paymentdata);
			$totalcodes[$t]->total_earned = $paidinfo[3];
			$totalcodes[$t]->balance = $paidinfo[1];
			// To get all checks supplied
			$totalcodes[$t]->checks_served = $this->getchecksdata($totalcodes[$t]->id,$_REQUEST[cid][0]);
		}
		
		return $totalcodes;
	}
		
	//Function to get paymanet information
	//Function to get balance 
	function getpaymentdata($codeid,$masterid){
		$db = & JFactory::getDBO();
		$total_earned = $this->gettotalearned($codeid);
		$alreay_requested = $this->gettotalrequested($codeid,$masterid);
		//$balance = $total_earned - $alreay_requested;
		$balance = $total_earned - $alreay_requested;
		if( $balance > 0 )
			$result = "yes---".$balance."---".$alreay_requested."---".$total_earned;	
		else
			$result = "no---".$balance."---".$alreay_requested."---".$total_earned;	
		return $result;
	}
	
	//Function to get the price total earned
	function gettotalearned($code){
		$db = & JFactory::getDBO();
		$sql_earned = "SELECT count(id) FROM #__cam_vendor_purchasedcodes where codeid=".$code."";
		$db->setQuery( $sql_earned );
		$count_ids = $db->loadResult();
		
		//Get the code cost
		$sql_cost = "SELECT cost FROM #__cam_master_vendorcodes where id=".$code."";
		$db->setQuery( $sql_cost );
		$codecost = $db->loadResult();
		$total_earned = $count_ids * $codecost;
		return $total_earned;	
	}
	//Function to get requested money already
	function gettotalrequested($codeid,$masterid){
		$db = & JFactory::getDBO();
		$user =& JFactory::getUser();
		$sql_request = "SELECT SUM(tf_money) FROM #__cam_transfer_money where codeid=".$codeid." and masterid=".$masterid." ";
		$db->setQuery( $sql_request );
		$requested = $db->loadResult();
		return $requested;	
	}
	
	//Function to process all checks
	function getchecksdata($codeid,$masterid){
		$db = & JFactory::getDBO();
		$user =& JFactory::getUser();
		$sql_request = "SELECT tf_money, checkid, id FROM #__cam_transfer_money where codeid=".$codeid." and masterid=".$masterid." ";
		$db->setQuery( $sql_request );
		$requested = $db->loadObjectList();
		
		return $requested;	
	}
	//Completyed
		function savetfinfo($data1)
	{
	 	// give me JTable object	
		$row1 = & $this->getTable('sendmoney');
//		echo "<pre>";  print_r($data); print_r($data1); exit;
		// Bind the form fields to the  table
		if (!$row1->bind($data1)) {
			//echo "<pre>"; print_r($row); 	
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// Create the timestamp for the date field
		// Store the  detail record into the database
		if (!$row1->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
		
}

?>
