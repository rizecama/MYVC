<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
?>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>templates/camassistant_left/css/style.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery.elastic.js"></script>
<script type="text/javascript">
function pclose(){
window.parent.document.getElementById( 'sbox-window' ).close();
}
</script>
<?php
$user = JFactory::getUser();
$usertype = $user->user_type;
?>

<form name="reassignform" id="reassignform" method="post" >


<div id="i_bar_terms" style="margin:16px;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">REASSIGN MANAGER</font></span>
</div></div>

<table width="100%" border="0">
   
  <tr>
    <td colspan="2" height="25" style="text-align:center;"><font style="font-weight:bold;font-size:12px; font-family: arial; line-height:28px; margin-left:26px;" color=" #4d4d4d">Please choose the user who managers this property</font>	</td>
	</tr>
	<tr height="20"></tr>
	<tr>
	<td colspan="2" style="text-align:center">
<?php 	//echo "<pre>"; print_r($this->pinfo);
//echo "<pre>"; print_r($this->custmers);
 //exit; ?>
<select style="width: 156px;" name="custid" >
<!--<option value="0">Current Assigned Manager</option>-->
<?php 

for ($i=0; $i<count($this->custmers); $i++){
$custmers = $this->custmers[$i];
?>
<option value="<?php echo $custmers->id; ?>" <?php if($this->pinfo[0]->property_manager_id==$custmers->id) echo "selected";?>><?php echo $custmers->lastname.' '.$custmers->name; ?> </option>
<?php }  ?>
<?php 
if( $usertype ==13 ) {
			$db= JFactory::getDBO();	
			$sql1 = "SELECT u.masterid, v.name, v.lastname from #__cam_masteraccounts as u, #__users as v where u.firmid=".$user->id." and u.masterid=v.id";
			$db->Setquery($sql1);
			$masterid = $db->loadObject();
}
?>
<?php if($masterid){ ?>
<option value="<?php echo $masterid->masterid; ?>" <?php if($this->pinfo[0]->property_manager_id==$masterid->id) echo "selected";?>><?php echo $masterid->lastname.' '.$masterid->name; ?> </option>
<?php } ?>
</select></td>
  </tr>

<input type="hidden" name="pid" value="<?php echo $this->pid;?>" />
<input type="hidden" name="task" value="save_reassign" />
<input type="hidden" name="controller" value="addproperty" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" value="popup" name="pop" />
<!-- sof table pan -->

<!-- eof table pan -->
<tr height="40"></tr>
<tr>
<td colspan="2" style="text-align:center">
<a style="margin-left:65px;" href="javascript:pclose();"><img style="cursor:pointer;" src="templates/camassistant_left/images/cancel.png"></a>
<input type="image" src="templates/camassistant_left/images/save.png" alt="add a property" width="169" height="49" style="margin-right:70px;" />
</td>
</table>
</form>

<?php  exit;?>