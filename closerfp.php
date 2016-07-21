


#!/usr/bin/php
<?php   
define( '_JEXEC', 1 );
define('JPATH_BASE', str_replace('/cron_testing','',dirname(__FILE__)) );
define( 'DS', DIRECTORY_SEPARATOR );
/* Required Files */
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
/* To use Joomla's Database Class */
require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
/* Create the Application */
$mainframe =& JFactory::getApplication('site');

$today = strtotime(date('Y-m-d H:i')); 
/* Create a database object */
$db =& JFactory::getDBO();
$total_rfps="SELECT id,cust_id, proposalDueDate,biddingcloseddate  FROM jos_cam_rfpinfo where rfp_type='Unawarded' ";
$db->Setquery($total_rfps);
$row = $db->loadObjectList();

for($i=0;$i<=count($row);$i++){
	if($row[$i]->biddingcloseddate == ''){
	$sql_emails = "UPDATE jos_cam_rfpinfo SET biddingcloseddate  = '".$row[$i]->proposalDueDate."' WHERE id= '".$row[$i]->id."'  "; 
	$db->Setquery($sql_emails);
	$db->query();
	}
}

?>
