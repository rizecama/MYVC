<?php
	error_reporting(0);
	defined('_JEXEC') or die('Restricted access');
	$ordering = ($this->lists['order'] == 'ordering');
	// import html tooltips
	JHTML::_('behavior.tooltip');
	JHTML::_('behavior.modal');
	$rfp_id = JRequest::getVar('rfp_id','');
	// echo "<pre>"; print_r($this->eligible_vendors);
?>
	<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
	<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
    <script language="javascript" type="text/javascript">
    G = jQuery.noConflict();
	function submitform1(pressbutton){
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
		{
		form.task.value=pressbutton;}

		if(pressbutton=='edit' && hasChecked != 1)
		 {
		 alert("Please make single selection from the list to edit");
		 return false;
		 }
		else if(pressbutton=='remove')
		 {
		 var res = confirm("Are you sure you want to delete this bid");
		 if(res == false)
		 {return false;}
		 }
	else if(pressbutton=='back')
		 {
//		 alert("can");
		var rfpstatus= form.rfpstatus.value;
		var industryid= form.industry_id.value;
		var rfpapproval= form.rfpapproval.value;
		var search= form.search.value;
		//alert(rfpstatus);
		 window.location = 'index.php?option=com_camassistant&controller=rfp&industry_id='+industryid+'&rfpstatus='+rfpstatus+'&rfpapproval='+rfpapproval+'&search='+search;
		 }
		//form.submit();
	}
	function change (id,status,userid)
	{
		SqueezeBox.initialize({});
		if(status==2){
			el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=rfp&task=proposal_reject&id='+id+'&status='+status+'&userid='+userid;
			var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 600, y:450}}"))
			SqueezeBox.fromElement(el,options);
			} else  {
			location.href='index2.php?option=com_camassistant&controller=rfp&task=change_bidstatus&id='+id+'&status='+status+'&rfp_id=<?PHP echo $rfp_id ?>';
			}
		//form.submit();
	}
function county(){

var state = G("#stateid").val();
G.post("index2.php?option=com_camassistant&controller=rfp&task=ajaxcounty", {State: ""+state+""}, function(data){
if(data.length >0) {
G("#divcounty").html(data);
G("#divcounty").val('<?php echo $_REQUEST['divcounty']; ?>');
}
});

}
</script>

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
<p>Eligible vendors:  <?php echo $this->eligiblevendors; ?></p>

<form action="<?php  echo $this->request_url; ?>" method="post" name="adminForm" >

<div id="editcell">
	<table>

	<?php /*?><tr height="40px"><td align="left" width="25%"><br/>
	</td>
	</tr><?php */?>
<?php /*?><tr height="1px"></tr><?php */?>
		<tr align="right"><td style="float:right;"><?php $industryList=$this->industryList; ?>

<?php echo JHTML::_('select.genericlist', $industryList, 'industryid', 'size="1" style="width:283px;" onchange="document.adminForm.submit();" class="inputbox"', 'value', 'text', $_REQUEST['industryid']);?>

<select name="state" style="width:282px;" id="stateid" onchange="javascript:county();" >
 <option value="0">Select State</option>
<?php
for ($i=0; $i<count($this->states); $i++){
$states = $this->states[$i];   ?>
<option  value="<?php echo $states->state_id; ?>" <?php if($states->state_id==$_REQUEST['state']){ ?> selected="selected" <?php } ?> ><?php echo $states->state_name; ?> </option>
<?php }  ?>
 </select>
</td>
<td>

<select style="width: 252px;" name="divcounty" id="divcounty" onchange="document.adminForm.submit();" >
<option value="">Please Select County</option>
</select>
 <script type="text/javascript">
county();
</script>
</td>
<td><select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="special" name="special">
<option selected="selected" value=""> Special Requirements </option>
<option value="pro" <?php if($_REQUEST['special']=='pro') { ?> selected="selected" <?php } ?> >Professional</option>
<option value="occ" <?php if($_REQUEST['special']=='occ') { ?> selected="selected" <?php } ?>>Occupational</option>
<option value="work" <?php if($_REQUEST['special']=='work') { ?> selected="selected" <?php } ?>>Worker's Comp</option>
<option value="general" <?php if($_REQUEST['special']=='general') { ?> selected="selected" <?php } ?>>General Liability</option>

</select>

