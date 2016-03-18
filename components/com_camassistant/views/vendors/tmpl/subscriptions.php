<?php $promo =  $this->promo;
$type = JRequest::getVar('type','');
 ?>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
G = jQuery.noConflict();

G(function(){
G('.subscribe').each(function(){
if(G(this).is(':checked')){
//G(this).parent().parent().addClass('defaultactive');
}
});
});


function apply_promo(promocode){	
first_amount = G('#lastamount').val() ;
if(first_amount == ''){
amount = '99'; 
}
else{
amount = first_amount; 
}
if(document.getElementById('promo_code').value == '')
 { 
 alert('Please enter Promo Code'); 
 document.getElementById('promo_code').focus();
 return false;
  }
G("#promo_msg").html('<img src="templates/camassistant_left/images/final_loading_promo.gif" />'); 
G.post("index2.php?option=com_camassistant&controller=vendorsignup&task=ajax_appyly_promocode", {promocode: ""+promocode+"",amount: ""+amount+""}, function(data){
	if(data.length >0)
	{
		var splitIt = data.split('AND');
		G("#promo_msg").html(''); 	
	   var discount = splitIt[1];
	   
	   if(discount == '0')
	   {
		G("#promo_msg").html('Promo Code is Invalid');
		G("#lastamounthtml").html('$'+splitIt[0]+'.00');
		G("#discount").val('');
	   }
	   else if(G('#discount').val() != '')
	  {
	  alert('Already Applied Promocode'); 
	  G("#lastamounthtml").html('$'+splitIt[0]+'');
	  G("#discount").val('');
	  return false;
	 }
	   else 
	   {
	   G("#promo_msg").html('You got '+discount+' dollar(s) discount.');
	   G("#lastamounthtml").html('$'+splitIt[0]+'');
	   G("#discount").val(discount);
	   }
	    G("#lastamount").val(splitIt[0]);
		
		G('#pay_amount_span').html('$'+splitIt[0]);
		//G("#lastamounthtml").html('$'+splitIt[0]+'');
		
	}
});
}

G (function(){
G('.subscribe').each(function(){
	G(this).click(function(){
	val = G(this).attr('rel') ;
	if( val != 'free' ){
		G('.newsubscription').hide();
		G('.hidecontent').show();
	}
	G('.thirdstepsubscription').hide();
	G('body,html').animate({
				scrollTop: 100
				},800);
				
	G('tr').removeClass('subactive');
	//val = G(this).val() ;
	
	G('#selected_plan').val(val);
	msg = G(this).parent().next().children("span").html() ;
	var typeold = '<?php echo $type; ?>';
	if(typeold){
		G('.total').hide();
	}
	if( val == 'free' )
	msg = "Today's Total: Basic Membership";
	else if( val == 'public' )
	msg = "Today's Total: Basic Membership + Compliance Verification";
	else if( val == 'all' )
	msg = "Today's Total: Basic Membership + Compliance Verification + Sponsored Vendor";
	
	G("#pay_amount_spantext").html(msg);
	//G(this).parent().parent().addClass('subactive');
	
	if(val == 'free'){
	G('#task_sub').val('updatesubscribe_free');
	amount = '0';
	getpopupbox();
	}
	if(val == 'public'){
	amount = '99';
	G('#task_sub').val('updatesubscribe');
	}
	if(val == 'all'){
	amount = '199';
	G('#task_sub').val('updatesubscribe');
	}
	discount = G('#discount').val() ;
	if(discount)
	discount = discount ;
	else
	discount = '0';
	if(val != 'free'){
	amount = parseInt(amount) - parseInt(discount) ;
	}
	else{
	amount = '0';
	}
	
	if( amount < 0 && val != 'free' ){
		amount = '0.01';
	}
	
	G(".pay_amount").val(amount);
	G("#lastamount").val(amount);
	if( amount == '0.01' && val != 'free' ){
	G("#lastamounthtml").html('$'+amount+'');
	}
	else{
	G("#lastamounthtml").html('$'+amount+'.00');
	}
	//G(".pay_amount").html('$'+amount);
	} );
}
);
	G('.clickforpromo').click(function(e){
		G('.inptu_promo').show();
		G('.clickhere_promo').hide();
		
	});
}
);

