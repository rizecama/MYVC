<?PHP
//$loginID		= "6pBcEYY9LJ5m ";
//$transactionKey = "28qW9d28EYmL59vz";
//visacard =  4864103139988256
$post_url = "https://secure.authorize.net/gateway/transact.dll";
$description 	= "CAMassistant Vendor Membership Payment";
$label 			= "Submit Payment"; 

if (array_key_exists("cost",$_REQUEST))
	{ $amount = $_REQUEST["cost"]; }
if (array_key_exists("amount",$_REQUEST))
	{ $description = $_REQUEST["description"]; }
if (array_key_exists("Auth_key",$_REQUEST))
	{ $transactionKey = $_REQUEST["Auth_key"]; }
if (array_key_exists("Auth_login_id",$_REQUEST))
	{ $loginID = $_REQUEST["Auth_login_id"]; }	
if (array_key_exists("Cardnumber",$_REQUEST))
	{ $Cardnumber = $_REQUEST["Cardnumber"]; }	
if (array_key_exists("address",$_REQUEST))
	{ $address = $_REQUEST["address"]; }	
if (array_key_exists("city",$_REQUEST))
	{ $city = $_REQUEST["city"]; }	
if (array_key_exists("states",$_REQUEST))
	{ $states = $_REQUEST["states"]; }	
if (array_key_exists("zipcode",$_REQUEST))
	{ $zipcode = $_REQUEST["zipcode"]; }
if (array_key_exists("user_id",$_REQUEST))
	{ $user_id = $_REQUEST["user_id"]; }
if (array_key_exists("Itemid",$_REQUEST))
	{ $Itemid = $_REQUEST["Itemid"]; }	
if (array_key_exists("ExpMon",$_REQUEST))
	{ $ExpMon = $_REQUEST["ExpMon"]; }	
if (array_key_exists("ExpYear",$_REQUEST))
	{ $ExpYear = $_REQUEST["ExpYear"]; }
if (array_key_exists("name",$_REQUEST))
	{ $name = $_REQUEST["name"]; }	
if (array_key_exists("lastname",$_REQUEST))
	{ $lastname = $_REQUEST["lastname"]; }
if (array_key_exists("companyname",$_REQUEST))
	{ $companyname = $_REQUEST["companyname"]; }
if (array_key_exists("email",$_REQUEST))
	{ $email = $_REQUEST["email"]; }
if (array_key_exists("company_phone",$_REQUEST))
	{ $company_phone = $_REQUEST["company_phone"]; }
	$ExpYear=substr($ExpYear,'-2');
$ccexp=	$ExpMon.$ExpYear;
//echo $user =& JFactory::getUser($user_id);
$firstname=$name;
$lastname=$lastname;
$db = JFactory::getDBO();
$sql = "SELECT state_name FROM #__state where id = ".$states;
$db->Setquery($sql);
$state_name = $db->loadResult();
/*print_r($companyname); echo "<br>";
print_r($email); echo "<br>";
print_r($company_phone); exit;*/
$post_values = array(
	"x_login"			=> $loginID,
	"x_tran_key"		=> $transactionKey,
	"x_version"			=> "3.1",
	"x_delim_data"		=> "TRUE",
	"x_delim_char"		=> "|",
	"x_relay_response"	=> "FALSE",
	"x_type"			=> "AUTH_CAPTURE",
	"x_method"			=> "CC",
	"x_card_num"		=> $Cardnumber,
	"x_exp_date"		=> $ccexp,
	"x_amount"			=> $amount,
	"x_description"		=> $description,
	"x_first_name"		=> $firstname,
	"x_address"			=> $address,
	"x_state"			=> $state_name,
	"x_zip"				=> $zipcode,
	"x_city"			=> $city,
	"x_company"			=> $companyname,
	"x_email"			=> $email,
	"x_phone"			=> $company_phone
);


$post_string = "";
foreach( $post_values as $key => $value )
	{ $post_string .= "$key=" . urlencode( $value ) . "&"; }
$post_string = rtrim( $post_string, "& " );

$request = curl_init($post_url);
	curl_setopt($request, CURLOPT_HEADER, 0);
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
	$post_response = curl_exec($request);
	
	
curl_close ($request);


$response_array = explode($post_values["x_delim_char"],$post_response);
//echo "<pre>"; print_r($response_array); exit;
//code to save tx details to database
$insert_sql = "INSERT into #__cam_vendor_payment_TX_details VALUES('','".$response_array[0]."','".$response_array[3]."','".date('Y-m-d h:i')."','".$response_array[9]."','".$response_array[13]."','".$response_array[14]."','".$response_array[23]."')";
$db->Setquery($insert_sql);
$db->query();
//end-code to save tx details to database
if($response_array[3] == 'This transaction has been approved.' && $response_array[0] == 1)
{
	$task = 'vendorsignup_p3';
	$mailfrom = 'payment@camassistant.com';
	$fromname = 'Camassistant Team';
	$mailsubject = 'Payment has been approved';
	//$body = $body_content; 
	//$body = "Hi ".$_SESSION['user']['name']."! <br/>Your Payment has been approved successfully.<br/><br/>At Your Service,<br/><br/>CAMassistant.com";
	$db = JFactory::getDBO();
	$payment = "SELECT introtext  FROM #__content where id='165'";
	$db->Setquery($payment);
	$vendormsg = $db->loadResult();
	/*$vendorname = $_SESSION['user']['name'];
	$vendorlastname = $_SESSION['user']['lastname'];*/
	$vendorname = $response_array[13]; //first name
	$vendorlastname = $response_array[14]; //last name
	$fullname = $vendorname.'&nbsp;'.$vendorlastname;
	$body = str_replace('{VENDORNAME}',$fullname,$vendormsg) ;
	$body = str_replace('{FEE}',$amount,$body) ;
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
?>
<!--<form name="Authorizefrm"  />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="vendorsignup" />
<input type="hidden" name="task" value="<?PHP //echo $task; ?>" />
<input type="hidden" name="user_id" value="<?PHP  //echo $user_id; ?>" />
<input type="hidden" name="Itemid" value="144" />
<input type="hidden" name="pack_cost" value="<?PHP  //echo $amount; ?>" />


</form>
<script language="javascript">
document.Authorizefrm.submit();
</script>
-->