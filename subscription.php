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
$inactiveaccounts = "SELECT id FROM #__users where subscribe!='yes' and block=0 and user_type=11 ";
$db->Setquery($inactiveaccounts);
$inc = $db->loadObjectList();


for($r=0; $r<count($inc); $r++){   ///To get the download links
	$sql_up = "UPDATE #__users SET subscribe='yes', subscribe_sort='4', subscribe_type='free', subscribe_admin='free' WHERE id='".$inc[$r]->id."'";
	$db->setQuery($sql_up);
	$res = $db->query();
	
	$date = date('Y-m-d'); 
	$nextdate = date('Y-m-d', strtotime('+1 year'));
	
	$query = "insert into #__cam_vendor_subscriptions (`id`, `vendorid`, `coupon`, `paid`, `ctype`, `subscribeid`, `date`, `nextdate`) VALUES ('','".$inc[$r]->id."','','0.00','free','A-AAAAAAAAAAAA','".$date."','".$nextdate."')";
		$db->setQuery($query);
		$db->query();
}
?>