<?PHP
$compliance = $_REQUEST['compliance'];
$OMI_title = $_REQUEST['OMI_title'];
if($OMI_title != '')
$delid = $OMI_title;
else
$delid = $compliance;
//echo 'anand'; exit;
?><div id="line_task_OMI<?PHP echo $OMI_title; ?>">
<div class="lic-pan">
    <h2><!--<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/empty-icon.gif" alt="" />-->ERRORS & OMISSIONS INSURANCE - <?PHP echo $OMI_title; ?></h2>
   <div class="clear"></div>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayOMI<?PHP echo $OMI_title; ?>"><span id="adminnofileuploaded">NO FILE UPLOADED</span></div>
<div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $OMI_title; ?>"  id="uploadnewOMI<?PHP echo $OMI_title; ?>"><a href="javascript:doc_upload('<?PHP echo $OMI_title; ?>','OMI','');" id="adminupload_compliance"></a></span>  
	  <span class="remove<?PHP echo $OMI_title; ?>" ><a href="javascript:doc_upload_second('<?PHP echo $OMI_title; ?>','OMI','','second');" id="update_compliance" id="removeOMI<?PHP echo $OMI_title; ?>" style="display:none;"></a></span>
              <input type="hidden" name="dOMI<?PHP echo  $OMI_title; ?>" id="dOMI<?PHP echo  $OMI_title; ?>"  value="" />
  </div> 
  
  <div class="reeditbuttons">
<div class="OMI<?PHP echo $OMI_title; ?>" >
<a href="javascript: Alt_saveassubmit('OMI<?PHP echo $OMI_title; ?>');" class="adminsave_complaince"></a>
<a href="javascript:cenceleditdocs();" class="admincancel_complaince"></a><br />
<?php /*?><div id="OMI_delete_<?PHP echo $OMI_title; ?>"><a href="javascript:del_callajaxcomp_OMI('occupational_license','','<?PHP echo $delid; ?>');"><img alt="" src="components/com_camassistant/assets/images/delete.jpg" style="left:1px; position: relative;"></a></div><?php */?>
</div>
</div>

  
  
  <input type="hidden" class="file_input_textbox" name="OMI_upld_cert[]" id="OMI_upld_cert<?PHP echo  $OMI_title; ?>"  value="" /></div></div>
    <div class="lic-pan-rightnew">
      <div class="comm">
	  <div class="in-pan1">
        <label>Exp. Date:</label>
          <input name="OMI_end_date[]" id="OMI_end_date<?PHP echo $compliance; ?>" type="text" class="t_field" value="" placeholder = "mm-dd-yyyy" />
<script type="text/javascript">G('#OMI_end_date<?PHP echo $compliance; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,minDate: "0y",maxDate: "+5y"});</script>
</div>
<div class="in-pan1">
		<label>Aggregate:</label>
	<input type="text" class="t_field" name="OMI_aggregate[]" id="OMI_aggregate<?PHP echo $OMI_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid nomier'); this.value=''; }" onChange="javascript: add_commas('OMI_aggregate',this.value,<?PHP echo $OMI_title; ?>);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Each Claim</label>
        <input type="text" class="t_field" name="OMI_each_claim[]" id="OMI_each_claim<?PHP echo $OMI_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid nomier'); this.value=''; }" onChange="javascript: add_commas('OMI_each_claim',this.value,<?PHP echo $OMI_title; ?>);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
		</div>
		</div>
		
		<div class="comm">
		<div class="in-pan">
          <label style="padding-top:5px;">MyVC listed as Cert Holder?</label>
		  <input type="radio" value="yes" name="omi_cert<?PHP echo $OMI_title-1; ?>" />&nbsp;YES &nbsp;<input type="radio" value="no" name="omi_cert<?PHP echo $OMI_title-1; ?>" />&nbsp;No
         
        </div>
		</div>
		
		
      <div class="comm">
	  <div class="in-pan">
        <label style="padding-top:5px;">Last Verified By MyVendorCenter On:</label>
      <input name="OMI_date_verified[]" id="OMI_date_verified<?PHP echo $OMI_title; ?>" type="text"  size="20" value=""/><script type="text/javascript">G('#OMI_date_verified<?PHP echo $OMI_title; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script>
		</div>
      </div>
    </div>
    <div class="clear"></div>

<input type="hidden" name="old_line_task_OMI_ids[]" id="old_line_task_OMI_ids_<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="OMI_status[]" value="1" />
 <input type="hidden" name="dOMI<?PHP echo $compliance; ?>" id="dOMI<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="current_line_task_OMI_ids[]" id="current_line_task_OMI_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
<input type="hidden" value="yes" name="OMI_editready" id="OMI_idedit<?PHP echo $compliance; ?>" />
  </div>
  
</div><?php exit; ?>
