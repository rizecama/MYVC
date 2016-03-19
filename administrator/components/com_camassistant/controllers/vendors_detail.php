<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//echo '<pre>'; print_r($_REQUEST); exit;
// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );
 
class vendors_detailController extends JController
{

	function __construct( $default = array())
	{
		//echo '<pre>'; print_r($_REQUEST);
		parent::__construct( $default );
		$this->registerTask( 'apply',		'save' );
		
	}
	function cancel()
	{
		// Checkin the detail
		$this->setRedirect( 'index.php?option=com_camassistant&controller=vendors' );
	}

	function display() {
		parent::display();
	}
	
	function industries_form()
	{
	   JRequest::getVar('view','vendors_detail');
	   parent::display();
	}
	
	function industries_Save()
	{
		//session_destroy();
		session_start();
		$ind_ary 				= JRequest::getVar('cid','','post','array',REQUEST_ALLOWRAW);
		$_SESSION['industries'] = $ind_ary;
		$ind = implode(',',$ind_ary); 
		
		echo "<script language='javascript' type='text/javascript'>
		var val = '".$ind."';
		window.parent.document.getElementById('industries').value = val;
		window.parent.document.getElementById( 'sbox-window' ).close();
		//window.parent.parent.location.reload();
		 </script>"; 
		//$link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_info';	
		//$this->setRedirect( $link,$msg );
	}
	
