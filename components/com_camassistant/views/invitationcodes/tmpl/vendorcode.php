<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>camassistant</title>

<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:540px;  height:217px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}

</style>
<script type="text/javascript">
G = jQuery.noConflict();
G(document).ready( function(){
	G('.add_code_venodor').click(function(){
   	code = G("#code").val();
	if(code == '' ){
	alert("Plese enter your code");
	G( "#code" ).focus();
	return false;
	}
	else if(code)
	{
	
	G.post("index2.php?option=com_camassistant&controller=invitationcodes&task=checkcode", {newcode: ""+code+""}, function(data){
	if(data == 1)
	G('#addcodeform').submit();
	else
	errorpopup();
	});
}	
});
});
	function errorpopup()
	{
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
    }

function getpopuptext(){
	el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=invitationcodes&task=vendortext';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 672, y:320}}"))
	SqueezeBox.fromElement(el,options);
}

</script>

</head>
<?php $codes = $this->manager_info;
?>
 
<body>
<div class="inviteedcode_vendor">
<div class="createdvendorcodes"><p>Add your company to your client's personal <strong>'MY VENDORS'</strong> list by redeeming their unique <b>invite code</b> below
<a href="javascript:void(0);" onclick="javascript:getpopuptext();" class="more-infoa">+ More Info</a>
</p>

<div class="invitedcode" >
<form action="" method="post" id="addcodeform" name="addcodeform">
<input  type="text"   placeholder="Enter code here" onclick="if(this.placeholder == 'Enter code here') this.placeholder='';" onblur="if(this.placeholder == '') this.placeholder ='Enter code here';"  name="invitecode" id="code"/>
<input type="hidden" name="option" value="com_camassistant">
<input type="hidden" name="controller" value="invitationcodes">
<input type="hidden" name="task" value="savevendorcode">
</form>
</div>
<div align="center" class="add_code_venodor" ><a class="addednewvendorcode" href="javascript:void(0);"> REDEEM CODE</a></div>
<div align="center" class="add_code_venodor_active"  style="display:none;"><a class="addednewvendorcode" href="javascript:void(0);">REDEEM CODE </a></div>
</div>
<div class="redeemcode_div"><img src="templates/camassistant_left/images/invitevendorcodeimage.jpg" /></div>
</div>


<div class="clr"></div>
<div class="table_pannel" id="purchasedcodes">
<div class="table_panneldiv" style="margin:0px;">
<div id="i_bar_terms" style="background: #21314d  none repeat scroll 0 0;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">REDEEMED CODES</font></span>
</div></div>
<?php 
if($codes){ ?>
<table width="100%" cellspacing="4" cellpadding="0" class="vendortable">
  <tr class="vendorfirsttr">
    <td width="15%" valign="middle" align="center">CODE</td>
    <td width="30%" valign="middle" align="center">CLIENT</td>
    <td width="40%" valign="middle" align="center">COMPANY</td>
    <td width="25%" valign="middle" align="center">REDEEMED ON</td>
  </tr>
	<?php for ( $c = 0; $c < count( $codes ); $c++ ) { ?>
	<tr class="table_blue_rowdots">
	<td width="15%" valign="middle" align="center"><?php echo $codes[$c]->code ; ?></td>
	<td width="30%" valign="middle" align="center"><?php echo $codes[$c]->manager_name ; ?></td>
	<td width="40%" valign="middle" align="center"><?php echo $codes[$c]->comapnay_name ;?></td>
	<td width="25%" valign="middle" align="center">
	<?php 
	$date = explode(' ', $codes[$c]->invitedate );
	$date = explode('-', $date[0] );
	echo $date[1].'-'.$date[2].'-'.$date[0];?></td>
	
	
	</tr>
	<?php } ?>
</table>

<?php 
		} else { ?>
<p style="padding-top:20px; text-align:center;">You have not purchased any Preferred Vendor Codes</p>
<?php } ?>
</table>
</div></div>


<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red; margin-top: 7px;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="error_code">The Invite Code you entered does not exists in our system. Please try again or contact your client for help.</p>
</div>
<div style="padding-top:46px;" align="center">
<div id="cancelex" name="doneex" value="Ok" class="errorcode_button"></div>
</div>
</div>
  <div id="maskex"></div>
</div>