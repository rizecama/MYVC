<?php
//restricted access
defined('_JEXEC') or die('Restricted access');

// import html tooltips
JHTML::_('behavior.tooltip');

?>

	<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'lists') {
				window.location='index.php?option=com_camassistant';
			}
			//var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
			// do field validation
			
			else if(pressbutton == 'apply' || pressbutton == 'save')
			 {
				if (trim(form.property_name.value) == "")
				 {
					alert( "Please enter property name." );
				 }
				 else if ((trim(form.tax_id1.value) == "")&&(trim(form.tax_id2.value) == ""))
				 {
					alert( "Please enter Federal tax number." );
				 }
				
				else if (trim(form.city.value) == "")
				 {
					alert( "Please enter your city" );
				 }
				else if (trim(form.state.value) == "")
				 {
					alert( "Please enter your state" );
				 }
			
				else if (trim(form.zip.value) == "")
				 {
					alert( "Please enter your zipcode" );
				 }
				else{
		tax_two=document.adminForm.elements['tax_id1'].value;
		tax_seven=document.adminForm.elements['tax_id2'].value;
		if(tax_seven){
		taxid = tax_two+'-'+tax_seven;
		}
		else{
		taxid = tax_two;
		}
		
		H.post("index2.php?option=com_camassistant&controller=assignproperty_detail&task=verfirytaxid&pid=<?php echo $this->detail->id; ?>", {queryString: ""+taxid+""}, function(data){
		
		if(data == 'invalid'){
 		alert("You have entered the Tax Identification for an Existing Property");
		H('#tax_id1').val('');
		H('#tax_id2').val('');
		return false;
		}
	else{
	submitform( pressbutton );
	}
		});
	
				 }
		     }
		}
		
	</script>
<link rel="stylesheet" media="all" type="text/css" href="components/com_camassistant/skin1/css/jquery1.css" />		
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>

<script type="text/javascript">
H = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
function county(){
var state = H("#stateid").val();
H.post("index2.php?option=com_camassistant&controller=assignproperty_detail&task=ajaxcounty", {State: ""+state+""}, function(data){
if(data.length >0) {
H("#divcounty").html(data);
H("#divcounty").val('<?php echo $this->detail->divcounty; ?>');
}
});

}
/*function verifytaxid(){
		tax_two=document.adminForm.elements['tax_id1'].value;
		tax_seven=document.adminForm.elements['tax_id2'].value;
		taxid = tax_two+'-'+tax_seven;
		H.post("index2.php?option=com_camassistant&controller=assignproperty_detail&task=verfirytaxid", {queryString: ""+taxid+""}, function(data){
		if(data == 'invalid'){
 		alert("You have entered the Tax Identification for an Existing Property");
		document.adminForm.elements['tax_id1'].value = '';
		document.adminForm.elements['tax_id2'].value = '';
		return false;
		}
	else{
	H('#user-email').html('<font color="green">Property Association Tax ID Number accepted.</font>');
	}
		});
	}*/
	function managers(){
	userid=document.adminForm.elements['property_manager_id'].value;
	H.post("index2.php?option=com_camassistant&controller=assignproperty_detail&task=manager", {userid: ""+userid+""}, function(data){
if(data.length >0) {

H("#custmors").html(data);
H("#custmors").val('<?php echo $this->detail->property_manager_id; ?>');
}
});
	}
  </script>
 
  <?php $tax_id1 = explode('-',$this->detail->tax_id);   //print_r($this->detail);?>
<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="adminForm" id="adminForm">
		<table class="adminheading">
		<tr>
			<th class="content">
			 <small><?php echo $this->detail->id ? 'Edit' : 'Add';?></small> Property
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
		<table>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					Property Details
					</th>
				</tr>
				<tr>
					<td width="250">
					Property Association Name:
					</td>
					<td>
					<input name="property_name" type="text" style="width:275px;" value="<?php echo $this->detail->property_name; ?>" />(*)
					</td>
					
				</tr>
                <tr>
				<?php if( $this->detail->pro_type == 'ass' || $this->detail->pro_type == '' )  { ?>
                <td>Property Association Tax ID Number:</td><td>
					<input id="tax_id1" name="tax_id1" type="text" style="width:25px; text-align:center;" maxlength="2" value="<?php echo $tax_id1[0]; ?>" /> -
					<input id="tax_id2" name="tax_id2" type="text" style="width:90px; text-align:center;" value="<?php echo $tax_id1[1];
					if($tax_id1[2]) echo '-'.$tax_id1[2]; ?>" /><br />
        		</td>
				<?php } else { ?>
				 <td>Property Identification Number:</td><td>
					<input id="tax_id1" name="tax_id1" type="text" style="width:100px; text-align:center;" value="<?php echo $tax_id1[0]; ?>" maxlength="" />
					<input id="tax_id2" name="tax_id2" type="hidden" value="" />
        		</td>
				<?php } ?>
				
				</tr>
				
					<tr>
				<tr>
