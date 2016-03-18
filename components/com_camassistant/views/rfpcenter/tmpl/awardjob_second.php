<?php
$rfpno = JRequest::getVar('rfpno','');
$proposalid = JRequest::getVar('proposalid','');
$shareinfo = JRequest::getVar('shareinfo','');
$awardedto = JRequest::getVar('awardedto','');
?>
<script language="JavaScript" type="text/javascript" src="components/com_camassistant/assets/wysiwyg_award.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script>
	N = jQuery.noConflict();
	N(document).ready(function() {	
	
	N('.editstandardsind').live('click',function(e) {
		N('#specialreqs').submit();
	});	
	N('.editstandardall').live('click',function(e) {
		N('#industryall').val('all');
		N('#specialreqs').submit();
	});	
	N('.cancelbutton').live('click',function(e) {
		
		id = N('#industryall').val();
		N('.formcontent').html('');
		if(N(this).hasClass('active'))
		{
				N('#sowform_'+id).html('');
				N(this).removeClass('active')
		}
		else 
		{
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getsowform", {industryid: ""+id+""}, function(data){
			N('#sowform_'+id).html(data);
			N('#sowform_'+id).slideDown('slow');
			Custom.init();
			});
			N(this).addClass('active');
		}
			
	});
	
	N('#saveoption').click(function(){
		N('#editable').val('');
		N('textarea[rel="editor"]').each(function(){
		var n=N(this).attr('id');
		document.getElementById(n).value = document.getElementById("wysiwyg" + n).contentWindow.document.body.innerHTML;
		notesstrings = document.getElementById(n).value ;
		notesstrings = notesstrings.replace("’", "'");
		notesstrings = notesstrings.replace(/[^\u000A\u0020-\u007E]/g, ' ');
		document.getElementById(n).value = notesstrings ;
		});
		if (notesstrings.indexOf("{winning Bid}") < 0)
		{
			//pricepopupbox();
			//alert("Please don't remove the text {winning Bid} from the notification");
			N( "#aboutformsubmit" ).submit();
		}
		else{
		N( "#aboutformsubmit" ).submit();
		}
	});
	
	N('.continue_award').click(function(){
		if( N('#editable').val() == 'yes' ){
			alert("Please SAVE or CANCEL the revised AWARD NOTIFICATION above");
		}
		else{
			N( ".mail_save" ).submit();
		}	
	});
	
	N('.cancel_award').click(function(){
		rfpid = N('#rfpno').val();
		N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=deleteeditmailtext", {rfpno: ""+rfpid+""}, function(data){
		window.location = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';	
		});
	});
	
	N('#editoption').live('click',function(){
		N('#editable').val('yes');
		N('#aboutform').show();
		N('.detailsextra').hide();
		N('.detailsextra_nonedit').show();
	});
		N(".awardjob_mail").contents().find("body").css("font-size","13px");
		N(".awardjob_mail").contents().find("body").css("font-family","sans-serif");
		N(".awardjob_mail").css("height","200px"); 
		
		
	});
	function pricepopupbox(){
		
	}
</script>
<p style="height:20px;"></p>
<div align="center"><img src="templates/camassistant_left/images/award_step2.png"></div>
<p style="height:30px;"></p>
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">AWARD NOTIFICATION TO VENDOR</font></span>
</div></div>
<?php 
$message = explode('{devider}',$this->message);
 ?>
 <div class="detailsextra_nonedit" style="display:none;">
<div class="awardjobmailnonedit"><?php echo html_entity_decode($message[0]); ?> 
</div> 
</div>
<div class="detailsextra">
<br />
<div class="awardjobmailedit"><?php echo html_entity_decode(str_replace('{devider}','',$this->message)); ?> 
<p id="topborder_row_awarded"></p>
<table cellpadding="0" cellspacing="0" width="100%" class="awardjob_table">
<tr>
<td align="right">
<a id="editoption" href="javascript:void(0);" class="editoption_award"><strong><img src="templates/camassistant_left/images/EditMini.png" /></strong></a></td>
</tr>

</table>
</div>
</div>

<br />
<div id="aboutform" style="display:none;">
<form action="" method="post" id="aboutformsubmit">
<table cellpadding="0" cellspacing="0">
<tr><td colspan="3">
 <textarea rel="editor" name="mailtext" id="awardjob_mail" style="height:200px; margin-left:1px; width:667px;"><?php echo $message[1]; ?></textarea>
<script language="javascript1.2">
generate_wysiwyg('awardjob_mail');
</script>

 </td></tr>
 <tr height="5"></tr>
 <tr><td align="right"><a href="javascript:void(0);" onClick="window.location.reload()" id="cancellink"><img src="templates/camassistant_left/images/CancelMini.png" /></a> <a id="saveoption" href="javascript:void(0);" style="font-weight:bold; color: #7ab800;"><img src="templates/camassistant_left/images/SaveMini.png" /></a></td></tr>
<tr height="10"></tr>
<tr><td style="color: #808080; font-size: 13px; padding-left: 9px; text-align: left;">
</td></tr>
</table>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="rfpcenter" name="controller">
<input type="hidden" value="save_awardedemail" name="task">
<input type="hidden" value="<?php echo $rfpno; ?>" name="rfpid" />
<input type="hidden" value="" id="editable" />
<input type="hidden" value="<?php echo $message[0]; ?>" name="non_edit" />
</form>
</div>

<div class="mainformbuttons">
<a href="javascript:void(0);" class="cancel_award"></a>
<a href="javascript:void(0);" class="continue_award"></a>
</div>
<form class="mail_save" method="post">
<input type="hidden" name="rfpno" value="<?php echo $rfpno; ?>" id="rfpno" />
<input type="hidden" name="proposalid" value="<?php echo $proposalid; ?>" />
<input type="hidden" name="shareinfo" value="<?php echo $shareinfo; ?>" />
<input type="hidden" name="awardedto" value="<?php echo $awardedto; ?>" />
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="rfpcenter" name="controller">
<input type="hidden" value="save_emailsubmit" name="task">

</form>
