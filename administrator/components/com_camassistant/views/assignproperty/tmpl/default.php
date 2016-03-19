<?php defined('_JEXEC') or die('Restricted access'); 

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');

// import html tooltips
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
//echo "<pre>"; print_r($this->items); exit;

?>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script language="javascript" type="text/javascript">
G = jQuery.noConflict();
function submitform(pressbutton){
var form = document.adminForm;
var chks = document.getElementsByName('cid[]');
var hasChecked = 0;
for (var i = 0; i < chks.length; i++)
{
	if (chks[i].checked)
	{
	var val = chks[i].value;
	var retailers = document.getElementById('retailers_'+val).value;
	var seccat = document.getElementById('seccat_'+val).value;
	var retailers_name = document.getElementById('retailers_name_'+val).value;
	var seccat_name = document.getElementById('seccat_name_'+val).value;
	hasChecked = hasChecked+1;
	}
}

   if(pressbutton)
    {form.task.value=pressbutton;}
	 if((pressbutton=='add'))
	 {
	  form.controller.value="assignproperty_detail";
	  form.submit();
	 }
	 else if(pressbutton=='edit' && hasChecked == 1)
	 {
	  form.controller.value="assignproperty_detail";
	  form.submit();
	 }
	 else if(pressbutton=='edit' && hasChecked != 1)
	 {
	 alert("Please make single selection from the list to edit");
	 return false;
	 }
	 if((pressbutton=='remove'))
	 {
		 if(retailers == 0 && seccat == 0)
		 {
		 var val = confirm("Are you sure you want to delete the selected items?");
		 if(val == false)
		 return false;		 
		 }
	    form.controller.value="assignproperty_detail";
	     form.submit();
	 }
	form.submit();
	if(pressbutton=='lists'){
	 window.location="index.php?option=com_camassistant";
	}
}
function unhideprop(pid,type){
	if( type == 'unhide' )
	var cnfr = confirm(" Are you sure you want to Un-Delete this property? ");
	else
	var cnfr = confirm(" Are you sure you want to Delete this property? ");
	if( cnfr == true ) {
		G.post("index2.php?option=com_camassistant&controller=assignproperty&task=updateproperty", {property_id: ""+pid+"" , type: ""+type+""}, function(data){
		location.reload();
		});
	}
	else{
	}
}

</script>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" >
<div id="editcell">
Property Name: <select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="propertyname" name="propertyname">
<option value="0">All Properties</option>

<?php for ($p=0, $n=count( $this->properties ); $p < $n; $p++)
	{ ?>
<option <?php if($_REQUEST['propertyname'] == $this->properties[$p]->pid) { ?> selected="selected"<?php }?> value="<?php echo $this->properties[$p]->pid; ?>"><?php echo $this->properties[$p]->property_name; ?></option>
<?php } ?>
</select>
Companies: <select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="camfirmname" name="camfirmname">
<option value="0" selected="selected">All Companies</option>
	<?php for ($c=0, $n=count( $this->camfirms ); $c < $n; $c++)
	{ ?>
<option <?php if($_REQUEST['camfirmname'] == $this->camfirms[$c]->id) { ?> selected="selected"<?php }?> value="<?php echo $this->camfirms[$c]->id; ?>"><?php echo $this->camfirms[$c]->comp_name; ?></option>
<?php } ?>
</select>

Managers: <select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="manager" name="manager">
<option value="0" selected="selected">All Managers</option>
	<?php for ($m=0, $n=count( $this->managers ); $m < $n; $m++)
	{ ?>
<option <?php if($_REQUEST['manager'] == $this->managers[$m]->id) { ?> selected="selected"<?php }?> value="<?php echo $this->managers[$m]->id; ?>"><?php echo $this->managers[$m]->name.'&nbsp;'.$this->managers[$m]->lastname; ?></option>
<?php } ?>
</select>

States: <select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="state" name="state">
<option value="0" selected="selected">All States</option>
	<?php for ($s=0, $n=count( $this->state_sort ); $s < $n; $s++)
	{ ?>
<option <?php if($_REQUEST['state'] == $this->state_sort[$s]->state_id) { ?> selected="selected"<?php }?> value="<?php echo $this->state_sort[$s]->state_id; ?>"><?php echo $this->state_sort[$s]->state_id ?></option>
<?php } ?>
</select>

Cities: <select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="city" name="city">
<option value="0" selected="selected">All Cities</option>
	<?php for ($c=0, $n=count( $this->cities ); $c < $n; $c++)
	{ ?>
<option <?php if($_REQUEST['city'] == $this->cities[$c]->city) { ?> selected="selected"<?php }?> value="<?php echo $this->cities[$c]->city; ?>"><?php echo $this->cities[$c]->city ?></option>
<?php } ?>
</select>

