<?php
/**
 * $Id: default.php 11917 2009-05-29 19:37:05Z ian $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
//$cparams = JComponentHelper::getParams ('com_media');
?>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery.elastic.js"></script>
<script type="text/javascript">
G = jQuery.noConflict();

function save_submit(){
	firstname = G('#firstname').val() ;
	lastname = G('#lastname').val() ;
	companyname = G('#companyname').val() ;
	email = G('#email').val() ;
	phonenumber1 = G('#phonenumber1').val() ;
	phone1 = phonenumber1.length;
	phonenumber2 = G('#phonenumber2').val() ;
	phone2 = phonenumber2.length;
	phonenumber3 = G('#phonenumber3').val() ;
	phone3 = phonenumber3.length;
	pickdate = G('#pickdate').val() ;
	if(!firstname) {
		alert("Please enter your first name.");
		G( "#firstname" ).focus();
	}
	else if(!lastname) {
		alert("Please enter your last name.");
		G( "#lastname" ).focus();
	}
	else if(!companyname) {
		alert("Please enter your company name.");
		G( "#companyname" ).focus();
	}
	else if(phone1 != '3' || phone2 != '3' || phone3 != '4' ) {
		alert("Please enter your correct phone number");
	}
	
	else if( isNaN(phonenumber1) || isNaN(phonenumber2) || isNaN(phonenumber3)) {
		alert("Please enter your correct phone number");	
	}
	
	else if(!email) {
		alert("Please enter your email address.");
		G( "#email" ).focus();
	}
	else if(email){
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			if( !emailReg.test( email ) ) {
				alert("Please enter proper email address.");
			}
			else if( !G(".rep").is(':checked')  ) {
				alert("Please select an option When would you like a DEMO?");
				G( ".rep" ).focus();
			}
			else if( G("#spec").is(':checked') ){
			if(pickdate == ''){
				alert("Please select the Request a Date.");
				G( "#spec" ).focus();
			}
			else{
				G('#demoformpage').submit();
			}
			}
			else{
				G('#demoformpage').submit();
			}
	
	}
	
	
	
}
G(document).ready(function(){
	G('#spec').click(function(){
		G('#pickdate').show();
	});
	G('#rep').click(function(){
		G('#pickdate').hide();
	});
	
G('#firstname').keyup(function(){
		if( G(this).val() == '' )
		G( this ).prev().removeClass( 'active' );
		else
		G( this ).prev().addClass( 'active' );
	});
G('#lastname').keyup(function(){
		if( G(this).val() == '' )
		G( this ).prev().removeClass( 'active' );
		else
		G( this ).prev().addClass( 'active' );
	});
	
	G('#companyname').keyup(function(){
		if( G(this).val() == '' )
		G( this ).prev().removeClass( 'active' );
		else
		G( this ).prev().addClass( 'active' );
	});
	G('#email').keyup(function(){
		if( G(this).val() == '' )
		G( this ).prev().removeClass( 'active' );
		else
		G( this ).prev().addClass( 'active' );
	});
	G('#phonenumber1').keyup(function(){
		if( G(this).val() == '' )
		G( this ).prev().removeClass( 'active' );
		else
		G( this ).prev().addClass( 'active' );
	});	

G("input[type='radio']").click(function(){
var radioValue = G("input[name='rep']:checked").val();
if (radioValue == 'rep')
G( ".new" ).addClass( "addclass" );
});
});


</script>
	<div class="componentheading">

	</div>
<br />
<div class="demopage">
<div id ="demopage_content">
<form id="demoformpage" method="post">
<ul>
<li style="float:left"><label>First Name</label><input type="textbox" id="firstname" name="firstname" value=""></li>
<li><label >Last Name</label><input type="textbox" id="lastname" name="lastname" value=""></li>
<li class="company"><label>Company Name</label><input type="textbox" value="" name="companyname" id="companyname" ></li>
<li class="phone"><label>Phone Number</label>
<input type="textbox" value="" name="phonenumber1" id="phonenumber1" maxlength="3" style="width:40px; text-align:center;" >&nbsp;-&nbsp;
<input type="textbox" value="" name="phonenumber2" id="phonenumber2" maxlength="3" style="width:40px; text-align:center;" >&nbsp;-&nbsp;
<input type="textbox" value="" name="phonenumber3" id="phonenumber3" maxlength="4" style="width:40px; text-align:center;" >
</li>
<li class="email" style="margin-bottom:20px;"><label>Email Address</label><input type="textbox" value="" name="email" id="email"></li>
<li class="demo"><p><span class="new"></span>When would you like a Demo?</p></li>
<li class="check"><input type="radio" name="rep" id="rep" class="rep" value="rep"><p>Have a MyVC Representative contact me</p></li>
<li class="specific"><input type="radio" name="rep" id="spec" class="rep" value="rep"><label style="background:none; padding:0px; line-height:0px;">Request a Date</label>
<div class="clear"></div><input style="display:none; margin-left:17px; margin-top:7px;" type="text" name="pickdate" id="pickdate" value="" readonly="readonly">
</li>
<li><p style="height:0px;"></p></li>
<li class="check"><input type="checkbox" name="copy" id="copy">E-mail a copy of this message to your own address.</li>
<script type="text/javascript">
G('#pickdate').datetimepicker({
			dateFormat: 'mm-dd-yy',
			//minDate: '10D',
			minDate: '2D',
			//minDate: 'new',
			 timeFormat: 'hh:mm',
			changeYear: true,changeMonth:true,
			//ampm: true,

 beforeShowDay: function (date) {
        //if (date.getDay() == 0 || date.getDay() == 1 || date.getDay() == 6) {
		if (date.getDay() == 0 || date.getDay() == 1 || date.getDay() == 6) {
                    return [true, ''];
                } else {
                    return [true, ''];
                }

     }

});
</script>
<li class="buttondemo" style="margin-top:10px; margin-bottom:40px;">
<input type="button" onclick="javascript:save_submit();" value="SUBMIT" />
<input type="hidden" value="com_contact" name="option">
<input type="hidden" value="" name="controller">
<input type="hidden" value="savedemo" name="task">
</li>
</li>
</ul>
</div>
</div>

