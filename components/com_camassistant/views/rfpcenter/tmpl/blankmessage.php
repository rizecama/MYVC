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
	H('.oknewsmall_noprps').click(function(){
	window.parent.document.getElementById( 'sbox-window' ).close();		
	});
});
</script>
<?php
$rfpid = JRequest::getVar('rfpid','');
$vendors = JRequest::getVar('vendors','');
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
?>	
<form action="" method="post" name="uninviteform" id="uninviteform">
<div id="messageboxs">
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:10px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">Awaiting Vendor's Response</font></span>
</div></div>
<div class="uninvited_firstdd_text" style="padding-top:0px;">
<p>This Vendor has not Accepted or Declined your invitation. Please click on "SEND REMINDER" to ask this Vendor to respond.</p></div>
<div id="buttons_uninvite"><br />
<table align="center" width="100%">
<tbody>
<tr>
<td align="right">
<a id="" href="#" class="oknewsmall_noprps" style="margin-top:-14px;"></a>
</td>
</td>
</tr>
</tbody></table>
</div>
<div id="rolloverimage" style="display:none;"></div>	
</div>
<?php exit; ?>