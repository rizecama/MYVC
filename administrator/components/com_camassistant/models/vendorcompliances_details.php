<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// import MODEL object class
jimport('joomla.application.component.model');


class vendorcompliances_detailsModelvendorcompliances_details extends JModel
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
 /*********************************************************add/edit compliance documents code by lalitha**********************************************************/

 	function get_reject_mailcontent()
	{
		$db = JFactory::getDBO();
		$userid = JRequest::getVar('cid','','get','array' );
		$userid = $userid[0];
		$user	= JFactory::getUser($userid);
		$vendorname = $user->name.'&nbsp;'.$user->lastname;
		$sql = "SELECT introtext FROM #__content   where id=175";
		$db->Setquery($sql);
		$introtext=$db->loadResult();
		$introtext = str_replace('{Vendor Name}',$vendorname,$introtext);
		$tags = array("<p>","</p>","<br>","<br />","<b>","</b>");
		$rtags = array("","\n","\n","\n");
		$introtext = str_replace($tags, $rtags, $introtext);
		return $introtext;
	}


 	//function to delete upld cert file
	function get_delete_upld_cert()
	{
		$filename = JRequest::getVar('filename','');
		$tbl = JRequest::getVar('tbl','');
		$suffix = JRequest::getVar('suffix','');
		$id = JRequest::getVar('id','');
		$user->id = JRequest::getVar('userid','');
		//code to unlink image in folder
                $base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS;
	//	$base_Dir = JPATH_COMPONENT.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS;
		$filename =$files['name'];
		$post['image'] = $filename;
		if(file_exists($base_Dir . $filename))
					@unlink($base_Dir . $filename);
		//code to update vendor compliances table
		$db = JFactory::getDBO();
		//$user = JFactory::getUser();
		$sql = "UPDATE #__cam_vendor_".$tbl." SET ".$suffix."_upld_cert = '' where id=".$id." AND vendor_id='".$user->id."'";
		$db->Setquery($sql);
		$db->query();
		$err_msg="Document Deleted Successfully";
		//$prev_image = $db->loadResult();
	}

	//function to get liscense categories in vendor compliance doc page
	function get_GLI_policy_configurations()
	{
		$db = JFactory::getDBO();
		$sql = "SELECT vendor_policy_limits,vendor_aggregate FROM #__cam_configuration";
		$db->Setquery($sql);
		$GLI = $db->loadObjectList();
		return $GLI;
	}

	//function to get liscense categories in vendor compliance doc page
	function get_liscense_categories()
	{
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__compliance_license_categories order by category_name";
		$db->Setquery($sql);
		$categories = $db->loadObjectList();
		return $categories;
	}

	//function to get vendor compliance WCI data
	function get_compliance_W9_data($userid)
	{
		$db = JFactory::getDBO();
		$user->id = $userid;
		$sql = "SELECT * FROM #__cam_vendor_compliance_w9docs WHERE vendor_id=".$user->id;
		$db->Setquery($sql);
		$W9_data = $db->loadObjectList();
		return $W9_data;
	}

	//function to get vendor compliance WCI data
	function get_compliance_WCI_data($userid)
	{
		$db = JFactory::getDBO();
		$user->id = $userid;
		$sql = "SELECT * FROM #__cam_vendor_workers_companies_insurance WHERE vendor_id=".$user->id;
		$db->Setquery($sql);
		$WCI_data = $db->loadObjectList();
		return $WCI_data;
	}
	function get_compliance_AIP_data($userid)
	{
		$db = JFactory::getDBO();
		$user->id = $userid;
		$sql = "SELECT * FROM #__cam_vendor_auto_insurance WHERE vendor_id=".$user->id;
		$db->Setquery($sql);
		$AIP_data = $db->loadObjectList();
		return $AIP_data;
	}
	function get_compliance_UMB_data($userid)
	{
		$db = JFactory::getDBO();
		$user->id = $userid;
		$sql = "SELECT * FROM #__cam_vendor_umbrella_license WHERE vendor_id=".$user->id;
		$db->Setquery($sql);
		$UMB_data = $db->loadObjectList();
		return $UMB_data;
	}
	function get_compliance_OMI_data($userid)
	{
		$db = JFactory::getDBO();
		$user->id = $userid;
		$sql = "SELECT * FROM #__cam_vendor_errors_omissions_insurance WHERE vendor_id=".$user->id;
		$db->Setquery($sql);
		$OMI_data = $db->loadObjectList();
		return $OMI_data;
	}
	 function get_compliance_WC_data($userid)
	{
		$db = JFactory::getDBO();
		$user->id = $userid;
		$sql = "SELECT * FROM #__cam_vendor_workers_compansation WHERE vendor_id=".$user->id;
		$db->Setquery($sql);
		$WC_data = $db->loadObjectList();
		return $WC_data;
	}
	//function to get vendor compliance GLI data
	function get_compliance_GLI_data($userid)
	{
		$db = JFactory::getDBO();
		$user->id = $userid;
		$sql = "SELECT * FROM #__cam_vendor_liability_insurence  WHERE vendor_id=".$user->id;
		$db->Setquery($sql);
		$GLI_data = $db->loadObjectList();
		return $GLI_data;
	}

	//function to get vendor compliance OLN data
	function get_compliance_OLN_data($userid)
	{
		$db = JFactory::getDBO();
		$user->id = $userid;
		$sql = "SELECT * FROM #__cam_vendor_occupational_license WHERE vendor_id=".$user->id;
		$db->Setquery($sql);
		$OLN_data = $db->loadObjectList();
		//echo "<pre>"; print_r($OLN_data); exit;
		return $OLN_data;
	}

	//function to get vendor compliance PLN data
	function get_compliance_PLN_data($userid)
	{
		$db = JFactory::getDBO();
		$user->id = $userid;
		$sql = "SELECT * FROM #__cam_vendor_professional_license WHERE vendor_id=".$user->id;
		$db->Setquery($sql);
		$PLN_data = $db->loadObjectList();
		return $PLN_data;
	}

	//function to get list of states
	function get_edit_compliance_states()
	{
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__cam_vendor_states WHERE id != '38' order by state";
		$db->Setquery($sql);
		$states = $db->loadObjectList();
		return $states;
	}

	//function to display states in vendor registration
	function get_compliances_OLN_states()
	{
		global $mainframe;
		$db = JFactory::getDBO();
		$states[] = JHTML::_('select.option', '0', '-Select State-');
		$compliance = JRequest::getVar('compliance','');
		$compliance = $compliance+1;
		$this->_filter_vendorslist	= $mainframe->getUserStateFromRequest( $context.'filter_vendorslist', 'filter_vendorslist', 0,	'string' );
		$sql = "SELECT * FROM #__cam_vendor_states WHERE id != '38' order by state";
		$db->Setquery($sql);
		$objects = $db->loadObjectList();
		foreach( $objects as $obj )
		{
			$states[] = JHTML::_('select.option',  $obj->id, $obj->state);
		}
		//echo "<pre>"; print_r($vendorslist); exit;
		$result = JHTML::_('select.genericlist',$states, 'OLN_state[]', 'class="inputbox" size="1" ' . $javascript , 'value', 'text','', 'OLN_state'.$compliance,  $this->_filter_states);
	   return $result;
	}

	//function to display states in vendor registration
	function get_compliances_PLN_states()
	{
		global $mainframe;
		$db = JFactory::getDBO();
		$states[] = JHTML::_('select.option', '0', '-Select State-');
		$compliance = JRequest::getVar('compliance','');
		$compliance = JRequest::getVar('PLN_title','');
		//$compliance = $compliance+1;
		$this->_filter_vendorslist	= $mainframe->getUserStateFromRequest( $context.'filter_vendorslist', 'filter_vendorslist', 0,	'string' );
		$sql = "SELECT * FROM #__cam_vendor_states WHERE id != '38' order by state";
		$db->Setquery($sql);
		$objects = $db->loadObjectList();
		foreach( $objects as $obj )
		{
			$states[] = JHTML::_('select.option',  $obj->id, $obj->state);
		}
		//echo "<pre>"; print_r($vendorslist); exit;
		$result = JHTML::_('select.genericlist',$states, 'PLN_state[]', 'class="inputbox" size="1" ' . $javascript , 'value', 'text','', 'PLN_state'.$compliance,  $this->_filter_states);
	   return $result;
	}

	//function to get w9 upload certificate link
	function get_W9_upld_cert_link()
	{
	    /*****************code to send to fnd**************************/
	    JHTML::_('behavior.modal');
        $uri	=& JURI::getInstance();
		$base	= $uri->toString( array('scheme', 'host', 'port'));
		$link	= $base;
		$url	= 'index.php?option=com_camassistant&controller=vendors&task=compliance_upload_form&text_name=W9&compliance=0';
		$status = 'width=400,height=350,menubar=yes,resizable=yes';
		$text = '<img src="templates/camassistant_left/images/uploadw9.gif" alt="Upload Certificate"  width="87" height="22" />';
        $attribs['rel']	= "{handler: 'iframe', size: {x: 660, y: 350}}";
		$attribs['class']	= 'modal';
		$attribs['title']	= JText::_( 'Upload A File' );
		//$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$output = JHTML::_('link', JRoute::_($url), $text, $attribs);
		return $output;
		/*****************end of code to send to fnd**************************/
	}

	//function to get GLI upload certificate link
	function get_GLI_upld_cert_link()
	{
	    /*****************code to send to fnd**************************/
	    JHTML::_('behavior.modal');
        $uri	=& JURI::getInstance();
		$base	= $uri->toString( array('scheme', 'host', 'port'));
		$link	= $base;
		$url	= 'index.php?option=com_camassistant&controller=vendors&task=compliance_upload_form&text_name=GLI&compliance=0';
		$status = 'width=400,height=350,menubar=yes,resizable=yes';
		$text = '<img src="templates/camassistant_left/images/upload_certificate.gif" alt="Upload Certificate"  width="113" height="22" />';
        $attribs['rel']	= "{handler: 'iframe', size: {x: 660, y: 350}}";
		$attribs['class']	= 'modal';
		$attribs['title']	= JText::_( 'Upload A File' );
		//$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$output = JHTML::_('link', JRoute::_($url), $text, $attribs);
		return $output;
		/*****************end of code to send to fnd**************************/
	}

	//function to get OLN upload certificate link
	function get_WCI_upld_cert_link()
	{
	    /*****************code to send to fnd**************************/
	    JHTML::_('behavior.modal');
        $uri	=& JURI::getInstance();
		$base	= $uri->toString( array('scheme', 'host', 'port'));
		$link	= $base;
		$url	= 'index.php?option=com_camassistant&controller=vendors&task=compliance_upload_form&text_name=WCI&compliance=0';
		$status = 'width=400,height=350,menubar=yes,resizable=yes';
		$text = '<img src="templates/camassistant_left/images/upload_certificate.gif" alt="Upload Certificate"  width="113" height="22" />';
        $attribs['rel']	= "{handler: 'iframe', size: {x: 660, y: 350}}";
		$attribs['class']	= 'modal';
		$attribs['title']	= JText::_( 'Upload A File' );
		//$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$output = JHTML::_('link', JRoute::_($url), $text, $attribs);
		return $output;
		/*****************end of code to send to fnd**************************/
	}

	//function to get OLN upload certificate link
	function get_OLN_upld_cert_link()
	{
	    /*****************code to send to fnd**************************/
	    JHTML::_('behavior.modal');
        $uri	=& JURI::getInstance();
		$compliance = JRequest::getVar('compliance','0');
		//$compliance = $compliance+1;
		$base	= $uri->toString( array('scheme', 'host', 'port'));
		$link	= $base;
		$url	= 'index.php?option=com_camassistant&controller=vendors&task=compliance_upload_form&text_name=OLN&compliance='.$compliance;
		$status = 'width=400,height=350,menubar=yes,resizable=yes';
		$text = '<img src="templates/camassistant_left/images/upload_certificate.gif" alt="Upload Certificate"  width="113" height="22" />';
        $attribs['rel']	= "{handler: 'iframe', size: {x: 660, y: 350}}";
		$attribs['class']	= 'modal';
		$attribs['title']	= JText::_( 'Upload A File' );
		//$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$output = JHTML::_('link', JRoute::_($url), $text, $attribs);
		return $output;
		/*****************end of code to send to fnd**************************/
	}

	//function to get OLN upload certificate link
	function get_PLN_upld_cert_link()
	{
	    /*****************code to send to fnd**************************/
	    JHTML::_('behavior.modal');
        $uri	=& JURI::getInstance();
		$compliance = JRequest::getVar('compliance','0');
		//$compliance = $compliance+1;
		$base	= $uri->toString( array('scheme', 'host', 'port'));
		$link	= $base;
		$url	= 'index.php?option=com_camassistant&controller=vendors&task=compliance_upload_form&text_name=PLN&compliance='.$compliance;
		$status = 'width=400,height=350,menubar=yes,resizable=yes';
		$text = '<img src="templates/camassistant_left/images/upload_certificate.gif" alt="Upload Certificate"  width="113" height="22" />';
        $attribs['rel']	= "{handler: 'iframe', size: {x: 660, y: 350}}";
		$attribs['class']	= 'modal';
		$attribs['title']	= JText::_( 'Upload A File' );
		//$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$output = JHTML::_('link', JRoute::_($url), $text, $attribs);
		return $output;
		/*****************end of code to send to fnd**************************/
	}

	//for getting industryname in edit vendor compilance page
	function getindustry_ids($userid)
	{
		$db = JFactory::getDBO();
		$query ="select industry_id from #__cam_vendor_industries Where user_id =".$userid;
		$db->setQuery($query);
		$results = $db->loadResultArray();
		return $results;
	}


	//function to store vendor_OLN_comploances_info
	function store_vendor_OLN_compliances_info($data)
	{
	 	// give me JTable object
		$row = & $this->getTable('vendor_occupational_license');
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
		  $lastRowId = $row->id;
		return $lastRowId;
	}

	//function to store vendor_OLN_comploances_info
	function store_vendor_PLN_compliances_info($data)
	{
	 	// give me JTable object
		$row = & $this->getTable('vendor_professional_license');
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
		  $lastRowId = $row->id;
		return $lastRowId;
	}

	function store_vendor_aip_compliances_info($data)
	{
	 	// give me JTable object
		//echo "<pre>"; print_r($data); exit;
		$row = & $this->getTable('vendor_auto_insurance');
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
                $lastRowId = $row->id;
               // echo $lastRowId; exit;
		return $lastRowId;
	}
	function store_vendor_UMB_compliances_info($data)
	{
	 	// give me JTable object
		//echo "<pre>"; print_r($data); exit;
		$row = & $this->getTable('vendor_umbrella_license');
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
                $lastRowId = $row->id;
               // echo $lastRowId; exit;
		return $lastRowId;
	}
	function store_vendor_OMI_compliances_info($data)
	{
	 	// give me JTable object
		//echo "<pre>"; print_r($data); exit;
		$row = & $this->getTable('vendor_omi_insurance');
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
                $lastRowId = $row->id;
               // echo $lastRowId; exit;
		return $lastRowId;
	}
	//function to store vendor_OLN_comploances_info
	function store_vendor_GLI_compliances_info($data)
	{
	 	// give me JTable object
		$row = & $this->getTable('vendor_liability_insurence');
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
		  $lastRowId = $row->id;
		return $lastRowId;
	}

	//function to store vendor_OLN_comploances_info
	function store_vendor_WCI_compliances_info($data)
	{
	 	// give me JTable object
		//echo "<pre>"; print_r($data); exit;
		$row = & $this->getTable('vendor_workers_companies_insurance');
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
		  $lastRowId = $row->id;
		return $lastRowId;
	}
	 function store_vendor_WC_compliances_info($data)
	{
	 	// give me JTable object
		//echo "<pre>"; print_r($data);
		$row = & $this->getTable('vendor_workers_compansation');
		// Bind the form fields to the  table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		//echo "<pre>"; print_r($row);
		// Create the timestamp for the date field
		// Store the  detail record into the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		$lastRowId = $row->id;
//exit;
		return $lastRowId;
	}
	//function to store vendor_OLN_comploances_info
	function store_vendor_compliance_w9docs_info($data)
	{
	 	// give me JTable object
		$row = & $this->getTable('vendor_compliance_w9docs');
		//echo '<pre>'; print_r($row); echo '<pre>'; print_r($data);  exit;// Bind the form fields to the  table
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
		   $lastRowId = $row->id; 
		return $lastRowId;
	}

  /*******************************************************end -- add/edit compliance documents code by lalitha******************************************************/
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
			 $query = $this->_OLN_buildQuery();
			$this->_data[0] = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));

			 $query = $this->_PLN_buildQuery();
			$this->_data[1] = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));

			 $query = $this->_GLI_buildQuery();
			$this->_data [2]= $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));

			 $query = $this->_WCI_buildQuery();
			$this->_data[3] = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));

			 $query = $this->_W9_buildQuery();
			$this->_data[4] = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		//echo "<pre>"; print_r($this->_data);
		return $this->_data;

}

	function _OLN_buildQuery()
	{
	 //code added on 06-02-2010
	    $db =& JFactory::getDBO();
		$orderby	= $this->_buildContentOrderBy();
		$id = JRequest::getVar('cid');
		$OLN_query = "SELECT * FROM #__cam_vendor_occupational_license WHERE vendor_id = ".$id[0];

		return $OLN_query;
	}

	function _PLN_buildQuery()
	{
	 //code added on 06-02-2010
	    $db =& JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$PLN_query = "SELECT * FROM #__cam_vendor_professional_license WHERE vendor_id = ".$id[0];
		return $PLN_query;
	}

	function _GLI_buildQuery()
	{
	 //code added on 06-02-2010
	    $db =& JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$GLI_query = "SELECT * FROM #__cam_vendor_liability_insurence WHERE vendor_id = ".$id[0];
		return $GLI_query;
	}

	function _WCI_buildQuery()
	{
	 //code added on 06-02-2010
	    $db =& JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$WCI_query = "SELECT * FROM #__cam_vendor_workers_companies_insurance WHERE vendor_id = ".$id[0];
		return $WCI_query;
	}

	function _W9_buildQuery()
	{
	 //code added on 06-02-2010
	    $db =& JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$W9query = "SELECT * FROM #__cam_vendor_compliance_w9docs WHERE vendor_id = ".$id[0];
		return $W9query;
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
		$row =& $this->getTable('configuration');

		// Bind the form fields to the  table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

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
	
	//Funcmtion to get all the preferred companies
	function getpreferredclist($userid){
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$query_id = "SELECT email from #__users where id=".$userid."" ;
		$db->setQuery($query_id);
        $useremail = $db->loadResult();
		
		/*$query = "SELECT V.userid, U.comp_name from #__vendor_inviteinfo as V, #__cam_customer_companyinfo  as U, #__users as W, #__state as X where W.id=V.userid and V.userid =U.cust_id and U.comp_state=X.id and V.vendortype !='exclude' 
		and V.inhousevendors ='".$useremail."' group by U.comp_name having count(*)>=1";*/
		
		$query = "SELECT U.id as userid, V.comp_name from #__users as U 
		LEFT JOIN #__cam_customer_companyinfo as V on U.id=V.cust_id
		where U.user_type='13' and U.accounttype='master' and U.search='' ";
		
		$db->setQuery($query);
        $camfirmslist = $db->loadObjectList();
		return $camfirmslist;
}
	//Completed

}

?>
