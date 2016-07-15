<?PHP
$compliance = $_REQUEST['compliance'];
$AIP_title = $_REQUEST['AIP_title'];
$vendoridmain = $_REQUEST['vendoridmain'];

if($AIP_title != '')
$delid = $AIP_title;
else
$delid = $compliance;
?>
<div id="line_task_AIP<?PHP echo $AIP_title; ?>">
<div class="lic-pan">
    <h2><!--<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/empty-icon.gif" alt="" />-->COMMERCIAL VEHICLE POLICY - <?php echo $AIP_title; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayaip<?PHP echo $AIP_title; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $AIP_title; ?>"  id="uploadaip<?PHP echo $AIP_title; ?>">
	  <a href="javascript:doc_upload('<?PHP echo $AIP_title; ?>','aip','');" id="adminupload_compliance"></a>
	  </span> 
	  <span class="remove<?PHP echo $AIP_title; ?>"  style="width:160px; left:-6px;"><a href="javascript:doc_upload_second('<?PHP echo $AIP_title; ?>','aip','','second');" id="removeaip<?PHP echo $AIP_title; ?>" class="upload_compliance" >
       </a>
	   </span>
              <input type="hidden" name="daip<?PHP echo  $AIP_title; ?>" id="daip<?PHP echo  $AIP_title; ?>"  value="" /><!--<img src="components/com_camassistant/assets/images/upload-document.jpg" alt="" />
   <input type="file" class="file_input_hidden"  name="wc_upld_cert[]" onchange="ajaxFileUpload('wc','');"/>--></div></div>
   
   <div class="reeditbuttons" >
