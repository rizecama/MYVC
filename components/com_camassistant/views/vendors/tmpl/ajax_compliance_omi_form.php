<?PHP
$compliance = $_REQUEST['compliance'];
$OMI_title = $_REQUEST['OMI_title'];
if($OMI_title != '')
$delid = $OMI_title;
else
$delid = $compliance;
?>
<div id="line_task_OMI<?PHP echo $OMI_title; ?>">
<div class="lic-pan">
    <h2>ERRORS & OMISSIONS INSURANCE - <?PHP echo $OMI_title; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayOMI<?PHP echo $OMI_title; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $OMI_title; ?>"  id="uploadnewOMI<?PHP echo $OMI_title; ?>"><a href="javascript:doc_upload('<?PHP echo $OMI_title; ?>','OMI','');" id="upload_compliance"></a></span>  
	  <span class="remove<?PHP echo $OMI_title; ?>" ><a href="javascript:doc_upload_second('<?PHP echo $OMI_title; ?>','OMI','','second');" id="update_compliance" id="removeOMI<?PHP echo $OMI_title; ?>" style="display:none;"></a></span>
              <input type="hidden" name="dOMI<?PHP echo  $OMI_title; ?>" id="dOMI<?PHP echo  $OMI_title; ?>"  value="" /></div>
   <input type="hidden" class="file_input_textbox" name="OMI_upld_cert[]" id="OMI_upld_cert<?PHP echo $OMI_title; ?>"  value="" />

<div class="reeditbuttons" id="savedocs_vendor">
<div class="OMI<?PHP echo $OMI_title; ?>">
<a href="javascript: Alt_saveassubmit('OMI<?PHP echo $OMI_title; ?>');" class="save_complaince"></a>
<a href="javascript:cenceleditdocs();" class="cancel_compliance"></a><br />
</div>
</div>
   </div>
   </div>
    <div class="lic-pan-rightnew">
      <div class="comm">
	   <div class="in-pan">
        <label>Exp. Date:</label>
        <input type="text" size="20" name="OMI_end_date[]" id="OMI_end_date<?PHP echo $OMI_title; ?>" placeholder = "mm-dd-yyyy" value="" /><script type="text/javascript">G('#OMI_end_date<?PHP echo $OMI_title; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,minDate: "0y",maxDate: "+5y",changeMonth:true});</script>
		</div>
		<div class="in-pan1">
	<label>Each Claim:</label>
	<input type="text" class="t_field" name="OMI_each_claim[]" id="OMI_each_claim<?PHP echo $OMI_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('OMI_disease_policy',this.value,<?PHP echo $OMI_title; ?>);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
	</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Aggregate:</label>
    <input type="text" class="t_field" name="OMI_aggregate[]" id="OMI_aggregate1" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('OMI_each_accident',this.value,1);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
	</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        
	</div>
	
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>MyVC listed as Cert Holder?</label>
		  <input type="radio" <?php echo $omi_classf; ?> value="yes" name="OMI_cert<?PHP echo $OMI_title-1; ?>" />&nbsp;YES &nbsp;<input type="radio" <?php echo $omi_classs; ?> value="no" name="OMI_cert<?PHP echo $OMI_title-1; ?>" />&nbsp;No
        </div>
        <div class="clear"></div>
      </div>
	  
	  
      
    </div>
	
	

    <div class="clear"></div>

<input type="hidden" name="old_line_task_OMI_ids[]" id="old_line_task_OMI_ids_<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="OMI_status[]" value="1" />
  <input type="hidden" name="dOMI<?PHP echo $compliance; ?>" id="dOMI<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="current_line_task_OMI_ids[]" id="current_line_task_OMI_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
 <input type="hidden" value="yes" name="OMI_editready" id="OMI_idedit<?PHP echo $compliance; ?>" />
</div>  </div>
<?php exit; ?>
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