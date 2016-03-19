<?php defined('_JEXEC') or die('Restricted access');

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');
/*echo '<pre>';
print_r($this->items);*/

// import html tooltips
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
//echo "<pre>"; print_r($this->items);
?>
<script language="javascript" type="text/javascript">


function submitform(pressbutton){
var form = document.adminForm;
 if(pressbutton)
 { form.task.value=pressbutton; }
if(pressbutton == 'edit')
{
	form.task.value = pressbutton;
	form.controller.value="vendors_detail";
}
else if(pressbutton == 'remove')
{
var r=confirm("Are you sure you want to delete this vendor?");
if (r==true){
	form.task.value = pressbutton;
	form.controller.value="vendors";
	}
else
  {
return false;
  }
}
else if(pressbutton == 'add')
{
	form.task.value = pressbutton;
	form.controller.value="vendors_detail";
}
form.submit();
}

function deleteuser(name,id){

var r=confirm("Are you sure you want to delete this vendor "+name+"?");
	if (r==true)
	{
			var frm = document.adminForm;
			frm.controller.value='vendors';
			frm.task.value='remove';
			frm.userid.value = id;
			frm.submit();
	}
	else
	{
	return false;
	}
}
function submit_resend(name,email,user_id){

var r=confirm("Are you sure you want to resend the activation?");
	if (r==true)
	{

			location.href='index.php?option=com_camassistant&controller=vendors&task=activation&name='+name+'&email='+email+'&user_id='+user_id;
	}
	else
	{
	return;
	}
}
function changesubscibestatus(user_id){
var r=confirm("Are you sure you want to change the vendor subscription status?");
	if (r==true)
	{
			location.href='index.php?option=com_camassistant&controller=vendors&task=changesubscriotionstatus&user_id='+user_id;
	}
	else
	{
	return;
	}
}
function loginas(username,password){
document.getElementById('username').value = username;
document.getElementById('passwd').value = password;
document.forms["com-form-login"].submit();
}
</script>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" >
<div id="editcell">
	<table>
		<tr>
			<td align="left">
				<?php echo '<b>Manage Vendor </b>'; echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $_REQUEST['search'];?>" class="text_area" onchange="document.adminForm.submit();" />

				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('vendorstatus').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td align="right" width="43%">
			<?PHP if($this->filter_vendorslist == 'IH') $text = 'Invite A Vendor to sign up as in-house vendor';

			else if($this->filter_vendorslist == 'PF') $text = 'Invite A Vendor to be preferred';

			if($this->filter_vendorslist == 'IH') { ?>
			<!--<input style="cursor:pointer" type="button" value=" <?PHP //echo $text;?> " />-->
			<a class="modal" id="links1"  title="Invite"  href="index.php?option=com_camassistant&view=inviteasinhouse&id=inhouse" rel="{handler: 'iframe', size: {x: 629, y: 445}}" ><?php echo $text; ?></a>
			<?PHP } ?>
			<?php if($this->filter_vendorslist == 'PF') { ?>
			<!--<input style="cursor:pointer" type="button" value=" <?PHP //echo $text;?> " />-->
			<a class="modal" id="links1"  title="Invite"  href="index.php?option=com_camassistant&view=inviteasinhouse&id=preferred" rel="{handler: 'iframe', size: {x: 629, y: 445}}" ><?php echo $text; ?></a>
			<?PHP } ?>
			</td><td><?php echo $this->lists['vendorslist'];?></td><td>
<select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="vendorstatus" name="vendorstatus">
<option selected="selected" value=""> Vendor Status </option>
<option value="active" <?php if($_REQUEST['vendorstatus']=='active') { ?> selected="selected" <?php } ?> >Pending</option>
<option value="inactive" <?php if($_REQUEST['vendorstatus']=='inactive') { ?> selected="selected" <?php } ?>>Inactive</option>
<option value="approved" <?php if($_REQUEST['vendorstatus']=='approved') { ?> selected="selected" <?php } ?>>Approved</option>
<option value="rejected" <?php if($_REQUEST['vendorstatus']=='rejected') { ?> selected="selected" <?php } ?>>Rejected</option>
</select>
</td>

