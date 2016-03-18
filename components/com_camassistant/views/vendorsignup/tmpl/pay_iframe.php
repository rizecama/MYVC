<?php if(!$_REQUEST['approved']) { ?>
<?php /*?><p style="color:#20314D;font-family: caption; font-size: 24px;font-weight: bold; padding-left:15px;">Applied Promo Code: <?php echo $_REQUEST['promocode']; ?></p><?php */?>
<p style="color:#20314D;font-family: Arial; font-size: 24px;font-weight: bold; margin-top:10px; margin-left:15px;">
<?php $money = str_replace('$','',$_REQUEST['pack_cost']); ?>
Amount Due: $<?php echo str_replace('.00','',$money); ?>.00</p>
<?php } ?>

<?php
if($_REQUEST['pack_cost'] != '0') {
if($_REQUEST['approved'] == '') {
session_start();
global $environment;
$environment = "live";
require_once('components/com_camassistant/views/vendorsignup/tmpl/PayflowNVPAPI.php');
if (isset($_POST['RESULT']) || isset($_GET['RESULT']) ) {
  $_SESSION['payflowresponse'] = array_merge($_GET, $_POST);
  echo '<script type="text/javascript">alert(script_url()); window.parent.location.href = "' . script_url() .  '";</script>';
  exit(0);
}
if(!empty($_SESSION['payflowresponse'])) {
  $response= $_SESSION['payflowresponse'];
  unset($_SESSION['payflowresponse']);
  $success = ($response['RESULT'] == 0);
  if($success) echo "<span style='font-family:sans-serif;font-weight:bold;'>Transaction approved! Thank you for your order.</span>";
  else echo "<span style='font-family:sans-serif;'>Transaction failed! Please try again with another payment method.</span>";
  echo "<pre>(server response follows)\n";
  print_r($response);
  echo "</pre>";
  exit(0);
}
$request = array(
  "PARTNER" => "PayPal",
  "VENDOR" => "CAMassistant",
  "USER" => "CAMassistant",
  "PWD" => "CAMa0519100", 
  "TRXTYPE" => "S",
  "AMT" =>  $_REQUEST['pack_cost'],
  "CURRENCY" => "USD",
  "CREATESECURETOKEN" => "Y",
  "SECURETOKENID" => uniqid('MySecTokenID-'), //Should be unique, never used before
  "RETURNURL" => "https://camassistant.com/live/pay_replay.php",
  "CANCELURL" => "https://camassistant.com/live/pay_replay.php",
  "ERRORURL" => "https://camassistant.com/live/pay_replay.php",
  "BILLTOFIRSTNAME" => $_REQUEST['name'],
  "BILLTOLASTNAME" => $_REQUEST['lastname'],
  "EMAIL" => $_REQUEST['email'],  
  "BILLTOSTREET" => $_REQUEST['street'],
  "BILLTOCITY" => $_REQUEST['city'],
  "BILLTOSTATE" => $_REQUEST['states'],
  "BILLTOZIP" => $_REQUEST['zipcode'],
  "BILLTOCOUNTRY" => "US",
);
$response = run_payflow_call($request);
if ($response['RESULT'] != 0) {
  pre($response, "Payflow call failed");
  exit(0);
} else { 
  $securetoken = $response['SECURETOKEN'];
  $securetokenid = $response['SECURETOKENID'];
}
if($environment == "sandbox" || $environment == "pilot") $mode='TEST'; else $mode='LIVE';
echo "<iframe src='https://payflowlink.paypal.com?SECURETOKEN=$securetoken&SECURETOKENID=$securetokenid&MODE=$mode' width='490' height='565' border='0' frameborder='0' scrolling='no' allowtransparency='true'>\n
</iframe>";
?>
<input type="hidden" value="<?php echo $_REQUEST['approved']; ?>" name="paymentsuccess" />
<?php 
} }
 ?>