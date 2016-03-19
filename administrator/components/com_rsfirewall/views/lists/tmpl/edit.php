<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
?>

<script type="text/javascript">
function submitbutton(pressbutton)
{
	var form = document.adminForm;
	
	if (pressbutton == 'cancel')
	{
		submitform(pressbutton);
		return;
	}
	if (pressbutton == 'save2copy')
		form.id.value = '';

	// do field validation
	if (form.ip.value.length == 0)
		alert('<?php echo JText::_('RSF_IP_ERROR', true); ?>');
	else if (form.ip.value == '*.*.*.*')
		alert('<?php echo JText::_('RSF_IP_MASK_ERROR', true); ?>');
	else
		submitform(pressbutton);
}

<?php if (RSFirewallHelper::isJ16()) { ?>
	Joomla.submitbutton = submitbutton;
<?php } ?>
</script>

<form action="<?php echo JRoute::_('index.php?option=com_rsfirewall&view=lists&layout=edit'.($this->row->id > 0 ? '&cid[]='.$this->row->id : '')); ?>" method="post" name="adminForm" id="adminForm">
<div class="rsfirewall_tooltip"><?php echo JText::sprintf('RSF_YOUR_IP_ADDRESS_IS', $this->escape($this->ip)); ?></div>
<div class="width-100">
	<fieldset class="adminform">
	<legend><?php echo $this->row->id ? JText::sprintf('RSF_EDITING_IP', $this->escape($this->row->ip)) : JText::_('RSF_ADDING_NEW_IP'); ?></legend>
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="admintable">
		<tr>
			<td width="1%" nowrap="nowrap" align="right" class="key"><span class="hasTip" title="<?php echo JText::_('RSF_IP_ADDRESS_DESC'); ?>"><label for="ip"><?php echo JText::_('RSF_IP_ADDRESS'); ?></label></span></td>
			<td><input type="text" name="ip" value="<?php echo $this->escape($this->row->ip); ?>" id="ip" size="120" maxlength="255" /></td>
		</tr>
		<tr>
			<td width="1%" nowrap="nowrap" align="right" class="key"><span class="hasTip" title="<?php echo JText::_('RSF_LIST_TYPE_DESC'); ?>"><label for="type"><?php echo JText::_('RSF_LIST_TYPE'); ?></label></span></td>
			<td><?php echo $this->lists['type']; ?></td>
		</tr>
		<tr>
			<td width="1%" nowrap="nowrap" align="right" class="key"><span class="hasTip" title="<?php echo JText::_('RSF_LIST_REASON_DESC'); ?>"><label for="published"><?php echo JText::_('RSF_LIST_REASON'); ?></label></span></td>
			<td><textarea cols="80" rows="10" class="text_area" name="reason" id="reason"><?php echo $this->escape($this->row->reason); ?></textarea></td>
		</tr>
		<tr>
			<td width="1%" nowrap="nowrap" align="right" class="key"><span class="hasTip" title="<?php echo JText::_('RSF_PUBLISHED_DESC'); ?>"><label for="published"><?php echo JText::_('RSF_PUBLISHED'); ?></label></span></td>
			<td><?php echo $this->lists['published']; ?></td>
		</tr>
	</table>
	</fieldset>
</div>
	
<?php echo JHTML::_('form.token'); ?>
<input type="hidden" name="option" value="com_rsfirewall" />
<input type="hidden" name="view" value="lists" />
<input type="hidden" name="controller" value="lists" />
<input type="hidden" name="task" value="" />

<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
</form>

<?php
//keep session alive while editing
JHTML::_('behavior.keepalive');
?>