	// created on 06-05-2011 for creating new vendor
	
	
	
	
	function createVendor($data,$company,$userInfo=null,$counties)
{
echo "<pre>"; print_r($data);
echo "<pre>"; print_r($company);

unset($userInfo);
	$db = JFactory::getDBO();
	
	//$data["registerDate"] = "now()";
	//$data["activation"] = "";
	$data["block"] = 0;
	$data['name']		= $data['name'] != "" ? "'".$data['name']."'" : '""';
	$data['username']	= $data['username']!= "" ? "'".$data['username']."'" : '""';
		
		//$data['password2']	= $post['password2'];
		if($data['password']!= "")
		{
		
		$salt = $this->genRandomPassword(32);
		$encrypted =  md5($data['password']);
		$data['password'] = "'".$encrypted."'";
		
		}
		//$data['password2'] 	= $post['password2']!= "" ? $post['password2'] :'""';
		$data['salutation'] = $data['salutation']!= "" ? "'".$data['salutation']."'" :'""';
		$data['lastname'] 	= $data['lastname']!= "" ? "'".$data['lastname']."'" : '""';
		$data['email'] 		= $data['email']!= "" ? "'".$data['email']."'" : '""';
		$data['ccemail'] 		= $data['ccemail']!= "" ? "'".$data['ccemail']."'" : '""';
		$data['phone'] 		= $data['phone']!= "" ? "'".$data['phone']."'" : '""';
		$data['extension'] 	= $data['extension']!= "" ? "'".$data['extension']."'" : '" "';
		$data['cellphone'] 	= $data['cellphone']!= "" ? "'".$data['cellphone']."'" : '""';
		$data['question'] 	= $data['question']!= "" ? "'".$data['question']."'" : '""';
		$data['answer'] 	= $data['answer']!= "" ? "'".$data['answer']."'" : '""';
		$data['hear'] 	= $data['hear']!= "" ? "'".$data['hear']."'" : '""';
		$data['user_notes'] 	= $data['user_notes']!= "" ? "'".$data['user_notes']."'" : '""';
		$data['camrating'] 	= $data['camrating']!= "" ? "'".$data['camrating']."'" : '""';
		$data['flag'] 	= $data['flag']!= "" ? "'".$data['flag']."'" : '""';
		$data['suspend'] 	= $data['suspend']!= "" ? "'".$data['suspend']."'" : '""';
		$data['search'] 	= $data['search']!= "" ? "'".$data['search']."'" : '""';
		$data['promo_code'] 	= $data['promo_code']!= "" ? "'".$data['promo_code']."'" : '""';
		$data['usertype']	= "'Registered'";
		$data['user_type'] 	= "11";
		$data['gid']		= "18";
		
		
		//vendro company details
		$company["user_id"] = '';
		$company["company_name"] = $company['company_name'] != "" ? "".$company['company_name']."" : '""';
		$company["company_address"] = $company['company_address'] != "" ? "".$company['company_address']."" : '""';
		$company["company_addresss"] = $company['company_addresss'] != "" ? "".$company['company_addresss']."" : '""';
		$company["tax_id"] = $company['tax_id'] != "" ? "".$company['tax_id']."" : '""'; 
		$company["fax_id"]	= '';	
		$company["city"] = $company['city'] != "" ? "".$company['city']."" : '""';
		$company["state"] = $company['state'] != "" ? "".$company['state']."" : '""';
		$company["zipcode"] = $company['zipcode'] != "" ? "".$company['zipcode']."" : '""';
		$company["in_house_vendor"] = $company['in_house_vendor'];
		$company["in_house_parent_company"] = $company['in_house_parent_company'];
		$company["in_house_parent_company_FEIN"] = $company['in_house_parent_company_FEIN'] ;
		$company["miles"]	= '';
		$company["company_phone"] = $company['company_phone'] != "" ? "".$company['company_phone']."" : '""';
		$company["phone_ext"] = $company['phone_ext'] != "" ? "".$company['phone_ext']."" : '" "';
		$company["alt_phone"] = $company['alt_phone'] != "" ? "".$company['alt_phone']."" : '" "';
		$company["alt_phone_ext"] = $company['alt_phone_ext'] != "" ? "".$company['alt_phone_ext']."" : '" "';
		$company["established_year"] = $company['established_year'] != "" ? "".$company['established_year']."" : '""';
		$company["not_interest_RFP"] = $company['not_interest_RFP'];
		$company["interest_RFP_alerts"] = $company['interest_RFP_alerts'] ;
		$company["authorized_business"] = $company['authorized_business'] ;
		$company["preferred_vendors"] = $company['preferred_vendors'];
		$company["company_web_url"] = $company['company_web_url'] != "" ? "".$company['company_web_url']."" : '""';
		$company["status"] = 'approved';
		
		
	$keys = implode(',', array_keys($data));
	$values = implode(',', array_values($data));
	//	echo '<pre>'; print_r($keys); echo '<br>';
		//echo '<pre>'; print_r($values); exit;
	  $query = "INSERT INTO #__users (".$keys.") VALUES(".$values.")"; 
	 $db->setQuery($query);

	  if($db->query())
	  {
	  $company["user_id"] = $db->insertid();
	  $query = "INSERT INTO #__core_acl_aro (section_value,value,name) VALUES('users',".$company["user_id"].",".$data["name"].")"; 
	  $db->setQuery($query);
	  	
			
	
	  }
	  else
	  {
	    return false;
	  }
	  
	  if($db->query())
	  {
	  $new_aro_id = $db->insertid();
	  $query = "INSERT INTO #__core_acl_groups_aro_map (group_id,aro_id) VALUES(".$data["gid"].",".$new_aro_id .")"; 
	  $db->setQuery($query);
	  }
	  else
	  {
	   return false;
	  }
	  
	 if($db->query())
	{
	 
	 //$company["user_id"] = $db->insertid();
	 $company["created"] = date("Y-m-d");
	 
/*	 $db->setQuery("SELECT activation FROM #__users where id=".$company["user_id"]);
	 $results = $db->loadAssoc();
	  $company["activation"] = '"'. $results['activation'].'"';*/
	 $ckeys = implode(',', array_keys($company));
	
	 $cvalues = implode(',', array_values($company));
	
	 	
		$model = $this->getModel('vendors_detail');
		$val = $model->store($company);

			if($data['subscribe']){
			$date = date('Y-m-d');  
			$nextdate = date('Y-m-d', strtotime('+1 year'));
			$data['subscribe'] = "yes";
			$query_ins = "insert into #__cam_vendor_subscriptions (`id`, `vendorid`, `coupon`, `paid`, `ctype`, `subscribeid`, `date`, `nextdate`) VALUES ('','".$company["user_id"]."','','admin','".$data['subscribe']."','A-AAAAAAAAAAAA','".$date."','".$nextdate."')";
			$db->setQuery($query_ins);
			$successin_new = $db->query();

			}
			
// $query = "INSERT INTO #__cam_vendor_company(company_name,company_web_url,tax_id,company_address,company_addresss,state,city,zipcode,established_year,company_phone,phone_ext,published,alt_phone_ext,alt_phone,in_house_vendor,in_house_parent_company,in_house_parent_company_FEIN,image,pledge,preferred_vendors,authorized_business,interest_RFP_alerts,not_interest_RFP,status,user_id,created) values('".$company['company_name']."','".$company['company_web_url']."','".$company['tax_id']."','".$company['company_address']."','".$company['company_addresss']."',".$company['state'].",'".$company['city']."','".$company['zipcode']."','".$company['established_year']."','".$company['company_phone']."','".$company['phone_ext']."',".$company['published'].",'".$company['alt_phone_ext']."','".$company['alt_phone']."',".$company['in_house_vendor'].",".$company['in_house_parent_company'].",".$company['in_house_parent_company_FEIN'].",'".$company['image']."',".$company['pledge'].",".$company['preferred_vendors'].",".$company['authorized_business'].",".$company['interest_RFP_alerts'].",".$company['not_interest_RFP'].",".$company['status'].",".$company['user_id'].",'".$company['created']."')";
	
	

	 //$db->setQuery($query);

	 if($val)
	{
	
	 if(isset($_POST["industries"]) && $_POST["industries"]!="")
	  {
	 	if(isset($_SESSION['industries']) && $_SESSION['industries']!="")
		 {
	 	$ind_arr = $_SESSION['industries']; //getting vendor's industries from session variable
		unset($_SESSION['industries']);		//unsetting session variablehmm
		 }
		 else
		 {
		  $ind_arr = explode(",",$_POST["industries"]);
		 }
		//session_destroy();
		$vendor['id'] = $db->insertid();
		$ind_data['user_id'] = $company["user_id"];
		$sql = "DELETE FROM #__cam_vendor_industries where vendor_id ='".$vendor['id']."'";
	
		$db->Setquery($sql);
		$db->query();
		foreach($ind_arr as $arr)
		{
			$db = JFactory::getDBO();
			//code to delete industries 
			$sql = "SELECT id FROM #__cam_industries where industry_name='".$arr."'";
			$db->Setquery($sql);
			$ind_id = $db->loadResult(); 
			$ind_data['vendor_id'] = $vendor['id']; 
			$ind_data['industry_id'] = $ind_id; 
			$model = $this->getModel('vendors_detail');
			$model->store_industries($ind_data);
			
		}
		/// Added by sateesh on 21-07-11
	  for($j=0;$j<count($counties['county']);$j++) 
			{
				$stateandcounty = explode("_",$counties['county'][$j]);
				$state_id = $stateandcounty[0];
				$county_id = $stateandcounty[1];
				$query_counties = "insert into #__vendor_state_counties (`id` ,`user_id` , `state_id` ,`county_id`) VALUES ('','".$company['user_id']."','".$state_id."','".$county_id."')";
				$db->setQuery($query_counties);
				$db->query();
			}
		//Completed on 21-07-11	
	  }
	  return true;
	 }
	 else
	 return false;
 	}
	 else
	 return false;
}
	
function updateVendor($data, $id, $company, $counties)
{

	$db = JFactory::getDBO();
	// echo "<pre>"; echo '123'; print_r($company); exit;
	$company['company_address'] = htmlentities($company['company_address']); 
	$company['company_addresss'] = htmlentities($company['company_addresss']); 
	$company['company_name'] = htmlentities($company['company_name']); 
	//Get the old email id
	$sql_oldemail = "SELECT email FROM #__users where id='".$id."'";
	$db->Setquery($sql_oldemail);
	$oldmailid = $db->loadResult();
	
	//Completed		
	//$key = implode(",", array_keys($data));
	//$value = implode(",", array_values($data));
	//$keys = explode(",", $key);
	//$values = explode(",", $value);	
		
		//for($i=0;$i<count($data);$i++)
		//{
		//$qstring[$i] = $keys[$i]."=".$values[$i]."";
		//}
		
	//$uquery = 	implode(",",$qstring);
	//echo '<pre>'; print_r($data); 
		$password = $data['password'];
		//$password2 = $data['password2'];
		$data['id']= $id;
		
		$salt		= JUserHelper::genRandomPassword(32);
		$crypt		= JUserHelper::getCryptedPassword($password, $salt);
		$data['password']	= $crypt.':'.$salt;
		//$crypt1		= JUserHelper::getCryptedPassword($password2, $salt);
		//$data['password2'] =$crypt1.':'.$salt;
		//echo '<pre>'; print_r($data);
		$mailfrom = 'support@camassiantant.com';
		$fromname = 'Support team';
		$to = 'rize.cama@gmail.com';
		$mailsubject = 'Vendor info is updated';
		$body = 'Hi admin uopdated some vendor information'.$id;
		JUtility::sendMail($mailfrom, $fromname, $to,  $mailsubject, $body, $mode = 1);
		
		$subtype = $data['subscribe'] ;
	if($subtype  != 'P'){	
		if($subtype == '0'){
		$sub_sort = '' ;
		$subtype = '' ;
		$sub = '';
		}
		else {
		$sub = 'yes';
		}

		if($subtype == '1')
		$sub_sort = 'all' ;
		if($subtype == '2')
		$sub_sort = 'sponsor' ;
		if($subtype == '3')
		$sub_sort = 'public' ;
		if($subtype == '4')
		$sub_sort = 'free' ;
		$querys= "UPDATE #__users SET subscribe_type='".$sub_sort."',subscribe_sort='".$subtype."',subscribe='".$sub."' WHERE id=".$id;
		$db->setQuery($querys);
		$successss =$db->query(); 
	}	
	else{
		
	}
		
		if($password!= "")
		{
	 $query= "UPDATE #__users SET password='".$data['password']."',user_type='".$data['user_type']."',cellphone='".$data['cellphone']."',extension='".$data['extension']."',phone='".$data['phone']."',email='".$data['email']."',ccemail='".$data['ccemail']."',lastname='".$data['lastname']."',salutation='".$data['salutation']."',username='".$data['username']."',name='".$data['name']."',question='".$data['question']."',answer='".$data['answer']."',hear='".$data['hear']."',user_notes='".$data['user_notes']."',camrating='".$data['camrating']."',suspend='".$data['suspend']."',flag='".$data['flag']."',search='".$data['search']."',promo_code='".$data['promo_code']."' WHERE id=".$id;	
	} else {
	//exit;
     $query= "UPDATE #__users SET user_type='".$data['user_type']."',cellphone='".$data['cellphone']."',extension='".$data['extension']."',phone='".$data['phone']."',email='".$data['email']."',ccemail='".$data['ccemail']."',lastname='".$data['lastname']."',salutation='".$data['salutation']."',username='".$data['username']."',name='".$data['name']."',question='".$data['question']."',answer='".$data['answer']."',hear='".$data['hear']."',user_notes='".$data['user_notes']."',camrating='".$data['camrating']."',suspend='".$data['suspend']."',flag='".$data['flag']."',search='".$data['search']."',promo_code='".$data['promo_code']."' WHERE id=".$id;
	} 
		//exit;
	//$query = "UPDATE #__users SET ".$uquery." WHERE id=".$id; 
	 $db->setQuery($query);
	$success =$db->query(); 
	
	if($subtype  != 'P'){
	$date = date('Y-m-d'); 
	$nextdate = date('Y-m-d', strtotime('+1 year'));
	if(!$subtype){
	//$query_sub = "DELETE FROM #__cam_vendor_subscriptions where vendorid =".$id."";  
	//$db->setQuery($query_sub);
	//$success_sub =$db->query();  
	}
	else{
		$select_all = "SELECT id FROM #__cam_vendor_subscriptions WHERE vendorid='".$id."'";
		$db->Setquery($select_all);
		$extid = $db->loadResult();
			if($extid){
			$query_sub = "UPDATE #__cam_vendor_subscriptions SET ctype='".$sub_sort."', paid='admin' WHERE vendorid=".$id;	
			$db->setQuery($query_sub);
			$success_sub =$db->query(); 
			}
			else{
			$query_in = "insert into #__cam_vendor_subscriptions (`id`, `vendorid`, `coupon`, `paid`, `ctype`, `subscribeid`, `date`, `nextdate`) VALUES ('','".$id."','','admin','".$sub_sort."','A-AAAAAAAAAAAA','".$date."','".$nextdate."')";
			$db->setQuery($query_in);
			$successin =$db->query();
			}
		}
	}
	
 if($success)
 {
	//echo '<pre>'; print_r($company); exit;
	//unset($qstring);
/*	$company['company_address'] = ereg_replace(',',' ',$company['company_address']);
	$company['company_name'] = ereg_replace(',',' ',$company['company_name']);
	$ckey = implode(',', array_keys($company));
	$cvalue = implode(',', array_values($company));
	$ckeys = explode(",", $ckey);
	$cvalues = explode(",", $cvalue);	
	for($i=0;$i<count($company);$i++)
	{
	$qstring[$i] = $ckeys[$i]."=".$cvalues[$i]."";
	}
	$uquery = 	implode(",",$qstring);
	$query = "UPDATE #__cam_vendor_company SET ".$uquery." WHERE user_id=".$id;
	$db->setQuery($query);	*/
	$model = $this->getModel('vendors_detail');
	$company['user_id'] = $id;
	$model->update_companyinfo($company);
	
	if($model->update_companyinfo($company))
	 {
	 	//code to update billing centre table
		$query_update = 'UPDATE #__cam_vendor_billing_centre SET payment_preference ='.$company['pledge'].' WHERE user_id ='.$id;
		$db->setQuery($query_update);
	 	$db->query();
		
		$industries = JRequest::getVar('industries','');
		//echo $industries;
	 	 $ind_arr = $_SESSION['industries']; //getting vendor's industries from session variable
		unset($_SESSION['industries']);		//unsetting session variables
		$vendor['id'] = $_POST['vendor_id'];
		$ind_data['user_id'] = $id;
		if(count($ind_arr) >0){
		$sql = "DELETE FROM #__cam_vendor_industries where user_id =".$ind_data['user_id']."";
		$db->Setquery($sql);
		$db->query();
		
		foreach($ind_arr as $arr)
		{
			$db = JFactory::getDBO();
			//code to delete industries 
			$sql = "SELECT id FROM #__cam_industries where industry_name='".$arr."'";
			$db->Setquery($sql);
			$ind_id = $db->loadResult(); 
			$ind_data['vendor_id'] = $vendor['id']; 
			$ind_data['industry_id'] = $ind_id; 
			$model = $this->getModel('vendors_detail');
			//echo "<pre>"; print_r($ind_data); exit;
			$model->store_industries($ind_data);
		}
		}
//		echo "<pre>"; print_r($counties); exit;
		//Edit new state and counties by sateesh on 22-07-11

		if($counties['county'][0] != ''){

			//$sql_deletecounties = "DELETE FROM #__vendor_state_counties where user_id =".$ind_data['user_id']."";    
			//$db->Setquery($sql_deletecounties);
			//$db->query();
	  		for($j=0;$j<count($counties['county']);$j++) 
			{
			$stateandcounty = explode("_",$counties['county'][$j]);
			$state_id = $stateandcounty[0];
			$county_id = $stateandcounty[1];
			$query_counties = "insert into #__vendor_state_counties (`id` ,`user_id` , `state_id` ,`county_id`) VALUES ('','".$ind_data['user_id']."','".$state_id."','".$county_id."')";
			$db->setQuery($query_counties);
			$db->query();
			}
		}
		//Edit new state and counties by sateesh on 22-07-11 completed
		//Send activation link to new email
		$newmail = JRequest::getVar('email','');
		if($oldmailid != $newmail)	{ 
		//Update table to unblock the userid
		srand ((double) microtime( )*1000000);
		$activatecode = rand();
		//Update invitation table
		$query_invite = "UPDATE #__vendor_inviteinfo SET inhousevendors='$newmail' WHERE inhousevendors='".$oldmailid."'";
		$db->setQuery($query_invite);
	 	$db->query();
		
		
		//Completed

		//$query_update = 'UPDATE #__users'. ' SET block = 0, activation="'.$activatecode.'" WHERE id ='.$id.'';
		//$db->setQuery($query_update);
	 	//$db->query();
		
		
		//Completed
		$mailfrom = 'support@myvendorcenter.com';
		$fromname = 'MyVendorCenter.com';
		$to = $newmail;
		$to_old = $oldmailid;
		$mailsubject = 'Email Verification';
		$siteURL		= JURI::root();
		$link = "<a href=".$siteURL."index.php?option=com_camassistant&controller=vendorsignup&Itemid=158&task=reactivate&useractivation=".$activatecode."&id=".$id."&view=vendorsignup'>CLICK HERE</a>";
		$sql_message = "SELECT introtext  FROM #__content where id=123";
		$db->Setquery($sql_message);
		$admin_message = $db->loadResult(); 
		$body = str_replace('{CLICK HERE}',$link,$admin_message);
		//JUtility::sendMail($mailfrom, $fromname, $to,  $mailsubject, $body, $mode = 1);
		//JUtility::sendMail($mailfrom, $fromname, $to_old, $mailsubject, $body,$mode = 1);
		$this->setRedirect( 'index.php?option=com_camassistant&controller=vendors&task=displayext','Vendor updated successfully and sent activated link');
		}	
		//Completed	

		 }
	else
	return false;
 }
	else
	return false;
	
}

