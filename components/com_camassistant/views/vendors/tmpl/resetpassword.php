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
		G('#current').val('');
		G('#cancelpopup').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('#savepassword').click(function(){
			password = G('#current').val();
			password1 = G('#password1').val();
			password2 = G('#password2').val();
			re = /[0-9]/;
			
			if(!password){
				alert("Please enter current password");
				G('.passwordstatus').show();
			 	G('.passwordstatus').css('background-position','0px -33px');
				return false;
			}
			else if(password) {
			G.post("index2.php?option=com_camassistant&controller=vendors&task=verifypassword", {Password: ""+password+""}, function(data){
			 if(data != 'Yes'){
				 alert("Please enter correct password");
				 G('.passwordstatus').show();
				 G('.passwordstatus').css('background-position','0px -33px');
				 return false;
			 }
			 else{
			 	G('.passwordstatus').show();
				G('.passwordstatus').css('background-position','0px 0px');
					if( !password1 ){
			 	alert("Please enter new password");
				G('.passwordstatus1').show();
			 	G('.passwordstatus1').css('background-position','0px -33px');
				 }
				 else if( password1.length < '7'  ){
					alert("Please enter password with atleast 7 characters");
					G('.passwordstatus1').show();
					G('.passwordstatus1').css('background-position','0px -33px');
				 }
				 else if(!re.test(password1)) { 
				 alert("password must contain at least one number (0-9)");
				 G('.passwordstatus1').show();
				 G('.passwordstatus1').css('background-position','0px -33px');
				 } 
				 else if( password1 != password2){
					alert('Incorrect passwords');
					 G('.passwordstatus1').show();
					 G('.passwordstatus1').css('background-position','0px 0px');
					 G('.passwordstatus2').show();
					 G('.passwordstatus2').css('background-position','0px -33px');
				 }
				 else{
					G('.passwordstatus').show();
					G('.passwordstatus1').show();
					G('.passwordstatus2').show();
					G('.passwordstatus').css('background-position','0px 0px');
					G('.passwordstatus1').css('background-position','0px 0px');
					G('.passwordstatus2').css('background-position','0px 0px');
					G('#resetpassword').submit();
				 }
			 
			 }
			 });
			 }
			 
			 
		});
	});
	
</script>
<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">CHANGE PASSWORD</font></span>
</div></div>
<p class="resettext">Your new password must be AT LEAST 7 characters and include ONE number (0-9). </p>
<form action="#" method="post" id="resetpassword">
<div class="resetpasswords">
<ul class="resetwords">
<li><label>Current Password:</label><input type="password" name="current" id="current" value="" /><span class="passwordstatus"></span></li>
<li><label>New Password:</label><input type="password" name="new" id="password1" value="" /><span class="passwordstatus1"></span></li>
<li><label>Retype New Password:</label><input type="password" name="renew" id="password2" value="" /><span class="passwordstatus2"></span></li>
<br />
<li>
<a id="cancelpopup" href="#"><img src="templates/camassistant_left/images/cancel.png" /></a>
<a id="savepassword" href="#"><img src="templates/camassistant_left/images/save.png" /></a></li>
</ul>
</div>
<input type="hidden" name="option" value="com_camassistant">
<input type="hidden" name="controller" value="vendors">
<input type="hidden" name="task" value="savepassword">
</form>
<?php
exit;
?>