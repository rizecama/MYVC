<link rel="stylesheet" href="<?PHP echo juri::base(); ?>templates/camassistant_left/css/style.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
H = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var countyCount = 0;
H(document).ready( function(){
	H('.firstdd').change(function(){
		if( H('.firstdd').val() == '' || H('.firstdd').val() == '0' ){
			H('.reminder_seconddd_text').hide();
			H('.reminder_seconddd').html('');
		}
		else{
			H(".firstdd option[value='0']").remove();
			H('.reminder_seconddd_text').show();
			rfpid = H('#rfp_id').val();
			if( H('.firstdd').val() == '1' ){
				H.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getinvites", {rfpid:""+rfpid+"", ptype:"itb"}, function(data){
				H('.reminder_seconddd').html(data);
				});
			}
			else
			{
				H.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getinvites", {rfpid:""+rfpid+"", ptype:"draft"}, function(data){
				H('.reminder_seconddd').html(data);
				});
			}
		}
	});
	
	H('.newreminder').click(function(){
		if( H('.firstdd').val() == '' || H('.firstdd').val() == '0'){
			H('.reminder_seconddd_text').hide();
			alert("Please select reminder type.");
		}
		else if( H('.vendor_drop').val() == '' || H('.vendor_drop').val() == '0'){
			alert("Please select the vendor.");
		}
		else{
			H("#rolloverimage").show();
			H("#buttons_uninvite").hide();	
			H('#reminderbox').submit();
		}
	});
	
	H('.newcancel').click(function(){
	window.parent.document.getElementById( 'sbox-window' ).close();		
	});
	
	H('.vendor_drop').live('change', function(){
		H(".vendor_drop option[value='0']").remove();
	});
});
</script>
<?php
$rfpid = JRequest::getVar('rfpid','');
?>	
<form action="" method="post" name="reminderbox" id="reminderbox">
<div id="reminder">
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:10px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">SEND REMINDER</font></span>
</div></div>

<div class="reminder_firstdd_text">Please choose the type of reminder you would like to send</div>
<div class="reminder_firstdd"><select name="firstdd" class="firstdd">
<option value="0">Select Reminder Type</option>
<option value="1">Respond to invitation</option>
<option value="2">Submit a proposal</option>
</select></div>

<div class="reminder_seconddd_text" style="display:none;">Please choose the Vendors you would like to submit this reminder to</div>
<div class="reminder_seconddd"></div>

<div id="buttons_uninvite">
<table align="center" width="100%">
<tbody><tr>
<td align="right">
<a class="newcancel" style="padding:0px; margin:0px;" href="javascript:void(0);"></a>
</td>
<td><a class="newreminder" href="javascript:void(0);" style="padding:0px; margin:0px;"></a>
</td>
</tr>
</tbody></table>
</div>
<div id="rolloverimage" style="display:none;"></div>
</div>
<input type="hidden" value="com_camassistant" name="option" />
<input type="hidden" value="rfpcenter" name="controller" />
<input type="hidden" value="send_reminder" name="task" />
<input type="hidden" value="<?php echo $rfpid; ?>" name="rfpid" id="rfp_id" />
</form>
<?php exit; ?>