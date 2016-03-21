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
$total_props="SELECT property_manager_id,id  FROM jos_cam_property ";
$db->Setquery($total_props);
$row = $db->loadObjectList();

for($i=0;$i<=count($row);$i++){

$usertype="SELECT user_type  FROM jos_users where id=".$row[$i]->property_manager_id." ";
$db->Setquery($usertype);
$type = $db->loadResult();
if($type==12){
$query_company = "SELECT comp_id FROM #__cam_customer_companyinfo WHERE cust_id=".$row[$i]->property_manager_id;
	$db->setQuery($query_company);
	$comp_id = $db->loadResult();
		
	$query_cam = "SELECT U.id FROM #__users as U, #__cam_camfirminfo as V  where V.id  =".$comp_id." and U.id= V.cust_id"  ;
	$db->setQuery($query_cam);
    $camfirmid=$db->loadResult();
	
$update = "UPDATE jos_cam_property SET camfirmid=".$camfirmid." WHERE id='".$row[$i]->id."'"; 
	$db->Setquery($update);
	$db->query();
}}

?>
