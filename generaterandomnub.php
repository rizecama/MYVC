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
 $code = "SELECT lastname,id FROM #__users where user_type !=16 AND user_type !=11 ";
$db->setQuery( $code );
$code = $db->loadObjectList();
$len = count($code);
$min = 10000; // minimum
$max = 99999; // maximum
$range[] = '';
foreach (range(0, $len - 1) as $i) {
   
    while(in_array($num = mt_rand($min, $max), $range));
    $range[] = $num;
}

for ($i=0; $i<count($code); $i++)
{
$lastname = $code[$i]->lastname;

$link = $range[$i];
$inviecodes =$lastname.$link;

$update = "UPDATE #__users SET manager_invitecode='".$inviecodes."' where id = ".$code[$i]->id."";
$db->setQuery($update);
$db->query();

}
?>