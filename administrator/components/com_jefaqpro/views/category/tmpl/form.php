<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

defined('_JEXEC') or die('Restricted access');

// joomla predefined functions.
$doc 		= & JFactory::getDocument();
$editor		= & JFactory::getEditor();
$cparams 	= JComponentHelper::getParams ('com_media');

$js  		= JURI::base().'components/com_jefaqpro/assets/js/validate.js';
$doc->addScript($js);

?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'JE_CATEGORY_DETAILS' ); ?></legend>
			<table class="admintable" width="100%">
				<tr>
					<td width="10%" align="right" class="jekey">
						<label for="category">
							<?php echo JText::_( 'JE_CATEGORY' ); ?>:
						</label>
					</td>
					<td width="90%">
						<input class="required" type="text" name="category" id="category" size="62" maxlength="256" value="<?php echo $this->row->category;?>" onblur="elementvalidate(this.id)" />
						<span id="category-error"></span>
					</td>
				</tr>
				<tr>
					<td align="right" class="jekey">
						<label for="alias">
							<?php echo JText::_( 'JE_CATEGORY_ALIAS' ); ?>:
						</label>
					</td>
					<td>
						<input class="input_text" type="text" name="alias" id="alias" size="62" maxlength="256" value="<?php echo $this->row->alias; ?>" />
					</td>
				</tr>

				<tr>
					<td align="right" class="jekey">
						<label for="published">
							<?php echo JText::_( 'JE_FAQ_PUBLISHED' ); ?>:
						</label>
					</td>
					<td>
						<?php
							$published = ($this->row->id) ? $this->row->state : 1;
							echo JHTML::_('select.booleanlist',  'state', '', $published );
						?>
					</td>
				</tr>
				<tr>
					<td align="right" class="jekey">
						<label for="ordering">
							<?php echo JText::_( 'JE_CATEGORY_ORDERING' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $this->lists['ordering']; ?>
					</td>
				</tr>
				<tr>
					<td align="right" class="jekey">
						<label for="image">
							<?php echo JText::_( 'JE_CATEGORY_IMAGE' ); ?>:
						</label>
					</td>
					<td>
						<input type="file" name="image"  id="image"  size="50" value="<?php echo $this->row->image;?>">
					</td>
				</tr>
				<tr>
					<td align="right" class="jekey">
						<label for="image_position">
							<?php echo JText::_( 'JE_CATEGORY_IMAGEPOSITION' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $this->lists['image_position']; ?>
					</td>
				</tr>
			</table>
	</fieldset>

	<fieldset  class="adminform">
		<legend> <?php echo JText::_( 'JE_CATEGORY_INTROTEXT' ); ?> </legend>
		<table class="admintable" width="100%">
			<tr>
				<td valign="top">
					<?php
							//Editor parameters : areaname, content, width, height, cols, rows
							echo $editor->display( 'introtext',  $this->row->introtext , '50%', '300', '75', '30' ) ;
					?>
				</td>
			</tr>
		</table>
	</fieldset>

	<div class="clr"></div>

	<input type="hidden" name="option" value="com_jefaqpro" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" id="controller" value="category" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

<p class="copyright" align="center">
	<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
</p>