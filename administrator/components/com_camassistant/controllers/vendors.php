<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//echo '<pre>'; print_r($_REQUEST); exit;
// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );
 
class vendorsController extends JController
{
	function __construct( $default = array())
	{
		parent::__construct( $default );
		
	}
	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}
	//function to go for Camassistant Control Panel(Prasad 12 Jan 11)
	function lists()
	{
		// Panel 
		$this->setRedirect( 'index.php?option=com_camassistant&controller=camassistant' );
	}
	function displayext() {
		parent::display();
	}
	function display() {
		parent::display();
	}
	
	//
	function remove()
	{
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$userid = JRequest::getVar( 'userid','');
                //echo '<pre>'; print_r($_REQUEST); exit;
		if($userid)
		$userid = $userid;
		$cids = implode( ',', $cid );
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('vendors');
		if($res <= 0)
		{
			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}
			$msg='';
			$msg='Vendors Deleted Successfully';
		}
		$this->setRedirect( 'index.php?option=com_camassistant&controller=vendors',$msg);
	 }
	 function block()
	{
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$user_ids		= JRequest::getVar( 'user_ids', array(), 'post', 'array' );
		$vendor_id = $cid[0];
		$user_id = $user_ids[$vendor_id];
		$task		= JRequest::getCmd( 'task' );
		$publish	= 1;
		/*$n			= count( $cid );
		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );*/
		$query = 'UPDATE #__users'
		. ' SET block = ' . (int) $publish
		. ' WHERE id IN ( '. $user_id.'  )'
		; 
		$db->setQuery( $query );
		$db->query();
		//to update vendor taoble
		$query = 'UPDATE #__cam_vendor_company'
		. ' SET published = ' . (int) $publish
		. ' WHERE user_id IN ( '. $user_id.'  )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning(500, $db->getError());
		}
				$this->setRedirect( 'index.php?option=com_camassistant&controller=vendors','Vendor Unpublished Successfully');

	}
	
	function unblock()
	{
		// Check for request forgeries
		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$user_ids		= JRequest::getVar( 'user_ids', array(), 'post', 'array' );
		$vendor_id = $cid[0];
		$user_id = $user_ids[$vendor_id];
		$task		= JRequest::getCmd( 'task' );
		$publish	= 0;
		/*$n			= count( $cid );
		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );*/
		//to update status in users table
		 $query = 'UPDATE #__users'
		. ' SET block = ' . (int) $publish
		. ' WHERE id IN ( '. $user_id.'  )'
	
		; 
		$db->setQuery( $query );
		$db->query();
		//to update status vendor table
		$query = 'UPDATE #__cam_vendor_company'
		. ' SET published = ' . (int) $publish
		. ' WHERE user_id IN ( '. $user_id.'  )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
		$this->setRedirect( 'index.php?option=com_camassistant&controller=vendors','Vendor Published Successfully');

	}
	
	function mail_redirect_form()
	{
		$useractivation = JRequest::getVar("useractivation",'');
		$db =& JFactory::getDBO();
		$activate = "UPDATE #__cam_vendor_company SET status='active' where activation ='".$useractivation."'";
		$db->setQuery($activate);
		$db->query();
		$userdetails1 = "SELECT user_id FROM #__cam_vendor_company where activation ='".$useractivation."'";
		$db->setQuery( $userdetails1 );
		$user_id = $db->loadResult();
		$user_details = "SELECT name,email,lastname FROM #__users where id ='".$user_id."'";
		$db->setQuery( $user_details );
		$user_details1 = $db->loadObjectlist();
		$username=$user_details1[0]->name.' '.$user_details1[0]->lastname;
		$email=$user_details1[0]->email;
		$mailfrom='support@myvendorcenter.com';
		$fromname='MyVendorCenter.com';
		//$assignuseremail='rize.test@gmail.com';
		$assignuseremail='support@myvendorcenter.com';
		$mailsubject='New Vendor Registered On CAMAssistant';
		$notification = "SELECT introtext  FROM #__content where id='191'";
		$db->setQuery($notification);
		$body = $db->loadResult();
		$body = str_replace('{EMAIL}', $email, $body);
		$body = str_replace('{USERNAME}', $username, $body);
		//print_r($body); exit;
		JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body, $mode = 1);
		JRequest::getVar('view','vendors');
		parent::display();

	}
	
	function activation (){

		//echo "<pre>"; print_r($_REQUEST); exit;
		$db	=& JFactory::getDBO();
		$email = JRequest::getVar( 'email' );
		$user_id = JRequest::getVar( 'user_id' );
		$name = JRequest::getVar( 'name' );
		$query='SELECT activation FROM #__cam_vendor_company where user_id='.$user_id;
		$db->Setquery($query);
		$result = $db->loadResult();
		
		$mailfrom = 'support@myvendorcenter.com';
		$fromname = 'MyVendorCenter.com';
		$assignuseremail = $email;
		$mailsubject = 'Email Verification';
		$siteURL		= JURI::root();
		$link = '<a href="'.$siteURL.'index.php">CLICK HERE</a>'; 
		$link1 = $siteURL.'index.php'; 
		//print_r($link); exit;
		$mail_content_sql="SELECT introtext  FROM #__content where id='166' ";
		$db->Setquery($mail_content_sql);
		$content = $db->loadResult();
		jimport('joomla.user.helper');
		$vendor['activation'] = JUtility::getHash( JUserHelper::genRandomPassword() ); 
		$siteURL		= JURI::root();
		$link = "<a href=".$siteURL."index.php?option=com_camassistant&controller=vendors&Itemid=158&task=mail_redirect_form&useractivation=".$vendor['activation']."&view=vendors&from=resend'>CLICK HERE</a>"; 
		$link1 = $siteURL."index.php?option=com_camassistant&controller=vendors&Itemid=158&task=mail_redirect_form&useractivation=".$vendor['activation']."&view=vendors&from=resend"; 
		$body = str_replace('{VENDOR NAME}',$name,$content) ;
		$body = str_replace('{CLICK HERE}',$link,$body) ;
		$body = str_replace('{ACTIVATION LINK}',$link1,$body) ;
			//$body = $body_content; 
			//$body = "Hi ".$name."! <br/>Please <a href='camassistant.com/cms/index.php?option=com_camassistant&controller=vendorsignup&Itemid=158&task=mail_redirect_form&useractivation=".$result."&view=vendorsignup'>CLICK HERE</a> to complete your Vendor Registration.<br/><br/>At Your Service,<br/><br/>CAMASSISTANT.COM";
			
		$success = JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
		$assignuseremail = 'vendoremails@myvendorcenter.com';
		$success = JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
		//code to update status of vendor in users,vendor company tables 
		if($success){
		$query = 'UPDATE #__cam_vendor_company'
		. ' SET status = "pending", activation ="'.$vendor['activation'].'" WHERE user_id IN ( '. $user_id.'  )';
		$db->setQuery( $query );
		$db->query();
		
		$query = 'UPDATE #__users'
		. ' SET block = "1" WHERE id IN ( '. $user_id.'  )';
		$db->setQuery( $query );
		$db->query();
		$this->setRedirect( 'index.php?option=com_camassistant&controller=vendors','Email Verification Sending Successfully');	
	}
	}
	//to send approve mail to vendor
	function Approve()
	{
			//code to send vendor approve email
		$db			=& JFactory::getDBO();
		$user_id = JRequest::getVar('user_id','');
		//to update status in users table
		$query = 'UPDATE #__users'
		. ' SET block = 0 WHERE id IN ( '. $user_id.'  )' ;
		$db->setQuery( $query );
		$db->query();
		$query = 'UPDATE #__cam_vendor_company'
		. ' SET status = "approved" WHERE user_id IN ( '. $user_id.'  )';
		$db->setQuery( $query );
		$db->query();
		$get_name_sql='SELECT CONCAT(U.name," " ,U.lastname) "Fullname", email FROM #__users as U where U.id='.$user_id;
		$db->Setquery($get_name_sql);
		$vendor = $db->loadObjectList();
		$mail_content_sql="SELECT introtext  FROM #__content where id='150' ";
		$db->Setquery($mail_content_sql);
		$content = $db->loadResult();
		$link = "<a href='myvendorcenter.com/live/index.php'>CLICK HERE</a>";
		$body_content = str_replace('{VENDOR COMPANY NAME}',$vendor[0]->Fullname,$content) ;
		$body_content = str_replace('{CLICK HERE}',$link,$body_content) ;
		//code to send mail to user
		$mailfrom = 'support@myvendorcenter.com';
		$fromname = 'MyVendorCenter.com';
		$assignuseremail = $vendor[0]->email;
		$mailsubject = 'Approved Registration';
		$body = $body_content; 
		JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
		$this->setRedirect( 'index.php?option=com_camassistant&controller=vendors','Vendor Approved Successfully');	
	}
	//to send Reject mail to vendor
	function Reject()
	{
		//code to send vendor Reject  email
		$db			=& JFactory::getDBO();
		$user_id = JRequest::getVar('user_id','');
		//to update status in users table
		$query = 'UPDATE #__users'
		. ' SET block = 1 WHERE id IN ( '. $user_id.'  )' ; 
		$db->setQuery( $query );
		$db->query();
		//to update status vendor table
		$query = 'UPDATE #__cam_vendor_company'
		. ' SET status = "rejected" WHERE user_id IN ( '. $user_id.'  )'
		;
		$db->setQuery( $query );
		$db->query();
		$get_name_sql='SELECT CONCAT(U.name," " ,U.lastname) "Fullname", email FROM #__users as U where U.id='.$user_id;
		$db->Setquery($get_name_sql);
		$vendor = $db->loadObjectList();
		//code to send reject mail to user
		$mailfrom = 'support@myvendorcenter.com';
		$fromname = 'MyVendorCenter.com';
		$assignuseremail = $vendor[0]->email;
		$mailsubject = 'Rejected Registration';
		//$body = $body_content; 
		$reject_message = "SELECT introtext  FROM #__content where id='193'";
		$db->setQuery($reject_message);
		$body_msg = $db->loadResult();
		$body = str_replace('{Vendor Name}',$vendor[0]->Fullname,$body_msg);				
		//$body = "Hai ".$vendor[0]->Fullname."! <br/>Sorry your application has been rejected.<br/><br/>At Your Service,<br/><br/>CAMASSISTANT.COM";
		//code to send mail to user
		$mailfrom = 'support@myvendorcenter.com';
		$fromname = 'MyVendorCenter.com';
		$assignuseremail = $vendor[0]->email;
		$mailsubject = 'Rejected Registration';
		JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
		$this->setRedirect( 'index.php?option=com_camassistant&controller=vendors','Vendor Rejected Successfully');	
	}
	function changesubscriotionstatus(){
	$db	=& JFactory::getDBO();
	$user_id = JRequest::getVar('user_id','');
	$query = "UPDATE #__users SET subscribe = 'no', subscribe_type='', subscribe_sort='' WHERE id=".$user_id." ";
	$db->setQuery( $query );
	$db->query();	
	//Delete from subscription table
	$queryd = "DELETE FROM #__cam_vendor_subscriptions WHERE vendorid=".$user_id; 
	$db->setQuery($queryd); 
	$db->query() ;
	//Completed
	$this->setRedirect( 'index.php?option=com_camassistant&controller=vendors&task=displayext','Vendor subscription status changed Successfully');	
	}	
}	
?>