function validate_data2(){
lastamount = G('#lastamount').val();
payamount = lastamount.substr(0, 1);
if( payamount == '-' ){
alert("We are unable to process your request, please contact support team.");
return false;
}
else{
return true;
}
}
/*function showsub(){
G( ".hidecontent" ).show();
G( ".newsub" ).hide();
G('.subscribe').attr("disabled", false);
}*/

function getpopupbox(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskex').css({'width':maskWidth,'height':maskHeight});
		G('#maskex').fadeIn(100);
		G('#maskex').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitex").css('top',  winH/2-G("#submitex").height()/2);
		G("#submitex").css('left', winW/2-G("#submitex").width()/2);
		G("#submitex").fadeIn(2000);
		G('.windowex #cancelex').click(function (e) {
		e.preventDefault();
		G('#maskex').hide();
		G('.windowex').hide();
		});
		G('.windowex #continueex').click(function (e) {
		G('.newsubscription').hide();
		G('.hidecontent').show();
		e.preventDefault();
		G('#maskex').hide();
		G('.windowex').hide();
		});
}
</script>
<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:580px;  height:290px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>
<p style="height:12px;"></p>
<?php
defined('_JEXEC') or die('Restricted access');
$user =& JFactory::getUser(); 
if( $user->subscribe == '' || $user->subscribe == 'no' ){ 
$extend = 'nodiv';
	?>
<div class="thirdstepsubscription">
<div id="dotshead" style="background:none; font-size:16px; padding-bottom:7px;" align="center">YOU'RE ALMOST DONE...</div>
<div id="topborder_row" style="margin-top:7px; width:665px; padding-top:17px; float:left;"></div>
<p><span class="fontsizesteps_big"><span class="bold_blu_txt_big">STEP 3 of 3:</span> Please choose an account. If registering for a client, please select the option that meets their requirements.</span></p>
</div>

<?php }
if($user->user_type != 11)
{ ?>
<div align="center" style="color:#0066FF; font-size:15px"> You are not authorized to view this page.</div>
<?php } else { ?>
<div id="container_inner"  style=" padding-top:10px;">


<div class="subc_pan">
<?php if($promo && !$type){
$display = 'none';
}
else{
$display = '';
}
?>
<?php /*?><div class="hidecontent" style="display:<?php echo $display; ?>">
<p style="margin-top:5px;">Choose your Membership below and then hit "SUBSCRIBE NOW".</p>
</div><?php */?>
<?php 
if( $type ){
$disp_newsubscription = 'none';
$hidecontent = '';
}
else{
$disp_newsubscription = '';
$hidecontent = 'none';

}
?>
		
<form enctype="multipart/form-data" method="post" name="VendorForm2">
<div class="newsubscription" style="display:<?php echo $disp_newsubscription; ?>">
  <div class="newsbox">
  <?php 
	if($promo == 'public' ) {
		$texts = "YOUR PLAN";
		$class = 'already';
		}
	
	else if( $type == 'public' ){
		$class = 'selected';
		$texts = 'SELECTED PLAN';
		}
	else{
		$class = 'empty';
		$texts = '';
		$texts = '';
		}	
	?>
  <div class="title-box <?php echo $class; ?> <?php echo $extend; ?>">
  	<?php echo $texts; ?>
  </div>
  
    <h1>COMPLIANCE VERIFICATION</h1>
    
    <div class="verification">
    <h2>$99<span>/year</span></h2>
    <ul>
      <li><span class="green">VERIFIED</span> compliance documents</li>
      <li>-</li>
      <li>Appear as a <span class="green">VERIFIED</span> Vendor</li>
	  <li>-</li>
      <li>Appear <span class="green">ABOVE</span> Unverified Vendors on Eligible Vendor lists and Vendor Searches </li>
      <li>-</li>
      <li>Online storage for compliance documents and more</li>
      <li>-</li>
      <li>Ability to receive &amp; respond to projects from new and existing clients</li>
      <li>-</li>
      <li>Online profile page visible to your clients on and off of MyVendorCenter</li>
      <li>-</li>
      <li>Easily become a Preferred Vendor for clients through code redemptions</li>
	  <li>&nbsp;</li>
	  <li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li>
    </ul>
	<?php if( $promo != 'public' ) { ?>
	  <a class="subscribe" href="javascript:void(0);" rel="public"></a>
	  <?php } else echo "&nbsp;"; ?>
  </div>
  </div>
  
	
  <div class="newsbox">
  <?php 
	if($promo == 'all' ) {
		$texts = "YOUR PLAN";
		$class = 'already';
		}
	else if( $type == 'all' ){
		$class = 'selected';
		$texts = 'SELECTED PLAN';
		}
	else{
		$class = 'empty';
		$texts = '';
	}
	?>
  <div class="title-box <?php echo $class; ?> <?php echo $extend; ?>">
  <?php echo $texts; ?>
  </div>
    <h1>SPONSORED VENDOR</h1>
    <div class="sponsorvendor">
    <h2>$199<span>/year</span></h2>
    <ul>
      <li><span class="green">VERIFIED</span> compliance documents</li>
      <li>-</li>
      <li>Appear as a <span class="green">VERIFIED</span> Vendor</li>
	  <li>-</li>
      <li>Appear <span class="green">ABOVE</span> Unverified Vendors on Eligible Vendor lists and Vendor Searches </li>
      <li>-</li>
      <li>Appear within the top of Vendor search results and eligible vendor's lists</li>
      <li>-</li>
      <li>Online storage for compliance documents and more</li>
      <li>-</li>
      <li>Ability to receive &amp; respond to projects from new and existing clients</li>
      <li>-</li>
      <li>Online profile page visible to your clients on and off of MyVendorCenter</li>
      <li>-</li>
      <li>Easily become a Preferred Vendor for clients through code redemptions</li>
    </ul>
	<?php if( $promo != 'all' ) { ?>
	  <a class="subscribe" href="javascript:void(0);" rel="all"></a>
	  <?php } else echo "&nbsp;"; ?>
  </div>
  </div>
  
	
  <div class="newsbox">
   <?php 
	if($promo == 'free' ) {
		$texts = "YOUR PLAN";
		$class = 'already';
		}
	else if( $type == 'free' ){
		$class = 'selected';
		$texts = 'SELECTED PLAN';
		}	
	else{
		$class = 'empty';
		$texts = '';
		}	
	
	?>
  <div class="title-box <?php echo $class; ?> <?php echo $extend; ?>">
  <?php echo $texts; ?>
  </div>
    <h1>BASIC</h1>
    <div class="onlyfreevendor">
    <h2>$0<span>/year</span></h2>
    <ul>
      <li><span class="red">UNVERIFIED</span> compliance documents</li>
      <li>-</li>
      <li>Appear as a <span class="green">UNVERIFIED</span> Vendor</li>
	  <li>-</li>
      <li>Appear <span class="green">BELOW</span> Verified Vendors on Eligible Vendor lists and Vendor Searches </li>
      <li>-</li>
      <li>Online storage for compliance documents and more</li>
      <li>-</li>
      <li>Ability to receive &amp; respond to projects from new and existing clients who do not block <span class="green">UNVERIFIED</span> Vendors</li>
      <li>-</li>
      <li>Online profile page visible to your clients on and off of MyVendorCenter</li>
      <li>-</li>
      <li>Become a Preferred Vendor for clients through code redemptions who do not block <span class="green">UNVERIFIED</span> Vendors</li>
	  <li>&nbsp;</li>
	  <li>&nbsp;</li>
    </ul>
	<?php if( $promo != 'free' ) { ?>
	  <a class="subscribe" href="javascript:void(0);" rel="free"></a>
	  <?php } else echo "&nbsp;"; ?>
  </div>
  </div>
</div>
<div class="clear"></div>

<?php if(!$promo || $type){
$display = 'none';
}
else{
$display = '';
}
?>
<?php /*?><p align="center" style="margin-top:20px; display:<?php echo $display; ?>"><a class="newsub" href="javascript:showsub();"><img src="templates/camassistant_left/images/change-subscription.gif" /></a></p><?php */?>
<?php if($promo && !$type){
$display = 'none';
}
else{
$display = '';
}
?>
<?php
if($type || !$promo)
$margintop = '7px';
else
$margintop = '30px';
?>
<div class="hidecontent" style="display:<?php echo $hidecontent; ?>">

<div class="order_sum_pan" style="width:auto;">
<h3>Order Summary</h3>
<!--<div class="total">

	<div class="name" style="font-weight:bold; width:<?php echo $width; ?>; "><?php echo $text ; ?></div>
    <?php if($promo){ ?>
	<div class="line" style="border:none; width:<?php echo $linewidth; ?>">&nbsp;</div>
	<?php } ?>
    <div class="price" style="font-weight:bold;"><?php echo $amount ; ?></div>
    <div class="clear"></div>
</div>-->

<?php
	if( $type == 'public'){
	$amount = '$99.00';
	$text = 'Basic Membership + Compliance Verification';
	$width = '300px;';
	$linewidth = '265px;';
	}
	else if( $type == 'all'){
	$amount = '$199.00';
	$text = 'Basic Membership + Compliance Verification + Sponsored Vendor';
	$width = '387px;';
	$linewidth = '262px;';
	}
	else{
	
	}
	?>
	
<div class="order_lst">
	<div class="name"></div><span id="pay_amount_spantext" style="font-weight:bold; color:#000"><?php echo $text ; ?></span>
    <div class="price"><span id="lastamounthtml" style="font-weight:bold; color:#000"><?php echo $amount ; ?></span></div>
    <div class="clear"></div>
</div>

<div class="clear"></div>
</div>


<div class="code_pan">
<div class="clickhere_promo">
<a href="javascript:void(0);" class="clickforpromo"></a></div>
<div class="inptu_promo" style="display:none">
<h4>Promotional Code</h4>
<input type="text" value="" id="promo_code" name="promo_code" />
<div class="apply"><a onclick="javascript: apply_promo(document.getElementById('promo_code').value,'');" style="color:#7AB800; cursor:pointer; text-decoration:none;"><img src="templates/camassistant_left/images/apply.gif" /></a></div>
</div>
<br /><br />
<div id="promo_msg"></div>
<div class="clear"></div>
</div>

<div class="normalclients_master"></div>

<div class="nrm_txt">
	<p>By submitting this form, you agree that your credit card will be charged according to the subscription terms of the plan you selected above. You also agree that your subscription will automatically renew at the end of each subscription period, and your credit card will be charged accoring to the above terms for your plan, unless you cancel your subscription before it renews.<span>If you upgrade your subscription at any time, you will receive a pro-rated refund for any unused subscription time via check by mail within 15 days. Alternatively, you may call our office at 1-800-985-9243 and we will issue you a promo code for this amount. Canceled subscriptions are non-refundable.</span></p>
	<p>To help maintain the safety of the MyVendorCenter.com community, you also agree that we may use third party serivces to check the accuracy of your registration information, and your representations in the Terms of Use, against various registries, lists, database, and other sources.
	</p>
    <p align="center">
	<input type="image" style="border:none"  src="templates/camassistant_left/images/SubscribeNow.gif" alt="Continue sign up!" readonly="readonly" onclick="javascript:return validate_data2();"  /></p>
</div>
</div>
<?php 
if($promo == 'public' ) 
$pay_amount = '99';
else if($promo == 'all' ) 
$pay_amount = '199';
else
$pay_amount = '';

if( $type ) {
	if( $type == 'public' ) $pay_amount = '99';
	else if( $type == 'all' ) $pay_amount = '199';
}
else{
$pay_amount = $pay_amount ;
}

if( $promo == 'free' )
$task = 'updatesubscribe_free';
else
$task = 'updatesubscribe';

if($type){
$task = 'updatesubscribe';
}
else{
$task =  $task ;
}
?>
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="vendors" />
<input type="hidden" name="task" id="task_sub" value="<?php echo $task; ?>" />
<input type="hidden" value="<?php echo $pay_amount; ?>" name="pay_amount" id="lastamount" />
<input type="hidden" value="" name="discount" id="discount" />
<input type="hidden" value="<?php echo $type; ?>" name="subscribe" id="selected_plan" />
</form>
</div>
</div>
</div>
<?php } ?>

<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid #7ab800; position:fixed">
<div style="text-align:justify; padding:10px 7px 7px 6px;">

<div id="i_bar_terms" style="background:gray;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">NOTICE</font></span>
</div></div>

<p class="existcodemsg" style="padding-top:6px;">If you registered for a client, please make sure they are not requiring your company to have a VERIFIED account.  If you continue with a free account, your company may be blocked by your client, and other clients on MyVendorCenter, for maintaining an UNVERIFIED account. <br /><br />
If you are a Vendor with a VERIFIED account switching to an UNVERIFIED account, any compliance documents that have been verified by MyVendorCenter's compliance team will be immediately reverted to UNVERIFIED.</p>
</div>
<div class="subscription_free_buttons" style="padding-top:15px;">
<div id="cancelex" name="doneex" value="Ok" class="goback_code"></div>
<div id="continueex" name="doneex" value="Ok" class="continue_code"></div>
</div>
</div>
  <div id="maskex"></div>
</div>