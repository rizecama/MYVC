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
$follow_emails="SELECT id,followupdate,cust_id,property_id,projectName FROM #__cam_rfpinfo";
$db->Setquery($follow_emails);
$rfps = $db->loadObjectList();

for($r=0; $r<count($rfps); $r++){   ///To get the download links
	$totalfield =  $rfps[$r]->followupdate;
	$totalex = explode(' ', $totalfield);

	$closetime = $totalex[0]. ' ' .$totalex[1];

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
	$diff = $closeddate1-$todatdate;

	if( $diff < 600 && $diff > 300 ){
		$managerid =  $rfps[$r]->cust_id ;
		//To get the manager names
		$db =& JFactory::getDBO();
		$names = "SELECT name, lastname  FROM #__users WHERE  id='".$managerid."'";
		$db->setQuery($names);
		$names_m = $db->loadObject();	
		$m_name = $names_m->name.' '. $names_m->lastname;
		//To get the property name
		$p_name= "SELECT property_name FROM #__cam_property WHERE id='".$rfps[$r]->property_id."' ";
		$db->Setquery($p_name);
		$pname = $db->loadResult();
		//Completed
		$sateesh = 'rize.cama@gmail.com';
		$allen = 'allen@myvendorcenter.com';
		$support = 'support@myvendorcenter.com';
		//Who creates followup date
			
		$adminmail = "SELECT email FROM #__users WHERE id=".$totalex[2]."";
		$db->setQuery($adminmail);
		$adminemail = $db->loadResult();

		$subject = "Followup with {Manager Name} at {RFP} re: {RFP NAME}";
		$sub = str_replace('{Manager Name}',$m_name,$subject);
		$sub = str_replace('{RFP}',$rfps[$r]->id,$sub);		
		$sub = str_replace('{RFP NAME}',$rfps[$r]->projectName,$sub);
		
		//To get the body
		$message = "SELECT introtext FROM #__content WHERE  id=237";
		$db->setQuery($message);
		$body_text = $db->loadResult();
		//Completed		
		$from = "support@myvendorcenter.com";
		$from_name = 'MyVendorCenter.com';
		$bodymain = $body_text;
		$links = "http://myvendorcenter.com/live/administrator/index.php?option=com_camassistant&controller=rfp&task=rfp_bids&rfp_id=".$rfps[$r]->id."&industryid=&rfpstatus=rfp&rfpapproval=1&search=";
		$link = "<a href='http://myvendorcenter.com/live/administrator/index.php?option=com_camassistant&controller=rfp&task=rfp_bids&rfp_id=".$rfps[$r]->id."&industryid=&rfpstatus=rfp&rfpapproval=1&search='>Click Here</a>";
		$body = str_replace('{Click here}',$link,$bodymain);	
		$body = str_replace('{RFP}',$rfps[$r]->id,$body);	
		$body = str_replace('{Association Name}',$pname,$body);	
		
		
class ICS {
    var $data;
    var $name;
    function ICS($start,$end,$name,$description,$location) {
        $this->name = $name;
        $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTART:".date("Ymd\THis\Z",strtotime($start))."\nDTEND:".date("Ymd\THis\Z",strtotime($end))."\nLOCATION:".$location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP:".date("Ymd\THis\Z")."\nSUMMARY:".$name."\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEnd:VALARM\nEnd:VEVENT\nEnd:VCALENDAR\n";
    }
    function save() {
        file_put_contents("components/com_camassistant/assets/ical/".$this->name.".ics",$this->data);
    }
}

$event = new ICS($date3,$date3,"RFP ".$rfps[$r]->id. " followup",  "You have gotten followup email on ".$date3." for RFP ".$rfps[$r]->id." You can see the ITBs page from this link ".$links."","California");
$event->save();

	
		if($rfps[$r]->id){
		$attachment = "/home/allen/public_html/myvendorcenter/live/components/com_camassistant/assets/ical/RFP ".$rfps[$r]->id. " followup.ics";
		JUtility::sendMail($from, $from_name, $sateesh, $sub, $body, $mode=1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
		JUtility::sendMail($from, $from_name, $allen, $sub, $body, $mode=1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
		JUtility::sendMail($from, $from_name, $support, $sub, $body, $mode=1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
		JUtility::sendMail($from, $from_name, $adminemail, $sub, $body, $mode=1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
		}
	}	//Closing for loop
}

?>
