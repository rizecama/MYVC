<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
H = jQuery.noConflict();
G = jQuery.noConflict();
H(document).ready( function(){
H('#preferredcodeform').submit(function(){
var preferredcode = H("#preferredcode").val();
preferredcode = preferredcode.trim();
	if(preferredcode == '' || preferredcode == 'Enter Code'){
	alert("Please enter the code you received from client.");
	}
	else{
		H.post("index2.php?option=com_camassistant&controller=invitations&task=checkcode_purchase", {code: ""+preferredcode+""}, function(data){
			checkd = data.trim();
			//alert(checkd);
			if( checkd == 'no' ){
			nocodeexist();
			}
			else if( checkd == 'sold' ){
			popup_purchased();
			}
			else{
			H('.codetext_purchase').show();
			H('.button_purchase').show();
			H('#purchasedcodes').hide(); //Hiding purchased code history
			H('#newcode_search').show(); //Displaying search code information
			H('.heading_purchased').hide(); //Hiding purchased code header
			H('#preferred-vendor-new_status').show(); //Displaying search code header
			H('.codes-search').hide(); //Hiding search box
			H('.newcode_main').hide(); //Hiding total box
			H('#cancelled_codes').hide(); //Hiding total box
			var res = data.split("----");
			
			var codinfo = '<td width="8%" align="center" valign="middle">'+res[2]+'</td><td width="45%" align="center" valign="middle">'+res[3]+'</td><td width="25%" align="center" valign="middle">'+res[4]+'</td><td width="19%" align="center" valign="middle"><font color="#77b800">'+res[5]+'</font></td>';
			H('#before_data').hide();
			H('#date_code').html(codinfo);
			if( res[5] != '$0.00' ){
				if( res[1] == 'none' )
				H('#formtask').val('buypreferredcode_none');	
				else
				H('#formtask').val('buypreferredcode');	
				H('#purchasecode_paid').show();
				H('#continue_free').hide();
			}
			else{
				H('#formtask').val('buypreferredcode_free');
				H('#continue_free').show();	
				H('#purchasecode_paid').hide();	
			}	
			H('#preferred_code').val(preferredcode);
			H('#code_reqs').val(res[6]);
			//H('#purchasecodeform').submit();
			}
		});
	}
return false;
});
	H('.purchasecode').click(function(){
		var codereqs = H("#code_reqs").val();	
		var userstatus = H("#user_status").val();	
		
		if( codereqs == '0' )
			H('#purchasecodeform').submit();
		else{
			if( userstatus == 'verified' )
			H('#purchasecodeform').submit();
			else
			errorpopup_verified();
		}
	});
});

function popup_purchased(){
		var maskHeight = H(document).height();
		var maskWidth = H(window).width();
		H('#maskexa').css({'width':maskWidth,'height':maskHeight});
		H('#maskexa').fadeIn(100);
		H('#maskexa').fadeTo("slow",0.8);
		var winH = H(window).height();
		var winW = H(window).width();
		H("#submitexa").css('top',  winH/2-H("#submitex").height()/2);
		H("#submitexa").css('left', winW/2-H("#submitex").width()/2);
		H("#submitexa").fadeIn(2000);
		H('.windowexa #cancelexa').click(function (e) {
		e.preventDefault();
		H('#maskexa').hide();
		H('.windowexa').hide();
		});
}
function errorpopup_verified(){
		var maskHeight = H(document).height();
		var maskWidth = H(window).width();
		H('#masker').css({'width':maskWidth,'height':maskHeight});
		H('#masker').fadeIn(100);
		H('#masker').fadeTo("slow",0.8);
		var winH = H(window).height();
		var winW = H(window).width();
		H("#submiter").css('top',  winH/2-H("#submiter").height()/2);
		H("#submiter").css('left', winW/2-H("#submiter").width()/2);
		H("#submiter").fadeIn(2000);
		H('.windower #canceler').click(function (e) {
		e.preventDefault();
		H('#masker').hide();
		H('.windower').hide();
		window.location = 'index.php?option=com_camassistant&controller=vendors&task=subscriptions&type=public&Itemid=213';
		});
}

