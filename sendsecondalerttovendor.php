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
$closed_rfp="SELECT id,proposalDueDate,proposalDueTime,cust_id,projectName,property_id FROM #__cam_rfpinfo where rfp_type='rfp' and publish=1 ";
$db->Setquery($closed_rfp);
$rfps = $db->loadObjectList();
//echo "<pre>"; print_r($rfps); 

for($r=0; $r<count($rfps); $r++){   ///To get the download links
$fdate =  $rfps[$r]->proposalDueDate ;
$ftime =  $rfps[$r]->proposalDueTime ;

$date2= explode('-',$fdate);
$date= $date2[1];
$month= $date2[0];
$year= $date2[2];	
$rfpdate = $year.'-'.$month.'-'.$date;
$strdate = strtotime(date("Y-m-d", strtotime($rfpdate)) );
$duetime = $ftime * 3600;  

	$timezone_sql = "SELECT timezone FROM #__cam_property where id=".$rfps[$r]->property_id." ";
	$db->Setquery($timezone_sql);
	$timezone = $db->loadResult();
			if( $timezone == '' || $timezone == 'eat' ) 
			$duetime = $duetime ;
			else if( $timezone == 'cen' )
			$duetime = $duetime + 3600 ;
			else if( $timezone == 'mou' ) 
			$duetime = $duetime + 7200 ;
			else if( $timezone == 'pac' ) 
			$duetime = $duetime + 10800 ;
			else if( $timezone == 'ala' ) 
			$duetime = $duetime + 14400 ;
			else if( $timezone == 'haw' ) 
			$duetime = $duetime + 21600 ;
			else
			$duetime = $duetime ;
			
$closeddate = $strdate + $duetime ; 
$today = date('Y-m-d H:i');
$todaydate = strtotime($today);
$datediff=$closeddate - $todaydate;
$hours = $datediff / 3600 ;  
$hours = round($hours) ;
//echo '<br />RFP ID: ' . $rfps[$r]->id . '<br />' ;
//echo '<br />HOURS: ' . $hours . '<br />' ;
if($hours == '36')
{		
	$rfpid =  $rfps[$r]->id ;
	$managerid =  $rfps[$r]->cust_id ;
	$user_id= "SELECT proposedvendorid,id FROM #__cam_vendor_proposals WHERE rfpno='".$rfpid."' and (proposaltype='ITB' or proposaltype='Draft') and bidfrom='' ";
	$db->Setquery($user_id);
    $user_ids = $db->loadObjectList();
//	echo "<pre>"; print_r($user_ids); echo count($user_ids); exit;
	for($u=0;$u<count($user_ids);$u++)
	{
		$declined_bid = "SELECT not_interested FROM #__cam_vendor_availablejobs WHERE user_id='".$user_ids[$u]->proposedvendorid."' and rfp_id=".$rfpid." ";
		$db->setQuery($declined_bid);
		$bid_vendor = $db->loadResult();
		if( $bid_vendor != '2' ){
		
		$user_id1= "SELECT email,name,lastname,ccemail FROM #__users WHERE id='".$user_ids[$u]->proposedvendorid."'";
	    $db->Setquery($user_id1);
        $user_ids1 = $db->loadObject();	
		//echo "<pre>"; print_r($user_ids1); exit;
		//To get the body
		$message = "SELECT introtext FROM #__content WHERE  id=228";
		$db->setQuery($message);
		$body = $db->loadResult();
//Completed		
//To get the camfirm details
		$cname = "SELECT comp_name  FROM #__cam_customer_companyinfo WHERE  cust_id='".$managerid."'";
		$db->setQuery($cname);
		$cname = $db->loadResult();	
//Completed		

//To get the property name
		$p_name= "SELECT property_name FROM #__cam_property WHERE id='".$rfps[$r]->property_id."' ";
		$db->Setquery($p_name);
		$pname = $db->loadResult();
		$pname = str_replace('_',' ',$pname);
//To get the manager names
	$names = "SELECT name, lastname  FROM #__users WHERE  id='".$managerid."'";
		$db->setQuery($names);
		$names_m = $db->loadObject();	
		$m_name = $names_m->name.' '. $names_m->lastname;
// To get the due date and time
$date2= explode('-',$rfps[$r]->proposalDueDate);
$date= $date2[1];
$month= $date2[0];
$year= $date2[2];	
$rfpdate = $year.'-'.$month.'-'.$date;
$redate = strtotime(date("Y-m-d", strtotime($rfpdate)) . "0 day");   //Adding 1 days to (X) days 
$rfpdate = date('m-d-Y', $redate);
//$totaltime = $rfpdate.' '.$rfps[$r]->proposalDueTime;
$totaltime = $rfpdate.' '.date("g:i A", strtotime($rfps[$r]->proposalDueTime));
//Completed		
		$from='support@myvendorcenter.com';
		$from_name='MyVendorCenter.com';
		$to=$user_ids1->email;
		$vendorname=$user_ids1->name. ' ' . $user_ids1->lastname;
		$body = str_replace('{VENDORNAME}',$vendorname,$body);
		$body = str_replace('{RFPNO}',$rfpid,$body);
		$body = str_replace('{CAMFIRMNAME}',$cname,$body);
		$body = str_replace('{RFP NAME}',$rfps[$r]->projectName,$body);
		$body = str_replace('{PROPERTY NAME}',$pname,$body);
		$body = str_replace('{MANAGEMENT FIRM COMPANY NAME}',$cname,$body);
		$body = str_replace('{MANAGER NAME}',$m_name,$body);
		$body = str_replace('{DUEDATEANDTIME}',$totaltime,$body);
		
		$sub="Reminder to Submit Your Proposal For RFP #".$rfpid." ";
		//echo $body ;
		$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
		$to = 'rize.cama@gmail.com';
		$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);		
		$to = 'vendoremails@myvendorcenter.com';
		$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
		
		$ccemails = $user_ids1->ccemail;
		$cc_exploade = explode(';', $ccemails);
		for( $c=0; $c<count($cc_exploade); $c++ ){
		$to = $cc_exploade[$c] ;
		$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
		}
		$sql = "insert into #__cam_rfp_reminders values ('','".$rfpid."','".$user_ids[$u]->proposedvendorid."','".$user_ids[$u]->id."','".$managerid."', '".date("m-d-Y H:i")."','a', '2')";
		$db->SetQuery($sql);
		$db->query();
	} //exit;
	}
}

}
?>