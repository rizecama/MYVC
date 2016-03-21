<script type="text/javascript">
	function validateformreset(){
		var form = document.resetfornvalidate;
		re = /[0-9]/;
		 if(form.password1.value)	{
			  if(form.password1.value.length < 7){
				alert("Please enter password with atleast 7 characters");
				return false;
			  }
			  else if(!re.test(form.password1.value)) { 
					 alert("password must contain at least one number (0-9)");
					 return false;
					 }
			  else if ( form.password1.value != form.password2.value) {
					alert( "<?php echo JText::_( 'Password do not match.', true ); ?>" );
					return false;
					}	
			   else {
					document.resetfornvalidate.submit();
					}		  
		 }
		 else if(!form.password1.value){
		 			alert("Please enter password.");
		 }
		 else{
		 	document.resetfornvalidate
		 }
	}
</script>
<?php defined('_JEXEC') or die; ?>

<div id="dotshead_blue_reset">
	<?php echo JText::_('STEP 3: Choose a new Password'); ?>
</div>

<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=completereset&Itemid=137' ); ?>" method="post" class="josForm form-validate" name="resetfornvalidate">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
		<tr>
			<td height="40">
				<p><?php echo JText::_('RESET_PASSWORD_COMPLETE_DESCRIPTION'); ?></p>
			</td>
		</tr>
		<tr>
			<td height="20">
				<label for="password1" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_PASSWORD1_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_PASSWORD1_TIP_TEXT'); ?>"><?php echo JText::_('New Password'); ?>:</label>
			</td>
		</tr>
		<tr>	
			<td height="40">
				<input id="password1" name="password1" type="password" class="required validate-password"  style="font-size:15px; height:30px; width:250px; padding-left:4px;"/>
			</td>
		</tr>
		<tr height="10"></tr>
		<tr>
			<td height="20">
				<label for="password2" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_PASSWORD2_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_PASSWORD2_TIP_TEXT'); ?>"><?php echo JText::_('Reenter New Password'); ?>:</label>
			</td>
		</tr>	
			<td height="40">
				<input id="password2" name="password2" type="password" class="required validate-password"  style="font-size:15px; height:30px; width:250px; padding-left:4px;"/>
			</td>
		</tr>
		<tr height="20"></tr>
	</table>
<label id="submit_reset_password"><input type="image" value="" class="validate" onclick="validateformreset(); return false;" /></label>
	<?php /*?><button type="submit" class="validate"><?php echo JText::_('Submit'); ?></button><?php */?>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>