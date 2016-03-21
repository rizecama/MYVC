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

$last = date('Y-m-d');
$after30day=date('Y-m-d', strtotime('+30 days', strtotime($last)));

$today = date('m-d-Y');
$db =& JFactory::getDBO();
$closed_rfp="SELECT id,proposalDueDate,proposalDueTime,cust_id,property_id,projectName,biddingcloseddate FROM #__cam_rfpinfo where rfp_type='closed' and publish=1 ";
$db->Setquery($closed_rfp);
$rfps = $db->loadObjectList();
for($r=0; $r<count($rfps); $r++){ 
//echo "<pre>"; print_r($rfps[$r]);  
	// Get closed tim
	$bidding_closed = explode(' ',$rfps[$r]->biddingcloseddate);
	//echo $bidding_closed[0];
	$closeday = explode('-',$bidding_closed[0]) ;
	$final_close = $closeday[2].'-'.$closeday[0].'-'.$closeday[1];
	//echo '<br />'.$final_close;
	//echo '<br />'.$last;
	$after30day = date('Y-m-d', strtotime('+30 days', strtotime($final_close)));
	//echo '<br /><br />'.$after30day;
	
	//Completed  
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
	$closeddate1 = $closeddate;   //Adding 0 minuits of time to closing time
	$today = date('Y-m-d H:i');
	$todatdate= strtotime($today);
	$diff = $todatdate - $closeddate1 ;

	if( $last == $after30day ){
		$message = "SELECT introtext FROM #__content WHERE  id=243";
		$db->setQuery($message);
		$body = $db->loadResult();
		$body = str_replace('[RFP#]',$rfps[$r]->id,$body);
		$body = str_replace('[Reference Name]',$rfps[$r]->projectName,$body);
		$body = str_replace('[Close Date]',$rfps[$r]->biddingcloseddate,$body);
		$body = str_replace('[Close Time]','',$body); 
		
		$db =& JFactory::getDBO();
		//Completed
		$manager="SELECT email,name,lastname,phone,user_type FROM #__users where id=".$rfps[$r]->cust_id."";
		$db->Setquery($manager);
		$managerd = $db->loadObject();
		$managername = $managerd->name.'&nbsp;'.$managerd->lastname;
		$body = str_replace('[MNAME]',$managername,$body);
		$sub = "Courtesy Reminder for Closed Request(s)";
		$from = "support@myvendorcenter.com";
		$from_name = 'MyVendorCenter.com';
		
		$to = $managerd->email;
		//$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
		$to_rize = 'rize.cama@gmail.com';
		$successMail =JUtility::sendMail($from, $from_name, $to_rize, $sub, $body,$mode = 1);
		$to = 'manageremails@myvendorcenter.com';
		//$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
		}   // closing if condition 
	}	//Closing for loop
?>