</td>
			<?php /*?><td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->search;?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td><?php */?>
		</tr>
	</table>

	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' );  ?>
			</th>
			<?php /*?><th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th><?php */?>
			<th class="title" align="left">
					<?php echo JText::_( 'User Id' );  ?>
		   <?php  //echo sort1('UserId #', 'U.id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<?php /*?><th class="title" align="left">
			<?php echo JText::_( 'Proposal #' );  ?>
		   <?php  //echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th><?php */?>
			<th class="title" align="left">
					<?php echo JText::_( 'Vendor Name' );  ?>
		   <?php  //echo sort1('UserId #', 'U.id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Vendor Company Name' );  ?>
			   <?php  //echo sort1('First Name', 'U.name', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Company Phone' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'RegisterDate' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Email Address' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Publish' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Status' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>

			<?php /*?><th class="title" align="left">
     		  <?php  echo sort1('Status', 'P.proposaltype', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
			  <?php echo JText::_( "ITB's" );  ?>
     		  <?php  //echo sort1('Commission', 'P.commission', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
			  <?php echo JText::_( 'Action' );  ?>
     		  <?php  //echo sort1('Alt-Bid', 'P.Alt_bid', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th><?php */?>

	</thead>
<?php //echo "<pre>"; print_r($this->vendorslist); ?>
	<?php
	//echo "<pre>"; print_r(count( $this->vendorslist1 ));
	$k = 0;
	for ($i=0, $n=count( $this->vendorslist ); $i < $n; $i++)
	{

		$row = &$this->vendorslist[$i];

		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=edit&cid[]='. $row->proposal_id );
			//echo 'status------'.$row->published;
		$img 	= $row->published ? 'publish_x.png' : 'tick.png';
		$task 	= $row->published ? 'unblock' : 'block';
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$j = $row->user_id;
		$published 	= JHTML::_('grid.published', $row, $i);
 //echo "<pre>"; print_r($i);
		?>
		<tr class="<?php echo "row$k";  ?>">
			<td>
				<?php echo $i+1; //echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<?php /*?><td><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->proposal_id; ?>" name="cid[]" id="cb<?php echo $i; ?>">
				<?php //echo $checked; ?>
			</td><?php */?>
			<?php /*?><td align="center"><?php echo sprintf('%05d', $row->proposal_id);  ?>
			</td><?php */?>
			<td align="center"><?php echo $row->user_id; ?>
			</td>
			<td align="center">
			<a target="_blank" href="index.php?option=com_camassistant&controller=vendors_detail&task=edit&cid[]=<?php echo $row->id; ?>"><?php echo $row->name.'&nbsp;'.$row->lastname; 	?></a>
				<?php /*?> <a title="Click a vendor name to edit it" href="index.php?option=com_camassistant&controller=vendors_detail&task=edit&cid[]=<?php echo $row->vendor_id;  ?>">
			<?php echo $row->name.'&nbsp;'.$row->lastname; 	?></a><?php */?>
			</td>
			<td align="center">
				<?php 
				if($row->suspend == 'suspend' && $row->flag == 'flag') {$font = "red"; }
				else if($row->flag == 'flag') { $font = "#ff9900"; }
				else if($row->suspend == 'suspend') { $font = "red"; }
				else { $font = ''; }
				?> 
			<font color="<?php echo $font; ?>"><?php echo $row->company_name; ?></font>
			</td>
			<?php /*?><td align="center"><?php echo $row->proposaltype; ?>
			</td><?php */?>
			<td align="center">
				<?php echo $row->company_phone ?>
			</td>

			<td align="center">
			<?php echo JHTML::_('date', $row->registerDate, '%Y-%m-%d %H:%M:%S');?>
			</td>
			<td align="center">
			<a href="mailto:<?php echo $row->email ?>"><?php echo $row->email ?></a>
			</td>
			<td align="center"><?PHP if($row->status != 'approved') echo '__'; else if($row->status == 'approved') { ?>
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
   <?PHP } ?>
			</td>
			<td align="center" >
				<?php echo $row->status ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;

}
	?>
<tfoot>
		<td colspan="20">
			<?php echo $this->pagination1->getListFooter(); ?>
		</td>
	</tfoot>
	</table>
</div>

<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="task" value="eligible_vendors" />
<input type="hidden" name="user_id" value="<?PHP //echo $this->rfpinfo[0]->cust_id; ?>" />
<input type="hidden" name="rfp_id" value="<?PHP echo $this->rfp_id; ?>" />

<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />

<input type="hidden" name="industry_id" value="<?php echo $_REQUEST['industry_id']?>" />
<input type="hidden" name="rfpstatus" value="<?php echo $_REQUEST['rfpstatus'];?>" />
<input type="hidden" name="rfpapproval" value="<?php echo $_REQUEST['rfpapproval'];?>" />
<input type="hidden" name="status" value="<?php echo $_REQUEST['status'];?>" />
<input type="hidden" name="search" value="<?php echo $_REQUEST['search'];?>" />

</form>

