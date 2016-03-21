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
$closed_rfp="SELECT vid,userid FROM #__vendor_inviteinfo ";
$db->Setquery($closed_rfp);
$rfps = $db->loadObjectList();
//echo "<pre>"; print_r($rfps); 

for($r=0; $r<count($rfps); $r++){

		$getc = "SELECT comp_id FROM #__cam_customer_companyinfo where cust_id =".$rfps[$r]->userid."  ";
		$db->setQuery($getc);
		$companyid = $db->loadResult();
		if($companyid == '0'){
			$getcid = "SELECT id FROM #__cam_camfirminfo where cust_id =".$rfps[$r]->userid."  ";
			$db->setQuery($getcid);
			$companyid = $db->loadResult();
			$sql_updateindustry = "UPDATE #__vendor_inviteinfo SET taxid='".$companyid."' WHERE vid='".$rfps[$r]->vid."'";
			$db->Setquery($sql_updateindustry);
			$db->query();
		}
		else{
		$sql_updateindustry = "UPDATE #__vendor_inviteinfo SET taxid='".$companyid."' WHERE vid='".$rfps[$r]->vid."'";
		$db->Setquery($sql_updateindustry);
		$db->query(); 
		}
}
?>