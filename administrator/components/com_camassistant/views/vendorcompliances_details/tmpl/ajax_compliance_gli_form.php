<?PHP
$compliance = $_REQUEST['compliance'];
$GLI_title = $_REQUEST['GLI_title'];
$vendoridmain = $_REQUEST['vendoridmain'];

if($GLI_title != '')
$delid = $GLI_title;
else
$delid = $compliance;
?>
<div id="line_task_GLI<?PHP echo $GLI_title; ?>">

<div class="lic-pan">
    <h2><!--<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/empty-icon.gif" alt="" />-->GENERAL LIABILITY POLICy - <?PHP echo $GLI_title; ?></h2>
    <div class="clear"></div>
<script type='text/javascript'>

function add_commas(field,x,id)

{

//var charCode = (evt.which) ? evt.which : event.keyCode

var val = parseFloat(x).toFixed(2)+'',

      rgx = /(\d+)(\d{3}[\d,]*\.\d{2})/;

  while (rgx.test(val)) {

    val = val.replace(rgx, '$1' + ',' + '$2');

  }

  if(val != "NaN")
 document.getElementById(field+id).value = val;

}

</script>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayGLI<?PHP echo $GLI_title; ?>">
	  <span id="nofileuploaded">NO FILE UPLOADED</span>
	  </div>

      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $GLI_title; ?>"  id="uploadGLI<?PHP echo $GLI_title; ?>" style="width:160px; left:-6px;"><a href="javascript:doc_upload('<?PHP echo $GLI_title; ?>','GLI','');" id="adminupload_compliance" ></a></span>  
	  <span class="remove<?PHP echo $GLI_title; ?>"  style="width:160px; left:-6px;">
	  <a href="javascript:doc_upload_second('<?PHP echo $GLI_title; ?>','GLI','','second');" class="update_compliance" id="removeGLI<?PHP echo $GLI_title; ?>"></a></span>
              <input type="hidden" name="dGLI<?PHP echo  $GLI_title; ?>" id="dGLI<?PHP echo  $GLI_title; ?>"  value="" />
  <!-- <input type="file" class="file_input_hidden"  name="OLN_upld_cert[]" onchange="ajaxFileUpload('OLN','');" />--></div></div>
  <div class="reeditbuttons">
