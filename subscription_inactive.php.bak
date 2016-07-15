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

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime(' -1 day')) ;
$db =& JFactory::getDBO();
$all_vendors = "SELECT id FROM #__users where user_type='11' ";
$db->Setquery($all_vendors);
$vendors = $db->loadObjectList();
	for( $v=0; $v<count($vendors); $v++ ){
	$query_expired = "SELECT nextdate FROM #__cam_vendor_subscriptions where vendorid='".$vendors[$v]->id."' and paid!='admin' and ctype!='free' order by nextdate DESC ";
		$db->Setquery($query_expired);
		$date_exp = $db->loadResult();
		if( $date_exp == $yesterday ){
		$sql_up = "UPDATE #__users SET subscribe='', subscribe_type='', subscribe_sort='', subscribe_admin='' WHERE id='".$vendors[$v]->id."'";
		$db->Setquery($sql_up);
		if( $db->query() ){
			$sql12="SELECT introtext  FROM #__content where id='284' ";
			$db->Setquery($sql12);
			$body = $db->loadResult();
			
			$sql_vname="SELECT company_name  FROM #__cam_vendor_company where user_id=".$vendors[$v]->id  ;
			$db->Setquery($sql_vname);
			$vendorcompany = $db->loadResult();
			
			// To get the email and CC email
			$vendorinfo = "SELECT email, ccemail FROM #__users where id=".$vendors[$v]->id  ;
			$db->Setquery($vendorinfo);
			$vendormail = $db->loadObject();
			$to = $vendormail->email;
			//Completed
			$body = str_replace('(Vendor_Company_Name)',$vendorcompany,$body);
			$from='support@myvendorcenter.com';
			$from_name='MyVendorCenter.com';
			$sub = 'Please reactivate your account';
			$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
			
			$to_sateesh = 'rize.cama@gmail.com';
			$successMail =JUtility::sendMail($from, $from_name, $to_sateesh, $sub, $body,$mode = 1);
			$to_support = 'vendoremails@myvendorcenter.com';
			$successMail =JUtility::sendMail($from, $from_name, $to_support, $sub, $body,$mode = 1);
			// Sending mail to CC email
			$ccemails = $vendormail->ccemail;
			$cc_exploade = explode(';', $ccemails);
			for( $c=0; $c<count($cc_exploade); $c++ ){
			$to = $cc_exploade[$c] ;
			$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
			}
			//COmpleted
		}
		}
	}
?>