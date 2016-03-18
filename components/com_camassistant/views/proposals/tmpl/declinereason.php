<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<?php
$company_css = '<link rel="stylesheet" href="'.$this->baseurl.'/templates/camassistant_left/css/style.css" type="text/css" />';
echo $company_css;
?>
<script type="text/javascript">
G = jQuery.noConflict();
	G(document).ready(function(){
		G('.cancellink').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('.submitlink').click(function(){
                    
		               if( G("#other").is(':checked')  ) {
					if( G('#reasonarea').val() == '' ){
                                            alert("Please enter cause in textarea box as you selected Other option.");
					} else {
											G("#rolloverimage").show();
                                            G('#declinedreason').submit();
                                         }
				} else if(G('#declined_options').find('input[type=checkbox]:checked').length == 0) {
                                    alert('You must select at least one reason for declining this project');           
                                } else {
									G("#rolloverimage").show();
                                    G('#declinedreason').submit();
				}
				
		});
		G('#other').click(function(){
			if( G('#other').hasClass('active') ) {
				G('#reasonarea').hide();
				G('#other').removeClass('active');
				G('#whennoother').css('height','45px');
			}
			else{
				G('#reasonarea').show();
				G('#other').addClass('active');
				G('#whennoother').css('height','0px');
			}
		});
		
	});	
</script>
<?php
$rfpid = JRequest::getVar('rfpid',''); 
?>
<?php
$db =& JFactory::getDBO();

$property_details="SELECT property_id FROM #__cam_rfpinfo where id='".$rfpid."'";
$db->Setquery($property_details);
$property_id = $db->loadResult();


$property_details="SELECT property_name,tax_id,zip FROM #__cam_property where id='".$property_id."'";
$db->Setquery($property_details);
$property = $db->loadObject();

 $pr_manager = "SELECT property_manager_id FROM #__cam_property WHERE id ='".$property_id."'";
		$db->Setquery($pr_manager);
		$property_manager_id = $db->loadResult();

		$p_manager = "SELECT name,lastname,phone,extension,email FROM #__users WHERE id = '".$property_manager_id."'";
		$db->Setquery($p_manager);
		$property_manager_detail = $db->loadObjectList();
        ?>
		<div id="rolloverimage" style="display:none;"></div>
<div class="reasondiv">
<form method="post" id="declinedreason" style="padding:0px; margin:0px;">
<table cellpadding="0" cellspacing="0" align="center" id="declined_options">
<tr><td colspan="2"><p>In order to help <?PHP echo $property_manager_detail[0]->name;  ?> <?PHP echo $property_manager_detail[0]->lastname;  ?> understand your reason(s) for declining this invitation, please select one, or more, of the options listed below.</p></td></tr>
<tr height="40"></tr>
<tr><td width="10" colspan="2" style="padding-left:150px"><input class="declinedoptions" type="checkbox" name="big" id="big" /><label>Project too big</label></td></tr>
<tr><td width="10" colspan="2" style="padding-left:150px"><input class="declinedoptions" type="checkbox" name="small" id="small" /><label>Project too small</label></td></tr>
<tr><td width="10" colspan="2" style="padding-left:150px"><input class="declinedoptions" type="checkbox" name="busy" id="busy" /><label>Too busy/Needed staff unavailable</label></td></tr>
<tr><td width="10" colspan="2"  style="padding-left:150px"><input class="declinedoptions" type="checkbox" name="indus" id="indus" /><label>This is an industry we do not serve</label></td></tr>
<tr><td width="10" colspan="2" style="padding-left:150px"><input class="declinedoptions" type="checkbox" name="loc" id="loc" /><label>This is a location we do not serve</label></td></tr>
<tr><td width="10" colspan="2" style="padding-left:150px"><input class="declinedoptions" type="checkbox" name="other" id="other" /><label>Other</label></td></tr>
<tr id="otherreason"><td colspan="2" style="padding-left:90px">&nbsp;<label><textarea style="display:none;" id="reasonarea" name="otherreason"></textarea></label></td></tr>
<tr id="whenother"></tr>
<!--<tr id="whennoother"></tr>-->
<tr align="center">
<td colspan="2">
<a href="javascript:void(0);" class="cancellink createnewrequest"><img src="templates/camassistant_left/images/cancel.jpg"></a>
&nbsp;&nbsp;
<a href="javascript:void(0);" class="submitlink createnewrequest"><img src="templates/camassistant_left/images/submit.jpg"></a>
</td>
</tr>
</table>
<input type="hidden" name="option" value="com_camassistant">
<input type="hidden" name="controller" value="proposals">
<input type="hidden" name="task" value="not_interested">
<input type="hidden" value="<?php echo $rfpid; ?>" name="rfpid" />
<input type="hidden" value="invitation" name="type" />
</form>
</div>
<?php
exit;
?>