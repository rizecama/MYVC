<?php 
$deleteid = JRequest::getVar('id','');
?>
<link rel="stylesheet" href="<?php echo juri::base(); ?>templates/camassistant_left/css/style.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
H = jQuery.noConflict();
H(document).ready( function(){
H('.cancel_assign').click(function(){
window.parent.document.getElementById( 'sbox-window' ).close();		
});
H('.assign_mgr').click(function(){
	if( H('#managerid').val() == '0' ){
		alert("Please select manager");
	}
	else{
		H('#assignedform').submit();
	}
	});

	});
</script>
<div id="rolloverimage" style="display:none;"></div>
<div id="i_bar_terms" style="margin:20px 20px 10px; background:none repeat scroll 0 0 #77b800">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">DELETED ACCOUNT</font></span>
</div></div>

<div class="vendortypebody">
<p style="font-size:13px;">Please choose an account below in which you would like to reassign the deleted user's properties and managers. NOTE: If a person does not appear on this list, you will need to click on the INVITE A NEW MANAGER button and have them create a new manager account first. You can only reassign managers to a District Manager or an Admin account, You can upgrade a user's account by directly clicking on the "ACCOUNT TYPE" for an individual user.</p>
<br /><br />
<div class="managerslist" align="center">
<form name="assignedform" id="assignedform" method="post">
<?php
echo $this->managerslist;
?>
</div>
<div align="center" style="" class="savebuttons_property">
<a href="javascript:void(0);" class="cancel_assign"></a>
<a href="javascript:void(0);" class="assign_mgr"></a></div>
</div> 


<input type="hidden" value="com_camassistant" name="option" />
<input type="hidden" value="propertymanager" name="controller" />
<input type="hidden" value="reassignmanager" name="task" />
<input type="hidden" value="<?php echo $deleteid; ?>" id="vendorid" name="deletedid" />
</form>
<?php 
exit; ?>