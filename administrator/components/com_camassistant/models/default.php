<?php
error_reporting(0);
defined('_JEXEC') or die('Restricted access'); 

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');

// import html tooltips
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');

?>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>

<script language="javascript" type="text/javascript">
G = jQuery.noConflict();

//function to download proposal summary report

function popup_proposal_summary1(rfp_id,bid) 
{
	var chk = document.getElementsByName('cid[]'); 
	var rfp_id=rfp_id;
	var bid=bid;
	if(bid!=0){
	G.post("index2.php?option=com_camassistant&controller=rfp&task=keypath&tmpl=component", {rfpid: ""+rfp_id+""}, function(data){
	
if(data.length >0) {
window.location.href='<?php echo Juri::root(); ?>ziptest.php?directtozip='+data+'&rfpid='+rfp_id+'';
}
});
} else {
alert('There are no Proposals submitted for this RFP.\n We are unable to generate the Zip File.');
}
}

function popup_proposal_summary(rfp_id) 
{
	var chk = document.getElementsByName('cid[]'); 
	
	var targetid = document.getElementById('dproposal');
	targetid.setAttribute('href','<?php echo Juri::root(); ?>index.php?option=com_camassistant&controller=vendors&task=vendor_download_proposals_summary&rfp_id='+rfp_id);
	var newWindow = window.open(targetid.getAttribute('href'), '_blank');
	newWindow.focus();
	//window.location.href='index.php?option=com_camassistant&controller=vendors&task=vendor_proposals_summary&rfp_id='+rfp_id;
	//var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 1000, y:550}}"))
	//SqueezeBox.fromElement(popup,options);
}

function popup_Award_Unaward_summary(rfp_id) 
{
	var chk = document.getElementsByName('cid[]'); 
	
	var targetid = document.getElementById('dproposal');
	targetid.setAttribute('href','<?php echo Juri::root(); ?>index.php?option=com_camassistant&controller=vendors&task=vendor_download_awarded_proposals&rfp_id='+rfp_id);
	var newWindow = window.open(targetid.getAttribute('href'), '_blank');
	newWindow.focus();
	//window.location.href='index.php?option=com_camassistant&controller=vendors&task=vendor_proposals_summary&rfp_id='+rfp_id;
	//var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 1000, y:550}}"))
	//SqueezeBox.fromElement(popup,options);
}
	
function chnage (id,status,industry_id,rfpstatus,search,rfpapproval,email,name,lastname){

SqueezeBox.initialize({});
if(status==2){
el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=rfp&task=rejectform&email='+email+'&name='+name+'&lastname='+lastname+'&id='+id+'&search='+search+'&status='+status+'&industry_id='+industry_id+'&rfpstatus='+rfpstatus+'&rfpapproval='+rfpapproval;
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 600, y:450}}"))
SqueezeBox.fromElement(el,options);

} else {
location.href='index2.php?option=com_camassistant&controller=rfp&task=chnagestatus&id='+id+'&search='+search+'&status='+status+'&industry_id='+industry_id+'&rfpstatus='+rfpstatus+'&rfpapproval='+rfpapproval;
}
}




