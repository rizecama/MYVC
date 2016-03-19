<?php
error_reporting(0);
defined('_JEXEC') or die('Restricted access');

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');

// import html tooltips
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
 //echo Juri::root(); ?>

<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>

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
function urgent(rfpid, type){
G.post("index2.php?option=com_camassistant&controller=rfp&task=geturgent&tmpl=component&type="+type+"", {rfpid: ""+rfpid+""}, function(data){
if(data == 'success'){
alert("Urgency updated successfully");
location.reload();
}
else{
alert("Please try once again");
}
});

}


function assignedadmin(rfp,adminid){
G.post("index2.php?option=com_camassistant&controller=rfp&task=getassigned&tmpl=component&adminid="+adminid+"", {rfpno: ""+rfp+""}, function(data){
if(data == 'success'){
alert("Assigned successfully");
}
else{
alert("Please try once again");
}
});

}

function getindi(id){
G("#abc"+id).toggle();
}
function getallnotes(id){
if(id=='show') {
<?php for($all=0; $all<count($this->items ); $all++) { ?>
document.getElementById("abc"+<?php echo $this->items[$all]->id; ?>).style.display = '';
<?php }
?>
}
else{
<?php for($all=0; $all<count($this->items ); $all++) { ?>
document.getElementById("abc"+<?php echo $this->items[$all]->id; ?>).style.display = 'none';
<?php }
?>

}
}

