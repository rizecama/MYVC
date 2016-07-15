<?PHP
$compliance = $_REQUEST['compliance'];
$OLN_title = $_REQUEST['OLN_title'];
if($OLN_title != '')
$delid = $OLN_title;
else
$delid = $compliance;
//echo 'anand'; exit;
?><div id="line_task_OLN<?PHP echo $OLN_title; ?>">
<div class="lic-pan">
    <h2>Bus. Tax Receipt / Occupational License - <?PHP echo $OLN_title; ?></h2>
   <div class="clear"></div>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayOLN<?PHP echo $OLN_title; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"  ><span class="upload<?PHP echo $OLN_title; ?>"  id="uploadnewOLN<?PHP echo $OLN_title; ?>" style="width:160px; left:-6px;"><a href="javascript:doc_upload('<?PHP echo $OLN_title; ?>','OLN','');" id="upload_compliance"></a></span> <span class="remove<?PHP echo $OLN_title; ?>"><a href="javascript:doc_upload_second('<?PHP echo $OLN_title; ?>','OLN','','second');" id="update_compliance" id="removeOLN<?PHP echo $OLN_title; ?>" style="display:none;">
       </a></span>
              <input type="hidden" name="dOLN<?PHP echo  $OLN_title; ?>" id="dOLN<?PHP echo  $OLN_title; ?>"  value="" />
  <!-- <input type="file" class="file_input_hidden"  name="OLN_upld_cert[]" onchange="ajaxFileUpload('OLN','');" />--></div> 
  
  <div class="reeditbuttons" id="savedocs_vendor">
<div class="GLI3">
<a href="javascript: Alt_saveassubmit('OLN<?PHP echo $OLN_title; ?>');" class="save_complaince"></a>
<a href="javascript:cenceleditdocs();" class="cancel_compliance"></a><br />

</div>
</div>

  
  
  <input type="hidden" class="file_input_textbox" name="OLN_upld_cert[]" id="OLN_upld_cert<?PHP echo  $OLN_title; ?>"  value="" /></div></div>
    <div class="lic-pan-rightnew">
      <div class="comm">
        <label>Expiration Date:</label>
          <input name="OLN_expdate[]" id="OLN_expdate<?PHP echo $compliance; ?>" type="text" class="t_field" placeholder = "mm-dd-yyyy" value="" />
<script type="text/javascript">G('#OLN_expdate<?PHP echo $compliance; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,minDate: "0y",maxDate: "+5y"});</script>

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
      
    </div>
    <div class="clear"></div>

<input type="hidden" name="old_line_task_OLN_ids[]" id="old_line_task_OLN_ids_<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="OLN_status[]" value="1" />
 <input type="hidden" name="dOLN<?PHP echo $compliance; ?>" id="dOLN<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="current_line_task_OLN_ids[]" id="current_line_task_OLN_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
<input type="hidden" value="yes" name="OLN_editready" id="OLN_idedit<?PHP echo $compliance; ?>" />
  </div>
  
</div><?php exit; ?>
<?php /* ?>
<div id="line_task_OLN<?PHP echo $OLN_title; ?>">
<div class="lineitem_pan_row" style="padding-top: 25px;">
<div class="tab_title">My Occupational License Info <span style="font-weight: bold;" id="OLN_<?PHP echo $OLN_title; ?>"><?PHP echo $OLN_title; ?></span> :</div>
<div class="date_verifid">
<table border="0"><tr><td>
<img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/date_verified.gif" alt="dateverified" width="87" height="22" align="left" /></td>
<td> <strong></strong> </td>
<td><input name="OLN_date_verified[]" id="OLN_date_verified<?PHP echo $compliance; ?>" type="text" style=" width:70px;" value=""/> </td></tr></table>
</div>
<input type="hidden" name="old_line_task_OLN_ids[]" id="old_line_task_OLN_ids_<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="current_line_task_OLN_ids[]" id="current_line_task_OLN_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
<div class="clear"></div>
<div class="lineitem_pan">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td width="43%"><label><strong>Occupational License Number <span id="OLN_no<?PHP echo $OLN_title; ?>"><?PHP echo $OLN_title; ?></span> : </strong></label><br/>
<input type="text" name="OLN_license[]" id="OLN_license<?PHP echo $compliance; ?>" class="t_field" style="width:230px;" value=""/>
</td>
<td width="20%"><label><strong>Expiration date : </strong></label><br />
               <table width="96%" border="0" cellspacing="0" cellpadding="0">
			   <tr><td align="left" valign="top" width="72"><?php /*?>onChange="javascript: OLN_modify_date(this.value,<?PHP echo $compliance; ?>);"
<input name="OLN_expdate[]" id="OLN_expdate<?PHP echo $compliance; ?>" type="text" class="t_field" style="width:70px;" value="" /></td>
				<td width="53"><script type="text/javascript">G('#OLN_expdate<?PHP echo $compliance; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script></td>
				</tr>
				</table></td>
<td width="25%"><label><strong>City/County : </strong><!--<span class="redstar">*</span> --></label><br/><input name="OLN_city_country[]" id="OLN_city_country<?PHP echo $compliance; ?>" type="text" class="t_field" style="width:140px;" value=""/></td>
<td width="12%"><label><strong>State :</strong><!--<span class="redstar">*</span> --></label><br /><?php echo $this->states; ?></td>
</tr>
<tr><td colspan="3">
				  <table width="500" border="0" cellspacing="0" cellpadding="0">
				  <tr><td width="213" class="file_input_div">
				  <div class="file_input_div"><input type="button" class="file_input_button"><input type="file" class="file_input_hidden"  name="OLN_upld_cert[]" onChange="javascript: document.getElementById('OLN_upld_cert<?PHP echo $compliance; ?>').value = this.value.replace('C:\\fakepath\\', '')" />
				  </div>
				  </td>
				  <td width="87"><input type="text" readonly="readonly" class="file_input_textbox" id="OLN_upld_cert<?PHP echo $compliance; ?>" /></td>
				  <td width="74"><?php /*?><a href="#"><img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/viewfile.gif" width="71" height="22" alt="View File" /></a><?php</td>
				  <td width="126" height="40"><?php /*?><a href="#"><img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/deletefile.gif" width="71" height="22" alt="Delete file" /></a><?php </td>
				  </tr>
				  </table>
	</td>
	<td>&nbsp;</td>
</tr>
<tr><td align="left" id="OLN_delete_<?PHP echo $OLN_title; ?>"><a href="javascript:del_callajaxcomp_OLN('occupational_license','','<?PHP echo $delid; ?>');"><img src="templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a></td>
<td><?php /*?><a href="javascript:callajaxcomp_OLN('<?PHP echo $compliance; ?>');"><img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/addanother.gif" alt="Add another occupational License" width="195" height="22" /></a><?php &nbsp;</td>
<td>&nbsp;</td><td align="left">&nbsp;</td>
</tr>
</table></div></div><?php */?>