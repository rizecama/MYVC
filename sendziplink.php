<?php
define( '_JEXEC', 1 );
define('JPATH_BASE', str_replace('/cron','',dirname(__FILE__)) );
define( 'DS', DIRECTORY_SEPARATOR );
/* Required Files */
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
/* To use Joomla's Database Class */
require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
/* Create the Application */
$mainframe =& JFactory::getApplication('site');

$db =& JFactory::getDBO();
$closed_rfp="SELECT id,proposalDueDate,proposalDueTime,cust_id,property_id,projectName FROM #__cam_rfpinfo where rfp_type='rfp' ";
$db->Setquery($closed_rfp);
$rfps = $db->loadObjectList();

for($r=0; $r<=count($rfps); $r++){   ///To get the download links
	$closetime =  $rfps[$r]->proposalDueDate . " " . $rfps[$r]->proposalDueTime;
	$date2= explode('-',$closetime);
	$date= $date2[1];
	$month= $date2[0];
	$year1= $date2[2];
	$year2= explode(' ',$year1);
	$year = $year2[0];
	$time = $year2[1];
	 $date3= $year.'-'.$month.'-'.$date.' '.$time;
	  $closeddate= strtotime($date3);
	  
	$timezone_sql = "SELECT timezone FROM #__cam_property where id=".$rfps[$r]->property_id." ";
	$db->Setquery($timezone_sql);
	$timezone = $db->loadResult();
			if( $timezone == '' || $timezone == 'eat' ) 
			$closeddate = $closeddate ;
			else if( $timezone == 'cen' )
			$closeddate = $closeddate + 3600 ;
			else if( $timezone == 'mou' ) 
			$closeddate = $closeddate + 7200 ;
			else if( $timezone == 'pac' ) 
			$closeddate = $closeddate + 10800 ;
			else if( $timezone == 'ala' ) 
			$closeddate = $closeddate + 14400 ;
			else if( $timezone == 'haw' ) 
			$closeddate = $closeddate + 21600 ;
			else
			$closeddate = $closeddate ;
			
	$closeddate1 = $closeddate ;   //Adding 10 minuits of time to closing time
	  $today = date('Y-m-d H:i');
	 $todatdate= strtotime($today);
	 $diff = $closeddate1 - $todatdate;
	// $diff = $todatdate-$closeddate1;
	//echo $rfps[$r]->id;	 echo'<br>';
//	echo $rfps[$r]->id."&nbsp;&nbsp;".$diff; echo "<br>";

	if( $diff < 600 && $diff > 420 ){
	//echo 'hi';
//		if( $diff > 2820){
		$link1 = 'http://www.myvendorcenter.com/live/zipdownloads/RFP'.$rfps[$r]->id.'.zip';
		$link = '<a href='.$link1.'>CLICK HERE</a>';
		$message = "SELECT introtext FROM #__content WHERE  id=212";
		//$message = "SELECT introtext FROM #__content WHERE  id=209";
		$db->setQuery($message);
		$body = $db->loadResult();
		$body = str_replace('{CLICK HERE}',$link,$body);
		$body = str_replace('{ID}',$rfps[$r]->id,$body);
		$body = str_replace('{RFPNAME}',$rfps[$r]->projectName,$body);
		$body = str_replace('{LINK}',$link1,$body);

		$db =& JFactory::getDBO();
		//To get the property name
		$property="SELECT property_name FROM #__cam_property where id=".$rfps[$r]->property_id."";
		$db->Setquery($property);
		$property_name = $db->loadResult();
		$property_name = str_replace('_',' ',$property_name);
		$body = str_replace('{PNAME}',$property_name,$body);
		//Completed
		$manager="SELECT email,name,lastname,phone,user_type FROM #__users where id=".$rfps[$r]->cust_id."";
		$db->Setquery($manager);
		$managerd = $db->loadObject();

		$managername = $managerd->name.'&nbsp;'.$managerd->lastname;

		//Get the management company name
		if($managerd->user_type == 13){
		$company_name="SELECT comp_name FROM #__cam_camfirminfo where cust_id=".$rfps[$r]->cust_id."";
		$db->Setquery($company_name);
		$comp_name = $db->loadResult();
		}
		else{
		$company_name="SELECT comp_name FROM #__cam_customer_companyinfo where cust_id=".$rfps[$r]->cust_id."";
		$db->Setquery($company_name);
		$comp_name = $db->loadResult();
		}

		//Completed
		$body = str_replace('{MNAME}',$managername,$body);
		$body = str_replace('{MPHONE}',$managerd->phone,$body);
		$body = str_replace('{CNAME}',$comp_name,$body);



		$to = $managerd->email;
		//echo '<pre>'; print_r($to);
		$sateesh = 'rize.cama@gmail.com';
		//$allen = 'allen@myvendorcenter.com';
		$support = "manageremails@myvendorcenter.com";
		$sub = "Your RFP has reached its Requested Due Date";
		$from = "support@myvendorcenter.com";
		$from_name = 'MyVendorCenter.com';

		$proposals="SELECT count(id) FROM #__cam_vendor_proposals where rfpno=".$rfps[$r]->id." and (proposaltype= 'submit' || proposaltype= 'resubmit') " ;
		$db->Setquery($proposals);
		$countproposals = $db->loadResult();

		if($countproposals >0){
		$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
		$successMail =JUtility::sendMail($from, $from_name, $support, $sub, $body,$mode = 1);
		$successMail =JUtility::sendMail($from, $from_name, $sateesh, $sub, $body,$mode = 1);
//		$successMail =JUtility::sendMail($from, $from_name, $allen, $sub, $body,$mode = 1);
		//to send the board members
		 $board_members="SELECT email FROM #__cam_board_mem where user_id=".$rfps[$r]->cust_id." and property_name=".$rfps[$r]->property_id." ";
		$db->Setquery($board_members);
		$bmembers = $db->loadObjectList();
		for($b=0; $b<=count($bmembers); $b++){
		$bto = $bmembers[$b]->email;
		//echo '<pre>'; print_r($bto); echo 'board';
		$successMail =JUtility::sendMail($from, $from_name, $bto, $sub, $body,$mode = 1);
		}
		}
		else{
		$body  = $body."<br><br>No proposals for this LIVE RFP";
		//$successMail =JUtility::sendMail($from, $from_name, $sateesh, $sub, $body,$mode = 1);

		}
		//completed

		}	// closing if condition
	}	//exit;//Closing for loop

?>
