<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<link href="<?php JPATH_SITE ?>templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<style>
a:link {
    color: #7AB800;
    font-size: 12px;
    font-weight: bold;
    text-decoration: none;
	font-weight: bold; 
	text-align:center
}

</style>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>

<script type="text/javascript">
N = jQuery.noConflict();
N(document).ready(function() {	
	N('.reportsto_newcancel').click(function(e) {
			window.parent.document.getElementById( 'sbox-window' ).close(); 
		});
	N('.reportsto_change').click(function(e) {
			N('#reportstoform').submit();
		});
	N('.reportsto_higher').click(function(e) {
			window.parent.document.getElementById( 'sbox-window' ).close(); 
		});	
	
	
});
</script>
<br />
<div id="i_bar_terms" style="margin-left:20px; margin-right:20px;">
<div id="i_bar_txt_terms" style="text-align:center">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">REPORTS TO</font></span>
</div></div>
<div style="text-align:center; padding-top:20px;"> 
<?php 
/*$managers = $this->managerslist;
$dmanagers = $this->dms;
echo "<pre>"; print_r($_REQUEST); echo "</pre>";
if($managers){
for($p=0; $p<=count($managers); $p++){ 
			$db=&JFactory::getDBO();
			$sql_names = 'select name, lastname from #__users where id='.$managers[$p].' ';
			$db->setQuery($sql_names);
			$mgname = $db->loadObject();
?>
	 <a style=" color: #636363; font-size: 12px;font-weight: bold; text-decoration: none; font-weight: bold; font-size:14px;">
	 <?php echo $mgname->name.'&nbsp;'.$mgname->lastname; ?></a><br />
<?php } } else { 
echo "There is NO managers in his list.";
}*/
?>
</div>
<form method="post" name="reportstoform" id="reportstoform">
<?php 
	 $user = JFactory::getUser();
	 $managerid = JRequest::getVar("pmanager_id",'');
	 $mgrtype = JRequest::getVar("mgrtype",'');
	 $mgr_name = JRequest::getVar("name",'');
	 $dmanagers = $this->dms;
	 //echo "<pre>"; print_r($dmanagers); echo "</pre>";
	 //echo $_REQUEST['pmanager_id'];
	 $db =& JFactory::getDBO();
	 if($user->user_type == 13 && $mgrtype == 'normal' ){
	 ?>
	 <div class="reportsto_manager">
	<label>Please select which user <?php echo $mgr_name; ?> reports to: </label>
		<br /><br /><select name="dmanager" id="dmanager">
          <?php 
		for($d=0; $d<count($dmanagers); $d++){ 
	 	$sql_dmanagerdet = "SELECT name,lastname,id FROM #__users where id=".$dmanagers[$d]."";
		$db->Setquery($sql_dmanagerdet);
		$ddetails = $db->loadObject();
		
		// To get selected element
		$dman = "SELECT dmanager FROM #__cam_invitemanagers where managerid=".$_REQUEST['pmanager_id']."";
		$db->Setquery($dman);
		$dmans = $db->loadResult();
		if($ddetails->id == $dmans){
			$selected = 'selected="selected"';
		}
		else
			$selected = '';
		
		if($ddetails->id){ ?>
		<option <?php echo $selected; ?> value="<?php echo $ddetails->id; ?>" ><?php echo $ddetails->name.'&nbsp;'.$ddetails->lastname; ?></option>
		<?php 	}	}
		?>
        </select> 
    </div>
	<input type="hidden" name="option" value="com_camassistant" />
	<input type="hidden" name="controller" value="propertymanager" />
	<input type="hidden" name="task" value="reportsto" />
	<input type="hidden" name="id" value="<?php echo $managerid; ?>" />
	</form>
	<div class="buttons_reports">
	<div class="cancel_reports"><a href="javascript:void(0);" class="reportsto_newcancel"></a></div>
	<div class="change_reports"><a href="javascript:void(0);" class="reportsto_change"></a></div>
	</div>
	<?php } 
	else {?>
	<div class="reportsto_manager">
	"You can't change who a Master, Admin, or District Manager account reports to. If you want to change the details on this account, like the primary email or name, please click on the user's name (first column)." If you want to demote a District Manager to a Standard Manager, please click on "District Manager" under the ACCOUNT TYPE column.
	</div>
	<div class="buttons_reports_ok">
	<div class="change_reports"><a href="javascript:void(0);" class="reportsto_higher"></a></div>
	</div>
	<?php } ?>
	
	
<?php 
exit;

?>