function savecomment(id){
var comment1 = document.getElementById("comment1"+id).value;
var rfpid1 = document.getElementById("id1"+id).value;
var author = document.getElementById("author").value;
var related = document.getElementById("vendor_id"+id).value;

if(comment1 == ''){
alert("Please enter some notes");
}
else {
	G.post("index2.php?option=com_camassistant&controller=rfp&task=addcomments", {cmt: ""+comment1+"", rfpid: ""+rfpid1+"",  author: ""+author+"", related: ""+related+""}, function(data){

	if(data == 'success'){
	alert("Notes added successfully");
	location.reload();
	}
	else{
	alert("Please try again");
	}
	});
	}
}
function loginas(username,password){
document.getElementById('username').value = username;
document.getElementById('passwd').value = password;
document.forms["com-form-login"].submit();
}
function closerfp(rfpid){
var r=confirm("Are you sure you want to End Bidding?")
if (r==true)
{
G.post("index2.php?option=com_camassistant&controller=rfp&task=endbiddingrfp", {rfpid: ""+rfpid+""}, function(data){
if(data == 'success'){
alert("RFP closed successfully.");
document.getElementById(rfpid).style.display = 'none';
}
	});
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
<option value="submitclosed" <?php if($_REQUEST['rfpstatus']=='submitclosed') { ?> selected="selected" <?php } ?> >Submitted & Closed</option>
<option value="draft" <?php if($_REQUEST['rfpstatus']=='draft') { ?> selected="selected" <?php } ?>>Draft</option>
<option value="closed" <?php if($_REQUEST['rfpstatus']=='closed') { ?> selected="selected" <?php } ?>>Closed</option>
<option value="awarded" <?php if($_REQUEST['rfpstatus']=='awarded') { ?> selected="selected" <?php } ?>>Awarded</option>
<option value="unawarded" <?php if($_REQUEST['rfpstatus']=='unawarded') { ?> selected="selected" <?php } ?>>Canceled</option>
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
			<th width="20">
				<a href="javascript:getallnotes('show');"><?php echo "Show";?></a> <a href="javascript:getallnotes('hide');"><?php echo "Hide";?></a> NOTES
			</th>
			<th class="title" align="left">
		   <?php  echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
		   <?php  echo 'Property Name'; ?>
			</th>
					<th class="title" align="left">
		   <?php  echo sort1('Project Name', 'R.projectName', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>

			<?php if($_REQUEST['rfpstatus']=='rfp') { ?>
			<th class="title" align="left">
			   <?php  echo sort1('County', 'start', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<?php } ?>

			<th class="title" align="left">
     		 <?php  echo sort1('Assigned To', 'assigned', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<?php if($_REQUEST['rfpstatus']=='rfp') { ?>
			<th class="title"><?php  echo sort1('Urg', 'urgency', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th> <?php } ?>

			<?php if($_REQUEST['rfpstatus']!='rfp') { if($_REQUEST['rfpstatus']!='awarded') { ?>
			<th class="title" align="left">
     		  <?php  echo 'Followup date'; ?>
			</th><?php } }?>
			<?php /* ?>
			<th class="title" align="left">
     		  <?php  echo sort1('Created Date', 'R.createdDate', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
     		 Updated date
			</th>
			<?php */ ?>
			

            <?php 
			if($_REQUEST['rfpstatus']=='unawarded' || $_REQUEST['rfpstatus']=='Unawarded'){ ?>
			<th class="title" align="left">
			<?php echo sort1('Closed Date', 'R.proposalDueDate', $this->lists['order_Dir'], $this->lists['order']); ?> </th> <?php
			}
			?>
     		 
			
			
			<th class="title" align="left">
            <?php 
			if($_REQUEST['rfpstatus']=='rfp' || $_REQUEST['rfpstatus']=='draft') {
			echo JHTML::_( 'grid.sort', 'Requested Due Date', 'R.proposalDueDate', $this->lists['order_Dir'], $this->lists['order']);
			} 
			else if($_REQUEST['rfpstatus']=='unawarded' || $_REQUEST['rfpstatus']=='Unawarded'){
			echo 'Canceled Date';
			}
			else { 
           echo sort1('Closed Date', 'R.proposalDueDate', $this->lists['order_Dir'], $this->lists['order']);  
			 } ?>
     		  <?php  //echo sort1('Proposal DueDate', 'R.proposalDueDate', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			
			<?php if($_REQUEST['rfpstatus']=='awarded') { ?>
			<th class="title" align="left">
			Awarded Date
			</th>
			<?php } ?>
			<th class="title" align="left">
     		   <?php  echo sort1('A ITB`s', 'maxProposals', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
     		  U ITB's
			</th>

			<th class="title" align="left">
     		 PPs
			</th>
			<th class="title" align="left">
     		Eligible Vendors
			</th>
			<th class="title"> <?php  echo sort1('Manager Name', 'U.name', $this->lists['order_Dir'], $this->lists['order']);  ?>
		 	</th>

			<th class="title">Phone
		 	</th>
			<th class="title">Email
		 	</th>
			<?php if($_REQUEST['rfpstatus']!='awarded') { ?>			
			<th class="title">RFP Approval
		 	</th>
			<?php } ?>
			<?php if($_REQUEST['rfpstatus']=='closed' || $_REQUEST['rfpstatus']=='rfp'|| $_REQUEST['rfpstatus']=='draft' || $_REQUEST['rfpstatus']=='awarded'){ ?>
			<th class="title">P Report</th>
			<?php } ?>
			<?php if($_REQUEST['rfpstatus']=='awarded') { ?>
			<th class="title">Awarded To
		 	</th>
			<?php } ?>
			
			<?php if($_REQUEST['rfpstatus']=='rfp' && $_REQUEST['rfpapproval'] == '1') { ?>
			<th class="title">End Bidding
		 	</th>
			<?php } ?>


	</thead>
<?php $industryid =  JRequest::getVar('industry_id');
	$rfpstatus =  JRequest::getVar('rfpstatus');
	$rfpapproval =  JRequest::getVar('rfpapproval');
	$search =  JRequest::getVar('search');
 //  echo '<pre>'; print_r($_REQUEST); ?>
	<?php

	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{

		$row = &$this->items[$i];
       // echo '<pre>'; print_r($row);
		$db = JFactory::getDBO();
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=edit_rfp_form&task=edit&cid[]='. $row->id );
		$sql = "select count(proposedvendorid)  FROM #__cam_vendor_proposals as V LEFT JOIN #__users as U ON U.id=V.proposedvendorid where  V.Alt_bid != 'yes' AND V.proposedvendorid=U.id and V.rfpno =".$row->id;
		$db->Setquery($sql);
		if($db->loadResult() == '')
		$row->Bids = 0;
		else
		$row->Bids = $db->loadResult();
		//To get the invitations before approve the rfp
			if($row->publish == 0){
			$sql_inv = "select count(vendorid)  FROM #__rfp_invitations  where  rfpid =".$row->id;
			$db->Setquery($sql_inv);
				if($db->loadResult() == '')
				$row->Bids = 0;
				else
				$row->Bids = $db->loadResult();
			}
			//Completed
		//For submitted proposals
		$sql_submit = "select count(proposedvendorid)  FROM #__cam_vendor_proposals as V LEFT JOIN #__users as U ON U.id=V.proposedvendorid where  (V.proposaltype='Submit' OR V.proposaltype='resubmit') AND V.Alt_bid != 'yes' AND V.proposedvendorid=U.id AND  V.rfpno =".$row->id;
		$db->Setquery($sql_submit);
		if($db->loadResult() == '')
		$row->Bids = 0;
		else
		$row->submittedITBs = $db->loadResult();
		$submitbid_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&var=submit&rfp_id='. $row->id.'&industryid='.$industryid.'&rfpstatus='.$rfpstatus.'&rfpapproval='.$rfpapproval.'&search='.$search );
		//Completed
		//For awarded proposals
		if($_REQUEST['rfpstatus'] == 'awarded' ){
		$sql_submit = "select count(proposedvendorid)  FROM #__cam_vendor_proposals as V LEFT JOIN #__users as U ON U.id=V.proposedvendorid where  (V.proposaltype='Awarded' OR V.proposaltype='Unawarded') AND V.Alt_bid != 'yes' AND V.proposedvendorid=U.id AND  V.rfpno =".$row->id;
		$db->Setquery($sql_submit);
		if($db->loadResult() == '')
		$row->Bids = 0;
		else
		$row->submittedITBs = $db->loadResult();
		$submitbid_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&var=submit&rfp_id='. $row->id.'&industryid='.$industryid.'&rfpstatus='.$rfpstatus.'&rfpapproval='.$rfpapproval.'&search='.$search );
		}
		//Completed
		$sql1 = "select count(proposedvendorid)  FROM #__cam_vendor_proposals as V LEFT JOIN #__users as U ON U.id=V.proposedvendorid where  V.Alt_bid != 'yes' AND V.proposedvendorid=U.id AND (V.proposaltype='Submit' OR V.proposaltype='resubmit') AND V.rfpno =".$row->id;
		$db->Setquery($sql1);
		$Bids1 = $db->loadResult();
      // echo "<pre>"; print_r($_REQUEST);
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=edit&cid[]='. $row->id.'&industryid='.$industryid.'&rfpstatus='.$rfpstatus.'&rfpapproval='.$rfpapproval.'&search='.$search );
		if($_REQUEST['rfpapproval'] == 0){
		$bid_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&types=pendingrfps&rfp_id='. $row->id.'&industryid='.$industryid.'&rfpstatus='.$rfpstatus.'&rfpapproval='.$rfpapproval.'&search='.$search );
		}
		else {
		$bid_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&rfp_id='. $row->id.'&industryid='.$industryid.'&rfpstatus='.$rfpstatus.'&rfpapproval='.$rfpapproval.'&search='.$search );
		}
		$submitbid_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&var=submit&rfp_id='. $row->id.'&industryid='.$industryid.'&rfpstatus='.$rfpstatus.'&rfpapproval='.$rfpapproval.'&search='.$search );
			//echo 'status------'.$row->published;
		$img 	= $row->published ? 'publish_x.png' : 'tick.png';
		$task 	= $row->published ? 'unblock' : 'block';
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$j = $row->user_id;
		$published 	= JHTML::_('grid.published', $row, $i);
	//To get the property owner email
	$sql_pemail = "select u.email,u.name,u.lastname,v.divcounty, v.property_name  FROM #__users as u, #__cam_property as v where u.id=v.property_manager_id and v.id=".$row->property_id." ";
		$db->Setquery($sql_pemail);
		$mail = $db->loadObject();
	//Completed
//To Get the county name
	$c_name = "SELECT County FROM #__cam_counties WHERE  id='".$mail->divcounty."'";
	$db->setQuery($c_name);
	$county_name = $db->loadResult();
//echo "<pre>"; print_r($row);
		?>
		<tr class="<?php echo "row$k";  ?>" id="<?php echo $row->id; ?>">
			<td>
				<?php echo $i+1; //echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td align="center"><a href="javascript:getindi(<?php echo $row->id?>);">NOTES</a>
			</td>
			<td align="center"><a href="<?php echo $link; ?>"><?php echo sprintf('%06d', $row->id);  ?></a>
			</td>

			<td align="center"><?php echo str_replace('_',' ',$mail->property_name); ?>
			</td>

			<td align="center"><?php echo $row->projectName; ?>
			</td>

			<?php if($_REQUEST['rfpstatus']=='rfp') { ?>
			<td align="center">
				<?php echo $county_name ; ?>
			</td>
			<?php } ?>
			<td align="center">
				<?php
				if($row->followupdate == ''){
				$date2= explode('-',$row->proposalDueDate);
				$rfpdate = $date2[2].'-'.$date2[0].'-'.$date2[1];
				$redate_sat = date('m-d-Y', strtotime($rfpdate . "14 day"));   //Adding 14 days to (X) days
				}
				else{
				$redate_sats = $row->followupdate;
				$redate = $row->followupdate;
				$redatee  = explode(' ',$redate);
				$redate_sat = $redatee[0].' '.$redatee[1];
				} ?>
				<script type="text/javascript">
				H = jQuery.noConflict();
				H('.datepicker').datepicker({
				showOn: "button",
				buttonImage: "images/calendar.gif",
				buttonImageOnly: true
			});
				</script>
<select name="mainadmin" onchange="javascript: assignedadmin('<?php  echo $row->id; ?>', this.value)">
<option value="0">--</option>
<?php for($ma=0; $ma<count($this->mainadmins); $ma++ ){ ?>
<option value="<?php echo $this->mainadmins[$ma]->value?>" <?php if($row->assigned == $this->mainadmins[$ma]->value) { echo "selected"; } ?>>
<?php

if($this->mainadmins[$ma]->text == 'Eric Ciccotelli '){ $name = 'EC';}
else if($this->mainadmins[$ma]->text == 'John '){ $name = 'JB'; }
else if($this->mainadmins[$ma]->text == 'Gerry Coeppicus '){ $name = 'GC'; }
else if($this->mainadmins[$ma]->text == 'jgarvin '){ $name = 'JG'; }
else if($this->mainadmins[$ma]->text == 'Allen Borza '){ $name = 'AB'; }
echo $name; ?>
	</option>
<?php } $redatee[2] ='';?>

			</td>
			<?php if($_REQUEST['rfpstatus']!='rfp') { if($_REQUEST['rfpstatus']!='awarded') { ?>
			<td align="center"> 
				<a id="defaultcal"  style="text-decoration: none;" mce_style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 600, y: 450}}" href="index2.php?option=com_camassistant&controller=rfp&task=followdate&date=<?php echo $redate_sats; ?>&id=<?php echo $row->id; ?>" ><?php echo $redate_sat; ?></a>
			</td>
			<?php } }?>
			<?php if($_REQUEST['rfpstatus']=='rfp') {
			if($row->urgency == '') $style="#ffffff" ;
			if($row->urgency == 'low') $style="#ffff00" ;
			if($row->urgency == 'medium') $style="#ff9900" ;
			if($row->urgency == 'high') $style="#FF0000" ;
			if($row->urgency == 'done') $style="green" ;
			 ?>
			<td align="center" style="background:<?php echo $style; ?>">
			<select name="urgency" onchange="javascript: urgent('<?php  echo  $row->id; ?>', this.value)" >
			<option <?php if($row->urgency == '') echo "selected";  ?> value="" style="color:#000000;"> -- </option>
			<option <?php if($row->urgency == 'low') echo "selected";  ?> value="low" style="color:#ffff00;">LO</option>
			<option <?php if($row->urgency == 'medium') echo "selected";  ?> value="medium" style="color:#ff9900;">MD</option>
			<option <?php if($row->urgency == 'high') echo "selected";  ?> value="high" style="color:#FF0000;">HI</option>
			<option <?php if($row->urgency == 'done') echo "selected";  ?> value="done" style="color:green;">OK</option></select>
			</td>
			<?php } ?>
			<?php /* ?><?php if($_REQUEST['rfpstatus']!='rfp') { ?>
			<td align="center">
				<?php echo $row->createdDate; ?>
			</td>
			<td align="center">
				<?php echo $row->update_date; ?>
			</td>
			<?php } ?><?php */ ?>
			
			
				<?php
				   if($_REQUEST['rfpstatus']=='unawarded' || $_REQUEST['rfpstatus']=='Unawarded') { 
							?><td align="center"><?php echo $row->biddingcloseddate; ?></td>&nbsp;<?php 
						} 
					?> 
			
			
			<td align="center">
				<?php
			 	if($_REQUEST['rfpstatus']=='rfp' || $_REQUEST['rfpstatus']=='draft' || $_REQUEST['rfpstatus']=='closed' ) 
						{ 
							echo $row->proposalDueDate; ?>&nbsp;<?php echo $row->proposalDueTime; 
						} 
				elseif($_REQUEST['rfpstatus']=='')
						{
							if($row->rfp_type == 'draft' || $row->rfp_type == 'rfp')
								{
								echo ""; 						
								}
							else{
								echo $row->biddingcloseddate; ?>&nbsp;<?php //echo //$row->proposalDueTime;  	
								}	
						}
				   else { 
							echo $row->proposalDueDate; ?>&nbsp;<?php //echo $row->proposalDueTime;  
						} 
					?> 
			</td>
			<?php if($_REQUEST['rfpstatus']=='awarded') { ?>
			<td align="center">
				<?php echo $row->awardeddate; ?>
			</td>
			<?php } ?>
			<td align="center">
				<?php echo $row->maxProposals; ?>
			</td>
			<td align="center"><a target="blank" href="<?php echo $bid_link; ?>" title="<?php echo JText::_( 'Click a customer name to edit it' ); ?>">
				<?php echo $row->Bids; ?></a>
			</td>

			<td align="center"><a target="blank" href="<?php echo $submitbid_link.'&from=primary'; ?>"><?php echo $row->submittedITBs; ?></a></td>
			<?php //$el_link= 'index.php?option=com_camassistant&controller=rfp&task=eligible_vendors&rfpid='.sprintf('%06d', $row->id).'&industry_id='.$industryid.'&rfpstatus='.$rfpstatus.'&rfpapproval='.$rfpapproval.'&search='.$search
             $el_link= 'index.php?option=com_camassistant&controller=rfp&task=itb_tool&rfp_id='.sprintf('%06d', $row->id).'&industry_id='.$industryid.'&rfpstatus='.$rfpstatus.'&rfpapproval='.$rfpapproval.'&search='.$search
                     ?>
            <td align="center"><a target="blank" href="<?php echo $el_link; ?>">eligible vendors</a></td>
			<td align="center">
			<a href="javascript:loginas('<?php echo $row->username ?>','<?php echo $row->password; ?>');">	<?php echo $row->name.' '.$row->lastname; ?></a>
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
			<?php if($_REQUEST['rfpstatus']=='awarded') { ?>
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

		if($row->id=='550494') {
		$query_two = "SELECT U.company_name FROM #__cam_vendor_proposals as V, #__cam_vendor_company as U WHERE V.rfpno=".$row->id." and V.proposedvendorid = U.user_id and V.proposaltype = 'Awarded'";
		$db->setQuery($query_two);
		$a_prs = $db->loadObjectList();
		$vcname = $a_prs[0]->company_name .', '.$a_prs[1]->company_name;
		echo $vcname;

		}

		else{
		if($outside){
		echo $outside.' '.'(O)';
		} else  {
		echo $finalname;
		}

		}
		 }



		  else {
		 echo "N/A";
		 }
		 }
		  ?>
			</td>
            <td><?php if($row->rfp_type=='closed' || $row->rfp_type=='rfp'|| $row->rfp_type=='draft'){ ?>
			<?php  //if($row->id == '417418' || $row->id == '254939' || $row->id == '173606'){ ?>
			<!--<a id="dproposal" href='https://camassistant.com/live/administrator/components/com_camassistant/assets/rfp/RFP<?php echo $row->id ; ?>.zip'>CPSR</a>	-->
			<?php //} else { ?>
			<a id="dproposal" href='javascript:popup_proposal_summary1("<?PHP echo $row->id; ?>","<?PHP echo $Bids1; ?>");'>CPSR</a>
			<?php //} ?>
			<?php   } ?></td>
			<?php if($_REQUEST['rfpstatus']=='rfp' && $_REQUEST['rfpapproval'] == '1') { ?>
			<td><a href="javascript:closerfp('<?php echo $row->id; ?>')">End Bidding</a></td>
			<?php } ?>
		</tr>
		<tr  id="abc<?php echo $row->id; ?>" style="display:none">
		<td colspan="18">
		<table cellpadding="0" cellspacing="0">
		<tr><th align="left"><font color="#FF0000">Related To</font></th><th align="left"><font color="#FF0000">Comment</font></th><th align="left"><font color="#FF0000">Author</font></th><th><font color="#FF0000">Date</font></th></tr>
<?php
$user=&JFactory::getuser();
$rfpnotes = "SELECT * FROM #__cam_adminnotes WHERE  rfp_id='".$row->id."' order by notes_date DESC";
$db->setQuery($rfpnotes);
$rfpnotes = $db->loadObjectList();
for($on=0; $on<count($rfpnotes); $on++) { ?>
<tr style="height:23px;">
<?php
$v_c = "SELECT company_name FROM #__cam_vendor_company WHERE user_id='".$rfpnotes[$on]->vendor_id."'";
$db->setQuery($v_c);
$v_com = $db->loadResult();
?>
<td width="100"><?php if($rfpnotes[$on]->vendor_id == 'm'){ echo "manager"; } else if ($rfpnotes[$on]->vendor_id == '0'){ echo "General"; } else { echo $v_com ; } ?></td>
<td width="800"><?php echo html_entity_decode($rfpnotes[$on]->comment) ; ?></td>
<td width="100"><?php echo $rfpnotes[$on]->author ; ?></td>
<td width="100"><?php echo $rfpnotes[$on]->notes_date ; ?></td>
</tr>
<?php } ?>
</table></td>
<td colspan="10">
<table cellpadding="0" cellspacing="0">
<tr>
</tr>
<tr>
<td><a style="text-decoration: none;" class="modal" rel="{handler: 'iframe', size: {x: 1000, y: 650}}" href="index2.php?option=com_camassistant&controller=rfp&task=addrfpnotes&rfpid=<?php echo $row->id; ?>"><img src="images/new.jpg" /></a></td>
</tr>
</table>
<?php /*?><table cellpadding="0" cellspacing="0">
<tr>
</tr>
<?php
$allps= "SELECT U.company_name,U.user_id as id,P.id as pid FROM #__cam_vendor_company as U LEFT JOIN #__cam_vendor_proposals as P ON P.proposedvendorid=U.user_id WHERE P.rfpno=".$row->id." and P.Alt_bid='' ";
$db->Setquery($allps);
$this->propos = $db->loadObjectList();
?>

<tr>				<td>Related To: </td>
				<td>
<select name="vendor_id" id="vendor_id<?php echo $row->id; ?>"><option value="0">General Note</option><option value="m">Manager</option>
<?php
for($p=0; $p<count($this->propos); $p++ ){ ?>
<option value="<?php echo $this->propos[$p]->id ; ?>"><?php echo $this->propos[$p]->company_name; ?></option>
<?php }?></select>
				</td></tr>
<tr id="newcomment1"><td>Comment</td><td colspan="4"><textarea name="comment1" id="comment1<?php echo $row->id; ?>" style="width:400px; height:120px;"></textarea></td></tr><br />
<input type="hidden" name="id1" id="id1<?php echo $row->id; ?>" value="<?php echo $row->id; ?>"  />
<input type="hidden" value="<?php echo $user->name; ?>" name="author" id="author" />
<tr id="newcomment2"><td></td><td><a href="javascript:savecomment('<?php echo $row->id; ?>');">SAVE</a></td></tr>

<tr height="50"></tr>
<tr>
</tr>
		</table><?php */?>

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

<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $_REQUEST['filter_order']; ?>" />
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