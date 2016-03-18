<?PHP
//$loginID		= "6pBcEYY9LJ5m ";
//$transactionKey = "28qW9d28EYmL59vz";
$post_url = "https://test.authorize.net/gateway/transact.dll";
$description 	= "Sample Transaction";
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
	"x_exp_date"		=> "0115",

	"x_amount"			=> $amount,
	"x_description"		=> "Sample Transaction",

	"x_first_name"		=> "John",
	"x_last_name"		=> "Doe",
	"x_address"			=> $address,
	"x_state"			=> $states,
	"x_zip"				=> $zipcode
	
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
//echo "<pre>"; print_r($response_array[3]); exit;
if($response_array[3] == 'This transaction has been approved.')
$task = 'vendor_billing_thankyou_form';
else
$task = 'vendor_billing_failed_form';
//$url = 'index.php?option=com_camassistant&controller=vendors&task=vendor_billing_thankyou_form';
//$url = 'index.php?option=com_camassistant&controller=vendors&task=vendor_billing_failed_form';

/*echo "<OL>\n";
foreach ($response_array as $value)
{
	echo "<LI>" . $value . "&nbsp;</LI>\n";
	$i++;
}
echo "</OL>\n";*/
?>
<form name="Authorizefrm" action="<?PHP  echo $url; ?>" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="vendors" />
<input type="hidden" name="task" value="<?PHP echo $task; ?>" />
<input type="hidden" name="user_id" value="<?PHP  echo $user_id; ?>" />
<input type="hidden" name="Itemid" value="140" />
<input type="hidden" name="pack_cost" value="<?PHP  echo $amount; ?>" />
</form>
<script language="javascript">
document.Authorizefrm.submit();
</script>