	function genRandomPassword($length = 8)
	{
		$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$len = strlen($salt);
		$makepass = '';

		$stat = @stat(__FILE__);
		if(empty($stat) || !is_array($stat)) $stat = array(php_uname());

		mt_srand(crc32(microtime() . implode('|', $stat)));

		for ($i = 0; $i < $length; $i ++) {
			$makepass .= $salt[mt_rand(0, $len -1)];
		}

		return $makepass;
	}
	
	function save() {
	
		jimport('joomla.user.helper');
		$post	= JRequest::get('post');
		$files		= JRequest::getVar( 'image', '', 'files', 'array' );
		//juser fields
		$user=clone(JFactory::getUser(0));
		//$data['name']		= $post['name'] != "" ? "'".$post['name']."'" : '""';
		//$data['username']	= $post['username']!= "" ? "'".$post['username']."'" : '""';
		$data['name']		= $post['name'];
		$data['username']	= $post['username'];
		$data['password']	= $post['password'];
		//$data['password2']	= $post['password2'];
		/*if($post['password']!= "")
		{
		
		$salt = $this->genRandomPassword(32);
		$encrypted =  md5($post['password']);
		$data['password'] = "'".$encrypted."'";
		
		}*/
		//$data['password2'] 	= $post['password2']!= "" ? $post['password2'] :'""';
		/*$data['salutation'] = $post['salutation']!= "" ? "'".$post['salutation']."'" :'""';
		$data['lastname'] 	= $post['lastname']!= "" ? "'".$post['lastname']."'" : '""';
		$data['email'] 		= $post['email']!= "" ? "'".$post['email']."'" : '""';
		$data['phone'] 		= $post['phone']!= "" ? "'".$post['phone']."'" : '""';
		$data['extension'] 	= $post['extension']!= "" ? "'".$post['extension']."'" : '" "';
		$data['cellphone'] 	= $post['cellphone']!= "" ? "'".$post['cellphone']."'" : '""';
		$data['question'] 	= $post['question']!= "" ? "'".$post['question']."'" : '""';
		$data['answer'] 	= $post['answer']!= "" ? "'".$post['answer']."'" : '""';
		$data['promo_code'] 	= $post['promo_code']!= "" ? "'".$post['promo_code']."'" : '""';
		$data['usertype']	= "'Registered'";
		$data['user_type'] 	= "11";
		$data['gid']		= "18";*/
		$data['salutation'] = $post['salutation'];
		$data['lastname'] 	= $post['lastname'];
		$data['email'] 		= $post['email'];
		$data['email'] = str_replace(' ','',$data['email']);
		$data['username']	= $data['email'];
		$data['ccemail'] 		= $post['ccemail'];		
		$data['phone'] 		= $post['phone'];
		$data['extension'] 	= $post['extension'];
		$data['cellphone'] 	= $post['cellphone'];
		$data['question'] 	= $post['question'];
		$data['answer'] 	= $post['answer'];
		$data['hear'] 	= $post['hear'];
		$data['user_notes'] 	= $post['user_notes'];
		$data['camrating'] 	= $post['camrating'];
		$data['flag'] 	= $post['flag'];
		$data['suspend'] 	= $post['suspend'];
		$data['search'] 	= $post['search'];
		$data['promo_code'] 	= $post['promo_code'];
		$data['usertype']	= "Registered";
		$data['user_type'] 	= "11";
		$data['gid']		= "18";
		$data['subscribe'] 	= $post['subscription'];
		//vendro company details
		/*$company["user_id"] = '';
		$company["company_name"] = $post['company_name'] != "" ? "".$post['company_name']."" : '""';
		$company["company_address"] = $post['company_address'] != "" ? "".$post['company_address']."" : '""';
		$company["company_addresss"] = $post['company_addresss'] != "" ? "".$post['company_addresss']."" : '""';
		$company["tax_id"] = $post['tax_id'] != "" ? "".$post['tax_id']."" : '""'; 
		$company["fax_id"]	= '';	
		$company["city"] = $post['city'] != "" ? "".$post['city']."" : '""';
		$company["state"] = $post['states'] != "" ? "".$post['states']."" : '""';
		$company["zipcode"] = $post['zipcode'] != "" ? "".$post['zipcode']."" : '""';
		$company["in_house_vendor"] = $post['in_house_vendor'];
		$company["in_house_parent_company"] = $post['in_house_parent_company'];
		$company["in_house_parent_company_FEIN"] = $post['in_house_parent_company_FEIN'] ;
		$company["miles"]	= '';
		$company["company_phone"] = $post['company_phone'] != "" ? "".$post['company_phone']."" : '""';
		$company["phone_ext"] = $post['phone_ext'] != "" ? "".$post['phone_ext']."" : '" "';
		$company["alt_phone"] = $post['alt_phone'] != "" ? "".$post['alt_phone']."" : '" "';
		$company["alt_phone_ext"] = $post['alt_phone_ext'] != "" ? "".$post['alt_phone_ext']."" : '" "';
		$company["established_year"] = $post['established_year'] != "" ? "".$post['established_year']."" : '""';
		$company["not_interest_RFP"] = $post['not_interest_RFP'];
		$company["interest_RFP_alerts"] = $post['interest_RFP_alerts'] ;
		$company["authorized_business"] = $post['authorized_business'] ;
		$company["preferred_vendors"] = $post['preferred_vendors'];
		$company["company_web_url"] = $post['company_web_url'] != "" ? "".$post['company_web_url']."" : '""';*/
		$fax_acc	= $post['fax_acc'];
		if( $fax_acc )
		$fax_acc = 'yes';
		else
		$fax_acc = 'no';
		
		$company["user_id"] = '';
		$company["company_name"] = $post['company_name'];
		$company["company_address"] = $post['company_address'];
		$company["company_addresss"] = $post['company_addresss'];
		$company["tax_id"] = $post['tax_id']; 
		$company["fax_id"]	= '';	
		$company["city"] = $post['city'];
		$company["state"] = $post['states'];
		$company["zipcode"] = $post['zipcode'];
		$company["in_house_vendor"] = $post['in_house_vendor'];
		$company["in_house_parent_company"] = $post['in_house_parent_company'];
		$company["in_house_parent_company_FEIN"] = $post['in_house_parent_company_FEIN'] ;
		$company["miles"]	= '';
		$company["company_phone"] = $post['company_phone'];
		$company["faxid"] = $post['faxid'];
		$company["fax_acc"] = $fax_acc;
		$company["phone_ext"] = $post['phone_ext'];
		$company["alt_phone"] = $post['alt_phone'];
		$company["alt_phone_ext"] = $post['alt_phone_ext'];
		$company["established_year"] = $post['established_year'];
		$company["not_interest_RFP"] = $post['not_interest_RFP'];
		$company["interest_RFP_alerts"] = $post['interest_RFP_alerts'] ;
		$company["authorized_business"] = $post['authorized_business'] ;
		$company["preferred_vendors"] = $post['preferred_vendors'];
		$company["company_web_url"] = $post['company_web_url'];



		/*$company["industries"] = $post['industries'] != "" ? "'".$post['industries']."'" : '""';*/
		//$company["company_web_url"] = $post['company_web_url'] != "" ? "".$post['company_web_url']."" : '""';

		

		//Modified by sateesh on 21-07-11 by sateesh
		$counties["county"] = $post['county'] ;
		$counties["cstates"] = $counties['stateid'] ;
		//Modified by sateesh on 21-07-11 completed	
		
		
		
		
		
		
		
		
		
		
		//code to rename compliances folder
		$vendoruser = JFactory::getUser($post['user_id']);
		$db = JFactory::getDBO();
		$sql = "SELECT tax_id FROM #__cam_vendor_company   WHERE user_id=".$post['user_id']; 
		$db->setQuery($sql);
		$old_tax_id = $db->loadResult();
		$old_folder = $vendoruser->name.'_'.$vendoruser->lastname.'_'.$old_tax_id; 
		$old_folder = str_replace(' ','_',$old_folder); 
		$source = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$old_folder; 
		$company["tax_id"] = $post['tax_id'] != "" ? "".$post['tax_id']."" : '""'; 
		$new_folder = $post['name'].'_'.$post['lastname'].'_'.$company["tax_id"]; 
		$new_folder = str_replace(' ','_',$new_folder); 
		$target = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$new_folder;
		rename($source,$target); 
		//end of code to rename compliacnes folder
		
		/*if($files && $files['name'] != '')
		{
			jimport('joomla.filesystem.file');		
			//code to move image to folderpath
			$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendors'.DS;
			
			$filename = $files['name'];
			$filepath = $base_Dir . $filename;  
			$post['image'] = $filename;
			if(file_exists($base_Dir . $prev_image))
			@unlink($base_Dir . $prev_image);
			move_uploaded_file($files['tmp_name'], $filepath); 
			$company["image"] =  "".$post['image']."";
			
			//For image cropping by sateesh
			 $apath=getimagesize($filepath);
			 $height_orig=$apath[1];
			 $width_orig=$apath[0];
			 $width = 132;
			 $aspect_ratio = (float) $height_orig / $width_orig;
			 $height = round($width * $aspect_ratio); 
			 $resized = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendors'.DS.'resized'.DS;
			 $pdf_resized = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendors'.DS.'pdf_resized';
			 $model = $this->getModel('vendors_detail');
			 $pdf_thumb = $model->image_resize_to_max($filepath,$width,$height,$resized,$filename);
			 $pdf_thumb = $model->image_resize_to_max($filepath,$width,$height,$pdf_resized,$filename);
			 //Completed

		}*/
		jimport('joomla.filesystem.file');	
		$files		= JRequest::getVar( 'image', '', 'files', 'array' );
		//echo "<pre>"; print_r($files);
		$id	= $post['user_id']!= "" ? $post['user_id'] : "";
		$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendors'.DS;
			//print_r($base_Dir); echo '<br>';
		if($files['name'])
			{
					$files1= str_replace(' ','_',$files['name']); 		
					$files1= str_replace('&','_',$files1); 		
					$files1= str_replace('#','_',$files1); 		
					$files1= str_replace('%','_',$files1); 	
					$files2=$id.'_'.$files1;	
					$company['image']	= $files2;
					jimport('joomla.filesystem.file');
			 		$filename =$company['image']; 
					//$base_Dir = JPATH_COMPONENT.DS.'assets'.DS.'images'.DS.'vendors'.DS;
					$filepath = $base_Dir . $filename;  
					$company["image"] = $filename;
					if(file_exists($base_Dir . $filename)){ //echo 'in unlink';
					@unlink($base_Dir . $filename); }
					move_uploaded_file($_FILES['image']['tmp_name'], $filepath); 
			}
			else
			{ 
				 $company['image'] =  $_REQUEST['img_name'];
			}
			//print_r($company['image']); exit;
		//code to resize image 
			$model = $this->getModel('vendors_detail');
			if($filename!=''){
			$img = $filepath;
			//print_r($img); exit;
			$pdf_resized = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendors'.DS.'pdf_resized';
			$resized = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendors'.DS.'resized';
			$img1 =$resized;
			$img2 =$pdf_resized;
			$dimensions = $model->get_thumbnail_dimensions();
			if($dimensions[0]->vendor_logo_width == 0)
			$dimensions[0]->vendor_logo_width = 90;
			if($dimensions[0]->vendor_logo_height == 0)
			$dimensions[0]->vendor_logo_height = 90;
			if($img)
			{
			$apath=getimagesize($img);
			$height_orig=$apath[1];
			$width_orig=$apath[0];
			$aspect_ratio = (float) $height_orig / $width_orig;
			$width =$dimensions[0]->vendor_logo_width;
			$height = round($width * $aspect_ratio);
			$thumb = $model->image_resize_to_max($img,$width,$height,$img1,$filename);
			$pdf_thumb = $model->image_resize_to_max($img,$width_orig,$height_orig,$img2,$filename);
			}
			/********************************************* pdf image resize code*******************************/
			$ftmp = $filename;
            $oname = $filename;
            $fname = $pdf_resized.'/'.$filename;
            $sizes = getimagesize($fname);
            $width	=	$sizes[0];
            $height	=	$sizes[1];
            $extenssion = strstr($oname, ".");
            $prod_img		= $fname;	
            $prod_img_thumb =  $pdf_resized.'/'.$oname;
            move_uploaded_file($ftmp, $prod_img);
            $original_filesize = (filesize($prod_img)/1024);
            $sizes = getimagesize($prod_img);
            $expected_max_width		=	128;
            $expected_max_height	=	50;
            $originalw	=	$sizes[0];
            $originalh	=	$sizes[1];
               if ($originalh<$expected_max_height) {

                if ($originalw<$expected_max_width) {
                    $imgwidth	=	$originalw;
                    $imgheight	=	$originalh;
                } else {
                    $imgheight	=	($expected_max_width * $originalh)/ $originalw;
                    $imgwidth	=	$expected_max_width;
                }
            } else {
                 $new_height		=	$expected_max_height;
                 $new_width		=	($expected_max_height * $originalw)/ $originalh;
                if ($new_width>$expected_max_width) {
                    $new_height	=	($expected_max_width * $expected_max_height) / $new_width;
                    $new_width	=	$expected_max_width;
                }
                $imgwidth	=	$new_width;
                $imgheight	=	$new_height;
            }
            $new_h	=	$imgheight;
            $new_w	=	$imgwidth;
			$new_w_im='128'; 
			$new_h_im='50';
			$offsetwidth=$new_w_im-$new_w;
			$offsetw=$offsetwidth/2;
			$offsetheight=$new_h_im-$new_h;
			$offseth=$offsetheight/2;
           $dest = imagecreatetruecolor ($new_w_im,$new_h_im);
           $bg = imagecolorallocate ( $dest, 255, 255, 255 );
           imagefill ( $dest, 0, 0, $bg );
		   $extenssion= str_replace('.jpg.jpg','.jpg',$extenssion);
		 $extenssion= str_replace('.jpeg.jpeg','.jpeg',$extenssion);
		 $extenssion= str_replace('.gif.gif','.gif',$extenssion);
		 $extenssion= str_replace('.png.png','.png',$extenssion);
			if($extenssion=='.jpg' ||  $extenssion=='.JPG'){	
            	$src = imagecreatefromjpeg($prod_img)
                or die('Problem In opening Source JPG Image');
			}elseif($extenssion=='.jpeg' || $extenssion=='.JPEG'){
				 $src = imagecreatefromjpeg($prod_img)
                 or die('Problem In opening Source JPEG Image');
			}elseif($extenssion=='.gif' || $extenssion=='.GIF'){
				 $src = imagecreatefromgif($prod_img)
                 or die('Problem In opening Source GIF Image');
			}elseif($extenssion=='.png' || $extenssion=='.PNG'){
			   $src = imagecreatefrompng($prod_img)
                or die('Problem In opening Source PNG Image');
			}
            if(function_exists('imagecopyresampled'))
            {
                imagecopyresampled($dest,$src,$offsetw,$offseth,0,0,$new_w,$new_h,imagesx($src),imagesy($src))
                or die('Problem In resizing');
            }else{

                Imagecopyresized($dest,$src,$offsetw,$offseth,0,0,$new_w,$new_h,imagesx($src),imagesy($src))
                or die('Problem In resizing');
            }
            imagejpeg($dest,$prod_img_thumb,72)  or die('Problem In saving');
            imagedestroy($dest);
            @ob_flush();
            $new_filesize = (filesize($prod_img)/1024);
			}
 
		$company["pledge"] = $post['pledge'];
		/*$company["pledge"] = $post['pledge'] != "" ? "'".$post['pledge']."'" : '""';
		$company["preferred_vendors"] = $post['preferred_vendors'] != "" ? "'".$post['preferred_vendors']."'" : '""';
		$company["authorized_business"] = $post['authorized_business'] != "" ? "'".$post['authorized_business']."'" : '""';
		$company["interest_RFP_alerts"] = $post['interest_RFP_alerts'] != "" ? "'".$post['interest_RFP_alerts']."'" : '""';
		$company["not_interest_RFP"] = $post['not_interest_RFP'] != "" ? "'".$post['not_interest_RFP']."'" : '""';*/
		
			
	
		$id	= $post['user_id']!= "" ? $post['user_id'] : "";
		//echo "first"; echo "<pre>"; print_r($company); exit;
		if($id=="")
		{
			$data['block']= '0';
			$company["status"] = $post['status'];
			$company["created"] = '';
			$company["published"] = $post['published'] != "" ? $post['published'] : 0;
			$company["activation"] = '';
			$company["company_represents"] = '';
		}
		if($id=="")
		{
			
			if($post['subscription'] == '1') {
			$data['subscribe'] = "'yes'";
			$data['subscribe_sort'] = $post['subscription'];
			$data['subscribe_type'] = "'all'";
			}
			else if($post['subscription'] == '3') {
			$data['subscribe'] = "'yes'";
			$data['subscribe_sort'] = $post['subscription'];
			$data['subscribe_type'] = "'public'";
			}
			else if($post['subscription'] == '4'){
			$data['subscribe'] = "'yes'";
			$data['subscribe_sort'] = $post['subscription'];
			$data['subscribe_type'] = "'free'";
			$data['subscribe_admin'] = "'free'";
			}
			else{
			$data['subscribe'] = "'no'";
			}
		if(!$this->createVendor($data,$company,$userInfo,$counties))
		{
		$this->setRedirect("index.php?option=com_camassistant&controller=vendors&task=displayext","Creating vendor failed");
		}
		else
		{
		$link ='index.php?option=com_camassistant&controller=vendors&task=displayext';
		$msg="Created vendor Successfully";
		$this->setRedirect( $link,$msg );
		}
		}
		
		else
		{
		$data['block']= $post['published'] != "" ? $post['published'] : 0;
		$allstate = explode("_",$counties['county'][0]);
		if($allstate[1] == 'All'){
		$db = JFactory::getDBO();
		$select_all = "SELECT * FROM #__cam_counties WHERE State='".$allstate[0]."' ORDER BY County";
		$db->Setquery($select_all);
		$allcounties = $db->loadObjectList();
		$all = array();
		for($i=0; $i<=count($allcounties); $i++){
		$all[county][]= $allcounties[$i]->State."_".$allcounties[$i]->id;
		}
		$counties=$all;
		}
		else{
		$counties=$counties;
		}
//		echo "<pre>"; print_r($_REQUEST['stateid'][0]);   exit;
		if(!$this->updateVendor($data, $id, $company, $counties))
		{
		$db = JFactory::getDBO();
		$sql_cid = "SELECT id  FROM #__cam_vendor_company  where user_id=".$id."";
		$db->Setquery($sql_cid);
		$cid = $db->loadResult(); 
		if($_REQUEST['task']=='apply'){
		$this->setRedirect("index.php?option=com_camassistant&controller=vendors_detail&task=edit&cid[]=".$cid."","Update vendor successfull");
		} else{
		$this->setRedirect("index.php?option=com_camassistant&controller=vendors&task=displayext","Update vendor successfull");
		}
		}
		else
		{
		$this->setRedirect("index.php?option=com_camassistant&controller=vendors&task=displayext","Update vendor successfull");
		}
		}
		/*if(!$user->bind($data)) { 
		echo $user->getError();
		}else {
		if (!$user->save()){ 
		echo $user->getError();
		}
		} */
		//echo "<pre>";
	    //print_r($post);
		//exit;
		
		//code to update jos_cam_vendor_company table
		/*$db = JFactory::getDBO();
		if($post['user_id']=="")
		{
		
		$db->setQuery("SELECT max(id) AS id FROM #__users");
		$uid = $db->loadAssoc();
		$post['user_id']=$uid['id'];
		}
		
		$vendor['id']							= $post['vendor_id'];
		$vendor['user_id']						= $post['user_id'];
		$vendor['company_name'] 				= $post['company_name'];
		$vendor['company_address']				= $post['company_address'];
		$vendor['tax_id'] 						= $post['tax_id'];
		$vendor['city'] 						= $post['city'];
		$vendor['state'] 						= $post['state'];
		$vendor['zipcode'] 						= $post['zipcode'];
		$vendor['in_house_vendor'] 				= $post['in_house_vendor'];
		if($post['in_house_vendor'] == 'Yes')
		{
		$vendor['in_house_parent_company'] 		= $post['in_house_parent_company'];
		$vendor['in_house_parent_company_FEIN'] = $post['in_house_parent_company_FEIN'];
		}
		else
		{
		$vendor['in_house_parent_company'] 		= '';
		$vendor['in_house_parent_company_FEIN'] = '';
		}
		
		$vendor['miles']						= $post['miles'];
		$vendor['company_phone'] 				= $post['company_phone'];
		$vendor['phone_ext'] 					= $post['phone_ext'];
		$vendor['alt_phone'] 					= $post['alt_phone'];
		$vendor['alt_phone_ext']				= $post['alt_phone'];
		$vendor['established_year'] 			= $post['established_year'];
		$vendor['not_interest_RFP']				= $post['not_interest_RFP'];
		$vendor['interest_RFP_alerts'] 			= $post['interest_RFP_alerts'];
		$vendor['authorized_business'] 			= $post['authorized_business'];
		$vendor['preferred_vendors'] 			= $post['preferred_vendors'];
		$vendor['company_web_url'] 				= $post['company_web_url'];
		$vendor['pledge'] 						= $post['pledge'];
		if($post['user_id'] == '')
		$vendor['status'] 						= 'aprooved';
		$vendor['created'] 						= date('Y-m-d');
		$vendor['published']					= $post['published'];
		$userid 								= $post['user_id'];
		//echo "<pre>"; print_r($vendor); exit;
		if($files['name'] == '')
		{
		//$db = JFactory::getDBO();
		$sql = "SELECT image FROM  #__cam_vendor_company  where id='".$vendor['id']."'"; 
		$db->Setquery($sql);
		$prev_image = $db->loadResult();
		$vendor['image'] 						= $prev_image;
		}
		else
		$vendor['image'] 						= $files['name'];
		
		//code to update published field in users table
		$query = 'UPDATE #__users SET block = '.$post['published'].' WHERE id IN ( '.$post['user_id'].'  )'; 
		$db->setQuery( $query );
		$db->query();
		//echo "<pre>"; print_r($vendor); exit;
		$model = $this->getModel('vendors_detail');
		if($model->store($vendor)) {
		$msg = JText::_( 'Vendor Saved' );
		} else {
		$msg = JText::_( 'Error Saving Vendor' );
		}
		
		//echo "<pre>"; print_r($files); exit;
		//code to update existing user record
		jimport('joomla.filesystem.file');
		//code to move image to vendors folder
		if($files && $files['name'] != '')
		{
			//code to move image to folderpath
			$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendors'.DS;
			$filename =$files['name'];
			$filepath = $base_Dir . $filename;  
			$post['image'] = $filename;
			if(file_exists($base_Dir . $prev_image))
						@unlink($base_Dir . $prev_image);
			move_uploaded_file($files['tmp_name'], $filepath); 
		}
		
		$ind_arr = $_SESSION['industries']; //getting vendor's industries from session variable
		unset($_SESSION['industries']);		//unsetting session variablehmm
		//session_destroy();
		$sql = "DELETE FROM #__cam_vendor_industries where vendor_id ='".$vendor['id']."'";
		$db->Setquery($sql);
		$db->query();
		foreach($ind_arr as $arr)
		{
			$db = JFactory::getDBO();
			//code to delete industries 
			$sql = "SELECT id FROM #__cam_industries where industry_name='".$arr."'";
			$db->Setquery($sql);
			$ind_id = $db->loadResult(); 
			$ind_data['vendor_id'] = $vendor['id']; 
			$ind_data['industry_id'] = $ind_id; 
			$model = $this->getModel('vendors_detail');
			$model->store_industries($ind_data);
		}*/
		
		
	}
	//Function to vetrify email id
	function verfiryemailid()
	{
		$db =& JFactory::getDBO();
		$Email=$_POST['queryString'];
		$userid=$_POST['userid'];
		$userid = str_replace(' ','',$userid);
		if ($Email != "")
		{
		$query_email="SELECT id FROM #__users WHERE email='".$Email."' "; 
		$db->setQuery( $query_email );
		$id = $db->loadResult();
		//print_r($result_email);
		if(!$id){
		$data="valid";
		}
		elseif ($id != $userid){ 
		$data="invalid";
		 }
		}
		echo $data;
		exit;
   }
   
