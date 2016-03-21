<?php defined('_JEXEC') or die; ?>

<div id="dotshead_blue_reset">
	<?php echo JText::_('STEP 2: Confirm your Account'); ?>
</div>

<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=confirmreset&&Itemid=137' ); ?>" method="post" class="josForm form-validate">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
		<tr>
			<td colspan="2" height="40">
				<p><?php echo JText::_('RESET_PASSWORD_CONFIRM_DESCRIPTION'); ?></p>
			</td>
		</tr>
		<?php /*?><tr> 
			<td height="40">
				<label for="username" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_USERNAME_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_USERNAME_TIP_TEXT'); ?>"><?php echo JText::_('User Name'); ?>:</label>
			</td>
			<td>
				<input id="username" name="username" type="text" class="required" size="36" />
			</td>
		</tr><?php */?>
		<tr>
			<td height="20">
				<label for="token" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_TOKEN_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_TOKEN_TIP_TEXT'); ?>"><?php echo JText::_('Token'); ?>:</label>
			</td>
		</tr>
		<tr>	
			<td headers="40">
				<input id="token" name="token" type="text" class="required" size="36" style="font-size:15px; height:30px; width:280px; padding-left:4px;" />
			</td>
		</tr>
		<tr height="20"></tr>
	</table>
<label id="submit_reset_password"><input type="image" src="" value="" class="validate" /></label>
<?php /*?>	<button type="submit" class="validate"><?php echo JText::_('Submit'); ?></button><?php */?>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
