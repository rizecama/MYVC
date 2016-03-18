<div style="height:26px;color:#ffffff; font-size: 16px; font-weight: bold; text-align:center; font-family:Sans-serif; padding-top: 8px; background: url('templates/camassistant_left/images/green_bg1.gif'); margin-left:11px; margin-right:11px;">INFO SHARING PREFERENCES</div>
<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php JPATH_SITE ?>components/com_camassistant/editor/ed.js"></script> 
<script type="text/javascript">
function fun(a){
if(a=='s'){
document.mailform.submit();
window.parent.document.getElementById( 'sbox-window' ).close(); 
}
else{
window.parent.document.getElementById( 'sbox-window' ).close(); 
}
}
</script>
<div id="l_box" style="width:350px; margin-top:10px;" align="center">
<?php /*?><div class="head_greenbg2">Info Sharing Preferences</div><?php */?>
<form style="padding:0px; margin:0px;" action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="mailform" >
<table>
<tr><td>Phone Number:</td><td><?php echo  $this->phone; ?></td></tr>
<tr><td>Alt. Phone:</td><td><?php echo  $this->fax; ?></td></tr>
<tr><td>Address:</td><td><?php echo  $this->address; ?></td></tr>
<tr><td>Email:</td><td><?php echo  $this->email; ?></td></tr>
<tr><td>Company:</td><td><?php echo  $this->company; ?></td></tr>
</table>

<img src="images/submit.gif" alt="Submit Text" vspace="10" hspace="10"  style="cursor:pointer"border="0" onclick="javascript:fun('s');" />
<img src="images/cancel-bution.jpg" alt="Submit Text" vspace="10" hspace="10"  style="cursor:pointer"border="0" onclick="javascript:fun('c');" />

<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="shareinfo" />
<input type="hidden" name="load" value="save" />
<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="tmpl" value="component" />
<?php echo JHTML::_( 'form.token' ); ?>

</form>
</div>