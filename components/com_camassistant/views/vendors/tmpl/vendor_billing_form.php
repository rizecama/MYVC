<?php
/**
 * @version		1.0.0 camassistant $
 * @package		camassistant
 * @copyright	Copyright © 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
// Your custom code here
//American Express Test Card: 370000000000002
// Discover Test Card: 6011000000000012
// Visa Test Card: 4007000000027
// Second Visa Test Card: 4012888818888
// JCB: 3088000000000017
//Diners Club/ Carte Blanche: 38000000000006
//4864103139988256
//echo "<pre>"; print_r($this->details);
$phone = explode('-',$this->details->phone);  
$cellphone = explode('-',$this->details->cellphone);
$payment = $this->Payment_details;
//echo "<pre>"; print_r($payment);
?>
<?PHP if($payment->payment_type == 'Authorize') { ?>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/assets/js/Creditcard_validations.js">
</script>
<?PHP } else if($payment->payment_type == 'Paypal'){ ?>
<script type="text/javascript" >
function validate_fields()
{
var form = document.Vendor_BillForm2;
if(form.address.value == '')
 {
 alert('Please enter your address');
 form.address.focus();
 return false;
 }
 else if(form.city.value == '')
 {
 alert('Please enter your City');
 form.city.focus();
 return false;
 }
 else if(form.states.value == '0')
 {
 alert('Please select state');
 form.states.focus();
 return false;
 }
 else if(form.zipcode.value == '')
 {
 alert('Please enter your Zipcode');
 form.zipcode.focus();
 return false;
 }
  else if(form.phone.value == '')
 {
 alert('Please enter your phone number');
 form.phone.focus();
 return false;
 }
 else if(form.terms.checked == false)
 {
	 alert('Please check terms&conditions');
	 form.terms.focus();
	 return false;
 }
 else
 {
 form.submit();
 }
 return;
 }
</script>
<?PHP } ?>
<div id="vender_right">

<!-- sof bedcrumb -->
<div id="bedcrumb">
<ul>
<li class="home"><a href="#">Home</a> </li>
<li><a href="#">Registration Fee</a> </li>

</ul>
</div>
<!-- eof bedcrumb -->
<form enctype="multipart/form-data" action="index.php?option=com_camassistant&amp;controller=vendors&amp;Itemid=57&amp;task=save_billing_info" method="post" name="Vendor_BillForm2" >
<!-- sof dotshead -->
<div id="dotshead">PAY MY 1-TIME ACCOUNT REGISTRATION FEE</div>
<!-- eof dotshead -->

<span class="blueheads_small">ATTENTION:</span> <strong>In order to complete your registration and have RFPs emailed to you (so you can submit Proposals), please be sure to complete this section thoroughly. <br />

If you need assistance, view our <span class="greenlinks"><a href="#">Registration Fee Video.</a></span></strong>
<ul class="grey_list"><br />

<li> Please enter your Credit Card information below or<a href="#" class="greenlinks"><strong> Pay by ACH.</strong></a></li>
<li>We require a<strong> <a href="#" class="greenlinks_13">fully-refundable $99 Registration Fee</a></strong> that will be charged after you click the <strong>SUBMIT PAYMENT</strong> button.  
   <strong>Please note that there is a $3 convenience fee for the credit/debit card payment option.</strong></li>
<li>  For details regarding our money-back satisfaction guarantee, <span class="greenlinks_13"> <a href="#"><strong>click here.</strong></a></span>
</li></ul>

<br />
<!-- sof table pan -->
<div class="table_pannel">
<div class="head_greenbg">CREDIT CARD INFORMATION </div>
<div class="table_panneldiv2">
  <table width="100%" cellspacing="0">
  <?PHP if($payment->payment_type == 'Authorize') { ?>
<input type="hidden" name="hid_auth_tx_key" value="<?PHP echo $payment->auth_tx_key; ?>" />
<input type="hidden" name="hid_auth_login_id" value="<?PHP echo $payment->auth_login_id; ?>" />
  <tr>
      <td width="24%" height="35" align="left" bgcolor="#ebebeb">Credit Card 

Type:</td>
      <td width="76%" bgcolor="#ebebeb">
<select name="CardType">
<option value="MasterCard">MasterCard
<option value="VisaCard">Visa
<option value="AmExCard">American Express
<option value="DinersClubCard">Diners Club
<option value="DiscoverCard">Discover
<option value="enRouteCard">enRoute
<option value="JCBCard">JCB
</select> </td>
    </tr>
	<tr>
      <td height="35" align="left" bgcolor="#ebebeb">Card Number:</td>
      <td bgcolor="#ebebeb"><input name="CardNumber" size="16" maxlength="16"></td></tr>
	    <tr>
      <td height="35" align="left" bgcolor="#ebebeb">Name On Card:</td>
      <td bgcolor="#ebebeb"> <input type="text" name="name_on_card" 

id="name_on_card" /></td>
    </tr>
    <tr>
      <td height="35" align="left" bgcolor="#ebebeb">Company Name:</td>
      <td bgcolor="#ebebeb"> <input type="text" name="company_name" 

id="company_name" /></td>
    </tr>
<tr>
      <td height="35" align="left" bgcolor="#ebebeb">Expiration Date:  	</td>
      <td bgcolor="#ebebeb"> Month
<select name="ExpMon">
<option value="1" selected>1
<option value="2">2
<option value="3">3
<option value="4">4
<option value="5">5
<option value="6">6
<option value="7">7
<option value="8">8
<option value="9">9
<option value="10">10
<option value="11">11
<option value="12">12
</select>  /
 <!--<input name="ExpYear" size="2" maxlength="4">--><select name="ExpYear">
<option value="2011" selected>2011</option>
<option value="2012">2012</option>
<option value="2013">2013</option>
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
</select>
      Verification Code: 
      <input type="text" name="verify_code" id="verify_code" 

style="width:45px"/> <span  class="greenlinks"><a href="#">What’s this?

</a></span></td>
    </tr>
	<?PHP } ?>
    <tr>
      <td height="35" align="left" bgcolor="#ebebeb">Payment Amount:</td>
      <td bgcolor="#ebebeb"><input name="pay_amount" readonly="readonly" type="text" id="pay_amount" style="width:65px;" value="99.00"/></td>
    </tr>
    <tr>
      <td height="35" align="left" bgcolor="#ebebeb">Convenience Fee:</td>
      <td bgcolor="#ebebeb"><input name="convinience_fee" readonly="readonly" type="text" id="convinience_fee" style="width:65px;" value="3" /></td>
    </tr>
    <tr>
      <td height="35" align="left" bgcolor="#ebebeb" class="redheads"><span class="redheads">Amount Charged
On Your Card:</span></td>
      <td bgcolor="#ebebeb"><input name="amnt_charged" readonly="readonly" type="text" id="amnt_charged" style="width:65px; color:#b30000;" value="102"/></td>
    </tr>
    <tr>
      <td height="35" align="left" bgcolor="#ebebeb">Promo Code:</td>
      <td bgcolor="#ebebeb"><input name="promo_code" type="text" id="promo_code" style="width:110px;" /> (Optional)</td>
    </tr>
    <tr>
      <td height="35" align="left">&nbsp;</td>
      <td align="right"><a onclick="if(document.getElementById('promo_code').value == '') { alert('Please enter Promo Code'); document.getElementById('promo_code').focus();return false; }document.getElementById('pay_amount').value =  parseInt(document.getElementById('pay_amount').value) - parseInt(document.getElementById('promo_code').value); document.getElementById('amnt_charged').value = parseInt(document.getElementById('amnt_charged').value)- parseInt(document.getElementById('promo_code').value); 
"><img src="templates/camassistant_left/images/applypromocode.gif" width="164" height="25" alt="Apply promo code" /></a></td>
    </tr>
  </table>
  <div class="clear"></div>
</div>
</div>
<!-- eof table pan -->


<div class="table_panneldiv2">
  <table width="100%" cellspacing="0">
  
  <tr><td colspan="2" class="head_greycolor_bg" style=" color:#fff;">Credit Card Billing Address</td>
  </tr>
    <tr>
      <td width="24%" height="35" align="left" bgcolor="#ebebeb">Street Address:</td>
      <td width="76%" bgcolor="#ebebeb"><input type="text" name="address" id="address" style="width:190px; height:40px;" />
         
        </td>
    </tr>
    <!--<tr>
      <td height="35" align="left" bgcolor="#ebebeb"></td>
      <td bgcolor="#ebebeb"> <input type="text" name="textfield" id="textfield" /></td>
    </tr> -->
    <tr>
      <td height="35" align="left" bgcolor="#ebebeb">City:</td>
      <td bgcolor="#ebebeb"> <input type="text" name="city" id="city" style=" width:150px;" /></td>
    </tr>
    <tr>
      <td height="35" align="left" bgcolor="#ebebeb">State:</td>
      <td bgcolor="#ebebeb"><?PHP echo $this->states; ?>
         </td>
    </tr>
    <tr>
      <td height="35" align="left" bgcolor="#ebebeb">Zip Code: 	</td>
      <td bgcolor="#ebebeb"> <input type="text" name="zipcode" id="zipcode" style=" width:100px;" /></td>
    </tr>
    <tr>
      <td height="35" align="left" bgcolor="#ebebeb">Phone Number:</td>
      <td bgcolor="#ebebeb"><input name="phone" type="text" id="phone" style="width:150px;"/></td>
    </tr>
  </table>

<div class="clear"></div>
</div>
<table width="100%" cellpadding="0" cellspacing="0" style=" padding-top:15px;">
  <tr>
    <td width="4%" align="left" valign="top" >
      <input type="checkbox" name="terms" id="terms" style="border:0px; width:15px;"/>
</td>
    <td width="72%">
     By submitting your account information, you indicate that you accept and agree<br />
to our <a href="#" class="greenlinks"> <strong>Terms of Use</strong></a>,
        
       <strong><a href="#" class="greenlinks">Terms of Service</a></strong> and 
       <a href="# "class="greenlinks"> <strong>Privacy Policy</strong>.</a><span class="redstar">*</span>
    </td>
    <td width="24%" align="right" valign="top"><!--<input type="image" src="templates/camassistant_left/images/submitpayment.gif" onclick="javascript: return CheckCardNumber(this.form);"  alt="Apply promo code" />-->
	<?PHP if($payment->payment_type == 'Authorize') { ?>
	<a onclick="javascript: CheckCardNumber(document.Vendor_BillForm2);"><img src="templates/camassistant_left/images/submitpayment.gif" /></a>
	<?PHP } else { ?>
	<a onclick="javascript: return validate_fields();"><img src="templates/camassistant_left/images/submitpayment.gif" /></a>
	<?PHP } ?>
	<!--<input type="button" onclick="javascript: CheckCardNumber(this.form);" value="Submit"  alt="Apply promo code" />--></td>
  </tr>
</table>
<?PHP if($payment->payment_type == 'Paypal') { ?>
<input type="hidden" name="hid_pay_name" value="<?PHP echo $payment->pay_name; ?>" />
<input type="hidden" name="hid_pay_currency" value="<?PHP echo $payment->pay_currency; ?>" />
<input type="hidden" name="hid_pay_busness_email" value="<?PHP echo $payment->pay_busness_email; ?>" />
<?PHP } ?>
<input type="hidden" name="hid_payment_type" value="<?PHP echo $payment->payment_type; ?>" />
</form> 
</div>