<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>
<form action="<?php echo JRoute::_('index.php?option=com_rsfirewall&view=lists'); ?>" method="post" name="adminForm" id="adminForm">
	<table class="adminform">
		<tr>
			<td width="100%">
			<?php echo JText::_( 'RSF_SEARCH' ); ?>
			<input type="text" name="filter" id="filter" value="<?php echo $this->escape($this->filter); ?>" class="text_area" onchange="document.adminForm.submit();" />
			<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="this.form.getElementById('filter').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap"><?php echo $this->lists['filter_state']; ?></td>
			<td nowrap="nowrap"><?php echo $this->lists['filter_type']; ?></td>
		</tr>
	</table>
	<table class="adminlist">
		<thead>
		<tr>
			<th width="1%" nowrap="nowrap"><?php echo JText::_( '#' ); ?></th>
			<th width="1%" nowrap="nowrap"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);"/></th>
			<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort', 'RSF_LIST_DATE', 'date', $this->sortOrder, $this->sortColumn); ?></th>
			<th><?php echo JHTML::_('grid.sort', 'RSF_IP_ADDRESS', 'ip', $this->sortOrder, $this->sortColumn); ?></th>
			<th><?php echo JHTML::_('grid.sort', 'RSF_LIST_REASON', 'reason', $this->sortOrder, $this->sortColumn); ?></th>
			<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort', 'RSF_LIST_TYPE', 'type', $this->sortOrder, $this->sortColumn); ?></th>
			<th width="1%" nowrap="nowrap"><?php echo JText::_('RSF_PUBLISHED'); ?></th>
		</tr>
		</thead>
	<?php
	$k = 0;
	$i = 0;
	$n = count($this->rows);
	foreach ($this->rows as $row)
	{
	?>
		<tr class="row<?php echo $k; ?>">
			<td width="1%" nowrap="nowrap"><?php echo $this->pagination->getRowOffset($i); ?></td>
			<td width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.id', $i, $row->id); ?></td>
			<td width="1%" nowrap="nowrap"><?php echo JHTML::_('date', $row->date); ?></td>
			<td><a href="<?php echo JRoute::_('index.php?option=com_rsfirewall&view=lists&layout=edit&cid[]='.$row->id); ?>"><?php echo $this->escape($row->ip); ?></a></td>
			<td><?php echo $this->escape($row->reason); ?></td>
			<td width="1%" nowrap="nowrap" class="rsf_list_type_<?php echo $row->type; ?>"><?php echo JText::_('RSF_LIST_TYPE_'.$row->type); ?></td>
			<td width="1%" nowrap="nowrap" align="center"><?php echo JHTML::_('grid.published', $row, $i); ?></td>
		</tr>
	<?php
		$i++;
		$k=1-$k;
	}
	?>
	<tfoot>
		<tr>
			<td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
	</table>
	
	<?php echo JHTML::_( 'form.token' ); ?>
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_rsfirewall" />
	<input type="hidden" name="view" value="lists" />
	<input type="hidden" name="controller" value="lists" />
	<input type="hidden" name="task" value="" />
	
	<input type="hidden" name="filter_order" value="<?php echo $this->escape($this->sortColumn); ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->escape($this->sortOrder); ?>" />
</form>