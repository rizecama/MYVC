<?php defined('_JEXEC') or die('Restricted access'); 

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');

// import html tooltips
JHTML::_('behavior.tooltip');

?>
<script language="javascript" type="text/javascript">
function submitform(pressbutton){
var form = document.adminForm;
var chks = document.getElementsByName('cid[]');
var hasChecked = 0;
for (var i = 0; i < chks.length; i++)
{
	if (chks[i].checked)
	{
	var val = chks[i].value;
	hasChecked = hasChecked+1;
	}
}
   if(pressbutton)
    {form.task.value=pressbutton;}
     
	 if((pressbutton=='add'))
	 {
	  form.controller.value="category_detail";
	  form.submit();
	 }
	 else if(pressbutton=='edit' && hasChecked != 1)
	 {
	 alert("Please make single selection from the list to edit");
	 return false;
	 }
	 else if(pressbutton=='edit')
	 {
	  form.controller.value="category_detail";
	  form.submit();
	 }

	 if((pressbutton=='remove'))
	 {
	     form.controller.value="category_detail";
	     form.submit();
	 }
	form.submit();
}

</script>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" >
<div id="editcell">
	<table>
		<tr>
			<td align="left" width="100%">
				<?php echo '<b>Industry Manager  </b>'; echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->search;?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
		</tr>
	</table>
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th class="title">
			<?PHP 
			function sort1( $title, $order, $direction = 'asc', $selected = 0 )
			{
				$direction	= strtolower( $direction );
				$images		= array( 'sort_asc.png', 'sort_desc.png' );
				$index		= intval( $direction == 'desc' );
				$direction	= ($direction == 'desc') ? 'asc' : 'desc';
		
				$html = '<a href="javascript:tableOrdering(\''.$order.'\',\''.$direction.'\',\''.$task.'\');" title="'.JText::_( 'Click to sort this column' ).'">';
				$html .= JText::_( $title );
				if ($order == $selected ) {
					$html .= JHTML::_('image.administrator',  $images[$index], '/images/', NULL, NULL);
				}
				$html .= '</a>';
				return $html;
			}
		
		   ?>
			<?php //echo JHTML::_( 'grid.sort1', 'Name', 'catname', $this->lists['order_Dir'], $this->lists['order']);
			       echo sort1('Name', 'industry_name', $this->lists['order_Dir'], $this->lists['order']);
			  ?>
				<?php //echo JText::_( 'Name' ); ?>
			</th>
			<th class="title">
			<?php //echo JHTML::_( 'grid.sort1', 'Description', 'catdescription', $this->lists['order_Dir'], $this->lists['order']); ?>
			   <?php  echo sort1('Description', 'industry_desc', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title">
			<?php 
			
			//echo JHTML::_( 'grid.sort1', 'Publish', 'published', $this->lists['order_Dir'], $this->lists['order']); ?>
				<?php  echo sort1('Publish', 'published', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>			 
	</thead>	

	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
        //echo "<pre>"; print_r($row);
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=category_detail&task=edit&cid[]='. $row->id );

		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$published 	= JHTML::_('grid.published', $row, $i );		

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td align="center">
				<?php
				if (  JTable::isCheckedOut($this->user->get('id'), $row->checked_out ) ) {
					echo $row->catname;
				} else {
				?>
					<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Click a Category name to edit it' ); ?>">
						<?php echo $row->industry_name; ?></a>
				<?php
				}
				?>
			</td>
			<td align="center" title="This is a general description of the Industry">
				<?php echo $row->industry_desc; ?>
			</td>
			<td align="center" title="Click the icon to toggle the state of the Industry">
				<?php echo $published; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
<tfoot>
		<td colspan="9">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
	</table>
</div>

<input type="hidden" name="controller" value="category" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>

