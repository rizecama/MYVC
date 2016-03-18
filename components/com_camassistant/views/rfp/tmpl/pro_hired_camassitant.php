<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php JPATH_SITE ?>components/com_camassistant/editor/ed.js"></script>
<script type="text/javascript">
function fun(){
document.mailform.submit();
window.parent.document.getElementById( 'sbox-window' ).close(); 
}
</script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<div id="l_box" style="width:580px;">
<?php  $industryList=$this->industryList; ?>
<div class="head_greenbg2">A professional By the Property Asscoiation</div>
<form style="padding:0px; margin:0px;" action="<?php echo JRoute::_( 'index2.php' ); ?>" method="post" name="mailform" >


	<div class="form_row" ><div class="form_text" >Select A Professional:</div><?php echo JHTML::_('select.genericlist', $industryList, 'industry_id', 'size="1" style="width:315px;" class="inputbox" style="background:none; border:1px solid #DEDEDE;"', 'value', 'text', '');?><div class="clear"></div></div>
<div class="form_row"><div class="form_text">When are the Profwssionals Proposal Due by:</div><label></label><input type="text" name="inhousevendors" style="width:300px;"/><div class="clear"></div></div>
<div class="form_row"><div class="form_text">What time are the proposal due:</div><label></label><input type="text" name="subject" style="width:300px;"/><div class="clear"></div></div>

<div class="form_row_button" >
<div class="form_text" style="width:153px;">&nbsp;</div>
<div id="txt_box" style="float:left;padding:0px;">
<div id="txt_box_topcurve"></div>
<div id="txt_box_midbg"><h1>Enter your text here:</h1>
<script>edToolbar('mytxtarea'); </script>
<div class="clear"></div>
<textarea name="inhousetext" id="mytxtarea" class="ed" style=" width:361px;" ><?php echo $this->bodytext;  ?></textarea>
<div class="clear"></div>

<img src="images/submit_text.png" alt="Submit Text" vspace="10" border="0" onclick="javascript:fun();" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="hirecamassitant" />
<?php echo JHTML::_( 'form.token' ); ?>

</div>
<div id="txt_box_botomcurve"></div>
</div>
<div class="clear"></div></div>

<div class="form_row">
<div id="txt_box"></div>
<div class="clear"></div>
</div>



<div class="clear"></div>

</form>



</div>