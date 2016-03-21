<?php 
error_reporting(0);
defined('_JEXEC') or die; ?>

<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>

	<div id="dotshead_blue_reset">
		<?php //echo $this->escape($this->params->get('page_title'));
		echo "STEP 1: Enter Primary Email";
		 ?>
	</div>
<?php endif; ?>

<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=requestreset&Itemid=137' ); ?>" method="post" class="josForm form-validate">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
		<tr>
			<td colspan="2" height="55">
				<p><?php echo JText::_('RESET_PASSWORD_REQUEST_DESCRIPTION'); ?></p>
			</td>
		</tr>
		<tr>
			<td height="40">
				<label for="email" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_EMAIL_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_EMAIL_TIP_TEXT'); ?>"><?php echo JText::_('Email Address'); ?>:</label>
			</td>
		</tr>
		<tr>	
			<td>
				<input id="email" name="email" type="text" class="required validate-email" style="font-size:15px; height:30px; width:250px; padding-left:4px;" />
			</td>
		</tr>
       <!-- <tr>
			<td height="40">
				<label for="email" class="hasTip" title="<?php echo JText::_('QUESTION'); ?>::<?php echo JText::_('QUESTION'); ?>"><?php echo JText::_('Select Your Security Question'); ?>:</label>
			</td>
			<td>
           <?php      echo JHTML::_('select.genericlist', $this->questions, 'question', null, 'value', 'text', $currentValue); ?>
				 
			</td>
		</tr>
        <tr>
			<td height="40">
				<label for="email" class="hasTip" title="<?php echo JText::_('ANSWER'); ?>::<?php echo JText::_('ANSWER'); ?>"><?php echo JText::_('Your Answer'); ?>:</label>
			</td>
			<td>
				<input id="answer" name="answer" type="text" class="require answer" />
			</td>
		</tr>-->
		<tr height="20"></tr>
	</table>
<label id="submit_reset_password"><input type="image" src="" value="" class="validate" /></label>
<?php /*?>	<button type="submit" class="validate"><?php echo JText::_('Submit'); ?></button><?php */?>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
