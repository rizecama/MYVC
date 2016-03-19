<?php
	error_reporting(0);
	defined('_JEXEC') or die('Restricted access');
	$ordering = ($this->lists['order'] == 'ordering');
	// import html tooltips
	JHTML::_('behavior.tooltip');
	JHTML::_('behavior.modal');
	$rfp_id = JRequest::getVar('rfp_id','');
    $rfpid =JRequest::getVar('rfpid','');
    if($rfpid){
       $rfp_id=$rfpid;
    }
	$db=&JFactory::getDBO();
	$rfpname = "SELECT projectName, property_id, cust_id, proposalDueDate, proposalDueTime  FROM #__cam_rfpinfo WHERE  id='".$rfp_id."'";
	$db->setQuery($rfpname);
	$rfp_details = $db->loadObject();
	//to get the property name
	$p_name = "SELECT u.property_name, v.name, v.lastname, u.divcounty  FROM #__cam_property as u, #__users as v WHERE  u.id='".$rfp_details->property_id."' and v.id=u.property_manager_id";
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
	// echo "<pre>"; print_r($this->eligible_vendors);
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
function loginas(username,password){
document.getElementById('username').value = username;
document.getElementById('passwd').value = password;
document.forms["com-form-login"].submit();
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
<?php //echo '<pre>'; print_r($this->rfpinfo); ?>
	<tr><td align="left" width="25%"> <strong>  <font color="#FF0000">RFP #</font> <?php echo sprintf('%06d', $rfp_id);  ?>, <font color="#FF0000">RFP NAME:</font> <?php echo $rfp_details->projectName; ?>, <font color="#FF0000">Property Name:</font> <?php echo str_replace('_',' ',$propname->property_name) ; ?>, <font color="#FF0000">Property County:</font> <?php echo $county_name ; ?>, <font color="#FF0000">Property Manager: </font> <?php echo $propname->name.' ' .$propname->lastname; ?>, <font color="#FF0000">Camfirm Name: </font><?php echo $cam_name; ?>, <font color="#FF0000">Manager`s Phone Number: </font><?php echo $camname->comp_phno. ' ' .$camname->comp_extnno ; ?>, <font color="#FF0000">RFP closed date to vendor: </font>
	<?php
	$date2= explode('-',$rfp_details->proposalDueDate);
$date= $date2[1];
$month= $date2[0];
$year= $date2[2];
$rfpdate = $year.'-'.$month.'-'.$date;
$redate = strtotime(date("Y-m-d", strtotime($rfpdate)) . "-1 day");   //Adding 1 days to (X) days
$rfpdate = date('m-d-Y', $redate);

	echo $rfpdate.' '.$rfp_details->proposalDueTime; ?> </strong></td>
	</tr>
<tr height="1px"></tr>
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
			<?php /*?><th class="title" align="left">
			<?php echo JText::_( 'Proposal #' );  ?>
		   <?php  //echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th><?php */?>

			<th class="title" align="left">
				<?php echo JText::_( 'Vendor Name' );  ?>
			   <?php  //echo sort1('First Name', 'U.name', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Email' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left">
				<?php echo JText::_( 'Company Name' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			 <th class="title" align="left">
				<?php echo JText::_( 'Main Number' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
            <th class="title" align="left">
				<?php echo JText::_( 'Alternate Number' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
            <th class="title" align="left">
				<?php echo JText::_( 'Cell Number' );  ?>
     		  <?php // echo sort1('Email', 'U.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<?php /*?><th class="title" align="left">
     		  <?php  echo sort1('Status', 'P.proposaltype', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th><?php */?>
			<th class="title" align="left">
			  <?php echo JText::_( "ITB's" );  ?>
     		  <?php  //echo sort1('Commission', 'P.commission', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
			  <?php echo JText::_( 'Action' );  ?>
     		  <?php  //echo sort1('Alt-Bid', 'P.Alt_bid', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
			  <?php echo JText::_( 'Proposal Centre' );  ?>
     		  <?php  //echo sort1('Alt-Bid', 'P.Alt_bid', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
            <th class="title" align="left">
			  <?php echo JText::_( 'Deficiencies' );  ?>
     		  <?php  //echo sort1('Alt-Bid', 'P.Alt_bid', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>
			<th class="title" align="left">
			  <?php echo JText::_( 'Login As' );  ?>
     		  <?php  //echo sort1('Alt-Bid', 'P.Alt_bid', $this->lists['order_Dir'], $this->lists['order']);  ?>
			</th>

	</thead>
<?php //echo "<pre>"; print_r($this->rfpinfo->cust_id); ?>
	<?php

	$k = 0;

	for ($i=0, $n=count( $this->ineligible_vendors ); $i < $n; $i++)
	{
		$row = &$this->ineligible_vendors[$i][0];
        // echo "<pre>"; print_r($row);
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=edit&cid[]='. $row->proposal_id );
			//echo 'status------'.$row->published;
		$img 	= $row->published ? 'publish_x.png' : 'tick.png';
		$task 	= $row->published ? 'unblock' : 'block';
		//$checked 	= JHTML::_('grid.checkedout',   $row, proposal_id );
		$j = $row->user_id;
		$published 	= JHTML::_('grid.published', $row, $i);
		//echo "<pre>";	print_r($row);

		?>
		<tr class="<?php echo "row$k";  ?>">
			<td>
				<?php echo $i+1; //echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->proposal_id; ?>" name="cid[]" id="cb<?php echo $i; ?>">
				<?php //echo $checked; ?>
			</td>
			<?php /*?><td align="center"><?php echo sprintf('%05d', $row->proposal_id);  ?>
			</td><?php */?>

			<td align="center">
			<a target="_blank" href='index.php?option=com_camassistant&controller=vendors_detail&task=edit&cid[]=<?php echo $row->vid;?>'><?php echo $row->name.'&nbsp;'.$row->lastname; 	?></a>
				<?php /*?> <a title="Click a vendor name to edit it" href="index.php?option=com_camassistant&controller=vendors_detail&task=edit&cid[]=<?php echo $row->vendor_id;  ?>">
			<?php echo $row->name.'&nbsp;'.$row->lastname; 	?></a><?php */?>
			</td>
			<td align="center">
				<a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a>
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
             <td align="center">
				<?php echo $row->company_phone; ?>
			</td>
            <td align="center">
				<?php echo $row->alt_phone; ?>
			</td>
            <td align="center">
				<?php echo $row->cellphone; ?>
			</td>
			<?php /*?><td align="center"><?php echo $row->proposaltype; ?>
			</td><?php */?>
			<td align="center">
				<?php if($row->proposal_id) echo 'Yes'; else echo 'No'?>
			</td>

			<td align="center">
				<?php  if(!$row->proposal_id) { ?> <a href="index.php?option=com_camassistant&controller=rfp&task=resendactivation&rfp_id=<?PHP echo $this->rfpinfo->id; ?>&cust_id=<?php echo $this->rfpinfo->cust_id; ?>&vend_id=<?php echo $row->id;?>&choose_tasks=<?php echo $this->rfpinfo->choose_tasks;?>&email=<?php echo $row->email;?>&property_id=<?php echo $this->rfpinfo->property_id;?>">Resend Job Invitations</a><?php } ?>
			</td>
			<td align="center">
					<?php echo $row->ProposalCentre_status; ?>
			</td>
            <td align="center">
               <?php
               $today = date('Y-m-d');
               $db=&JFactory::getDBO();
            $sql = "SELECT distinct(req_subparentid)  FROM #__cam_rfpreq_info WHERE req_subparentid !=0 AND rfp_id ='".$this->rfp_id."'";
			$db->Setquery($sql);
			$sub = $db->loadObjectList();
$query ="select industry_id from #__cam_vendor_industries Where user_id =".$row->id;
		$db->setQuery($query);
		$getindustryids = $db->loadResultArray();
		if($getindustryids)
		{
		if(in_array('56',$getindustryids))
		$PLN_needed = 'yes';
		else $PLN_needed = 'no';
		}
		else
		$PLN_needed = 'no';
for($s = 0; $s<count($sub); $s++){

//echo '<pre>'; print_r($sub[$s]->req_subparentid);
               $vendor_professional ="SELECT id from #__cam_vendor_professional_license  WHERE PLN_expdate>= '".$today."' and PLN_status = 1 AND vendor_id=".$row->id;
               $db->Setquery($vendor_professional);
               $vendor_prof = $db->loadResult();
                $PLN_cnt = count($vendor_prof); //echo '<br/>';
              //  print_r($PLN_cnt);
               //print_r($sub[$s]->req_subparentid);

               $vendor_occupational ="SELECT id from #__cam_vendor_occupational_license WHERE OLN_expdate>= '".$today."' and OLN_status = 1 AND vendor_id=".$row->id; //validation to status of docs
               $db->Setquery($vendor_occupational);
               $vendor_occu = $db->loadResult();
               $OLN_cnt = count($vendor_occu);


               $vendor_workers_companies = "SELECT id  FROM #__cam_vendor_workers_companies_insurance WHERE WCI_end_date>= '".$today."' and WCI_status = 1 AND vendor_id=".$row->id;
               $db->Setquery($vendor_workers_companies);
               $vendor_workers = $db->loadResult();

                $WCI_cnt = count($vendor_workers);
               // echo '<pre>'; print_r($WCI_cnt);


               $vendor_liability = "SELECT sum(GLI_policy_aggregate)  FROM #__cam_vendor_liability_insurence  WHERE GLI_end_date>='".$today."'and GLI_status = 1 AND vendor_id=".$row->id;
               $db->Setquery($vendor_liability);
               $amount = $db->loadResult();

               $spl_amount="SELECT price FROM #__cam_rfpreq_info WHERE rfp_id='".$this->rfp_id."' and req_subparentid='12'";
               $db->Setquery($spl_amount);
               $amount1 = $db->loadResult();
               $amount2 = doubleval(str_replace(",","",$amount1));
 //print_r($PLN_needed);
                if($PLN_cnt=='0' && $sub[$s]->req_subparentid=='17'){
                   $status ='PL<br/>';
               } else if( $OLN_cnt=='0' && $sub[$s]->req_subparentid=='18'){
                     $status =  'OL<br/>';
               } else if( $WCI_cnt=='0' && $sub[$s]->req_subparentid=='11'){
                      $status ='WC<br/>';
               } else if(($amount2 > $amount||!$amount)&&($sub[$s]->req_subparentid=='12')){
                    $status ='GL';
               } else {
                  $status ='';
               }
             //  echo $row->id;
               $link='index.php?option=com_camassistant&controller=vendorcompliances_details&task=vendor_compliance_docs&userid='.$row->id;
               $st="<a href='$link'>".$status."</a>";
            echo $st;

         }
        ?>
					<?php //echo $row->ProposalCentre_status; ?>
			</td>
			<td align="center">
					<a href="javascript:loginas('<?php echo $row->username ?>','<?php echo $row->password; ?>');">Login As</a>
			</td>
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

<form action="<?php echo JURI::root()."index.php"; ?>" method="post" name="comlogin" id="com-form-login" target="_blank">
<input id="username" name="username" id="username" type="hidden" class="inputbox" alt="username" size="18" value="" />
<input id="passwd" type="hidden" id="passwd" name="passwd" class="inputbox" size="18" alt="password" value="" />
<input type="hidden" name="option"  value="com_user" />
<input type="hidden" name="task"  value="login" />
<input type="hidden" name="view"  value="login" />
<input type="hidden" name="from"  value="adminlogin" />
</form>