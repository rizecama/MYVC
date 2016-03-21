#!/usr/bin/php
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
$today = strtotime(date('Y-m-d H:i:s')); 
/* Create a database object */
$db =& JFactory::getDBO();
$total_rfps="SELECT id,approve_date,cust_id,industry_id,property_id,choose_tasks FROM #__cam_rfpinfo where note_email=0 ORDER BY id ASC";
$db->Setquery($total_rfps);
$row = $db->loadObjectList();
for($i=0;$i<=count($row);$i++){
$approvaltime = strtotime($row[$i]->approve_date);
$diff = ($today-$approvaltime)/60;
if($diff >1440 && $diff < 1441){

$normal_vendors="SELECT user_id,rfp_id,vendor_type,rfp_creator FROM #__cam_rfp_emails where rfp_id=".$row[$i]->id." and publish=0";
$db->Setquery($normal_vendors);
$normal_vendors = $db->loadObjectList();

$choose_tasks = $row[$i]->choose_tasks;
$property_id = $row[$i]->property_id;
if($choose_tasks=='3'){
$article_id='155';
} else if(($choose_tasks=='2')||($choose_tasks=='2choose')||($choose_tasks=='Engineer')||($choose_tasks=='Architect')){
$article_id = '154';
} else {
$article_id = '162';
}


for($n=0; $n<=count($normal_vendors); $n++){
//To get the manager information
	$rfp_creator = "SELECT name,lastname,id FROM #__users where id='".$normal_vendors[$n]->rfp_creator."'";
	$db->setQuery($rfp_creator);
	$firm_details = $db->loadObjectList();
	$Managername = $firm_details[0]->name."&nbsp;".$firm_details[0]->lastname;
//Completed
//to get the camfirm details
	$camfirmid_sql = "SELECT comp_id FROM #__cam_customer_companyinfo WHERE cust_id=".$normal_vendors[$n]->rfp_creator;
	$db->SetQuery($camfirmid_sql);
	$camfirmid_res = $db->loadResult();

	if($camfirmid_res == '0')
	$Camfirmname = '';

	else
	{
	  $camfirmid_sql = "SELECT cust_id FROM #__cam_camfirminfo  WHERE id=".$camfirmid_res;
	  $db->SetQuery($camfirmid_sql);
	  $camfirmid_res = $db->loadResult();
	  $camfirmuser = JFactory::getUser($camfirmid_res);
	  $Camfirmname = $camfirmuser->name.'&nbsp;'.$camfirmuser->lastname;
	}
//Completed
$avail_id = "SELECT id FROM #__cam_vendor_availablejobs  WHERE rfp_id=".$row[$i]->id." AND user_id=".$normal_vendors[$n]->user_id."";
$db->SetQuery($avail_id);
$ajob_id = $db->loadResult();
//$siteURL		= JURI::root();	  
$link ='https://myvendorcenter.com/live/index.php?option=com_camassistant&controller=proposals&Itemid=148&task=vendor_proposal_form&view=proposals&amp;Prp_id='.$property_id.'&id='.$ajob_id.'&rfp_id='.$row[$i]->id.'';
	
	///To get the vendors information
$vendorid= "SELECT email,name,lastname FROM #__users where id=". $normal_vendors[$n]->user_id; 
	$db->setQuery($vendorid);
	$vendor_details = $db->loadObject(); 
	$vendorname= $vendor_details->name."&nbsp;".$vendor_details->lastname;	
	$vendoremail= $vendor_details->email;	
//Completed
$rfpinvite = "SELECT introtext  FROM #__content where id='".$article_id."'";
$db->setQuery($rfpinvite);
$body = $db->loadResult();

//echo "<br>"; echo "VENDOR ANME:".$vendorname; echo "<br>";
	$body = str_replace('{RFP NUMBER}', $row[$i]->id, $body);
	$body = str_replace('{RFP NUMBER}',sprintf('%06d', $row[$i]->id), $body);
	$body = str_replace('{vendor Name}', $vendorname, $body);
	$body = str_replace('{link}', '<a href="'.$link.'">CLICK HERE</a>', $body);
	$body = str_replace('{CLICK HERE link}', '<a href="'.$link.'">CLICK HERE</a>', $body);
	$body = str_replace('{camName}', 'CAMassitant', $body);
	$body = str_replace('{Managername}', $Managername, $body);
	$body = str_replace('{Camfirmname}', $Camfirmname, $body);
	$sub='RFP Invitation from CAMassistant';
	$from_name='CAMassistant Support';
	$from_email='Support@CAMassistant.com';
//echo "BODY".$body; echo "<br>";
	$successMail =JUtility::sendMail($from_email, $from_name, $vendoremail, $sub, $body,$mode = 1);
	$successMail =1;
	if($successMail == 1){
	$sql_emails = "UPDATE #__cam_rfp_emails SET publish=1 WHERE user_id='".$normal_vendors[$n]->user_id."'"; 
	$db->Setquery($sql_emails);
	$db->query();

	$sql_availjobs = "UPDATE #__cam_vendor_availablejobs SET publish=1 WHERE user_id='".$normal_vendors[$n]->user_id."'"; 
	$db->Setquery($sql_availjobs);
	$db->query();

	$sql_availjobs = "UPDATE #__cam_rfpinfo SET note_email=1 WHERE id='".$row[$i]->id."'"; 
	$db->Setquery($sql_availjobs);
	$db->query();
	}
}///Send invitation to normal vendors
//$appdate_day = date('Y-m-d h:i:s',strtotime('+1 day', strtotime($row[$i]->approve_date))); 

}////difference condition
}/// all rfps for loop