function rejectform(id){ 

el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=rfp&task=rejectform';
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 600, y:450}}"))
SqueezeBox.fromElement(el,options);
}  
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
	else  if(pressbutton=='itb_tool' && hasChecked != 1)
	 {
	 alert("Please make single selection from the list");
	 return false;
	 }
	 else
	 {
		 if((pressbutton=='deleterfp'))
		 {
		 var r=confirm("Are you sure you want to delete this rfp?");
		if (r==true){
		form.controller.value="rfp";
		form.submit();
		} else {
		return false;
		}
		 }
		form.submit();
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
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter By Project Name' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo htmlspecialchars($_REQUEST['search']);?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('industry_id').value='';this.form.getElementById('rfpstatus').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td><?php $industryList=$this->industryList; ?>
<?php echo JHTML::_('select.genericlist', $industryList, 'industry_id', 'size="1" style="width:283px;" onchange="document.adminForm.submit();" class="inputbox"', 'value', 'text', $_REQUEST['industry_id']);?>

</td>
<td><select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="rfpstatus" name="rfpstatus">
<option selected="selected" value=""> RFP Status </option>
<option value="rfp" <?php if($_REQUEST['rfpstatus']=='rfp') { ?> selected="selected" <?php } ?> >Submitted</option>
<option value="draft" <?php if($_REQUEST['rfpstatus']=='draft') { ?> selected="selected" <?php } ?>>Draft</option>
<option value="closed" <?php if($_REQUEST['rfpstatus']=='closed') { ?> selected="selected" <?php } ?>>Closed</option>
<option value="awarded" <?php if($_REQUEST['rfpstatus']=='awarded') { ?> selected="selected" <?php } ?>>Awarded</option>
<option value="unawarded" <?php if($_REQUEST['rfpstatus']=='unawarded') { ?> selected="selected" <?php } ?>>Unawarded</option>
</select>

</td>
<td><select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="rfpapproval" name="rfpapproval">
<option selected="selected" value=""> RFP Approval </option>
<option value="0" <?php if($_REQUEST['rfpapproval']=='0') { ?> selected="selected" <?php } ?> >Pending</option>
<option value="1" <?php if($_REQUEST['rfpapproval']=='1') { ?> selected="selected" <?php } ?>>Approve</option>
<option value="2" <?php if($_REQUEST['rfpapproval']=='2') { ?> selected="selected" <?php } ?>>Reject</option>
</select>

</td>
		</tr>
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
		   <?php  echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
					<th class="title" align="left">
		   <?php  echo sort1('Project Name', 'DATE_FORMAT(R.projectName)', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
			   <?php  echo sort1('Start Date', 'R.startdate', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
     		  <?php  echo sort1('End Date', 'R.enddate', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
     		  <?php  echo sort1('Created Date', 'R.createdDate', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
     		  <?php  echo sort1('Proposal DueDate', 'R.proposalDueDate', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
     		   <?php  echo sort1('Available ITB`s', 'maxProposals', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
     		  Used ITB's 
			</th>
			<th class="title" align="left">
     		 Primary Proposals
			</th>
			<th class="title" align="left">
     		Eligible Vendors
			</th>
			<th class="title">Manager Name
		 	</th>	 

			<th class="title">Phone
		 	</th>
			<th class="title">Email
		 	</th>	
			<th class="title">RFP Approval
		 	</th> 
			<th class="title">Awarded To
		 	</th> 
			<th class="title">Proposal Report
		 	</th> 
			
			
			
	</thead>	

	<?php
	
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		$db = JFactory::getDBO();
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=edit_rfp_form&task=edit&cid[]='. $row->id );
		$sql = "select count(proposedvendorid)  FROM #__cam_vendor_proposals as V LEFT JOIN #__users as U ON U.id=V.proposedvendorid where  V.Alt_bid != 'yes' AND V.proposedvendorid=U.id and V.rfpno =".$row->id;
		$db->Setquery($sql);
		if($db->loadResult() == '')
		$row->Bids = 0;
		else
		$row->Bids = $db->loadResult();
		//For submitted proposals
		$sql_submit = "select count(proposedvendorid)  FROM #__cam_vendor_proposals as V LEFT JOIN #__users as U ON U.id=V.proposedvendorid where  (V.proposaltype='Submit' OR V.proposaltype='resubmit') AND V.Alt_bid != 'yes' AND V.proposedvendorid=U.id AND  V.rfpno =".$row->id;
		$db->Setquery($sql_submit);
		if($db->loadResult() == '')
		$row->Bids = 0;
		else
		$row->submittedITBs = $db->loadResult();
		$submitbid_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&var=submit&rfp_id='. $row->id );
		//Completed
		
		$sql1 = "select count(proposedvendorid)  FROM #__cam_vendor_proposals as V LEFT JOIN #__users as U ON U.id=V.proposedvendorid where  V.Alt_bid != 'yes' AND V.proposedvendorid=U.id AND (V.proposaltype='Submit' OR V.proposaltype='resubmit') AND V.rfpno =".$row->id;
		$db->Setquery($sql1);
		$Bids1 = $db->loadResult();
      // echo "<pre>"; print_r($_REQUEST);
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=edit&cid[]='. $row->id );
		$bid_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&rfp_id='. $row->id );
		$submitbid_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&var=submit&rfp_id='. $row->id );
			//echo 'status------'.$row->published;
		$img 	= $row->published ? 'publish_x.png' : 'tick.png';
		$task 	= $row->published ? 'unblock' : 'block';
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$j = $row->user_id;
		$published 	= JHTML::_('grid.published', $row, $i);		
			
//echo "<pre>"; print_r($row);
		?>
		<tr class="<?php echo "row$k";  ?>" id="<?php echo $row->id; ?>">
			<td>
				<?php echo $i+1; //echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td align="center"><a href="<?php echo $link; ?>"><?php echo sprintf('%06d', $row->id);  ?></a>
			</td>
			<td align="center"><?php echo $row->projectName; ?>
			</td>
			<?php /*?><td><a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Click a customer name to edit it' ); ?>">
				<?php echo $row->projectName; ?></a>
			</td><?php */?>
			<td align="center">
				<?php echo $row->startDate; ?>
			</td>
			<td align="center">
				<?php echo $row->endDate; ?>
			</td>
			<td align="center">
				<?php echo $row->createdDate; ?>
			</td>
			<td align="center">
				<?php echo $row->proposalDueDate; ?>&nbsp;<?php echo $row->proposalDueTime; ?>
			</td>
			<td align="center">
				<?php echo $row->maxProposals; ?>
			</td>
			<td align="center"><a href="<?php echo $bid_link; ?>" title="<?php echo JText::_( 'Click a customer name to edit it' ); ?>">
				<?php echo $row->Bids; ?></a>
			</td>
			<td align="center"><a href="<?php echo $submitbid_link; ?>"><?php echo $row->submittedITBs; ?></a></td>
            <td align="center"><a href="index.php?option=com_camassistant&controller=rfp&task=eligible_vendors&rfpid=<?php echo sprintf('%06d', $row->id); ?>">eligible vendors</a></td>
			<td align="center">
				<?php echo $row->name.' '.$row->lastname; ?>
			</td>
			<td align="center">
				<?php echo $row->phone; ?>
			</td>
			<td align="center">
				<?php echo $row->email; ?>
			</td>
			<td align="center" > 
			<?php if($row->rfp_type=='rfp'){ //print_r($row->rfp_type);?>
			<select name="status" onchange="javascript:chnage('<?php echo $row->id; ?>', this.value,'<?php echo $_REQUEST['industry_id']; ?>','<?php echo $_REQUEST['rfpstatus']; ?>','<?php echo $_REQUEST['search']; ?>','<?php echo $_REQUEST['rfpapproval']; ?>','<?php echo $row->email; ?>','<?php echo $row->name; ?>','<?php echo $row->lastname; ?>');">
      
			<option value="0" <?php if( $row->publish=='0') { ?> selected="selected" <?php } ?>  >Pending</option>
			<option value="1" <?php if( $row->publish=='1') { ?> selected="selected" <?php } ?> >Approve</option>
			<option value="2" <?php if( $row->publish=='2') { ?> selected="selected" <?php } ?> >Reject</option>
		</select>
			<?PHP }	else {  ?>
				<?php if($row->rfp_type=='review')
				        { echo 'draft'; }
				     else if($row->rfp_type=='closed')
					 { ?> closed: <a id="dproposal" href='javascript:popup_proposal_summary("<?PHP echo $row->id; ?>");'>Download</a>	<?PHP }  
					 else if($row->rfp_type=='Unawarded')
					 { ?> Unawarded: <a id="dproposal" href='javascript:popup_Award_Unaward_summary("<?PHP echo $row->id; ?>");'>Download</a>	<?PHP }  
					 else if($row->rfp_type=='Awarded')
					 { ?> Awarded: <a id="dproposal" href='javascript:popup_Award_Unaward_summary("<?PHP echo $row->id; ?>");'>Download</a>	<?PHP }
				     else { echo $row->rfp_type; } ?>
		<?php 	} //echo "<pre>"; print_r($row); //if($row->publish == '0') echo 'Inactive';  else if($row->publish == '1') { echo 'Active'; } ?>
			</td>
			<td align="center" > 
		<?php if(($row->rfp_type=='Awarded')||($row->rfp_type=='awarded')) { 
		$db=&JFactory::getDBO();
		$query = "SELECT awarded_vendor FROM #__cam_outsidevendor where rfpid=".$row->id;
		$db->setQuery($query);
		$outside = $db->loadResult();
		$query1 = "SELECT U.company_name FROM #__cam_vendor_proposals as V LEFT JOIN #__cam_vendor_company as U ON U.user_id= V.proposedvendorid where V.rfpno=".$row->id." and V.proposaltype='awarded' " ;
		$db->setQuery($query1);
		$name_last = $db->loadObjectList();
		$finalname=$name_last[0]->company_name;
		if($outside){
		echo $outside.' '.'(O)';
		} else  {
		echo $finalname;
		}
		 } else {
		 echo "N/A"; 
		 }
		  ?>
			</td>
           <?php //echo $row->rfp_type; ?>
            <td><?php if($row->rfp_type=='closed' || $row->rfp_type=='rfp'|| $row->rfp_type=='draft'){ ?> <a id="dproposal" href='javascript:popup_proposal_summary1("<?PHP echo $row->id; ?>","<?PHP echo $Bids1; ?>");'>Create Proposal Summary Report</a><?php } ?></td>            
          
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

<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>

