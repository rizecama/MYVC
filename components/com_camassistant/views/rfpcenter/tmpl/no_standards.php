<link rel="stylesheet" href="<?PHP echo juri::base(); ?>templates/camassistant_left/css/style.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
H = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var countyCount = 0;
H(document).ready( function(){
	H('.link_cstandards').click(function(){
	window.parent.document.getElementById( 'sbox-window' ).close();	
	window.parent.location = 'index.php?option=com_camassistant&controller=rfpcenter&task=mastercompliance&Itemid=249';
	});
});
</script>
<?php
$rfpid = JRequest::getVar('rfpid','');
?>	
<div id="reminder">
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:10px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">COMPLIANCE STATUS NOT AVAILABLE</font></span>
</div></div>

<div class="nostandards_text">Vendors within your account will not display a current compliance status because company-wide compliance standards have not been set for your company.  To set specific compliance standards for Vendors, please click on the "COMPLIANCE STANDARDS" button below.</div>

<div id="buttons_uninvite">
<table align="center" width="100%">
<tbody><tr height="20"></tr><tr>
<td align="center">
<a class="link_cstandards" style="padding:0px; margin:0px;" href="javascript:void(0);"></a>
</td>
</tr>
</tbody></table>
</div>
</div>
<?php exit; ?>