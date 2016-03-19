<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

?>

<!-- General Settings -->
<fieldset class="adminform">
	<legend><?php echo JText::_( 'JE_FORM_CONFIG' ); ?></legend>
		<table class="admintable" width="100%">
			<tr>
				<td align="right" class="jekey" width="25%">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_SHOW_CAPTCHA' ); ?>::<?php echo JText::_( 'JE_SHOW_CAPTCHADES' ); ?>">
						<label for="show_captcha">
							<?php echo JText::_( 'JE_SHOW_CAPTCHA' ); ?>:
						</label>
					</span>
				</td>
				<td width="75%">
					<?php
						$show_captcha = ($this->items->id) ? $this->items->show_captcha : 0;
						echo JHTML::_('select.booleanlist',  'show_captcha', '', $show_captcha );
					?>
				</td>
			</tr>
		</table>
</fieldset>
<!-- General Settings End-->