<?PHP
$compliance = $_REQUEST['compliance'];
$WCI_title = $_REQUEST['WCI_title'];
if($WCI_title != '')
$delid = $WCI_title;
else
$delid = $compliance;
?>
<div id="line_task_WCI<?PHP echo $WCI_title; ?>">
<div class="lic-pan">
    <h2><!--<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/empty-icon.gif" alt="" />-->WORKERS COMPENSATION / EMPLOYER'S LIABILITY POLICY - <?PHP echo $WCI_title; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayWCI<?PHP echo $WCI_title; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $WCI_title; ?>"  id="uploadWCI<?PHP echo $WCI_title; ?>"><a href="javascript:doc_upload('<?PHP echo $WCI_title; ?>','WCI','');" id="adminupload_compliance"></a>
	  </span>  
	  <span class="remove<?PHP echo $WCI_title; ?>"  style="width:160px; left:-6px;"><a href="javascript:doc_upload_second('<?PHP echo $WCI_title; ?>','WCI','','second');" id="update_compliance" id="removeWCI<?PHP echo $WCI_title; ?>" style="display:none;">
       </a></span>
              <input type="hidden" name="dWCI<?PHP echo  $WCI_title; ?>" id="dWCI<?PHP echo  $WCI_title; ?>"  value="" /><!--<img src="components/com_camassistant/assets/images/upload-document.jpg" alt="" />
   <input type="file" class="file_input_hidden"  name="WCI_upld_cert[]"  onchange="ajaxFileUpload('WCI','');"/>--></div></div>
   
   <div class="reeditbuttons">
<div class="GLI3" style="float: left;">
<a href="javascript: Alt_saveassubmit('WCI<?PHP echo $WCI_title; ?>');" class="adminsave_complaince" style="margin-top:-1px;"></a>
<a href="javascript:cenceleditdocs();" class="admincancel_complaince"></a><br />

</div>
</div>

   <input type="hidden" class="file_input_textbox" name="WCI_upld_cert[]" id="WCI_upld_cert<?PHP echo $WCI_title; ?>"   value="" /></div>
    <div class="lic-pan-right">
      <div class="comm">
	   <div class="in-pan">
        <label>Exp. Date:</label>
        <input type="text" size="20" name="WCI_end_date[]" id="WCI_end_date<?PHP echo $WCI_title; ?>" placeholder = "mm-dd-yyyy" value="" /><script type="text/javascript">G('#WCI_end_date<?PHP echo $WCI_title; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,minDate: "0y",maxDate: "+5y",changeMonth:true});</script>
		<script type="text/javascript">
	G('#WCI_end_date<?PHP echo $WCI_title; ?>').click(function(){
	var check = "<span class='othercheck'><input type='checkbox' value='does not expire' onclick='WCI_end_date<?PHP echo $WCI_title; ?>();'>This document does not expire</span>";
	G('.othercheck').empty();
	G('#ui-datepicker-div').show();
	G('#ui-datepicker-div').append(check);
	});
	function WCI_end_date<?PHP echo $WCI_title; ?>(){
		G('#WCI_end_date<?PHP echo $WCI_title; ?>').val('Does Not Expire');
		G('#ui-datepicker-div').hide();
	}
	</script>
		</div>
		<div class="in-pan1">
	<label>Disease - Policy Limit:</label>
	<input type="text" class="t_field" name="WCI_disease_policy[]" id="WCI_disease_policy<?PHP echo $WCI_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('WCI_disease_policy',this.value,<?PHP echo $WCI_title; ?>);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
	</div>
      </div>
	  <div class="comm">
	  <div class="in-pan">
        <label>Each Accident:</label>
    <input type="text" class="t_field" name="WCI_each_accident[]" id="WCI_each_accident1" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('WCI_each_accident',this.value,1);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
	</div>
	
	 <div class="in-pan1">
        <label>Disease - Each Employee:</label>
    <input type="text" class="t_field" name="WCI_disease[]" id="WCI_disease<?PHP echo $WCI_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('WCI_disease',this.value,<?PHP echo $WCI_title; ?>);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
	<p style="height:6px;"></p>
		 <input type="checkbox" value="waiver" name="WCI_waiver<?PHP echo $WCI_title-1; ?>" style="margin:0px;" /> &nbsp;Waiver of Subrogation <br />
	</div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan" style="margin-top:-20px;">
          <label>MyVC listed as Cert Holder?</label>
		  <input type="radio" <?php echo $wci_classf; ?> value="yes" name="WCI_cert<?PHP echo $WCI_title-1; ?>" />&nbsp;YES &nbsp;<input type="radio" <?php echo $wci_classs; ?> value="no" name="WCI_cert<?PHP echo $WCI_title-1; ?>" />&nbsp;No
        </div>
        <div class="clear"></div>
      </div>
	  
      <div class="comm">
	  <div class="in-pan">
        <label>Last Verified By MyVendorCenter On:</label>
       <input type="text" class="bak" size="10" name="WCI_date_verified[]" id="WCI_date_verified<?PHP echo $WC_title; ?>" value=""/><script type="text/javascript">G('#WCI_date_verified<?PHP echo $WC_title; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div></div>
    </div>
    <div class="clear"></div>

<input type="hidden" name="old_line_task_WCI_ids[]" id="old_line_task_WCI_ids_<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="WCI_status[]" value="1" />
  <input type="hidden" name="dWCI<?PHP echo $compliance; ?>" id="dWCI<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="current_line_task_WCI_ids[]" id="current_line_task_WCI_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
 <input type="hidden" value="yes" name="WCI_editready" id="WCI_idedit<?PHP echo $compliance; ?>" />
  </div></div>
<?PHP exit; ?>
