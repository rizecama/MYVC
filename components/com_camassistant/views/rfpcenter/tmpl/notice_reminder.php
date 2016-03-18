<link rel="stylesheet" href="<?php echo juri::base(); ?>templates/camassistant_left/css/style.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
H = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var countyCount = 0;
H(document).ready( function(){ 
	H('.oknewsmall_noprps').click(function(){
	window.parent.document.getElementById( 'sbox-window' ).close();		
	});
});
</script>
<?php
$companyname = JRequest::getVar('cname','');
$companyname_acc = str_replace('_',',',$companyname);
$date_submitted = JRequest::getVar('dates','');
?>	
<div id="reminder">
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:10px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">INVITATION ACCEPTED</font></span>
</div></div>
<div class="inputoptions_check">
<div class="uninvited_firstdd_text" style="padding-top:11px;">
<span><?php echo strtoupper($companyname_acc); ?></span><br />
<?php 
$date_time = explode(' ',$date_submitted);
$time = date("h:i A", strtotime($date_time[1]));
?>
<span class="">has accepted your invitation at <strong><?php echo $time; ?></strong> on <strong><?php echo $date_time[0]; ?></strong></span>
<p class="bordertopclass">IMPORTANT: If this Vendor does not provide a proposal before your requested due date, you can use the "SEND REMINDER" feature to deliver a friendly reminder.</p></div>
<div class="inputoptions_check" style="min-height:0px;">
<a id="" href="javascript:void(0);" class="oknewsmall_noprps" style="margin-top:1px;"></a>
</div>
</div>
</div>
<?php exit; ?>