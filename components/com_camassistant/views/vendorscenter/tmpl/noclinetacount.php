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
		G('.cancelnoclient').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('.findnoclient').click(function(){
	
		
		el="<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=noclinetacount";
		var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:300}}"))
		SqueezeBox.fromElement(el,options);

		
		});
				
	});
	
</script>
<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">FIND YOUR CLIENT</font></span>
</div></div>
<p>
To see if your Client is registered, please enter the primary email address associated with your Client's MYVendorCenter(Property Owner Account).</p>
<div class="check_propertyemail">
<input type ="text" name ="email" id= "email" id="email" />
     <input type="hidden" name="option" value="com_camassistant" />
     </div>
<form id="invitingform" name="invitingform" method="post">
<div class="findnoclienttolink">
<a class="cancelnoclient" href="javascript:void(0)"></a>
<a class="findnoclient" href="javascript:void(0)"></a>
<a class="invitenoclient" href="javascript:void(0)"></a>
</div>

<input type="hidden" name="boardmemberid" id="boardmemberid" value="<?php echo $bid; ?>">
<input type="hidden" name="oldproperty" id="oldproperty" value="<?php echo $oldproperty; ?>">
<input type="hidden" name="propertyname" class="propertyname">
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="boardmembers" name="controller">
<input type="hidden" value="inviteproperty" name="task">
</form>
<?php
exit;
?>