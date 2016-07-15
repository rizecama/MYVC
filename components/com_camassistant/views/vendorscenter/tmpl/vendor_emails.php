<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script><link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<?php
$company_css = '<link rel="stylesheet" href="'.$this->baseurl.'/templates/camassistant_left/css/style.css" type="text/css" />';
echo $company_css;
$from = JRequest::getVar('from','');
?>
<script type="text/javascript">
G = jQuery.noConflict();
	G(document).ready(function(){
		G('#cancelpopup_email').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('#submitpopup_email').click(function(){
			if( G('#mailsubject').val() == '' ){
				alert("Please enter mail subject");
			}
			else if( G('#mailbody').val() == '' ){
				alert("Please enter mail body");			
			}
			else{
			G('#vendormailform').submit();
			G("#rolloverimage").show();
			G(".buttonimages").hide();
			}
		});
	});
	
</script>
<form id="vendormailform" method="post">
<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">EMAIL VENDOR<span class="vendorspace">S</span></font></span>
</div></div>
<p class="recommendedtext">Please write your message below and then click "<strong>SUBMIT</strong>". Once submitted, your message will be separately emailed to all selected Vendors.</p>

<div id="message-popup" style="margin-top: 20px; margin-left: 17px; width: 535px;">
<div class="message-popup-main">
<div class="message-popup-left">
<input type="text" style="width: 617px;" id="mailsubject" name="subject" value="" placeholder="(Enter Subject)">
</div>
</div>

<div class="message-popup-main">
<textarea name="mailbody" id="mailbody" placeholder="(Enter Message)"></textarea>
</div>

<div class="message-popup-main">
<input type="checkbox" name="copymanager" checked="checked" />Copy me on this message
</div>

</div>
<input type="hidden" value="com_camassistant" name="option" />
<input type="hidden" value="vendorscenter" name="controller" />
<input type="hidden" value="sendmailto_vendors" name="task" />
</form>
<div class="clear"></div>
<div id="rolloverimage" style="display:none;"></div>
<div align="center" class="buttonimages">
<table align="center"><tbody><tr>
<td>
<a id="cancelpopup_email" href="javascript:void(0);"></a>
</td>
<td>
<a id="submitpopup_email" href="javascript:void(0);"></a>
</td>

</tr></tbody></table>
</div>
<?php
exit;
?>