   //Verify taxid
	function verfirytaxid()
	{
		$db =& JFactory::getDBO();
		$Taxid=$_POST['queryString'];
		$userid=$_POST['userid'];
		if ($Taxid != "")
		{
		$query_Taxid="SELECT tax_id FROM #__cam_vendor_company  WHERE tax_id='".$Taxid."' and user_id != '".$userid."'";
		$db->setQuery( $query_Taxid );
		$result_tax = $db->loadResult();
		$license_id="SELECT camfirm_license_no FROM #__cam_camfirminfo WHERE camfirm_license_no='".$Taxid."'";
		$db->setQuery($license_id);
		$license_id = $db->loadResult();
//Checking for exclude or  not
		$query_exclude="SELECT licenseno FROM #__vendor_inviteinfo  WHERE taxid='".$Taxid."' AND vendortype = 'exclude'";
		$db->setQuery($query_exclude);
		$result_exclude = $db->loadResult();
//Checking for exclude or  not		
		//print_r($result_email);
		if($result_exclude && ($result_tax || $license_id)){
		 $data="excluded"; 
		 }
		 else if($result_tax || $license_id){
		 $data="invalid"; 
		 }
		 else{
		 $data = 'valid';
		 }
		 }
		echo $data;
		exit;
   }
    function deletecounties(){
   $db =& JFactory::getDBO();
   $user=$_REQUEST['user'];
   $county=$_REQUEST['county'];
   $sql = "DELETE FROM #__vendor_state_counties where user_id =".$user." and county_id=".$county;
   $db->Setquery($sql);
   if($db->query()){
   echo "County deleted";
   }
   else{
   echo "County not deleted";
   }
   exit;
   }
   function deletestates(){
   $db =& JFactory::getDBO();
   $user=$_REQUEST['user'];
   $state=$_REQUEST['state'];
   
  $sql = "DELETE FROM #__vendor_state_counties where user_id =".$user." and state_id='".$state."'";
   $db->Setquery($sql);
   if($db->query()){
   echo "State and related counties deleted.";
   }
   else{
   echo "State not deleted";
   }
   exit;
   }
	function deleterating(){
	$db = JFactory::getDBO();
		$query_update = 'UPDATE #__cam_rfpinfo SET apple_publish ="1" WHERE id ='.$_REQUEST['rfpid'];
		$db->setQuery($query_update);
	 	if($db->query()) {
		echo "success"; 
		}
		else{
		echo "fail";
		}
		 exit;
	}
	function undeleterating(){
	$db = JFactory::getDBO();
		$query_update = 'UPDATE #__cam_rfpinfo SET apple_publish ="0" WHERE id ='.$_REQUEST['rfpid'];
		$db->setQuery($query_update);
	 	if($db->query()) {
		echo "success"; 
		}
		else{
		echo "fail";
		}
		 exit;
	}
	
	
	//Function to vetrify email id
	function verfiryphonenumber()
	{
		$db =& JFactory::getDBO();
		$phone = JRequest::getVar('queryString','');
		$userid = JRequest::getVar('userid','');
		$userid = str_replace(' ','',$userid);
		if ($phone != "")
		{
		$query_phone = "SELECT user_id FROM #__cam_vendor_company WHERE user_id!='".$userid."' and company_phone = '".$phone."' "; 
		$db->setQuery( $query_phone );
		$id = $db->loadResult();
		//print_r($result_email);
		if(!$id){
		$data="valid";
		}
		elseif ($id != $userid){ 
		$data="invalid";
		 }
		}
		echo $data;
		exit;
   }
   
	//Completed
	
}	
?>
