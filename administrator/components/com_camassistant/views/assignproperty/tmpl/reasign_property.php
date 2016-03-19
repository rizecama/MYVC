<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery.elastic.js"></script>

<script type="text/javascript">
H = jQuery.noConflict();
function getmanagers(val){
document.getElementById("premanagers").style.display = 'none';

H.post("index2.php?option=com_camassistant&controller=assignproperty&task=getallmanagers", {companyid: ""+val+""}, function(data){

if(data.length >0) {
document.getElementById("divcounty").style.display = '';
H("#divcounty").html(data);
}
});

}
</script>
<?php
$property_name = JRequest::getVar( 'pname','' );
$company_name = JRequest::getVar( 'company','' );
$property_id = JRequest::getVar( 'pid','' );
$presentid = JRequest::getVar( 'present','' );
$db=JFactory::getDBO();	
		$cid = JRequest::getVar( 'company','' );	
		$mans = "SELECT u.name,u.lastname,u.id from #__cam_customer_companyinfo as v, #__users as u where v.comp_id=".$cid." and u.id=v.cust_id";
		$db->setQuery($mans);
		$mans = $db->loadObjectList();

$cams = "SELECT u.name,u.lastname,u.id from #__cam_camfirminfo as v, #__users as u where v.id=".$cid." and u.id=v.cust_id";
		$db->setQuery($cams);
		$camfirm = $db->loadObjectList();

$all_managers = array_merge($mans,$camfirm);
?>
<form name="reassignform" id="reassignform" method="post" >
<div style="padding-left:63px; padding-top:60px;">
<table width="100%" border="0">
  <tr>
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="25%" height="25"><strong>Property Name:</strong></td>
    <td><?php echo ucwords($property_name);?></td>
  </tr>
  <!--<tr>
    <td width="25%" height="25"><strong>Present Company Name:</strong></td>
    <td><?php //echo ucwords($company_name);?></td>
  </tr>-->
  <tr>
    <td height="25"><strong>All Camfirms:</strong></td>
    <td><?php //echo "<pre>"; print_r($this->custmers); ?> 
<select style="width: 156px;" name="cid" onchange=javascript:getmanagers(this.value); >
<!--<option value="0">Current Assigned Manager</option>-->
<?php 
for ($i=0; $i<count($this->custmers); $i++){
$custmers = $this->custmers[$i];
?>
<option value="<?php echo $custmers->id; ?>" <?php if($company_name==$custmers->id) echo "selected";?>><?php echo $custmers->comp_name; ?> </option>
<?php }  ?>
</select></td>
  </tr>
  <tr>
    <td height="25"><strong>All managers:</strong></td>
<td id="divcounty" class="divcounty" style="display:none"></td>
    <td  id="premanagers">
<select style="width: 156px;" name="custid" >
<!--<option value="0">Current Assigned Manager</option>-->
<?php 

for ($i=0; $i<count($all_managers); $i++){
$managers = $all_managers[$i];
?>
<option value="<?php echo $managers->id; ?>" <?php if($presentid==$managers->id) echo "selected";?>><?php echo $managers->name.' '.$managers->lastname; ?> </option>
<?php }  ?>
</select></td>
  </tr>
  <?php /*?><tr>
    <td height="25"><strong>Camfirm Admin:</strong></td>
    <td><?php //echo "<pre>"; print_r($this->custmers); ?> 
<select style="width: 156px;" name="custid" >
<!--<option value="0">Current Assigned Manager</option>-->
<?php 
for ($i=0; $i<count($this->custmers); $i++){
$custmers = $this->custmers[$i];
?>
<option value="<?php echo $custmers->id; ?>" <?php if($presentid==$custmers->id) echo "selected";?>><?php echo $custmers->name.' '.$custmers->lastname; ?> </option>
<?php }  ?>
</select></td>
  </tr><?php */?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

<input type="hidden" name="type" value="<?php echo $type;?>" />
<input type="hidden" name="pid" value="<?php echo $property_id;?>" />
<input type="hidden" name="task" value="save_reassign" />
<input type="hidden" name="controller" value="assignproperty" />
<input type="hidden" name="option" value="com_camassistant" />
<tr><td>&nbsp;</td><td>
<input type="image" src="images/reassignmanager.gif" alt="add a property" width="169" height="49" />
</td></tr>
</table>
</form>
</div>