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
	
	H('.newreminder').click(function(){
			H("#rolloverimage").show();
			H("#buttons_uninvite").hide();	
			H('#uninviteform').submit();
	});
	
	H('.newcancel').click(function(){
	window.parent.document.getElementById( 'sbox-window' ).close();		
	});
});
</script>
<?php
$rfpid = JRequest::getVar('rfpid','');
$vendors = JRequest::getVar('vendors','');
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
?>	
<form action="" method="post" name="uninviteform" id="uninviteform">
<div id="messageboxs">
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:10px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">UN-INVITE VENDORS</font></span>
</div></div>

<div class="uninvited_firstdd_text">
<span>Please explain why you are un-inviting the Vendor(s)</span>
<p>Note: We recommend entering a reason so the Vendor understands why their products or services are no longer needed.</p></div>
<div class="textareabox">
<textarea name="reason" id="reason"></textarea>
</div>
<div id="buttons_uninvite"><br />
<table align="center" width="100%">
<tbody>
<tr>
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
<input type="hidden" value="send_message" name="task" />
<input type="hidden" value="<?php echo $vendors; ?>" name="vendors" id="vendors" />
<input type="hidden" value="<?php echo $rfpid; ?>" name="rfpid" id="rfp_id" />
</form>
<?php exit; ?>

