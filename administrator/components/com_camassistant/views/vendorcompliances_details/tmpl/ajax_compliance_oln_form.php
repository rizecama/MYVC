<?PHP
$compliance = $_REQUEST['compliance'];
$OLN_title = $_REQUEST['OLN_title'];
if($OLN_title != '')
$delid = $OLN_title;
else
$delid = $compliance;
?><div id="line_task_OLN<?PHP echo $OLN_title; ?>">
<div class="lic-pan">
    <h2><!--<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/empty-icon.gif" alt="" />-->Bus. Tax Receipt / Occupational License - <?PHP echo $OLN_title; ?></h2>
   <div class="clear"></div>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayOLN<?PHP echo $OLN_title; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $OLN_title; ?>"  id="uploadOLN<?PHP echo $OLN_title; ?>" style="width:160px; left:-6px;"><a href="javascript:doc_upload('<?PHP echo $OLN_title; ?>','OLN','');" id="adminupload_compliance"></a></span> <span class="remove<?PHP echo $OLN_title; ?>"><a href="javascript:doc_upload_second('<?PHP echo $OLN_title; ?>','OLN','','second');" id="update_compliance" id="removeOLN<?PHP echo $OLN_title; ?>" style="display:none;">
       </a></span>            
	   
	   <input type="hidden" name="dOLN<?PHP echo  $OLN_title; ?>" id="dOLN<?PHP echo  $OLN_title; ?>"  value="" />
  <!-- <input type="file" class="file_input_hidden"  name="OLN_upld_cert[]" onchange="ajaxFileUpload('OLN','');" />--></div> 
  
  <div class="reeditbuttons">
<div class="GLI3">
<a href="javascript: Alt_saveassubmit('OLN<?PHP echo $OLN_title; ?>');" class="adminsave_complaince"></a>
<a href="javascript:cenceleditdocs();" class="admincancel_complaince"></a><br />
</div>
</div>

  <input type="hidden" class="file_input_textbox" name="OLN_upld_cert[]" id="OLN_upld_cert<?PHP echo  $OLN_title; ?>"  value="" /></div></div>
    <div class="lic-pan-right">
      <div class="comm">
        <label>Expiration Date:</label>
          <input name="OLN_expdate[]" id="OLN_expdate<?PHP echo $compliance; ?>" type="text" class="t_field" value="" />
<script type="text/javascript">G('#OLN_expdate<?PHP echo $compliance; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+5y"});</script>
<script type="text/javascript">
	G('#OLN_expdate<?PHP echo $compliance; ?>').click(function(){
	var check = "<span class='othercheck'><input type='checkbox' value='does not expire' onclick='closecalOLN<?PHP echo $compliance; ?>();'>This document does not expire</span>";
	G('.othercheck').empty();
	G('#ui-datepicker-div').show();
	G('#ui-datepicker-div').append(check);
	});
	function closecalOLN<?PHP echo $compliance; ?>(){
		G('#OLN_expdate<?PHP echo $compliance; ?>').val('Does Not Expire');
		G('#ui-datepicker-div').hide();
	}
	</script>
      </div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
        <input name="OLN_date_verified[]" id="OLN_date_verified<?PHP echo $compliance; ?>" type="text" value=""/><script type="text/javascript">G('#OLN_date_verified<?PHP echo $compliance; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script>
      </div>
    </div>
    <div class="clear"></div>
 
<input type="hidden" name="old_line_task_OLN_ids[]" id="old_line_task_OLN_ids_<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="OLN_status[]" value="1" />
 <input type="hidden" name="dOLN<?PHP echo $compliance; ?>" id="dOLN<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="current_line_task_OLN_ids[]" id="current_line_task_OLN_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
<input type="hidden" value="yes" name="OLN_editready" id="OLN_idedit<?PHP echo $compliance; ?>" />
</div> </div>
<?PHP exit; ?>
