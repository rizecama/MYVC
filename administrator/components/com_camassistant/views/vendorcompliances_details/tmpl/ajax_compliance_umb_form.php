<?PHP
$compliance = $_REQUEST['compliance'];
$UMB_title = $_REQUEST['UMB_title'];
if($UMB_title != '')
$delid = $UMB_title;
else
$delid = $compliance;
//echo 'anand'; exit;
?><div id="line_task_UMB<?PHP echo $UMB_title; ?>">
<div class="lic-pan">
    <h2><!--<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/empty-icon.gif" alt="" />-->UMBRELLA LIABILITY POLICY - <?PHP echo $UMB_title; ?></h2>
   <div class="clear"></div>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayUMB<?PHP echo $UMB_title; ?>"><span id="adminnofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $UMB_title; ?>"  id="uploadnewUMB<?PHP echo $UMB_title; ?>"><a href="javascript:doc_upload('<?PHP echo $UMB_title; ?>','UMB','');" id="adminupload_compliance"></a></span> <span class="remove<?PHP echo $UMB_title; ?>" ><a href="javascript:doc_upload_second('<?PHP echo $UMB_title; ?>','UMB','','second');" id="update_compliance" id="removeUMB<?PHP echo $UMB_title; ?>" style="display:none;">
       </a></span>
              <input type="hidden" name="dUMB<?PHP echo  $UMB_title; ?>" id="dUMB<?PHP echo  $UMB_title; ?>"  value="" />
  </div> 
  
  <div class="reeditbuttons">
<div class="UMB3">
<a href="javascript: Alt_saveassubmit('UMB<?PHP echo $UMB_title; ?>');" class="adminsave_complaince"></a>
<a href="javascript:cenceleditdocs();" class="admincancel_complaince"></a><br /></div>
</div>

  
  
  <input type="hidden" class="file_input_textbox" name="UMB_upld_cert[]" id="UMB_upld_cert<?PHP echo  $UMB_title; ?>"  value="" /></div></div>
    <div class="lic-pan-rightnew">
      <div class="comm">
	  <div class="in-pan1">
        <label>Exp. Date:</label>
          <input name="UMB_expdate[]" id="UMB_expdate<?PHP echo $compliance; ?>" type="text" class="t_field" value="" /><span style="color:red; font-size: 20px;">*</span>
<script type="text/javascript">G('#UMB_expdate<?PHP echo $compliance; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+5y"});</script>
</div>
<div class="in-pan1">
		<label>Aggregate:</label>
	<input type="text" class="t_field" name="UMB_aggregate[]" id="UMB_aggregate<?PHP echo $UMB_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('UMB_aggregate',this.value,<?PHP echo $UMB_title; ?>);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/><span style="color:red; font-size: 20px;">*</span>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Each Occurrence</label>
        <input type="text" class="t_field" name="UMB_occur[]" id="UMB_occur<?PHP echo $UMB_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('UMB_occur',this.value,<?PHP echo $UMB_title; ?>);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/><span style="color:red; font-size: 20px;">*</span>
		</div>
		</div>
		
		<div class="comm">
		<div class="in-pan">
          <label style="padding-top:5px;">MyVC listed as Cert Holder?</label>
		  <input type="radio" value="yes" name="umb_cert<?PHP echo $UMB_title-1; ?>" />&nbsp;YES &nbsp;<input type="radio" value="no" name="umb_cert<?PHP echo $UMB_title-1; ?>" />&nbsp;No
         
        </div>
		</div>
		
		
      <div class="comm">
	  <div class="in-pan">
        <label style="padding-top:5px;">Last Verified By MyVendorCenter On:</label>
		<input name="UMB_date_verified[]" id="UMB_date_verified<?PHP echo $UMB_title; ?>" type="text"  size="20" value=""/><script type="text/javascript">G('#UMB_date_verified<?PHP echo $UMB_title; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script>
		
		</div>
      </div>
    </div>
    <div class="clear"></div>

<input type="hidden" name="old_line_task_UMB_ids[]" id="old_line_task_UMB_ids_<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="UMB_status[]" value="1" />
 <input type="hidden" name="dUMB<?PHP echo $compliance; ?>" id="dUMB<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="current_line_task_UMB_ids[]" id="current_line_task_UMB_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
<input type="hidden" value="yes" name="UMB_editready" id="UMB_idedit<?PHP echo $compliance; ?>" />
  </div>
  
</div><?php exit; ?>
