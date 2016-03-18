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
		G('#cancelpopup').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('#assignvendor').click(function(){
			invites = G('#invitedvendors_hide').val();
			email = G('#email').val();
			if(!email)
			{
			alert('Please enter manager email');
			return false;
			}
			 var mail=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
			 if(mail.test(email)==false)
			 {
			 alert("Please enter the valid email");
			 return false;
			 }
			G(".totalmanagers:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
			});
			
				G('#invitingform').submit();
			
		});
	});
	
</script>
<form id="invitingform" name="invitingform" method="post">
<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">VENDOR RECOMMENDATION</font></span>
</div></div>
<p class="recommendedtext">Please enter your Manager's Email Address that you would like to recommend this vendor to. Once you click on Submit button, the vendor's information will appear in each manager's VENDOR LISTS page.</p>

<div class="email-div">
	<span style="padding-left:22px; padding-right:24px;">EMAIL</span><input class="int-mgr" type ="text"  id="email"  name="email" style="margin-left:11px;"/>
	</div>
<?php 
$vendors = JRequest::getVar('vendors','');
 ?>

</div>

<br><br>
<div class="clear"></div>

<table width="100%">
<tr>
<td align="right">

<a id="cancelpopup" href="javascript:void(0)"></a>&nbsp;
</td>
<td>
&nbsp;<a id="assignvendor" href="javascript:void(0)"></a>
</td>
</tr>
</table>

<input type="hidden" name="invitedvendors" id="invitedvendors" value="<?php echo $vendors; ?>">
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="vendorscenter" name="controller">
<input type="hidden" value="propertyowner_recommendvendors" name="task">
<input type="hidden" value="vcenter" name="vcenter" />
</form>
<?php
exit;
?>