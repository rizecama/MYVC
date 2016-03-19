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
	<legend><?php echo JText::_( 'JE_THEMES_CONFIG' ); ?></legend>
		<table class="admintable" width="100%">
			<tr>
				<td align="right" class="jekey" width="25%">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_FAQ_THEMES' ); ?>::<?php echo JText::_( 'JE_FAQ_THEMESDES' ); ?>">
						<label for="themes">
							<?php echo JText::_( 'JE_FAQ_THEMES' ); ?>:
						</label>
					</span>
				</td>
				<td width="75%">
					<?php
						echo JHTML::_('select.genericlist',  $this->themes, 'themes', 'class="inputbox" onchange="selectTheme(this.value)"', 'value', 'text', $this->items->themes);
					?>
				</td>
			</tr>
			<tr height="">
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_FAQ_THEMESPREVIEW' ); ?>::<?php echo JText::_( 'JE_FAQ_THEMESPREVIEWDES' ); ?>">
						<label for="themes_preview">
							<?php echo JText::_( 'JE_FAQ_THEMESPREVIEW' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<div id="je-themepreview"></div>
				</td>
			</tr>
		</table>
		<input type="hidden" id="theme_path" name="theme_path" value="<?php echo JURI::base(); ?>" />
</fieldset>
<!-- General Settings End-->