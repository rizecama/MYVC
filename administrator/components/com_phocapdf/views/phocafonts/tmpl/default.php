<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<script language="javascript" type="text/javascript">
function submitbuttonupload(pressbutton) {
	document.uploadForm.submit();
}
</script>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">

<div id="editcell">
<table class="adminlist">
<thead>
	<tr>
		<th width="2"><?php echo JText::_('NUM'); ?></th>
		<th width="2"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
	<th width="93%"><?php echo JText::_('Font Name') ?></th>
	<th width="5%" nowrap="nowrap"><?php echo JText::_('Delete'); ?></th>
</tr>
</thead>

<?php
$k = 0;
for ($i=0, $n=count( $this->items ); $i < $n; $i++) {
	
	$row 		= &$this->items[$i];
	$checked 	= JHTML::_('grid.checkedout', $row, $i );
	$linkRemove = 'index.php?option=com_phocapdf&controller=phocafont&task=remove&cid[]='.(int)$row->id;
?>
	<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
	<td><?php echo $checked; ?></td>
	<td><?php echo $row->name ?></td>
		
	<td align="center">
		<a href="<?php echo $linkRemove; ?>" onclick="return confirm('<?php echo JText::_('Warning delete font'); ?>');" title="<?php echo JText::_('Delete'); ?>"><?php echo JHTML::_('image.site',  'icon-16-trash.png', '/components/com_phocapdf/assets/images/', NULL, NULL, JText::_('Delete') )?></a>
		</td>

	</tr>
	<?php
	$k = 1 - $k;
}
?>
<tfoot>
	<tr>
		<td colspan="11"><?php echo $this->pagination->getListFooter(); ?></td>
	</tr>
</tfoot>
</table>
</div>
<input type="hidden" name="type" value="" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_phocapdf" />
<input type="hidden" name="controller" value="phocafont" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>


<form enctype="multipart/form-data" action="index.php" method="post" name="uploadForm">

	<?php   if ($this->ftp) : ?>
		<?php  echo $this->loadTemplate('ftp'); ?>
	<?php  endif; ?>

	<table class="adminform" border="0">
	<tr>
		<td>&nbsp;</td>
		<td colspan="2"><b><?php echo JText::_( 'Upload Phoca PDF Font Installation File' ); ?></b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="120">
			<label for="install_package"><?php echo JText::_( 'Package File' ); ?>:</label>
		</td>
		<td>
			<input class="input_box" id="install_package" name="install_package" type="file" size="57" />
			<input class="button" type="button" value="<?php echo JText::_( 'Upload File' ); ?> &amp; <?php echo JText::_( 'Install' ); ?>" onclick="submitbuttonupload()" />
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	</table>

<div id="pg-update" ><a href="http://www.phoca.cz/phocapdf-fonts" target="_blank"><?php echo JText::_('New Font Download'); ?></a></div>
	
<input type="hidden" name="type" value="" />
<input type="hidden" name="task" value="install" />
<input type="hidden" name="option" value="com_phocapdf" />
<input type="hidden" name="controller" value="phocafont" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>