function nocodeexist(){
		var maskHeight = H(document).height();
		var maskWidth = H(window).width();
		H('#maskex').css({'width':maskWidth,'height':maskHeight});
		H('#maskex').fadeIn(100);
		H('#maskex').fadeTo("slow",0.8);
		var winH = H(window).height();
		var winW = H(window).width();
		H("#submitex").css('top',  winH/2-H("#submitex").height()/2);
		H("#submitex").css('left', winW/2-H("#submitex").width()/2);
		H("#submitex").fadeIn(2000);
		H('.windowex #cancelex').click(function (e) {
		e.preventDefault();
		H('#maskex').hide();
		H('.windowex').hide();
		});
	}	

function cancelcode(id){
		G('.deletepreferredcodev').attr( "rel", id );
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskexcan').css({'width':maskWidth,'height':maskHeight});
		G('#maskexcan').fadeIn(100);
		G('#maskexcan').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitexcan").css('top',  winH/2-G("#submitexcan").height()/2);
		G("#submitexcan").css('left', winW/2-G("#submitexcan").width()/2);
		G("#submitexcan").fadeIn(2000);
		G('.windowexcan #cancelexcan').click(function (e) {
		e.preventDefault();
		G('#maskexcan').hide();
		G('.windowexcan').hide();
		});
		
		G('.windowexcan #doneexcannodel').click(function (e) {
		codeidval = G('.deletepreferredcodev').attr('rel');
		G.post("index2.php?option=com_camassistant&controller=invitations&task=deletepcode", {code: ""+id+""}, function(data){
			data = data.trim();
			if( data == 'removed' )
			window.parent.parent.location.reload();
			else
			alert("We are unable to delete the code, please contact MyVendorSupport Team.");
		});
		e.preventDefault();
		G('#maskexcan').hide();
		G('.windowexcan').hide();
		});
}	
function getpopuptext(){
	el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=invitations&task=vendortext';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 672, y:400}}"))
	SqueezeBox.fromElement(el,options);
}
</script>
<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:450px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
#maskexcan { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexcan .windowexcan {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexcan #submitexcan {  width:545px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxesexcan #submitexcan a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneexcan {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeexcan {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
#masker { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxeser .windower {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxeser #submiter {  width:540px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxeser #submiter a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneer {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeer {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}

#maskexa { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexa .windowexa {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexa #submitexa {  width:450px;  height:175px;  padding:10px;  background-color:#ffffff;}
#boxesexa #submitexa a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneexa {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeexa {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}


</style>
<p style="height:20px;"></p>
<div id="preferred-vendor-new_status" style="display:none;">
<span class="heading_search" style="">
			<h3 class="codefound">CODE SUCCESSFULLY FOUND!</h3>
			(Not the code you were looking for? <a href="index.php?option=com_camassistant&controller=invitations&task=newcode&Itemid=270" class="clickhere_newcode">Click Here</a>)
			</span>
</div>
			
<div class="newcode_main">
<div class="creatcode_div"><p>Add your company to your client's <span>Preferred Vendor</span> list and increase your chances at aquiring new business<span class="moreinfo_newone"><img src="templates/camassistant_left/images/arrow_master.png" /><a href="javascript:void(0);" onclick="javascript:getpopuptext();"> More Info</a></span>
</p>
<div align="center" class="add_newcode">
			<div id="preferred-vendor-new">
			<span class="heading_purchased">
			<h3>ENTER CODE</h3>
			(Code received from Client)
			</span>
			
			
			<div class="codes-search">
			<form method="post" id="preferredcodeform" name="preferredcodeform">
			<input type="text" style="padding-left:3px;" onblur="if(this.value == '') this.value ='Enter Code';" onclick="if(this.value == 'Enter Code') this.value='';" value="Enter Code" id="preferredcode" name="preferredcode">
			<input type="submit" style="padding-left:4px; padding-right:3px;" id="searchcodes" class="go-button" value="SUBMIT" name="">
			</form>
			</div>
			<div class="clr"></div>
			</div>

</div>
</div>
<div class="manimage_div"><img src="templates/camassistant_left/images/preferred_man.png" /></div>
</div>




<div class="clr"></div>
<?php $codes = $this->purchased_codes; ?>

