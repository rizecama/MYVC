<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );
 
class customerController extends JController
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

	function display() {

		parent::display();
	}
	
/*    function unpublish()
	{
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		$publish	= 0;

		
		$n			= count( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__cam_customer_companyinfo'
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning(500, $db->getError());
		}
				$this->setRedirect( 'index.php?option=com_camassistant&controller=customer','customer Unpublished Successfully');

	}
	
	function publish()
	{
		// Check for request forgeries


		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		$publish	= ($task == 'publish');
		$n			= count( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__cam_customer_companyinfo'
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )'
	
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
		$this->setRedirect( 'index.php?option=com_camassistant&controller=customer','customer Published Successfully');

	}*/
	function remove()
	{
		
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cids = implode( ',', $cid );
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('customer');
		if($res <= 0)
		{
			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}
			//$msg='';
			
			$msg='Customer Deleted Successfully';
		}
		$this->setRedirect( 'index.php?option=com_camassistant&controller=customer',$msg);
	 }
	 function activation(){
	 
	 //echo "<pre>"; print_r($_REQUEST); exit;
	 
		$db	=& JFactory::getDBO();
		$email = JRequest::getVar( 'email' );
		$user_id = JRequest::getVar( 'user_id' );
		$name = JRequest::getVar( 'name' );
		
	 
		jimport('joomla.user.helper');
		$activation = JUtility::getHash( JUserHelper::genRandomPassword() ); 
		$siteURL		= JURI::root();
	
				$useractivation = $siteURL."index.php?option=com_camassistant&controller=propertymanager&task=useractivation&useractivation=".$activation."&Itemid='105'";
			$link = '<a href="'.$useractivation.'">CLICK HERE</a>'; 
				$mailsubject = 'Registration Verification';
				$mail_sending= "SELECT introtext  FROM #__content where id='148' ";
				$db->Setquery($mail_sending);
				$content = $db->loadResult();
				$link = '<a href="'.$useractivation.'">CLICK HERE</a>'; 
				$body = str_replace('{customer name}',$name,$content) ;
				$body = str_replace('{CLICK HERE}',$link,$body) ;
				$body = str_replace('{LINK}',$useractivation,$body) ;
				$mailfrom= 'support@myvendorcenter.com';
				$fromname = 'MyVendorCenter.com';
				$assignuseremail = $email;
			
				$success= JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body, $useractivation,$mode = 1);
				$assignuseremail = 'manageremails@myvendorcenter.com';
				$success= JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body, $useractivation,$mode = 1);
				if($success){
					$query = 'UPDATE #__cam_customer_companyinfo'
					. ' SET status = "inactive", activation ="'.$activation.'" WHERE cust_id IN ( '. $user_id.'  )';
					$db->setQuery( $query );
					$db->query();
					
					$query = 'UPDATE #__users'
					. ' SET block = "1" WHERE id IN ( '. $user_id.'  )';
					$db->setQuery( $query );
					$db->query();
		$this->setRedirect( 'index.php?option=com_camassistant&controller=customer','Email Verification Sending Successfully');	
				}
	 }
	 function block()
	{
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$user_ids		= JRequest::getVar( 'user_ids', array(), 'post', 'array' );
		$user_id = $cid[0];
		//$user_id = $user_ids[$vendor_id];
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
		//to update vendor table
		$query = 'UPDATE #__cam_customer_companyinfo'
		. ' SET published = ' . (int) $publish
		. ' WHERE cust_id IN ( '. $user_id.'  )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning(500, $db->getError());
		}
				$this->setRedirect( 'index.php?option=com_camassistant&controller=customer','Vendor Unpublished Successfully');

	}
	
	function unblock()
	{
		// Check for request forgeries
		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$user_ids		= JRequest::getVar( 'cust_id', array(), 'post', 'array' );
		$user_id = $cid[0];
		//$user_id = $user_ids[$cust_id];
		$task		= JRequest::getCmd( 'task' );
		$publish	= 0;
		// print_r($cust_id); exit;
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
		$query = 'UPDATE #__cam_customer_companyinfo'
		. ' SET published = ' . (int) $publish
		. ' WHERE cust_id IN ( '. $user_id.'  )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
		$this->setRedirect( 'index.php?option=com_camassistant&controller=customer','Customer Published Successfully');

	}
	

	
	function approve()
	{
		
		//code to send vendor approve email
		$db			=& JFactory::getDBO();
		$user_id = JRequest::getVar('user_id','');
		//to update status in users table
		$query = 'UPDATE #__users'	. ' SET block = 0 WHERE id IN ( '. $user_id.'  )' ;
		$db->setQuery( $query );
		$db->query();
		$query1 = 'UPDATE #__cam_customer_companyinfo'	. ' SET status = "approved" WHERE cust_id IN ( '. $user_id.'  )';
		$db->setQuery( $query1 );
		$db->query();

		$get_name_sql='SELECT CONCAT(U.name," " ,U.lastname) "Fullname", email FROM #__users as U where U.id='.$user_id;
		$db->Setquery($get_name_sql);
		$propertymanager = $db->loadObjectList();
		//$mail_content_sql="SELECT vendor_appemail FROM #__emails where id='1'";
//		$db->Setquery($mail_content_sql);
//		$content = $db->loadResult();
		//$link = "<a href='camassistant.com/cms/index.php?option=com_user&view=login'>CLICK HERE</a>"; 
//		$body_content = str_replace('{VENDOR COMPANY NAME}',$vendor[0]->Fullname,$content) ;
//		$body_content = str_replace('{CLICK HERE}',$link,$body_content) ;
		//code to send mail to user
		$mailfrom = 'support@myvendorcenter.com';
		$fromname = 'MyVendorCenter.com';
		$assignuseremail = $propertymanager[0]->email;
		$mailsubject = 'Approved Registration';
		$mail_sending="SELECT introtext  FROM #__content where id='149' ";
			$db->Setquery($mail_sending);
			$content = $db->loadResult();
			//$siteURL		= JURI::base();
			//$link = '<a href="'.$siteURL.'index.php">CLICK HERE</a>'; 
			//$link = "<a href='camassistant.com/cms/index.php'>CLICK HERE</a>"; 
			$body = str_replace('{customer name}',$propertymanager[0]->Fullname,$content) ;
			//$body_content = str_replace('{CLICK HERE}',$link,$body_content) ;
		//$body="Congratulations ".$propertymanager[0]->Fullname."! <br/>
//You have successfully activated your account and completed the registration process.<br/><br/>You can now begin adding Properties & creating RFPs
//<br/><br/>At Your Service,<br/><br/>
//<b>The CAMassistant.com Team</b>";
		//$body = $body_content; 
	
		JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
		//$assignuseremail = 'manageremails@myvendorcenter.com';
		$assignuseremail = 'manageremails@myvendorcenter.com';
		JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
		$this->setRedirect( 'index.php?option=com_camassistant&controller=customer','Customer Approved Successfully');	
	}
	
	//to send Reject mail to vendor
	function reject()
	{
		//code to send vendor Reject  email
		$db			=& JFactory::getDBO();
		$user_id = JRequest::getVar('user_id','');
		//to update status in users table
		 $query = 'UPDATE #__users'
		. ' SET block = 1 WHERE id IN ( '. $user_id.'  )' ; 
		$db->setQuery( $query );
		$db->query();
		$query1 = 'UPDATE #__cam_customer_companyinfo'
		. ' SET status = "rejected" WHERE cust_id IN ( '. $user_id.'  )'
		;
		//exit;
		$db->setQuery( $query1 );
		$db->query();
		$get_name_sql='SELECT CONCAT(U.name," " ,U.lastname) "Fullname", email FROM #__users as U where U.id='.$user_id;
		$db->Setquery($get_name_sql);
		$propertymanager = $db->loadObjectList();
		//code to send reject mail to user
		//$mailfrom = 'support@camassistant.com';
		$mailfrom = 'support@myvendorcenter.com';
		$fromname = 'MyVendorCenter.com';
		$assignuseremail = $propertymanager[0]->email;
		$mailsubject = 'Rejected Registration';
		$mail_sending="SELECT introtext  FROM #__content where id='193' ";
		$db->Setquery($mail_sending);
		$content = $db->loadResult();
		$body = str_replace('{Manager Name}',$propertymanager[0]->Fullname,$content) ;
		//$body = $body_content; 
		//$body = "Hai ".$propertymanager[0]->Fullname."! <br/>Sorry your application has been rejected.<br/><br/>At Your Service,<br/><br/>CAMASSISTANT.COM";
		//code to send mail to user
	
		JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
		$this->setRedirect( 'index.php?option=com_camassistant&controller=customer','Customer Rejected Successfully');	
	}
