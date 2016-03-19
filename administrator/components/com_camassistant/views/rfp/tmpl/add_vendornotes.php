<?php
$ven_id =JRequest::getVar('vendor_id','');
$rfpid = JRequest::getVar('rfp_id','');
$prop_id = JRequest::getVar('prop_id','');
?>
    <script language="javascript" type="text/javascript">
    
	function submitform(pressbutton){

		var form = document.vendor_edit_proposal_form;
		var chks = document.getElementsByName('cid[]');
		var hasChecked = 0;
		
		
	   if(pressbutton == 'cancel') {
	 //  alert("can");
	  window.location = "index.php?option=com_camassistant&controller=rfp&task=vendor_notes&vendorid=<?php echo $ven_id;?>&rfpid=<?php echo $rfpid;?>&prop_id=<?php echo $prop_id;?>";
	  //form.submit();
	   }
          if(pressbutton == 'save'){ 
        /*  if(document.forms['adminForm']['related'].value ==""){
		alert("Please fill the fileds");
		return false;
       	       }
          else if(document.forms['adminForm']['comment'].value ==""){
                 alert("Please fill the fileds");
		 return false;
       	       }*/
        
    		 form.submit();
	          
          
          }
          
		
	}	
function getcursor(){
alert("can");	
}
</script>
<script language="JavaScript" type="text/javascript" src="components/com_camassistant/assets/wysiwyg.js"></script>
<?php
$notes = $this->notes;
?>

<table>
<form name="vendor_edit_proposal_form" method="post" action="index.php?option=com_camassistant&controller=proposals&task=Proposal_save_as&rfp_id=<?PHP echo $RFP->id  ?>"/>
		<?php /*?><tr>
			<td align="left">
				<?php echo JText::_( 'Related To' ); ?>:</td>
<td>
				<input type="text" name="related" id="related" size="100" value="<?php echo htmlentities($notes[0]->relatedto);?>" />	
					
			</td>
</tr><?php */?>
			<tr><td align="left">
				<?php echo JText::_( 'Comment' ); ?>:</td>
<td>

<textarea rows="20" cols="100" name="comment" id="textarea2" />&nbsp;<?php echo $notes[0]->comment;?></textarea>		
<script language="javascript1.2">
generate_wysiwyg('textarea2');
</script>
</td>
</tr>
</table>
<input type="submit" value="SAVE NOTES" />
<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="task" value="save_notes" />
<input type="hidden" name="vendor_id" value="<?php echo $ven_id;?>" />
<input type="hidden" name="rfp_id" value="<?php echo $rfpid;?>" />
<input type="hidden" name="prop_id" value="<?php echo $prop_id;?>" />
<input type="hidden" name="note_id" value="<?php echo $notes[0]->id;?>" />
<input type="hidden" name="from" value="<?php echo $_REQUEST['from']; ?>" />
</form>
