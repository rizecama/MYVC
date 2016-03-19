<?php
	error_reporting(0);
	defined('_JEXEC') or die('Restricted access');
	$ordering = ($this->lists['order'] == 'ordering');
	// import html tooltips
	JHTML::_('behavior.tooltip');
	JHTML::_('behavior.modal');
	$rfp_id = JRequest::getVar('rfp_id','');
	//$rfp_id = JRequest::getVar('rfp_id','');
	$db=&JFactory::getDBO();
	$rfpname = "SELECT projectName, property_id, cust_id, proposalDueDate, proposalDueTime, rfp_adminstatus  FROM #__cam_rfpinfo WHERE  id='".$rfp_id."'";
	$db->setQuery($rfpname);
	$rfp_details = $db->loadObject();
	//to get the property name
	$p_name = "SELECT u.property_name, v.name, v.lastname, u.divcounty, v.username, v.password  FROM #__cam_property as u, #__users as v WHERE  u.id='".$rfp_details->property_id."' and v.id=u.property_manager_id";
	$db->setQuery($p_name);
	$propname = $db->loadObject();
	//To Get the property county
	$c_name = "SELECT County FROM #__cam_counties WHERE  id='".$propname->divcounty."'";
	$db->setQuery($c_name);
	$county_name = $db->loadResult();

	//Completed
	//To get the camfirm name
	$camfir_name = "SELECT comp_name,comp_phno,comp_extnno FROM #__cam_customer_companyinfo WHERE  cust_id='".$rfp_details->cust_id."'";
	$db->setQuery($camfir_name);
	$camname = $db->loadObject();
	$cam_name = $camname->comp_name;
$task = JRequest::getVar('from','');

if($task == 'primary'){
$return = '';
$from = 'primary';
}
else{
$return = 'submit';
$from = 'bids';
}

	//echo "<pre>"; print_r($this->lists);
?>
	<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
	<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
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
			hasChecked = hasChecked+1;
			}
		}
	   if(pressbutton)
		{form.task.value=pressbutton;}

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

		form.submit();
	}
	function change (id,status,userid,industryid,rfpstatus,rfpapproval,search)
	{
		SqueezeBox.initialize({});
		if(status==2){
			el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=rfp&task=proposal_reject&id='+id+'&status='+status+'&industryid='+industryid+'&rfpstatus='+rfpstatus+'&rfpapproval='+rfpapproval+'&search='+search+'&userid='+userid;
			var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 600, y:450}}"))
			SqueezeBox.fromElement(el,options);
			} else  {
			location.href='index2.php?option=com_camassistant&controller=rfp&task=change_bidstatus&id='+id+'&status='+status+'&industryid='+industryid+'&rfpstatus='+rfpstatus+'&rfpapproval='+rfpapproval+'&search='+search+'&rfp_id=<?PHP echo $rfp_id ?>';
			}
		//form.submit();
	}
function loginas(username,password){
document.getElementById('username').value = username;
document.getElementById('passwd').value = password;
document.forms["com-form-login"].submit();
}
function updatestatus(id){
document.forms["statusform"].submit();
}
function deleterfpnotes(rfpid, id){
var del = confirm("Are you sure you want to delete this RFP NOTE?");
if(del == true){
G.post("index2.php?option=com_camassistant&controller=rfp&task=deleterfpnotes&tmpl=component&id="+id+"", {rfpid: ""+rfpid+""}, function(data){
if(data == 'success'){
alert("NOTE deleted successfully.");
location.reload();
}
else{
alert("Please try again");
}
});

}
else{
}
}

