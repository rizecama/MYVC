<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

defined('_JEXEC') or die('Restricted access');

$doc 		= & JFactory::getDocument();
$editor		= & JFactory::getEditor();

$js  		= JURI::base().'components/com_jefaqpro/assets/js/validate.js';
$doc->addScript($js);


?>

<!-- Get the Editor Contents using the joomla editor function -->
<script language="javascript" type="text/javascript">

function editorContent()
{
	var text = <?php echo $editor->getContent( 'answers' ); ?>
	return text;
}

</script>
<!-- Script End -->

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'JE_FAQ_DETAILS' ); ?></legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="jekey">
						<label for="name">
							<?php echo JText::_( 'JE_FAQ_CATEGORY' ); ?>:
						</label>
					</td>
					<td>
						<?php echo JHTML::_('select.genericlist', $this->category, 'catid', 'class="input_text"', 'value', 'text', $this->row->catid) ?>
					</td>
					<td>
						<span id="category-error"></span>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="jekey">
						<label for="name">
							<?php echo JText::_( 'JE_FAQ_QUESTIONS' ); ?>:
						</label>
					</td>
					<td>
						<input class="required" type="text" name="questions" id="questions" size="100"  value="<?php echo $this->row->questions;?>" onblur="elementvalidate(this.id)" />
					</td>
					<td>
						<span id="questions-error"></span>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="jekey" valign="top">
						<label for="name">
							<?php echo JText::_( 'JE_FAQ_ANSWERS' ); ?>:
						</label>
					</td>
					<td valign="top">
						<?php
								//Editor parameters : areaname, content, width, height, cols, rows
								echo $editor->display( 'answers',  $this->row->answers , '100%', '300', '75', '30' ) ;
						?>
					</td>
					<td>
						<span id="answers-error"></span>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="jekey">
						<label for="name">
							<?php echo JText::_( 'JE_FAQ_PUBLISHED' ); ?>:
						</label>
					</td>
					<td colspan="2">
						<?php
							$published = ($this->row->id) ? $this->row->state : 1;
							echo JHTML::_('select.booleanlist',  'state', '', $published );
						?>
					</td>
				</tr>
			</table>
	</fieldset>

	<div class="clr"></div>
	
	<input type="hidden" name="cat_id" value="<?php echo $this->row->catid ; ?>" />
	
	<input type="hidden" name="posted_by" value="<?php echo $this->posted['postedby'] ; ?>" />
	<input type="hidden" name="posted_email" value="<?php echo $this->posted['email'] ; ?>" />
	<input type="hidden" name="posted_date" value="<?php echo $this->posted['posteddate'] ; ?>" />
	<input type="hidden" name="gid" value="<?php echo $this->posted['gid'] ; ?>" />
	<input type="hidden" name="remote_ip" value="<?php echo $this->posted['remote_ip'] ; ?>" />
	<input type="hidden" name="option" value="com_jefaqpro" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="email_status" value="<?php echo $this->row->email_status; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" id="controller" value="faq" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

<p class="copyright" align="center">
	<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
</p>