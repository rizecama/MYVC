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


	//Completed
	$body = 'This is for testing to find the crons are running or not...';
	$from='support@myvendorcenter.com';
	$from_name='MyVendorCenter.com';
	$sub = 'Test Run';
	$to = 'rize.cama@gmail.com';
	$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1);
			
			
?>