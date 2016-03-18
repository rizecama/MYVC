
<?php
/**
 * @Copyright Copyright (C) 2009- ... virginsoft
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @author Prakash Sahu
 * @package Joomla
 * @subpackage ajaxregistration
 *
 * AjaxRegistration 
 *
 *
 */

defined('_JEXEC') or die('Restricted access'); 

error_reporting(0);

$UserId=$_GET['user'];
$Email=$_GET['email'];
print_r($Email);
$db		=& JFactory::getDBO();

if ( $UserId != "")
	{
		
		$query="SELECT username FROM #__users WHERE username='$UserId'";
		$db->setQuery( $query );
		$result = $db->loadObjectList();
		if ( $result )
			{
	
				echo "invalid";
	
			}
		else 
			{
				echo "valid";
			}
	}
if ( $Email != "")
	{
		
		$query_email="SELECT email FROM #__users WHERE email='$Email'";
		$db->setQuery( $query_email );
		$result_email = $db->loadObjectList();
		if ( $result_email )
			{
				echo "invalid";
			}
		else 
			{
				echo "valid";
			}
	}
		
?>
