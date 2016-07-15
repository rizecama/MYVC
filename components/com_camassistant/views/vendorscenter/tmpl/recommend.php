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
	var matchesr = [];
	var countpr = 0 ;
	G(document).ready(function(){
		G('#vendor_cancelpopup').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('#vendor_assignvendor').click(function(){
			invites = G('#invitedvendors_hide').val();
			G(".totalmanagers:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
			});
			if( countpr == '0' ){
				alert("Please select atleast one manager to recommend the vendors to.");
			}
			else{
				G('#invitingform').submit();
			}
		});
	});
	
</script>
<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">VENDOR RECOMMENDATION</font></span>
</div></div>
<p class="recommendedtext">Please choose the manager(s) that you would like to recommend this vendor to. Once you click on Submit button, the vendor's information will appear in each manager's VENDOR LISTS page.</p>
<?php 
$managers = $this->managers ;
$vendors = JRequest::getVar('vendors','');
 ?>
<form id="invitingform" name="invitingform" method="post">
<?php if($managers) { 
	if( count($managers) < 8 ) { 
	echo '<div class="recommendationsform_less">';
	}
	else{
	echo '<div class="recommendationsform">';
	}
?>

<table width="100%" cellpadding="0" cellspacing="0">
<?php
for( $b=0; $b<count($managers); $b++ ){
?>
<tr>
<td align="left">&nbsp;<?php echo $managers[$b]->name.'&nbsp;'.$managers[$b]->lastname; ?></td>
<td width="20" align="left"><input type="checkbox" value="<?php echo $managers[$b]->id; ?>" name="manager[]" class="totalmanagers" /></td>
</tr>
<?php 
	}
?>
<tr height="10"></tr>
</table>
</div>
<?php } else { 
	echo "<table width='100%' cellpadding='0' cellspacing='0'><tr><td width='100%' colspan='2'><p class='nomanagersrecs'>There are no other Managers in your office to recommend vendors to.  To invite other Managers that work in your office to join MyVendorCenter, please tell your Admin Account holder to use the 'INVITE A MANAGER' feature and send them a personal invitation.</p></td></tr></table>";

}
?>

<div class="clear"></div>
<?php
if($managers) { ?>
<table width="100%">
<tr>
<td align="right">
<a id="vendor_cancelpopup" href="javascript:void(0)"></a>&nbsp;
</td>
<td>
&nbsp;<a id="vendor_assignvendor" href="javascript:void(0)"></a>
</td>
</tr>
</table>
<?php } ?>
<input type="hidden" name="invitedvendors" id="invitedvendors" value="<?php echo $vendors; ?>">
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="vendorscenter" name="controller">
<input type="hidden" value="recommendvendors" name="task">
<input type="hidden" value="vcenter" name="vcenter" />
</form>
<?php
exit;
?>