function deleteovernotes(rfpid, id){
var del = confirm("Are you sure you want to delete this RFP NOTE?");
if(del == true){
G.post("index2.php?option=com_camassistant&controller=rfp&task=deleteoverrfpnotes&tmpl=component&id="+id+"", {rfpid: ""+rfpid+""}, function(data){
if(data == 'success'){
alert("NOTE deleted successfully.");
location.reload();
}
else{
alert("Please try again");
}
});

}
else{
}
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



<form action="<?php  echo $this->request_url; ?>" method="post" name="adminForm" >
<div id="editcell">
	<table>

	<tr height="30px"><td align="left" width="25%"> <strong>  <font color="#FF0000">RFP #</font> <?php echo sprintf('%06d', $rfp_id);  ?>, <font color="#FF0000">RFP NAME:</font> <?php echo $rfp_details->projectName; ?>, <font color="#FF0000">Property Name:</font> <?php echo str_replace('_',' ',$propname->property_name) ; ?>, <font color="#FF0000">Property County:</font> <?php echo $county_name ; ?>, <font color="#FF0000">Property Manager: </font> <a href="javascript:loginas('<?php echo $propname->username ?>','<?php echo $propname->password; ?>');"><?php echo $propname->name.' ' .$propname->lastname; ?></a>, <font color="#FF0000">Camfirm Name: </font><?php echo $cam_name; ?>,<font color="#FF0000">Manager`s Phone Number: </font><?php echo $camname->comp_phno. ' ' .$camname->comp_extnno ; ?>, <font color="#FF0000">RFP closed date to vendor: </font>
	<?php
	$date2= explode('-',$rfp_details->proposalDueDate);
$date= $date2[1];
$month= $date2[0];
$year= $date2[2];
$rfpdate = $year.'-'.$month.'-'.$date;
$redate = strtotime(date("Y-m-d", strtotime($rfpdate)) . "-1 day");   //Adding 1 days to (X) days
$rfpdate = date('m-d-Y', $redate);

	echo $rfpdate.' '.$rfp_details->proposalDueTime; ?> </strong></td>
    <?php
		$db=&JFactory::getDBO();
		$query = "SELECT O.awarded_vendor,O.amount,O.award_date,U.name,U.lastname FROM #__cam_outsidevendor as O LEFT JOIN #__users as U ON U.id= O.cust_id where rfpid=".$rfp_id;
		$db->setQuery($query);
		$outside = $db->loadObjectList();
		//echo "<pre>"; print_r($outside);
		if(count($outside)>0){
		 $amount1 = doubleval(str_replace(",","",$outside[0]->amount));
	     $amount = number_format($amount1,2,'.','');
		 $amount_win = number_format($amount,2);
		echo "<td align='left' style='color:red; font-size:14px; font-weight:bold;'>".$outside[0]->awarded_vendor."&nbsp;(out side vendor) Awarded on ".$outside[0]->award_date." to ".$outside[0]->name."&nbsp;&nbsp;".$outside[0]->lastname." for $".$amount_win.".</td>";
		} else {
			for ($i=0, $n=count( $this->bids ); $i < $n; $i++)
			{
			$row = &$this->bids[$i];
			if($row->proposaltype == 'Awarded' ||  $row->proposaltype == 'awarded'){
			echo "<td align='left' style='color:red; font-size:14px; font-weight:bold;'>Proposal Number ".$row->id." Awarded on ".$row->awardeddate." to ".$row->name."&nbsp;&nbsp;".$row->lastname." of ".$row->company_name." for $".$row->proposal_total_price.".</td>";
			}
			//echo "<pre>"; print_r($row);
			}
	}
	 ?>


</tr>
		<?php /*?><tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->search;?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
		</tr><?php */?>
	</table>
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' );  ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th class="title" align="left">
			<?php echo JText::_( 'Notes' );  ?>
		   <?php  //echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
		   <?php  echo sort1('Proposal #', 'P.id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
					<th class="title" align="left">
					<?php echo JText::_( 'Company Name' );  ?>
		   <?php  //echo sort1('UserId #', 'U.id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
					<?php echo JText::_( 'Phone Number' );  ?>
		   <?php  //echo sort1('UserId #', 'U.id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
					<?php echo JText::_( 'Alternate Number' );  ?>
		   <?php  //echo sort1('UserId #', 'U.id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
					<?php echo JText::_( 'Cell Number ' );  ?>
		   <?php  //echo sort1('UserId #', 'U.id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
			   <?php  echo 'Contact Name' ; ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Email' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'CC: E-mails' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Proposeddate' );  ?>
     		  <?php  //echo sort1('Proposeddate', 'P.proposeddate', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
				 <?php echo JText::_( 'Proposal Total Price' );  ?>
     		  <?php  //echo sort1('Proposal Total Price', 'P.proposal_total_price', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
			  <?php echo JText::_( 'Commission' );  ?>
     		  <?php  //echo sort1('Commission', 'P.commission', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Alt-Bid' );  ?>
     		  <?php  //echo sort1('Alt-Bid', 'P.Alt_bid', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
     		  <?php  echo sort1('Status', 'P.proposaltype', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
     		 Action
			</th>
			<th class="title" align="left">
     		 Login As
			</th>
	</thead>

	<?php

	$k = 0;
	for ($i=0, $n=count( $this->bids ); $i < $n; $i++)
	{
		$row = &$this->bids[$i];
       //echo "<pre>"; print_r($row);
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=edit&cid[]='. $row->id );
			//echo 'status------'.$row->published;
		$img 	= $row->published ? 'publish_x.png' : 'tick.png';
		$task 	= $row->published ? 'unblock' : 'block';
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$j = $row->user_id;
		$published 	= JHTML::_('grid.published', $row, $i);


		?>
		<tr class="<?php echo "row$k";  ?>">
			<td>
				<?php echo $i+1;//echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<?php
			//To get the count of notes
			$db=&JFactory::getDBO();
		$query = "SELECT count(id) as cnt FROM #__cam_adminnotes where prop_id=".$row->id." and rfp_id=".$row->rfpno." and vendor_id=".$row->proposedvendorid." ";
		$db->setQuery($query);
		$countofnotes = $db->loadResult();
			?>
			<td align="center" width="55"><?php if($row->Alt_bid == '') { ?><a href="index.php?option=com_camassistant&controller=rfp&task=vendor_notes&vendorid=<?PHP echo $row->proposedvendorid; ?>&rfpid=<?php echo $rfp_id; ?>&prop_id=<?php echo $row->id;?>&from=<?php echo $from; ?> "> NOTES <font color="#FF0000">(<?php echo $countofnotes; ?>)</font></a> <?php } ?>
			</td>
			<td align="center"><?php echo $row->id; ?>
			</td>
			<td align="center">
			<?php 
				if($row->suspend == 'suspend' && $row->flag == 'flag') {$font = "red"; }
				else if($row->flag == 'flag') { $font = "#ff9900"; }
				else if($row->suspend == 'suspend') { $font = "red"; }
				else { $font = ''; }
				?> 
			<a target="_blank" title="Click a vendor name to edit it" href="index.php?option=com_camassistant&controller=vendors_detail&task=edit&cid[]=<?php echo $row->vendor_id;  ?>"><font color="<?php echo $font; ?>"><?php echo $row->company_name; ?></font></a>
			</td>
			<td align="center"><?php echo $row->company_phone; ?>
			</td>
			<td align="center"><?php echo $row->alt_phone; ?>
			</td>
			<td align="center"><?php echo $row->cellphone; ?>
			</td>
			<?php /*?><td><a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Click a customer name to edit it' ); ?>">
				<?php echo $row->projectName; ?></a>
			</td><?php */?>
			<td align="center">
			<?php 
			if($row->contact_name) {
			echo $row->contact_name ;
			}
			else {
				if($row->Alt_bid == 'yes') {
				$db=&JFactory::getDBO();
				$query_c = "SELECT contact_name FROM #__cam_vendor_proposals where rfpno=".$row->rfpno." and proposedvendorid=".$row->proposedvendorid." and Alt_bid='' ";
				$db->setQuery($query_c);
				$altname = $db->loadResult();
				echo $altname;
				}
			 	else{
				echo $row->name.' '.$row->lastname ;
				}
			} 	?>
			</td>
			<td align="center">
				<?php echo $row->email; ?>
			</td>
			<td align="center">
				<?php echo $row->ccemail; ?>
			</td>
			<td align="center">
				<?php echo $row->proposeddate; ?>
			</td>
			<td align="center">
				<?php echo $row->proposal_total_price; ?>
			</td>
			<td align="center">
				<?php echo $row->commission; ?>
			</td>
			<td align="center">
				<?php  if($row->Alt_bid == '') echo 'Primary'; else echo $row->Alt_bid; ?>
			</td>
			<td align="center">
			<?php 
				
				$invited = "SELECT id FROM #__rfp_invitations  WHERE  rfpid=".$rfp_id." AND vendorid=".$row->proposedvendorid;
					$db->setQuery($invited);
					$invitation = $db->loadResult();
					
					if($invitation && ($row->bidfrom == 'admin')){
						$invited_a = "SELECT DISTINCT not_interested FROM #__cam_vendor_availablejobs  WHERE  rfp_id=".$rfp_id." AND user_id=".$row->proposedvendorid;
						$db->setQuery($invited_a);
						$inv = $db->loadResult();
						if($inv == '2'){
						$row->proposaltype = "Declined";
						}
						else {
						$row->proposaltype =  "Invited" ;
						}
					
					}
					else if($invitation && ($row->bidfrom == '') && $row->proposaltype == ''){
					echo "Invited";
					}
					else{
					 $row->proposaltype = $row->proposaltype ;
					 }
					  if($row->proposaltype == 'ITB')
						{$stat = 'Draft'; echo $row->proposaltype;}
					  else if($row->proposaltype == 'review' || $row->proposaltype == 'Draft')
						{$stat = 'Draft'; echo 'Draft';}
				      else if($row->proposaltype == 'Submit' || $row->proposaltype == 'resubmit')
					  	{ $stat = 'Submit';
						?> <select name="publish" onchange="javascript:change('<?php echo $row->id; ?>',this.value,'<?PHP echo $row->proposedvendorid; ?>','<?php echo $_REQUEST['industryid']; ?>','<?php echo $_REQUEST['rfpstatus']; ?>','<?php echo $_REQUEST['rfpapproval']; ?>','<?php echo $_REQUEST['search']; ?>');">

			<option value="0" <?php if( $row->publish=='0') { ?> selected="selected" <?php } ?>  >Pending</option>
			<option value="1" <?php if( $row->publish=='1') { ?> selected="selected" <?php } ?> >Approve</option>
			<option value="2" <?php if( $row->publish=='2') { ?> selected="selected" <?php } ?> >Reject</option>
		</select>
		<?PHP }
					  else echo $row->proposaltype;
				?>
			</td>
			<td align="center">
				<a href="index.php?option=com_camassistant&controller=proposals&Alt_Prp=<?PHP echo $row->Alt_bid; ?>&task=Proposal_edit&Proposal_id=<?php echo $row->id; ?>&vendorid=<?PHP echo $row->proposedvendorid; ?>&rfp_id=<?php echo $row->rfpno; ?>&industryid=<?php echo $_REQUEST['industryid']; ?>&rfpstatus=<?php echo $_REQUEST['rfpstatus']; ?>&rfpapproval=<?php echo $_REQUEST['rfpapproval']; ?>&search=<?php echo $_REQUEST['search']; ?>&act=<?PHP echo $stat; ?> ">Edit</a>
			</td>
			<td align="center">
			<a href="javascript:loginas('<?php echo $row->username ?>','<?php echo $row->password; ?>');">Login As</a></td>
			<?php /*?><td align="center" >

			<?PHP  if($row->publish == '0') echo 'Inactive';  else if($row->publish == '1') { echo 'Active'; } ?>
			</td><?php */?>

		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
<tfoot>
		<td colspan="20">
			<?php //echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
	</table>
</div>

<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="task" value="rfp_bids" />
<input type="hidden" name="user_id" value="<?PHP echo $this->bids[0]->proposedvendorid?>" />
<input type="hidden" name="rfp_id" value="<?PHP echo $rfp_id; ?>" />
<input type="hidden" name="boxchecked" value="0" />
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


<br /><br />
<div id="toolbar-box">
<div class="t">
<div class="t">
<div class="t"></div>
</div>
</div>
<div class="m">
<div id="toolbar" class="toolbar">
<table class="toolbar"><tbody><tr>
<td id="toolbar-html" class="button"><a style="text-decoration: none;" class="modal" rel="{handler: 'iframe', size: {x: 1000, y: 650}}" href="index2.php?option=com_camassistant&controller=rfp&task=addrfpnotes&rfpid=<?php echo $_REQUEST['rfp_id']; ?>"><img src="images/new.jpg" /></a></td>
<td id="toolbar-delete" class="button"></td>
<td id="toolbar-back" class="button">
</td>
</tr></tbody></table>
</div>
<div class="header icon-48-generic" style="margin-left:0px;">
RFP NOTES
</div>
<div class="clr"></div>
</div>
<div class="b">
<div class="b">
<div class="b"></div>
</div>
</div>
</div>
	<table class="adminlist">
	<thead><tr>
	<th align="left" class="title">Related To</th>
	<th align="left" class="title">Comment</th>
	<th align="left" class="title">Submitted Date</th>
	<th align="left" class="title">Author</th>
	<th align="center" class="title">Delete</th>
	</tr></thead>

<tbody>
<?php for($no=0; $no<count($this->rfpnotes); $no++) { ?>
<td align="center" width="170"><?php if($this->rfpnotes[$no]->vendor_id == 'm'){ echo "Manager";  } else if($this->rfpnotes[$no]->vendor_id == '0'){ echo "General"; } else { echo $this->rfpnotes[$no]->company_name; }?></td>
<td align="center" width="930"><?php echo html_entity_decode($this->rfpnotes[$no]->comment); ?></td>
<td align="center"><?php echo $this->rfpnotes[$no]->notes_date ; ?></td>
<td align="center"><?php echo $this->rfpnotes[$no]->author; ?></td>
<td align="center"><a href="javascript:deleterfpnotes(<?php echo $this->rfpnotes[$no]->rfp_id ; ?>, <?php echo $this->rfpnotes[$no]->id; ?>);">Delete</a></td>
</tr>
<?php } ?>
</tbody>
<tfoot>
		<tr><td colspan="20">
					</td>
	</tr></tfoot>
	</table>


<br /><br />
<div id="toolbar-box">
<div class="t">
<div class="t">
<div class="t"></div>
</div>
</div>
<div class="m">
<div id="toolbar" class="toolbar">
<table class="toolbar"><tbody><tr>
<td id="toolbar-html" class="button"><a href="javascript:void(0);" onclick="javascript:updatestatus(<?php echo $_REQUEST['rfp_id']; ?>);"><img src="images/save_jobnotes.jpg" /></a></td>
<td id="toolbar-delete" class="button"></td>
<td id="toolbar-back" class="button">
</td>
</tr></tbody></table>
</div>
<div class="header icon-48-generic" style="margin-left:0px;">
JOB STATUS
</div>
<div class="clr"></div>
</div>
<div class="b">
<div class="b">
<div class="b"></div>
</div>
</div>
</div>
<table class="adminlist">
<tbody>
<tr><td colspan="2">
<form name="statusform" id="statusform" method="post" action="index.php?option=com_camassistant&controller=rfp&task=updatejobstatus&rfpid=<?php echo $_REQUEST['rfp_id']; ?>">
<textarea name="rfp_adminstatus" style="width:800px; height:150px" ><?php echo $rfp_details->rfp_adminstatus ; ?></textarea>
<input type="hidden" value="<?php echo str_replace('/live/administrator/','',$_SERVER["REQUEST_URI"]); ?>" name="returnurl" />
</td></tr>
</form>
</tbody>

	</table>