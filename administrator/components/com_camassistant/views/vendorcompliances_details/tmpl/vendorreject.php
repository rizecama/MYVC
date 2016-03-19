<?php 
//restricted access
defined('_JEXEC') or die('Restricted access');
?>
<link href="<?php  echo Juri::root(); ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/editor/ed.js"></script>
<!--<script type="text/javascript">
function fun(){
document.mailform.submit();
window.parent.document.getElementById( 'sbox-window' ).close(); 
}
</script>-->

<?php 
/* to get the mail id */
$cid = JRequest::getVar('cid','','get','array');
$cid = $cid[0];
$user =& JFactory::getUser($cid);
//echo $user->email;
?>

<form style="padding:0px; margin:0px;" action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="mailform" >
<div class="head_greenbg2">Vendor Reject Mail</div>

<div class="form_row"><div class="form_text">Recipient:</div><label></label><input type="text" style="width: 300px;" name="recipient" value="<?php echo $user->email; ?>"><div class="clear"></div></div>
<div class="form_row"><div class="form_text">Subject:</div><label></label><input readonly="readonly" type="text" style="width: 300px;" name="subject" value="MyVendorCenter Compliance Document Rejected"><div class="clear"></div></div>
<div class="form_row_button">
<div class="form_text">&nbsp;</div>
<div id="txt_box">
<!--<div id="txt_box_topcurve"></div> -->
<!--<div id="txt_box_midbg"><h1>Enter your text here:</h1> -->
<!--<script>edToolbar('mytxtarea'); </script> -->
<div class="clear"></div>
<textarea name="reject_body" id="mytxtarea" class="ed" style=" width:300px; height:150px" readonly="readonly" ><?php echo $this->introtext;  ?></textarea>
<div class="clear"></div>
<input type="image" src="images/submit_text.png" alt="Submit Text" vspace="10" style="margin-top:20px;" border="0"  />
<!--<img src="images/submit_text.png" alt="Submit Text" vspace="10" style="margin-top:20px;" border="0" onclick="javascript:fun();" />-->
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="reject" />
<input type="hidden" name="name" value="<?php echo $user->name; ?>" />
<input type="hidden" name="lastname" value="<?php echo $user->lastname; ?>" />
<input type="hidden" name="controller" value="vendorcompliances_details" />
<input type="hidden" name="userid" value="<?php echo $user->id; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>

</div>
<!--<div id="txt_box_botomcurve"></div> -->
</div>
<div class="clear"></div></div>

<div class="form_row">
<div id="txt_box"></div>
<div class="clear"></div>
</div>
</form>
</div>
<?PHP exit; ?>