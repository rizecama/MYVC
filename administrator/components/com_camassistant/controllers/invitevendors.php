<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//echo '<pre>'; print_r($_REQUEST); exit;
// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );
 
class InvitevendorsController extends JController
{
	function __construct( $default = array())
	{
		parent::__construct( $default );
		
	}
	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}

	function display() {

		parent::display();
	}
	function remove()
	{
		
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$cids = implode( ',', $cid );
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('invitevendors');
		if($res <= 0)
		{
			$model->delete($cid) ;
			/*if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}*/
			$msg='';
			$msg='Vendors Deleted Successfully';
		}
		$this->setRedirect( 'index.php?option=com_camassistant&controller=invitevendors&camid='.$_REQUEST['camid'].'',$msg);
	 }
	 	function newexclude()
	{
		JRequest::setVar('view', 'invitevendors');
		parent::display();
	}

function newinvitation(){
		JRequest::setVar('view', 'invitevendors');
		parent::display();
}
///function to send the invitations to all types(preferred and inhouce and excluding)
function inhousevendors(){


	$db =& JFactory::getDBO();
	$model = $this->getModel('invitevendors');
	$post = JRequest::get('get');
	$tax1 = JRequest::getVar( 'tax1','');
	$send = JRequest::getVar( 'send','');
	$tax2 = JRequest::getVar( 'tax2','');
	$tax = $tax1.'-'.$tax2;
	$userid = JRequest::getVar( 'userid','');
	$vendortype = JRequest::getVar( 'vendortype','' );
	$inviters = JRequest::getVar( 'inhouse','' );
	$articletype = JRequest::getVar( 'articletype','');
	$inhouse = explode(',',$inviters);
	//for loop for multiple vendors invitations...
	for($i=0; $i<count($inhouse); $i++){
		$to = $inhouse[$i];
		$query_email = "SELECT email,name,lastname FROM #__users where id =".$userid;
		$db->setQuery($query_email);
		$mailfrom=$db->loadObject();
		$from_email = $mailfrom->email;
		$from_name = $mailfrom->name.'&nbsp;'.$mailfrom->lastname;
		$from_name = str_replace('&nbsp;',' ',$from_name);
		if($vendortype =='preferred'){
		$subject = 'Preferred Vendor Invitation'; 
		$text = 'Preferred invitation from camfirm'; }
		if($vendortype =='inhouse'){
		$subject = 'Invite as In-House vendor'; $text = 'In house invitation from camfirm'; }
	
		$fei=$model->getfei($to,$userid);
		$post['userid'] = $userid;
		
		$to_id = "SELECT id FROM #__users where email =".$to."";
		$db->setQuery($to_id);
		$v_id=$db->loadResult();
		if($v_id)
		$post['v_id'] = $v_id;
		else
		$post['v_id']=0;
		$post['vendortype'] = $vendortype;
		
		$post['fei'] = $fei;
		$post['inhousevendors'] = $to;
		$post['inhouse'] = $to;
		$post['subject'] = $subject;
		$post['inhousetext'] = $text;
		$post['status'] = 1;
		$post['articletype'] = $articletype ;
		$body = $model->getbody($fei,$vendortype,$to,$userid,$subject,$articletype); 
		//echo $body; exit;
		$model = $this->getModel('invitevendors');
		//$check = $model->getcheck($to,$userid);
		if($vendortype!='exclude'){
			$successMail =JUtility::sendMail($from_email, $from_name, $to, $subject, $body,$mode = 1);
					$save = $model->store_invites($post); 
		 } 
		  
	 }//////for loop competed 
	 ?> 
	<script type="text/javascript">
	<?php if(!$send){?>
	window.parent.document.getElementById( 'sbox-window' ).close();
	<?php } ?>
	window.parent.location.href = 'index.php?option=com_camassistant&controller=invitevendors';
	alert("Vendor invited successfully.");
	</script>

	<?php
	if($vendortype=='exclude'){
	$model = $this->getModel('invitevendors');
	$tax_details = $model->getchecktax($tax);
	$post['v_id'] = $tax_details->id;
	$post['inhousevendors'] = $tax_details->email;
	$post['inhouse'] = $tax_details->email;
	$post['taxid'] = $tax;
	$post['exclude'] = 1;
	//echo "<pre>"; print_r($post); exit;	
	 $save = $model->store($post);
	 ?>
	<script type="text/javascript">
	window.parent.document.getElementById( 'sbox-window' ).close();
	window.parent.location.href = 'index.php?option=com_camassistant&controller=invitevendors';
	alert("TAXID ecluded successfully.");
	</script>
	 <?php }
}


	//Function to check the emial id status on 02-08-11 by sateesh
		function verfiryemailid(){
		$db =& JFactory::getDBO();
		$emailid=$_POST['queryString'];
		$user=$_REQUEST['userval']; 
		if ($emailid != "")
		{
		$query_emailid="SELECT inhouse,status,vendortype FROM #__vendor_inviteinfo  WHERE userid=".$user." AND inhousevendors='".$emailid."'";
		$db->setQuery( $query_emailid );
		$result_email = $db->loadObjectList();
	
		if($result_email[0]->inhouse && $result_email[0]->status == 1){
		$data="invalid"; 
		 }
		 else if($result_email[0]->vendortype == 'exclude'){
		 $data="invalid"; 
		 }
		 else if($result_email[0]->inhouse && $result_email[0]->status == 0) {
		 $data="valid";  
		 }
		}
		echo $data;
		exit;
   }
   
   function verfiryexcludeid(){
		$db =& JFactory::getDBO();
		$user=$_REQUEST['userval']; 
		$taxid=$_POST['queryString'];
		if ($taxid != "")
		{
		$query_emailid="SELECT vid FROM #__vendor_inviteinfo  WHERE userid=".$user." AND taxid='".$taxid."'";
		$db->setQuery( $query_emailid );
		$result_email = $db->loadResult();
		if($result_email){
		$data = 'invalid';
		}
		}
		echo $data;
		exit;
   }
   //To get the body
	function article(){
		$db =& JFactory::getDBO();
		$article=$_POST['queryString'];
		if($article=='high'){
		$article="SELECT introtext FROM #__content  WHERE id=211";
		}
		else{
		$article="SELECT introtext FROM #__content  WHERE id=152";
		}
		$db->setQuery( $article );
		$body = $db->loadResult();
		$tags = array("<p>","</p>","<br>","<br />");
		$rtags = array("","\n","\n","\n");
		$data = str_replace($tags, $rtags, $body);
		echo $data;
		exit;
   }
   
   //Completed
   
    //To get the body
	function newarticle(){
		$db =& JFactory::getDBO();
		$article=$_POST['queryString'];
		if($article=='262'){
		$article="SELECT introtext FROM #__content  WHERE id=262";
		}
		
		$db->setQuery( $article );
		$body = $db->loadResult();
		$tags = array("<p>","</p>","<br>","<br />");
		$rtags = array("","\n","\n","\n");
		$data = str_replace($tags, $rtags, $body);
		echo $data;
		exit;
   }
   
   function newemailinvitationsend(){
   $db =& JFactory::getDBO();
   $to = JRequest::getVar( 'to','');
   $article = JRequest::getVar( 'articletype','');
   $subject = JRequest::getVar( 'subject','');
   $from_email = 'support@myvendorcenter.com';
   $from_name = 'MyVendorCenter';
   
   	   if($to == 'support'){
	   $article="SELECT introtext FROM #__content  WHERE id=262";
	   $users = " SELECT id,email FROM #__users WHERE username='support@myvendorcenter.com' or email='support@myvendorcenter.com' ";
	   $sendto = 'myvc';
	   }
	   else if($to == 'subscribe'){
	   $article="SELECT introtext FROM #__content  WHERE id=262";
	   $users = "SELECT id,email,ccemail FROM #__users WHERE subscribe='yes' ";
	   $sendto = '';
	   }	   
	   else if($to == 'unsubscribe'){
	   $article = "SELECT introtext FROM #__content  WHERE id=262";
	   $users = "SELECT id,email,ccemail FROM #__users WHERE user_type='11' and (subscribe='' or subscribe='no') ";	   
	   $sendto = '';
	   }
	   else if($to == 'allvendor'){
	   $article = "SELECT introtext FROM #__content  WHERE id=262";
	   $users = "SELECT id,email,ccemail FROM #__users where user_type='11' ";	   	   
	   $sendto = '';
	   }
	   else if($to == 'managers'){
	   $article = "SELECT introtext FROM #__content  WHERE id=262";
	   $users = "SELECT id,email,ccemail FROM #__users where user_type='12' ";	   	    
	   $sendto = '';
	   }
	   else if($to == 'firsmmanagers'){
	   $article = "SELECT introtext FROM #__content  WHERE id=262";
	   $users = "SELECT id,email,ccemail FROM #__users where user_type='13' ";	   	    	   
	   $sendto = '';
	   }
	   else if($to == 'allmanagers'){
	   $article = "SELECT introtext FROM #__content  WHERE id=262";
	   $users = "SELECT id,email,ccemail FROM #__users where user_type='13' or user_type='12' ";	   	    	   
	   $sendto = '';
	   }
	   else {
	   $article = "SELECT introtext FROM #__content  WHERE id=262";
	   $users = "SELECT id,email,ccemail FROM #__users ";	   	   
	   $sendto = '';
	   }
	   $db->setQuery( $users );
	   $total_users = $db->loadObjectList();
	  
	   //To get the body
	   $db->setQuery( $article );
	   $body = $db->loadResult();
	   //Completed
	   for( $i=0; $i<count($total_users); $i++ ){
	   $to = $total_users[$i]->email;
	   if( $sendto == 'myvc' ){
	   $to = 'support@myvendorcenter.com';
	   }
	   else{
	   $to = $to ;
	   }
  
	  $successMail = JUtility::sendMail($from_email, $from_name, $to, $subject, $body,$mode = 1);
	   
	   	if($total_users[$i]->ccemail){
			$cc = $total_users[$i]->ccemail ;
			$cclist = explode(';',$cc);
			
			for($c=0; $c<=count($cclist); $c++){
			$listcc = $cclist[$c];
				if($listcc){
				$successMail = JUtility::sendMail($from_email, $from_name, $listcc, $subject, $body,$mode = 1);
				}
			}
		
		}
	   }
	   
	   echo "SUCCESS"; exit;
   }
   
   function deletevendor(){
   		$db =& JFactory::getDBO();
   		$id = JRequest::getVar( 'id','');
		$query = 'DELETE FROM #__vendor_inviteinfo where vid='.$id; 
		$db->setQuery($query);
		$db->Query();
		$msg='Invitation Deleted Successfully';
		$this->setRedirect( 'index.php?option=com_camassistant&controller=invitevendors',$msg);
		
   }
   
}	
?>