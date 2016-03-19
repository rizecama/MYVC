<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::root(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery.elastic.js"></script>
<script type="text/javascript">
function closepopup(){
window.parent.document.getElementById( 'sbox-window' ).close();}
</script>
<script language="JavaScript" type="text/javascript" src="components/com_camassistant/assets/wysiwyg.js"></script>
<form name="vendor_Edit_proposal_form" id="vendor_Edit_proposal_form" method="post"/>
<table>
		<?php /*?><tr>
			<td align="left">
				<?php echo JText::_( 'Related To' ); ?>:</td>
<td>
				<input type="text" name="related" id="related" size="100" value="<?php echo htmlentities($notes[0]->relatedto);?>" />	
					
			</td>
</tr><?php */?>
<tr>				<td>Related To: </td>
				<td>
<select name="vendor_id"><option value="0">General Note</option><option value="m">Manager</option>
<?php
for($p=0; $p<count($this->propos); $p++ ){ ?>
<option value="<?php echo $this->propos[$p]->id ; ?>"><?php echo $this->propos[$p]->company_name; ?></option>
<?php }?></select>
				</td></tr>
			<tr><td align="left">
				<?php echo JText::_( 'Comment' ); ?>:</td><td>
<textarea rows="20" cols="100" name="comment" id="textareaa" />&nbsp;<?php echo $notes[0]->comment;?></textarea>		
<script language="javascript1.2">
generate_wysiwyg('textareaa'); 
</script>
</td></tr>

<tr><td></td><td><input type="submit" value="SAVE" onClick="javascript:closepopup();" /></td></tr>
</table>
<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="task" value="save_mainnotes" />
<input type="hidden" name="rfp_id" value="<?php echo $_REQUEST['rfpid'];?>" />
<input type="hidden" name="from" value="<?php echo $_REQUEST['from']; ?>" />
<input type="hidden" name="var" value="secondform" />
</form>
<?php exit; ?>