<br /><br />
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
			<?php 
			       echo sort1('Property Name', 'property_name', $this->lists['order_Dir'], $this->lists['order']);
			  ?>
			</th>
             <th class="title">
			   <?php  echo sort1('Company Name', 'comp_name', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
            <th class="title">
			   <?php  echo sort1('Property Manager', 'name', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
              
			<th class="title">
			   <?php  echo sort1('Property ID Number', 'tax_id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title">
				<?php  echo sort1('State', 'state', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>	
			<th class="title">
				<?php  echo sort1('City', 'city', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>	
			<th class="title">
				<?php  echo sort1('Created Time', 'createtime', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>
			<th class="title">
				<?php  echo 'Reassign Property'; ?>
		 	</th>
            <th class="title">
				<?php  echo 'Delete/Un-Delete'; ?>
		 	</th>
			<?php /*?><th class="title">
				<?php  echo sort1('Remove Vendor', 'lastname', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th><?php */?>
	</thead>	

	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		
        $filter = JRequest::getVar( 'filter_order','' );
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=assignproperty_detail&task=edit&filter_order='.$filter.'&cid[]='. $row->pid );

		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$published 	= JHTML::_('grid.published', $row, $i );		

		?>
		<?php 
			if($row->publish == '1')
			$bckground = 'red';
			else
			$bckground = '';
		?>
		<tr class="<?php echo "row$k$bckground"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->pid; ?>" name="cid[]" id="cb<?php echo $i; ?>">
				<input type="hidden" id="retailers_<?PHP echo $row->pid; ?>" value="<?PHP echo $row->retailers; ?>" />
				<input type="hidden"  id="seccat_<?PHP echo $row->pid; ?>" value="<?PHP echo $row->seccat; ?>" />
				<input type="hidden" id="seccat_name_<?PHP echo $row->pid; ?>"  value="<?PHP echo $row->catname; ?>" />
				<input type="hidden" id="retailers_name_<?PHP echo $row->pid; ?>"  value="<?PHP echo $row->catname; ?>" />
			</td>
			<td align="left">
				<a href="<?php echo $link; ?>"><?php  echo str_replace('_',' ',$row->property_name);			?></a>
			</td>
 <td align="left" title="This is a general description of the Category">
            <?php
			if($row->camfirmid)
			$row->camfirmid=$row->camfirmid;
			else
			$row->camfirmid=$row->property_manager_id;
			$db =& JFactory::getDBO();
			if($_REQUEST['camfirmname']){
			$query = "SELECT comp_name FROM #__cam_camfirminfo WHERE id=".$_REQUEST['camfirmname'];
			}
			else{
			$query = "SELECT id, comp_name FROM #__cam_camfirminfo WHERE cust_id=".$row->camfirmid;
			}
			$db->setQuery($query);
			//$companyname = $db->loadResult();
			$company = $db->loadObject();
			$companyname = $company->comp_name;
			$cid = $company->id;
			//echo $companyname;
			echo $row->comp_name;

			?>
			</td>
			<td align="left">
				<?php  echo $row->name.'&nbsp;'.$row->lastname;		?>
			</td>
        
			<td align="left" title="This is a general description of the Category">
				<?php
				$lastchar = substr($row->tax_id, -1);
				if($lastchar == '-'){
					$finaltax = substr($row->tax_id, 0, -1);
				}
				else{
					$finaltax = $row->tax_id;
				}
				 echo $finaltax; ?>
			</td>
			<td align="left" title="Click the icon to toggle the state of the Category">
				<?php echo $row->state; ?>
			</td>
			<td align="left" title="Click the icon to toggle the state of the Category">
				<?php echo $row->city; ?>
			</td>
            <td align="left" title="Click the icon to toggle the state of the Category">
				<?php echo $row->createtime; ?>
			</td>
              <td align="left" title="Click the icon to toggle the state of the Category">
				<a class="modal" id="links1"  title="Assign this property to any other manager"  href="index2.php?option=com_camassistant&controller=assignproperty&task=reasign&tmpl=component&pname=<?php echo $row->property_name; ?>&pid=<?php echo $row->pid; ?>&company=<?php echo $cid; ?>&present=<?php echo $row->id; ?>" rel="{handler: 'iframe', size: {x: 600, y: 450}}" ><?php echo "Re Assign"; ?></a>
			</td>
			<td>
			<?php 
				if($row->publish == '1'){ ?>
				<a href="javascript:void(0);" onclick="unhideprop(<?php echo $row->pid; ?>,'unhide');">Un-Delete</a>
				<?php } else{ ?>
				<a href="javascript:void(0);" onclick="unhideprop(<?php echo $row->pid; ?>,'hide');">Delete</a>
				<?php }
				?>
			</td>
			<?php /*?><td align="center" title="Click the icon to toggle the state of the Category">
				<?php 
				$baseurl = JURI::root();
				$image_path = $baseurl.'administrator/components/com_camassistant/images/search.gif';
				 ?>
			<input type="image" style="border:0px" src="<?php echo $save_path; ?>" onclick="document.getElementById('task').value='status_tx'; document.getElementById('user_id').value='<?php echo $row->user_id; ?>';"  />
			</td><?php */?>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
<tfoot>
		<td colspan="10">
			<?php  echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
	</table>
</div>

<input type="hidden" name="controller" value="assignproperty" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>

