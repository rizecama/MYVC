<?PHP
//$compliance = $_REQUEST['compliance'];
//$PLN_title = $_REQUEST['PLN_title'];
$compliance = $_REQUEST['compliance'];
$PLN_title = $_REQUEST['PLN_title'];
if($PLN_title != '')
$delid = $PLN_title;
else
$delid = $compliance;
$liscense_categories = $this->liscense_categories;
$liscense_sub_categories = $this->liscense_sub_categories;
?>

<div id="line_task_PLN<?PHP echo $PLN_title; ?>" style="padding-top:10px">

    <div class="lic-pan">
    <h2>PROFESSIONAL LICENSE - <?PHP echo $PLN_title; ?></h2>
   <div class="clear"></div>

    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayPLN<?PHP echo $PLN_title; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $PLN_title; ?>"  id="uploadnewPLN<?PHP echo $PLN_title; ?>" ><a href="javascript:doc_upload('<?PHP echo $PLN_title; ?>','PLN','');" id="upload_compliance"></a></span> <span class="remove<?PHP echo $PLN_title; ?>"><a href="javascript:doc_upload_second('<?PHP echo $PLN_title; ?>','PLN','','second');" id="update_compliance" id="removePLN<?PHP echo $PLN_title; ?>" style="display:none;">
       </a></span>
              <input type="hidden" name="dPLN<?PHP echo  $PLN_title; ?>" id="dPLN<?PHP echo  $PLN_title; ?>"  value="" />
</div><input type="hidden" class="file_input_textbox" name="PLN_upld_cert[]" id="PLN_upld_cert<?PHP echo $PLN_title; ?>"  value="" /> 
   <div class="reeditbuttons" id="savedocs_vendor">
<div class="PLN<?PHP echo $PLN_title; ?>">
<a href="javascript: Alt_saveassubmit('PLN<?PHP echo $PLN_title; ?>');" class="save_complaince"></a>
<a href="javascript:cenceleditdocs();" class="cancel_compliance"></a><br />

