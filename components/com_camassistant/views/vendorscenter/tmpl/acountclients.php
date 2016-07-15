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
		G('#cancellinkaccept').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('#assignlinkaccept').click(function(){
		propertyid = G('#newproperty').val();
		if( propertyid == '0' ) 
		{
		alert("select your property");
		return false;
		}
		G('#invitingclient').submit();
		});
				
	});
	
</script>

<div class="linkwithclient">
<div id="i_bar_terms" class="linkclientinfo">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:800; color:#FFF;">LINK WITH YOUR CLIENT</font></span>
</div></div>

<p style="margin:5px 104px; font-size:15px;margin: 24px 70px 0; color: #4d4d4d;">Please confirm the Property you would like to LINK with this Client.</p>

<form id="invitingclient" name="invitingform" method="post">
<table width="100%" cellpadding="0" cellspacing="0">
<tr height="30"></tr>
<tr><td align="center">
<?php //echo '<pre>';print_r($this->propertyList);exit;
$bid = JRequest::getVar('bid','');

?>
<select name="newproperty" id="newproperty" style="width:395px; height:35px; padding:5px;">
<option value="0">Please Select Property</option>
<?php

for( $b=0; $b<count($this->propertyList); $b++ ){
echo '<option value="'.$this->propertyList[$b]->value.'">'. str_replace('_',' ',$this->propertyList[$b]->text) .'</option>';	
}
?>
</select>

</td></tr>
<tr height="35"></tr>

<tr>
<td align="center">
</div>
<div class="invitationlinkbuttons">
<a id="cancellinkaccept" href="javascript:void(0)"></a>
<a id="assignlinkaccept" href="javascript:void(0)"></a>
</div>
</td>
</tr>
</table>
<div id="rolloverimage" style="display:none;"></div>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="boardmembers" name="controller">
<input type="hidden" value="inviteproperty" name="task">
</form>
<?php
exit;
?>