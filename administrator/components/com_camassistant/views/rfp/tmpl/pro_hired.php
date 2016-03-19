<link href="<?php  echo Juri::root(); ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php  echo Juri::root(); ?>components/com_camassistant/editor/ed.js"></script> 
<script type="text/javascript">
function fun(){
document.mailform.submit();
window.parent.document.getElementById( 'sbox-window' ).close(); 
}
</script>
<div id="l_box">
<div id="l_box_close"></div>
</div>
<div class="head_greenbg2">A professional By the Property Asscoiation</div>
<form style="padding:0px; margin:0px;" action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="mailform" >
<div class="form_row"><div class="form_text">Recipient:</div><label></label><input type="text" name="recipient" style="width:300px;"/><div class="clear"></div></div>
<div class="form_row_button">
<div class="form_text">&nbsp;</div>
<div id="txt_box">
<div id="txt_box_topcurve"></div>
<div id="txt_box_midbg"><h1>Enter your text here:</h1>
<script>edToolbar('mytxtarea'); </script>
<div class="clear"></div>
<textarea name="sowtext" id="mytxtarea" class="ed" style=" width:325px;" ><?php echo $this->bodytext; ?></textarea>
<div class="clear"></div>

<img src="images/submit_text.png" alt="Submit Text" vspace="10" style="margin-top:20px;" border="0" onclick="javascript:fun();" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="prohired" />
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