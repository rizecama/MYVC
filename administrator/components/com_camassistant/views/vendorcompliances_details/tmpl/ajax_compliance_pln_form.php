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
    <h2><!--<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/empty-icon.gif" alt="" />-->PROFESSIONAL LICENSE - <?PHP echo $PLN_title; ?></h2>
   <div class="clear"></div>

    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplayPLN<?PHP echo $PLN_title; ?>"><span id="adminnofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $PLN_title; ?>"  id="uploadPLN<?PHP echo $PLN_title; ?>" style="width:160px; left:-6px;"><a href="javascript:doc_upload('<?PHP echo $PLN_title; ?>','PLN','');" id="adminupload_compliance"></a></span> <span class="remove<?PHP echo $PLN_title; ?>" ><a href="javascript:doc_upload_second('<?PHP echo $PLN_title; ?>','PLN','','second');" id="update_compliance" id="removePLN<?PHP echo $PLN_title; ?>" style="display:none;">
       </a></span>
              <input type="hidden" name="dPLN<?PHP echo  $PLN_title; ?>" id="dPLN<?PHP echo  $PLN_title; ?>"  value="" /><!--<img src="components/com_camassistant/assets/images/upload-document.jpg" alt="" />
   <input type="file" class="file_input_hidden"  name="PLN_upld_cert[]" onchange="ajaxFileUpload('PLN','');"/>--></div>
   
   <div class="reeditbuttons">
<div class="GLI3" style="float: left;">
<a href="javascript: Alt_saveassubmit('PLN<?PHP echo $PLN_title; ?>');" class="adminsave_complaince"></a>
<a href="javascript:cenceleditdocs();" class="admincancel_complaince"></a><br />
</div>
</div>

   <input type="hidden" class="file_input_textbox" name="PLN_upld_cert[]" id="PLN_upld_cert<?PHP echo $PLN_title; ?>"  value="" /></div> 
   </div>
    <div class="lic-pan-right">
      <div class="comm">
        <label>Expiration Date:</label>
       <input name="PLN_expdate[]" id="PLN_expdate<?PHP echo $PLN_title; ?>" type="text" class="t_field" placeholder = "mm-dd-yyyy" value="" /><span style="color:red; font-size: 20px;">*</span><script type="text/javascript">G('#PLN_expdate<?PHP echo $PLN_title; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,minDate: "0y",maxDate: "+5y"});</script>
      </div>
      <div class="comm">
        <div class="in-pan">
          <label>Jurisdiction (state/country/city/association):</label>
           <input name="PLN_state[]" id="PLN_state<?PHP echo $PLN_title; ?>" class="t_field" size="25" value="">
        </div>
        <div class="in-pan1">
          <label>License Type:</label>
        <input name="PLN_type[]" id="PLN_type<?PHP echo $PLN_title; ?>" class="t_field" size="15" value="">
        </div>
        <div class="clear"></div>
      </div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
   <input name="PLN_date_verified[]" id="PLN_date_verified<?PHP echo $PLN_title; ?>" type="text" size="10"  value=""/><script type="text/javascript">G('#PLN_date_verified<?PHP echo $PLN_title; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true,maxDate: "+2y"});</script>
      </div>
    </div>
    <div class="clear"></div>


 <input type="hidden" name="old_line_task_PLN_ids[]" id="old_line_task_PLN_ids_<?PHP echo $compliance; ?>" value="" />
  <input type="hidden" name="PLN_status[]" value="1" />
   <input type="hidden" name="dPLN<?PHP echo $compliance; ?>" id="dPLN<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="current_line_task_PLN_ids[]" id="current_line_task_PLN_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
 <input type="hidden" value="yes" name="PLN_editready" id="PLN_idedit<?PHP echo $compliance; ?>" />
   </div>
</div>
<?PHP exit; ?>
  