<div class="GLI3">
<a href="javascript: Alt_saveassubmit('AIP<?PHP echo $AIP_title; ?>');" class="adminsave_complaince" style="margin-top:-2px;"></a>
<a href="javascript:cenceleditdocs();" class="admincancel_complaince" style="margin-left:8px"></a>
</div>
</div>

   <input type="hidden" class="file_input_textbox" name="aip_upld_cert[]" id="aip_upld_cert<?PHP echo $AIP_title; ?>"  value="" /></div>
   
    <div class="lic-pan-right">
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
		
		$query_id = "SELECT email from #__users where id=".$vendoridmain."" ;
		$db->setQuery($query_id);
        $useremail = $db->loadResult();
		
		
		$query = "SELECT V.userid, U.comp_name from #__vendor_inviteinfo as V, #__cam_customer_companyinfo  as U, #__users as W, #__state as X where W.id=V.userid and V.userid =U.cust_id and U.comp_state=X.id and V.vendortype !='exclude' 
		and V.inhousevendors ='".$useremail."' group by U.comp_name having count(*)>=1";
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
	  
      <div class="comm">
	  <div class="in-pan">
        <label>Last Verified By MyVendorCenter On:</label>
       <input name="aip_date_verified[]" id="AIP_date_verified<?PHP echo $AIP_title; ?>" type="text"  size="20" value=""/><script type="text/javascript">G('#AIP_date_verified<?PHP echo $AIP_title; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script>
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
<?php /* ?>
<div id="line_task_WCI<?PHP echo $WCI_title; ?>">
<div class="lineitem_pan_row" style="padding-top: 25px;">
<!--<p style=" padding-top:5px;"></p> -->
<div class="tab_title">Workers Compensation Insurance Info <span style="font-weight: bold;" id="WCI_<?PHP echo $WCI_title; ?>"><?PHP echo $WCI_title; ?></span> :</div>
<div class="date_verifid">
<table border="0"><tr><td>
  <img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/date_verified.gif" alt="dateverified" width="87" height="22" align="left" /></td>
  <td><strong></strong> </td>
  <td><input name="WCI_date_verified[]" id="WCI_date_verified<?PHP echo $compliance; ?>" type="text" style=" width:70px;" value=""/></td></tr></table>
</div>
<input type="hidden" name="old_line_task_WCI_ids[]" id="old_line_task_WCI_ids_<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="current_line_task_WCI_ids[]" id="current_line_task_WCI_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
<div class="clear"></div>
<div class="lineitem_pan">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="18%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="43%"><label><strong>Workers Compensation Insurance Carrier <span id="WCI_no<?PHP echo $WCI_title; ?>"><?PHP echo $WCI_title; ?></span> :</strong> </label>
          <br />
          <input name="WCI_name[]" id="WCI_name<?PHP echo $compliance; ?>" type="text" class="t_field" style="width:250px;" value=""/></td>
        <td width="18%"><label><strong>Policy Number : </strong></label>
          <br />
          <input name="WCI_policy[]" id="WCI_policy<?PHP echo $compliance; ?>" type="text" class="t_field" style="width:100px;" value=""/>
          <br />
          <table width="96%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="top" width="72"></td>
            </tr>
          </table></td>
        <td width="39%"><label><strong>Coverage Dates (Start & End Dates) :</strong></label>
          <br />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="44%">
    <input name="WCI_start_date[]" id="WCI_start_date<?PHP echo $compliance; ?>" type="text" class="t_field" style="width:70px;" value=""/><script type="text/javascript">G('#WCI_start_date<?PHP echo $compliance; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script></td>
    <td width="9%" align="center" valign="middle">to</td>
    <td width="47%">
    <input name="WCI_end_date[]" id="WCI_end_date<?PHP echo $compliance; ?>" type="text" class="t_field" style="width:70px;" value=""/><script type="text/javascript">G('#WCI_end_date<?PHP echo $compliance; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script></td>
  </tr>
</table></td>
      </tr>
    </table></td>
  </tr>
  </table>
  <p style=" padding-top:10px;"></p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="23%">
  <label><strong>Agent Name :</strong></label>
  <br />
  <input name="WCI_agent_first_name[]" id="WCI_agent_first_name<?PHP echo $compliance; ?>" type="text" class="t_field" style="width:123px;" value=""/></td>
    <td width="22%">
      <label>&nbsp; </label><br />
      <input name="WCI_agent_last_name[]" id="WCI_agent_last_name<?PHP echo $compliance; ?>" type="text" class="t_field" style="width:120px;" value=""/></td>
    <td width="43%" valign="top">
     <label><strong>Agent Phone Number :</strong></label><br />
<input type="text" name="WCI_phone1[]" id="WCI_phone1<?PHP echo $compliance; ?>" class="t_field" style="width:23px;" maxlength="3" value=""/> -
<input type="text" name="WCI_phone2[]" id="WCI_phone2<?PHP echo $compliance; ?>" class="t_field" style="width:23px;" maxlength="3" value=""/> -
<input type="text" name="WCI_phone3[]" id="WCI_phone3<?PHP echo $compliance; ?>" class="t_field" style="width:30px;" maxlength="4" value="" />
  </td>
    <td width="12%"><br /></td>
  </tr>
  <tr><td colspan="4"><input type="checkbox" name="excemption[]" value="1">- Certificate of Exemption </td></tr>
  <table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="113"><div class="file_input_div"><input type="button" class="file_input_button"><input type="file" class="file_input_hidden"  name="WCI_upld_cert[]" onChange="javascript: document.getElementById('WCI_upld_cert<?PHP echo $compliance; ?>').value = this.value.replace('C:\\fakepath\\', '')" /></div></td>
	<td width="87"><input type="text" readonly="readonly" class="file_input_textbox" id="WCI_upld_cert<?PHP echo $compliance; ?>" /></td>
    <td width="74"><!--<a href="#"><img src="images/viewfile.gif" width="71" height="22" alt="View File" /></a> --></td>
    <td width="126" height="40"><!--<a href="#"><img src="images/deletefile.gif" width="71" height="22" alt="Delete file" /></a> --></td>
  </tr>
</table>
  </table>
  <span id="WCI_delete_<?PHP echo $WCI_title; ?>" ><a href="javascript:del_callajaxcomp_WCI('workers_companies_insurance','','<?PHP echo $delid; ?>');"><img src="templates/camassistant_left/images/remove_file.gif" alt="Delete Workers Compensation" width="66" height="22" /></a></span>
  <!--<a href="#"><img src="images/add-another-workers-comp-document.gif" alt="add another workers comp. document" width="195" height="22" /></a> -->
</div>
</div>
</div>
 * <?php
 */ ?>