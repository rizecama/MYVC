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


$link = mysql_connect('localhost', 'allen_camauser', 'kRuxt#&[$f8*');
if (!$link)
{
	die('Could not connect:' . mysql_error());
}
echo $today = date('Y-m-d h:i');
//$todatdate= strtotime($today);
//echo   $todatdate;
$db_selected = mysql_select_db('allen_cam', $link);

$result = mysql_query("SELECT  *  FROM jos_cam_rfpinfo");
while($row = mysql_fetch_array($result))
  {
		$closetime =  $row['proposalDueDate'] . " " . $row['proposalDueTime'];
		// print_r( $closetime); echo "<br><br>";
		//$date= str_replace('PM','',$closetime); 
		//$date1= str_replace('AM','',$date); 
		$date2= explode('-',$closetime);
		$date= $date2[1];
		$month= $date2[0];
		$year1= $date2[2];
		$year2= explode(' ',$year1);
		$year = $year2[0];
		$time = $year2[1];
		$date3= $year.'-'.$month.'-'.$date.' '.$time;
		//$date4= JHTML::_('date', $$date3, '%Y-%m-%d %H:%M');
		//echo '<pre>'; print_r($date3); 
	
		
		$closeddate= strtotime($date3);
		$today = date('Y-m-d H:i');
		$todatdate= strtotime($today);
		$db =& JFactory::getDBO();
		$row['id']='941322';
		$property_id='153';
		 $property_name ="SELECT property_name FROM #__cam_property where id=".$property_id;
 	 	$db->Setquery($property_name);
  		$property_name = $db->loadResult();
  		$property_name = str_replace(" ", "_", $property_name);

 $sql = 'SELECT C.comp_name, U.name, U.lastname, U.email, P.property_name, R.id, R.industry_id FROM #__cam_rfpinfo as R
		LEFT JOIN  #__cam_customer_companyinfo as C ON R.cust_id = C.cust_id  
		LEFT JOIN  #__cam_property as P ON R.property_id = P.id  
		LEFT JOIN  #__users as U ON R.cust_id = U.id WHERE R.id ='.$row['id'];
		$db->Setquery($sql);
		$comp_name = $db->loadResult();
		
if($todatdate >= $closeddate){
		//$result1 = mysql_query("UPDATE jos_cam_rfpinfo SET rfp_type  = 'closed' WHERE id= ".$row['id']." AND rfp_type='rfp' ");
		}
		echo $link1 = 'http://camassistant.com/live/PropertyDocuments/'.$property_name.'/ProposalReports/RFP'.$row['id'].'/'.$row['id'].'_'.$comp_name.'.pdf';
		exit;
if($date3 == $today){
		$db =& JFactory::getDBO();
		$manager="SELECT email FROM #__users where id=".$row['cust_id']."";
		$db->Setquery($manager);
		$manager = $db->loadResult();

		$to = $manager;
		echo $link1 = 'http://camassistant.com/live/PropertyDocuments/'.$property_name.'/ProposalReports/RFP'.$row['id'].'/'.$row['id'].'_'.$comp_name.'.pdf';
		exit;
		$link = '<a href='.$link1.'>'.$link.'</a>';
		$support = 'support@camassistant.com';
		$sub = "RFP closing email";
		$message = "The RFP ".$row['id']." is closed";
		//completed
		$body = $message."<br><br>Thanks<br>CAMassistant";
		$from = "support@camassistant.com";
		$from_name = 'CAMassistant';
		//$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
		//$successMail =JUtility::sendMail($from, $from_name, $support, $sub, $body,$mode = 1);
		
		//to send the board members
		$board_members="SELECT email FROM #__cam_board_mem where user_id=".$row['cust_id']."";
		$db->Setquery($board_members);
		$bmembers = $db->loadObjectList();
		for($b=0; $b<=count($bmembers); $b++){
		//$bto = $bmembers[$b]->email;
		//$successMail =JUtility::sendMail($from, $from_name, $bto, $sub, $body,$mode = 1);
		}
		//completed
			}
	//$closeddate = $closeddate+600;
	/*if($todatdate == $closeddate){
	$from = 'support@camassistant.com';
	$to = $manager;
	$from_name = 'CAMassistant';	
	$sub = 'Closing RFP';
	$body = 'RFP closed';
	$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
	}		*/
 		}
?>
