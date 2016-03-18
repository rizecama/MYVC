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
	H('.basic_request').click(function(){
	window.parent.location = 'index.php?option=com_camassistant&controller=vendorscenter&task=basicrfp&view=vendorscenter&Itemid=242';
	window.parent.document.getElementById( 'sbox-window' ).close();	
	});
	H('.advance_request').click(function(){
	window.parent.location = 'index.php?option=com_camassistant&controller=rfp&task=rfpform&Itemid=199';
	window.parent.document.getElementById( 'sbox-window' ).close();	
	});
		
	
});
</script>
<div id="rfp_typeselected">
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:10px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">NEW REQUEST</font></span>
</div></div>
<div class="uninvited_firstdd_text_rfp" style="padding-top:11px;">
<span>Which type of template would you like to use for your new request?</span>
<p class="newrequestclass"><span class="basic_rfptext">BASIC:</span> The basic template will allow you to invite any Vendor within MyVendorCenter to your request, even if a Vendor's provided service/product does not match the industry or service area of your request. Some important features, like sealed bidding and line-item pricing, are not available with this option.</p>

<p class="newrequestclass_nobg"><span class="advanced_rfptext">ADVANCED:</span> The advanced template will auto-filter all Vendors within MyVendorCenter according to the industry and service area of your request for more accurate Vendor selection. Important features, like optional sealed bidding, specific site-visit requirements, line-item pricing, and Scope of Work Wizards are available with this option.</p></div>

<div class="inputoptions_rfp" style="min-height:0px;">
<div class="buttons_uninvite">
<a class="basic_request" href="javascript:void(0);"></a>
<a class="advance_request" href="javascript:void(0);"></a>
</div>
<div id="rolloverimage" style="display:none;"></div>	
</div>
<?php exit; ?>