<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<?php
$company_css = '<link rel="stylesheet" href="'.$this->baseurl.'/templates/camassistant_left/css/style.css" type="text/css" />';
echo $company_css;
$from = JRequest::getVar('from','');
?>
<script type="text/javascript">
G = jQuery.noConflict();
	G(document).ready(function(){
		G('#cancelpopupbasic_req').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('#assignvendorbasic_req').click(function(){
			invites = G('#invitedvendors_hide').val();
			rfpid = G('#rfpid').val();
			if( !rfpid || rfpid == '0' ) {
				alert("Please select the Request.");
			}
			else{
					G.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkvendor_invites&from=<?php echo $from; ?>", {vendorid: ""+invites+"", rfpid: ""+rfpid+""}, function(data){
					data = data.slice(0,-1) ;
					data = data.trim() ;
					if(data == '') {
alert("    You have selected a Vendor that is already participating in the basic request chosen.\n Please choose a different Basic Request or click 'CANCEL' and choose a different Vendor.");
					}
					else {
					G('#invitedvendors').val(data) ;
					G('#invitingform').submit();
					}
					});
				}
		});
	});
	
</script>
<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">INVITE TO BASIC REQUEST</font></span>
</div></div>
<?php 
$basics = $this->basisjobs ;
$vendors = JRequest::getVar('vendors','');
if( $basics )  { ?>
<p style="margin:5px 21px; font-size:13px;">Please select the Basic Request that you would like the selected Vendor(s) to participate in. Once you click "SUBMIT", the Vendor(s) will be sent a personal invitation to participate. If you would like to add the selected Vendor(s) to an Advanced Request, please use the "INIVITE A VENDOR" link that is available once you click the "+" icon next to that particular request.</p>
<?php } ?>
<form id="invitingform" name="invitingform" method="post">
<table width="100%" cellpadding="0" cellspacing="0">
<tr height="30"></tr>
<tr><td align="center">
<?php if( $basics )  { ?>
<select name="rfpid" id="rfpid" style="width:395px; height:35px; padding:5px;">
<option value="0">Please Select Basic Request</option>
<?php
for( $b=0; $b<count($basics); $b++ ){
echo '<option value="'.$basics[$b]->id.'">'. $basics[$b]->projectName .'</option>';	
}
?>
</select>
<?php } else { ?>
<p style="font-size:14px; padding:0 20px;">You do not have any Basic Requests to invite a Vendor to. If you'd like to invite a Vendor to an Advanced Request, then please use the "INVITE VENDOR" link after clicking on the "+" icon next to that request.</p>
<?php } ?>
</td></tr>
<tr height="35"></tr>
<tr>
<td align="center">
<?php if( $basics )  { ?>
<div>
<a id="cancelpopupbasic_req" href="javascript:void(0)"></a>
<a id="assignvendorbasic_req" href="javascript:void(0)"></a>
 </div>
<?php } else { ?>
<a class="oknewsmall_nobasics" id="cancelpopup" href="javascript:void(0)"></a>
<?php } ?>
</td>
</tr>
</table>
<input type="hidden" name="invitedvendors" id="invitedvendors" value="<?php echo $vendors; ?>">
<input type="hidden" name="vendors" id="invitedvendors_hide" value="<?php echo $vendors; ?>">
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="rfp" name="controller">
<input type="hidden" value="invitenewvendor" name="task">
</form>
<?php
exit;
?>