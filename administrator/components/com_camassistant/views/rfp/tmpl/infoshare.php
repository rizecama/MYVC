<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php JPATH_SITE ?>components/com_camassistant/editor/ed.js"></script> 
<script type="text/javascript">
function fun(){
document.mailform.submit();
window.parent.document.getElementById( 'sbox-window' ).close(); 
}
</script>
<div id="l_box" style="width:217px;">
<div class="head_greenbg2">Info Sharing Preferences</div>
<form style="padding:0px; margin:0px;" action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="mailform" >
<table>
<tr><td>Phone Number:</td><td><?php echo  $this->phone; ?></td></tr>
<tr><td>Fax No:</td><td><?php echo  $this->fax; ?></td></tr>
<tr><td>Adress:</td><td><?php echo  $this->address; ?></td></tr>
<tr><td>Email:</td><td><?php echo  $this->email; ?></td></tr>
<tr><td>Company:</td><td><?php echo  $this->company; ?></td></tr>
</table>

<img src="images/submit_text.png" alt="Submit Text" vspace="10" hspace="10"  style="float:right;"border="0" onclick="javascript:fun();" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="shareinfo" />
<input type="hidden" name="load" value="save" />
<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="tmpl" value="component" />
<?php echo JHTML::_( 'form.token' ); ?>

</form>
</div>