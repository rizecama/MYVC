<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
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


$dir = JPATH_BASE;
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
	$extension = end(explode('.', $filename));
	$first = substr($filename,0,3);
	if($extension == 'pdf' && $first == 'RFP'){
 	unlink($filename);
	}
}


?>

