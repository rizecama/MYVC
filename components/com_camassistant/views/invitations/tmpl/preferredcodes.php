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
		H.post("index2.php?option=com_camassistant&controller=invitations&task=checkcode", {code: ""+preferredcode+""}, function(data){
			checkd = data.trim();
			if( checkd == 'no' )
			nocodeexist();
			else if( checkd == 'sold' )
			alert("You already purchased this code.");
			else{
			var res = data.split("-");
			
				if( res[1] == 'none' )
				H('#formtask').val('buypreferredcode_none');	
				else
				H('#formtask').val('buypreferredcode');	
			H('#preferred_code').val(preferredcode);
			H('#codesubmitform').submit();
			}
		});
	}
return false;
});
});

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
		
		G('.windowexcan #doneexcan').click(function (e) {
		e.preventDefault();
		G('#maskexcan').hide();
		G('.windowexcan').hide();
		});
}
	
</script>
<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:450px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>
<style>
#maskexcan { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexcan .windowexcan {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexcan #submitexcan {  width:545px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxesexcan #submitexcan a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneexcan {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeexcan {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>

<div id="preferred-vendor-new">
<h3>ENTER CODE</h3>
(Code received from Client)
<div class="codes-search">

<form method="post" id="preferredcodeform" name="preferredcodeform">
<input type="text" style="padding-left:3px;" onblur="if(this.value == '') this.value ='Enter Code';" onclick="if(this.value == 'Enter Code') this.value='';" value="Enter Code" id="preferredcode" name="preferredcode">
<input type="submit" style="padding-left:4px; padding-right:3px;" id="searchcodes" class="go-button" value="SUBMIT" name="">
</form>

<form method="post" id="codesubmitform" name="codesubmitform">
<input type="hidden" value="" name="preferred_code" id="preferred_code" />
<input type="hidden" name="option" value="com_camassistant">
<input type="hidden" name="controller" value="invitations">
<input type="hidden" name="task" id="formtask" value="buypreferredcode">
</form>
</div>
<div class="clr"></div>

<br>
</div>
<div class="clr"></div>
<?php $codes = $this->purchased_codes; ?>
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">PURCHASED CODES</font></span>
</div></div>
<div class="table_pannel">
<div class="table_panneldiv">
<table width="100%" cellspacing="4" cellpadding="0" class="vendortable">
  <tr class="vendorfirsttr">
    <td width="8%" valign="middle" align="center">CODE</td>
    <td width="40%" valign="middle" align="center">CLIENT</td>
    <td width="15%" valign="middle" align="center">LAST PURCHASE</td>
    <td width="25%" valign="middle" align="center">RENEWAL DATE</td>
	<td width="19%" valign="middle" align="center">OPTIONS</td>
  </tr>
<?php 
if($codes){ ?>
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
	<a class="cancelcode_exist" href="javascript:void(0);" onclick="cancelcode(<?php echo $codes[$c]->id ; ?>);">CANCEL</a></td>
	</tr>
	<?php } ?>
</table>

<?php 
		} else { ?>
</table>
<?php } ?>

</div>
</div>




<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">The Code you entered does not exist in our system. Please try again or contact your client for help.</p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelex" name="doneex" value="Ok" class="existing_code"></div>
</div>
</div>
  <div id="maskex"></div>
</div>

<div id="boxesexcan" style="top:576px; left:582px;">
<div id="submitexcan" class="windowexcan" style="top:300px; left:582px; border:6px solid #77b800; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 #77b800;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">CANCEL CODE</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">Warning: You will not receive a refund for a cencelled Code. <strong>Would you still like to cancel this Code?</strong></p>
</div>
<div style="padding-top:25px;" align="center">

<div style="text-align:center; width:250px; margin:0 auto;">
<div class="nocancelcode" value="Canceexcan" name="closeexcan" id="cancelexcan"></div>
<div class="yesawardjob" value="Ok" name="done1" id="doneexcan"></div>
</div>

</div>
</div>
  <div id="maskexcan"></div>
</div>