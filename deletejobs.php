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
$db =& JFactory::getDBO();
$sql_rfps = "SELECT id,user_id, rfp_id from #__cam_vendor_availablejobs group by rfp_id, user_id having count(*)>1";
$db->setQuery($sql_rfps);
$rows = $db->loadObjectList();
foreach($rows as $row){
$sql_rfp = "SELECT count(*) as availjobs from #__cam_vendor_availablejobs where rfp_id = ".$row->rfp_id." and user_id= ".$row->user_id.""; echo "<br>";
$db->setQuery($sql_rfp);
$result = $db->loadResult();


if($result >1){
$rfp_delete = "delete from #__cam_vendor_availablejobs where rfp_id = ".$row->rfp_id." and user_id= ".$row->user_id." limit ".($result-1)." ";
$db->setQuery($rfp_delete);
$db->Query($rfp_delete);

}
}
?>
