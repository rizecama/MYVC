<?php
/**
 * @version		1.0.0 camassistant $
 * @package		camassistant
 * @copyright	Copyright © 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
error_reporting(0);
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class camassistantController extends JController
{



function display(){
//echo "control<pre>"; print_r($_REQUEST); exit;
if($_REQUEST['view']=='inviteasinhouse')
{
	JRequest::getVar('view','inviteasinhouse');
	parent::display();
} else {
parent::display();
}

}
function remove(){
		global $mainframe;
		
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cids = implode( ',', $cid );
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('invitevendors');
		if($res <= 0)
		{
			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}
			$msg='';
			$msg='Vendors Deleted Successfully';
		}
		$this->setRedirect( 'index.php?option=com_camassistant&view=invitevendors',$msg);
	 

}

	// 03-02-2011 Invite as inhouse vendors //
function inhousevendors()
	{	
	//echo "<pre>"; print_r($_REQUEST); exit;
	$post = JRequest::get('get');
	$vendortype = JRequest::getVar( 'vendortype','' );
	$userid = JRequest::getVar( 'userid','');
	$mailfrom = JRequest::getVar( 'email','');
	/*$user = JFactory::getUser();
	echo "<pre>"; print_r($user); exit;*/
			$shareproperty = array(); 
			$db =& JFactory::getDBO();
			$query = "SELECT tax_id,camfirm_license_no FROM #__cam_camfirminfo where cust_id =".$userid;
			$db->setQuery($query);
			$tax=$db->loadObject();
	
	if($tax->tax_id == '')
	{
		$licenseno 	= $tax->camfirm_license_no; 
	}
	else 
	{
		$licenseno = $tax->tax_id; 
	}
	
	$vendor = JRequest::getVar( 'inhousevendors','');
	$vendors = JRequest::getVar( 'inhouse','' );
	$subject = JRequest::getVar( 'subject','' );
	$post['inhousetext'] = JRequest::getVar( 'inhousetext', '', 'get', 'string', JREQUEST_ALLOWRAW );
	$body = $post['inhousetext'];
	$admin = 'support@myvendorcenter.com';
	
	
	$res = JUtility::sendMail($mailfrom, '', $admin, $subject, $body, $mode=1);
	
	/*$message =  explode("\n", $body);
	echo "<pre>"; print_r($message);  exit;*/
	
	$vendors1 = array();
	$vendors1 = explode(",",$vendors);
	$j=0;
	$model = $this->getModel('inviteasinhouse');
	if(count($vendors1)>0){
	for($i=0; $i<count($vendors1); $i++){
	$vendor = $vendors1[$i];
	/*$mailfrom = 'support@camassistant.com';*/
	//Generate random number //
	
	srand ((double) microtime( )*1000000);
	$fei = rand();
	srand ((double) microtime( )*1000000);
	$invc = rand();
	if($tax->tax_id == '')
	{
		$msg = str_replace("FEI Number {XXXXXXXXX}", "FEI Number ".$licenseno, $body);
	}
	else 
	{
		$msg = str_replace("FEI Number {XXXXXXXXX}", "Tax Id Number  ".$licenseno, $body);
	}
	$msg = str_replace("Invite Code: XXXXX", "Invite Code ".$invc, $msg);
	$post['inhousetext'] = $msg;
	
	//echo $msg; exit;
	/*if($taxid != '') {
	$body1 = $body."<br>This is the FEI Number:".$fei."<br />Invitation from :".$taxid;
	}
	if($licenseno != '') {
	$body1 = $body."<br>This is the FEI Number:".$fei;
	$body1 = $body1."Invitation from :".$licenseno;
	}
	
	$body1 = $body1.$body;*/
	//Random number Complete//
	 $res = JUtility::sendMail($mailfrom, '', $vendor, $subject, $msg, $mode=1);
	//print_r($body); exit;
	$post['fei'] = $invc;
	$post['inhousevendors'] = $vendor;
	if($tax->tax_id == '')
	{
		$post['licenseno'] = $licenseno;
		$post['taxid'] = '';
	}
	else 
	{
		$post['licenseno'] = '';
		$post['taxid'] = $tax->tax_id;
	}
	$success = $model->store($post);
	}
	if($success)
	{
		$msg = 'Your invitation has been sent successfully';
	
	}  
	else 
	{
		$msg = 'Your invitation sending was failed';
	}
	
	} else {
	$return = JURI::base();
	$msg = 'Your invitation sending was failed';
	}
	$url = "index.php?option=com_camassistant&controller=vendors&task=displayext";
$this->setRedirect( $url, $msg );
}

//invite inhouse vendors completed//

//old code before 03-02-2011

/*function inhousevendors(){	

$post = JRequest::get('get');
$vendortype = JRequest::getVar( 'vendortype','' );

$admin = JRequest::getVar( 'inhouse','');
$vendors = JRequest::getVar( 'inhousevendors','' );
$subject = JRequest::getVar( 'subject','' );
$post['inhousetext'] = JRequest::getVar( 'inhousetext', '', 'get', 'string', JREQUEST_ALLOWRAW );
$body = $post['inhousetext'];
$body = $body."<br>"."<a href='http://camassistant.com'>Click here</a>";

$res = JUtility::sendMail($mailfrom, $to, $admin, $subject, $body, $mode=1);
$vendors1 = array();
$vendors1 = explode(",",$vendors);
$j=0;
$model = $this->getModel('inviteasinhouse');
if(count($vendors1)>0){
for($i=0; $i<count($vendors1); $i++){
$vendor = $vendors1[$i];
$mailfrom = 'support@camassistant.com';

srand ((double) microtime( )*1000000);
$fei = rand();

$body = $body."<br>This is the FEI Number:".$fei;

$res = JUtility::sendMail($mailfrom, $to, $vendor, $subject, $body, $mode=1);

$post['fei'] = $fei;
$post['inhousevendors'] = $vendor;
$success = $model->store($post);
}
if($success){
$msg = 'Your invitation have been sent successfully';

}  else {
$msg = 'Your invitation sending was failed';
}

} else {
$return = JURI::base();
$msg = 'Your invitation sending was failed';
}
$url = 'index.php?option=com_camassistant&view=popup&Itemid=2';
$this->setRedirect( $url, $msg );
}*/

function files(){

//	$filetype = JRequest::getVar( 'filetype','');
	$post = JRequest::get('get');

	$model = $this->getModel('filetype');
	$post['filetype'] = $_POST['filetype'];

	$success = $model->store($post);
	if($success){
	echo "Success";
	}
	else{
	echo "Fail";
	}

}
//function to go for Camassistant Control Panel(Prasad 13 Jan 11)
function lists()
{
	// Panel 
	$this->setRedirect( 'index.php?option=com_camassistant&controller=camassistant' );
}
//
function updatefile() {

//print_r($_POST['filetype']); 

$db=JFactory::getDBO();
$sql="UPDATE #__cam_filetype SET files='".$_POST['files']."',pagecount='".$_POST['pagecount']."'";
$db->setQuery($sql);
$res=$db->query(); 
if($res)
{
$msg = 'Updated Successfully';
$url = 'index.php?option=com_camassistant&view=filetype';
$this->setRedirect( $url, $msg );
}
else {
$msg = 'Not updated';
$url = 'index.php?option=com_camassistant&view=filetype';
$this->setRedirect( $url, $msg );
}
}

}
?>