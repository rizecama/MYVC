<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<?php
$company_css = '<link rel="stylesheet" href="'.$this->baseurl.'/templates/camassistant_left/css/style.css" type="text/css" />';
echo $company_css;
$from = JRequest::getVar('from','');
?>
<script type="text/javascript">
G = jQuery.noConflict();
	G(document).ready(function(){
		G('.cancelbutton_requestmade').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('.submitbutton').click(function(){
			G('#requestmoney_form').submit();
		});
	});
</script>

<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:450px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>

<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">REQUEST MONEY</font></span>
</div></div>
<?php //echo "<pre>"; print_r($_REQUEST); echo "</pre>";
	$eligible = JRequest::getVar( 'eligible','');
	$balance = JRequest::getVar( 'amount','');
	$codeid = JRequest::getVar( 'codeid','');
	if( $eligible == 'yes' ){
 ?>
<div class="request_money_popupbox" >
<p class="requestmoney_text">Please click SUBMIT to complete your request. It may take up to 14 busines days to receive your refund check.</p>
<ul>
<li>BALANCE: <span><?php echo "$".number_format($balance,2) ; ?></span></li>
<li>5% FEE: <span class="red_fee"><?php $fees = (5 / 100) * $balance;
										echo "$".number_format($fees,2) ;
 ?></span></li>
<li>TO BE PAID: <span><?php $tobepaid = $balance - 	$fees ;			
							echo "$".number_format($tobepaid,2) ; ?></span></li>
</ul>
<div class="request_waring">
Note: You cannot request anything less than the total balance for each Code. A 5% fee for Paypal fees and administrative costs will be deducted from your total. Once your check has been processed, your balance will be updated within your account. If you do not receive your check within 14 business days, please contact support <a href="mailto:accounting@myvendorcenter.com"><strong>accounting@myvendorcenter.com</strong></a>.
</div>
</div>
<div class="buttons_request">
	<div class="cancelbutton_request"><a href="javascript:void(0);" class="cancelbutton_requestmade"></a></div>
	<div class="requestbutton_request"><a href="javascript:void(0);" class="submitbutton"></a></div>
</div>
<form method="post" name="requestmoney_form" id="requestmoney_form">
<input type="hidden" value="com_camassistant" name="option" />
<input type="hidden" value="vendorscenter" name="controller" />
<input type="hidden" value="send_requestmoney" name="task" />
<input type="hidden" value="<?php echo $tobepaid.'.00'; ?>" name="amount" />
<input type="hidden" value="<?php echo $balance; ?>" name="saveamount" />
<input type="hidden" value="<?php echo $codeid; ?>" name="codeid" />
</form>
<?php } else { ?>

<?php } ?>
<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">The Code you entered already exists in our system. Please enter a new code and try again.</p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelex" name="doneex" value="Ok" class="existing_code"></div>
</div>
</div>
  <div id="maskex"></div>
</div>

<?php
exit;
?>