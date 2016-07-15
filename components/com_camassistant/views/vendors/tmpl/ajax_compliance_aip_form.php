<?PHP
$compliance = $_REQUEST['compliance'];
$AIP_title = $_REQUEST['AIP_title'];
if($AIP_title != '')
$delid = $AIP_title;
else
$delid = $compliance;
?>
<div id="line_task_AIP<?PHP echo $AIP_title; ?>">
<div class="lic-pan">
    <h2>COMMERCIAL VEHICLE POLICY - <?php echo $AIP_title; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayaip<?PHP echo $AIP_title; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $AIP_title; ?>"  id="uploadnewaip<?PHP echo $AIP_title; ?>"><a href="javascript:doc_upload('<?PHP echo $AIP_title; ?>','aip','');" id="upload_compliance"></a></span> <span class="remove<?PHP echo $AIP_title; ?>">
	  <a href="javascript:doc_upload_second('<?PHP echo $AIP_title; ?>','aip','','second');" id="removeaip<?PHP echo $AIP_title; ?>" class="upload_compliance" >
       </a></span>
<input type="hidden" name="daip<?PHP echo  $AIP_title; ?>" id="daip<?PHP echo  $AIP_title; ?>"  value="" />
</div>
<input type="hidden" class="file_input_textbox" name="aip_upld_cert[]" id="aip_upld_cert<?PHP echo $AIP_title; ?>"  value="" />
<div class="reeditbuttons" id="savedocs_vendor">
<div class="GLI3">
<a href="javascript: Alt_saveassubmit('AIP<?PHP echo $AIP_title; ?>');" class="save_complaince"></a>
<a href="javascript:cenceleditdocs();" class="cancel_compliance"></a>

</div>
</div>
</div>
   
   </div>
    <div class="lic-pan-rightnew">
	  <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
        <input type="text" size="10" name="aip_end_date[]" id="aip_end_date<?PHP echo $AIP_title; ?>" placeholder = "mm-dd-yyyy" value="" /><span style="color:red; font-size: 20px;">*</span><script type="text/javascript">G('#aip_end_date<?PHP echo $AIP_title; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,minDate: "0y",maxDate: "+5y",changeMonth:true});</script>
      </div>
	  <div class="in-pan1">
		 <label>Bodily Injury - Per Person:</label>
		 <input type="text" class="t_field" name="aip_bodily[]" id="aip_bodily<?PHP echo $AIP_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('aip_bodily',this.value,<?PHP echo $AIP_title; ?>);"  size="16"  style="color:green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
		 </div>
		 </div>
		 
		 <div class="comm">
	   <div class="in-pan">
        <label>Combined Single Limit:</label>
        <input type="text" class="t_field" name="aip_combined[]" id="aip_combined<?PHP echo $AIP_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('aip_combined',this.value,<?PHP echo $AIP_title; ?>);"  size="16"  style="color:green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/><span style="color:red; font-size: 20px;"></span>
		</div>
		 <div class="in-pan1">
		 <label>Bodily Injury - Per Accident:</label>
		 <input type="text" class="t_field" name="aip_body_injury[]" id="aip_body_injury<?PHP echo $AIP_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('aip_body_injury',this.value,<?PHP echo $AIP_title; ?>);"  size="16"  style="color:green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
		 </div>
      </div>
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Property Damage - Per Accident:</label>
        <input type="text" class="t_field" name="aip_property[]" id="aip_property<?PHP echo $AIP_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('aip_property',this.value,<?PHP echo $AIP_title; ?>);"  size="16"  style="color:green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
		</div>
		 <div class="in-pan1">
		 <table cellpadding="0" cellspacing="0"><tr><td>
		 <input type="checkbox" value="primary" name="aip_primary<?PHP echo $AIP_title-1; ?>" style="margin-left:0px;" /></td><td>&nbsp;Primary Non-Contributory&nbsp;&nbsp;</td></tr>
		 <tr><td><input type="checkbox" value="waiver" name="aip_waiver<?PHP echo $AIP_title-1; ?>" style="margin-left:0px;" /></td><td>&nbsp;Waiver of Subrogation&nbsp;&nbsp;</td></tr></table>
		 </div>
      </div>
	  
	  <div class="comm" style="width:386px;">
	  <div class="in-pan" style="width:386px;">
          <label style="padding-top:5px;">MyVC listed as Cert Holder?</label>
		  <input type="radio" value="yes" name="aip_cert<?PHP echo $AIP_title-1; ?>" style="margin-left:0px;" />&nbsp;YES &nbsp;<input type="radio" value="no" name="aip_cert<?PHP echo $AIP_title-1; ?>" style="margin-left:0px;" />&nbsp;No
        
		 <label style="padding-top:5px;">Additional Insured:</label>
		  <?php
		  $db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$query = "SELECT V.userid, U.comp_name from #__vendor_inviteinfo as V, #__cam_customer_companyinfo  as U, #__users as W, #__state as X where W.id=V.userid and V.userid =U.cust_id and U.comp_state=X.id and V.vendortype !='exclude' 
		and V.inhousevendors ='".$user->email."' group by U.comp_name having count(*)>=1";
		$db->setQuery($query);
        $camfirmslist = $db->loadObjectList();
		  ?>
		   <select name="aip_addition<?PHP echo $AIP_title-1; ?>">
		  <option value="0">Select</option>
		  <?php
		  for($c=0; $c<count($camfirmslist); $c++){
		   ?>
		  <option value="<?php echo $camfirmslist[$c]->userid; ?>"><?php echo $camfirmslist[$c]->comp_name; ?></option>
		  <?php  }
		  ?>
		 </select>
		 <p style="height:11px;"></p>
		 <label>Applies to:</label>
        <p style="float:right; margin-top:-20px;">
		<table cellpadding="0" cellspacing="0"><tr><td><input type="checkbox" value="any"   name="aip_applies_any<?PHP echo $AIP_title-1; ?>"  style="margin-left:0px;"></td><td>Any&nbsp;</td>
		<td><input type="checkbox" value="owned" name="aip_applies_owned<?PHP echo $AIP_title-1; ?>" style="margin-left:0px;"></td><td>Owned&nbsp;</td>
		<td><input type="checkbox" value="nonowned" name="aip_applies_nonowned<?PHP echo $AIP_title-1; ?>" style="margin-left:0px;"></td><td>Non-Owned&nbsp;</td>
		<td><input type="checkbox" value="hired" name="aip_applies_hired<?PHP echo $AIP_title-1; ?>" style="margin-left:0px;"></td><td>Hired&nbsp;</td>
		<td><input type="checkbox" value="sch" name="aip_applies_scheduled<?PHP echo $AIP_title-1; ?>" style="margin-left:0px;"></td><td>Scheduled&nbsp;</td></tr></table></p>
        </div>
	  </div>
	  
      
    </div>
	
    <div class="clear"></div>
 
<input type="hidden" name="old_line_task_aip_ids[]" id="old_line_task_aip_ids_<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="aip_status[]" value="1" />
 <input type="hidden" name="daip<?PHP echo $compliance; ?>" id="daip<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="current_line_task_aip_ids[]" id="current_line_task_aip_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
<input type="hidden" value="yes" name="aip_editready" id="aip_idedit<?PHP echo $compliance; ?>" />
</div>
</div><?php exit; ?>
