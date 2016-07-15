<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );

class customer_detailController extends JController
{

	function __construct( $default = array())
	{
		parent::__construct( $default );
		$this->registerTask( 'apply',		'save' );
	}

	// function edit
	function edit()
	{
		JRequest::setVar( 'view', 'customer_detail' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1);

		parent::display();

		$model = $this->getModel('customer_detail');
		$model->checkout();
	}

	// function save
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
	function save()
	{
    	//echo "<pre>"; print_r($_REQUEST); exit;
		$task = JRequest::getVar("task",'');
		//$regtype = JRequest::getVar('hidden_field','');
		$usertype = JRequest::getVar('hidden_field1','');
		if($usertype){
		$regtype = JRequest::getVar('hidden_field1','');
		} else {
		$regtype = JRequest::getVar('hidden_field','');
		}
		$comp_name = JRequest::getVar('comp_name','');
		$licno1 = JRequest::getVar('taxid1','');
		$licno2 = JRequest::getVar('taxid2','');
		$licno3 = JRequest::getVar('taxid3','');
		$licno = $licno1.'-'.$licno2;
		if($licno3){
		$licno = $licno . '-'. $licno3 ;
		}
		else {
		$licno = $licno ;
		}

		$tax_id = JRequest::getVar('tax_id1','');

//$db = &JFactory::getDBO();
//	if($licno!=''&& $licno!='--')
//   $query = "select * FROM #__cam_customer_companyinfo where camfirm_license_no='$licno'";
//	elseif($tax_id!='')
//	$query = "select * FROM #__cam_customer_companyinfo where tax_id='$tax_id'";
//	$db->setQuery($query);
//	$licid= $db->loadObjectList();

		$mailaddress = JRequest::getVar('mailaddress','');
		$city = JRequest::getVar('city','');
		$state = JRequest::getVar('state','');
		$zipcode = JRequest::getVar('zipcode','');
		$cphone1 = JRequest::getVar('cphone1','');
		$cphone2 = JRequest::getVar('cphone2','');
		$cphone3 = JRequest::getVar('cphone3','');
		$cphone = $cphone1.'-'.$cphone2.'-'.$cphone3;
		$cext = JRequest::getVar('cext','');
		$caphone1 = JRequest::getVar('caphone1','');
		$caphone2 = JRequest::getVar('caphone2','');
		$caphone3 = JRequest::getVar('caphone3','');
		$caphone = $caphone1.'-'.$caphone2.'-'.$caphone3;
		$caext = JRequest::getVar('caext','');
		$website = JRequest::getVar('website','');
		//$image = JRequest::getVar('image','');
		$email = JRequest::getVar('email','');
		$email = str_replace(' ','',$email); 
		$username = JRequest::getVar('username','');
		$username = str_replace(' ','',$username);
		$password = JRequest::getVar('password','');
		$password2 = JRequest::getVar('password2','');
	//	print_r($password);print_r($password2);
		$salutation = JRequest::getVar('salutation','');
		$fname = JRequest::getVar('fname','');
		$question = JRequest::getVar('question','');
		$answer = JRequest::getVar('answer','');
		$hear = JRequest::getVar('hear','');
		$user_notes = JRequest::getVar('user_notes','');
		$flag = JRequest::getVar('flag','');
		$suspend = JRequest::getVar('suspend','');
		$search = JRequest::getVar('search','');
		$lname = JRequest::getVar('lname','');
		$phone1 = JRequest::getVar('phone1','');
		$phone2 = JRequest::getVar('phone2','');
		$phone3 = JRequest::getVar('phone3','');
		$phone = $phone1.'-'.$phone2.'-'.$phone3;
		$manager_invitecode = JRequest::getVar('manager_invitecode','');
			
			if( $manager_invitecode )
			$manager_invitecode = $manager_invitecode; 
			else {
			$len = 1;
			$min = 10000; // minimum
			$max = 99999; // maximum
			foreach (range(0, $len - 1) as $i) {
			
			while(in_array($num = mt_rand($min, $max), $range));
			$range[] = $num;
			}
			$lastname = $lname;
			$manager_invitecode = $lastname.$range[0];
			}
			
		$accounttype = JRequest::getVar('accounttype','');
		
		$ext = JRequest::getVar('ext','');
		$mphone1 = JRequest::getVar('mphone1','');
		$mphone2 = JRequest::getVar('mphone2','');
		$mphone3 = JRequest::getVar('mphone3','');

		$mphone = $mphone1.'-'.$mphone2.'-'.$mphone3;
		$id = JRequest::getVar('id',0);
		 //$cid = JRequest::getVar('id',0);
		$db = &JFactory::getDBO();
		$query2 = "select id FROM #__cam_customer_companyinfo where cust_id='$id'";
		$db->setQuery($query2);
		$cid = $db->loadResult();
		$query3 = "select id FROM #__cam_camfirminfo where cust_id='$id'";
		$db->setQuery($query3);
		$cid1 = $db->loadResult();
          if(!$id){
        $data['lastvisitDate']= '0000-00-00 00:00:00';
        }
		//$model = $this->getModel('customer_detail');
		//$model = $this->getModel('customer_detail');
		//$result= $model->verifytaxid($licno,$tax_id);

		jimport('joomla.user.helper');
		//$post	= JRequest::getVar("task",'');
		$post	= JRequest::get('post');

		$user=clone(JFactory::getUser());
		$data['name']	=	$fname;
		$data['email']	=	$email;
		$data['username']	=	$username;
		$data['salutation'] = $salutation;
		$data['lastname'] = $lname ;
		$data['accounttype'] = $accounttype ;
		$data['manager_invitecode'] = $manager_invitecode ;
		$data['phone'] = $phone;
		$data['extension'] = $ext;
		$data['cellphone'] = $mphone;
		$data['question'] = $question;
		$data['answer'] = $answer;
		$data['hear'] = $hear;
		$data['user_notes'] = $user_notes;
		$data['flag'] = $flag;
		$data['suspend'] = $suspend;
		$data['search'] = $search;
		$data['usertype'] = 'Registered';
		$data['gid']='18';
		//$data['block']='0'; 
        $date =& JFactory::getDate();
		$data['registerDate']	= $date->toMySQL();
        $data['id']= $id;




		if($regtype == 'C' || $regtype == ''){
		$data['user_type'] = 13;
		} else if ($regtype=='13'){
		$data['user_type'] = 13;
		} else {
		$data['user_type'] = 12;
		}
		//echo "<pre>"; print_r($data); exit;
		//$data['gid']='18';
		//$data['block']='0';
		//$data['id']= $id;
//echo '<pre>'; print_r($data); exit;
		/*$salt		= JUserHelper::genRandomPassword(32);
		$crypt		= JUserHelper::getCryptedPassword($password, $salt);
		$data['password']	= $crypt.':'.$salt;
		$crypt1		= JUserHelper::getCryptedPassword($password2, $salt);
		$data['password2'] =$crypt1.':'.$salt;

		if($password!= "")
		{
	 $query= "UPDATE #__users SET password='".$data['password']."',user_type='".$data['user_type']."',cellphone='$mphone',extension='$ext',phone='$phone',email='$email',lastname='$lname',salutation='$salutation',username='$username',name='$fname',question='$question',answer='$answer' WHERE id=".$id;
	} else {
	//exit;
 $query= "UPDATE #__users SET user_type='".$data['user_type']."',cellphone='$mphone',extension='$ext',phone='$phone',email='$email',lastname='$lname',salutation='$salutation',username='$username',name='$fname',question='$question',answer='$answer' WHERE id=".$id;
	} //exit;
	$db->Setquery($query);
	$success =$db->query();
	if($success){
	echo "success";
		}
		if($id==''){
	if(!$user->bind($data)) {
		echo $user->getError();
		parent::display($tpl);
		}else {
		if (!$user->save()){
		echo $user->getError();
		parent::display($tpl);
		}
		}
	}*/




if($id==''){
		$salt		= JUserHelper::genRandomPassword(32);
		$crypt		= JUserHelper::getCryptedPassword($password, $salt);
		$data['password']	= $password;
		$crypt1		= JUserHelper::getCryptedPassword($password2, $salt);
		$data['password2'] = $password;
		//echo "<pre>"; print_r($data);
		if(!$user->bind($data)) {
		echo $user->getError();
		//exit;
		parent::display($tpl);
		}
		else{
		if (!$user->save()){
		echo $user->getError();
		parent::display($tpl);

		}
		}

	} 
	

	else {
		if($password!= "")
		{
           echo $password;
		$salt		= JUserHelper::genRandomPassword(32);
		$crypt		= JUserHelper::getCryptedPassword($password, $salt);
		$updatesateesh	= $crypt.':'.$salt;

	
	  $query= 'UPDATE #__users SET password="'.$updatesateesh.'",user_type="'.$data['user_type'].'",cellphone="'.$mphone.'",extension="'.$ext.'",phone="'.$phone.'",email="'.$email.'",lastname="'.$lname.'",salutation="'.$salutation.'",username="'.$username.'",name="'.$fname.'",question="'.$question.'",answer="'.$answer.'",hear="'.$hear.'",user_notes="'.$user_notes.'",flag="'.$flag.'",suspend="'.$suspend.'",search="'.$search.'",manager_invitecode="'.$manager_invitecode.'" WHERE id='.$id;
	} else {
	//exit;
 $query= 'UPDATE #__users SET user_type="'.$data['user_type'].'",cellphone="'.$mphone.'",extension="'.$ext.'",phone="'.$phone.'",email="'.$email.'",lastname="'.$lname.'",salutation="'.$salutation.'",username="'.$username.'",name="'.$fname.'",question="'.$question.'",answer="'.$answer.'",hear="'.$hear.'",user_notes="'.$user_notes.'",flag="'.$flag.'",suspend="'.$suspend.'",search="'.$search.'" ,manager_invitecode="'.$manager_invitecode.'" WHERE id='.$id;
	} //exit;
	$db->Setquery($query);
	$success =$db->query();
	if($success){
	echo "success";
		}
	// Suspend all managers
	$model = $this->getModel('customer_detail');
	$result_suspend = $model->updatesuspend($id,$suspend,$flag);
	//Completed			
}

		if($id){
		$cust_id= $id;
		} else {
		$cust_id= $user->id;
		}
		//$cust_id= $user->id;

		if ((empty($regtype))||($regtype=='C')||($regtype=='13')){
		//echo "<pre>"; print_r($regtype);  exit;
		$camfirm['id'] = $id;
		$camfirm['cust_id']= $cust_id;
		$camfirm['camfirm_license_no']= $licno;
		$camfirm['comp_name']= $comp_name;
		$camfirm['tax_id']= $tax_id ;
		$model = $this->getModel('customer_detail');
		//print_r($camfirm);
		/*if($model->store_camfirm($camfirm)) {


		echo "success"; //exit;
		//exit;
		//$link='index.php?option=com_camassistant&controller=customer';
		//$this->setRedirect( $link, JText::_( 'Cam Firm Admin Saved' ) );
		//parent::display($tpl);
		}*/

		$hidden_image = JRequest::getVar('hidden_image','');
		jimport('joomla.filesystem.file');
		$files		= JRequest::getVar( 'image', '', 'files', 'array' );
		//echo "<pre>"; print_r($files); exit;
	    $base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'properymanager'.DS;

		if($files && $files['name'] != '')
		{
			$db =& JFactory::getDBO();
			$files1= str_replace(' ','_',$files['name']);
					$files1= str_replace('&','_',$files1);
					$files1= str_replace('#','_',$files1);
					$files1= str_replace('%','_',$files1);
			$filename =$id.'_'.$files1;
			$sql = "UPDATE #__cam_customer_companyinfo SET comp_logopath='".$filename."' where cust_id='".$id."'";
			$db->Setquery($sql);
			$db->query();
			//$filename =$user->id.'_'.$files['name'];

			$filename=str_replace(' ','_',$filename);
						$filepath = $base_Dir . $filename;
						$post['image'] = $filename;
						if(file_exists($base_Dir . $filename))
						@unlink($base_Dir . $filename);
						move_uploaded_file($files['tmp_name'], $filepath);

    //code to move image to folderpath
			$model = $this->getModel('customer_detail');
			$pdf_resized =   $base_Dir.'pdf_resized';

			$resized =   $base_Dir.'resized';
			$img = $filepath;
			$dimensions = $model->get_thumbnail_dimensions();
			$img1=$resized;
			$img2 =$pdf_resized;
						if($dimensions[0]->vendor_logo_width == 0)
						$dimensions[0]->vendor_logo_width = 90;
						if($dimensions[0]->vendor_logo_height == 0)
						$dimensions[0]->vendor_logo_height = 90;
						//$thumb = $model->image_resize_to_max($img,$dimensions[0]->vendor_logo_width,$dimensions[0]->vendor_logo_height,$img1,$filename);
						$apath=getimagesize($img);
					 	$height_orig=$apath[1];
						$width_orig=$apath[0];
						$aspect_ratio = (float) $height_orig / $width_orig;
						$width =$dimensions[0]->vendor_logo_width;
					    $height = round($width * $aspect_ratio);

						$thumb = $model->image_resize_to_max($img,$width,$height,$img1,$filename);
						$pdf_thumb = $model->image_resize_to_max($img,$width_orig,$height_orig,$img2,$filename);

            $ftmp = $filename;
            $oname = $filename;
            $fname = $pdf_resized.'/'.$filename;

            $sizes = getimagesize($fname);
			//print_r( $files); exit;
            $width	=	$sizes[0];
            $height	=	$sizes[1];

            $extenssion = strstr($oname, ".");

            $prod_img		= $fname;
            $prod_img_thumb =  $pdf_resized.'/'.$oname;
             move_uploaded_file($ftmp, $prod_img);
             $original_filesize = (filesize($prod_img)/1024);
             $sizes = getimagesize($prod_img);

            $expected_max_width		=	136;
            $expected_max_height	=	68;
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

			if($extenssion=='.jpg' || $extenssion=='.JPG'){
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
			/*elseif($extenssion=='.PNG'){
			   $src = imagecreatefrompng($prod_img)
                or die('Problem In opening Source PNG Image');
			}
			elseif($extenssion=='.JPG'){
			   $src = imagecreatefrompng($prod_img)
                or die('Problem In opening Source PNG Image');
			}
			elseif($extenssion=='.JPEG'){
			   $src = imagecreatefrompng($prod_img)
                or die('Problem In opening Source PNG Image');
			}
			elseif($extenssion=='.GIF'){
			   $src = imagecreatefrompng($prod_img)
                or die('Problem In opening Source PNG Image');
			}*/
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
			$camfirm['id'] = $cid1;
			$camfirm['cust_id']= $cust_id;
			$camfirm['camfirm_license_no']= $licno;
			$camfirm['comp_name']= $comp_name;
			$camfirm['tax_id']= $tax_id ;
			$data1=$camfirm;
			$model = $this->getModel('customer_detail');
			//print_r($model); exit;

			if($model->store_camfirm($data1)) {

			echo 'success';
			//parent::display($tpl);
			}
	  $customer_detail['id'] = $cid;
	  $customer_detail['cust_id'] =$cust_id;

	   $customer_detail['comp_id'] ='0';

 		//code to update jos_cam_customer_companyinfo table
	 //  $customer_detail['id'] = $cid;
	  // $customer_detail['cust_id'] = $cust_id;
	   //$customer_detail['comp_id'] = '0';
	   $customer_detail['camfirm_license_no'] = $licno;
	   $customer_detail['comp_name'] = $comp_name;
	   $customer_detail['tax_id'] = $tax_id;
	   $customer_detail['mailaddress'] = $mailaddress;
	   $customer_detail['comp_city'] = $city;
	   $customer_detail['comp_state'] = $state;
	   $customer_detail['comp_zip'] = $zipcode;
	   $customer_detail['comp_phno'] = $cphone;
	   $customer_detail['comp_extnno'] = $cext;
	   $customer_detail['comp_alt_phno'] = $caphone;
	   $customer_detail['comp_alt_extnno'] = $caext;
	   $customer_detail['comp_website'] = $website;
	   if($filename){
	   $customer_detail['comp_logopath'] = str_replace(' ','_',$filename);
	   } else {
	    $customer_detail['comp_logopath']= $hidden_image;
	   }

	   $customer_detail['is_providing_proposals'] = '0';
	   $customer_detail['is_manage_cproperties'] = '0';
	   $customer_detail['published'] = '1';
       //$customer_detail['status'] = 'approved'; 
	   $data=$customer_detail;

	   $model = $this->getModel('customer_detail');

       $query2 = "select id FROM #__cam_camfirminfo  where cust_id=".$cust_id;
		$db->setQuery($query2);
		$compid = $db->loadResult();
		if($compid){
		$sql1 = "UPDATE #__cam_customer_companyinfo SET camfirm_license_no='".$licno."', comp_name='".$comp_name."' where comp_id='".$compid."'";
		$db->Setquery($sql1);
		$db->query();
		}

		 $sql2 = "UPDATE #__cam_camfirminfo SET camfirm_license_no='".$licno."',comp_name='".$comp_name."' where cust_id='".$cust_id."'";
		$db->Setquery($sql2);
		$db->query();
	//	exit;
		//exit;
		   /// print_r($customer_detail); exit;

 		//if(($id)||($user->id))
		//{
		if($model->store($data)) {
		//echo "<pre>"; print_r($model->store($propertymanager); exit;
		$link='index.php?option=com_camassistant&controller=customer';
				if($accounttype=='master'){
                  //  echo 'anand'; exit;
                    $this->setRedirect( $link, JText::_( 'Master Account Saved' ) );
                } else {
                  // echo 'anand2123'; exit;
                   $this->setRedirect( $link, JText::_( 'Cam Firm Admin Saved' ) ); 
                }
		} else {
		$link='index.php?option=com_camassistant&controller=customer';
		 		if($accounttype=='master'){
                    $this->setRedirect( $link, JText::_( 'Error Saving Master Account' ) );
                } else {
                  $this->setRedirect( $link, JText::_( 'Error Saving Master Account' ) );
                }
		}
		//}
		} else {

	$db = &JFactory::getDBO();
	if($licno!=''&& $licno!='--')
   	$query1 = "select id FROM #__cam_camfirminfo where camfirm_license_no='$licno'";
	elseif($tax_id!='')
	$query1 = "select id FROM #__cam_camfirminfo where tax_id='$tax_id'";
	$db->setQuery($query1);
	$compid = $db->loadResult();
	//print_r($regtype);
	  $customer_detail['id'] = $cid;
	  $customer_detail['cust_id'] =$cust_id;
	   if($regtype=='13'){
	   $customer_detail['comp_id'] ='0';
	   } else {
	  $customer_detail['comp_id'] = $compid;
	   }
	  // echo "<pre>"; print_r($customer_detail); exit;
	   $customer_detail['camfirm_license_no'] = $licno;
	   $customer_detail['comp_name'] = $comp_name;
	   $customer_detail['tax_id'] = $tax_id;
	   $customer_detail['mailaddress'] = $mailaddress;
	   $customer_detail['comp_city'] = $city;
	   $customer_detail['comp_state'] = $state;
	   $customer_detail['comp_zip'] = $zipcode;
	   $customer_detail['comp_phno'] = $cphone;
	   $customer_detail['comp_extnno'] = $cext;
	   $customer_detail['comp_alt_phno'] = $caphone;
	   $customer_detail['comp_alt_extnno'] = $caext;
	   $customer_detail['comp_website'] = $website;
	   $customer_detail['comp_logopath'] = $filename;
	   $customer_detail['is_providing_proposals'] = '0';
	   $customer_detail['is_manage_cproperties'] = '0';
	   $customer_detail['published'] = '1';
      //$customer_detail['status'] = 'approved'; 
	   $data=$customer_detail;

	   $model = $this->getmodel('customer_detail');
	// echo "<pre>"; print_r($details); exit;
	   //echo $user->id;
	   //exit;

      /* if (!$model->store($details)) {

			$msg = JText::_( 'Error Saving customer' );
			} else {

			$msg = JText::_( 'customer Saved' );
			}*/
	//echo "<pre>"; print_r($model ); exit;
 		//if(($id)||($user->id))
		//{
		$query2 = "select id FROM #__cam_camfirminfo  where cust_id=".$cust_id;
		$db->setQuery($query2);
		$compid = $db->loadResult();
		if($compid){
		$sql1 = "UPDATE #__cam_customer_companyinfo SET camfirm_license_no='".$licno."' where comp_id='".$compid."'";
		$db->Setquery($sql1);
		$db->query();
		}
		$sql2 = "UPDATE #__cam_camfirminfo SET camfirm_license_no='".$licno."' where cust_id='".$cust_id."'";
		$db->Setquery($sql2);
		$db->query();
		 //echo 'i am iun the loop';

		if($model->store($data)) {
		//echo "<pre>"; print_r($model->store($details)); exit;
		$link='index.php?option=com_camassistant&controller=customer';
		$this->setRedirect( $link, JText::_( 'Property Manager Saved' ) );
		} else {
		$link='index.php?option=com_camassistant&controller=customer';
		$this->setRedirect( $link, JText::_( 'Error Saving Property Manager' ) );
		}
		//}
  $query1 = "select cust_id FROM #__cam_camfirminfo where id =".$customer_detail['comp_id'];
			$db->setQuery($query1);
			$cust_id_ad = $db->loadResult();





			$date =  date('Y-m-d H:i:s');
			$insert_sql = "insert into #__cam_invitemanagers values ('','".$cust_id_ad."','".$email."','".$cust_id."','0','".$date."','".$licno."','1','1')";
			$db->SetQuery($insert_sql);
			$db->query();
		}



		$model->checkin();
		$db		=& JFactory::getDBO();
		$query = "SELECT max(id) FROM #__cam_customer_companyinfo";
		$db->setQuery( $query );
		$catid = $db->loadResult();
		switch ($task)
		{
			case 'apply':
			if($post['id']) $cat_id = $post['id']; else  $cat_id = $catid;
				$link = 'index.php?option=com_camassistant&controller=customer_detail&task=edit&cid[]='.$id ;
				break;
			case 'save':
			default:
				$link = $link = 'index.php?option=com_camassistant&controller=customer';
				break;
		}
		$this->setRedirect( $link,$msg );
		//$this->setRedirect( $link, JText::_( 'Item Saved' ) );
	}
	//Function to vetrify email id
	function verfiryemailid()
	{
		$db =& JFactory::getDBO();
		$Email=$_POST['queryString'];
		if ($Email != "")
		{
		$query_email="SELECT email FROM #__users WHERE email='".$Email."'";
		$db->setQuery( $query_email );
		$result_email = $db->loadResult();
		//print_r($result_email);
		if ($result_email){ $data="invalid"; }}
		echo $data;
		exit;
   }
   function verfirytaxid()
	{
		$db =& JFactory::getDBO();
		$Taxid=$_POST['queryString'];
		if ($Taxid != "")
		{
		$query_Taxid="SELECT tax_id FROM #__cam_vendor_company  WHERE tax_id='".$Taxid."'";
		$db->setQuery( $query_Taxid );
		$result_tax = $db->loadResult();
		$license_id="SELECT camfirm_license_no FROM #__cam_camfirminfo WHERE camfirm_license_no='".$Taxid."'";
		$db->setQuery($license_id);
		$license_id = $db->loadResult();
//Checking for exclude or  not
		//$query_exclude="SELECT licenseno FROM #__vendor_inviteinfo  WHERE taxid='".$Taxid."' AND vendortype = 'exclude'";
		//$db->setQuery($query_exclude);
		//$result_exclude = $db->loadResult();
//Checking for exclude or  not
		//print_r($result_email);
		//if($result_exclude && ($result_tax || $license_id)){
		// $data="excluded";
		// }
		  if($result_tax || $license_id){
		 $data="invalid";
		 }
		 }
		echo $data;
		exit;
   }
	function verfiryuser()
	{
		$db =& JFactory::getDBO();
		$cid=$_POST[queryString];

		$query_email="SELECT * FROM #__cam_customer_companyinfo WHERE cust_id='$cid'";
		$db->setQuery( $query_email );
		$result_email = $db->loadObjectlist();
		//echo "<pre>"; print_r($result_email);
		$camfirm_license_no = explode('-',$result_email[0]->camfirm_license_no);
		$comp_alt_phno = explode('-',$result_email[0]->comp_alt_phno);
		$comp_phno = explode('-',$result_email[0]->comp_phno);
		$regtype = JRequest::getVar('hidden_field','');
		 //echo "anand"; ?>
		<script type="text/javascript">

		document.getElementById('comp_name').value='<?php echo $result_email[0]->comp_name; ?>';
		document.getElementById('taxid1').value='<?php echo $camfirm_license_no[0]; ?>';
		document.getElementById('taxid2').value='<?php echo $camfirm_license_no[1]; ?>';
		document.getElementById('taxid3').value='<?php echo $camfirm_license_no[2]; ?>';
		document.getElementById('mailaddress').value='<?php echo $result_email[0]->mailaddress; ?>';
		document.getElementById('city').value='<?php echo $result_email[0]->comp_city; ?>';
		document.getElementById('state').value='<?php echo $result_email[0]->comp_state; ?>';
		document.getElementById('zipcode').value='<?php echo $result_email[0]->comp_zip; ?>';
		document.getElementById('cphone1').value='<?php echo $comp_phno[0]; ?>';
		document.getElementById('cphone2').value='<?php echo $comp_phno[1]; ?>';
		document.getElementById('cphone3').value='<?php echo $comp_phno[2]; ?>';
		document.getElementById('cext').value='<?php echo $result_email[0]->comp_extnno; ?>';
		document.getElementById('caphone1').value='<?php echo $comp_alt_phno[0]; ?>';
		document.getElementById('caphone2').value='<?php echo $comp_alt_phno[1]; ?>';
		document.getElementById('caphone3').value='<?php echo $comp_alt_phno[2]; ?>';
		document.getElementById('caext').value='<?php echo $result_email[0]->comp_alt_extnno; ?>';
		document.getElementById('website').value='<?php echo $result_email[0]->comp_website; ?>';
		document.getElementById('image').value='<?php echo $result_email[0]->comp_logopath; ?>';
		</script>



		<?php

		//$db =& JFactory::getDBO();
		//$Email=$_POST[queryString];
		//print_r($Email);
		//if ( $Email != "")
		//{
		//$query_email="SELECT email FROM #__users WHERE email='$Email'";
		//$db->setQuery( $query_email );
		//$result_email = $db->loadResult();
		//print_r($result_email);
		//if ( $result_email){ $data="invalid"; }}
		//echo $data;
		exit;
		//return  $data;
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
		$user =& JFactory::getUser($cids);

		$db = & JFactory::getDBO();
		$sql_p = "SELECT id FROM #__cam_property where property_manager_id = ".$cids." and publish='1' ";
		$db->setQuery($sql_p);
		$propertiescount = $db->loadResult();

if($propertiescount) {
$msg = 'There are existing some properties under this manager. Please assign the properties to some other manager and try to delete the manager';
$link = 'index.php?option=com_camassistant&controller=customer';
}

else{
		if($user->user_type=='12'){
		//echo '12'; exit;
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('customer_detail');
		if($res <= 0)
		{
			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}

			$msg='Customer Deleted Successfully';
		}
		} else {
		$db = JFactory::getDBO();
		$query ="SELECT id FROM #__cam_camfirminfo WHERE cust_id IN (".$cids.")";
		$db->setQuery($query);
		$db->query();
		$res = $db->loadResult();
		//print_r($res); echo '</br>';
		$query1 ="SELECT count(id) FROM #__cam_customer_companyinfo WHERE comp_id =".$res;
		$db->setQuery($query1);
		$db->query();
		$res1 = $db->loadResult();
		//print_r($res1); echo '</br>'; exit;
		if(($res1)||($res1!='0')){
		//echo 'if'; exit;
		$msg='Some of the managers are associated with this camfirm. Please delete them before removing camfirm';
		//alert('');

		} else {
	//echo 'else'; exit;
		/***************end of code Case 3. Retailers assigned as primary categories************/
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel('customer_detail');
		//echo $res; exit;

			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}

			$msg='Customer Deleted Successfully';


		}
		}
		}
		/*else
        $msg = $catnames.' cannot  be removed as they contain Retailers as a primary reference.';
		if($msg == 'Industry Deleted Successfully')
		header("Location: index.php?option=com_camassistant&controller=category&msg=deleted");
		else*/
		$this->setRedirect( 'index.php?option=com_camassistant&controller=customer',$msg);
	}

