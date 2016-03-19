<?php defined('_JEXEC') or die('Restricted access'); 

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');

// import html tooltips
JHTML::_('behavior.tooltip');
//echo "<pre>"; print_r($this->items);

?>
<script language="javascript" type="text/javascript">
function submitform(pressbutton){
var form = document.adminForm;

	 if((pressbutton=='cancel'))
	 {
	     form.controller.value="vendorcompliances";
		 form.task.value = 'cancel';
		  form.submit();
	 }
	  if(pressbutton=='edit')
	 {
	 
	var chks = document.getElementsByName('cid[]');
	var hasChecked = 0;
	for (var i = 0; i < chks.length; i++)
	{
		if (chks[i].checked)
		{
			var val = chks[i].value;
			
			window.location = "index.php?option=com_camassistant&controller=vendorcompliances_details&task=vendor_compliance_docs&userid="+val+"";
		}
	}

	 
	   //form.controller.value="vendorcompliances_details";
	 } 
	  if((pressbutton=='lists'))
	 {
	     form.controller.value="vendorcompliances";
		 form.task.value = 'lists';
		  form.submit();
	 }
	 else
	 {
	   form.controller.value="vendorcompliances";
	   form.submit();
	 }
	 //alert(form.task.value);
	 //form.submit();
}
</script>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" >
<div id="editcell">
	<table>
		<tr>
			<td align="left" width="100%">
				<?php echo '<b>Vendor Name  </b>'; echo JText::_( 'Filter' ); ?>:
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
			       echo sort1('User ID', 'V.user_id', $this->lists['order_Dir'], $this->lists['order']);
			  ?>
				<?php //echo JText::_( 'Name' ); ?>
			</th>
			<th class="title">
			<?php //echo JHTML::_( 'grid.sort1', 'Description', 'catdescription', $this->lists['order_Dir'], $this->lists['order']); ?>
			   <?php  echo sort1('Name', 'U.name', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title">
			<?php //echo JHTML::_( 'grid.sort1', 'Description', 'catdescription', $this->lists['order_Dir'], $this->lists['order']); ?>
			   <?php  echo sort1('Company Name', 'V.company_name', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title">
			<?php 
			
			//echo JHTML::_( 'grid.sort1', 'Publish', 'published', $this->lists['order_Dir'], $this->lists['order']); ?>
				<?php  echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>	
			<th class="title">
			<?php 
			
			//echo JHTML::_( 'grid.sort1', 'Publish', 'published', $this->lists['order_Dir'], $this->lists['order']); ?>
				<?php  echo 'Options';?>
		 	</th>	
			<th class="title">			Proposal Centre(Active/Inactive)		 	</th>	 
	</thead>	

	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
        //echo "<pre>"; print_r($row);
	if($row){
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=vendorcompliances_details&task=edit&cid[]='. $row->id );

		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$published 	= JHTML::_('grid.published', $row, $i );		

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $i+1; //echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			 <td align="center">
				<?php echo $row->id;  ?>
			</td>
			<td align="center"><?php echo $row->name.'&nbsp;'.$row->lastname; ?>
					<!--<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Click a Vendor compliance documents to edit it' ); ?>">
						<?php echo $row->name.'&nbsp;'.$row->lastname; ?></a>-->
			</td>
			<td align="center">
				<a target="_blank" href="index.php?option=com_camassistant&controller=vendors_detail&task=edit&cid[]=<?php echo $row->vid; ?>"><?php echo $row->company_name;  ?></a>
			</td>
			<td align="center" title="">
				<a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a>
			</td>
			<td align="center">
				<a href="index.php?option=com_camassistant&controller=vendorcompliances_details&task=vendor_compliance_docs&userid=<?PHP echo $row->id; ?>"> Edit Compliance Documents </a> 
			</td>
			<td align="center" title="">
				<?php echo $row->ProposalCentre_status; ?>
			</td>
			
		</tr>
		<?php
		$k = 1 - $k;
	}
	}
	?>
<tfoot>
		<td colspan="9">
			<?php //echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
	</table>
</div>

<input type="hidden" name="controller" value="vendorcompliances" />
<input type="hidden" name="task" value="vendorcompliances_list" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>

