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
$closed_rfp="SELECT id,proposalDueDate,proposalDueTime,cust_id FROM #__cam_rfpinfo where rfp_type='rfp'";
$db->Setquery($closed_rfp);
$rfps = $db->loadObjectList();


for($r=0; $r<count($rfps); $r++){   ///To get the download links
$fdate =  $rfps[$r]->proposalDueDate ;
$ftime =  $rfps[$r]->proposalDueTime ;

$date2= explode('-',$fdate);
$date= $date2[1];
$month= $date2[0];
$year= $date2[2];	
 $rfpdate = $year.'-'.$month.'-'.$date;

$strdate= strtotime($rfpdate); //Changed date to strtotime
$strtime = $ftime * 3600; 		//Changed time to strtotime
$closeddate = $strdate + $strtime ; 
  $today = date('Y-m-d');
$todaydate = strtotime($today);
$datediff=$closeddate-$todaydate;

$val=86400;
$days= "SELECT vendor_dates FROM #__cam_configuration";
$db->Setquery($days);
$v_days = $db->loadResult();
$max=$val*$v_days;  
$min=$max-300;
/*echo "RFP ID: ".$rfps[$r]->id.'<br>';
echo "Date diff: ". $datediff.'<br>';
echo "RFP DATE: ".$closeddate.'<br>';
echo "ToDAY DATE: ".$todaydate.'<br>';
echo "MAX: ". $max.'<br>';
echo "Min: ". $min.'<br><br><br>';
*/
//if($datediff < $max && $datediff > $min)
//{		
//echo "in"; exit;
	$rfpid =  $rfps[$r]->id ;
	$managerid =  $rfps[$r]->cust_id ;
echo	$user_id= "SELECT proposedvendorid FROM #__cam_vendor_proposals WHERE rfpno='$rfpid' and proposaltype='ITB'";
	$db->Setquery($user_id);
    $user_ids = $db->loadObjectList();
//	echo "<pre>"; print_r($user_ids); echo count($user_ids); exit;
	for($u=0;$u<count($user_ids);$u++)
	{
		$user_id1= "SELECT email,name,lastname FROM #__users WHERE id='".$user_ids[$u]->proposedvendorid."'";
	    $db->Setquery($user_id1);
        $user_ids1 = $db->loadObject();	
		//echo "<pre>"; print_r($user_ids1); exit;
//To get the body
		$message = "SELECT introtext FROM #__content WHERE  id=213";
		$db->setQuery($message);
		$body = $db->loadResult();
//Completed		
//To get the camfirm details
		$cname = "SELECT comp_name  FROM #__cam_customer_companyinfo WHERE  cust_id='".$managerid."'";
		$db->setQuery($cname);
		$cname = $db->loadResult();	
//Completed		

		$from='support@camassistant.com';
		$from_name='CAMassistant Support';
		$to=$user_ids1->email;
		$vendorname=$user_ids1->name. ' ' . $user_ids1->lastname;
		$body = str_replace('{VENDORNAME}',$vendorname,$body);
		$body = str_replace('{RFPNO}',$rfpid,$body);
		$body = str_replace('{CAMFIRMNAME}',$cname,$body);
		$body = str_replace('{X}',$v_days,$body);
		
		$sub="RFP reminding email";
		//$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
		$to = 'rize.cama@gmail.com';
		$body = "This if for first one<br>".$body;
		$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
		$to = 'vipin3485@gmail.com';
		$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
	} //exit;
//}

}
?>