<div class="table_pannel" id="purchasedcodes">
<div class="table_panneldiv">
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">PURCHASED CODES</font></span>
</div></div>
<?php 
if($codes){ ?>
<table width="100%" cellspacing="4" cellpadding="0" class="vendortable">
  <tr class="vendorfirsttr">
    <td width="8%" valign="middle" align="center">CODE</td>
    <td width="40%" valign="middle" align="center">CLIENT</td>
    <td width="15%" valign="middle" align="center">LAST PURCHASE</td>
    <td width="25%" valign="middle" align="center">RENEWAL PERIOD</td>
	<td width="19%" valign="middle" align="center">OPTIONS</td>
  </tr>
	<?php for ( $c = 0; $c < count( $codes ); $c++ ) { ?>
	<tr class="table_blue_rowdots">
	<td width="8%" valign="middle" align="center"><?php echo $codes[$c]->code ; ?></td>
	<td width="40%" valign="middle" align="center"><?php echo $codes[$c]->client ; ?></td>
	<td width="15%" valign="middle" align="center">
	<?php 
		$date_first = explode(' ',$codes[$c]->purchase_date);
		$date_onlyf = explode('-',$date_first[0]);
		echo $date_onlyf[1].'-'.$date_onlyf[2].'-'.$date_onlyf[0];
	?>
</td>
	<td width="25%" valign="middle" align="center">
	<?php 
		if( $codes[$c]->renewal_date == 'none' ) 
		echo 'None' ; 
		else{
		$date_renew = explode(' ',$codes[$c]->renewal_date);
		$date_only = explode('-',$date_renew[0]);
		echo $date_only[1].'-'.$date_only[2].'-'.$date_only[0];
		}
	?></td>
	<td width="19%" valign="middle" align="center">
	<?php if( $codes[$c]->publish == '1' ) { ?>
	<a class="cancelcode_exist" href="javascript:void(0);" onclick="cancelcode(<?php echo $codes[$c]->id ; ?>);">CANCEL</a></td>
	<?php } else { echo "Cancelled by Creator"; } ?> 
	
	
	</tr>
	<?php } ?>
</table>

<?php 
		} else { ?>
<p style="padding-top:20px; text-align:center;">You have not purchased any Preferred Vendor Codes</p>
<?php } ?>
</table>
</div></div>






<?php $cancelledcodes = $this->cancelled_codes;
$codes = $cancelledcodes ;
 ?>

<div class="table_pannel" id="cancelled_codes">
<br /><br /><br /><br />
<div class="table_panneldiv">
<div id="i_bar_terms_red">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">CANCELED CODES</font></span>
</div></div>
<?php 
if($codes){ ?>
<table width="100%" cellspacing="4" cellpadding="0" class="vendortable">
  <tr class="vendorfirsttr">
    <td width="8%" valign="middle" align="center">CODE</td>
    <td width="40%" valign="middle" align="center">CLIENT</td>
    <td width="15%" valign="middle" align="center">LAST PURCHASE</td>
    <td width="20%" valign="middle" align="center">CANCELED ON</td>
	<td width="30%" valign="middle" align="center">CANCELED BY</td>
  </tr>
	<?php for ( $c = 0; $c < count( $codes ); $c++ ) { ?>
	<tr class="table_blue_rowdots">
	<td width="8%" valign="middle" align="center"><?php echo $codes[$c]->code ; ?></td>
	<td width="40%" valign="middle" align="center"><?php echo $codes[$c]->client ; ?></td>
	<td width="15%" valign="middle" align="center">
	<?php 
		$date_first = explode(' ',$codes[$c]->purchase_date);
		$date_onlyf = explode('-',$date_first[0]);
		echo $date_onlyf[1].'-'.$date_onlyf[2].'-'.$date_onlyf[0];
	?>
</td>
	<td width="20%" valign="middle" align="center">
	<?php 
		if( $codes[$c]->publish == '0' )  
			$date_cancel = $codes[$c]->canceldate;
		else if( $codes[$c]->vendor_publish == '0' )	  
			$date_cancel = $codes[$c]->vendor_cancel;
			
		$datecanc = explode('-',$date_cancel);
		echo $datecanc[1].'-'.$datecanc[2].'-'.$datecanc[0];
			
	?></td>
	<td width="30%" valign="middle" align="center">
	<?php 
		if( $codes[$c]->publish == '0' )  
			echo "Client";
		else if( $codes[$c]->vendor_publish == '0' )	  
			echo "You";
	?>
	</td>

	
	</tr>
	<?php } ?>
</table>

<?php 
		} else { ?>
		<p style="padding-top:20px; text-align:center;">You have not canceled any Preferred Vendor Codes</p>
<?php } ?>
</div></div>






