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
echo $today = strtotime(date('Y-m-d H:i:s')); echo "<br>";
//echo strtotime($today); 
/* Create a database object */
$db =& JFactory::getDBO();
$total_rfps="SELECT id,approve_date,cust_id,industry_id,property_id,choose_tasks FROM #__cam_rfpinfo ";
$db->Setquery($total_rfps);
$row = $db->loadObjectList();
for($i=0;$i<=count($row);$i++){
$todayDate = $row[$i]->approve_date;
$currentTime = strtotime($row[$i]->approve_date);
//$currentTime = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
//echo $row[$i]->id;
$timeAfterOneHour = $currentTime+(60*10);

//echo "<br>Current Date and Time: ".date("Y-m-d H:i:s",$currentTime);
//echo "<br>Date and Time After adding one hour: ".date("Y-m-d H:i:s",$timeAfterOneHour);
echo "<br>";
if($timeAfterOneHour>=$today){
echo $timeAfterOneHour."==".$today."<br>";  
}
else{
echo $timeAfterOneHour."!=".$today."<br>";  
}
}
?>