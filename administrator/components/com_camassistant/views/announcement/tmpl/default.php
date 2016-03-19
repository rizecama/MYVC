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
	  form.controller.value="announcement_detail";
	  form.submit();
	 }
	 else if(pressbutton=='edit' && hasChecked != 1)
	 {
	 alert("Please make single selection from the list to edit");
	 return false;
	 }
	 else if(pressbutton=='edit')
	 {
	  form.controller.value="announcement_detail";
	  form.submit();
	 }

	 if((pressbutton=='remove'))
	 {
	     form.controller.value="announcement_detail";
	     form.submit();
	 }
	form.submit();
}

</script>
<?php //echo "<pre>"; print_r($this->items); ?>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" >
<div id="editcell">
	
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
			
			   <?php  echo sort1('Announcement', 'Announcement', $this->lists['order_Dir'], $this->lists['order']); ?>
			
			</th>
			<th class="title" align="left">
		   <?php  echo sort1('User Type', 'User Type', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
		   <?php  echo sort1('Industry', 'Industry', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
				<th class="title" align="left">
		   <?php  echo sort1('State', 'State', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			
			
			<th class="title" align="left">
				<?php  echo sort1('Publish', 'Published', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>
			
	</thead>	

	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
        //echo "<pre>"; print_r($row);
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=announcement_detail&task=edit&cid[]='. $row->id );
		$approve_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=announcement&task=approve&user_id='. $row->cust_id );
		$reject_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=announcement&task=reject&user_id='. $row->cust_id );
		$img 	= $row->published ? 'publish_x.png' : 'tick.png';
		$task 	= $row->published ? 'unblock' : 'block';
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$j = $row->user_id;
		$published 	= JHTML::_('grid.published', $row, $i);		
			
		$db = JFactory::getDBO();
		$sql = "SELECT state_name FROM #__state where id=".$row->state_name;
		$db->Setquery($sql);
		$states = $db->loadResult();
		
		
		$sq2 = "SELECT industry_name FROM #__cam_industries where id=".$row->industry_name;
		$db->Setquery($sq2);
		$industry = $db->loadResult();
		
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
				
			<td><a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Click a announcement name to edit it' ); ?>">
				<?php echo $row->announcement; ?></a>
			</td>
			<td>
			<?php if ($row->user_type=='11'){ 
				 echo "Vendor"; 
				 } else if($row->user_type=='12') {
				 echo "Manager";
				 }
				 else if($row->user_type=='16') {
				 echo "Property Owner";
				 }
				 
				  else {
				 echo "Cam Firm Admin";
				 }
				 ?>
			</td>
			<td><a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Click a announcement name to edit it' ); ?>">
				<?php echo $industry; ?></a>
			</td>
			<td><a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Click a announcement name to edit it' ); ?>">
				<?php echo $states; ?></a>
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
		<td colspan="20">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
	</table>
</div>

<input type="hidden" name="controller" value="announcement" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>

