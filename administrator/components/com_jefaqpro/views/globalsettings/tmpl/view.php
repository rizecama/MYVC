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

<!-- Template Settings -->
<fieldset class="adminform">
	<legend><?php echo JText::_( 'JE_FRONTEND_CONFIG' ); ?></legend>
		<table class="admintable" width="100%">
			<tr>
				<td align="right" class="jekey" width="38%">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_TITLE' ); ?>::<?php echo JText::_( 'JE_TITLEDES' ); ?>">
						<label for="show_title">
							<?php echo JText::_( 'JE_TITLE' ); ?>:
						</label>
					</span>
				</td>
				<td width="62%">
					<?php
						$show_title = ($this->items->id) ? $this->items->show_title : 0;
						echo JHTML::_('select.booleanlist',  'show_title', '', $show_title );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_SHOWINTRO' ); ?>::<?php echo JText::_( 'JE_SHOWINTRODES' ); ?>">
						<label for="introtext">
							<?php echo JText::_( 'JE_SHOWINTRO' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$introtext = ($this->items->id) ? $this->items->introtext : 0;
						echo JHTML::_('select.booleanlist',  'introtext', '', $introtext );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_NOCATEGORIES' ); ?>::<?php echo JText::_( 'JE_NOCATEGORIESDES' ); ?>">
						<label for="cat_perpage">
							<?php echo JText::_( 'JE_NOCATEGORIES' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<input type="text" name="cat_perpage" size="8" id="cat_perpage" value="<?php echo $this->items->cat_perpage ; ?>" />
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_IMAGE' ); ?>::<?php echo JText::_( 'JE_IMAGEDES' ); ?>">
						<label for="show_image">
							<?php echo JText::_( 'JE_IMAGE' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$show_image = ($this->items->id) ? $this->items->show_image : 0;
						echo JHTML::_('select.booleanlist',  'show_image', '', $show_image );
					?>
				</td>
			</tr>
			<tr>
				<td  align="right" class="jekey" valign="top">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_DIMENSIONS' ); ?>::<?php echo JText::_( 'JE_DIMENSIONSDES' ); ?>">
						<label for="name">
							<?php echo JText::_( 'JE_DIMENSIONS' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$resize = ($this->items->id) ? $this->items->resize : 0;
						echo JHTML::_('select.booleanlist',  'resize', 'onClick="return imageResize()"', $resize );
					?>
					<div id="imgdimensions" style="display : none; padding : 10px 0px 10px 0px;">
						<div style="padding : 2px;"> <?php echo JText::_('JE_WIDTH'); ?> :&nbsp; <input type="text" id="image_width"  name="image_width"  value="<?php if ($this->items->image_width == '0') { echo 'Width'; } else { echo $this->items->image_width; } ?>" size="8" maxlength="20"   onFocus="this.value=''"   onBlur="avatarDet('<?php  echo $this->items->image_width; ?>', this.id)" /> <?php echo JText::_('JE_PX'); ?> </div>
						<div style="padding : 2px;"> <?php echo JText::_('JE_HEIGHT'); ?> : <input type="text" id="image_height" name="image_height" value="<?php if ($this->items->image_height == '0') { echo 'Height'; } else { echo $this->items->image_height;} ?>" size="8" maxlength="20"  onFocus="this.value=''"   onBlur="avatarDet('<?php  echo $this->items->image_height; ?>', this.id)" /> <?php echo JText::_('JE_PX'); ?> </div>
					</div>
				</td>
			</tr>
		</table>
</fieldset>
<!-- Template Settings End-->