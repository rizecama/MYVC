<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<link href="<?php JPATH_SITE ?>templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<style>
#semdInvitation:hover{
opacity:0.8
}
</style>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
H = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var countyCount = 0;
H(document).ready(function(){
H("#semdInvitation").click(function(){
		var email=H("#email").val();
		var companyname=H("#companyname").val();
		var contactname=H("#contactname").val();
		var phone=H("#phone").val();
		var notes=H("#notes").val();
		var eaddress=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		if(!companyname){
		alert("Please enter company name");
		return false;
		}
		else if(!contactname){
		alert("Please enter contact name");
		return false;
		}
		else{
		window.parent.document.getElementById( 'sbox-window' ).close();		
		alert("Invitation sent successfully.");
		H('#inviteform').submit();
		}
	});
	H("#closewindow").click(function(){
	window.parent.document.getElementById( 'sbox-window' ).close();	
	});
});	

	</script>
</head>

<body>
<div id="l_box_topcurve">
  <div id="l_box_close"></div>
    <p>INVITE A PREFERRED VENDOR</p>
</div>

<form name="inviteform" id="inviteform" method="post" >
<div id="invite-popup">
<p style="text-align:left">A Vendor's email address is preferred but NOT required, as all invitations are copied to CAMassistant. Anything marked with a RED ARROW is required.</p><br />
<div class="invite-popup-main">
<div class="invite-popup-left">
<div class="red-arrow"><img src="templates/camassistant_left/images/red-arrow.jpg" width="10" height="20" alt="" /></div>
<label>Company Name:</label>
<input type="text" value="" id="companyname" name="companyname" />
</div>
</div>
<div class="invite-popup-main">
<div class="invite-popup-left">
<div class="red-arrow"><img src="templates/camassistant_left/images/red-arrow.jpg" width="10" height="20" alt="" /></div>
<label>Contact Name:</label>
<input type="text" value="" id="contactname" name="contactname"/>
</div>
<div class="invite-popup-left" style="margin:0px;">
<label>Phone:</label>
<input type="text" value="" id="phone" name="phone" />
</div>
</div>
<div class="invite-popup-main">
<label>Email Address:</label>
<input type="text" value="" name="email" id="email" class="invite-em"/>
</div>

<div class="invite-popup-main">
<label>Message:</label>
<textarea id="notes" name="notes"></textarea>
</div>
<div class="invite-popup-main" style="width:432px; float:right">
<div class="invite-popup-left">
<img vspace="10" border="0" align="right" src="templates/camassistant_left/images/cancel.png" style="cursor:pointer;" alt="Submit Text" id="closewindow">
</div>
<div style="margin:0px; width:150px;" class="invite-popup-left">
<img vspace="10" border="0" align="right" src="templates/camassistant/images/send-invitation.gif" style="cursor:pointer;" alt="Submit Text" id="semdInvitation">
</div>

</div></div>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="rfpcenter" name="controller">
<input type="hidden" value="sendinvitation" name="task">
</form>
<?php exit; ?>
</body>
</html>
