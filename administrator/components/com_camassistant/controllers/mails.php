<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );

class mailsController extends JController
{
	function __construct( $default = array())
	{
		parent::__construct( $default );
		$this->registerTask( 'apply',		'save' );
	}

	// function edit
	function edit()
	{
		JRequest::setVar( 'view', 'mails' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1);

		parent::display();

		$model = $this->getModel('mails');
		$model->checkout();
	}
	//function to go for Camassistant Control Panel(Prasad 12 Jan 2011)
	function lists()
	{
		// Panel 
		$this->setRedirect( 'index.php?option=com_camassistant&controller=camassistant' );
	}
	// function save
	function save()
	{
		// $task = JRequest::getVar("task",'');
 		 $task = JRequest::getVar("task",'');
		 $customer_confirm = JRequest::getVar( 'customer_confirm', '', 'post', 'string', JREQUEST_ALLOWHTML );
		 $customer_appemail = JRequest::getVar( 'customer_appemail', '', 'post', 'string', JREQUEST_ALLOWHTML );
 		 $vendor_appemail = JRequest::getVar( 'vendor_appemail', '', 'post', 'string', JREQUEST_ALLOWHTML );
		 $invite_vinhouse = JRequest::getVar('invite_vinhouse','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $invite_vpreferred = JRequest::getVar('invite_vpreferred','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $pro_hired_propertyassociation = JRequest::getVar('pro_hired_propertyassociation','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $hire_pro_camassistant = JRequest::getVar('hire_pro_camassistant','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $vendors_meet_myproject = JRequest::getVar('vendors_meet_myproject','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $automated_awardemail = JRequest::getVar('automated_awardemail','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $automated_rejectedemail = JRequest::getVar('automated_rejectedemail','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $invite_manager = JRequest::getVar('invite_manager','', 'post', 'string', JREQUEST_ALLOWHTML );
	 	 $invite_rvinhouse = JRequest::getVar('invite_rvinhouse','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $invite_rvpreferred = JRequest::getVar('invite_rvpreferred','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $email_boardmember = JRequest::getVar('email_boardmember','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $rfp_invitation = JRequest::getVar('rfp_invitation','', 'post', 'string', JREQUEST_ALLOWHTML );
		 $cancel_rfp = JRequest::getVar('cancel_rfp','', 'post', 'string', JREQUEST_ALLOWHTML );
		  $udrfp_invitation = JRequest::getVar('udrfp_invitation','', 'post', 'string', JREQUEST_ALLOWHTML );
		 //print_r($cancel_rfp);
		$db=JFactory::getDBO();
	 $sql="UPDATE #__emails SET customer_confirm='$customer_confirm',customer_appemail='$customer_appemail',vendor_appemail ='$vendor_appemail',invite_vinhouse ='$invite_vinhouse' ,invite_vpreferred='$invite_vpreferred',pro_hired_propertyassociation='$pro_hired_propertyassociation',hire_pro_camassistant='$hire_pro_camassistant',vendors_meet_myproject='$vendors_meet_myproject',automated_awardemail='$automated_awardemail',automated_rejectedemail='$automated_rejectedemail',invite_manager='$invite_manager' ,invite_rvinhouse='$invite_rvinhouse',invite_rvpreferred='$invite_rvpreferred',email_boardmember='$email_boardmember',udrfp_invitation='$udrfp_invitation',cancel_rfp='$cancel_rfp',rfp_invitation='$rfp_invitation' WHERE id='1'";
	//exit;
	$db->setQuery($sql);

	$res=$db->query(); 

			
	if($res)
	{
	$msg = 'Updated Successfully';
	$url = 'index.php?option=com_camassistant&controller=mails';
	$this->setRedirect( $url, $msg );
	}
	else {
	$msg = 'Not updated';
	$url = 'index.php?option=com_camassistant';
	$this->setRedirect( $url, $msg );
	}
		$model = $this->getModel('mails');
        //validation to restirct duplicate category names
		
		//echo $cnt; exit;
		//$
//			if ($model->store($post)) {
//				$msg = JText::_( 'Configuration Saved' );
//			} else {
//				$msg = JText::_( 'Error Saving Configuration' );
//			}
//        
//		$model->checkin();
//		$db		=& JFactory::getDBO();
//		$query = "SELECT max(id) FROM #__cam_configuration"; 
//		$db->setQuery( $query );
//		$catid = $db->loadResult();
//		switch ($task)
//		{
//			case 'apply':
//			if($post['id']) $cat_id = $post['id']; else  $cat_id = $catid;
//				$link = 'index.php?option=com_camassistant&controller=category_detail&task=edit&cid[]='. $cat_id ;
//				break;
//			case 'save':
//			default:
//				$link = $link = 'index.php?option=com_camassistant&controller=category';
//				break;
//		}
//		$this->setRedirect( $link,$msg );
		//$this->setRedirect( $link, JText::_( 'Item Saved' ) );
	}

	// function remove
	function remove()
	{
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cids = implode( ',', $cid );
       /* $db = JFactory::getDBO();
		$query ="SELECT catname FROM #__camassistant_category WHERE id IN (".$cids.")";
		$db->setQuery($query);
		$db->query();
		$catname = $db->loadResultArray ();
		$catnames = implode( ',', $catname );*/
		/***************Case 3. Retailers assigned as primary categories*********************/
		/*$query ="SELECT count(*) FROM #__camassistant_retailer WHERE catid IN (".$cids.")"; 
		$db->setQuery($query);
		$db->query();
		$res = $db->loadResult();   */
		
		/***************end of code Case 3. Retailers assigned as primary categories************/
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('category_detail');
/*		if($res <= 0)
		{
*/			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}
			$msg='';
			$msg='Industry Deleted Successfully';
		/*}*/
		/*else	
        $msg = $catnames.' cannot  be removed as they contain Retailers as a primary reference.';
		if($msg == 'Industry Deleted Successfully')
		header("Location: index.php?option=com_camassistant&controller=category&msg=deleted");
		else*/
		$this->setRedirect( 'index.php?option=com_camassistant',$msg);
	}
	
	// function cancel
	function cancel()
	{
		// Checkin the detail
		$model = $this->getModel('mails');
		$model->checkin();
		$this->setRedirect( 'index.php?option=com_camassistant' );
	}	
	
}

?>