<div class="table_pannel" id="newcode_search" style="display:none;">
<div class="table_panneldiv">
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">ORDER SUMMARY</font></span>
</div></div>

<table width="100%" cellspacing="4" cellpadding="0" class="vendortable">
  <tr class="vendorfirsttr">
    <td width="8%" valign="middle" align="center">CODE</td>
    <td width="40%" valign="middle" align="center">CLIENT</td>
    <td width="25%" valign="middle" align="center">RENEWAL PERIOD</td>
	<td width="19%" valign="middle" align="center">COST</td>
  </tr>
  <tr class="table_blue_rowdots" id="before_data">
	<td width="19%" valign="middle" align="center" colspan="4">
	Please enter Code above and click "SUBMIT" for Summary
	</td>
	</tr>
	<tr class="table_blue_rowdots" id="date_code"></tr>
</table>

<div class="codetext_purchase" style="display:none;">By purchasing this Code, you agree that your credit card will be charged according to the cost shown above for your Company to be automatically added to this Client's Preferred Vendor list. You also agree that your credit card will be automatically charged per the "Renewal Rate", if applicable. Once purchased, you may cancel at any time to avoid renewal. Cancelled codes are non-refundable.<br /><br /><br />
<a href="javascript:void(0);" class="purchasecode" id="purchasecode_paid"></a>
<div align="center" style="padding-top:40px;">
<a href="javascript:void(0);" class="purchasecode" id="continue_free" style="display:none;"></a>
</div>
</div>
</div>
</div>
<?php
	$user	= JFactory::getUser();
	if( $user->subscribe == 'yes' && $user->subscribe_type != 'free' )
		$user_status = 'verified' ;
	else
		$user_status = 'unverified' ;	
?>
<form name="purchasecodeform" id="purchasecodeform" method="post">
<input type="hidden" value="" name="preferred_code" id="preferred_code" />
<input type="hidden" name="option" value="com_camassistant">
<input type="hidden" name="controller" value="invitations">
<input type="hidden" name="task" id="formtask" value="buypreferredcode">
<input type="hidden" value="" name="code_reqs" id="code_reqs" />
<input type="hidden" value="<?php echo $user_status; ?>" name="user_status" id="user_status" />
</form>



<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">The Code you entered does not exist in our system. Please try again or contact your client for help.</p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelex" name="doneex" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskex"></div>
</div>



<div id="boxesexa" style="top:576px; left:582px;">
<div id="submitexa" class="windowexa" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">You have already purchased this code.</p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelexa" name="doneexa" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskexa"></div>
</div>



<div id="boxesexcan" style="top:576px; left:582px;">
<div id="submitexcan" class="windowexcan" style="top:300px; left:582px; border:6px solid #77b800; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 #77b800;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">CANCEL CODE</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">Warning: You will not receive a refund for a canceled Code. <strong>Would you still like to cancel this Code?</strong></p>
</div>
<div style="padding-top:25px;" align="center">

<div style="text-align:center; width:250px; margin:0 auto;">
<div class="nocancelcode" value="Canceexcan" name="closeexcan" id="cancelexcan"></div>
<a class="deletepreferredcodev" id="doneexcannodel" rel=""></a>
</div>

</div>
</div>
  <div id="maskexcan"></div>
</div>


<div id="boxeser" style="top:576px; left:582px;">
<div id="submiter" class="windower" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">You have already purchased this Preferred Vendor Code.</p>
</div>
<div style="padding-top:30px;" align="center">
<div id="canceler" name="doneer" value="Ok" class="become_verified"></div>
</div>
</div>
  <div id="masker"></div>
</div>