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


class vendorsignupModelvendorsignup extends Jmodel
{
	//assigning variables
	var $_data;
	var $_total = null;
	var $_pagination = null;

	function __construct(){
		parent::__construct();

		global $mainframe, $context;

		//initialize class property
	  $this->_table_prefix = '#__cam_';
		 global $mainframe;
		// echo "<pre>"; print_r($_REQUEST);
	    //DEVNOTE: Get the pagination request variables

	}

	function get_click_here_popup()
	{
	    /*****************code to send to fnd**************************/
	    JHTML::_('behavior.modal');
		$url	= 'index2.php?option=com_content&view=article&id=50&Itemid=145';
		$status = 'width=400,height=350,menubar=yes,resizable=yes';
		//$text = '<img src="templates/camassistant_left/images/upload_certificate.gif" alt="Upload Certificate"  width="113" height="22" />';
		$text = '<strong class="blue_small2">Click here</strong>';
        $attribs['rel']	= "{handler: 'iframe', size: {x: 680, y: 530}}";
		$attribs['class']	= 'modal';
		$attribs['title']	= JText::_( 'Click here' );
		$attribs['style'] = "text-decoration:none";
		//$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$output = JHTML::_('link', JRoute::_($url), $text, $attribs);
		return $output;
		/*****************end of code to send to fnd**************************/
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


	//function to display states in vendor registration
	function getstates()
	{
		global $mainframe;
		$db = JFactory::getDBO();
		$states[] = JHTML::_('select.option', '0', '-Select State-');
		$this->_filter_vendorslist	= $mainframe->getUserStateFromRequest( $context.'filter_vendorslist', 'filter_vendorslist', 0,	'string' );
		$sql = "SELECT * FROM #__cam_vendor_states order by state";
		$db->Setquery($sql);
		$objects = $db->loadObjectList();
		foreach( $objects as $obj )
		{
			$states[] = JHTML::_('select.option',  $obj->id, $obj->state);
		}
		//echo "<pre>"; print_r($vendorslist); exit;
		$result = JHTML::_('select.genericlist',$states, 'states', 'class="inputbox" size="1"  style="width:140px" ' . $javascript , 'value', 'text', $this->_filter_states);
	   return $result;
	}

	function get_states()
	{
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__cam_vendor_states order by state";
		$db->Setquery($sql);
		$states = $db->loadObjectList();
		return $states;
	}

	//function to get payment gateway details
	function getBilling_Payment()
	{
		$db = JFactory::getDBO();
		$pay_sql = "SELECT payment_type,pay_name,pay_currency,pay_busness_email,auth_tx_key,auth_login_id FROM #__cam_configuration WHERE id=1";
		$db->Setquery($pay_sql);
		$Billing_Payment = $db->loadObjectList();
		return $Billing_Payment;
	}

  //function to populate select industries link
	function getindustries_link()
	{
	    /*****************code to send to fnd**************************/
	    JHTML::_('behavior.modal');
        $uri	=& JURI::getInstance();
		$base	= $uri->toString( array('scheme', 'host', 'port'));
		$link	= $base;
		$url	= 'index.php?option=com_camassistant&controller=vendorsignup&task=industries_form';
		$status = 'width=400,height=350,menubar=yes,resizable=yes';
		$text = '<img src="templates/camassistant_left/images/select-my-industries.gif" alt="select industry" />';
        $attribs['rel']	= "{handler: 'iframe',size: {x: 700, y: 550}}";
		$attribs['class']	= 'modal';
		$attribs['title']	= JText::_( 'Industries' );
		//$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$output = JHTML::_('link', JRoute::_($url), $text, $attribs);

		return $output;
		/*****************end of code to send to fnd**************************/
	}

	//function to display industries list in popup
	function getindustires()
	{
		global $mainframe;
		if(isset($_SESSION['industries']))
		$chk_arry = $_SESSION['industries'];
		$db = JFactory::getDBO();
		$checked    = JHTML::_( 'grid.id', $i, $row->id );
		$sql = "SELECT * FROM #__cam_industries WHERE published=1 order by industry_name ";
		$db->Setquery($sql);
		$objects = $db->loadObjectList();
	foreach( $objects as $key => $obj )
	{
		//$checked    = JHTML::_( 'grid.id', $key, $obj->industry_name);
		if(isset($chk_arry) && in_array($obj->industry_name,$chk_arry))
		$checked = "<input type='checkbox' checked value='".$obj->industry_name."' name='cid[]' id='cb'".$key.">";
		else
		if($key == '41')
		$checked = "<input type='checkbox'  onclick='isChecked(this.checked);' value='".$obj->industry_name."' name='cid[]' id='cb'".$key.">";
		else {
		$checked = "<input type='checkbox'   value='".$obj->industry_name."' name='cid[]' id='cb'".$key.">";
		}

		$industries[] = $checked.'&nbsp;<label>'. $obj->industry_name . '</label>';
	}

		//echo "<pre>"; print_r($industries);
		if($industries == ''){ ?>
		<img src="templates/camassistant_left/images/final_loading_promo.gif" />
		<?php }
						else {
						return $industries;
		 }

	}

	// for getting the state list from db to dipaly in the vendor regsitration  //coded by anand babu

	function getstatelist()
	{
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM #__state";
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}

 // for getting the country list from db to dipaly in the vendor regsitration  //coded by anand babu

	function getcountylist()
	{
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM #__cam_counties ORDER BY County";
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}

	//function to save vendor registration details
	function store($data)
	{
		// give me JTable object
		$row = & $this->getTable('vendors');
		//echo '<pre>';  print_r($date);  exit;	// Bind the form fields to the  table
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
	//function to store in house vendors
	function store_Inhouse_vendors($data)
	{
	 	// give me JTable object

		$row = & $this->getTable('inhouse_vendors');
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

	//function to store vendor_billing_info
	function store_billing_info($data)
	{
	 	// give me JTable object
		//echo "<pre>"; print_r($data); exit;
		$row = & $this->getTable('vendor_billing');
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
	//Function to get the promocode type
	function getcoupontype($promo){
	$db =& JFactory::getDBO();
		$prmotype = "SELECT  ptype FROM #__cam_promocode where promocode='".$promo."'"; 
		$db->setQuery($prmotype);
		$promotype = $db->loadResult();
		return $promotype;
	}
	//Completed
	//function to store vendor_billing_info
	function getsavesubscription($data)
	{
		$row = & $this->getTable('subscriptions');
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
	//Function to get the error message when user uploads bad graphic file
	function getlogofailmsg(){
		$db =& JFactory::getDBO();
		$logo_fail_sql = "SELECT introtext  FROM #__content where id='291' ";
		$db->Setquery($logo_fail_sql);
		$failcontent = $db->loadResult(); 
		return $failcontent; 
	}
	//Completed
}
?>