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
	G('.add_code_manager').click(function(){
	G("#removeblock").removeAttr("readonly");
	G( "#removeblock" ).focus();
	G(".add_code_manager").hide();
	G(".add_code_manager_active").show();
	});
	
	G('.add_code_manager_active').click(function(){
	code = G("#removeblock").val();
	G.post("index2.php?option=com_camassistant&controller=vinvitations&task=checkcode", {newcode: ""+code+""}, function(data){
	if(data == 1)
	errorpopup();
	else
	{
	if(code == '')
	alert('Please enter code you received')
	else
	G('#addcodeform').submit();
	}
	});
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

</script>

</head>
<?php $code = $this->defaultcode;

?>
 
<body>
<p style="height:20px;"></p>
<div class="newinvitecode_manager">
<div class="creatvendorcode_div"><p>Have your invited Vendors automatically added to your personal <strong>'MY VENDORS'</strong> list by giving them your unique <b>invite code</b> below
</p>
<div class="invitecodebox" >
<form action="" method="post" id="addcodeform" name="addcodeform">
<input type="text" name="invitecode" value="<?php echo $code;?>" readonly="redonly" id="removeblock">
<input type="hidden" name="option" value="com_camassistant">
<input type="hidden" name="controller" value="vinvitations">
<input type="hidden" name="task" value="savevendorcode">
</form>
</div>
<div align="center" class="add_code_manager" ><a class="addnewvendorcode" href="javascript:void(0);">EDIT INVITE CODE</a></div>
<div align="center" class="add_code_manager_active"  style="display:none;"><a class="addnewvendorcode" href="javascript:void(0);">SAVE</a></div>
</div>
<div class="mannewimage_div"><img src="templates/camassistant_left/images/invitevendorcodeimage.jpg" /></div>
</div>

<div class="invitecode"><strong>How to use your Invite Code:</strong></div>
<div class="howtoinvitecode">The code above, in the white box, is your unique Vendor Invite Code.  This code can be entered by any Vendor during registration or after they've registered by clicking on "INVITE CODES" within their account.  Once a Vendor registers, they will automatically be added to your personal "MY VENDORS" list for convenience and tracking (i.e. included in compliance reports). </div>
<div class="changeinvitecode"><strong>How to change your Invite Code:</strong></div>
<div class="howtochangeinvitecode">To change your default Invite Code, just click on the "EDIT INVITE CODE" button above.  You can change your invite code to anything you want, just as long as your code doesn't already exist in our system. </div>

<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red; margin-top: 7px;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="error_code">The Invite Code you entered already exists in our system. Please enter a new code and try again.</p>
</div>
<div style="padding-top:46px;" align="center">
<div id="cancelex" name="doneex" value="Ok" class="errorcode_button"></div>
</div>
</div>
  <div id="maskex"></div>
</div>