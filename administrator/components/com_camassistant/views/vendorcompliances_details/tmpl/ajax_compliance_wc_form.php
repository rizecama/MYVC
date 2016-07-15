<?PHP
$compliance = $_REQUEST['compliance'];
$WC_title = $_REQUEST['WC_title'];
if($WC_title != '')
$delid = $WC_title;
else
$delid = $compliance;
?>
<div id="line_task_WC<?PHP echo $WC_title; ?>">
<div class="lic-pan">
    <h2><!--<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/empty-icon.gif" alt="" />-->WORKERS COMP EXEMPTION FORM - <?php echo $WC_title; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
      <div class="imag-display" id="imagdisplaywc<?PHP echo $WC_title; ?>"><span id="adminnofileuploaded">NO FILE UPLOADED</span></div>
      <div class="rmv"><div class="file_input_div"><span class="upload<?PHP echo $WC_title; ?>"  id="uploadnewwc<?PHP echo $WC_title; ?>"><a href="javascript:doc_upload('<?PHP echo $WC_title; ?>','wc','');" id="adminupload_compliance"></a></span> <span class="remove<?PHP echo $WC_title; ?>"><a href="javascript:doc_upload_second('<?PHP echo $WC_title; ?>','wc','','second');" id="update_compliance" id="removewc<?PHP echo $WC_title; ?>" style="display:none;"></a></span>
              <input type="hidden" name="dwc<?PHP echo  $WC_title; ?>" id="dwc<?PHP echo  $WC_title; ?>"  value="" /><!--<img src="components/com_camassistant/assets/images/upload-document.jpg" alt="" />
   <input type="file" class="file_input_hidden"  name="wc_upld_cert[]" onchange="ajaxFileUpload('wc','');"/>--></div></div>
   
   <div class="reeditbuttons">
<div class="GLI3" style="float: left;">
<a href="javascript: Alt_saveassubmit('WC<?PHP echo $WC_title; ?>');" class="adminsave_complaince"></a>
<a href="javascript:cenceleditdocs();" class="admincancel_complaince"></a><br />

</div>
</div>

   <input type="hidden" class="file_input_textbox" name="wc_upld_cert[]" id="wc_upld_cert<?PHP echo $WC_title; ?>"  value="" /></div>
    <div class="lic-pan-right">
      <div class="comm">
        <label>Expiration Date:</label>
        <input type="text" size="10" name="wc_end_date[]" id="wc_end_date<?PHP echo $WC_title; ?>" placeholder = "mm-dd-yyyy" value=" " /><span style="color:red; font-size: 20px;">*</span><script type="text/javascript">G('#wc_end_date<?PHP echo $WC_title; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,minDate: "0y",maxDate: "+5y",changeMonth:true});</script>
      </div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
       <input class="bak" size="10" name="wc_date_verified[]" id="wc_date_verified<?PHP echo $WC_title; ?>"  type="text" value=""/><script type="text/javascript">G('#wc_date_verified<?PHP echo $WC_title; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
    </div>
    <div class="clear"></div>
 
<input type="hidden" name="old_line_task_wc_ids[]" id="old_line_task_wc_ids_<?PHP echo $compliance; ?>" value="" />
 <input type="hidden" name="wc_status[]" value="1" />
  <input type="hidden" name="dwc<?PHP echo $compliance; ?>" id="dwc<?PHP echo $compliance; ?>" value="" />
<input type="hidden" name="current_line_task_wc_ids[]" id="current_line_task_wc_ids<?PHP echo $compliance; ?>" value="<?PHP echo $compliance; ?>" />
<input type="hidden" value="yes" name="wc_editready" id="wc_idedit<?PHP echo $compliance; ?>" />
</div> </div>
<?PHP exit; ?>
