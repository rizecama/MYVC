<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>camassistant</title>

<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript">
function invitevendor(){
//G('.deletepreferredcode').attr( "rel", id );
G("#sbox-window").css("top", '40%');				
//G("#sbox-window").css("position", "");				

el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=addcodes';
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 680, y:568}}"))
SqueezeBox.fromElement(el,options);
}
function editcode(id){
	el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=editcodes&id='+id+'';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 680, y:550}}"))
	SqueezeBox.fromElement(el,options);
}
function cancelcode(id){
		G('.deletepreferredcode').attr( "rel", id );
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
		G('.windowex #cancelexcandel').click(function (e) {
		e.preventDefault();
		G('#maskex').hide();
		G('.windowex').hide();
		});
		
		G('.windowex #doneexcannodel').click(function (e) {
		codeidval = G('.deletepreferredcode').attr('rel');
		G.post("index2.php?option=com_camassistant&controller=vendorscenter&task=deletepcode", {code: ""+codeidval+""}, function(data){
			data = data.trim();
			if( data == 'removed' )
			window.parent.parent.location.reload();
			else
			alert("We are unable to delete the code, please contact MyVendorSupport Team.");
		});
		e.preventDefault();
		G('#maskex').hide();
		G('.windowex').hide();
		});
		id = '';
}
</script>
<script type="text/javascript">
G = jQuery.noConflict();
G(document).ready( function(){
	G('.codeinfo_open').click(function(){
		codeid = G(this).attr('data');
		codetype = G(this).attr('rel');
		if(!G(this).hasClass("active")){
			getcodedata(codeid,codetype);
			G('.codeinfo_open').removeClass('active');
			G(this).addClass('active');
		}
		else{
			G('#codedetails_'+codeid).slideUp('slow').html('');
			G('.table_blue_rowdots_submitted').removeClass('active');
			G(this).removeClass('active');
		}
	});
});

function getcodedata(codeid,codetype){
	G.post("index2.php?option=com_camassistant&controller=vendorscenter&task=getpreferredcode", {code: ""+codeid+"", type: ""+codetype+""}, function(data){
	if(data) {
	G('#codedetails_'+codeid).removeClass('loader');
	G('.prop_details').slideUp();
	G('.table_blue_rowdots_submitted').removeClass('active');
	G('#table_blue_rowdots'+codeid).addClass('active');
	G('#codedetails_'+codeid).html(data).slideDown('slow');
	G('#codedetails_'+codeid).show();
	}
	else{
	G('#codedetails_'+codeid).removeClass('loader');
	G('#codedetails_'+codeid).html("No proposals for this RFP");
	}
	});
}
//Function to get the popup for request money
	function request_money(codeid,eligible,amount){
		if( eligible == 'yes' )
			requestmoneypbox(codeid,eligible,amount);
		else
			norequestmoney();
			
	}
	//Request money popup box
	function requestmoneypbox(codeid,eligible,amount){
	el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=requestmoney&codeid='+codeid+'&eligible='+eligible+'&amount='+amount+'';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 680, y:420}}"))
	SqueezeBox.fromElement(el,options);
	}
	//Function to get the error popup box
	function norequestmoney(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskrr').css({'width':maskWidth,'height':maskHeight});
		G('#maskrr').fadeIn(100);
		G('#maskrr').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitrr").css('top',  winH/2-G("#submitrr").height()/2);
		G("#submitrr").css('left', winW/2-G("#submitrr").width()/2);
		G("#submitrr").fadeIn(2000);
		G('.windowrr #cancelrr').click(function (e) {
		e.preventDefault();
		G('#maskrr').hide();
		G('.windowrr').hide();
		});
	}
	function getpopuptext(){
	el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=mastertext';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 672, y:615}}"))
	SqueezeBox.fromElement(el,options);
}
</script>
<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:545px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}

#maskrr { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesrr .windowrr {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesrr #submitrr {  width:545px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxesrr #submitrr a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donerr {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closerr {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}

</style>

</head>

<body>
<p style="height:20px;"></p>

<div class="newcode_main_manager">
<div class="creatcode_div"><p>Easily create an additional <span>revenue stream</span> for your business or properties with a Preferred Vendor code 
<span class="moreinfo_newone"><img src="templates/camassistant_left/images/arrow_master.png" /><a href="javascript:void(0);" onclick="javascript:getpopuptext();">More Info</a></span></p>
<div align="center" class="add_newcode_manager"><a class="addnewcode" onclick="invitevendor();" href="javascript:void(0);"></a></div>
</div>
<div class="manimage_div"><img src="templates/camassistant_left/images/preferred_man.png" /></div>
</div>

<div id="i_bar_terms" style="margin-bottom:0px; clear:both;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">PREFERRED VENDOR CODES</font></span>
</div></div>

<?php $codes = $this->codes;
//echo "<pre>"; print_r($codes); echo "</pre>";
 ?>
<div class="table_pannel">
<div class="table_panneldiv">

