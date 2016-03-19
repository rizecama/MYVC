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
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class proposalsController extends JController
{

	function __construct()
	{
		parent::__construct();
	}

	/*// function cancel
	function cancel()
	{
		$rfp_id = JRequest::getVar( 'rfp_id','');
		$this->setRedirect( 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&rfp_id='.$rfp_id );
	}*/

	function display()
	{
		parent::display();
	}

	//function to upload warranty docs in proposal form
	function warranty_docs()
	{
	   JRequest::getVar('view','proposals');
	   parent::display();
	}

	//function to display vendor propsals
	function vendor_proposal_form()
	{

		JRequest::setVar('view', 'proposals');
		parent::display();

	   //JRequest::getVar('view','vendors');
	  // parent::display();
	}

	//function to add comma to price
	function vendor_proposal_edit_format_val()
	{
	   $fieldvalue= JRequest::getVar('fieldvalue','');
	   $fieldvalue = doubleval(str_replace(",","",$fieldvalue));
	   $fieldvalue = number_format($fieldvalue,2);
	   echo $fieldvalue;
	   exit;
	   /*$subject = $fieldvalue;
	   $pattern = '/^./';
        preg_match($pattern, substr($subject,-3), $matches, PREG_OFFSET_CAPTURE);
		if($matches[0][0] == '.')
	    $fieldvalue = substr($fieldvalue, 0,-3);
	    $imp_arr = explode(',',$fieldvalue);
		$ini_flag = 0;
		$flag = 0;
		for($i=0; $i<count($imp_arr); $i++)
		{
		if($i==0)
		{$len=strlen($imp_arr[$i]); $ini_flag=1;}
		if(strlen($imp_arr[$i]) != 3 && $i != 0)
		$flag = '1';
		}
		if($flag == '1' && $ini_flag == '1')
		{echo 'Not valid';}
		else
		{
		 $fieldvalue = doubleval(str_replace(",","",$fieldvalue));
	     $fieldvalue = number_format($fieldvalue,2);
	     echo $fieldvalue;
		}*/

	}
	//function to get commission value
	function vendor_proposal_get_commission()
	{
		$c1		=0;
		$c2		=$_REQUEST['c2'];
		$added =  $_REQUEST['added'];
		$other =  $_REQUEST['other'];
		//$path	=$_REQUEST['path'];
		$c2 = doubleval(str_replace(",","",$c2));
		if($c1 == 0 && $c2 !=0) //code to combined calculation
		{
		if($c2 < 4400000)
		{
		$formula = (-0.00869*log($c2))+0.15;
		$percent = round($formula,5);
		}
		else if($c2 >= 4400000 && $c2 < 6500000)
		{
		$formula	=  (-0.00000000000000000000004033*pow($c2,3))+((0.0000000000000010088)*pow($c2,2))-(0.0000000083137)*$c2 + 0.037557;
		$percent = round($formula,5);
		}
		else if($c2 >= 6500000)
		{
		$percent = 0.015;
		}
		$comm_amnt = $percent*$c2;
		$comm_amnt = round($comm_amnt,2);
		}
		//$comm_amnt = '1000000';
		//$comm_amnt = number_format($comm_amnt,2,'.','');
		$comm_amnt = doubleval(str_replace(",","",$comm_amnt));
		$comm_amnt = number_format($comm_amnt,2);
		$c2 = doubleval(str_replace(",","",$c2));
		$amnt = number_format($c2,2);
		$added = doubleval(str_replace(",","",$added));
		$added = number_format($added,2);
		$other = doubleval(str_replace(",","",$other));
		$other = number_format($other,2);
		echo $comm_amnt.'AND'.$amnt.'AND'.$added.'AND'.$other;
		exit;
	}

	//function to submit proposal directly from proposal centre
	function Proposal_submit()
	{
	 $model = $this->getModel('proposals');
	 $Itemid= JRequest::getVar('Itemid','');
	 $Proposal_save_as = $model->Proposal_submit();
	 $link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_proposal_centre&Itemid=106';
	 $msg="Proposal Submitted Successfully";
	 $this->setRedirect($link,$msg );
	}

	//function to save as ITB
	function Proposal_save_as_ITB()
	{
	$post	= JRequest::get('post');
	$model = $this->getModel('proposals');
	$bid_status = $model->get_RFP_Maxbids();
	if($bid_status == 1)
	{
		$Update_job_status = $model->get_Update_job_status();
		$ins_id = $model->Proposal_save_as_ITB($post);
		$link = 'index.php?option=com_camassistant&controller=vendors&act=ITB&rfp_id='.$post['rfp_id'].'&Proposal_id='.$ins_id.'&Itemid=106&task=vendor_proposal_centre';
		$msg="'Intent To Bid' Submitted Successfully";
	}
	else
	{
	   $msg = "We're sorry, but this project has reached the maximum number of responses. There are no more slots available to bid on this RFP.";
	   $link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_proposal_centre&Itemid=106';
	}

	 $this->setRedirect($link,$msg );
	}

	//function to save rfp proposal (bidding)
	function Proposal_save_as()
	{

//echo "<pre>"; print_r($_REQUEST); exit;
	$post	= JRequest::get('post');
	$submit_type = JRequest::getVar('submit_type');
        $submittype = JRequest::getVar('submittype');
	$act = JRequest::getVar('act');
	$db = JFactory::getDBO();
    $vendorid = JRequest::getVar('vendorid');
	$contact_name = JRequest::getVar('contact_name');
    $rfp_id = JRequest::getVar('rfp_id');
	$user	= JFactory::getUser($vendorid);
    $rfp_id = JRequest::getVar('rfp_id');
	//echo '<pre>'; print_r($_REQUEST);
		$post['id'] = $post['Prp_id'];
		$task_ids = JRequest::getVar('task_ids','');
		$pid = JRequest::getVar('Proposal_id');

		//$SNOTES = JRequest::getVar('SNOTES','');
		//$SNOTES = htmlentities($_REQUEST['SNOTES'], ENT_QUOTES);
		//$SNOTES = str_replace('\&quot','&quot',$SNOTES);
		$SEXCEP = JRequest::getVar('SEXCEP','');
        //$SNOTES = JRequest::getVar('SNOTES','');
		$SNOTES = htmlentities($_REQUEST['SNOTES'], ENT_QUOTES);
		$SNOTES = str_replace('\&quot','&quot',$SNOTES);
		$SNOTES = str_replace('\\','',$SNOTES);
		$model = $this->getModel('proposals');

		$fpath = JRequest::getVar('fpath','');
		//$spath = JRequest::getVar('spath0','');
		$spath1 = JRequest::getVar('shid_text','');
		$spath2 = JRequest::getVar('spath','');
		if($spath2){
		$spath=$spath2;
		} else {
		$spath=$spath1;
		}
		//Tp update the contact person
		if($contact_name){
		$sql_upcontact = "Update #__cam_vendor_proposals set contact_name='".$contact_name."' where proposedvendorid =".$user->id." AND rfpno=".$rfp_id." AND id =".$pid." ";
		$db->Setquery($sql_upcontact);
		$db->query();
		}
		//Completed 
		//print_r($spath); exit;
		for($i=0; $i<count($task_ids); $i++)
		{
		/* $sql = "SELECT id FROM #__cam_rfpsow_addnotes WHERE rfp_id='".$post['rfp_id']."' and task_id='".$task_ids[$i]."' and vendor_id='".$user->id."' and Alt_bid='yes'";
		$db->setQuery($sql);
		$db_taskids = $db->loadResultArray();
		if(!$db_taskids){*/
		 // $add_notes= $post['NOTES_'.$task_ids[$i]];
		   $add_notes = htmlentities($_REQUEST['NOTES_'.$task_ids[$i]], ENT_QUOTES);
		   $add_notes = str_replace('\&quot','&quot',$add_notes);
		   $add_notes = str_replace('\\','',$add_notes);
         // $add_notes = mysql_real_escape_string($add_notes);
		 // $add_notes = htmlentities($add_notes, ENT_QUOTES);
		 // $add_notes = str_replace('\&quot','&quot',$add_notes);

		 // echo $add_notes ;
		  $data['id']='';
		  $data['rfp_id']=$post['rfp_id'];
		  $data['task_id']=$task_ids[$i];
		  $data['vendor_id']=$user->id;
		  $data['spl_req']='No';
		  $data['add_notes']=$add_notes;
		  $data['status']='active';
		 if( $post['Alt_Prp'] == 'yes'){
		  $data['Alt_bid']='yes';
		  } else {
		   $data['Alt_bid']='';
		  }
		//  echo '<pre>'; print_r($data);
		  if( $post['Alt_Prp'] == 'yes'){
		 	$query = "DELETE FROM #__cam_rfpsow_addnotes WHERE rfp_id='".$post['rfp_id']."' and task_id='".$task_ids[$i]."' and vendor_id='".$user->id."' and Alt_bid='yes'";
			$db->setQuery($query);
			$db->query();
			} else {
			$query = "DELETE FROM #__cam_rfpsow_addnotes WHERE rfp_id='".$post['rfp_id']."' and task_id='".$task_ids[$i]."' and vendor_id='".$user->id."' and Alt_bid!='yes'";
			$db->setQuery($query);
			$db->query();
			}

		$save_addnotes = $model->save_addnotes($data);

		//}
		/* $sql1 = "SELECT id FROM #__cam_rfpsow_addexception WHERE rfp_id='".$post['rfp_id']."' and task_id='".$task_ids[$i]."' and vendor_id='".$user->id."' and Alt_bid='yes'";
		$db->setQuery($sql1);
		$db_addexception = $db->loadResultArray();
		if(!$db_addexception){*/
		  $add_exception=$post['EXCEP_'.$task_ids[$i]];
                  $excption_accept=$post['excption_accept_'.$task_ids[$i]];
		  $data['id']='';
		  $data['rfp_id']=$post['rfp_id'];
		  $data['task_id']=$task_ids[$i];
		  $data['vendor_id']=$user->id;
		  $data['spl_req']='No';
		   if($excption_accept == 'on'){
		  		$data['add_exception'] = $add_exception;
				$data['add_exception'] = str_replace('(list all Exceptions here)','',$data['add_exception']);
		  }
		  else {
		  		$data['add_exception'] = '';
		  }
		  //$data['add_exception']=$add_exception;
          $data['check_exception']=$excption_accept;
		  $data['status']='active';
		  if( $post['Alt_Prp'] == 'yes'){
		  $data['Alt_bid']='yes';
		  } else {
		   $data['Alt_bid']='';
		  }
		//  echo '<pre>'; print_r($data);
		 if( $post['Alt_Prp'] == 'yes'){
		   $query = "DELETE FROM #__cam_rfpsow_addexception WHERE rfp_id='".$post['rfp_id']."' and task_id='".$task_ids[$i]."' and vendor_id='".$user->id."' and Alt_bid='yes'";
			$db->setQuery($query);
			$db->query();
			} else {
			   $query = "DELETE FROM #__cam_rfpsow_addexception WHERE rfp_id='".$post['rfp_id']."' and task_id='".$task_ids[$i]."' and vendor_id='".$user->id."' and Alt_bid!='yes'";
			$db->setQuery($query);
			$db->query();
			}
		$save_addexception = $model->save_addexception($data);



		//for($k=0; $k<count($fpath); $k++)
		//{
		//$fpath_upload=$post['fpath_'.$task_ids[$i];

 	if( $post['Alt_Prp'] == 'yes'){
		$query = "DELETE FROM #__cam_rfpsow_uploadfiles WHERE rfp_id='".$post['rfp_id']."' and task_id='".$task_ids[$i]."' and vendor_id='".$user->id."' and Alt_bid='yes'";
		$db->setQuery($query);
		$db->query();
		} else {
		$query = "DELETE FROM #__cam_rfpsow_uploadfiles WHERE rfp_id='".$post['rfp_id']."' and task_id='".$task_ids[$i]."' and vendor_id='".$user->id."' and Alt_bid!='yes'";
		$db->setQuery($query);
		$db->query();
		}
	$upload=$post['fpath_'.$task_ids[$i]];
	//$upload2=$post['hid_text_'.$task_ids[$i]];
	//$upload= array_merge($upload1,$upload2);
	//echo '<pre>'; print_r($upload);
	/*if($upload1){
	$upload=$upload1;
	} else {
	$upload=$upload12;
	}*/
//echo '<pre>'; print_r($upload); exit;
	 for($j=0; $j<count($upload); $j++){
	//echo '<pre>'; print_r($post['fpath_'.$task_ids[$i]]);
	//echo $post['fpath_'.$task_ids[0]];
		$uploadfile =$upload[$j];
		//echo '<pre>'; print_r($upload[$j]);
		$data['id']='';
		$data['rfp_id']=$post['rfp_id'];
		$data['task_id']=$task_ids[$i];
		$data['vendor_id']=$user->id;
		$data['spl_req']='No';
		$data['upload_doc']=$uploadfile;
		$data['status']='active';
		 if( $post['Alt_Prp'] == 'yes'){
		  $data['Alt_bid']='yes';
		  } else {
		   $data['Alt_bid']='';
		  }
		//}

			//echo '<pre>'; print_r($data);

		/*$query = "DELETE FROM #__cam_rfpsow_uploadfiles WHERE rfp_id='".$post['rfp_id']."' and task_id='".$task_ids[$i]."' and vendor_id='".$user->id."'";
		$db->setQuery($query);
		$db->query();*///exit;
		//echo 'iam in'; print_r($data);
		if($uploadfile){
		//echo 'upload';
		$save_uploadfile = $model->save_uploadfile($data);
		}
	    }  }
		//exit;
	//}}
		/*$query1 = "DELETE FROM #__cam_rfpsow_uploadfiles WHERE rfp_id='".$post['rfp_id']."' and spl_req='yes' and vendor_id='".$user->id."'";
		$db->setQuery($query1);
		$db->query();*/
		 for($k=0; $k<count($spath); $k++){
		$data['id']='';
		$data['rfp_id']=$post['rfp_id'];
		$data['task_id']=$task_ids[$i];
		$data['vendor_id']=$user->id;
		$data['spl_req']='yes';
		$data['upload_doc']=$spath[$k];
		$data['status']='active';
		 if( $post['Alt_Prp'] == 'yes'){
		  $data['Alt_bid']='yes';
		  } else {
		   $data['Alt_bid']='';
		  }
		  //echo '<pre>'; print_r($data);
		  if($spath[$k]){
		  //echo 'upload1';
		  $save_uploadfile = $model->save_uploadfile($data);
		  }
		}
		//exit;
		if( $post['Alt_Prp'] == 'yes'){
		$query = "DELETE FROM #__cam_rfpsow_addnotes WHERE rfp_id='".$post['rfp_id']."' and spl_req='yes'  and vendor_id='".$user->id."' and Alt_bid = 'yes' ";
			$db->setQuery($query);
			$db->query();
		}
		else {
		$query = "DELETE FROM #__cam_rfpsow_addnotes WHERE rfp_id='".$post['rfp_id']."' and spl_req='yes'  and vendor_id='".$user->id."' and Alt_bid != 'yes' ";
			$db->setQuery($query);
			$db->query();
		}
		if($SNOTES){
		// $add_notes= $SNOTES;
		  $data['id']='';
		  $data['rfp_id']=$post['rfp_id'];
		  $data['task_id']='0';
		  $data['vendor_id']=$user->id;
		  $data['spl_req']='yes';
		  $data['add_notes']=$SNOTES;
		  $data['status']='active';
		 if( $post['Alt_Prp'] == 'yes'){
		  $data['Alt_bid']='yes';
		  } else {
		   $data['Alt_bid']='';
		  }
		// echo '<pre>'; print_r($data);
		 /* $query = "DELETE FROM #__cam_rfpsow_addnotes WHERE rfp_id='".$post['rfp_id']."' and spl_req='Yes'  and vendor_id='".$user->id."'";
			$db->setQuery($query);
			$db->query();*/

		$save_addnotes = $model->save_addnotes($data);
		} //exit;
		if( $post['Alt_Prp'] == 'yes'){
		$query = "DELETE FROM #__cam_rfpsow_addexception WHERE rfp_id='".$post['rfp_id']."' and spl_req='Yes' and vendor_id='".$user->id."' and Alt_bid = 'yes'";
			$db->setQuery($query);
			$db->query();
		} else{
		$query = "DELETE FROM #__cam_rfpsow_addexception WHERE rfp_id='".$post['rfp_id']."' and spl_req='Yes' and vendor_id='".$user->id."'and Alt_bid != 'yes'";
			$db->setQuery($query);
			$db->query();
		}

		if($SEXCEP){
		// $add_exception=$SEXCEP;
		  $data['id']='';
		  $data['rfp_id']=$post['rfp_id'];
		  $data['task_id']='0';
		  $data['vendor_id']=$user->id;
		  $data['spl_req']='Yes';
		  $data['add_exception']=$SEXCEP;
		  $data['status']='active';
		 if( $post['Alt_Prp'] == 'yes'){
		  $data['Alt_bid']='yes';
		  } else {
		   $data['Alt_bid']='';
		  }
		//  echo '<pre>'; print_r($data);
		   /*$query = "DELETE FROM #__cam_rfpsow_addexception WHERE rfp_id='".$post['rfp_id']."' and spl_req='Yes' and vendor_id='".$user->id."'";
			$db->setQuery($query);
			$db->query();*/
			$save_addexception = $model->save_addexception($data);
		}
		 $reject = JRequest::getVar('reject');
		//exit;
	 //code to chk user existance in poposals table
	//echo $submit_type; exit;
	  if($submit_type == 'Submit' && $act == 'submitproposal')
	 {
	    // echo '123'; exit;
	 	$db = JFactory::getDBO();
		$vendorid = JRequest::getVar('vendorid');
	$user	= JFactory::getUser($vendorid);
		$post['id'] = $post['Prp_id'];
		$Proposal_id = JRequest::getVar('Proposal_id');
		$Alt_Prp = JRequest::getVar('Alt_Prp');
		$rfp_id = JRequest::getVar('rfp_id');
		$model = $this->getModel('proposals');
		$Itemid = JRequest::getVar('Itemid');

		//$chk_user = 'SELECT proposedvendorid FROM #__cam_vendor_proposals WHERE proposedvendorid='.$user->id.' AND rfpno='.$rfp_id.' AND (proposaltype != "review" AND proposaltype != "Draft" AND proposaltype != "ITB") ';
		 $chk_user = 'SELECT count(*) FROM #__cam_vendor_proposals WHERE proposedvendorid='.$user->id.' AND rfpno='.$rfp_id;
		 $db->setQuery($chk_user);
		 $is_exist = $db->loadResult();
		// if($is_exist == '') $flag = 0; else $flag = 1;
		 if($is_exist == '1') $flag = 0; else $flag = 1;
		 $sql = "Update #__cam_vendor_proposals set proposaltype='Submit' where proposedvendorid =".$user->id." AND rfpno=".$rfp_id." AND id =".$Proposal_id." AND Alt_bid= '".$Alt_Prp."'";
		 $db->Setquery($sql);
		 $db->query();

		 // Code to delete the vendor events...
		 $deleteevents = 'DELETE FROM #__jcalpro2_events WHERE rfpid='.$rfp_id.' and owner_id='.$user->id.' ';
		 $db->setQuery($deleteevents);
		 $db->query();


		 //Completed
		 if($flag == 0)
		 $link = 'index.php?option=com_camassistant&controller=rfp&Alt_bid='.$flag.'&Prp_id='.$post['Prp_id'].'&rfp_id='.$rfp_id.'&user_id='.$user->id.'&Proposal_id='.$Proposal_id.'&task=rfp_bids&industryid='.$_REQUEST['industryid'].'&rfpstatus='.$_REQUEST['rfpstatus'].'&rfpapproval='.$_REQUEST['rfpapproval'].'&search='.$_REQUEST['search'].'&Itemid='.$Itemid;
		 else
		 $link = 'index.php?option=com_camassistant&controller=rfp&rfp_id='.$rfp_id.'&industryid='.$_REQUEST['industryid'].'&rfpstatus='.$_REQUEST['rfpstatus'].'&rfpapproval='.$_REQUEST['rfpapproval'].'&search='.$_REQUEST['search'].'&task=rfp_bids';
		 $msg="Proposal Added Successfully";
	    //$link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_proposal_centre&Itemid=106';
		//$msg="Proposal Submitted Successfully";
	    $this->setRedirect($link,$msg );
	 }
	else if($submit_type == 'Submit' && $post['act'] != 'Update')
	 {
	 	 $rfp_id = JRequest::getVar('rfp_id');
		 $Alt_Prp = JRequest::getVar('Alt_Prp');
		 $Proposal_id = JRequest::getVar('Proposal_id');
		 $Itemid = JRequest::getVar('Itemid');
		$vendorid = JRequest::getVar('vendorid');
	$user	= JFactory::getUser($vendorid);
		 $db = JFactory::getDBO();
		 $chk_user = 'SELECT proposedvendorid FROM #__cam_vendor_proposals WHERE proposedvendorid='.$user->id.' AND rfpno='.$rfp_id.' AND (proposaltype != "review" AND proposaltype != "Draft" AND proposaltype != "ITB") ';
		 $db->setQuery($chk_user);
		 $is_exist = $db->loadResult();
		 if($is_exist == '')
		 {
		 $chk_user = 'SELECT id FROM #__cam_vendor_proposals WHERE proposedvendorid='.$user->id.' AND rfpno='.$rfp_id.' AND proposaltype = "ITB" ';
		 $db->setQuery($chk_user);
		 $Proposal_id = $db->loadResult();
		 $flag = 0;
		  } else $flag = 1;
		 $db = JFactory::getDBO();

		 $sql = "Update #__cam_vendor_proposals set proposaltype='Submit' where proposedvendorid =".$user->id." AND rfpno=".$rfp_id." AND id =".$Proposal_id." AND Alt_bid= '".$Alt_Prp."'";
		 $db->Setquery($sql);
		 $db->query();
		 /*$model = $this->getModel('proposals');
		 $Proposal_save_as = $model->Proposal_save_as($post);
		 $sql = "SELECT max(id) FROM #__cam_vendor_proposals ";
		 $db->Setquery($sql);
		 $Proposal_id = $db->loadResult();*/
		if($flag == 0)
		 $link = 'index.php?option=com_camassistant&controller=rfp&Alt_bid='.$flag.'&Prp_id='.$post['Prp_id'].'&rfp_id='.$rfp_id.'&user_id='.$user->id.'&Proposal_id='.$Proposal_id.'&task=rfp_bids&industryid='.$_REQUEST['industryid'].'&rfpstatus='.$_REQUEST['rfpstatus'].'&rfpapproval='.$_REQUEST['rfpapproval'].'&search='.$_REQUEST['search'].'&Itemid='.$Itemid;
		 else
		 $link = $link = 'index.php?option=com_camassistant&controller=rfp&rfp_id='.$rfp_id.'&industryid='.$_REQUEST['industryid'].'&rfpstatus='.$_REQUEST['rfpstatus'].'&rfpapproval='.$_REQUEST['rfpapproval'].'&search='.$_REQUEST['search'].'&task=rfp_bids';
		 $msg="Proposal Added Successfully";
		 if($post['act'] == 'Update')
		 $msg="Proposal Updated Successfully";
	 }
	  else if(($submit_type == 'Submit' || $submit_type == 'Draft' || $submittype=='Draft')&& $post['act'] == 'Update')
	 {
	 	//echo '123'; exit;
	 	$db = JFactory::getDBO();
		$vendorid = JRequest::getVar('vendorid');
         $user	= JFactory::getUser($vendorid);
		$post['id'] = $post['Prp_id'];
		$model = $this->getModel('proposals');
		$post['warranty_file_area'] = htmlentities($_REQUEST['warranty_file_area'], ENT_QUOTES);
		$post['warranty_file_area'] = str_replace('\&quot','&quot',$post['warranty_file_area']);
		$post['warranty_file_area'] = str_replace('\\','',$post['warranty_file_area']);
		$Proposal_save_as = $model->Proposal_save_as($post);
		$link = 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&industryid='.$_REQUEST['industryid'].'&rfpstatus='.$_REQUEST['rfpstatus'].'&rfpapproval='.$_REQUEST['rfpapproval'].'&search='.$_REQUEST['search'].'&rfp_id='.$rfp_id;
		$msg="Proposal Updated Successfully";
	    $this->setRedirect($link,$msg );
	 }
	  else if(($submit_type == 'review' || $submit_type == 'resubmit') && ($post['act'] == 'Update' || $post['Alt_bid'] == 'yes'))
	 {
	 	$db = JFactory::getDBO();
		$vendorid = JRequest::getVar('vendorid');
	$user	= JFactory::getUser($vendorid);
		$post['id'] = $post['Prp_id'];
		//$Proposal_id = JRequest::getVar('Proposal_id');<br />
//echo "<pre>"; print_r($_REQUEST);   exit;
		$model = $this->getModel('proposals');
		$post['id'] = $post['Prp_id'];
		$task_ids = JRequest::getVar('task_ids','');
		$model = $this->getModel('proposals');
		$post['warranty_file_area'] = htmlentities($_REQUEST['warranty_file_area'], ENT_QUOTES);
		$post['warranty_file_area'] = str_replace('\&quot','&quot',$post['warranty_file_area']);
		$post['warranty_file_area'] = str_replace('\\','',$post['warranty_file_area']);
		$ins_id = $model->Proposal_save_as($post);
		if($post['id'] == '' || $post['rebid'] == 's')
		$post['id'] = $ins_id;
		$Alt_bid = JRequest::getVar('Alt_bid','');
		$Alt_Prp = JRequest::getVar('Alt_Prp','');
		if($Alt_bid != '')
		$is_Alt =  $Alt_bid;
		else
		$is_Alt =  $Alt_Prp;
		$link = 'index.php?option=com_camassistant&controller=proposals&act=review&Alt_Prp='.$is_Alt.'&task=vendor_proposal_preview&Proposal_id='.$post['id'].'&vendorid='.$user->id.'&rfp_id='.$post['rfp_id'].'&industryid='.$_REQUEST['industryid'].'&rfpstatus='.$_REQUEST['rfpstatus'].'&rfpapproval='.$_REQUEST['rfpapproval'].'&search='.$_REQUEST['search'].'&Itemid='.$post['Itemid'];
		$msg="";
	    $this->setRedirect($link,$msg );
	 }
	  else
	 {
	 	$db = JFactory::getDBO();
	$vendorid = JRequest::getVar('vendorid');
	$user	= JFactory::getUser($vendorid);
		if($post['act'] == 'Update' && ($post['submit_type'] != 'review' && $post['submit_type'] != 'resubmit'))
		$post['id'] = $post['Prp_id'];
		//to delete ITB record from table
		$del_ITB_user = 'DELETE FROM #__cam_vendor_proposals WHERE proposedvendorid='.$user->id.' AND rfpno='.$post['rfp_id'].'AND proposaltype ="ITB"';
		$db->setQuery($del_ITB_user);
		$db->query();
		$model = $this->getModel('proposals');
		//echo "<pre>"; print_r($post); exit;
		$post['warranty_file_area'] = htmlentities($_REQUEST['warranty_file_area'], ENT_QUOTES);
		$post['warranty_file_area'] = str_replace('\&quot','&quot',$post['warranty_file_area']);
		$post['warranty_file_area'] = str_replace('\\','',$post['warranty_file_area']);
		$Proposal_save_as = $model->Proposal_save_as($post);
		//$sql = "SELECT max(id) FROM #__cam_vendor_proposals ";
		//$db->Setquery($sql);
		$Proposal_id = $db->insertid();
		$link = 'index.php?option=com_camassistant&controller=proposals&act=review&Alt_Prp='.$Alt_Prp.'&task=vendor_proposal_preview&Proposal_id='.$Proposal_id.'&vendorid='.$user->id.'&rfp_id='.$post['rfp_id'].'&industryid='.$_REQUEST['industryid'].'&rfpstatus='.$_REQUEST['rfpstatus'].'&rfpapproval='.$_REQUEST['rfpapproval'].'&search='.$_REQUEST['search'].'&Itemid='.$post['Itemid'];

	 }
	 $this->setRedirect($link,$msg );
	}

	//function to add tasks in RFP proposal addnotes
	function Addnotes()
	{
	   JRequest::getVar('view','proposals');
	   parent::display();
	}

	//function to upload tasks in RFP proposal uploadfiles
	function Uploadfile()
	{
		JRequest::getVar('view','proposals');
		parent::display();
	}

	//function to add tasks in RFP poposal addexceptions
	function Addexception()
	{
		JRequest::getVar('view','proposals');
		parent::display();
	}

	//function to get download file and using this function in both forms add/edit
	function downloadfile()
	{
		$model = $this->getModel('proposals');
		$downloadfile = $model->get_downloadfile();
		parent::display();
	}

	//function to save task -vendor notes
	function save_addnotes()
	{
		$post	= JRequest::get('post');
		$vendorid = JRequest::getVar('vendor_id');
		$user	= JFactory::getUser($vendorid);
		echo $rebid	= JRequest::getVar('rebid','');
		if($rebid != 's')
		{
			$Alt_bid = JRequest::getVar('Alt_bid','');
			$Alt_Prp = JRequest::getVar('Alt_Prp','');
			if($Alt_bid != '')
			$is_Alt =  $Alt_bid;
			else
			$is_Alt =  $Alt_Prp;
		}
		else
		$is_Alt = 'yes';
		$data['id'] = $post['id'];
		$data['task_id'] = $post['task_id'];
		$data['rfp_id'] = $post['rfp_id'];
		$data['vendor_id'] = $vendorid;
		if(isset($post['spl']) && $post['spl'] == 'Yes')
		$data['spl_req'] = 'Yes';
		else
		$data['spl_req'] = 'No';
		$data['add_notes'] = $post['tasknotes'];
		//$data['status'] = $post['active'];
		$data['status'] = 'active';
		$data['Alt_bid'] = $is_Alt;
		//echo "<pre>"; print_r($data); exit;
		$model = $this->getModel('proposals');

		if(isset($data['id']) && $data['id'] != '' && $rebid != 's')
		{
			$db = JFactory::getDBO();
			if($data['spl_req'] == 'Yes')
			$sql = "UPDATE  #__cam_rfpsow_addnotes SET add_notes = '".addslashes($data['add_notes'])."'  WHERE id = ".$data['id']." and rfp_id = ".$data['rfp_id']." AND spl_req='Yes'";
			else
			$sql = "UPDATE  #__cam_rfpsow_addnotes SET add_notes = '".addslashes($data['add_notes'])."'  WHERE id = ".$data['id']." and rfp_id = ".$data['rfp_id']." AND spl_req='No'";
			$db->Setquery($sql);
			$db->query();
			$taskid = $data['task_id'];
			$notes = $data['add_notes'];
			$notes = str_replace("\r\n","<br>",$notes);
			$notes = addslashes($notes);
			echo "<script language='javascript' type='text/javascript'>
			window.parent.document.getElementById( 'sbox-window' ).close();
			var taskid = 'NOTES_".$taskid."';
			var tasknotes = '".$notes."';
			window.parent.document.getElementById(taskid).innerHTML = tasknotes;
			alert('Saved Successfully');
			 </script>";
		 	exit;
		}
		else
		{
			if($data['add_notes'] != '')
			{
				if($rebid == 's')
			    $data['id'] = '';
				$save_addnotes = $model->save_addnotes($data);
				$taskid = $data['task_id'];
			    $notes = $data['add_notes'];
				$notes = str_replace("\r\n","<br>",$notes);
				$rfp_id = $data['rfp_id'];
		        $user_id = $vendorid;
				echo $notes = addslashes($notes);
				echo "<script language='javascript' type='text/javascript'>
				window.parent.document.getElementById( 'sbox-window' ).close();
				var taskid = 'NOTES_".$taskid."';
				var tasknotes = '".$notes."';
				var rfpid = '".$rfp_id."';
			    var userid = '".$user_id."';
				var Alink = 'Alink_".$taskid."';
				var task_id = '".$taskid."';
				var Alink_img = '<img src=\'images/editnotes.gif\' border=\'0\' onclick=\"edit_popup(\'index.php?option=com_camassistant&controller=proposals&Alt_Prp=&task=Addnotes&rfp_id='+rfpid+'&amp;vendorid='+userid+'&amp;task_id='+task_id+'&amp;Action=Edit\',630,390);\" style=\" cursor:pointer;\" alt=\'edit notes\' />';

			    window.parent.document.getElementById(Alink).innerHTML = Alink_img;
				window.parent.document.getElementById(taskid).innerHTML = tasknotes;
				//window.parent.parent.location.reload();
				 </script>";
				 exit;
			 }
			 else
			  echo "<script language='javascript' type='text/javascript'>
			window.parent.document.getElementById( 'sbox-window' ).close();
			 </script>";
			 exit;
		}

		//parent::display();
	}

	//function to save task -vendor notes
	function save_addexception()
	{

		$post	= JRequest::get('post');
		$vendorid = JRequest::getVar('vendor_id');
		$user	= JFactory::getUser($vendorid);
		$rebid	= JRequest::getVar('rebid','');
		$data['id'] = $post['id'];
		$data['task_id'] = $post['task_id'];
		$data['rfp_id'] = $post['rfp_id'];
		$data['vendor_id'] = $vendorid;
		$rebid	= JRequest::getVar('rebid','');
		if($rebid != 's')
		{
			$Alt_bid = JRequest::getVar('Alt_bid','');
			$Alt_Prp = JRequest::getVar('Alt_Prp','');
			if($Alt_bid != '')
			$is_Alt =  $Alt_bid;
			else
			$is_Alt =  $Alt_Prp;
		}
		else
			$is_Alt = 'yes';
		if(isset($post['spl']) && $post['spl'] == 'Yes')
		$data['spl_req'] = 'Yes';
		else
		$data['spl_req'] = 'No';
		$data['add_exception'] = $post['exception'];

		//$data['status'] = $post['active'];
		$data['status'] = 'active';
		$data['Alt_bid'] = $is_Alt;
//		echo "<pre>"; print_r($_REQUEST); exit;
		$model = $this->getModel('proposals');

		if(isset($data['id']) && $data['id'] != '' && $rebid != 's')
		{
			$db = JFactory::getDBO();
			if($data['spl_req'] == 'Yes')
			$sql = "UPDATE  #__cam_rfpsow_addexception SET add_exception = '".addslashes($data['add_exception'])."'  WHERE id = ".$data['id']." and rfp_id = ".$data['rfp_id']." AND spl_req='Yes'";
			else
			$sql = "UPDATE  #__cam_rfpsow_addexception SET add_exception = '".addslashes($data['add_exception'])."'  WHERE id = ".$data['id']." and rfp_id = ".$data['rfp_id']." AND spl_req='No'";
			$db->Setquery($sql);
			$db->query();
			$taskid = $data['task_id'];
			$excep = $data['add_exception'];
			$excep = str_replace("\r\n","<br>",$excep);
			//echo $excep; exit;
			$excep = addslashes($excep);
			echo "<script language='javascript' type='text/javascript'>
			var taskid = 'EXCEP_".$taskid."';
			var excepnotes = '".$excep."';
			window.parent.document.getElementById(taskid).innerHTML = excepnotes;
			window.parent.document.getElementById( 'sbox-window' ).close();
			alert('Saved Successfully');
			//window.parent.parent.location.reload();
		 	</script>";
			exit;
		}
		else
		{
		if($data['add_exception'] != '')
		{
			if($rebid == 's')
			$data['id'] = '';
			$save_addexception = $model->save_addexception($data);
			$taskid = $data['task_id'];
			$excep = $data['add_exception'];
			$excep = str_replace("\r\n","<br>",$excep);
			$excep = addslashes($excep);
			$rfp_id = $data['rfp_id'];
		    $user_id = $vendorid;
			echo "<script language='javascript' type='text/javascript'>
			window.parent.document.getElementById( 'sbox-window' ).close();
			var taskid = 'EXCEP_".$taskid."';
			var Elink = 'Elink_".$taskid."';
			var rfpid = '".$rfp_id."';
			var userid = '".$user_id."';
			var excepnotes = '".$excep."';
			var task_id = '".$taskid."';
			var Elink_img = '<img src=\'templates/camassistant_left/images/editexception.gif\' border=\'0\' onclick=\"edit_popup(\'index.php?option=com_camassistant&controller=proposals&Alt_Prp=&task=Addexception&rfp_id='+rfpid+'&amp;vendorid='+userid+'&amp;task_id='+task_id+'&amp;Action=Edit\',630,390);\" style=\" cursor:pointer;\" alt=\'edit exception\' />';
			window.parent.document.getElementById(taskid).innerHTML = excepnotes;
			window.parent.document.getElementById(Elink).innerHTML = Elink_img;
			alert('Saved Successfully');
			 </script>";
			 exit;
		 }
		 else
		 echo "<script language='javascript' type='text/javascript'>
			window.parent.document.getElementById( 'sbox-window' ).close();
			 </script>";
			 exit;

		}

		//parent::display();
	}

	//function to save task -vendor notes
	function save_uploadfile()
	{
		$files		= JRequest::getVar( 'uploadfile', '', 'files', 'array' );
		$post	= JRequest::get('post');
		$rebid	= JRequest::getVar('rebid','');
                $db = JFactory::getDBO();
		if($rebid != 's')
		{
			$Alt_bid = JRequest::getVar('Alt_bid','');
			$Alt_Prp = JRequest::getVar('Alt_Prp','');
			if($Alt_bid != '')
			$is_Alt =  $Alt_bid;
			else
			$is_Alt =  $Alt_Prp;
		}
		else
			$is_Alt = 'yes';
		//code to move image to folderpath
		if(isset($post['spl']) && $post['spl'] == 'yes')
                      $base_Dir = JPATH_ROOT.DS.'components'.DS.'com_camassistant'.DS.'doc'.DS;
		//$base_Dir = JPATH_ROOT.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rfp'.DS.'Spl_Requirements_docs'.DS;
		else
                      $base_Dir = JPATH_ROOT.DS.'components'.DS.'com_camassistant'.DS.'doc'.DS;
		//$base_Dir = JPATH_ROOT.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rfp'.DS.'Tasks'.DS;
        //echo $base_Dir; exit;
		$filename = $files['name'];
		$filename = str_replace(" ", "_", $filename);
		$filename = str_replace("&", "_", $filename);
		$filename = str_replace("#", "_", $filename);
		$filename = str_replace("%", "_", $filename);

		  $pro="SELECT tax_id FROM #__cam_vendor_company WHERE user_id='".$post['vendorid']."'";
		$db->Setquery($pro);
		$pro_res = $db->loadResult();
                  $dest=$base_Dir.$pro_res;
                if(!is_dir($dest))
                mkdir($dest,0777);
                // $p_path= $pro_res[0]->property_name.'_'.$pro_res[0]->tax_id.'/';
		$filepath = $base_Dir.$pro_res.'/'.$filename;
		move_uploaded_file($files['tmp_name'], $filepath);
		//code to update table
                  $post['property_manager_id'] = $post['vendorid'];

	//$post['docPath'] = $_REQUEST['path']."/".$_FILES['file']['name'];
                $filepath1='components/com_camassistant/doc/'.$pro_res.'/'.$filename;
                $post['docPath'] = $filepath1; //modified by lalitha
                $post['docTitle'] = $filename;
                $post['docTitle'] = ereg_replace(' ','_',$post['docTitle']);

                $post['parent'] = '0';
              	$model	=& $this->getModel('proposals');
		//code to update table

                $res = $model->store3($post);
		$user	= JFactory::getUser();
		$data['task_id'] = $post['task_id'];
		$data['rfp_id'] = $post['rfp_id'];

		$data['vendor_id'] = $post['vendorid'];
		$warranty = JRequest::getVar('warranty','');
		$taskid = JRequest::getVar('taskid','');
		if(isset($post['spl']) && $post['spl'] == 'Yes')
		$data['spl_req'] = 'Yes';
		else
		$data['spl_req'] = 'No';
                  $data['upload_doc'] = $filepath1;
		//$data['upload_doc'] = Juri::root().'components/com_camassistant/assets/images/rfp/Tasks/'.$filename;
		$data['Alt_bid'] = $is_Alt;
		$model = $this->getModel('proposals');
		if($rebid == 's')
		$data['id'] = '';
        //echo '<pre>'; print_r($data); exit;
		$file_id = $model->save_uploadfile($data);
		//$taskid = $data['task_id'];
		$filename = $filename;
		$rfp_id = $data['rfp_id'];
	 	$task_id = $data['task_id'];
		$user_id = $data['vendor_id'];
		$sql_req = $data['spl_req'];
		$act = $post['act'];
		$rebid= $post['rebid'];
		$Proposal_id= $post['Proposal_id'];

		echo "<script language='javascript' type='text/javascript'>

		var taskid = 'upload_file".$taskid."';
		var filename = '".$filename."';
		var rfpid = '".$rfp_id."';
		var task = '".$task_id."';
		var rfpid = '".$rfp_id."';
		var docid = '".$file_id."';
		var userid = '".$user_id."';
		var warranty = '".$warranty."';
		var taskid = '".$taskid."';
		var splreq = '".$sql_req."';
		var AltPrp = '".$is_Alt."';
		var act = '".$act."';
		var rebid = '".$rebid."';
		var Proposal_id = '".$Proposal_id."';
		//var path12 = 'components/com_camassistant/assets/images/rfp/Tasks/'+filename;
                 var path12 = '".$filepath1."';
		var path = '<strong>'+filename+'</strong>&nbsp;<br/><a href=\'index2.php?option=com_camassistant&controller=proposals&task=downloadfile&title='+filename+'&path=components/com_camassistant/assets/images/rfp/Tasks/'+filename+'\'><img src=\'templates/camassistant_left/images/downloadfile.gif\' alt=\'download file\' align=\'absmiddle\' /></a>';

		var del_path = '&nbsp;<a href=\'index.php?option=com_camassistant&controller=proposals&spl_req='+splreq+'&task=Remove_downloadfile&Alt_Prp='+AltPrp+'&Alt_bid='+AltPrp+'&vendor_id='+userid+'&rfp_id='+rfpid+'&task_id='+task+'&doc_id='+docid+'&act='+act+'&rebid='+rebid+'&prop_id='+Proposal_id+'&&Itemid=107\'><img src=\'templates/camassistant_left/images/remove.gif\' alt=\'Remove file\' align=\'absmiddle\' /></a><br/>';
		//var old = window.parent.document.getElementById(taskid).innerHTML;
		if(warranty=='file'){

		window.parent.document.getElementById('fpath'+taskid).value = path12;
		window.parent.document.getElementById('upload_file'+taskid).innerHTML =filename;
                window.parent.document.getElementById('delimg'+taskid).style.display ='';
		}
		if(warranty=='sfile'){
		window.parent.document.getElementById('spath'+taskid).value = path12;
		window.parent.document.getElementById('supload_file'+taskid).innerHTML =filename;
                window.parent.document.getElementById('delimg'+taskid).style.display ='';
		}
                 if(warranty=='warranty_popup'){
		window.parent.document.getElementById('warranty_path').value = path12;
                window.parent.document.getElementById('warranty_hid_text').value =filename;
                window.parent.document.getElementById('warranty_file_text').innerHTML =filename;
                var del_path = '&nbsp;<img onclick = \'javascript: warranty_doc_remove(); \' src=\'http://myvendorcenter.com/live/templates/camassistant_left/images/remove.gif\' alt=\'Remove file\' />';
                window.parent.document.getElementById('warranty_file_rem').innerHTML =del_path;
		}
		//window.parent.document.getElementById(taskid).innerHTML = path+del_path+old;
        	window.parent.document.getElementById( 'sbox-window' ).close();
		 </script>";
		 exit;
		//parent::display();
	}
	/********************************Edit Related Functions*********************************/



	//function to get Remove Uploaded file in Edit RFP proposal
	function Remove_downloadfile()
	{
		$doc_id = JRequest::getVar('doc_id','');
		$task_id = JRequest::getVar('task_id','');
		$rfp_id = JRequest::getVar('rfp_id','');
		$Prp_id = JRequest::getVar('prop_id','');
		$Itemid = JRequest::getVar('Itemid','');
		$Alt_Prp = JRequest::getVar('Alt_Prp','');
		$rebid = JRequest::getVar('rebid','');
		$vendor_id = JRequest::getVar('vendor_id','');
		$Alt_bid = JRequest::getVar('Alt_bid','');
		$Alt_Prp = JRequest::getVar('Alt_Prp','');
		$act = JRequest::getVar('act','');

		if($Alt_bid != '')
		{
		$is_Alt =  "Alt_bid=".$Alt_bid;
		$Alt = $Alt_bid;
		}
		else
		{
		$is_Alt =  "Alt_Prp=".$Alt_Prp;
		$Alt = $Alt_Prp;
		}
		$model = $this->getModel('proposals');
		$downloadfile = $model->get_Remove_downloadfile($Alt);
		/*echo "<script language='javascript' type='text/javascript'>
		window.parent.document.getElementById( 'sbox-window' ).close();
		var taskid = 'FILES_".$taskid."';
		window.parent.document.getElementById(taskid).innerHTML = '';
		 </script>"; */
		$link = 'index.php?option=com_camassistant&controller=proposals&task=Proposal_edit&'.$is_Alt.'&vendorid='.$vendor_id.'&rfp_id='.$rfp_id.'&Proposal_id='.$Prp_id.'&act='.$act.'&rebid='.$rebid.'&Itemid='.$Itemid;
	 	$msg = "File deleted Successfully";
       if($downloadfile){

        echo "deleted";
	}
        $this->setRedirect($link,$msg );
        //exit;
	 	//$this->setRedirect($link,$msg );
	}

	function Remove_warranty_file()
	{
		//echo "<pre>"; print_r($_REQUEST); exit;
		$vendorid = JRequest::getVar('vendorid');
		$user	= JFactory::getUser($vendorid);
		$db = JFactory::getDBO();
		$vendor_id = JRequest::getVar('vendorid','');
		$act = JRequest::getVar('act','');
		$rfp_id = JRequest::getVar('rfp_id','');
		$Prp_id = JRequest::getVar('prop_id','');
		$Itemid = JRequest::getVar('Itemid','');
		$Alt_bid = JRequest::getVar('Alt_bid','');
		$Alt_Prp = JRequest::getVar('Alt_Prp','');
		$rebid = JRequest::getVar('rebid','');
		if($Alt_bid != '')
		$is_Alt =  "Alt_bid=".$Alt_bid;
		else
		$is_Alt =  "Alt_Prp=".$Alt_Prp;
		$prp_sql = "UPDATE #__cam_vendor_proposals SET warranty_filepath = '',  warranty_file_text = '' WHERE id=".$Prp_id;
		$db->Setquery($prp_sql);

		/*echo "<script language='javascript' type='text/javascript'>
		window.parent.document.getElementById( 'sbox-window' ).close();
		var taskid = 'FILES_".$taskid."';
		window.parent.document.getElementById(taskid).innerHTML = '';
		 </script>"; */
		$link = 'index.php?option=com_camassistant&controller=proposals&task=Proposal_edit&'.$is_Alt.'&vendorid='.$vendorid.'&rfp_id='.$rfp_id.'&Proposal_id='.$Prp_id.'&act='.$act.'&rebid='.$rebid.'&Itemid='.$Itemid;
		if($db->query()){
			echo "deleted";
			}

        exit;
    }
}
?>