	// function cancel
	function cancel()
	{
		// Checkin the detail
		$model = $this->getModel('customer_detail');
		$model->checkin();
		$this->setRedirect( 'index.php?option=com_camassistant&controller=customer' );
	}
	
	function vendor_proposal_edit_format_val()
	{
	   $fieldvalue= JRequest::getVar('fieldvalue','');
	   $fieldvalue = doubleval(str_replace(",","",$fieldvalue));
	   $fieldvalue = number_format($fieldvalue,2);
	   echo $fieldvalue;
	   exit;
	  } 
	//Function to save the payment details
	function savepaymentinfo(){
		$model = $this->getModel('customer_detail');
		$db = JFactory::getDBO();
		$payment['codeid'] = JRequest::getVar("codeid",'');
		$payment['masterid'] = JRequest::getVar("masterid",'');
		$payment['tf_money'] = JRequest::getVar("amount",'');
		$payment['tf_money'] = str_replace(',','',$payment['tf_money']);
		$payment['checkid'] = JRequest::getVar("checkid",'');
		$payment['tf_date'] = date('Y-m-d');
		//Function to save data
		$save_tfinfo = $model->savetfinfo($payment);
		echo "<script language='javascript' type='text/javascript'>
		window.parent.document.getElementById( 'sbox-window' ).close();
		window.parent.parent.location.reload();
		 </script>";
		
	}
	//Completed  
}

?>