<div class="GLI3">
<a href="javascript: Alt_saveassubmit('GLI<?PHP echo $GLI_title; ?>');" class="adminsave_complaince"  style="margin-left:8px;"></a>
<a href="javascript:cenceleditdocs();" class="admincancel_compliance_w9" style="margin-left:8px; margin-top:5px;"></a><br />
</div>
</div>

  <input type="hidden" class="file_input_textbox" name="GLI_upld_cert[]" id="GLI_upld_cert<?PHP echo $GLI_title; ?>"  value="" />
 </div>
 
    <div class="lic-pan-right">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
    <input name="GLI_end_date[]" id="GLI_end_date<?PHP echo $GLI_title; ?>" type="text" class="t_field" size="10" value=""/><span style="color:red; font-size: 20px;">*</span><script type="text/javascript">G('#GLI_end_date<?PHP echo $GLI_title; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+5y"});</script>
	</div>
	<div class="in-pan1">
          <label>Med. Expenses:</label>
         <input type="text" class="t_field" name="GLI_med[]" id="GLI_med<?PHP echo $GLI_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('GLI_med',this.value,<?PHP echo $GLI_title; ?>);"  size="16"  style="color:green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
      </div>
	  
      <div class="comm">
        <div class="in-pan">
         <label style="color:green;"> Each Occurrence:</label>
        <span id="GLI_occurence_<?PHP echo $GLI_title; ?>" ><input type="text" name="GLI_policy_occurence[]" id="GLI_policy_occurence<?PHP echo $GLI_title; ?>" class="t_field"  size="16" style="color:green; text-align: left;" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('GLI_policy_occurence',this.value,<?PHP echo $GLI_title; ?>);" value=""/><span style="color:red; font-size: 20px;">*</span></span>
        </div>
        <div class="in-pan1">
          <label>Personal & Adv Injury:</label>
         <input type="text" class="t_field" name="GLI_injury[]" id="GLI_injury<?PHP echo $GLI_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('GLI_injury',this.value,<?PHP echo $GLI_title; ?>);"  size="16"  style="color:green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
        <div class="clear"></div>
      </div>
	  <div class="comm">
        <div class="in-pan">
           <label style="color:green;">General Aggregate:</label>
       <span id="GLI_aggregate_<?PHP echo $GLI_title; ?>" ><input type="text" name="GLI_policy_aggregate[]" id="GLI_policy_aggregate<?PHP echo $GLI_title; ?>" class="t_field" size="20"  style="color: green; text-align: left;" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('GLI_policy_aggregate',this.value,<?PHP echo $GLI_title; ?>);" value=""/><span style="color:red; font-size: 20px;">*</span></span>
		 <p style="height:10px"></p>
		 <strong>Applies To:</strong>&nbsp;<input type="radio" name="GLI_applies<?PHP echo $GLI_title-1; ?>" value="pol" class="attrInputs" id="attrInputs<?PHP echo $GLI_title; ?>" />&nbsp;Pol&nbsp;<input type="radio" name="GLI_applies<?PHP echo $GLI_title-1; ?>" value="proj" class="attrInputs" id="attrInputs<?PHP echo $GLI_title; ?>" />&nbsp;Proj&nbsp;<input type="radio" name="GLI_applies<?PHP echo $GLI_title-1; ?>" value="loc" class="attrInputs" id="attrInputs<?PHP echo $GLI_title; ?>" />&nbsp;Loc<span style="color:red; font-size: 20px;">*</span>
        </div>
        <div class="in-pan1">
          <label>Products - COMP/OP Agg:</label>
         <input type="text" class="t_field" name="GLI_products[]" id="GLI_products<?PHP echo $GLI_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('GLI_products',this.value,<?PHP echo $GLI_title; ?>);"  size="16"  style="color:green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
        <div class="clear"></div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>Damage to Rented Premises:</label>
         <input type="text" class="t_field" name="GLI_damage[]" id="GLI_damage<?PHP echo $GLI_title; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('GLI_damage',this.value,<?PHP echo $GLI_title; ?>);" size="20"  style="color: green; text-align: left;" value="" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
        <div class="in-pan1" style="margin-top:-28px;">
          <label></label>
         <input type="checkbox" value="primary" name="GLI_primary<?PHP echo $GLI_title-1; ?>" id="GLI_primary<?PHP echo $GLI_title; ?>" style="margin:0px;" /> &nbsp;Primary Non-Contributory <br />
		 <input type="checkbox" value="waiver" name="GLI_waiver<?PHP echo $GLI_title-1; ?>" id="GLI_waiver<?PHP echo $GLI_title; ?>" style="margin:0px;" /> &nbsp;Waiver of Subrogation <br />
		 <input type="checkbox" value="occur" name="GLI_occur<?PHP echo $GLI_title-1; ?>" id="GLI_occur<?PHP echo $GLI_title; ?>" style="margin:0px;" /> &nbsp;Occur <br />
        </div>
        <div class="clear"></div>
      </div>
	  
	  <div class="comm" style="margin-top:2px;">
        <div class="in-pan">
		
          <label>MyVC listed as Cert Holder?</label>
		  <table cellpadding="0" cellspacing="0"><tr><td><input type="radio" value="yes" name="GLI_certholder<?PHP echo $GLI_title-1; ?>" style="margin-left:1px;" /></td><td>&nbsp;YES &nbsp;</td>
		  <td><input type="radio" value="no"  name="GLI_certholder<?PHP echo $GLI_title-1; ?>" style="margin-left:1px;" /></td><td>&nbsp;No</td></tr></table>
		  <p style="height:4px;"></p>
         <label>Additional Insured:</label>
		  <?php
		  $db =& JFactory::getDBO();

		$query_id = "SELECT email from #__users where id=".$vendoridmain."" ;
		$db->setQuery($query_id);
        $useremail = $db->loadResult();
		
		
		$query = "SELECT V.userid, U.comp_name from #__vendor_inviteinfo as V, #__cam_customer_companyinfo  as U, #__users as W, #__state as X where W.id=V.userid and V.userid =U.cust_id and U.comp_state=X.id and V.vendortype !='exclude' 
		and V.inhousevendors ='".$useremail."' group by U.comp_name having count(*)>=1";
		$db->setQuery($query);
        $camfirmslist = $db->loadObjectList();
		  ?>
         <select name="GLI_additional<?PHP echo $GLI_title-1; ?>">
		  <option value="0">Select</option>
		  <?php
		  for($c=0; $c<count($camfirmslist); $c++){   ?>
		  <option value="<?php echo $camfirmslist[$c]->userid; ?>"><?php echo $camfirmslist[$c]->comp_name; ?></option>
		  <?php } ?>
		 </select>
		 
        </div>
        <div class="clear"></div>
      </div>
	  
      <div class="comm">
	  <div class="in-pan">
        <label>Last Verified By MyVendorCenter On:</label>
    <input name="GLI_date_verified[]" id="GLI_date_verified<?PHP echo $GLI_title; ?>" type="text"  size="20" value=""/><script type="text/javascript">G('#GLI_date_verified<?PHP echo $GLI_title; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script>
      </div></div>
    </div>
    <div class="clear"></div>
  
<input type="hidden" name="old_line_task_GLI_ids[]" id="old_line_task_GLI_ids_<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="GLI_status[]" value="1" />
<input type="hidden" name="dGLI<?PHP echo $compliance; ?>" id="dGLI<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="current_line_task_GLI_ids[]" id="current_line_task_GLI_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
 <input type="hidden" value="yes" name="GLI_editready" id="GLI_idedit<?PHP echo $compliance; ?>" />
 </div></div>
 <?PHP exit; ?>