<td>
<select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="vendorlogs" name="vendorlogs">
<option selected="selected" value="">All Vendors</option>
<option value="log" <?php if($_REQUEST['vendorlogs']=='log') { ?> selected="selected" <?php } ?> >Logged-in Now</option>
<option value="notlog" <?php if($_REQUEST['vendorlogs']=='notlog') { ?> selected="selected" <?php } ?> >Not Logged-in Now</option>
</select>
</td>



		</tr>
	</table>
	<table class="adminlist" width="100%">
	<thead>
		<tr>
			<th width="2%">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="2%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th class="title" width="10%">
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
			       echo sort1('Vendor Name', 'name', $this->lists['order_Dir'], $this->lists['order']);
			  ?>
			</th>
			<th class="title" width="13%">
			   <?php  echo sort1('Vendor Company Name', 'company_name', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" width="13%">
			   <?php  echo 'EIN Number'; ?>
			</th>
			<th class="title" width="12%">
				<?php  echo sort1('Company Phone #', 'company_phone', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>
			<th class="title" width="15%">
				<?php  echo sort1('Email Address', 'email', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>
			<th class="title" width="15%">
				<?php  echo sort1("CC'd Email Addresses", 'email', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>
			<th class="title" width="8%">
				<?php  echo sort1('RegisterDate', 'registerDate', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>
			<th class="title" width="4%">
				<?php  echo sort1('Publish', 'Published', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>
			<th class="title" width="5%">Status
		 	</th>
			<th class="title" width="10%">
			   Resend Email Confirmation
			</th>
			<th class="title" width="4%">
			  Delete
			</th>
			
			
			<th class="title">		<?php  echo sort1("Subscription Type", 'subscribe_type', $this->lists['order_Dir'], $this->lists['order']); ?>			 	</th>
			<th class="title">Next payment Date</th>
			
	</thead>
</table>

<div style="overflow:auto; height:500px; width:100%">
	<table class="adminlist" width="100%">
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
      //echo "<pre>"; print_r($row);
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=category_detail&task=edit&cid[]='. $row->vendor_id );
		$approve_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=vendors&task=Approve&user_id='. $row->user_id );
		$reject_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=vendors&task=Reject&user_id='. $row->user_id );
		$img 	= $row->published ? 'publish_x.png' : 'tick.png';
		$task 	= $row->published ? 'unblock' : 'block';
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$j = $row->user_id;
		$published 	= JHTML::_('grid.published', $row, $i);
		?>
		<input type="hidden" name="user_ids[<?PHP echo $row->id; ?>]" value="<?PHP echo $row->user_id; ?>" />
		<tr class="<?php echo "row$k"; ?>">
			<td width="2%">
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td width="2%">
				<?php echo $checked; ?>
			</td>
           <!-- //modified by sateesh on 25-07-11-->
			<td align="center" width="10%">
            <a title="Click a customer name to edit it" target="_blank" href="index.php?option=com_camassistant&controller=vendors_detail&task=edit&cid[]=<?php echo $row->id;  ?>">
			<?php echo $row->name.'&nbsp;'.$row->lastname; 	?></a>
			</td>
            <!-- //modified by sateesh on 25-07-11 completed-->
			<td align="center" width="13%">
			<?php 
				if($row->suspend == 'suspend' && $row->flag == 'flag') {$font = "red"; }
				else if($row->flag == 'flag') { $font = "#ff9900"; }
				else if($row->suspend == 'suspend') { $font = "red"; }
				else { $font = ''; }
				?> 
				<font color="<?php echo $font; ?>"> <a href="javascript:loginas('<?php echo $row->username ?>','<?php echo $row->password; ?>');"><?php echo $row->company_name; ?></a></font>
				<?php $font = ''; ?>
				
				
			</td>
			<td align="center" width="10%">
				<?php echo $row->tax_id;  ?>
			</td>
			<td align="center" width="10%">
				<?php echo $row->company_phone ?>
			</td>
			<td align="center" width="16%">
				<?php echo $row->email ?>
			</td>
			<td align="center" width="16%">
				<?php echo str_replace(';',';<br>',$row->ccemail); ?>
			</td>
			<td align="center" width="8%">
				<?php //echo $row->registerDate ?>
				<?php echo JHTML::_('date', $row->registerDate, '%Y-%m-%d %H:%M:%S');?>
			</td>
			<td align="center"  width="4%"><?PHP if($row->status != 'approved') echo '__'; else if($row->status == 'approved') { ?>
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
   <?PHP } ?>
			</td>
			<td align="center" width="5%">
			<?PHP if($row->status == 'inactive') echo 'Inactive'; else if($row->status == 'rejected') echo 'Rejected'; else if($row->status == 'pending') echo 'Pending'; else if($row->status == 'active') { ?><a href="<?PHP echo $approve_link; ?>">Approve</a> | <a href="<?PHP echo $reject_link; ?>">Reject</a> <?PHP } else if($row->status == 'approved' ) { echo 'Approved'; } ?>
			</td>
			<td align="center" width="10%">
			<?php /*?>index.php?option=com_camassistant&controller=vendors&task=activation&name=<?php echo $row->name; ?>&email=<?php echo $row->email ?>&user_id=<?php echo $row->user_id ?><?php */?>
				<?php $fullname= $row->name.' '.$row->lastname; ?>
			<a href="javascript:submit_resend('<?php echo $fullname; ?>', '<?php echo $row->email ?>','<?php echo $row->user_id ?>');" >Resend Activation</a>
			</td>

<td align="center"  width="4%" >
			<a style="cursor:pointer" onclick="javascript: deleteuser('<?php echo $row->name; ?>', '<?php echo $row->email; ?>');">DELETE</a>
			</td>
			
<td align="center" title="">
				<?php echo $row->subscribe_type; ?>
			</td>
			<td align="center" title="">
				<?php 
				if($row->subscribe_type == 'free'){
					echo "N/A";
				}
				else {
				$db = JFactory::getDBO();
				$date ="SELECT nextdate FROM #__cam_vendor_subscriptions where vendorid=".$row->user_id." order by nextdate DESC ";
				$db->Setquery($date);
				$nextdate = $db->loadResult();
				if($row->subscribe_type){
				echo $nextdate;
				}
				else{
				echo "Inactive";
				}
				}
				 ?>
			</td>
<?php /*?><td align="center" title="">
				<?php 
				if($row->subscribe_type){ ?>
				<a href="javascript:changesubscibestatus('<?php echo $row->user_id ?>');" >ACTIVE</a>
				<?php }
				else{
				echo "Not Subscribed";
				}
				 ?>
			</td><?php */?>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?></table></div>
	<table class="adminlist">
<tfoot>
		<td colspan="13">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
</tfoot>
	</table>
</div>

<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="vendors" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="userid" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>

<form action="<?php echo JURI::root()."index.php"; ?>" method="post" name="comlogin" id="com-form-login" target="_blank">
<input id="username" name="username" id="username" type="hidden" class="inputbox" alt="username" size="18" value="" />
<input id="passwd" type="hidden" id="passwd" name="passwd" class="inputbox" size="18" alt="password" value="" />
<input type="hidden" name="option"  value="com_user" />
<input type="hidden" name="task"  value="login" />
<input type="hidden" name="view"  value="login" />
<input type="hidden" name="from"  value="adminlogin" />
</form>

