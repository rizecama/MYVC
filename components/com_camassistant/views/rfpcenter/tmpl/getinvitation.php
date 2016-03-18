<?php
$user =& JFactory::getUser(); 
if($user->user_type == '13'){
$item = '216';
}
else {
$item = '217';
}
?>
<script type="text/javascript">
function sendalertvendor(rfptype,rfpid,props){
window.parent.location = "index.php?option=com_camassistant&controller=rfp&rfp_type="+rfptype+"&rfpid="+rfpid+"&bids="+props+"&var=closeinvite&task=saverfpmsg1&Itemid=199";
window.parent.document.getElementById( 'sbox-window' ).close();		
}
function outsidevendornew(){
window.parent.location = "index.php?option=com_camassistant&controller=vinvitations&Itemid=<?php echo $item; ?>";
window.parent.document.getElementById( 'sbox-window' ).close();	
}
</script>
<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<link href="<?php JPATH_SITE ?>templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<style>
#semdInvitation:hover{
opacity:0.8
}
</style>
<div id="l_box_topcurve" style="margin:10px; padding-left:45px;">
  <div id="l_box_close"></div>
    <p>INVITE A VENDOR</p>
</div>

<form name="inviteform" id="inviteform" method="post" >
<div id="invite-popup" style="width:616px;">
<p style="text-align:left">Select the type of Vendor you would like to personality invite to participate in this project. Clicking on PREFERRED VENDOR will take you to Preferred Vendor list. Clicking on OUTSIDE VENDOR will allow you to send an invitation to a Vendor that does NOT have a MyVendorCenter account..</p><br />

<div class="invite-popup-main" style="width:432px; float:right">
<div class="invite-popup-left"><?php //echo '<pre>'; print_r($_REQUEST['rfpid']);?>
<?php $db = &JFactory::getDbo();
$updaterfp="SELECT rfp_type,maxProposals FROM #__cam_rfpinfo where id='".$_REQUEST['rfpid']."'";
$db->Setquery($updaterfp);
$status12 = $db->loadObjectlist(); ?><!--index.php?option=com_camassistant&controller=rfp&rfp_type=rfp&rfpid=956615&bids=3&task=saverfpmsg1&Itemid=193-->
<a href="javascript:sendalertvendor('<?php echo $status12[0]->rfp_type; ?>','<?php echo $_REQUEST['rfpid']; ?>','<?php echo $status12[0]->maxProposals; ?>');">
<img vspace="10" border="0" align="right" src="templates/camassistant_left/images/prefered-vendor.gif" style="cursor:pointer;" alt="Submit Text" id="closewindow"></a>
</div>
<br />
<div style="margin:0px; width:250px;" class="invite-popup-left">
<a href="javascript:outsidevendornew();"><img vspace="10" border="0" align="right" src="templates/camassistant_left/images/outside-vendor.gif" style="cursor:pointer;" alt="Submit Text" id="semdInvitation"></a>
</div>

</div></div>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="rfpcenter" name="controller">
<input type="hidden" value="sendinvitation" name="task">
</form>
<?php

exit; ?>