<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="templates/camassistant_left/css/style.css" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
H = jQuery.noConflict();
	H(document).ready( function(){
		H('.decline_popup').click(function(){
			H('.responce').val('dec');
			if( H('.firstname').val() == '' || H('.lastname').val() == '' )
				geterrorpopup();
			else
				H('.termsform').submit();
				
		});
		H('.accept_popup').click(function(){
			H('.responce').val('acc');
			if( H('.firstname').val() == '' || H('.lastname').val() == '' )
				geterrorpopup();
			else
				H('.termsform').submit();
		});
		
	});

function geterrorpopup(){
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
</script>
<script type="text/javascript">
H = jQuery.noConflict();
	H(document).ready( function(){
		H('#decline_popup').click(function(){
			H('.responce').val('dec');
				H('.termsform_accept').submit();
				
		});
		H('#accept_popup').click(function(){
			H('.responce').val('acc');
				H('.termsform_accept').submit();
		});
		
	});

</script>	
<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:450px;  height:175px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>
<body>
<?php 
$cname = JRequest::getVar("cname",'');
$status = JRequest::getVar("status",''); 

?>
<div id="i_bar_terms" style="margin-bottom:0px; margin-left:19px; margin-top:15px; width:608px; text-align:center;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;"><?php echo strtoupper($cname); ?></font></span>
</div></div>
<?php if($this->terms->aboutus){ ?>
<p style="text-align:justify; padding:11px 21px 10px 21px;">
<div class="masterterms">
<?php
echo html_entity_decode($this->terms->aboutus); ?>
</p>
</div>
<div class="clear"></div><div class="sepdashbutton" style="width:605px; margin-left: 20px;"></div><br/></div>
<?php if( $status == 'acc' ) { ?>
   <div class="accept"><img src='templates/camassistant_left/images/right-icon_vendor.png'/><div class="aceprt2">ACCEPTED</div><br><br></div>
    <?php } if( $status == 'dec' ) { ?>
      <form method="post" name="termsform_accept" class="termsform_accept">
	 <div class="accept_decline">
	 <a class="decline_popup" id = "decline_popup" rel="decline" href="javascript:void(0);"></a>
     <a class="accept_popup" id = "accept_popup" rel="accept" href="javascript:void(0);"></a>
	 </div>
	 <input type="hidden" value="com_camassistant" name="option">
	 <input type="hidden" value="invitations" name="controller">
	 <input type="hidden" value="updatenewaccept" name="task">
	 <input type="hidden" value="<?php echo $this->terms->vendorid; ?>" name="masterid">
	 <input type="hidden" value="" name="responce" class="responce">
	</form>

	 <?php } if( $status == 'no' ) { ?>
	 <form method="post" name="termsform" class="termsform">
<table cellpadding="0" cellspacing="0" style="margin-right:21px;" width="100%" class="termspopup">
<tr align="center"><td colspan="2"><label>Full Name</label>:&nbsp;&nbsp;<input type="text" placeholder="First" class="firstname" name="firstname">&nbsp;&nbsp;<input type="text" class="lastname" placeholder="Last" name="lastname"></td></tr>
<tr height="20"></tr>
<tr>
<td align="right"><a class="decline_popup" rel="decline" href="javascript:void(0);"></a></td>
<td align="left"><a class="accept_popup" rel="accept" href="javascript:void(0);"></a></td>
</tr>
<tr height="20"></tr>
</table>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="invitations" name="controller">
<input type="hidden" value="updateaccept" name="task">
<input type="hidden" value="<?php echo $this->terms->vendorid; ?>" name="masterid">
<input type="hidden" value="" name="responce" class="responce">
</form>
<?php } ?>
<?php } else { ?>

<p style="text-align:justify; padding:11px 21px 10px 21px;">
There is no Terms & Conditions for this master...
</p>
<?php } ?>

<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">Please provide both a first and last name before declining or accepting your client's Terms & Conditions.</p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelex" name="doneex" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskex"></div>
</div>


<?php exit;
?>


</body>
</html>