<?php if($codes){ ?>
<table width="99%" cellspacing="0" cellpadding="0" style="margin:0px 4px">
<tr class="table_green_row listcodes">
	<td></td>
    <td width="195"  valign="middle" align="center" class="firsttd"><span>CODE</span></td>
    <td width="200" valign="middle" align="center">RENEWAL PERIOD</td>
    <td width="270" valign="middle" align="center">COST</td>
    <td width="160"  valign="middle" align="center">#SOLD</td>
  </tr>
	<?php for ( $c = 0; $c < count( $codes ); $c++ ) { ?>
	<tr class="table_blue_rowdots_submitted" id="table_blue_rowdots<?php echo $codes[$c]->id; ?>" >
	<td valign="middle" align="center" valign="middle" width="15">
	<a id="getcodeinfo_<?php echo $codes[$c]->id; ?>" class="codeinfo_open" data="<?php echo $codes[$c]->id; ?>" rel="open" href="javascript:void(0);"></a>
	</td>		
	<td valign="middle" align="center" width="153"><strong><?php echo $codes[$c]->code ; ?></strong></td>
	<td valign="middle" align="center" width="200"><strong><?php echo ucfirst($codes[$c]->renewtype) ; ?></strong></td>
	<td valign="middle" align="center" width="270"><span class="price_newcodes"><strong><?php echo "$".number_format($codes[$c]->cost,2) ; ?></strong></span></td>
	<td valign="middle" align="center" width="160"><?php echo $codes[$c]->sold ; ?></td>
	</tr>
	<tr><td colspan="5"><div id="codedetails_<?php echo $codes[$c]->id; ?>" class="prop_details" ></div></td></tr>
	<?php } ?>
</table>

<?php 
		} else { ?>

<p style="padding-top:20px; text-align:center;">You have not created any Preferred Vendor Codes</p>
<?php } ?>

</div>
</div>

<p style="height:50px;"></p>
<div id="i_bar_terms_red" style="margin-bottom:0px;">
<div id="i_bar_txt_terms_red">
<span> <font style="font-weight:bold; color:#FFF;">CANCELED CODES</font></span>
</div></div>

<?php $codesc = $this->codes_cancel;
//echo "<pre>"; print_r($codesc); echo "</pre>";
 ?>
<div class="table_pannel_canceled">
<div class="table_panneldiv">
<?php if($codesc){ ?>
<table width="99%" cellspacing="0" cellpadding="0" style="margin:0px 4px">
	<tr class="table_green_row listcodes">
	<td></td>
    <td width="195"  valign="middle" align="center" colspan="1" class="firsttd">CODE</td>
    <td width="200" valign="middle" align="center">RENEWAL PERIOD</td>
    <td width="270" valign="middle" align="center">COST</td>
    <td width="160"  valign="middle" align="center">#SOLD</td>
  </tr>
	<?php for ( $c = 0; $c < count( $codesc ); $c++ ) { ?>
	<tr class="table_blue_rowdots_submitted" id="table_blue_rowdots<?php echo $codesc[$c]->id; ?>" >
	<td valign="middle" align="center" valign="middle" width="15">
	<a id="getcodeinfo_<?php echo $codesc[$c]->id; ?>" class="codeinfo_open" rel="cancel" data="<?php echo $codesc[$c]->id; ?>" href="javascript:void(0);"></a>
	</td>		
	<td valign="middle" align="center" width="153"><strong><?php echo $codesc[$c]->code ; ?></strong></td>
	<td valign="middle" align="center" width="190"><strong><?php echo ucfirst($codesc[$c]->renewtype) ; ?></strong></td>
	<td valign="middle" align="center" width="270"><span class="price_newcodes"><strong><?php echo "$".number_format($codesc[$c]->cost,2) ; ?></strong></span></td>
	<td valign="middle" align="center" width="160"><?php echo $codesc[$c]->sold ; ?></td>
	</tr>
	<tr><td colspan="5"><div id="codedetails_<?php echo $codesc[$c]->id; ?>" class="prop_details" ></div></td></tr>
	<?php } ?>
</table>

<?php 
		} else { ?>
<p style="padding-top:20px; text-align:center;">You have not canceled any Preferred Vendor Codes</p>
<?php } ?>

</div>
</div>


</body>
</html>


<div id="boxesrr" style="top:576px; left:582px;">
<div id="submitrr" class="windowrr" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="wrongrequestmsg">You have a <strong>$0.00</strong> balance for this code; therefore, you cannot request money.</p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelrr" name="donerr" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskrr"></div>
</div>



<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid #77b800; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 #77b800;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">CANCEL CODE</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">WARNING: If you cancel this Code, none of the Vendors will be automatically renewed upon the Renewal Date. <strong>Would you still like to cancel this Code?</strong></p>
</div>

<div style="text-align:center; width:250px; margin:0 auto; padding-top:30px;">
<div class="nodeletecancelcode" value="Cancelex" name="closeexcan" id="cancelexcandel"></div>
<a class="deletepreferredcode" id="doneexcannodel" rel=""></a>
</div>

</div>
  <div id="maskex"></div>
</div>