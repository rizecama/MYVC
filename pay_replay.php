<style>
.loader{
background: url("templates/camassistant_left/images/loading_icon.gif") no-repeat scroll 0 0 transparent;
    display: block;
    height: 22px;
    padding-left: 41px;
    width: 400px;
	color: #21314D;
	font-size:17px;
	font-weight:bold;
}

</style>
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

$cost = $_REQUEST['AMT'];
$approve = $_REQUEST['RESPMSG'];
$name = $_REQUEST['FIRSTNAME'];
$lastname = $_REQUEST['LASTNAME'];


if($approve == 'Approved')   {
$mailfrom = 'payment@camassistant.com';
	$fromname = 'Camassistant Team';
	$mailsubject = 'Payment has been approved';
	//$body = $body_content; 
	//$body = "Hi ".$_SESSION['user']['name']."! <br/>Your Payment has been approved successfully.<br/><br/>At Your Service,<br/><br/>CAMassistant.com";
	$db = JFactory::getDBO();
	$payment = "SELECT introtext FROM #__content where id='165'";
	$db->Setquery($payment);
	$vendormsg = $db->loadResult();
	/*$vendorname = $_SESSION['user']['name'];
	$vendorlastname = $_SESSION['user']['lastname'];*/
	$vendorname = $name; //first name
	$vendorlastname = $lastname; //last name
	$fullname = $vendorname.'&nbsp;'.$vendorlastname;
	$body = str_replace('{VENDORNAME}',$fullname,$vendormsg) ;
	$body = str_replace('{FEE}',$cost,$body) ;
	$mailfrom = 'payment@camassistant.com';
	$fromname = 'Camassistant Team';
	$assignuseremail = $_REQUEST['EMAIL']; //email
	JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
	?>
	<p class='loader'>Payment transaction is on processing please wait untill redirect...</p>
<script type="text/javascript">
setTimeout('window.parent.location.href="https://camassistant.com/live/index.php?option=com_camassistant&controller=vendorsignup&task=vendorsignup_p3&user_id=&Itemid=144&pack_cost=<?php echo $cost; ?>&approved=<?php echo $approve; ?>"',10000)
 </script>

	<?php 
}	
 else{  ?>
 <p class='loader_text'>There is a problem processing your credit card. Please verify that you have entered the correct details.</p>
 <br />
 <a href="#" onclick='window.parent.location.href="https://camassistant.com/live/index.php?option=com_camassistant&controller=vendorsignup&task=payment&address=&city=&name=<?php echo $_REQUEST['name']; ?>&lastname=<?php echo $_REQUEST['lastname']; ?>&companyname=&email=<?php echo $_REQUEST['EMAIL']; ?>&payment_type=Paypal&pack_cost=<?php echo $_REQUEST['AMT']; ?>&Itemid=140"'>Please click here to go back to the Payment page </a>

<script type="text/javascript">
//setTimeout('window.parent.location.href="https://camassistant.com/live/index.php?option=com_camassistant&controller=vendorsignup&task=payment&address=&city=&name=<?php //echo $_REQUEST['name']; ?>&lastname=<?php //echo $_REQUEST['lastname']; ?>&companyname=&email=<?php// echo $_REQUEST['EMAIL']; ?>&payment_type=Paypal&pack_cost=<?php //echo $_REQUEST['AMT']; ?>&Itemid=140"',10000)
 </script>
 
<?php  }
?>
 


