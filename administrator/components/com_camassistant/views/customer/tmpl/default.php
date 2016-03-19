<?php defined('_JEXEC') or die('Restricted access');

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');
//echo "<pre>"; print_r($_REQUEST);
// import html tooltips
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
?>
<link rel="stylesheet" media="all" type="text/css" href="components/com_camassistant/skin/css/jquery1.css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>

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

	 if((pressbutton=='add'))
	 {
	  form.controller.value="customer_detail";
	  form.submit();
	 }
	else if((pressbutton=='createmaster'))
	 {
	  form.controller.value="customer_detail";
	  form.submit();
	 }
	 else if(pressbutton=='addtomaster' )
	 {
	 	if( hasChecked != 1 ){
		alert("Please make a single selection to add to the master account.");
		return false;
		}
		else{
			el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=customer&task=assignmaster&firmid='+val+'';
			var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 800, y:600}}"))
			SqueezeBox.fromElement(el,options);
			return false;
		}
	 }
	//Remove camfirm from the master
	else if(pressbutton=='removemaster' )
	 {
	 	if( hasChecked != 1 ){
		alert("Please make a single selection of camfirm to remove from the master account.");
		return false;
		}
		else{
			var cnfrm = confirm("Are you sure you want to remove the camfirm from the master account ?");
			if(cnfrm == false){
				return false;
			}
			else{
				
				G.post("index2.php?option=com_camassistant&controller=customer&task=removecamfirm&tmpl=component", {master: ""+val+""}, function(data){
					
					if(data == 'success'){
					alert("Camfirm removed from the master account.");
					location.reload(); 
					}
					else{
					alert("Please try once again");
					}
				});
				return false;
			}
			
		}
	 }
	//Completed
	 else if(pressbutton=='edit' && hasChecked != 1)
	 {

	 alert("Please make single selection from the list to edit");
	 return false;
	 }
	 else if(pressbutton=='edit')
	 {
	  form.controller.value="customer_detail";
	  form.submit();
	 }
	 else if(pressbutton=='export_mng' )
	 {
		window.location = 'index.php?option=com_camassistant&controller=customer&task=exportmanagers';
		return false;
	 }
	if(hasChecked>1){
	alert("Please make single selection from the list to edit");
	 return false;
	 } else {
	 if((pressbutton=='remove'))
	 {
	 var r=confirm("Are you sure you want to delete this customer/camfirm?");
	if (r==true){
	form.controller.value="customer_detail";
	form.submit();
	} else {
	return false;
	}
	 }
	form.submit();
	}
} 
function submit_resend(name,email,user_id){

var r=confirm("Are you sure you want to resend the activation?");
	if (r==true)
	{

			location.href='index.php?option=com_camassistant&controller=customer&task=activation&name='+name+'&email='+email+'&user_id='+user_id;
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
G(document).ready(function(){
G('.masterfirms').click(function(){
			masterid = G(this).attr('rel');
				
			if(G(this).hasClass('minus')){                            
				G(this).addClass('plus');			
				G('.plus').html('+');
				G(this).removeClass('minus');
                                G('.subfirms_'+masterid).next().remove();
				G('.subfirms_'+masterid).remove();
				G('.subfirms_'+masterid).remove();
			}
			else{
				G(this).addClass('minus');			
				G('.minus').html('-');
				G.post("index2.php?option=com_camassistant&controller=customer&task=getsubfirms&tmpl=component", {master: ""+masterid+""}, function(data){
				G('#master_'+masterid).after(data);
				});
				G(this).removeClass('plus');
			}
});

	// To get the managers list under the camfirm
	G('.masterfirmsmans').live('click',function(){
	
			firmid = G(this).attr('rel');
			//alert(G(this).parent().parent().attr('class'));	
			if(G(this).hasClass('minus')){
				G(this).addClass('plus');			
				G('.plus').html('+');
				G(this).removeClass('minus');
				G('.subfirms_'+firmid).next().remove();
                                G('.subfirms_'+firmid).remove();
                                
			}
			else{
				
				G(this).addClass('minus');
				G('.minus').html('-');
				G.post("index2.php?option=com_camassistant&controller=customer&task=getsubfirms&tmpl=component&type=managers", {firmid: ""+firmid+""}, function(data){
				G('#mastermans'+firmid).after(data);
				});
				G(this).removeClass('plus');
				
			}
});
	//Completed
	
	// To get the managers list under the camfirm
	G('.onlyfirms').live('click',function(){
	
			onlyfirmid = G(this).attr('rel');
			//alert(G(this).parent().parent().attr('class'));	
			if(G(this).hasClass('minus')){
				G(this).addClass('plus');			
				G('.plus').html('+');
				G(this).removeClass('minus');
				G('.dmanagershide_'+onlyfirmid).remove();
			}
			else{
				G(this).addClass('minus');
				G('.minus').html('-');
				G.post("index2.php?option=com_camassistant&controller=customer&task=getdistrictmanagers&tmpl=component&type=managers", {onlyfirm: ""+onlyfirmid+""}, function(data){
				//alert(data);
				G('#districtmanagers'+onlyfirmid).after(data);
				});
				G(this).removeClass('plus');
				
			}
});
	//Completed
	
	// To get the managers list under the districtmanages
	G('.masterfirmsdis').live('click',function(){
	
			disid = G(this).attr('rel');
			//alert(G(this).parent().parent().attr('class'));	
			if(G(this).hasClass('minus')){
				G(this).addClass('plus');			
				G('.plus').html('+');
				G(this).removeClass('minus');
				G('.dmanagershide_'+disid).hide();
			}
			else{
				G(this).addClass('minus');
				G('.minus').html('-');
				G.post("index2.php?option=com_camassistant&controller=customer&task=getdistrictmanagers&tmpl=component&type=managers", {disid: ""+disid+""}, function(data){
				//alert(data);
				G('#masterdis'+disid).after(data);
				});
				G(this).removeClass('plus');
				
			}
});
	//Completed
	
});

</script>
<?php //echo "<pre>"; print_r($this->items); ?>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" >
<div id="editcell">
	<table>
		<tr>
			<td align="left" width="100%">
				<?php echo '<b>Customer Manager  </b>'; echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->search;?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('userstatus').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td><td><select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="userstatus" name="userstatus">
<option selected="selected" value=""> Manager Status </option>
<option value="active" <?php if($_REQUEST['userstatus']=='active') { ?> selected="selected" <?php } ?> >Pending</option>
<option value="inactive" <?php if($_REQUEST['userstatus']=='inactive') { ?> selected="selected" <?php } ?>>Inactive</option>
<option value="approved" <?php if($_REQUEST['userstatus']=='approved') { ?> selected="selected" <?php } ?>>Approved</option>
<option value="rejected" <?php if($_REQUEST['userstatus']=='rejected') { ?> selected="selected" <?php } ?>>Rejected</option>
</select></td>
<td>
<select onchange="document.adminForm.submit();" style="width:200px;" size="1" id="vendorlogs" name="vendorlogs">
<option selected="selected" value="">All Managers</option>
<option value="log" <?php if($_REQUEST['vendorlogs']=='log') { ?> selected="selected" <?php } ?> >Logged-in Now</option>
<option value="notlog" <?php if($_REQUEST['vendorlogs']=='notlog') { ?> selected="selected" <?php } ?> >Not Logged-in Now</option>
</select>
</td>
		</tr>
	</table>
	<table class="adminlist" width="100%">
	<thead>
		<tr>
			<th width="3%">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="3%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>

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
			   //echo sort1('customer id', 'customer id', $this->lists['order_Dir'], $this->lists['order'])
			  ?>
				<?php //echo JText::_( 'Name' ); ?>
            <th class="title" align="left" width="6%">  Account Type	</th>   
			
			<th class="title" align="left" width="12%">
			   <?php  echo sort1('Company Name', 'c.comp_name', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
                        <th class="title" align="left" width="8%">
		   <?php  echo sort1('Federal Tax Id', 'c.camfirm_license_no', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<?php /*?><th class="title" align="left">
     		  <?php  //echo sort1('License no', 'License Number', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th><?php */?>
                        <th class="title" align="left" width="9%">
		   <?php  echo sort1('Name', 'u.lastname', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left" width="15%">
			   <?php  echo sort1('Email Address', 'u.email', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			
              <th class="title" align="left" width="7%">
		     <?php  echo sort1('Last Visit', 'u.lastvisitDate', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left" width="6%">
		    <?php  echo sort1('Registered Date', 'u.registerDate', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th class="title" align="left" width="7%">Phone Number
		   <?php  //echo sort1('Phone Number', 'phone', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>

			<th class="title" align="left" width="4%">Publish
				<?php  //echo sort1('Publish', 'Published', $this->lists['order_Dir'], $this->lists['order']); ?>
		 	</th>
			<th class="title" width="5%">Status
		 	</th>
			<th class="title" width="5%">Resend Email Confirmation
		 	</th>

		   <?php  //echo sort1('Manager', 'Manager', $this->lists['user_type'], $this->lists['order']); ?>

<!--<th class="title" align="left">
		   Login As
			</th>-->


	</thead>
</table>
	<div style="overflow:auto; height:500px; width:100%;">
       <table class="adminlist" width="100%">
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
        //echo "<pre>"; print_r($row);
		$link 	= JRoute::_( 'index.php?option=com_camassistant&controller=customer_detail&task=edit&cid[]='. $row->id );
		$approve_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=customer&task=approve&user_id='. $row->cust_id );
		$reject_link 	= JRoute::_( 'index.php?option=com_camassistant&controller=customer&task=reject&user_id='. $row->cust_id );
		$img 	= $row->published ? 'publish_x.png' : 'tick.png';
		$task 	= $row->published ? 'unblock' : 'block';
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		$j = $row->user_id;
		$published 	= JHTML::_('grid.published', $row, $i);

 if($row->comp_id!='0') { ?>
	<?php   $db		= &JFactory::getDBO();
			$query1 = "SELECT cust_id FROM #__cam_camfirminfo where id='".$row->comp_id."'";
			$db->setQuery($query1);
			$cust_id= $db->loadResult();

			$query2 = "SELECT comp_name FROM #__cam_customer_companyinfo where cust_id ='".$cust_id."'";
			$db->setQuery($query2);
			$result= $db->loadResult();
			//echo "<pre>"; print_r($result);
			$row->comp_name= $result;

			?>
<?php } else { ?>
<?php $row->comp_name=$row->comp_name; ?>
<?php }
		?>
<?php //echo '<pre>'; print_r($row->accounttype);?>
<?php if( $row->accounttype == 'master' ) { 
 $clss = 'master'; 
} else {
    $clss = 'admin';  
}
?>
			<tr class="<?php echo "row$k"; echo $clss; ?>" id="master_<?php echo $row->id; ?>">
			<td width="2%"><?php echo $this->pagination->getRowOffset( $i ); ?></td>
			<td width="2%"><?php echo $checked; ?>	</td>
                       
			<td><?php if( $row->accounttype == 'master' ) { ?>
<a style="color:green; font-weight:bold; font-size:17px;" href="javascript:void(0);" rel="<?php echo $row->id ;?>" class="masterfirms" id="masterfirms<?php echo $row->id; ?>">+</a>
			<?php } else if( $row->user_type == '13'){   ?>
<a style="color:green; font-weight:bold; font-size:17px;" href="javascript:void(0);" rel="<?php echo $row->id ;?>" class="onlyfirms" id="onlyfirms<?php echo $row->id; ?>">+</a>			
			<?php } ?>
			</td>
                         <td align="center" width="6%">
			<?PHP
			//echo "<pre>"; print_r($row);
			if($row->user_type == '12' && $row->dmanager == 'yes') { echo 'District Manager'; }
			else if($row->user_type == '12') { echo 'Manager'; }
			else if($row->user_type == '13' && $row->accounttype == 'master') {echo 'Master Account'; }
			else if($row->user_type == '13') {echo 'Camfirm Administartor'; }
			else { }
			?>
			</td>
			<?php //echo $row->cust_id; ?>
			
            <td width="15%">
			<?php 
				if($row->suspend == 'suspend' && $row->flag == 'flag') {$font = "red"; }
				else if($row->flag == 'flag') { $font = "#ff9900"; }
				else if($row->suspend == 'suspend') { $font = "red"; }
				else { $font = ''; }
				?> 
				<a target="_blank" href="<?php echo $link; ?>" title="<?php echo JText::_( 'Click a customer name to edit it' ); ?>"><font color="<?php echo $font; ?>"> <?php echo $row->comp_name; ?></font></a>
				<?php $font = ''; ?>
<?php /*?>	<a target="_blank" href="<?php echo $link; ?>" title="<?php echo JText::_( 'Click a customer name to edit it' ); ?>"><?php echo $row->comp_name; ?></a><?php */?>
			</td>
                        <td width="9%"><?php echo $row->camfirm_license_no; ?></td>
			<?php /*?><td><?php echo $row->tax_id; ?></td><?php */?>
                        <td width="9%"><a href="javascript:loginas('<?php echo $row->username ?>','<?php echo $row->password; ?>');"><?php echo $row->lastname.', '.$row->name; ?></a></td>
			<td width="12%"><?php echo $row->email; ?></td>
			
             <td width="8%"><?php echo $row->lastvisitDate; ?></td>
			<td width="7%"><?php echo $row->registerDate; ?></td>
			<td width="8%"><?php echo $row->phone; ?></td>
			<?php /*?><td align="center" title="Click the icon to toggle the state of the Industry">
				<?php echo $published; ?>
			</td><?php */?>
			<td align="center" width="5%"><?PHP if($row->status != 'approved') echo '__'; else if($row->status == 'approved') { ?>
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
   <?PHP } ?>
			</td>
			<td align="center" width="5%" >
			<?PHP if($row->status == 'inactive') echo 'Inactive'; else if($row->status == 'rejected') echo 'Rejected'; else if($row->status == 'active') { ?><a href="<?PHP echo $approve_link; ?>">Approve</a> | <a href="<?PHP echo $reject_link; ?>">Reject</a> <?PHP } else if($row->status == 'approved' ) { echo 'Approved'; }  else echo 'Inactive';?>
			</td>
			<td align="center" width="15%">
			<?php $fullname= $row->name.' '.$row->lastname; ?>
			<a href="javascript:submit_resend('<?php echo $fullname; ?>', '<?php echo $row->email ?>','<?php echo $row->cust_id ?>');" >Resend Activation</a>
			</td>

<!--<td align="center" >
			<a href="javascript:loginas('<?php echo $row->username ?>','<?php echo $row->password; ?>');">Login As</a>
			</td>-->
		</tr>
		<?php
		if($row->user_type == '13' && $row->accounttype == 'master') { ?>
		<tr id="master<?php echo $row->id; ?>"></tr>
		<?php } else if($row->user_type == '13'){ ?>
		<tr id="districtmanagers<?php echo $row->id; ?>"></tr>
		<?php } ?>
		<?php
		$k = 1 - $k;
	}
	?></table></div><table class="adminlist">
<tfoot>
		<td colspan="20">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
	</table>
</div>

<input type="hidden" name="controller" value="customer" />
<input type="hidden" name="task" value="" />
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