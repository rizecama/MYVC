<?php
/**
 * @version		1.0.0 cam assistant $
 * @package		cam_assistant
 * @copyright	Copyright © 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class vendorsacceptModelvendorsaccept extends Jmodel
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
		$limit		= JRequest::getWord('limit');
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
	
	function getprevendor()
	{
		$db = & JFactory::getDBO();
		$user =& JFactory::getUser();
		$query = 'select * from #__vendor_inviteinfo  where userid = '.$user->id;
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}
// for prefered vendor accepts coded by anandbabu
	function getcheckinvite()
	{
	//echo "<pre>"; print_r($_REQUEST); exit;
	$db = & JFactory::getDBO();
	$mail =  JRequest::getVar('email');
	$query = "select id,user_type from #__users  where email = '".$mail."' ";
	$db->setQuery($query);
	$id = $db->loadObject();
	
	if($id->user_type==11){
	$db = & JFactory::getDBO();
	$query = "UPDATE #__vendor_inviteinfo SET `status` = '1', v_id=".$id->id." WHERE `fei` = ".$_REQUEST['invitecode']." ";
	$db->setQuery($query);
	$db->query(); 
	$res = $db->getAffectedRows();
	$msg = "You have accepted the invitation"; 	
			}
	else
			{ 
						//echo "can can";  exit;
			$msg = 'This email address is already registered as a Management Firm. You cannot accept this invitation. Please call 561-246-3830 for assistance.';
			}

		return $msg;
	}				
				
//echo "Im model";	 exit;
		/*$post =JRequest::get('request');
		//echo '<pre>'; print_r($post); //exit;
		$db = & JFactory::getDBO();
		$user =& JFactory::getUser();
	 	 $query = 'SELECT vc.tax_id,vi.fei,vi.vid FROM #__vendor_inviteinfo as vi ,#__cam_vendor_company as vc  WHERE  vc.user_id = vi.userid  AND vi.userid = '.$user->id; 
	
		$db->setQuery($query);
		$result = $db->loadObjectList();
	 	
		$post['feicode']= $post['taxid1'].'-'.$post['taxid2'].'-'.$post['taxid3']; 

	 	$query = "SELECT * FROM `#__vendor_inviteinfo` WHERE `fei` LIKE ".$post['invitecode'];   					 
		$db->setQuery($query);
		$condition  = $db->loadObjectList();*/
		
		//print_r($condition[0]->status); //exit; 
		
		 /*$query = "SELECT tax_id, camfirm_license_no,comp_name FROM #__cam_camfirminfo WHERE cust_id = ".$condition[0]->userid;
		$db->setQuery($query);
		$checkfun  = $db->loadObjectList();*/
		//print_r($checkfun[0]->tax_id); 
		
		/* $checkfun[0]->tax_id;
		 $checkfun[0]->camfirm_license_no;
		
		if(($post['invitecode'] == $condition[0]->fei) && ($post['feicode'] == $checkfun[0]->camfirm_license_no || $post['Cus_taxid'] ==  $checkfun[0]->tax_id))
		{
		
			/*	if($status[0]->status == 0) 	{*/
			 	/*$query = "UPDATE #__vendor_inviteinfo SET `status` = '1' WHERE `vid` = ".$condition[0]->vid." LIMIT 1";
				$db->setQuery($query);
				if(!$db->query()) 
				{ 
					$msg = "Failed to Update the status"; 	
				}
				
				
				
				else 
				{ 
					$msg =  "Invitation Is Accepted As Preferred Vendor  ";	
					
					$user = & JFactory::getUser();*/
					
					/*$query ="UPDATE #__cam_vendor_company SET `preferred_vendors` = 'YES' AND `in_house_parent_company` ='". $checkfun[0]->comp_name."' AND `in_house_parent_company_FEIN` = '".$checkfun[0]->camfirm_license_no."' WHERE `user_id` =".$user->id;
					
					$db->setQuery($query);
				*/
				//	$db->query();
			//	}
		/*	}
			else 
			{  
				$msg =  "Your Already A Preferred Vendor  "; 
			}*/
		//}
		
// function for selecting the records from db // coded by anandbabu	in vendorscenter		
	/*function getinhouse()
	{
		$db = & JFactory::getDBO();
		$query = 'SELECT  V.id,U.name,U.lastname,U.email,U.salutation,U.phone,U.extension,U.cellphone,U.user_type,U.id AS userid  FROM #__users as U LEFT JOIN #__cam_vendor_company as V ON U.id = V.user_id WHERE U.user_type = 11  AND in_house_vendor = "yes"';
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}*/
// function for selecting the records from db // coded by anandbabu	in vendorscenter		
	/*function getpreferred()
	{
		$db = & JFactory::getDBO();
		$query = 'SELECT  V.id,U.name,U.lastname,U.email,U.salutation,U.phone,U.extension,U.cellphone,U.user_type,U.id AS userid  FROM #__users as U LEFT JOIN #__cam_vendor_company as V ON U.id = V.user_id WHERE U.user_type = 11  AND preferred_vendors = "yes" ';
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}*/
// function for selecting the records from db // coded by anandbabu	in vendorscenter	
	/*function getexcluded()
	{
		$db = & JFactory::getDBO();
		$query = 'SELECT  V.id,U.name,U.lastname,U.email,U.salutation,U.phone,U.extension,U.cellphone,U.user_type,U.id AS userid  FROM #__users as U LEFT JOIN #__cam_vendor_company as V ON U.id = V.user_id WHERE U.user_type = 11  AND not_interest_RFP  = "yes" ';
		$db->setQuery($query);
		$result = $db->loadObjectList();

		return $result;
	}*/
	
	/*function vendordelete()
	 {
	 	echo '564<pre>'; print_r($_REQUEST);
		exit;
	 }*/
		
	function getvendor_edit()
	{
		$post = JRequest::get('get');
		$db = & JFactory::getDBO();
		//echo $query = "UPDATE #__users SET extension = '".$post[ext]."' WHERE id = ".$post[userid]; 
		$query = "SELECT U.* FROM #__users AS U, #__cam_vendor_company As V WHERE U.id = V.user_id AND V.id = ".$post['id'];
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}
	
	
}
?>