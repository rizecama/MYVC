<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );

class vendorcompliances_detailsController extends JController
{

function __construct( $default = array())
	{
		parent::__construct( $default );
		$this->registerTask( 'apply',		'save' );
	}

    /*************************************************** Add/ Edit Vendor compliance related functions **************************************/
	function ajax_compliance_OLN_form()
	{
		JRequest::getVar('view','vendorcompliances_details');
	    parent::display();
	}

	function ajax_compliance_PLN_form()
	{
		JRequest::getVar('view','vendorcompliances_details');
	    parent::display();
	}

	function ajax_compliance_gli_form()
	{
		JRequest::getVar('view','vendorcompliances_details');
	    parent::display();
	}

	function ajax_compliance_wci_form()
	{
		JRequest::getVar('view','vendorcompliances_details');
	    parent::display();
	}
        function ajax_compliance_wc_form()
	{
		JRequest::getVar('view','vendorcompliances_details');
	    parent::display();
	}

	function get_subcat()
	{
		JRequest::getVar('view','vendorcompliances_details');
	    parent::display();
	}
        function imageupload23()
	{
		$db =& JFactory::getDBO();
		
		//$Email=$_POST['queryString'];
                $post	= JRequest::get('post');
		$model = $this->getModel('vendorcompliances_details');
                $type	= JRequest::getVar('type');
				
                $type_id	= JRequest::getVar('type_id');
                $id	= JRequest::getVar('id');
 		$userid	= JRequest::getVar('userid');
               $user	= JFactory::getUser($userid);
	//echo '<pre>'; print_r($_REQUEST); exit;
		$db = JFactory::getDBO();

		$sql = "SELECT tax_id FROM #__cam_vendor_company   WHERE user_id=".$user->id;

		$db->setQuery($sql);

		$tax_id = $db->loadResult();

		$vendorname = $user->name.'_'.$user->lastname.'_'.$tax_id;

		$vendorname = str_replace(' ','_',$vendorname);

              if($type=='OLN'){
                    $sql1 = "SELECT OLN_folder_id FROM #__cam_vendor_occupational_license  WHERE OLN_folder_id!=0 and id=".$type_id;

		$db->setQuery($sql1);

		$OLN_folder_id = $db->loadResult();

                $sql1 = "SELECT count(id) FROM #__cam_vendor_occupational_license  WHERE vendor_id=".$user->id;

		$db->setQuery($sql1);

		$count_id = $db->loadResult();

           	$OLN_files		= JRequest::getVar('uploadfile','','files','array' );
    //echo '<pre>'; print_r($_FILES); exit;
		//for($i=0; $i<count($post['old_line_task_OLN_ids']); $i++)
	//	{
				$OLN_data['id']				=$type_id;
                                $OLN_data['vendor_id']			= $user->id;
				if($OLN_files['name'] != '')

				{

				//code to update image filed in vendors table

				//code to move image to folderpath

				if($OLN_folder_id){
				$OLN_data['OLN_folder_id'] 		=	$OLN_folder_id;
                                $OLN_No 		=	$OLN_folder_id;
                                } else {
                                $OLN_data['OLN_folder_id'] 		=	$count_id+1;
                                $OLN_No 		=	$count_id+1;
                                }
 //echo '<pre>'; print_r($OLN_No);  exit;

		  		 $base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'OLN_'.$OLN_No.DS;
//exit;
				// Remove all the files in folder if they exist
				jimport('joomla.client.helper');
				if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}


			    JFolder::create( $base_Dir );
                
				$OLN_files['name'] = str_replace(" ", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("&", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("#", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("%", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace(",", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("`", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("'", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("\\", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace(":", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("?", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("<", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace(">", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("/", "_", $OLN_files['name']);
				$OLN_files['name'] = str_replace("//", "_", $OLN_files['name']);
				$OLN_files['name'] = ereg_replace("/", "_", $OLN_files['name']);
				$OLN_files['name'] = ereg_replace(".", "_", $OLN_files['name']);
				$OLN_files['name'] = preg_replace('/\.(?=.*?\.)/', '_', $OLN_files['name']);
				   

				$OLN_data['OLN_upld_cert'] 		=	$OLN_files['name'];
                                $folderid= 'OLN_'.$OLN_No ;
                                $filename=$OLN_files['name'];
                                 $ext = end(explode('.', $OLN_files['name']));
				 $filepath = $base_Dir .$OLN_files['name'];

				move_uploaded_file($OLN_files['tmp_name'], $filepath);

				$OLN_arr[$o] = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=OLN_'.$OLN_No.'&filename='.$OLN_files["name"] .'">'.$OLN_files["name"] .'</a>';

					$o++;

				}

                              $lastRowId=  $model->store_vendor_OLN_compliances_info($OLN_data);

		//}
  }
		//exit;


if($type=='UMB'){
            $sql1 = "SELECT UMB_folder_id FROM #__cam_vendor_umbrella_license  WHERE UMB_folder_id!=0 and id=".$type_id;
			$time = JRequest::getVar('time','');
			if($time == 'second'){
			$sql1 = "SELECT UMB_folder_id FROM #__cam_vendor_umbrella_license  WHERE UMB_folder_id!=0 and UMB_status ='' and vendor_id=".$user->id;
			}
			

		$db->setQuery($sql1);

		$UMB_folder_id = $db->loadResult();

        $sql1 = "SELECT count(id) FROM #__cam_vendor_umbrella_license  WHERE vendor_id=".$user->id;

		$db->setQuery($sql1);

		$count_id = $db->loadResult();

           	$UMB_files		= JRequest::getVar('uploadfile','','files','array' );
    //echo '<pre>'; print_r($_FILES); exit;
		//for($i=0; $i<count($post['old_line_task_OLN_ids']); $i++)
	//	{
				$UMB_data['id']				=$type_id;
                $UMB_data['vendor_id']			= $user->id;
				if($UMB_files['name'] != '')

				{

				//code to update image filed in vendors table

				//code to move image to folderpath

				if($UMB_folder_id){
				$UMB_data['UMB_folder_id'] 		=	$UMB_folder_id;
                                $UMB_No 		=	$UMB_folder_id;
                                } else {
                                $UMB_data['UMB_folder_id'] 		=	$count_id+1;
                                $UMB_No 		=	$count_id+1;
                                }
 //echo '<pre>'; print_r($OLN_No);  exit;

		  		//$base_Dir = JPATH_COMPONENT.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'UMB_'.$UMB_No.DS;
				$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'UMB_'.$UMB_No.DS;
				// Remove all the files in folder if they exist
				jimport('joomla.client.helper');
				if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}
			    JFolder::create( $base_Dir );

				$UMB_files['name'] = str_replace(" ", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("&", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("#", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("%", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace(",", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("`", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("'", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("\\", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace(":", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("?", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("<", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace(">", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("/", "_", $UMB_files['name']);
				$UMB_files['name'] = str_replace("//", "_", $UMB_files['name']);
				$UMB_files['name'] = ereg_replace("/", "_", $UMB_files['name']);
                $UMB_files['name'] = preg_replace('/\.(?=.*?\.)/', '_', $UMB_files['name']);
				
				$UMB_data['UMB_upld_cert'] 		=	$UMB_files['name'];
                                $folderid= 'UMB_'.$UMB_No ;
                                $filename=$UMB_files['name'];
                                 $ext = end(explode('.', $UMB_files['name']));
				 $filepath = $base_Dir .$UMB_files['name'];

				move_uploaded_file($UMB_files['tmp_name'], $filepath);

				$UMB_arr[$o] = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=UMB_'.$UMB_No.'&filename='.$UMB_files["name"] .'">'.$UMB_files["name"] .'</a>';

					$o++;

				}

 			  $time = JRequest::getVar('time','');
			  if($time == 'second'){
			  $update_time = "UPDATE #__cam_vendor_umbrella_license SET UMB_upld_cert='".$UMB_files["name"]."' where UMB_status ='' "; 
			  $db->setQuery($update_time);
			  $updatetime=$db->query();
			  }
			  else{
			  $lastRowId=  $model->store_vendor_UMB_compliances_info($UMB_data);
			  }
			  
                              

		//}
  }
  if($type=='OMI'){
	 
            $sql1 = "SELECT OMI_folder_id FROM #__cam_vendor_errors_omissions_insurance  WHERE OMI_folder_id!=0 and id=".$type_id;
			$time = JRequest::getVar('time','');
			if($time == 'second'){
			$sql1 = "SELECT OMI_folder_id FROM #__cam_vendor_errors_omissions_insurance  WHERE OMI_folder_id!=0 and OMI_status ='' and vendor_id=".$user->id;
			}
			

		$db->setQuery($sql1);

		$OMI_folder_id = $db->loadResult();

        $sql1 = "SELECT count(id) FROM #__cam_vendor_errors_omissions_insurance  WHERE vendor_id=".$user->id;

		$db->setQuery($sql1);

		$count_id = $db->loadResult();

           	$OMI_files		= JRequest::getVar('uploadfile','','files','array' );
    //echo '<pre>'; print_r($_FILES); exit;
		//for($i=0; $i<count($post['old_line_task_OLN_ids']); $i++)
	//	{
				$OMI_data['id']				=$type_id;
                $OMI_data['vendor_id']			= $user->id;
				if($OMI_files['name'] != '')

				{

				//code to update image filed in vendors table

				//code to move image to folderpath

				if($OMI_folder_id){
				$OMI_data['OMI_folder_id'] 		=	$OMI_folder_id;
                                $OMI_No 		=	$OMI_folder_id;
                                } else {
                                $OMI_data['OMI_folder_id'] 		=	$count_id+1;
                                $OMI_No 		=	$count_id+1;
                                }
 //echo '<pre>'; print_r($OLN_No);  exit;

		  		//$base_Dir = JPATH_COMPONENT.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'OMI_'.$OMI_No.DS;
				$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'OMI_'.$OMI_No.DS;
				// Remove all the files in folder if they exist
				jimport('joomla.client.helper');
				if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}
			    JFolder::create( $base_Dir );

				$OMI_files['name'] = str_replace(" ", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("&", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("#", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("%", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace(",", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("`", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("'", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("\\", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace(":", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("?", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("<", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace(">", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("/", "_", $OMI_files['name']);
				$OMI_files['name'] = str_replace("//", "_", $OMI_files['name']);
				$OMI_files['name'] = ereg_replace("/", "_", $OMI_files['name']);
				 $OMI_files['name'] = preg_replace('/\.(?=.*?\.)/', '_', $OMI_files['name']);
				

				$OMI_data['OMI_upld_cert'] 		=	$OMI_files['name'];
                                $folderid= 'OMI_'.$OMI_No ;
                                $filename=$OMI_files['name'];
                                 $ext = end(explode('.', $OMI_files['name']));
				 $filepath = $base_Dir .$OMI_files['name'];

				move_uploaded_file($OMI_files['tmp_name'], $filepath);

				$OMI_arr[$o] = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=OMI_'.$OMI_No.'&filename='.$OMI_files["name"] .'">'.$OMI_files["name"] .'</a>';

					$o++;

				}

 			  $time = JRequest::getVar('time','');
			  if($time == 'second'){
			  $update_time = "UPDATE #__cam_vendor_errors_omissions_insurance SET OMI_upld_cert='".$OMI_files["name"]."' where OMI_status ='' "; 
			  $db->setQuery($update_time);
			  $updatetime=$db->query();
			  }
			  else{
			  $lastRowId=  $model->store_vendor_OMI_compliances_info($OMI_data);
			  }
			  
                              

		//}
  }
  

		/***************************************************************PLN CODE*********************************************************************/
      if($type=='PLN'){
             $sql1 = "SELECT PLN_folder_id FROM #__cam_vendor_professional_license  WHERE PLN_folder_id!=0 and id=".$type_id;

		$db->setQuery($sql1);

		$PLN_folder_id = $db->loadResult();

                $sql1 = "SELECT count(id) FROM #__cam_vendor_professional_license  WHERE vendor_id=".$user->id;

		$db->setQuery($sql1);

		$count_id1 = $db->loadResult();

		$PLN_files		= JRequest::getVar('uploadfile','','files','array' );


				$PLN_data['id']				=$type_id;
                              $PLN_data['vendor_id']			= $user->id;


				if($PLN_files['name'] != '')

				{

				if($PLN_folder_id){
				$PLN_data['PLN_folder_id'] 		=	$PLN_folder_id;
                                $PLN_No 		=	$PLN_folder_id;
                                } else {
                                $PLN_data['PLN_folder_id'] 		=	$count_id1+1;
                                $PLN_No 		=	$count_id1+1;
                                }
					$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'PLN_'.$PLN_No.DS;

					// Remove all the files in folder if they exist
					jimport('joomla.client.helper');
					if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}
					JFolder::create( $base_Dir );

					$PLN_files['name'] = str_replace(" ", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("%", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("#", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("&", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace(",", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("`", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("'", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("\\", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace(":", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("?", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("<", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace(">", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("/", "_", $PLN_files['name']);
					$PLN_files['name'] = str_replace("//", "_", $PLN_files['name']);
					$PLN_files['name'] = ereg_replace("/", "_", $PLN_files['name']);
                    $PLN_files['name'] = preg_replace('/\.(?=.*?\.)/', '_', $PLN_files['name']);
					$PLN_data['PLN_upld_cert'] = $PLN_files['name'];
                                $folderid= 'PLN_'.$PLN_No ;
                                $filename=$PLN_files['name'];
                                 $ext = end(explode('.', $PLN_files['name']));
					$filepath = $base_Dir .$PLN_files['name'];

					move_uploaded_file($PLN_files['tmp_name'], $filepath);

					$PLN_arr[$p] = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=PLN_'.$PLN_No.'&filename='.$PLN_files["name"] .'">'.$PLN_files["name"] .'</a>';

						$p++;

				}

			$lastRowId= $model->store_vendor_PLN_compliances_info($PLN_data);


//exit;
      }

		/***************************************************************GLI CODE*********************************************************************/
if($type=='GLI'){
                  $sql1 = "SELECT GLI_folder_id FROM #__cam_vendor_liability_insurence  WHERE GLI_folder_id!=0 and id=".$type_id;

		$db->setQuery($sql1);

		$GLI_folder_id = $db->loadResult();

                $sql1 = "SELECT count(id) FROM #__cam_vendor_liability_insurence  WHERE vendor_id=".$user->id;

		$db->setQuery($sql1);

		$count_id1 = $db->loadResult();

		$GLI_files		= JRequest::getVar('uploadfile','','files','array' );
//echo '<pre>'; print_r($post); exit;

			//code to store GLI data
				$GLI_data['id']				=$type_id;
				$GLI_data['vendor_id'] 			=  $user->id;
				if($GLI_files['name'] != '')

				{


				if($GLI_folder_id){
				$GLI_data['GLI_folder_id'] 		=	$GLI_folder_id;
                                $GLI_No 		=	$GLI_folder_id;
                                } else {
                                $GLI_data['GLI_folder_id'] 		=	$count_id1+1;
                                $GLI_No 		=	$count_id1+1;
                                }

		  			$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'GLI_'.$GLI_No.DS;

					jimport('joomla.client.helper');
					if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}

			   		JFolder::create( $base_Dir );
                 	
					$GLI_files['name'] = str_replace(" ", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("%", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("#", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("&", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace(",", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("`", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("'", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("\\", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace(":", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("?", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("<", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace(">", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("/", "_", $GLI_files['name']);
					$GLI_files['name'] = str_replace("//", "_", $GLI_files['name']);
					$GLI_files['name'] = ereg_replace("/", "_", $GLI_files['name']);
					$GLI_files['name'] = preg_replace('/\.(?=.*?\.)/', '_', $GLI_files['name']);
				
					$GLI_data['GLI_upld_cert'] 			= $GLI_files['name'];
                                $folderid= 'GLI_'.$GLI_No ;
                                $filename=$GLI_files['name'];
                                 $ext = end(explode('.', $GLI_files['name']));
								// echo $ext; exit;
					$filepath = $base_Dir .$GLI_files['name'];
					//echo $GLI_files['tmp_name'].'<br /><br />'.$filepath; exit;
					move_uploaded_file($GLI_files['tmp_name'], $filepath);
					$GLI_arr[$g] = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=GLI_'.$GLI_No.'&filename='.$GLI_files["name"] .'">'.$GLI_files["name"] .'</a>';

					$g++;

				}


				$lastRowId=$model->store_vendor_GLI_compliances_info($GLI_data);


}
		/***************************************************************WCI CODE*********************************************************************/
if($type=='wc'){
            $sql1 = "SELECT wc_folder_id FROM #__cam_vendor_workers_compansation  WHERE wc_folder_id!=0 and id=".$type_id;

		$db->setQuery($sql1);

		$wc_folder_id = $db->loadResult();

                $sql1 = "SELECT count(id) FROM #__cam_vendor_workers_compansation  WHERE vendor_id=".$user->id;

		$db->setQuery($sql1);

		$count_id1 = $db->loadResult();

		$WC_files		= JRequest::getVar('uploadfile','','files','array' );


			//code to store WCI data
				$WC_data['id']                          = $type_id;
				$WC_data['vendor_id'] 			=$user->id;

				if($WC_files['name']!= '')

					{

						//code to update image filed in vendors table

						//code to move image to folderpath

						//$base_Dir = JPATH_COMPONENT.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS;

				if($wc_folder_id){
				$WC_data['wc_folder_id'] 		=	$wc_folder_id;
                                $WC_No 		=	$wc_folder_id;
                                } else {
                                $WC_data['wc_folder_id'] 		=	$count_id1+1;
                                $WC_No 		=	$count_id1+1;
                                }


		  				$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'WC_'.$WC_No.DS;

						jimport('joomla.client.helper');
						if(is_dir($base_Dir))
						{
							$files = JFolder::files($base_Dir, '.', false, true, array());
							if (!empty($files)) {
									jimport('joomla.filesystem.file');
									if (JFile::delete($files) !== true) {
											// JFile::delete throws an error
											return false;
									}
							}
						}

			    		JFolder::create( $base_Dir );

						$WC_files['name'] = str_replace(" ", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("%", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("#", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("&", "_", $WC_files['name']);
						$WC_files['name'] = str_replace(",", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("`", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("'", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("\\", "_", $WC_files['name']);
						$WC_files['name'] = str_replace(":", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("?", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("<", "_", $WC_files['name']);
						$WC_files['name'] = str_replace(">", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("/", "_", $WC_files['name']);
						$WC_files['name'] = ereg_replace("/", "_", $WC_files['name']);
						$WC_files['name'] = str_replace("//", "_", $WC_files['name']);
                        $WC_files['name'] = preg_replace('/\.(?=.*?\.)/', '_', $WC_files['name']);
						$WC_data['wc_upld_cert'] 		= $WC_files['name'];
                                 $folderid= 'WC_'.$WC_No ;
                                $filename=$WC_files['name'];
                                 $ext = end(explode('.', $WC_files['name']));
					$filepath = $base_Dir .$WC_files['name'];

						move_uploaded_file($WC_files['tmp_name'], $filepath);

						$WC_arr[$w] = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=WC_'.$WC_No.'&filename='.$WC_files["name"] .'">'.$WC_files["name"] .'</a>';

					$w++;

					}

//echo '<pre>'; print_r($WC_data); exit;
                               $lastRowId= $model->store_vendor_WC_compliances_info($WC_data);


} //exit;
if($type=='WCI'){

      $sql1 = "SELECT WCI_folder_id FROM #__cam_vendor_workers_companies_insurance  WHERE WCI_folder_id!=0 and id=".$type_id;

		$db->setQuery($sql1);

		$WCI_folder_id = $db->loadResult();

                $sql1 = "SELECT count(id) FROM #__cam_vendor_workers_companies_insurance  WHERE vendor_id=".$user->id;

		$db->setQuery($sql1);

		$count_id1 = $db->loadResult();

$WCI_files		= JRequest::getVar('uploadfile','','files','array' );


			//code to store WCI data

				$WCI_data['id']						= $type_id;

				$WCI_data['vendor_id'] 			= $user->id;

				if($WCI_files['name']!= '')

					{

				if($WCI_folder_id){
				$WCI_data['WCI_folder_id'] 		=	$WCI_folder_id;
                                $WCI_No 		=	$WCI_folder_id;
                                } else {
                                $WCI_data['WCI_folder_id'] 		=	$count_id1+1;
                                $WCI_No 		=	$count_id1+1;
                                }

		  				$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'WCI_'.$WCI_No.DS;

						jimport('joomla.client.helper');
						if(is_dir($base_Dir))
						{
							$files = JFolder::files($base_Dir, '.', false, true, array());
							if (!empty($files)) {
									jimport('joomla.filesystem.file');
									if (JFile::delete($files) !== true) {
											// JFile::delete throws an error
											return false;
									}
							}
						}

			    		JFolder::create( $base_Dir );

						$WCI_files['name'] = str_replace(" ", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("%", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("#", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("&", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace(",", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("`", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("'", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("\\", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace(":", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("?", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("<", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace(">", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("/", "_", $WCI_files['name']);
						$WCI_files['name'] = ereg_replace("/", "_", $WCI_files['name']);
						$WCI_files['name'] = str_replace("//", "_", $WCI_files['name']);
                         $WCI_files['name'] = preg_replace('/\.(?=.*?\.)/', '_', $WCI_files['name']);
						$WCI_data['WCI_upld_cert'] 			= $WCI_files['name'];

						$filepath = $base_Dir .$WCI_files['name'];
                                $folderid= 'WCI_'.$WCI_No ;
                                $filename=$WCI_files['name'];
                                 $ext = end(explode('.', $WCI_files['name']));
						move_uploaded_file($WCI_files['tmp_name'], $filepath);

						$WCI_arr[$w] = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=WCI_'.$WCI_No.'&filename='.$WCI_files["name"] .'">'.$WCI_files["name"] .'</a>';

					$w++;

					}

                               $lastRowId= $model->store_vendor_WCI_compliances_info($WCI_data);


}

if($type=='aip'){
                    $sql7 = "SELECT aip_folder_id FROM #__cam_vendor_auto_insurance  WHERE aip_folder_id!=0 and id=".$type_id;

		$db->setQuery($sql7);

		$aip_folder_id = $db->loadResult();

                $sql8 = "SELECT count(id) FROM #__cam_vendor_auto_insurance  WHERE vendor_id=".$user->id;

		$db->setQuery($sql8);

		$count_id = $db->loadResult();

           	$aip_files		= JRequest::getVar('uploadfile','','files','array' );
    //echo '<pre>'; print_r($_FILES); exit;
		//for($i=0; $i<count($post['old_line_task_OLN_ids']); $i++)
	//	{
				$aip_data['id']				=$type_id;
                                $aip_data['vendor_id']			= $user->id;
				if($aip_files['name'] != '')

				{

				//code to update image filed in vendors table

				//code to move image to folderpath

				if($aip_folder_id){
				$aip_data['aip_folder_id'] 		=	$aip_folder_id;
                                $aip_No 		=	$aip_folder_id;
                                } else {
                                $aip_data['aip_folder_id'] 		=	$count_id+1;
                                $aip_No 		=	$count_id+1;
                                }
 //echo '<pre>'; print_r($OLN_No);  exit;

		  		 $base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'aip_'.$aip_No.DS;

				// Remove all the files in folder if they exist
				jimport('joomla.client.helper');
				if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}


			    JFolder::create( $base_Dir );

				$aip_files['name'] = str_replace(" ", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("&", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("#", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("%", "_", $aip_files['name']);
				$aip_files['name'] = str_replace(",", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("`", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("'", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("\\", "_", $aip_files['name']);
				$aip_files['name'] = str_replace(":", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("?", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("<", "_", $aip_files['name']);
				$aip_files['name'] = str_replace(">", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("/", "_", $aip_files['name']);
				$aip_files['name'] = str_replace("//", "_", $aip_files['name']);
				$aip_files['name'] = ereg_replace("/", "_", $aip_files['name']);
                $aip_files['name'] = preg_replace('/\.(?=.*?\.)/', '_', $aip_files['name']);
				$aip_data['aip_upld_cert'] 		=	$aip_files['name'];
                                $folderid= 'aip_'.$aip_No;
                                $filename=$aip_files['name'];
                                 $ext = end(explode('.', $aip_files['name']));
				 $filepath = $base_Dir .$aip_files['name'];
//exit;
				move_uploaded_file($aip_files['tmp_name'], $filepath);

				$aip_arr[$o] = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=aip_'.$aip_No.'&filename='.$aip_files["name"] .'">'.$aip_files["name"] .'</a>';

					$o++;

				}

                              $lastRowId=  $model->store_vendor_aip_compliances_info($aip_data);

		//}
  }
		/***************************************************************W9 CODE*********************************************************************/
if($type=='W9'){
		$W9files		= JRequest::getVar('uploadfile','','files','array' );
//echo "<pre>"; print_r($W9files);
		  		$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'W9'.DS;

				jimport('joomla.client.helper');
				if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}

			    JFolder::create( $base_Dir );

				$W9files['name'] = str_replace(" ", "_", $W9files['name']);
				$W9files['name'] = str_replace("&", "_", $W9files['name']);
				$W9files['name'] = str_replace("#", "_", $W9files['name']);
				$W9files['name'] = str_replace("%", "_", $W9files['name']);
				$W9files['name'] = str_replace(",", "_", $W9files['name']);
				$W9files['name'] = str_replace("`", "_", $W9files['name']);
				$W9files['name'] = str_replace("'", "_", $W9files['name']);
				$W9files['name'] = str_replace("\\", "_", $W9files['name']);
				$W9files['name'] = str_replace(":", "_", $W9files['name']);
				$W9files['name'] = str_replace("?", "_", $W9files['name']);
				$W9files['name'] = str_replace("<", "_", $W9files['name']);
				$W9files['name'] = str_replace(">", "_", $W9files['name']);
				$W9files['name'] = str_replace("/", "_", $W9files['name']);
				$W9files['name'] = ereg_replace("/", "_", $W9files['name']);
				$W9files['name'] = str_replace("//", "_", $W9files['name']);
				$W9files['name'] = preg_replace('/\.(?=.*?\.)/', '_', $W9files['name']);



				$filepath = $base_Dir .$W9files['name'];
                                $folderid= 'W9';
                                $filename=$W9files['name'];
                                 $ext = end(explode('.', $W9files['name']));
				move_uploaded_file($W9files['tmp_name'], $filepath);

				$W9_link = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=W9&filename='.$W9files['name'].'">'.$W9files['name'].'</a>';
				$W9_data['w9_upld_cert'] 			= $post['W9_upld_cert1'];

				$W9_data['id']					=  $type_id;
  				$W9_data['w9_upld_cert'] = $W9files['name'];
  				$W9_data['vendor_id'] = $user->id;


				//echo "<pre>"; print_r($W9_data); exit;
				$lastRowId=$model->store_vendor_compliance_w9docs_info($W9_data);
}

//echo $lastRowId; exit;
            echo "<script language='javascript' type='text/javascript'>
		//window.parent.document.getElementById( 'sbox-window' ).close();
                parent.SqueezeBox.close();
                var id = '".$id."';
		var remove = 'remove".$id."';
               var userid = '".$user->id."';
		var upload = 'upload".$id."';
                var image = 'imagdisplay".$id."';
                var folderid = '".$folderid."';
                var filename='".$filename."';
               var lastrowid='".$lastRowId."';
                var type='".$type."';
                var ext='".$ext."';
		var root='".Juri::root()."';


                      //  var del_path = '<a href=\'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&doc=OLN_'+splreq+'&task=Remove_downloadfile&Alt_Prp='+AltPrp+'&Alt_bid='+AltPrp+'&vendor_id='+userid+'&rfp_id='+rfpid+'&task_id='+task+'&doc_id='+docid+'&act='+act+'&rebid='+rebid+'&prop_id='+Proposal_id+'&&Itemid=107\'><img src=\'templates/camassistant_left/images/remove.gif\' alt=\'Remove file\' align=\'absmiddle\' /></a><br/>';

               var image_exe='<a href=\'index.php?option=com_camassistant&controller=vendorcompliances_details&task=view_upld_cert&user_id='+userid+'&doc='+folderid+'&filename='+filename+'\'><img src=\'http://myvendorcenter.com/live/templates/camassistant_inner/images/doc_images/images_'+ext+'.png\'>';


                window.parent.document.getElementById('imagdisplay'+type+''+id).innerHTML = image_exe;
				window.parent.document.getElementById(type+'_upld_cert'+id).value = filename;
               //  window.parent.document.getElementById('upload'+type+''+id).style.display ='none';
                //  window.parent.document.getElementById('remove'+type+''+id).style.display ='';
                 if(lastrowid){
                   window.parent.document.getElementById('d'+type+''+id).value = lastrowid;
                   window.parent.document.getElementById('old_line_task_'+type+'_ids_'+id).value = lastrowid;
                  }

              </script>";
		 exit;

        //$link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_compliance_docs&Itemid=191';

		//$this->setRedirect($link);
	}

	//function to delete vendor compliance document
	function delete_upld_cert()
	{
		$model = $this->getModel('vendorcompliances_details');
		$type = JRequest::getVar('type','');
    		 $type= JRequest::getVar('suffix','');
                $type_id= JRequest::getVar('id','');
                $da_id= JRequest::getVar('daid','');
               // echo '<pre>'; print_r($_REQUEST); exit;
		$open = $model->get_delete_upld_cert();
		$err_msg="Document Deleted Successfully";

			$err_msg="Document Deleted Successfully";

			echo "<script language='javascript' type='text/javascript'>

                       var type = '".$type."';
                        var type_id = '".$type_id."';
                        var da_id = '".$da_id."';

			//window.parent.document.getElementById(id).value = '';

			alert('Document Deleted Successfully');
                        window.parent.document.getElementById('imagdisplay'+type+''+da_id).innerHTML = 'No File Uploaded. Click on Upload Document to add a file.';
                         window.parent.document.getElementById('upload'+type+''+da_id).style.display ='';
                         window.parent.document.getElementById('remove'+type+''+da_id).style.display ='none';
                      //  window.parent.parent.location.reload();
			 </script>";
		exit;
		//$this->setRedirect( $link,$msg );
		//parent::display();
	}

	//function te delete compliance from db
	function del_vendorcompliance_fromtbl()
	{
		$tbl = JRequest::getVar('tbl','');
		
		$docid = JRequest::getVar('docid','');
		$user = JFactory::getUser();
		$db = JFactory::getDBO();
		$query = "DELETE FROM #__cam_vendor_".$tbl." WHERE id=".$docid;
		$db->setQuery($query);
		if($db->query())
		{ echo 'Deleted'; }
		exit;
	}


	//function to save vendor compliance docs
	function save_compliance()
	{
		
		$post	= JRequest::get('post');
		$saveddoc	= JRequest::getVar('document_type','');
		$Itemid	= JRequest::getVar('Itemid','');
		$db = JFactory::getDBO();
		$vendor_user = JFactory::getUser($post['userid']);
		$db = JFactory::getDBO();
		$sql = "SELECT tax_id FROM #__cam_vendor_company   WHERE user_id=".$vendor_user->id;
		$db->setQuery($sql);
		$tax_id = $db->loadResult();
		$query_companyv = "SELECT company_name FROM #__cam_vendor_company  WHERE user_id=".$vendor_user->id;
		$db->setQuery($query_companyv);
		$companyname_v = $db->loadResult();
		
		$vendorname = $vendor_user->name.'_'.$vendor_user->lastname.'_'.$tax_id;
		$vendorname = str_replace(' ','_',$vendorname);
		$today = date('Y-m-d');
		$flag = 0;

		
		 //print_r($post['old_line_task_OLN_ids']); print_r($post['old_line_task_PLN_ids']); print_r($post['old_line_task_GLI_ids']); print_r($post['old_line_task_WCI_ids']);

		//code to copy docs to folder
		$model = $this->getModel('vendorcompliances_details');
		/***************************************************************OLN_CODE*********************************************************************/
		$OLN_files		= JRequest::getVar('OLN_upld_cert','','files','array' );
		for($i=0; $i<count($post['old_line_task_OLN_ids']); $i++)
		{

				$OLN_data['id']					= $post['old_line_task_OLN_ids'][$i];
				$OLN_data['vendor_id']			= $vendor_user->id;
				$OLN_data['OLN_license'] 		= $post['OLN_license'][$i];
				
				if (strpos($post['OLN_expdate'][$i], 'Does Not Expire') !== false){
				$OLN_data['OLN_expdate']		= 'Does Not Expire';
				}
				else{
				$date = explode('-',$post['OLN_expdate'][$i]);
				$OLN_data['OLN_expdate']		= $date[2].'-'.$date[0].'-'.$date[1];
				}
				
				
				$OLN_data['OLN_city_country'] 	= $post['OLN_city_country'][$i];
				//$OLN_data['OLN_upld_cert'] 		= $post['OLN_upld_cert'][$i];
				$OLN_data['OLN_state'] 			= $post['OLN_state'][$i];
				$date = explode('-',$post['OLN_date_verified'][$i]);
				$date1	= $date[2].'-'.$date[0].'-'.$date[1];
				//$OLN_data['OLN_status'] 			= $post['OLN_radio'][$i+1];
                //$OLN_data['OLN_status'] 			= '1';
                if($post['OLN_date_verified'][$i]!='Rejected'){
				$OLN_data['OLN_date_verified']	= $today;//$date1;
				} else {
				$OLN_data['OLN_date_verified']	= $today;
				}
                                //if($post['OLN_radio'][$i+1]){
                            //    $OLN_data['OLN_status'] 			= $post['OLN_radio'][$i+1];
                              if($post['OLN_radio'][$i+1] == '0'){

                                $OLN_data['OLN_status']			= '1';
                              } else if($post['OLN_radio'][$i+1] == '1'){

                                $OLN_data['OLN_status']			= '1';
                                 //$OLN_data['OLN_date_verified']	= $today;
                              } else if($post['OLN_radio'][$i+1] == '-1'){

                                $OLN_data['OLN_status']			= '-1';
                              } else if(!$post['OLN_radio'][$i+1]) {
                                  $OLN_data['OLN_status']			= '1';
                             }
                               // } else {
                               //   $OLN_data['OLN_status'] 			='1';
                               // }
				/* if($OLN_files['name'][$i] != '')
				{
				//code to update image filed in vendors table
				//code to move image to folderpath
				$OLN_No = $i+1;
				$OLN_No = $post['current_line_task_OLN_ids'][$i];
		  		$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'OLN_'.$OLN_No.DS;
				// Remove all the files in folder if they exist
					jimport('joomla.client.helper');
					if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}
			    JFolder::create( $base_Dir );
				$OLN_files['name'][$i] = str_replace(" ", "_", $OLN_files['name'][$i]);
				$OLN_files['name'][$i] = str_replace("&", "_", $OLN_files['name'][$i]);
				$OLN_files['name'][$i] = str_replace("#", "_", $OLN_files['name'][$i]);
				$OLN_files['name'][$i] = str_replace("%", "_", $OLN_files['name'][$i]);
				$OLN_files['name'][$i] = str_replace("`", "_", $OLN_files['name'][$i]);
				$OLN_files['name'][$i] = str_replace("'", "_", $OLN_files['name'][$i]);
				$OLN_files['name'][$i] = str_replace("\\", "_", $OLN_files['name'][$i]);

				$filepath = $base_Dir .$OLN_files['name'][$i];
				move_uploaded_file($OLN_files['tmp_name'][$i], $filepath);
				$OLN_data['OLN_upld_cert'] 		=	$OLN_files['name'][$i];
				$OLN_data['OLN_folder_id'] 		=	$OLN_No;
				//$OLN_data['OLN_status'] 		= '1';
				$OLN_data['OLN_date_verified']	= $today;
				$flag = 1;
				}  */
				/*if($OLN_data['OLN_date_verified'] == '0000-00-00')
				$OLN_data['OLN_date_verified'] = $today;*/
				
				$addo = $i + 1 ;
				if($saveddoc == 'OLN'.$addo){
				$oln_vdate = $post['OLN_date_verified'][$i] ;
				$oexp = explode('-',$oln_vdate);
				$OLN_data['OLN_date_verified'] = $oexp[2].'-'.$oexp[0].'-'.$oexp[1];
				//$OLN_data['OLN_date_verified']	= date('Y-m-d');
				}	
				else{
				$olddate ="select OLN_date_verified from #__cam_vendor_occupational_license Where id =".$post['old_line_task_OLN_ids'][$i];
				$db->setQuery($olddate);
				$OLN_data['OLN_date_verified'] = $db->loadResult();
					if($OLN_data['OLN_date_verified'])
					$OLN_data['OLN_date_verified'] = $OLN_data['OLN_date_verified']; 
					else
					$OLN_data['OLN_date_verified'] = $today ;
				}
								
			if($OLN_data['OLN_expdate']!='' && $OLN_data['OLN_expdate']!='--') {
			//echo "<pre>"; print_r($OLN_data); exit;
               $model->store_vendor_OLN_compliances_info($OLN_data);
               }
				//if($OLN_data['OLN_license'] != ''  || $OLN_files['name'][$i] != '' || $OLN_data['OLN_expdate'] != '' || $OLN_data['OLN_city_country'] != '' || $OLN_data['OLN_upld_cert'] != '' || $OLN_data['OLN_state'] != '')
				//{ $model->store_vendor_OLN_compliances_info($OLN_data);}
		}
//echo 'anand'; exit;

		/***************************************************************PLN CODE*********************************************************************/
		$PLN_files		= JRequest::getVar('PLN_upld_cert','','files','array' );
		for($i=0,$p=0; $i<count($post['old_line_task_PLN_ids']); $i++)
		{
				$PLN_data['id']					= $post['old_line_task_PLN_ids'][$i];
				$PLN_data['vendor_id']			= $vendor_user->id;
				$PLN_data['PLN_license'] 		= $post['PLN_license'][$i];
				$date = explode('-',$post['PLN_expdate'][$i]);
				$PLN_data['PLN_expdate']		= $date[2].'-'.$date[0].'-'.$date[1];
				$PLN_data['PLN_category'] 		= $post['PLN_category'][$i];
				$PLN_data['PLN_type']			= $post['PLN_type'][$i];
				$PLN_data['PLN_state'] 			= $post['PLN_state'][$i];
				$date = explode('-',$post['PLN_date_verified'][$i]);
				$date1	= $date[2].'-'.$date[0].'-'.$date[1];
				 if($post['PLN_date_verified'][$i]!='Rejected'){
				$PLN_data['PLN_date_verified']	= $today;//$date1;
				} else {
				$PLN_data['PLN_date_verified']	= $today;
				}
				//$PLN_data['PLN_upld_cert'] 		= $post['PLN_upld_cert'][$i];
                               // if($post['PLN_radio'][$i+1]){
			//	$PLN_data['PLN_status']			= $post['PLN_radio'][$i+1];
                             if($post['PLN_radio'][$i+1] == '0'){

                                $PLN_data['PLN_status']			= '1';
                              } else if($post['PLN_radio'][$i+1] == '1'){

                                $PLN_data['PLN_status']			= '1';
                                // $PLN_data['PLN_date_verified'] = $today;
                              } else if($post['PLN_radio'][$i+1] == '-1'){

                                $PLN_data['PLN_status']			= '-1';
                              } else if(!$post['PLN_radio'][$i+1]) {
                                  $PLN_data['PLN_status']		= '1';
                             }
                               // } else {
                                  //  $PLN_data['PLN_status']			= '1';
                                //}
                        // $PLN_data['PLN_status']			= '1';
				

				/*if($PLN_files['name'][$i] != '')
				{
					$PLN_No = $i+1;
					$PLN_No	=	$post['current_line_task_PLN_ids'][$i];
					$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'PLN_'.$PLN_No.DS;
					// Remove all the files in folder if they exist
					jimport('joomla.client.helper');
					if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}
					JFolder::create( $base_Dir );
					$PLN_files['name'][$i] = str_replace(" ", "_", $PLN_files['name'][$i]);
					$PLN_files['name'][$i] = str_replace("&", "_", $PLN_files['name'][$i]);
					$PLN_files['name'][$i] = str_replace("#", "_", $PLN_files['name'][$i]);
					$PLN_files['name'][$i] = str_replace("%", "_", $PLN_files['name'][$i]);
					$PLN_files['name'][$i] = str_replace("`", "_", $PLN_files['name'][$i]);
					$PLN_files['name'][$i] = str_replace("'", "_", $PLN_files['name'][$i]);
					$PLN_files['name'][$i] = str_replace("\\", "_", $PLN_files['name'][$i]);

					$filepath = $base_Dir .$PLN_files['name'][$i];
					move_uploaded_file($PLN_files['tmp_name'][$i], $filepath);
					$PLN_data['PLN_upld_cert'] = $PLN_files['name'][$i];
					$PLN_data['PLN_folder_id'] 		=	$PLN_No;
					//$PLN_data['PLN_status'] 		= '1';
					$PLN_data['PLN_date_verified']	= $today;
					$flag = 1;
				} */
				/*if($PLN_data['PLN_date_verified'] == '0000-00-00')
				$PLN_data['PLN_date_verified'] = $today;*/
				//echo "<pre>"; print_r($PLN_data);
				
				$addp = $i + 1 ;
				if($saveddoc == 'PLN'.$addp){
				$pln_vdate = $post['PLN_date_verified'][$i] ;
				$pexp = explode('-',$pln_vdate);
				$PLN_data['PLN_date_verified'] = $pexp[2].'-'.$pexp[0].'-'.$pexp[1];
				//$PLN_data['PLN_date_verified']    = date('Y-m-d');
				}	
				else{
				 $olddate ="select PLN_date_verified from #__cam_vendor_professional_license Where id =".$post['old_line_task_PLN_ids'][$i];
				$db->setQuery($olddate);
				$PLN_data['PLN_date_verified'] = $db->loadResult();
					if($PLN_data['PLN_date_verified'])
					$PLN_data['PLN_date_verified'] = $PLN_data['PLN_date_verified'] ;
					//else
					//$PLN_data['PLN_date_verified'] = $today ;
				}
				
				if(($PLN_data['PLN_expdate']!='' && $PLN_data['PLN_expdate']!='--') || $PLN_data['PLN_state'] != '' || $PLN_data['PLN_type'] != '' ) 
				{
				//echo '<pre>'; print_r($PLN_data); exit;
                   $model->store_vendor_PLN_compliances_info($PLN_data);
                   }
				//if($PLN_data['PLN_license'] != ''|| $PLN_files['name'][$i] != '' || $PLN_data['PLN_expdate'] != '' || $PLN_data['PLN_category'] != '' || $PLN_data['PLN_type'] != '' || $PLN_data['PLN_state'] != '' || $PLN_data['PLN_upld_cert'] != '')
				//$model->store_vendor_PLN_compliances_info($PLN_data);
		}
//echo 'anand'; exit;
		/***************************************************************GLI CODE*********************************************************************/
		$GLI_files		= JRequest::getVar('GLI_upld_cert','','files','array' );
		for($i=0,$g=0; $i<count($post['old_line_task_GLI_ids']); $i++)
		{
				//code to store GLI data
				$GLI_data['id']					= $post['old_line_task_GLI_ids'][$i];
				$GLI_data['vendor_id']				= $vendor_user->id;
				$GLI_data['GLI_name'] 				= $post['GLI_name'][$i];
				$GLI_data['GLI_policy'] 			= $post['GLI_policy'][$i];
				$date = explode('-',$post['GLI_start_date'][$i]);
				$GLI_data['GLI_start_date'] 		= $date[2].'-'.$date[0].'-'.$date[1];
				$date = explode('-',$post['GLI_end_date'][$i]);
				$GLI_data['GLI_end_date'] 			= $date[2].'-'.$date[0].'-'.$date[1];
				$GLI_data['GLI_agent_first_name'] 	= $post['GLI_agent_first_name'][$i];
				$GLI_data['GLI_agent_last_name'] 	= $post['GLI_agent_last_name'][$i];
				$GLI_data['GLI_phone_number'] 		= $post['GLI_phone1'][$i].'-'.$post['GLI_phone2'][$i].'-'.$post['GLI_phone3'][$i];
				$GLI_data['GLI_policy_aggregate'] 	= doubleval(str_replace(",","",$post['GLI_policy_aggregate'][$i]));
				$GLI_data['GLI_policy_occurence']	= doubleval(str_replace(",","",$post['GLI_policy_occurence'][$i]));
				//$GLI_data['GLI_upld_cert'] 			= $post['GLI_upld_cert'][$i];
                             //   if($post['GLI_radio'][$i+1]){
				//$GLI_data['GLI_status']			= $post['GLI_radio'][$i+1];
				$date = explode('-',$post['GLI_date_verified'][$i]);
				$date1		= $date[2].'-'.$date[0].'-'.$date[1];
				if($post['GLI_date_verified'][$i]!='Rejected'){
				$GLI_data['GLI_date_verified']	= $today;//$date1;
				} else {
				$GLI_data['GLI_date_verified']	= $today;
				}
                                 if($post['GLI_radio'][$i+1] == '0'){

                                $GLI_data['GLI_status']			= '1';
                              } else if($post['GLI_radio'][$i+1] == '1'){

                                $GLI_data['GLI_status']			= '1';
                               // $GLI_data['GLI_date_verified'] = $today;
                              } else if($post['GLI_radio'][$i+1] == '-1'){

                                $GLI_data['GLI_status']			= '-1';
                              } else if(!$post['GLI_radio'][$i+1]) {
                                  $GLI_data['GLI_status']			= '1';
                             } //} else {
                                   // $GLI_data['GLI_status']			= '1';
                               // }
 				// $GLI_data['GLI_status']			= '1';
				

				/* if($GLI_files['name'][$i] != '')
				{
					//code to move image to folderpath
					$GLI_No = $i+1;
					$GLI_No	=	$post['current_line_task_GLI_ids'][$i];
		  			$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'GLI_'.$GLI_No.DS;
					// Remove all the files in folder if they exist
					jimport('joomla.client.helper');
					if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}
			   		JFolder::create( $base_Dir );
					$GLI_files['name'][$i] = str_replace(" ", "_", $GLI_files['name'][$i]);
					$GLI_files['name'][$i] = str_replace("&", "_", $GLI_files['name'][$i]);
					$GLI_files['name'][$i] = str_replace("#", "_", $GLI_files['name'][$i]);
					$GLI_files['name'][$i] = str_replace("%", "_", $GLI_files['name'][$i]);
					$GLI_files['name'][$i] = str_replace("`", "_", $GLI_files['name'][$i]);
					$GLI_files['name'][$i] = str_replace("'", "_", $GLI_files['name'][$i]);
					$GLI_files['name'][$i] = str_replace("\\", "_", $GLI_files['name'][$i]);


					$filepath = $base_Dir .$GLI_files['name'][$i];
					move_uploaded_file($GLI_files['tmp_name'][$i], $filepath);
					$GLI_data['GLI_upld_cert'] 			= $GLI_files['name'][$i];
					$GLI_data['GLI_folder_id'] 		=	$GLI_No;
					$GLI_data['GLI_status'] = '1';
					$GLI_data['GLI_date_verified'] = $today;
					$flag = 1;
				}*/
				/*if($GLI_data['GLI_date_verified'] == '0000-00-00')
				$GLI_data['GLI_date_verified'] = $today;*/
				//echo "<pre>"; print_r($GLI_data); exit;
				
				//For master completed by sateesh
				$GLI_data['GLI_med']	= str_replace(",","",$post['GLI_med'][$i]);
				$GLI_data['GLI_injury']	= str_replace(",","",$post['GLI_injury'][$i]);
				$GLI_data['GLI_products']	= str_replace(",","",$post['GLI_products'][$i]);
				$GLI_applies = JRequest::getVar('GLI_applies'.$i);
				$GLI_data['GLI_applies']	= $GLI_applies;
				$GLI_data['GLI_damage']	= str_replace(",","",$post['GLI_damage'][$i]);
				$GLI_primary = JRequest::getVar('GLI_primary'.$i);
				
				if($GLI_primary)
				$GLI_primary = $GLI_primary ;
				else
				$GLI_primary = '';
				
				$GLI_data['GLI_primary']	= $GLI_primary;
				$GLI_waiver = JRequest::getVar('GLI_waiver'.$i);
				
				if($GLI_waiver)
				$GLI_waiver = $GLI_waiver ;
				else
				$GLI_waiver = '';
				
				$GLI_data['GLI_waiver']	= $GLI_waiver;
				$GLI_occur = JRequest::getVar('GLI_occur'.$i);
				
				if($GLI_occur)
				$GLI_occur = $GLI_occur ;
				else
				$GLI_occur = '';
				
				$GLI_data['GLI_occur']	= $GLI_occur;
				$GLI_certholder = JRequest::getVar('GLI_certholder'.$i);
				$GLI_data['GLI_certholder']	= $GLI_certholder;
				$GLI_additional = JRequest::getVar('GLI_additional'.$i);
				$GLI_data['GLI_additional']	= $GLI_additional;

				//Master completed by sateesh
				$addo = $i + 1 ;
				if($saveddoc == 'GLI'.$addo){
				$gli_vdate = $post['GLI_date_verified'][$i] ;
				$gexp = explode('-',$gli_vdate);
				$GLI_data['GLI_date_verified'] = $gexp[2].'-'.$gexp[0].'-'.$gexp[1];
				//$GLI_data['GLI_date_verified']    = date('Y-m-d');
				}	
				else{
				$olddate ="select  GLI_date_verified from #__cam_vendor_liability_insurence Where id =".$post['old_line_task_GLI_ids'][$i];
				$db->setQuery($olddate);
				$GLI_data['GLI_date_verified'] = $db->loadResult();
					if($GLI_data['GLI_date_verified'])
					$GLI_data['GLI_date_verified'] = $GLI_data['GLI_date_verified'] ;
					else
					$GLI_data['GLI_date_verified'] = $today ;
				}	
				
if(($GLI_data['GLI_end_date']!='' && $GLI_data['GLI_end_date']!='--') || ($GLI_data['GLI_policy_aggregate'] != '' && $GLI_data['GLI_policy_aggregate'] != '0.00') || ($GLI_data['GLI_policy_occurence'] != '' && $GLI_data['GLI_policy_occurence'] != '0.00') ) 
				{
				//echo '<pre>'; print_r($GLI_data); exit;
				$model->store_vendor_GLI_compliances_info($GLI_data);
				}
		}
		//echo 'anand'; exit;
		/***************************************************************WCI CODE*********************************************************************/
$WC_files		= JRequest::getVar('wc_upld_cert','','files','array' );
//echo '<pre>'; print_r($post); exit;
		for($i=0,$wc=0; $i<count($post['old_line_task_wc_ids']); $i++)

		{

			//code to store WCI data

				$WC_data['id']						= $post['old_line_task_wc_ids'][$i];

				$WC_data['vendor_id']				=$vendor_user->id;


				$date = explode('-',$post['wc_end_date'][$i]);

				$WC_data['wc_end_date'] 			= $date[2].'-'.$date[0].'-'.$date[1];
				
				$date = explode('-',$post['wc_date_verified'][$i]);
				$date1		= $date[2].'-'.$date[0].'-'.$date[1];
				
			if($post['wc_date_verified'][$i]!='Rejected'){
				$WC_data['wc_date_verified']	= $today;//$date1;
				} else {
				$WC_data['wc_date_verified']	= $today;
				}

				//$WC_data['wc_upld_cert'] 			= $post['wc_upld_cert'][$i];

				//$WC_data['wc_date_verified'] 		= $today;
                              if($post['wc_radio'][$i+1] == '0'){

                                $WC_data['wc_status']			= '1';
                              } else if($post['wc_radio'][$i+1] == '1'){

                                $WC_data['wc_status']			= '1';
                              //  $WC_data['wc_date_verified'] 		= $today;
                              } else if($post['wc_radio'][$i+1] == '-1'){

                                $WC_data['wc_status']			= '-1';
                              } else if(!$post['wc_radio'][$i+1]) {
                                  $WCI_data['wc_status']			= '1';
                             }

				//$WC_data['wc_status'] 			= '1';

			/*	if($WC_files['name'][$i]!= '')

					{

						//code to update image filed in vendors table

						//code to move image to folderpath

						//$base_Dir = JPATH_COMPONENT.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS;

						$WC_No = $i+1;

						$WC_No	=	$post['current_line_task_WC_ids'][$i];

		  				$base_Dir = JPATH_COMPONENT.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'WC_'.$WC_No.DS;

						jimport('joomla.client.helper');
						if(is_dir($base_Dir))
						{
							$files = JFolder::files($base_Dir, '.', false, true, array());
							if (!empty($files)) {
									jimport('joomla.filesystem.file');
									if (JFile::delete($files) !== true) {
											// JFile::delete throws an error
											return false;
									}
							}
						}

			    		JFolder::create( $base_Dir );

						$WC_files['name'][$i] = str_replace(" ", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("%", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("#", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("&", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace(",", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("`", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("'", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("\\", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace(":", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("?", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("<", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace(">", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("/", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = ereg_replace("/", "_", $WC_files['name'][$i]);
						$WC_files['name'][$i] = str_replace("//", "_", $WC_files['name'][$i]);

						$WC_data['wc_upld_cert'] 		= $WC_files['name'][$i];

						$WC_data['wc_folder_id'] 		=	$WC_No;

						$filepath = $base_Dir .$WC_files['name'][$i];

						move_uploaded_file($WC_files['tmp_name'][$i], $filepath);

						$WC_arr[$w] = '<a href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&vndr='.$user->id.'&doc=WC_'.$WC_No.'&filename='.$WC_files["name"][$i] .'">'.$WC_files["name"][$i] .'</a>';

					$w++;

					} */

				//if($WC_data['id']	== '')
				//{

				//}


//echo '<pre>'; print_r($WC_data); exit;
				//echo "<pre>"; print_r($WC_data);
				//if($WC_data['wc_end_date'] != '')
				//{ $model->store_vendor_WC_compliances_info($WC_data); }
				$addw = $i + 1 ;
				if($saveddoc == 'WC'.$addw){
				$wc_vdate = $post['wc_date_verified'][$i] ;
				$wcexp = explode('-',$wc_vdate);
				$WC_data['wc_date_verified'] = $wcexp[2].'-'.$wcexp[0].'-'.$wcexp[1];
				
				//$WC_data['wc_date_verified'] 		= date('Y-m-d');
				}	
				else{
				$olddate ="select wc_date_verified from #__cam_vendor_workers_compansation Where id =".$post['old_line_task_wc_ids'][$i];
				$db->setQuery($olddate);
				$WC_data['wc_date_verified'] = $db->loadResult();
					if($WC_data['wc_date_verified'])
					$WC_data['wc_date_verified'] = $WC_data['wc_date_verified'] ;
					else
					$WC_data['wc_date_verified'] = $today ;
				}
				
				if($WC_data['wc_end_date']!='' && $WC_data['wc_end_date']!='--')  
				{
                 $model->store_vendor_WC_compliances_info($WC_data);
                }

		 } //exit;
		  //echo '<pre>'; print_r($post);
		// echo '<pre>'; print_r($post['WCI_date_verified']);
		$WCI_files		= JRequest::getVar('WCI_upld_cert','','files','array' );
		for($i=0,$w=0; $i<count($post['old_line_task_WCI_ids']); $i++)
		{
			//code to store WCI data
				$WCI_data['id']						= $post['old_line_task_WCI_ids'][$i];
				$WCI_data['vendor_id']				= $vendor_user->id;
				$WCI_data['WCI_name'] 				= $post['WCI_name'][$i];
				$WCI_data['WCI_policy'] 			= $post['WCI_policy'][$i];
				
				$date = explode('-',$post['WCI_start_date'][$i]);
				$WCI_data['WCI_start_date'] 			= $date[2].'-'.$date[0].'-'.$date[1];
				
				if (strpos($post['WCI_end_date'][$i], 'Does Not Expire') !== false){
				$WCI_data['WCI_end_date'] 		= 'Does Not Expire';
				}
				else{
				$date = explode('-',$post['WCI_end_date'][$i]);
				$WCI_data['WCI_end_date'] 		= $date[2].'-'.$date[0].'-'.$date[1];
				}
				
				
				
				$WCI_data['WCI_agent_first_name'] 	= $post['WCI_agent_first_name'][$i];
				$WCI_data['WCI_agent_last_name'] 	= $post['WCI_agent_last_name'][$i];
				$WCI_data['WCI_phone_number'] 		= $post['WCI_phone1'][$i].'-'.$post['WCI_phone2'][$i].'-'.$post['WCI_phone3'][$i];
				//$WCI_data['WCI_upld_cert'] 			= $post['WCI_upld_cert'][$i];
                               // if($post['WCI_radio'][$i+1]){
				//$WCI_data['WCI_status']			= $post['WCI_radio'][$i+1];
				$date = explode('-',$post['WCI_date_verified'][$i]);
				$date1 		= $date[2].'-'.$date[0].'-'.$date[1];
				if($post['WCI_date_verified'][$i]!='Rejected'){
				$WCI_data['WCI_date_verified']	= $today;//$date1;
				} else {
				$WCI_data['WCI_date_verified']	= $today;
				}
                                if($post['WCI_radio'][$i+1] == '0'){
                                $WCI_data['WCI_status']			= '1';
                              } else if($post['WCI_radio'][$i+1] == '1'){

                                $WCI_data['WCI_status']			= '1';
                               // $WCI_data['WCI_date_verified'] = $today;
                              } else if($post['WCI_radio'][$i+1] == '-1'){

                                $WCI_data['WCI_status']			= '-1';
                              } else if(!$post['WCI_radio'][$i+1]) {
                                  $WCI_data['WCI_status']			= '1';
                             }
                               // } else {
                                //    $WCI_data['WCI_status']			= '1';
                               // }
                                // $WCI_data['WCI_status']			= '1';
				//$WCI_data['excemption'] 			= $post['excemption'][$i];
				
				if($post['excemption'][$i]){
				$WCI_data['excemption'] 			= $post['excemption'][$i];
				} else {
				$WCI_data['excemption'] ='0';
				}
				/*if($WCI_files['name'][$i]!= '')
					{
						//code to update image filed in vendors table
						//code to move image to folderpath
						//$base_Dir = JPATH_COMPONENT.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS;
						$WCI_No = $i+1;
						$WCI_No	=	$post['current_line_task_WCI_ids'][$i];
		  				$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'WCI_'.$WCI_No.DS;
						// Remove all the files in folder if they exist
						jimport('joomla.client.helper');
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if(is_dir($base_Dir))
					   {
						$files = JFolder::files($base_Dir, '.', false, true, array());
							if (!empty($files)) {
									jimport('joomla.filesystem.file');
									if (JFile::delete($files) !== true) {
											// JFile::delete throws an error
											return false;
									}
							}
					    }
			    		JFolder::create( $base_Dir );
						$WCI_files['name'][$i] = str_replace(" ", "_", $WCI_files['name'][$i]);
						$WCI_files['name'][$i] = str_replace("&", "_", $WCI_files['name'][$i]);
						$WCI_files['name'][$i] = str_replace("#", "_", $WCI_files['name'][$i]);
						$WCI_files['name'][$i] = str_replace("%", "_", $WCI_files['name'][$i]);
						$WCI_files['name'][$i] = str_replace("`", "_", $WCI_files['name'][$i]);
						$WCI_files['name'][$i] = str_replace("'", "_", $WCI_files['name'][$i]);
						$WCI_files['name'][$i] = str_replace("\\", "_", $WCI_files['name'][$i]);


						$filepath = $base_Dir .$WCI_files['name'][$i];
						move_uploaded_file($WCI_files['tmp_name'][$i], $filepath);
						$WCI_data['WCI_upld_cert'] 			= $WCI_files['name'][$i];
						$WCI_data['WCI_folder_id'] 		=	$WCI_No;
						//$WCI_data['WCI_status'] 			= '1';
						$WCI_data['WCI_date_verified'] 		= $today;
						$flag = 1;
					} */

				/*if($WCI_data['WCI_date_verified'] == '0000-00-00')
				$WCI_data['WCI_date_verified'] = $today;*/
				//echo "<pre>"; print_r($WCI_data); 
				//if($WCI_data['WCI_policy'] != '' || $WCI_files['name'][$i]!= '' || $WCI_data['WCI_name'] != '' || $WCI_data['WCI_start_date'] != '' || $WCI_data['WCI_end_date'] != '' || $WCI_data['WCI_agent_first_name'] != '' ||  $WCI_data['WCI_agent_last_name'] != '' || $WCI_data['WCI_phone_number'] != '' || $WCI_data['WCI_upld_cert'] != '')
				//{ $model->store_vendor_WCI_compliances_info($WCI_data); }
				
				//For master completed by sateesh
				$WCI_data['WCI_disease']	= str_replace(",","",$post['WCI_disease'][$i]);
				$WCI_data['WCI_disease_policy']	= str_replace(",","",$post['WCI_disease_policy'][$i]);
				$WCI_data['WCI_each_accident']	= str_replace(",","",$post['WCI_each_accident'][$i]);
				$WCI_waiver = JRequest::getVar('WCI_waiver'.$i);
				if($WCI_waiver)
				$WCI_waiver = $WCI_waiver ;
				else
				$WCI_waiver = '';
				$WCI_data['WCI_waiver']	= $WCI_waiver;
				$WCI_cert = JRequest::getVar('WCI_cert'.$i);
				$WCI_data['WCI_cert']	= $WCI_cert;
				//Master completed by sateesh
				
				$add = $i + 1 ;
				if($saveddoc == 'WCI'.$add){
				$wci_vdate = $post['WCI_date_verified'][$i] ;
				$wciexp = explode('-',$wci_vdate);
				$WCI_data['WCI_date_verified'] = $wciexp[2].'-'.$wciexp[0].'-'.$wciexp[1];
				//$WCI_data['WCI_date_verified'] 		= date('Y-m-d');
				}	
				else{
				$olddate ="select WCI_date_verified from #__cam_vendor_workers_companies_insurance Where id =".$post['old_line_task_WCI_ids'][$i];
				$db->setQuery($olddate);
				$WCI_data['WCI_date_verified'] = $db->loadResult();
					if($WCI_data['WCI_date_verified'])
					$WCI_data['WCI_date_verified'] = $WCI_data['WCI_date_verified'] ;
					else
					$WCI_data['WCI_date_verified'] = $today ;
				}
				
				if($WCI_data['WCI_end_date']!='' && $WCI_data['WCI_end_date']!='--')  
				{
				$model->store_vendor_WCI_compliances_info($WCI_data);
				}
		 }
		 $aip_files		= JRequest::getVar('aip_upld_cert','','files','array' );
		 for($i=0,$w=0; $i<count($post['old_line_task_aip_ids']); $i++)

		{

			//code to store WCI data

				$aip_data['id']						= $post['old_line_task_aip_ids'][$i];

				$aip_data['vendor_id']				= $vendor_user->id;

				$aip_data['aip_name'] 				= $post['aip_name'][$i];

				$aip_data['aip_policy'] 			= $post['aip_policy'][$i];

				$date = explode('-',$post['aip_start_date'][$i]);

				$aip_data['aip_start_date'] 		= $date[2].'-'.$date[0].'-'.$date[1];

				$date = explode('-',$post['aip_end_date'][$i]);

				$aip_data['aip_end_date'] 			= $date[2].'-'.$date[0].'-'.$date[1];

				$aip_data['aip_agent_first_name'] 	= $post['aip_agent_first_name'][$i];

				$aip_data['aip_agent_last_name'] 	= $post['aip_agent_last_name'][$i];

				$aip_data['aip_phone_number'] 		= $post['aip_phone1'][$i].'-'.$post['aip_phone2'][$i].'-'.$post['aip_phone3'][$i];

				//$WCI_data['WCI_upld_cert'] 			= $post['WCI_upld_cert'][$i];

				//$WCI_data['WCI_date_verified'] 		= $post['WCI_date_verified'][$i];

			//	$WCI_data['WCI_status'] 			= '1';
			$date = explode('-',$post['aip_date_verified'][$i]);
				$date1 		= $date[2].'-'.$date[0].'-'.$date[1];
				if($post['aip_date_verified'][$i]!='Rejected'){
				$aip_data['aip_date_verified']	= $today;//$date1;
				} else {
				$aip_data['aip_date_verified']	= $today;
				}
				
			/*if($post['aip_status'][$i]=='-1'){
				$aip_data['aip_status']   = '-1';
				} else {
				$aip_data['aip_status']   = '1';
				}*/
				
				 if($post['AIP_radio'][$i+1] == '0'){
                                $aip_data['aip_status']			= '1';
                              } else if($post['AIP_radio'][$i+1] == '1'){

                                $aip_data['aip_status']			= '1';
                               // $WCI_data['WCI_date_verified'] = $today;
                              } else if($post['AIP_radio'][$i+1] == '-1'){

                                $aip_data['aip_status']			= '-1';
                              } else if(!$post['AIP_radio'][$i+1]) {
                                  $aip_data['aip_status']			= '1';
                             }
							 
				
				if($post['excemption'][$i]){
				$aip_data['excemption'] 			= $post['excemption'][$i];
				} else {
				$aip_data['excemption'] ='0';
				}
				//echo '<pre>'; print_r($aip_data); 
				
				//For master completed by sateesh
				$aip_data['aip_bodily']	= str_replace(",","",$post['aip_bodily'][$i]);
				$aip_data['aip_combined']	= str_replace(",","",$post['aip_combined'][$i]);
				$aip_data['aip_body_injury']	= str_replace(",","",$post['aip_body_injury'][$i]);
				$aip_data['aip_property']	= str_replace(",","",$post['aip_property'][$i]);
				$aip_cert = JRequest::getVar('aip_cert'.$i);
				$aip_data['aip_cert']	= $aip_cert;
				$aip_primary = JRequest::getVar('aip_primary'.$i);

				if($aip_primary)
				$aip_primary = $aip_primary ;
				else
				$aip_primary = '';
				
				$aip_data['aip_primary']	= $aip_primary;
				$aip_waiver = JRequest::getVar('aip_waiver'.$i);
				
				if($aip_waiver)
				$aip_waiver = $aip_waiver ;
				else
				$aip_waiver = '';
				
				$aip_data['aip_waiver']	= $aip_waiver;
				$aip_addition = JRequest::getVar('aip_addition'.$i);
				$aip_data['aip_addition']	= $aip_addition;
				
				
				$aip_applies_any = JRequest::getVar('aip_applies_any'.$i);
				$aip_data['aip_applies_any']	= $aip_applies_any;
				if($aip_data['aip_applies_any'])
				$aip_data['aip_applies_any'] = $aip_data['aip_applies_any'] ;
				else
				$aip_data['aip_applies_any'] = '';
				
				$aip_applies_owned = JRequest::getVar('aip_applies_owned'.$i);
				$aip_data['aip_applies_owned']	= $aip_applies_owned;
				if($aip_data['aip_applies_owned'])
				$aip_data['aip_applies_owned'] = $aip_data['aip_applies_owned'] ;
				else
				$aip_data['aip_applies_owned'] = '';
				
				$aip_applies_nonowned = JRequest::getVar('aip_applies_nonowned'.$i);
				$aip_data['aip_applies_nonowned']	= $aip_applies_nonowned;
				if($aip_data['aip_applies_nonowned'])
				$aip_data['aip_applies_nonowned'] = $aip_data['aip_applies_nonowned'] ;
				else
				$aip_data['aip_applies_nonowned'] = '';
				
				
				$aip_applies_hired = JRequest::getVar('aip_applies_hired'.$i);
				$aip_data['aip_applies_hired']	= $aip_applies_hired;
				if($aip_data['aip_applies_hired'])
				$aip_data['aip_applies_hired'] = $aip_data['aip_applies_hired'] ;
				else
				$aip_data['aip_applies_hired'] = '';
				
				$aip_applies_scheduled = JRequest::getVar('aip_applies_scheduled'.$i);
				$aip_data['aip_applies_scheduled']	= $aip_applies_scheduled;
				if($aip_data['aip_applies_scheduled'])
				$aip_data['aip_applies_scheduled'] = $aip_data['aip_applies_scheduled'] ;
				else
				$aip_data['aip_applies_scheduled'] = '';
				
				//Master completed by sateesh
				//echo "<pre>"; print_r($aip_data);
				
				$adda = $i + 1 ;
				if($saveddoc == 'AIP'.$adda){
				$aip_vdate = $post['aip_date_verified'][$i] ;
				$aipexp = explode('-',$aip_vdate);
				$aip_data['aip_date_verified'] = $aipexp[2].'-'.$aipexp[0].'-'.$aipexp[1];
				//$aip_data['aip_date_verified']    = date('Y-m-d');
				}	
				else{
				$olddate ="select aip_date_verified from #__cam_vendor_auto_insurance Where id =".$post['old_line_task_aip_ids'][$i];
				$db->setQuery($olddate);
				$aip_data['aip_date_verified'] = $db->loadResult();
					if($aip_data['aip_date_verified'])
					$aip_data['aip_date_verified'] = $aip_data['aip_date_verified'] ;
					else
					$aip_data['aip_date_verified'] = $today ;
				}
				
				if($aip_data['aip_end_date']!='' && $aip_data['aip_end_date']!='--')  
					{
						$model->store_vendor_aip_compliances_info($aip_data);
					}
		}
		 //exit;
		 
		 //Started saving Umbrella docs
		$UMB_files		= JRequest::getVar('UMB_upld_cert','','files','array' );
   
		for($i=0; $i<count($post['old_line_task_UMB_ids']); $i++)
		{
				$UMB_data['id']					= $post['old_line_task_UMB_ids'][$i];
				$UMB_data['vendor_id']			= $vendor_user->id;
				$UMB_data['UMB_license'] 		= $post['UMB_license'][$i];
				$date = explode('-',$post['UMB_expdate'][$i]);
				$UMB_data['UMB_expdate']		= $date[2].'-'.$date[0].'-'.$date[1];
				$UMB_data['UMB_city_country'] 	= '';
				//$OLN_data['OLN_upld_cert'] 		= $post['OLN_upld_cert'][$i];
				$UMB_data['UMB_state'] 			= '';
				//$OLN_data['OLN_status'] 		= '1';
				if($post['UMB_radio'][$i+1] == '0'){
                                $UMB_data['UMB_status']			= '1';
                              } 
							  else if($post['UMB_radio'][$i+1] == '1'){

                                $UMB_data['UMB_status']			= '1';
                               // $WCI_data['WCI_date_verified'] = $today;
                              } 
							  else if($post['UMB_radio'][$i+1] == '-1'){

                                $UMB_data['UMB_status']			= '-1';
                              } else if(!$post['UMB_radio'][$i+1]) {
                                  $UMB_data['UMB_status']			= '1';
                             }
							 
                              // $date8 = date('Y-m-d');
				if($UMB_data['id']	== '')
				{
				$UMB_data['UMB_date_verified']	= '0000-00-00';
				//} else {
                               // $OLN_data['OLN_date_verified']	= $date8;
                  }

				//echo "<pre>"; print_r($OLN_data); exit;
				//if($OLN_data['OLN_expdate'] != '' )
				$addo = $i + 1 ;
				if($saveddoc == 'UMB'.$addo){
				$umb_vdate = $post['UMB_date_verified'][$i] ;
				$umbexp = explode('-',$umb_vdate);
				$UMB_data['UMB_date_verified'] = $umbexp[2].'-'.$umbexp[0].'-'.$umbexp[1];
				//$UMB_data['UMB_date_verified']	= date('Y-m-d');
				}	
				else{
				$olddate ="select UMB_date_verified from #__cam_vendor_umbrella_license Where id =".$post['old_line_task_UMB_ids'][$i];
				$db->setQuery($olddate);
				$UMB_data['UMB_date_verified'] = $db->loadResult();
					if($UMB_data['UMB_date_verified'])
					$UMB_data['UMB_date_verified'] = $UMB_data['UMB_date_verified'] ;
					else
					$UMB_data['UMB_date_verified'] = $today ;
				}

				//For master completed by sateesh
				$UMB_data['UMB_aggregate']	= str_replace(",","",$post['UMB_aggregate'][$i]);
				$UMB_data['UMB_occur']	= str_replace(",","",$post['UMB_occur'][$i]);
				$UMB_certholder = JRequest::getVar('umb_cert'.$i);
				$UMB_data['UMB_certholder']	= $UMB_certholder;

				//Master completed by sateesh

				if($UMB_data['UMB_expdate']!='' && $UMB_data['UMB_expdate']!='--') {
				$model->store_vendor_UMB_compliances_info($UMB_data);
				}
                              //  $model->store_vendor_OLN_compliances_info($OLN_data);

		}
		
		$OMI_files		= JRequest::getVar('OMI_upld_cert','','files','array' );
   
		for($i=0; $i<count($post['old_line_task_OMI_ids']); $i++)
		{
				$OMI_data['id']					= $post['old_line_task_OMI_ids'][$i];
				$OMI_data['vendor_id']			= $vendor_user->id;
				//$OMI_data['OMI_license'] 		= $post['OMI_license'][$i];
				$date = explode('-',$post['OMI_end_date'][$i]);
				$OMI_data['OMI_end_date']		= $date[2].'-'.$date[0].'-'.$date[1];
				$OMI_data['OMI_city_country'] 	= '';
				//$OLN_data['OLN_upld_cert'] 		= $post['OLN_upld_cert'][$i];
				$OMI_data['OMI_state'] 			= '';
				//$OLN_data['OLN_status'] 		= '1';
				if($post['OMI_radio'][$i+1] == '0'){
                                $OMI_data['OMI_status']			= '1';
                              } 
							  else if($post['OMI_radio'][$i+1] == '1'){

                                $OMI_data['OMI_status']			= '1';
                               // $WCI_data['WCI_date_verified'] = $today;
                              } 
							  else if($post['OMI_radio'][$i+1] == '-1'){

                                $OMI_data['OMI_status']			= '-1';
                              } else if(!$post['OMI_radio'][$i+1]) {
                                  $OMI_data['OMI_status']			= '1';
                             }
							 
                              // $date8 = date('Y-m-d');
				if($OMI_data['id']	== '')
				{
				$OMI_data['OMI_date_verified']	= '0000-00-00';
				//} else {
                               // $OLN_data['OLN_date_verified']	= $date8;
                  }

				//echo "<pre>"; print_r($OLN_data); exit;
				//if($OLN_data['OLN_expdate'] != '' )
				$addo = $i + 1 ;
				if($saveddoc == 'OMI'.$addo){
				$omi_vdate = $post['OMI_date_verified'][$i] ;
				$omiexp = explode('-',$omi_vdate);
				$OMI_data['OMI_date_verified'] = $omiexp[2].'-'.$omiexp[0].'-'.$omiexp[1];
				//$OMI_data['OMI_date_verified']	= date('Y-m-d');
				}	
				else{
				$olddate ="select OMI_date_verified from #__cam_vendor_errors_omissions_insurance Where id =".$post['old_line_task_OMI_ids'][$i];
				$db->setQuery($olddate);
				$OMI_data['OMI_date_verified'] = $db->loadResult();
					if($OMI_data['OMI_date_verified'])
					$OMI_data['OMI_date_verified'] = $OMI_data['OMI_date_verified'] ;
					else
					$OMI_data['OMI_date_verified'] = $today ;
				}

				//For master completed by sateesh
				$OMI_data['OMI_aggregate']	= str_replace(",","",$post['OMI_aggregate'][$i]);
				$OMI_data['OMI_each_claim']	= str_replace(",","",$post['OMI_each_claim'][$i]);
				$OMI_cert = JRequest::getVar('omi_cert'.$i);
				$OMI_data['OMI_cert']	= $OMI_cert;

				//Master completed by sateesh

				if($OMI_data['OMI_end_date']!='' && $OMI_data['OMI_end_date']!='--') {
				$model->store_vendor_OMI_compliances_info($OMI_data);
				}
                              //  $model->store_vendor_OLN_compliances_info($OLN_data);

		}
		
		// exit;
		 /***************************************************************W9 CODE*********************************************************************/
		$W9files		= JRequest::getVar('W9_upld_cert','','files','array' );
		$w9docname = JRequest::getVar('W9_upld_cert1','');
		//$W9_data['w9_upld_cert'] 			= $post['W9_upld_cert1'];
		//$W9_data['w9_status'] 			= '1';
			   // echo '<pre>'; print_r($W9files); exit;
		//if($W9files['name'] != '')
		/*if($w9docname != '')
		{
					//code to update image filed in vendors table
					$base_Dir = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendorname.DS.'W9'.DS;
					// Remove all the files in folder if they exist
					jimport('joomla.client.helper');
					if(is_dir($base_Dir))
					{
						$files = JFolder::files($base_Dir, '.', false, true, array());
						if (!empty($files)) {
								jimport('joomla.filesystem.file');
								if (JFile::delete($files) !== true) {
										// JFile::delete throws an error
										return false;
								}
						}
					}
					JFolder::create( $base_Dir );
					$W9files['name'] = str_replace(" ", "_", $W9files['name']);
					$W9files['name'] = str_replace("&", "_", $W9files['name']);
					$W9files['name'] = str_replace("#", "_", $W9files['name']);
					$W9files['name'] = str_replace("%", "_", $W9files['name']);
					$W9files['name'] = str_replace("`", "_", $W9files['name']);
					$W9files['name'] = str_replace("'", "_", $W9files['name']);
					$W9files['name'] = str_replace("\\", "_", $W9files['name']);
//					echo $W9files['name']; exit;
					$filepath = $base_Dir .$W9files['name'];
					move_uploaded_file($W9files['tmp_name'], $filepath);
                                        if($W9files['name']){
					$W9_data['w9_upld_cert'] = $W9files['name'];
                                        } else {
                                        $W9_data['w9_upld_cert'] 			= $post['W9_upld_cert1'];
                                        }

*/

					if(!$post['w9_radio']){
					$W9_data['w9_status'] 			='1';
					} else {
					$W9_data['w9_status'] 			=$post['w9_radio'];
					}
                                        //} else {
                                        // $W9_data['w9_status'] 		='1';
                                       // }
                                       //echo '<pre>'; print_r($_REQUEST);
                    $dW91	= JRequest::getVar('dW91','');
                    if($post['W9_id']){
					$W9_data['id']				= $post['W9_id'];
					} else {
					$W9_data['id']				=  $dW91;
					}
					
 					$W9_data['ein_number']			= $post['ein_number'];
					$W9_data['vendor_id']			= $vendor_user->id;
				//echo "<pre>"; print_r($post['w9_date_verified']);	//$W9_data['w9_date_verified'] 		= $today;
				$date = explode('-',$post['w9_date_verified']);
				$date1 		= $date[2].'-'.$date[0].'-'.$date[1];
				if($post['w9_date_verified']!='Rejected'){
				$W9_data['w9_date_verified']	= $date1;
				} else {
				$W9_data['w9_date_verified']	= $post['w9_date_verified'];
				}
					$flag = 1;
					//echo "<pre>"; print_r($W9_data); exit;
                                        //echo "<pre>"; print_r($_REQUEST);
					//echo "<pre>"; print_r($W9_data);  exit;
			//$query = "UPDATE #__cam_vendor_compliance_w9docs SET W9_date_verified = '".$W9_data['w9_date_verified']."' ,W9_status =".$W9_data['w9_status'].", ein_number='".$W9_data['ein_number']."' WHERE vendor_id=".$W9_data['vendor_id']; 
			//$db->setQuery($query);
			//$db->query();
			
				$model->store_vendor_compliance_w9docs_info($W9_data);
				
				// }
		//exit;
		if($flag == 1)
		{
		 $db = JFactory::getDBO();	
		 $mailfrom = 'support@myvendorcenter.com';
		 $to = $vendor_user->email;
		 $subject = 'Compliance Documents Approved.';
		 //$msg = '<br/><br/>Hello '.$vendor_user->name.'&nbsp;'.$vendor_user->lastname.' !<br/><br/>Congratulations! Your mandatory Compliance Documents have been verified and meet our basic requirements. Please keep this information current in order to receive RFPs that require corresponding Compliance Documentation.<br/><br/>You are now eligible to receive email RFP notifications as soon as they become available. Please note that by uploading additional documents, you can increase your eligibility for RFPs.<br/><br/>Happy bidding!<br/><br/>At Your Service,<br/>The CAMassistant.com Team';
		$message = "SELECT introtext FROM #__content WHERE  id=245";
		$db->setQuery($message);
		$msg = $db->loadResult();
		$msg = str_replace('{vendor name}',$companyname_v,$msg);
		//$res = JUtility::sendMail($mailfrom, '', $to, $subject, $msg, $mode=1);

		  //Sending emails to vendor cc persons
		$db = JFactory::getDBO();
	    $query_cc ="select ccemail from #__users Where id =".$vendor_user->id;
		$db->setQuery($query_cc);
		$cc = $db->loadResult();
		$cclist = explode(';',$cc);
		for($c=0; $c<=count($cclist); $c++){
		$listcc = $cclist[$c];
		if($listcc != '') {
		//$res = JUtility::sendMail($mailfrom, '', $listcc, $subject, $msg, $mode=1);
		}
		}
		//exit;
		//Completed
		}
		//$link = 'index.php?option=com_camassistant&controller=vendorcompliances&Itemid='.$Itemid;
		$link = "index.php?option=com_camassistant&controller=vendorcompliances_details&task=vendor_compliance_docs&userid=".$vendor_user->id."";
		$msg="Documents Saved Successfully";
		$this->setRedirect( $link,$msg );
		//JRequest::getVar('view','vendors');
	    //parent::display();
	}
	/*************************************************** Add/ Edit Vendor compliance related functions **************************************/
	// function edit
	function edit()
	{
		parent::display();
	}

	// function vendorcompliances_details  /* anil 20-07-2011 */
	function vendorcompliancesdetails()
	{
		JRequest::getVar('view', 'vendorreject');
		parent::display();
	}

	function reject()
	{
		$post	= JRequest::get('post');
		$mailfrom = 'support@camassistant.com';
		$fromname = 'MyVendorCenter Team';
		$recipient = $post['recipient'];
		$vendorname = $post['name'].'&nbsp;'.$post['lastname'];
		$mailsubject = 'MyVendorCenter Compliance Document Rejected';
		//$name = $post['name'];
		//$lastname = $post['lastname'];
		//$body = "Hello ".$name.'&nbsp;'.$lastname.'<br/><br/>';
		//$body = $post['reject_body'];
		//$body .= '<br/><br/>At Your Service <br/> CAMassistant.com';
		$db = JFactory::getDBO();
		$sql = "SELECT introtext FROM #__content   where id=175";
		$db->Setquery($sql);
		$introtext=$db->loadResult();
		
		$vendor_subscribe = "SELECT subscribe  FROM #__users where id=".$_REQUEST['userid']."";
		$db->setQuery($vendor_subscribe);
		$subscribe = $db->loadResult();
	
		if($subscribe == 'yes'){
	
		$body = str_replace('{Vendor Name}',$vendorname,$introtext);
		JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1) ;
		$to_support = 'vendoremails@myvendorcenter.com';
		JUtility::sendMail($mailfrom, $fromname, $to_support, $mailsubject, $body,$mode = 1) ;
		  //Sending emails to vendor cc persons
		$db = JFactory::getDBO();
	    $query_cc ="select ccemail from #__users Where id =".$_REQUEST['userid'];
		$db->setQuery($query_cc);
		$cc = $db->loadResult();
		$cclist = explode(';',$cc);
		for($c=0; $c<=count($cclist); $c++){
		$listcc = $cclist[$c];
		if($listcc != '') {
		$res = JUtility::sendMail($mailfrom, $fromname, $listcc, $mailsubject, $body, $mode=1);
		}
		}
		}
		//exit;
		//Completed


		echo "<script type='text/javascript'>
				window.parent.document.getElementById( 'sbox-window' ).close();
			  </script>";
		exit;
	}

	  /* anil 20-07-2011 */



	 //function to open document
	function view_upld_cert()
	{
		$userid = JRequest::getVar('user_id','');
		$user	= JFactory::getUser($userid);
		$db = JFactory::getDBO();
		//echo "<pre>"; print_r($_REQUEST);
		$sql = "SELECT tax_id FROM #__cam_vendor_company   WHERE user_id=".$user->id;
		$db->setQuery($sql);
		$tax_id = $db->loadResult();
		$vendorname = $user->name.'_'.$user->lastname.'_'.$tax_id;
		$vendorname = str_replace(' ','_',$vendorname);
		$doc_type = JRequest::getVar('doc','');

		$filename = JRequest::getVar('filename','');
		//$path = JURI::root().'components/com_camassistant/assets/images/vendorcompliances';
		 $path = JURI::root().'components/com_camassistant/assets/images/vendorcompliances/'.$vendorname.'/'.$doc_type;

		$doc_name = JURI::root()."/".$path;
		if($doc_type){
		$doc_name = $path.'/'.$filename;
		} else {
		$doc_name = JURI::root()."/".$filename;
		}
              // echo '<br/>'; echo '<pre>'; print_r($doc_name); exit;
		header("content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$filename);
		readfile($doc_name);
		exit;
		//parent::display();
	}
	// function save

	function save()
	{

		$task = JRequest::getCmd( 'task' );
		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$db		= &JFactory::getDBO();
		$post['id'] = $cid[0];
		$query = "SELECT name,email,lastname FROM #__users  WHERE id=".$post['id'];
		$db->setQuery($query);
		$user = $db->loadObjectList();
		$query_company = "SELECT company_name FROM #__cam_vendor_company  WHERE user_id=".$post['id'];
		$db->setQuery($query_company);
		$companyname = $db->loadResult();
		
		$today = date('Y-m-d');
		$model = $this->getModel('vendorcompliancaes_details');


		//echo "<pre>"; print_r($post); exit;
		//code to update OLN table
		for($i=0; $i<count($post['OLN_radio']); $i++)
		{
			 /*$today='';
			 if($post['OLN_date_verified'][$i] == '0000-00-00' &&  $post['OLN_radio'][$i] != '0' )
			 $today = date('Y-m-d');
			 else if($post['OLN_date_verified'][$i] != '0000-00-00' && ($post['OLN_radio'][$i] == '0' || $post['OLN_radio'][$i] == '-1' || $post['OLN_radio'][$i] == '1'))
			 $today = date('Y-m-d');
			 else
			 $today = $post['OLN_date_verified'][$i];*/
			 //code to get OLN files, status
			$sql = "SELECT OLN_status,OLN_date_verified FROM #__cam_vendor_occupational_license  WHERE id=".$post['OLN_ids'][$i];
			$db->setQuery($sql);
			$OLN_docs = $db->loadObjectList();
			if($OLN_docs[0]->OLN_status == $post['OLN_radio'][$i])
			$today = $OLN_docs[0]->OLN_date_verified;
			else
			$today = date('Y-m-d');
			$query = "UPDATE #__cam_vendor_occupational_license SET OLN_date_verified = '".$today."' , OLN_status =".$post['OLN_radio'][$i]." WHERE id=".$post['OLN_ids'][$i];
			$db->setQuery($query);
			$db->query();
		}
		//code to update PLN table
		for($i=0; $i<count($post['PLN_radio']); $i++)
		{
			/* $today='';
			 if($post['PLN_date_verified'][$i] == '0000-00-00' &&  $post['PLN_radio'][$i] != '0' )
			 $today = date('Y-m-d');
			 else if($post['PLN_date_verified'][$i] != '0000-00-00' && ($post['PLN_radio'][$i] == '0' || $post['PLN_radio'][$i] == '-1' || $post['PLN_radio'][$i] == '1'))
			 $today = date('Y-m-d');
			 else
			 $today = $post['PLN_date_verified'][$i];*/
			$sql = "SELECT PLN_status,PLN_date_verified FROM #__cam_vendor_professional_license  WHERE id=".$post['PLN_ids'][$i];
			$db->setQuery($sql);
			$PLN_docs = $db->loadObjectList();
			if($PLN_docs[0]->PLN_status == $post['PLN_radio'][$i])
			$today = $PLN_docs[0]->PLN_date_verified;
			else
			$today = date('Y-m-d');
			 $query = "UPDATE #__cam_vendor_professional_license SET PLN_date_verified = '".$today."' , PLN_status =".$post['PLN_radio'][$i]." WHERE id=".$post['PLN_ids'][$i];
			$db->setQuery($query);
			$db->query();
		}
		//code to update GLI table
		for($i=0; $i<count($post['GLI_radio']); $i++)
		{
			/* $today='';
			 if($post['GLI_date_verified'][$i] == '0000-00-00' &&  $post['GLI_radio'][$i] != '0' )
			 $today = date('Y-m-d');
			 else if($post['GLI_date_verified'][$i] != '0000-00-00' && ($post['GLI_radio'][$i] == '0' || $post['GLI_radio'][$i] == '-1' || $post['GLI_radio'][$i] == '1'))
			 $today = date('Y-m-d');
			 else
			 $today = $post['GLI_date_verified'][$i];*/
			 $sql = "SELECT GLI_status,GLI_date_verified FROM #__cam_vendor_liability_insurence  WHERE id=".$post['GLI_ids'][$i];
			$db->setQuery($sql);
			$GLI_docs = $db->loadObjectList();
			if($GLI_docs[0]->GLI_status == $post['GLI_radio'][$i])
			$today = $GLI_docs[0]->GLI_date_verified;
			else
			$today = date('Y-m-d');
			$query = "UPDATE #__cam_vendor_liability_insurence SET GLI_date_verified = '".$today."' ,GLI_status =".$post['GLI_radio'][$i]." WHERE id=".$post['GLI_ids'][$i];
			$db->setQuery($query);
			$db->query();
			if($post['GLI_radio'][0] == 1)
			$flag=0;
		}
		//code to update WCI table
		for($i=0; $i<count($post['WCI_radio']); $i++)
		{
			/* $today='';
			 if($post['WCI_date_verified'][$i] == '0000-00-00' &&  $post['WCI_radio'][$i] != '0' )
			 $today = date('Y-m-d');
			 else if($post['WCI_date_verified'][$i] != '0000-00-00' && ($post['WCI_radio'][$i] == '0' || $post['WCI_radio'][$i] == '-1' || $post['WCI_radio'][$i] == '1'))
			 $today = date('Y-m-d');
			 else
			 $today = $post['WCI_date_verified'][$i];*/
			$sql = "SELECT WCI_status,WCI_date_verified FROM #__cam_vendor_workers_companies_insurance  WHERE id=".$post['WCI_ids'][$i];
			$db->setQuery($sql);
			$WCI_docs = $db->loadObjectList();
			if($WCI_docs[0]->WCI_status == $post['WCI_radio'][$i])
			$today = $WCI_docs[0]->WCI_date_verified;
			else
			$today = date('Y-m-d');
			$query = "UPDATE #__cam_vendor_workers_companies_insurance SET WCI_date_verified = '".$today."' , WCI_status =".$post['WCI_radio'][$i]." WHERE id=".$post['WCI_ids'][$i];
			$db->setQuery($query);
			$db->query();
		}
			 /*if($post['w9_date_verified'] == '0000-00-00' &&  $post['w9_radio'] != '0' )
			 $today = date('Y-m-d');
			 else if($post['w9_date_verified'] != '0000-00-00' && ($post['w9_radio'] == '0' || $post['w9_radio'] == '-1' || $post['w9_radio'] == '1'))
			 $today = date('Y-m-d');
			 else
			 $today = $post['w9_date_verified'][$i];*/
			 $sql = "SELECT w9_status,w9_date_verified FROM #__cam_vendor_compliance_w9docs  WHERE id=".$post['w9_ids'];
			$db->setQuery($sql);
			$w9_docs = $db->loadObjectList();
			if($w9_docs[0]->w9_status == $post['w9_radio'])
			$today = $w9_docs[0]->w9_date_verified;
			else
			$today = date('Y-m-d');
			$query = "UPDATE #__cam_vendor_compliance_w9docs SET w9_date_verified = '".$today."' , w9_status =".$post['w9_radio']." WHERE id=".$post['w9_ids'];
			$db->setQuery($query);
			$db->query();
		if($post['w9_radio'] == 1 && $flag == 0)
		{
		 $mailfrom = 'support@camassistant.com';
		 $to = $user[0]->email;
		 $subject = 'Compliance Documents Approved.';
		// $msg = '<br/><br/>Hello '.$user[0]->name.'&nbsp;'.$user[0]->lastname.'<br/><br/>Congratulations! Your mandatory Compliance Documents have been verified and meet our basic requirements. Please keep this information current in order to receive RFPs that require corresponding Compliance Documentation.<br/><br/>You are now eligible to receive email RFP notifications as soon as they become available. Please note that by uploading additional documents, you can increase your eligibility for RFPs.<br/><br/>Happy bidding!<br/><br/>At Your Service,<br/>The CAMassistant.com Team';
		$message = "SELECT introtext FROM #__content WHERE  id=245";
		$db->setQuery($message);
		$msg = $db->loadResult();
		$msg = str_replace('{vendor name}',$companyname,$msg);
		
		// $res = JUtility::sendMail($mailfrom, '', $to, $subject, $msg, $mode=1);

		  //Sending emails to vendor cc persons
		$db = JFactory::getDBO();
	    $query_cc ="select ccemail from #__users Where id =".$post['id'];
		$db->setQuery($query_cc);
		$cc = $db->loadResult();
		$cclist = explode(';',$cc);
		for($c=0; $c<count($cclist); $c++){
		$listcc = $cclist[$c];
		if($listcc != '') {
		//$res = JUtility::sendMail($mailfrom, '', $listcc, $subject, $msg, $mode=1);
		}
		}

		//Completed

		}
		$msg = 'Updated Successfully';
		$link = 'index.php?option=com_camassistant&controller=vendorcompliances';
		$this->setRedirect( $link,$msg );
		//$this->setRedirect( $link, JText::_( 'Item Saved' ) );
	}

	// function remove
	function remove()
	{
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cids = implode( ',', $cid );
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('category_detail');
			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}
			$msg='';
			$msg='Industry Deleted Successfully';
		$this->setRedirect( 'index.php?option=com_camassistant&controller=category',$msg);
	}

	// function cancel
	function cancel()
	{
		$this->setRedirect( 'index.php?option=com_camassistant&controller=vendorcompliances' );
	}
	
	function removedocuments(){
		$db = JFactory::getDBO();	
		$type = JRequest::getVar('Type','');
		$documentid = JRequest::getVar('Documentid','');
		$userid_log = JRequest::getVar('Userid','');
			if($type == 'W9'){
				 $clear_w9 = "UPDATE #__cam_vendor_compliance_w9docs SET w9_upld_cert='', w9_date_verified='0000-00-00' where vendor_id=".$userid_log." and id=".$documentid." "; 
			 	 $db->setQuery($clear_w9);
			  	 $updatetime = $db->query();
				 if($updatetime){
				 echo "success";
				 }
			}	
			if($type == 'GLI'){
				 $clear_w9 = "UPDATE #__cam_vendor_liability_insurence SET GLI_name='', GLI_policy='', GLI_start_date='', GLI_end_date='', GLI_agent_first_name='', GLI_agent_last_name='', GLI_phone_number='', GLI_policy_aggregate='', GLI_policy_occurence='', GLI_upld_cert='', GLI_date_verified='0000-00-00', GLI_med='', GLI_injury='', GLI_products='', GLI_applies='', GLI_damage='', GLI_primary='', GLI_waiver='', GLI_occur='', GLI_certholder='', GLI_additional=''  where vendor_id=".$userid_log." and id=".$documentid." "; 
			 	 $db->setQuery($clear_w9);
			  	 $updatetime = $db->query();
				 if($updatetime){
				 echo "success";
				 }
			}
			if($type == 'aip'){
				 $clear_w9 = "UPDATE #__cam_vendor_auto_insurance SET aip_end_date='', aip_date_verified='0000-00-00', aip_upld_cert='', aip_bodily='', aip_combined='', aip_body_injury='', aip_property='', aip_primary='', aip_waiver='', aip_cert='', aip_addition='', aip_applies_any='', aip_applies_owned='', aip_applies_nonowned='', aip_applies_hired='', aip_applies_scheduled='' where vendor_id=".$userid_log." and id=".$documentid." "; 
			 	 $db->setQuery($clear_w9);
			  	 $updatetime = $db->query();
				 if($updatetime){
				 echo "success";
				 }
			}
			if($type == 'WCI'){
				 $clear_w9 = "UPDATE #__cam_vendor_workers_companies_insurance SET WCI_name='', WCI_policy='', WCI_start_date='', WCI_end_date='', WCI_agent_first_name='', WCI_agent_last_name='', WCI_phone_number='', WCI_upld_cert='', excemption='', WCI_disease='', WCI_disease_policy='', WCI_waiver='', WCI_each_accident='', WCI_cert='', WCI_date_verified='0000-00-00' where vendor_id=".$userid_log." and id=".$documentid." "; 
			 	 $db->setQuery($clear_w9);
			  	 $updatetime = $db->query();
				 if($updatetime){
				 echo "success";
				 }
			}
			if($type == 'wc'){
				 $clear_w9 = "UPDATE #__cam_vendor_workers_compansation SET wc_end_date='', wc_date_verified='0000-00-00', wc_upld_cert='' where vendor_id=".$userid_log." and id=".$documentid." "; 
			 	 $db->setQuery($clear_w9);
			  	 $updatetime = $db->query();
				 if($updatetime){
				 echo "success";
				 }
			}
			if($type == 'UMB'){
				 $clear_w9 = "UPDATE #__cam_vendor_umbrella_license SET UMB_license='', UMB_expdate='', UMB_city_country='', UMB_state='', UMB_upld_cert='', UMB_date_verified='0000-00-00', UMB_aggregate='', UMB_occur='', UMB_certholder='' where vendor_id=".$userid_log." and id=".$documentid." "; 
			 	 $db->setQuery($clear_w9);
			  	 $updatetime = $db->query();
				 if($updatetime){
				 echo "success";
				 }
			}
			if($type == 'OMI'){
				 $clear_w9 = "UPDATE #__cam_vendor_errors_omissions_insurance SET  OMI_end_date='', OMI_status='', OMI_upld_cert='', OMI_date_verified='0000-00-00', OMI_aggregate='', OMI_each_claim='', OMI_cert='' where vendor_id=".$userid_log." and id=".$documentid." "; 
			 	 $db->setQuery($clear_w9);
			  	 $updatetime = $db->query();
				 if($updatetime){
				 echo "success";
				 }
			}
			if($type == 'OLN'){
				 $clear_w9 = "UPDATE #__cam_vendor_occupational_license SET OLN_license='', OLN_expdate='', OLN_city_country='', OLN_state='', OLN_upld_cert='', OLN_date_verified='0000-00-00' where vendor_id=".$userid_log." and id=".$documentid." "; 
			 	 $db->setQuery($clear_w9);
			  	 $updatetime = $db->query();
				 if($updatetime){
				 echo "success";
				 }
			}
			if($type == 'PLN'){
				 $clear_w9 = "UPDATE #__cam_vendor_professional_license SET PLN_license='', PLN_category='', PLN_type='', PLN_expdate='', PLN_state='', PLN_upld_cert='', PLN_date_verified='0000-00-00' where vendor_id=".$userid_log." and id=".$documentid." "; 
			 	 $db->setQuery($clear_w9);
			  	 $updatetime = $db->query();
				 if($updatetime){
				 echo "success";
				 }
			}
				
			
		exit;
	}
	
}
?>
