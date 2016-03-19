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
class vendors_detailModelvendors_detail extends JModel
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
	function store($data)
	{
	 	// give me JTable object	
		$row =& $this->getTable('vendors'); 
		// Bind the form fields to the  table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		//echo "<pre>"; print_r($row); exit;
		// Create the timestamp for the date field

		// Store the  detail record into the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	function _buildQuery()
	{  
	 	//code added on 06-02-2010
		$filter_vendorslist		= JRequest::getWord('filter_vendorslist');
	    $db =& JFactory::getDBO();
		$orderby	= $this->_buildContentOrderBy();
		$search		= JRequest::getWord('search');
		$id		= JRequest::getVar('cid');
	   	// $where = ' WHERE LOWER(C.catname) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
	    //$where .=  ' OR LOWER(C.catdescription) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		$query = 'SELECT B.payment_preference, V.*,U.id as user_id,U.name,U.lastname,U.username,U.email,U.salutation,U.phone,U.extension,U.cellphone,U.user_type,U.question,U.answer,U.promo_code,U.invitecode,U.ccemail,U.hear,U.user_notes,U.flag,U.suspend,U.camrating,U.search,U.subscribe_type,U.subscribe_sort,U.subscribe_admin  FROM #__users as U LEFT JOIN #__cam_vendor_company as V ON U.id = V.user_id 
		LEFT JOIN #__cam_vendor_billing_centre as B ON U.id = B.user_id WHERE U.user_type = 11 and V.id='.$id[0];
		//code added on 06-02-2010
	    /*$orderby	= $this->_buildContentOrderBy();
		$query = ' SELECT * FROM '.$this->_table_prefix.'category'.$orderby;
		*/
		return $query;
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

	function delete($cid = array())
	{
		$result = false;

		if (count( $cid ))
		{
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM '.$this->_table_prefix.'category WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}
	
		//function to display industries list in the read only field modified by sateesh
	function fill_industires($userid) 
	{
		global $mainframe;
		$db = JFactory::getDBO();
		$id		= JRequest::getVar('cid');
		$sql_industries = "SELECT ci.industry_name FROM #__cam_vendor_industries as vi LEFT JOIN #__cam_industries as ci ON vi.industry_id = ci.id  WHERE vi.user_id =".$userid;
		$db->Setquery($sql_industries);
	
		$ind_list = $db->loadResultArray(); 
		$text = implode(',',$ind_list);
	   return $text;
	}
	
	
	//function to display states in vendor registration 
	function getstates() 
	{
		global $mainframe;
		$db = JFactory::getDBO(); 
		$cid = JRequest::getVar('cid','');
		$id = $cid[0];  
		$states[] = JHTML::_('select.option', '0', '-Select State-');
		//echo "<pre>"; print_r($_REQUEST); exit;
		$this->_filter_vendorslist	= $mainframe->getUserStateFromRequest( $context.'filter_vendorslist', 'filter_vendorslist', 0,	'string' );	
		$sql = "SELECT * FROM #__cam_vendor_states order by state";
		$db->Setquery($sql);
		$objects = $db->loadObjectList();
		$sql = "SELECT state FROM #__cam_vendor_company where id = ".$id; 
		$db->Setquery($sql);
		$state_code = $db->loadResult(); 
		foreach( $objects as $obj ) 
		{
			$states[] = JHTML::_('select.option',  $obj->id, $obj->state);
		}
		
		//echo "<pre>"; print_r($vendorslist); exit;
		$result = JHTML::_('select.genericlist',$states, 'states', 'class="inputbox" size="1" ' . $javascript , 'value', 'text', $state_code);	
	   return $result;
	}
	
	//function to populate select industries link 
	function getindustries_link()
	{
	    /*****************code to send to fnd**************************/
	    JHTML::_('behavior.modal');
        $uri	=& JURI::getInstance();
		$base	= $uri->toString( array('scheme', 'host', 'port'));
		$link	= $base;
		$cid = $_REQUEST['cid'][0];
		$url	= 'index.php?option=com_camassistant&controller=vendors_detail&task=industries_form&user_id='.$cid.'';
		$status = 'width=400,height=350,menubar=yes,resizable=yes';
		$text = 'SELECT INDUSTRIES ';
        $attribs['rel']	= "{handler: 'iframe', size: {x: 660, y: 350}}";  
		$attribs['class']	= 'modal';  
		$attribs['title']	= JText::_( 'Industries' );
		//$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$output = JHTML::_('link', JRoute::_($url), $text, $attribs); 
		return $output;
		/*****************end of code to send to fnd**************************/	
	}
	
	//function to display industries list in popup
	function getindustires($cid) 
	{

		global $mainframe;
		if(isset($_SESSION['industries']))
		$chk_arry = $_SESSION['industries'];
		$db = JFactory::getDBO();
		$checked    = JHTML::_( 'grid.id', $i, $row->id );
		//Edited by sateesh
		$sql_industries = "SELECT U.industry_id FROM #__cam_vendor_industries as U, #__cam_vendor_company as V  WHERE V.id=".$_REQUEST['user_id']." AND V.user_id=U.user_id ";
		$db->Setquery($sql_industries);
		$industry_ids = $db->loadResultArray();

		//Completed
		$sql = "SELECT * FROM #__cam_industries WHERE published=1 order by industry_name ";
		$db->Setquery($sql);
		$objects = $db->loadObjectList();

		foreach( $objects as $key => $obj ) 
		{
			//$checked    = JHTML::_( 'grid.id', $key, $obj->industry_name);
			if(isset($industry_ids) && in_array($obj->id,$industry_ids))
			$checked = "<input checked='checked' type='checkbox' onclick='isChecked(this.checked);' value='".$obj->industry_name."' name='cid[]' id='cb'".$key.">";
			else
			$checked = "<input type='checkbox' onclick='isChecked(this.checked);' value='".$obj->industry_name."' name='cid[]' id='cb'".$key.">";
			$industries[] = $checked.'&nbsp;'. $obj->industry_name;
		}
	   return $industries;
	}
	//Funtion to get the vendor states by sateesh on 21-07-11
	function getstatelist()
	{
		$db =& JFactory::getDBO();
		$query_states = "SELECT * FROM #__state";
		$db->setQuery($query_states);
		$result_states = $db->loadObjectList();
		return $result_states;
	}
	//Funtion to get the states by sateesh on 21-07-11
	
	//Funtion to get the vendor company states by sateesh on 21-07-11
	function getbusinessstatelist($user_id)
	{
		$db =& JFactory::getDBO();
		$query_bstates = "SELECT V.state_name,V.state_id FROM #__vendor_state_counties as U, #__state as V where U.user_id=".$user_id." and U.state_id=V.state_id GROUP BY V.state_name HAVING COUNT(*)>0";
		$db->setQuery($query_bstates);
		$result_bstates = $db->loadObjectList();
		return $result_bstates;
	}
	//Funtion to get the states by sateesh on 21-07-11
	
	//function to store vendor_industries
	function store_industries($data)
	{
	 	// give me JTable object	
		
		$row = & $this->getTable('vendor_industries');
		// Bind the form fields to the  table
		if (!$row->bind($data)) {
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
	//Function to get the counties by sateesh
	//for getting state id in edit vendor page	
	
	function getvendorcounties($userid)
	{
		$cid = $_REQUEST['cid'][0];
		$db = JFactory::getDBO();
		$sql_counties = "SELECT U.county_id, W.County, U.state_id FROM #__vendor_state_counties  as U, #__cam_vendor_company as V, #__cam_counties as W   WHERE V.id=".$cid." AND V.user_id=U.user_id AND W.id=U.county_id GROUP BY U.county_id HAVING COUNT(*)>0 ORDER BY W.County";	
		$db->setQuery($sql_counties);
		$counties_results = $db->loadObjectList();
		return $counties_results;
	}
	 function get_thumbnail_dimensions()
	{
		$db = JFactory::getDBO();
		$sql = "SELECT vendor_logo_height,vendor_logo_width FROM #__cam_configuration";
		$db->Setquery($sql);
		$dimensions = $db->loadObjectList();
		return $dimensions;
	}
	//Completed
	//Function to cropping the company logo by sateesh
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
         $bg = imagecolorallocate ( $tmp, 255, 255, 255 );
           imagefill ( $tmp, 0, 0, $bg );
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

	function update_companyinfo($data)
	{
//	echo "can"."<pre>"; print_r($data); exit;	
		$row =& $this->getTable('vendors_update'); 
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
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
	function invitations(){
	$db =& JFactory::getDBO();
	$query_invitations = "SELECT V.userid, V.invitedate, V.vendortype, V.status, U.comp_state, U.comp_name, U.comp_city, W.name, X.state_name	from #__vendor_inviteinfo as V, #__cam_customer_companyinfo  as U, #__users as W, #__state as X where W.id=V.userid and V.userid =U.cust_id and U.comp_state=X.id and V.vendortype !='exclude' and V.inhousevendors ='".$user_id."' group by U.comp_name having count(*)>=1";
		$db->setQuery($query_invitations);
        $invitation=$db->loadObjectList();
		
		return $invitation;
	}
	function getawardedrfps($vendorid){
	$db =& JFactory::getDBO();
	$award_rfps = "SELECT V.apple, V.id, V.projectName, V.cust_id, V.apple_publish, W.name, W.lastname FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V, #__users as W where U.proposedvendorid=".$vendorid." and V.apple!=0 and U.proposaltype='Awarded' and U.rfpno = V.id and W.id=V.cust_id ";
	$db->setQuery($award_rfps);
	$rfps_award=$db->loadObjectList();
	return $rfps_award;
	}
	
	function getavaragerating($vendorid){
	$db =& JFactory::getDBO();
	$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$vendorid." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	for($c=0; $c<count($count_vs); $c++){
	$total = $total + $count_vs[$c]->apple ;
	}
	$camrating = "SELECT camrating FROM `#__users` where id=".$vendorid."  ";
	$db->setQuery($camrating);
	$cam_rating = $db->loadResult();
	
	$total = $total + $cam_rating ;
	$count = count($count_vs) + 1;
	$avgrating = $total  / $count;
	$avgrating =  round($avgrating, 1); 
	return $avgrating;
	}
}
?>
