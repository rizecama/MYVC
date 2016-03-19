<script type="text/javascript">
function confirm_box(){
var r=confirm("Are you sure you want to remove notes!")
if (r==true)
  {  
  return true;
  }
else
  {
   return false;
  }
}
</script>



<?php

$rfpid = JRequest::getVar('rfpid','');
$ven_id = JRequest::getVar('vendorid','');
$prop_id = JRequest::getVar('prop_id','');
$task = JRequest::getVar('from','');

if($task == 'bids'){
$return = 'rfp';
$from = 'bids';
}
else{
$return = 'submit';
$from = 'primary';
}
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
		
		
	   if(pressbutton == 'back') {
	 //  alert("can");
	
	  window.location = 'index.php?option=com_camassistant&controller=rfp&task=rfp_bids&rfp_id=<?php echo $rfpid; ?>&industryid=&rfpstatus=rfp&rfpapproval=1&search=';
	  //form.submit();
	   }
          if(pressbutton == 'addnew'){
          window.location = "index.php?option=com_camassistant&controller=rfp&task=addnew&rfp_id=<?php echo $rfpid; ?>&vendor_id=<?php echo $ven_id; ?>&prop_id=<?php echo $prop_id;?>";        
          //form.submit();
          }
          
		
	}	

</script>
<form action="index.php?option=com_camassistant&controller=rfp&task=delete" method="post" name="adminForm" id="adminForm" >
<div id="editcell">
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
			<?php echo JText::_( 'Relatedto' );  ?>
		   <?php  //echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
                    <th class="title" align="left">
			<?php echo JText::_( 'comments' );  ?>
		   <?php  //echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
                   <th class="title" align="left">
			<?php echo JText::_( 'submitteddate' );  ?>
		   <?php  //echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			       <th class="title" align="left">
			<?php echo JText::_( 'Author' );  ?>
		   <?php  //echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
<th class="title" align="center">
			<?php echo JText::_( 'Delete' );  ?>
		   <?php  //echo sort1('Rfp #', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
 
			
			
	</thead>	

	<?php
//	echo "<pre>";; print_r($this->vendor_notes );
	$k = 0;
	for ($i=0, $n=count( $this->vendor_notes ); $i < $n; $i++)
	{
		$row = &$this->vendor_notes[$i];
      // echo "<pre>"; print_r($row);
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=editnew&from='.$from.'&rfp_id='.$rfpid.'&vendor_id='.$ven_id.'&prop_id='.$prop_id.'&id='.$row->id);
			//echo 'status------'.$row->published;
		$img 	= $row->published ? 'publish_x.png' : 'tick.png';
		$task 	= $row->published ? 'unblock' : 'block';
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$j = $row->user_id;
		$published 	= JHTML::_('grid.published', $row, $i);		
		$link2=JRoute::_( 'index.php?option=com_camassistant&controller=rfp&task=deletenew&from='.$from.'&rfp_id='.$rfpid.'&vendor_id='.$ven_id.'&prop_id='.$prop_id.'&id='.$row->id);	

		?>
		<tr class="<?php echo "row$k";  ?>">
			<td>
				<?php echo $i+1;//echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<?php
			$db = JFactory::getDBO();
		$cname = 'SELECT company_name from #__cam_vendor_company where user_id="'.$ven_id.'"'; 
		$db->Setquery($cname);
		$cname = $db->loadResult();
			?>
			<td align="center" width="170"><a href="<?php echo $link;?>"><?php echo $cname; ?></a>
			</td>
                         <td align="center" width="930"><?php echo html_entity_decode($row->comment); ?>
			</td>
                        <td align="center" width="110"><?php $date = explode(" ",$row->notes_date);$date1 = $date[0];$date2 = explode("-",$date1) ;
			$date3 = $date2[1].'-'.$date2[2].'-'.$date2[0];
                        echo $date3." ".$date[1];
					
			?>
			</td>
			<td align="center" width="80">
		      <?php echo $row->author; ?>                                                   

			</td>
			<td align="center">
		       <a href="<?php echo $link2;?>" onclick="return confirm_box()">Delete</a>                                                   

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
<input type="hidden" name="rfpid" id="rfpid" value="<?PHP echo $rfpid; ?>" />
<input type="hidden" name="boxchecked" value="0" />

</form>

