<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
?>
<script type="text/javascript">
function getsubmit(id){
if(id == 'cancel'){
window.parent.document.getElementById( 'sbox-window' ).close();
}
else{
followform.submit();
window.parent.document.getElementById( 'sbox-window' ).close();
}
}
</script>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::root(); ?>administrator/components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo Juri::root(); ?>components/com_camassistant/skin/js/jquery.elastic.js"></script>
<script type="text/javascript">
H = jQuery.noConflict();
H(document).ready(function(){
    H("#followdate").focus();
	H(function() {
    H(this).datepicker().datepicker( "show" )
});
});
</script>
<?php $userinfo=$this->admins;  ?>

<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="followform" id="followform">
		<table class="adminheading">
		<tr><td>Followup date: </td><td>
		<?php
		$date = JRequest::getVar('date','');
		$datenadtime = explode(' ',$date);
		
		?>
		<input type="text" name="followupdate" id="followdate" style="width:115px;" value="<?php echo $datenadtime[0] ; ?>" />
Time: <input type="text" name="followuptime" id="followtime" style="width:124px;" value="<?php echo $datenadtime[1] ; ?>"  /><font color="#FF0000">(HH:MM)(24 hours time)</font>
			<script type="text/javascript">
			G = jQuery.noConflict();
			G('#followdate').datepicker({
			dateFormat: 'mm-dd-yy',changeYear: true,changeMonth:true});
			/*G('#followtime').timepicker({
    showPeriodLabels: false,
});*/
			</script>
		</td></tr>
		<!--<tr height="200"></tr>-->
		<?php /*?><tr><td>Assigned to: </td>		
		<td><?php 
		$user = JFactory::getUser();
		$style = 'style="width:280px;"';
		if(!$datenadtime[2]) {
		$adminid = $user->id ;
		}
		else{
		$adminid = $datenadtime[2] ;
		}
		echo JHTML::_('select.genericlist', $userinfo, 'adminid',  'size="1" '.$style.'  class="inputbox "  "', 'value', 'text', $adminid);?></td></tr><?php */?>
		<tr height="10"></tr>
		<tr>
		<td></td>
		<td><input type="submit" value="CANCEL" onClick="javascript:getsubmit('cancel');">&nbsp;&nbsp;&nbsp;&nbsp;<input style="width:74px; float:right; margin-right:245px;" type="submit" value="OK" onClick="javascript:getsubmit('ok');"></td></tr>
		
		</table>
<input type="hidden" name="task" value="savefollowdate" />
<input type="hidden" name="controller" value="rfp" />
<input type="hidden" value="<?php echo $_REQUEST['id']; ?>" name="rfpid" m>
</form>

<?php

exit; ?>