<?php
// Include config file
//require_once('includes/config.php');


//$api_username  = 'allen_api1.camassistant.com';
$api_username  = 'accounting_api1.camassistant.com';
//$api_password = 'LM36K8M6LERMEK4H';
$api_password = 'M2BTUK6X9Y3USB9E';
//$api_signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AW4TYrdkx2tMmnVIIwC077NgBGY0';
$api_signature = 'AjE.ZewL5mG6AiztkysoRpX08PrkAPefU6ogzPSYce9zfd9.VuO8QUxN';
$api_version = '67.0';
//$api_endpoint='https://api.sandbox.paypal.com/nvp';
$api_endpoint='https://api-3t.paypal.com/nvp/';

$cardtype = $_REQUEST['cardtype'];
$Cardnumber = $_REQUEST['Cardnumber'];
$address = $_REQUEST['address'];
$city = $_REQUEST['city'];
$name = $_REQUEST['name'];
$lastname = $_REQUEST['lastname'];
$states = $_REQUEST['states'];
$ExpMon = $_REQUEST['ExpMon'];
$ExpYear = $_REQUEST['ExpYear'];
$zipcode = $_REQUEST['zipcode'];
$cost = $_REQUEST['cost'];
$vvcode = $_REQUEST['vvcode'];
$street = $_REQUEST['street'];

if($cardtype == 'VisaCard'){
$cardtype = substr($cardtype, 0, 4);
}

$db = JFactory::getDBO();
$sql = "SELECT state_id FROM #__state where id = ".$states;
$db->Setquery($sql);
$state_name = $db->loadResult();
$state_name = strtoupper($state_name);

// Store request params in an array
	$request_params = array
	(
	'METHOD' => 'DoDirectPayment', 
	'USER' => $api_username, 
	'PWD' => $api_password, 
	'SIGNATURE' => $api_signature, 
	'VERSION' => $api_version, 
	'PAYMENTACTION' => 'Sale', 					
	'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
	'CREDITCARDTYPE' => $cardtype, 
	'ACCT' => $Cardnumber, 						
	'EXPDATE' => $ExpMon.$ExpYear,	
	'CVV2' => $vvcode, 
	'FIRSTNAME' => $name, 
	'LASTNAME' => $lastname, 
	'STREET' => $street, 
	'CITY' => $city, 
	'STATE' => $state_name, 					
	'COUNTRYCODE' => 'US', 
	'ZIP' => $zipcode, 
	'AMT' => $cost, 
	'CURRENCYCODE' => 'USD', 
	'DESC' => 'Payments Advanced' 
	);
	
	//echo "<pre>"; print_r($request_params) ; 
	// Loop through $request_params array to generate the NVP string.
	$nvp_string = '';
	foreach($request_params as $var=>$val)
	{
	$nvp_string .= '&'.$var.'='.urlencode($val);	
	}

// Send NVP string to PayPal and store response
$curl = curl_init();
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_URL, $api_endpoint);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

$result = curl_exec($curl);
//echo $result.'<br /><br />';
curl_close($curl);

// Parse the API response
$result_array = NVPToArray($result);


// Function to convert NTP string to an array
function NVPToArray($NVPString)
{
	$proArray = array();
	while(strlen($NVPString))
	{
		// name
		$keypos= strpos($NVPString,'=');
		$keyval = substr($NVPString,0,$keypos);
		// value
		$valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
		$valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
		// decoding the respose
		$proArray[$keyval] = urldecode($valval);
		$NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
	}
	return $proArray;
}

//Furthar process
//echo "<pre>"; print_r($result_array); exit;
if($result_array['ACK'] == 'Success' || $cost == '0')
{
	$task = 'vendorsignup_p3';
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
	$assignuseremail = $response_array[23]; //email
	JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
}
else
{
	$task = 'vendor_billing_failed_form';
	$mailfrom = 'payment@camassistant.com';
	$fromname = 'Camassistant Team';
	$mailsubject = 'Payment has been declined';
	$db = JFactory::getDBO();
	$payment = "SELECT introtext  FROM #__content where id='196'";
	$db->Setquery($payment);
	$vendormsg = $db->loadResult();
	$vendorname = $response_array[13]; //first name
	$assignuseremail = $response_array[23]; //email
	//$assignuseremail = 'vipin3485@gmail.com';
	$body = str_replace('{USERNAME}',$vendorname,$vendormsg) ;
	$body = str_replace('{EMAIL}',$response_array[23],$body) ;
	$body = str_replace('{FEE}',$amount,$body) ;
	$body = str_replace('{ERRORCODE}',$response_array[0],$body) ;
	$body = str_replace('{ERRORMSG}',$response_array[3],$body) ;
	JUtility::sendMail($mailfrom, $fromname, $assignuseremail, $mailsubject, $body,$mode = 1);
}

header("Location:index.php?option=com_camassistant&controller=vendorsignup&task=".$task."&user_id=".$user_id."&Itemid=144&pack_cost=".$amount);


//Completed
?>