<td>Number of Units:</td> <td>
<input id="units" name="units" type="text" style="width:100px;" value="<?php echo $this->detail->units; ?>" onblur="unitsno()" />
</td></tr>
                    <td class="key">
                    Property Address:
                    </td>
                    <td colspan="2">
                    <input name="street" type="text" style="width:275px;" value="<?php echo $this->detail->street; ?>"/>
                    </td>
					</tr>
					<tr>
					<td>
					City:
					</td>
					<td>
					<input name="city" type="text" style="width:275px;" value="<?php echo $this->detail->city; ?>" />
					</td>
					</tr>
					<?php //echo "<pre>"; print_r($this->userslist); ?>
					<tr><td>Master/Admin</td><td>
					<?php 
					$p_creator = $this->detail->property_manager_id;
					$firm = $this->detail->camfirmid;
					if($firm == 0){
					$creator = $p_creator;
					}
					else{
					$creator = $firm;
					}
					foreach( $this->userslist as $userslist ) 
					{
					$managerlist[] = JHTML::_('select.option', $userslist->id, $userslist->username);
					}
					$javascript = 'onchange=javascript:managers();';
					$managerlist = JHTML::_('select.genericlist',$managerlist, 'property_manager_id', 'style="width: 276px"' . $javascript , 'value', 'text', $creator);
					echo $managerlist;
					?>
					
					<?php /*?> <select name="property_manager_id" style="width:282px;" id="property_manager_id" >
					<option value="">Select Property Manager</option>
					  <?php 
					  
					for ($j=1; $i<count($this->userslist); $j++){
					$userslist = $this->userslist[$j];
					//$username= $this->userslist[$j][name].$this->userslist[$j][lastname]
					?>
					<option value="<?php echo $userslist->id; ?>" <?php if($this->detail->property_manager_id==$userslist->id){?> selected="selected"<?php } ?> ><?php echo $userslist->username; ?></option>
					<?php } ?>
					</select><?php */?></td></tr>
                    <tr>
                    <td>Manager Name:</td>
                    <td>
                    <select style="width: 252px;" name="custmors" id="custmors" >
					<option value="">Please Select manager</option>
					</select>
                    <script type="text/javascript">
					managers();
					</script>
                    </td></tr>
					<tr>
					<td>
					State:
					</td>
					<td>
                    <select name="state" style="width:282px;" id="stateid" onchange="javascript:county();" >
					<option value="">Select State</option>
					  <?php 
					for ($i=1; $i<count($this->states); $i++){
					$states = $this->states[$i];
					?>
					<option value="<?php echo $states->state_id ?>" <?php if($this->detail->state==$states->state_id){?> selected="selected"<?php } ?> ><?php echo $states->state_name?></option>
					<?php } ?>
					</select>
					</td>
					</tr>
					<tr>
					<td>
					Please Select County:
					</td>
					<td title="This is a general description of the Category">
					<select style="width: 252px;" name="divcounty" id="divcounty" >
					<option value="">Please Select County</option>
					</select>
                    <script type="text/javascript">
					county();
					</script>
					</td>
					</tr>
					<tr>
					<td>
					Zip Code:
					</td>
					<td>
					<input name="zip" type="text" style="width:275px;" value="<?php echo $this->detail->zip; ?>" maxlength="5"/>
					</td>
						</tr>
                        <tr>
					<td>
					Created date:
					</td>
					<td>
					<?php echo $this->detail->createtime; ?>
					</td>
						</tr>
						</table></td></table></tr></table>
<input type="hidden" name="cid[]" value="<?php echo $this->detail->id; ?>" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="controller" value="assignproperty_detail" />
</form>