</div>
</div>
</div>
   
   </div>
    <div class="lic-pan-rightnew">
      <div class="comm">
        <label>Expiration Date:</label>
       <input name="PLN_expdate[]" id="PLN_expdate<?PHP echo $PLN_title; ?>" type="text" class="t_field" placeholder = "mm-dd-yyyy" value="" /><span style="color:red; font-size: 20px;">*</span><script type="text/javascript">G('#PLN_expdate<?PHP echo $PLN_title; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,minDate: "0y",maxDate: "+5y"});</script>
      </div>
      <div class="comm">
        <div class="in-pan">
          <label style="padding-top:5px;">Jurisdiction (state/country/city/association):</label>
           <input name="PLN_state[]" id="PLN_state<?PHP echo $PLN_title; ?>" class="t_field" size="25" value="">
        </div>
        <div class="in-pan1">
          <label>License Type:</label>
        <input name="PLN_type[]" id="PLN_type<?PHP echo $PLN_title; ?>" class="t_field" size="15" value="">
        </div>
        <div class="clear"></div>
      </div>
      
    </div>
    <div class="clear"></div>


 <input type="hidden" name="old_line_task_PLN_ids[]" id="old_line_task_PLN_ids_<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="PLN_status[]" value="1" />
 <input type="hidden" name="dPLN<?PHP echo $compliance; ?>" id="dPLN<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="current_line_task_PLN_ids[]" id="current_line_task_PLN_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />  </div>
 <input type="hidden" value="yes" name="PLN_editready" id="PLN_idedit<?PHP echo $compliance; ?>" />
</div><?php exit; ?>
  <?php /* ?>
    <div class="lineitem_pan_row"><div class="tab_title">My Professional License Info <span style="font-weight: bold;" id="PLN_<?PHP echo $PLN_title; ?>"><?PHP echo $PLN_title; ?></span> :(For jobs that require a professional license):</div>
<div class="date_verifid">
<table border="0"><tr><td>
<img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/date_verified.gif" alt="dateverified" width="87" height="22" align="left" /></td>
<td><strong></strong></td>
<td> <input name="PLN_date_verified[]" id="PLN_date_verified<?PHP echo $PLN_title; ?>" type="text" style=" width:70px;" value=""/></td></tr></table>
 </div></p>
 <input type="hidden" name="old_line_task_PLN_ids[]" id="old_line_task_PLN_ids_<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="current_line_task_PLN_ids[]" id="current_line_task_PLN_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
 <div class="clear"></div><div class="lineitem_pan"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="43%"><label><strong>Professional License Number <span id="PLN_no<?PHP echo $PLN_title; ?>"><?PHP echo $PLN_title; ?></span> : </strong></label><br/><input name="PLN_license[]" id="PLN_license<?PHP echo $PLN_title; ?>" type="text" class="t_field" style="width:240px;" value=""/></td><td width="29%"><label><strong>License Category :</strong></label><br /><table width="96%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="top" width="72">
<select name="PLN_category[]" id="PLN_category<?PHP echo $PLN_title; ?>" class="other_tfield" style=" width:170px;" onChange="javascript:get_subcat(this.value,<?PHP echo $PLN_title; ?>);">
	   <option value="0">Select License Category</option>
	  <?PHP for($p=0; $p<count($liscense_categories); $p++) { ?>
        <option value="<?PHP echo $liscense_categories[$p]->id;?>" ><?PHP echo $liscense_categories[$p]->category_name;?></option>
		<?PHP } ?>
      </select></td><td width="53">&nbsp;</td></tr></table></td><td width="28%"><label><strong> License Type :</strong></label><br />
<div id="PLN_sub_cat<?PHP echo $PLN_title; ?>">
      <select name="PLN_type[]" class="other_tfield" id="PLN_type<?PHP echo $PLN_title; ?>" style=" width:170px;">
        <option>Select License Type</option>
      </select></div>
<?php /*?>onChange="javascript: PLN_modify_date(this.value,<?PHP echo $PLN_title; ?>);"
</td></tr></table><p style=" padding-top:10px;"></p><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="23%"><label><strong>Expiration Date : </strong> </label><br /><input name="PLN_expdate[]" id="PLN_expdate<?PHP echo $PLN_title; ?>" type="text" class="t_field" style="width:80px;" value="" /><script type="text/javascript">G('#PLN_expdate<?PHP echo $PLN_title; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script></td><td width="22%"><label><strong>State : </strong></label><br /><?php echo $this->states; ?></td><td width="43%"></td><td width="12%"><br /></td></tr><tr><td colspan="3"><table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td width="213" class="file_input_div"><div class="file_input_div"><input type="button" class="file_input_button"><input type="file" class="file_input_hidden"  name="PLN_upld_cert[]" onChange="javascript: document.getElementById('PLN_upld_cert<?PHP echo $PLN_title; ?>').value = this.value.
replace('C:\\fakepath\\', '')" /></div></td><td width="87"><input type="text" readonly="readonly" class="file_input_textbox" id="PLN_upld_cert<?PHP echo $PLN_title; ?>"  ></td><td width="74"><?php /*?><a href="#"><img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/viewfile.gif" width="71" height="22" alt="View File" /></a><?php * </td><td width="126" height="40"><?php /*?><a href="#"><img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/deletefile.gif" width="71" height="22" alt="Delete file" /></a><?php *</td></tr></table></td><td>&nbsp;</td></tr></table><a href="javascript:callajaxcomp_PLN('<?PHP echo $compliance; ?>');"><img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/addprofessional_license.gif" alt="Add another Professional License" width="195" height="22" /></a><?php *<span id="PLN_delete_<?PHP echo $PLN_title; ?>"><a href="javascript:del_callajaxcomp_PLN('professional_license','','<?PHP echo $delid; ?>');"><img src="templates/camassistant_
left/images/remove_file.gif" alt="Delete Professional License" width="66" height="22" /></a></span></div></div></div>

<?php */?>