//Function to assign master 
	function assignmaster(){
	JRequest::setVar('view', 'customer');
		parent::display();
	}
	//Completed
	function assignfirm(){
		$firmid = JRequest::getVar('firmid');
		$masterid = JRequest::getVar('masterid');
		$db			=& JFactory::getDBO();
		$today = date('Y-m-d H:i:s');
		$insert_sql = "insert into #__cam_masteraccounts values ('','".$masterid."','".$firmid."','".$today."','')";
		$db->SetQuery($insert_sql);
		$db->query();
		?>
		<script type="text/javascript">
		window.parent.document.getElementById( 'sbox-window' ).close();
		alert("Firm has been assigned to masterfirm.");
		window.parent.location.href = 'index.php?option=com_camassistant&controller=customer';
		</script>
	<br />
<?php 
	}
	//Function to get the firms under master firm
	function getsubfirms(){
	$db			=& JFactory::getDBO();
	$masterid = JRequest::getVar('master');
	$camfirmid = JRequest::getVar('firmid');
	//To get the master id
		$sql = "SELECT masterid from #__cam_masteraccounts where firmid=".$camfirmid." ";
		$db->Setquery($sql);
		$masteraccountid = $db->loadResult();
	//Completed
	$type = JRequest::getVar('type');
	if($type != 'managers'){
		$sql = "SELECT firmid from #__cam_masteraccounts where masterid=".$masterid." ";
		$db->Setquery($sql);
		$subfirms = $db->loadObjectlist();
		if($subfirms){
			foreach($subfirms as $firmid){
				$firms[] = $firmid->firmid;
			}
		}
		$firmsarr = implode(',',$firms);
	}
	
	else{
		//To get the company id
		$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$camfirmid." ";
		$db->Setquery($sql);
		$companyid = $db->loadResult();
		//To get the users under the company
		$sql_cid = "SELECT cust_id from #__cam_customer_companyinfo where comp_id=".$companyid." ";
		$db->Setquery($sql_cid);
		$managerids = $db->loadObjectlist();
		
		if($managerids){
			foreach($managerids as $mansid){
				$mansids_withdm[] = $mansid->cust_id;
			}
		}
		
		for( $i=0; $i<count($mansids_withdm); $i++ ){
		$sql_mans = "SELECT managerid from #__cam_invitemanagers where dmanager=".$mansids_withdm[$i]." ";
		$db->Setquery($sql_mans);
		$mansidss = $db->loadObjectList();
			if($mansidss){
				foreach($mansidss as $mansidss){
					$remove_mans[] = $mansidss->managerid;
				}
			}
		}
		//echo "<pre>"; print_r($remove_mans); echo "</pre>";
			if($remove_mans){
			$mansids = array_diff($mansids_withdm, $remove_mans);	
			}
			else {
			$mansids = $mansids_withdm;
			}
		
		$firmsarr = implode(',',$mansids);
	}
		
	$sql_firms = "SELECT u.user_type,u.id,u.lastname,u.name,u.email,u.registerDate,u.lastvisitDate,u.dmanager,u.phone,u.username,u.flag,u.suspend,u.password,u.block as published,c.camfirm_license_no,c.comp_id ,c.comp_name,c.tax_id,c.status,c.cust_id,u.accounttype FROM #__users as u LEFT JOIN #__cam_customer_companyinfo as c ON c.cust_id= u.id WHERE u.id=c.cust_id AND u.user_type!=11 AND u.id IN(".$firmsarr.") group by u.id ORDER BY u.dmanager ASC";

	$db->Setquery($sql_firms);
	$firstfirms = $db->loadObjectlist();
	for( $f=0; $f<count($firstfirms); $f++ ){
	$task 	= $firstfirms[$f]->published ? 'unblock' : 'block';
	$img 	= $firstfirms[$f]->published ? 'publish_x.png' : 'tick.png';
	$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=customer_detail&task=edit&cid[]='. $firstfirms[$f]->id );
	$approve_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=customer&task=approve&user_id='. $firstfirms[$f]->cust_id );
	$reject_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=customer&task=reject&user_id='. $firstfirms[$f]->cust_id );
	?>
<?php if( $firstfirms[$f]->user_type == '13' ) { 
    $clss = 'admin';  
}
else {
    $clss = 'district';  
}
?>

	<tr class="subfirms_<?php if(!$masterid) echo $camfirmid.' subfirms_'.$masteraccountid ; else echo $masterid; ?> <?php echo $clss; ?>">
	
			<td width="3%"></td>
			<td width="4%"><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $firstfirms[$f]->id; ?>" name="cid[]" id="cb0">	</td>
			<td>
			<?php
			if($firstfirms[$f]->user_type == '13' ){ ?>
<a style="color:green; font-weight:bold; font-size:17px;" href="javascript:void(0);" rel="<?php echo $firstfirms[$f]->id ;?>" class="masterfirmsmans" id="masterfirmsmans<?php echo $firstfirms[$f]->id; ?>">+</a>			
			<?php } else if($firstfirms[$f]->user_type == '12' && $firstfirms[$f]->dmanager == 'yes'){ ?>
<a style="color:green; font-weight:bold; font-size:17px;" href="javascript:void(0);" rel="<?php echo $firstfirms[$f]->id ;?>" class="masterfirmsdis" id="districtmans<?php echo $firstfirms[$f]->id; ?>">+</a>			
			<?php }
			?>
			</td><td align="center" width="6%">
			<?PHP
			//echo "<pre>"; print_r($row);
			if($firstfirms[$f]->user_type == '12' && $firstfirms[$f]->dmanager == 'yes') { echo 'District Manager'; }
			else if($firstfirms[$f]->user_type == '12') { echo 'Manager'; }
			else if($firstfirms[$f]->user_type == '13') {echo 'Camfirm Administartor'; }
			else { }
			?>
			</td>
			
				<?php 
				if($firstfirms[$f]->suspend == 'suspend' && $firstfirms[$f]->flag == 'flag') {$font = "red"; }
				else if($firstfirms[$f]->flag == 'flag') { $font = "#ff9900"; }
				else if($firstfirms[$f]->suspend == 'suspend') { $font = "red"; }
				else { $font = ''; }
				?> 
							
            <td width="15%">
			 
				<a title="Click a customer name to edit it" href="index.php?option=com_camassistant&amp;controller=customer_detail&amp;task=edit&amp;cid[]=<?php echo $firstfirms[$f]->id; ?>" target="_blank"><font color="<?php echo $font; ?>"><?php echo $firstfirms[$f]->comp_name; ?></font></a>
							</td>
                                          <td width="9%"><?php echo $firstfirms[$f]->camfirm_license_no; ?></td>
			<td width="9%"><a href="javascript:loginas('<?php echo $firstfirms[$f]->username ?>','<?php echo $firstfirms[$f]->password; ?>');"><?php echo $firstfirms[$f]->lastname . ', ' . $firstfirms[$f]->name; ?></a></td>
                        <td width="12%"><?php echo $firstfirms[$f]->email; ?></td>
			
             <td width="8%"><?php echo $firstfirms[$f]->lastvisitDate; ?></td>
			<td width="7%"><?php echo $firstfirms[$f]->registerDate; ?></td>
			<td width="8%"><?php echo $firstfirms[$f]->phone; ?></td>
						<td align="center" width="5%"><?PHP if($firstfirms[$f]->status != 'approved') echo '__'; else if($firstfirms[$f]->status == 'approved') { ?>
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
   <?PHP } ?>
			</td>
			
			<td align="center" width="5%" >
			<?PHP if($firstfirms[$f]->status == 'inactive') echo 'Inactive'; else if($firstfirms[$f]->status == 'rejected') echo 'Rejected'; else if($firstfirms[$f]->status == 'active') { ?><a href="<?PHP echo $approve_link; ?>">Approve</a> | <a href="<?PHP echo $reject_link; ?>">Reject</a> <?PHP } else if($firstfirms[$f]->status == 'approved' ) { echo 'Approved'; }  else echo 'Inactive';?>
			</td>
			
			<td align="center" width="15%">
			<?php $fullname = $firstfirms[$f]->name.' '.$firstfirms[$f]->lastname; ?>
			<a href="javascript:submit_resend('<?php echo $fullname; ?>', '<?php echo $firstfirms[$f]->email ?>','<?php echo $firstfirms[$f]->cust_id ?>');" >Resend Activation</a>
			</td>
			

			
<!--<td align="center" >
			<a href="javascript:loginas('<?php echo $firstfirms[$f]->username ?>','<?php echo $firstfirms[$f]->password; ?>');">Login As</a>
			</td>-->
			
		</tr>
		
		<?php
		if($firstfirms[$f]->user_type == '13') { ?>
		<tr id="mastermans<?php echo $firstfirms[$f]->id; ?>"></tr>
		<?php } else if($firstfirms[$f]->user_type == '12' && $firstfirms[$f]->dmanager == 'yes' ){ ?>
		<tr id="masterdis<?php echo $firstfirms[$f]->id; ?>"></tr>
		<?php }  } ?>
	<?php 
	exit;
	}
	//Completed
	
	//Function to remove the camfirm from the master account
	function removecamfirm(){
		$db			=& JFactory::getDBO();
		$camfirmid = JRequest::getVar('master');
		$query = 'DELETE FROM #__cam_masteraccounts WHERE firmid ='.$camfirmid.' '; 
		$db->Setquery($query);
			if($db->query()) {
				echo "success";
			}
			else{
			echo "fail";
			}
			exit;
	}
	//Completed
	
	//Function to get the district managers under the camfirm
	function getdistrictmanagers(){

		$db			=& JFactory::getDBO();
		$onlyfirm = JRequest::getVar('onlyfirm');
		$disid = JRequest::getVar('disid');
		if($onlyfirm)
		$type = 'cm' ;
		if($disid)
		$type = 'dm' ;
		
		$model = $this->getModel('customer');
		$districtmanagers = $model->dmanagers($onlyfirm, $disid, $type) ;
		
		for( $f=0; $f<count($districtmanagers); $f++ ){
	$task 	= $districtmanagers[$f]->published ? 'unblock' : 'block';
	$img 	= $districtmanagers[$f]->published ? 'publish_x.png' : 'tick.png';
	$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=customer_detail&task=edit&cid[]='. $districtmanagers[$f]->id );
	$approve_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=customer&task=approve&user_id='. $districtmanagers[$f]->cust_id );
	$reject_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=customer&task=reject&user_id='. $districtmanagers[$f]->cust_id );
	?>
	<tr class="dmanagershide_<?php if($disid) echo $disid; else echo $onlyfirm; ?>">
			<td width="3%"></td>
			<td width="4%"><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $districtmanagers[$f]->id; ?>" name="cid[]" id="cb0">	</td>
			<td>
			<?php
			if($districtmanagers[$f]->user_type == '12' && $districtmanagers[$f]->dmanager == 'yes'){ ?>
<a style="color:green; font-weight:bold; font-size:17px;" href="javascript:void(0);" rel="<?php echo $districtmanagers[$f]->id ;?>" class="masterfirmsdis" id="masterfirmsdis<?php echo $districtmanagers[$f]->id; ?>">+</a>			
			<?php }
			?>
			</td><td align="center" width="6%">
			<?PHP
			//echo "<pre>"; print_r($row);
			if($districtmanagers[$f]->user_type == '12' && $districtmanagers[$f]->dmanager == 'yes') { echo 'District Manager'; }
			else if($districtmanagers[$f]->user_type == '12') { echo 'Manager'; }
			else if($districtmanagers[$f]->user_type == '13') {echo 'Camfirm Administartor'; }
			else { }
			?>
			</td>
			
				<?php 
				if($districtmanagers[$f]->suspend == 'suspend' && $districtmanagers[$f]->flag == 'flag') {$font = "red"; }
				else if($districtmanagers[$f]->flag == 'flag') { $font = "#ff9900"; }
				else if($districtmanagers[$f]->suspend == 'suspend') { $font = "red"; }
				else { $font = ''; }
				?> 
						
            <td width="15%">
			 
				<a title="Click a customer name to edit it" href="index.php?option=com_camassistant&amp;controller=customer_detail&amp;task=edit&amp;cid[]=<?php echo $districtmanagers[$f]->id; ?>" target="_blank"><font color="<?php echo $font; ?>"> <?php echo $districtmanagers[$f]->comp_name; ?></font></a>
                                        </td>
                            <td width="9%"><?php echo $districtmanagers[$f]->camfirm_license_no; ?></td>
                            <td width="9%"><a href="javascript:loginas('<?php echo $districtmanagers[$f]->username ?>','<?php echo $districtmanagers[$f]->password; ?>');"><?php echo $districtmanagers[$f]->lastname . ', ' . $districtmanagers[$f]->name; ?></a></td>
                            <td width="12%"><?php echo $districtmanagers[$f]->email; ?></td>
			
            <td width="8%"><?php echo $districtmanagers[$f]->lastvisitDate; ?></td>
			<td width="7%"><?php echo $districtmanagers[$f]->registerDate; ?></td>
			<td width="8%"><?php echo $districtmanagers[$f]->phone; ?></td>
						<td align="center" width="5%"><?PHP if($districtmanagers[$f]->status != 'approved') echo '__'; else if($districtmanagers[$f]->status == 'approved') { ?>
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
   <?PHP } ?>
			</td>
			
			<td align="center" width="5%" >
			<?PHP if($districtmanagers[$f]->status == 'inactive') echo 'Inactive'; else if($districtmanagers[$f]->status == 'rejected') echo 'Rejected'; else if($districtmanagers[$f]->status == 'active') { ?><a href="<?PHP echo $approve_link; ?>">Approve</a> | <a href="<?PHP echo $reject_link; ?>">Reject</a> <?PHP } else if($districtmanagers[$f]->status == 'approved' ) { echo 'Approved'; }  else echo 'Inactive';?>
			</td>
			
			<td align="center" width="15%">
			<?php $fullname = $districtmanagers[$f]->name.' '.$districtmanagers[$f]->lastname; ?>
			<a href="javascript:submit_resend('<?php echo $fullname; ?>', '<?php echo $districtmanagers[$f]->email ?>','<?php echo $districtmanagers[$f]->cust_id ?>');" >Resend Activation</a>
			</td>
			

<!--<td align="center" >
			<a href="javascript:loginas('<?php echo $districtmanagers[$f]->username ?>','<?php echo $districtmanagers[$f]->password; ?>');">Login As</a>
			</td>-->
			
		</tr>
		<?php
		
		if($districtmanagers[$f]->user_type == '12') { ?>
		<tr id="masterdis<?php echo $districtmanagers[$f]->id; ?>"></tr>
		<?php } ?>
		
		<?php }
		exit;
	}
	
	//Completed
	function exportmanagers(){
		//echo "style";	 exit;
		$db			=& JFactory::getDBO();
		$output = "";
		$table = "jos_users"; // Enter Your Table Name 
		$sql_query = 'SELECT CONCAT(u.name," " ,u.lastname) "Name", v.comp_name, u.email  from jos_users as u, jos_cam_customer_companyinfo as v where u.id=v.cust_id and u.user_type!=11';
	
		$sql = mysql_query($sql_query);
		$columns_total = mysql_num_fields($sql);
		// Get The Field Name
		for ($i = 0; $i < $columns_total; $i++) {
		$heading = mysql_field_name($sql, $i);
		if($heading == 'comp_name')
			$heading = 'Company Name';
		else if($heading == 'email')	
			$heading = 'Email';
			
		$output .= '"'.$heading.'",';
		}
		$output .="\n";
		// Get Records from the table
		while ($row = mysql_fetch_array($sql)) {
		for ($i = 0; $i < $columns_total; $i++) {
		$output .='"'.$row["$i"].'",';
		}
		$output .="\n";
		}
		// Download the file
		$filename = 'Manager_users.csv'; //For unique file name
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
	
		echo $output;
		exit;
	}
	
	
}	
?>
