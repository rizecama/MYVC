<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php JPATH_SITE ?>components/com_camassistant/editor/ed.js"></script>
<script type="text/javascript">
function fun_updaterfp(){
	document.rfpupdateform.submit();
}
function fun_showdiv(form)
{
	var len = document.rfpupdateform.choose_tasks.length;
	//alert(btn);
	for (i = 0; i <len; i++) {
if (document.rfpupdateform.choose_tasks[i].checked) {
chosen = document.rfpupdateform.choose_tasks[i].value;
}
}
	if (chosen == "yes") {
	document.rfpupdateform.submit();
		//document.getElementById( 'page2' ).style.display='';
		//document.getElementById( 'page1' ).style.display='none';
}
else {
window.parent.document.getElementById( 'sbox-window' ).close();
}

/*if(val=='yes')
	{
		document.getElementById( 'page2' ).style.display='';
		document.getElementById( 'page1' ).style.display='none';
	} else {
		window.parent.document.getElementById( 'sbox-window' ).close(); 
	}*/
}
</script>

<form style="padding:0px; margin:0px;" action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="rfpupdateform" >
<div class="head_greenbg2" style="margin-right:10px;">RFP Cancellation Confirmation</div>

<div class="form_row_button" style="line-height:24px;padding-left:15px">
<div class="form_text">&nbsp;</div>
<div id="txt_box" style="padding-right:8px;width:393px;">

<div id="page1" style="display:block;">
<div id="txt_box_midbg">You have selected to CANCEL this RFP.  This will immediately Close the RFP, invalidate any proposals for this RFP that may have been submitted, and notify Vendors that the RFP has been withdrawn.
<br/>
Do you want to CANCEL this RFP?
<script>//edToolbar('mytxtarea'); </script>
<div class="clear"></div>
<div>
<table cellspacing="0" cellpadding="0" border="0" width="100%" id="sow_me">
  <tr> <td align="right" width="7%"><input type="radio" name="choose_tasks" id="choose_tasks"  class="modal"  rel="{handler: 'iframe', size: {x: 550, y: 350 }}"  value="yes" /></td>
    <td width="93%" style="padding-top:3px"><strong>Yes</strong></td>
  </tr>
  <tr>
    <td align="right"><input type="radio" name="choose_tasks"  id="choose_tasks" value="no" checked="checked"/></td>
    <td style="padding-top:3px"><strong>No</strong></td>
  </tr>
</table>

</div>
<div class="clear"></div>
<a href="#" onclick="javascript:fun_showdiv(this.form)" style="vertical-align:top">
<img src="templates/camassistant_left/images/submit.png" alt="Cancel" />
</a>
</div>
</div>


<div id="page2" style="display:none;">
<div id="txt_box_midbg" ><h3>Choose your option below?</h1>
<script>//edToolbar('mytxtarea'); </script>
<div class="clear"></div>
<div>
<?php /*?><table cellspacing="0" cellpadding="0" border="0" width="100%" id="sow_me">
  <tr> <td align="right" width="7%"><input type="radio" name="rfp_type" value="closed" onclick="javascript:fun_updaterfp()"/></td>
    <td width="93%" style="padding-top:3px"><strong>Cancel and mark as Closed/Unawarded RFP</strong></td>
  </tr>
  <tr>
    <td align="right"><input type="radio" name="rfp_type"  value="closed" onclick="javascript:fun_updaterfp()"/></td>
    <td style="padding-top:3px"><strong>Cancel and Save as Draft RFP </strong></td>
  </tr>
</table><?php */?>
</div>
<div class="clear"></div>

</div>
</div>

<div id="txt_box_botomcurve"></div>
</div>
<div class="clear"></div></div>

<div class="form_row">
<div id="txt_box"></div>
<div class="clear"></div>
</div>

<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="updatestatus_rfp" />
<input type="hidden" name="rfp_type" value="closed" />
<input type="hidden" name="rfpid" value="<?php echo $_REQUEST['rfpid'];?>" />
<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="Itemid" value="<?php echo $_REQUEST['Itemid'];?>" />

<?php echo JHTML::_( 'form.token' ); ?>


</form>



</div>