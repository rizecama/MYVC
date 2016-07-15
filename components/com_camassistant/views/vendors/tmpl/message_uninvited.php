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
		G('#current').val('');
		G('#cancelpopup_new').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		
	});
	
</script>
<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">UN-INVITE</font></span>
</div></div>
<p class="uninitedtext_vendor">The Manager who submitted this request has uninvited you for the following reason:<br /><br /><strong><?php echo $this->message ?></strong></p>
<div class="resetpasswords_message">
<a id="cancelpopup_new" href="#" class="oknewsmall_new"></a>
</div>
<?php
exit;
?>