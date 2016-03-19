<?php
//restricted access
defined('_JEXEC') or die('Restricted access');

// import html tooltips
JHTML::_('behavior.modal');
//echo "<pre>"; print_r($this->detail);
$cid = JRequest::getVar('cid','','get','array' );
$cid = $cid[0];
$user =& JFactory::getUser($cid);
$document =& JFactory::getDocument();
$document->addStyleSheet(JPATH_ADMINISTRATOR.DS.'templates/khepri/css/camassistant.css');
$document->addStyleSheet(JPATH_COMPONENT_SITE.DS.'skin/css/jquery1.css');
$document->addScript(JPATH_COMPONENT_SITE.DS.'skin/js/jquery-1.4.4.min.js');
$document->addScript(JPATH_COMPONENT_SITE.DS.'skin/js/jquery-ui-1.8.6.custom.min.js');
$document->addScript(JPATH_COMPONENT_SITE.DS.'skin/js/jquery-ui-timepicker-addon.js');

?>

<script type="text/javascript">
G  = jQuery.noConflict();
function rejvendor(id) { 
//alert(id);

el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=vendorcompliances_details&task=vendorcompliancesdetails&cid[]='+id;
//alert(el);
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 600, y:500}}"))
SqueezeBox.fromElement(el,options);
}
</script>

<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="adminForm" id="adminForm">
		<table class="adminheading">
		<tr>
			<th class="content">
			Edit Vendor Documents - <?PHP echo $user->name.'&nbsp;'.$user->lastname; ?>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<?PHP if(count($this->OLN) > 0 ){ ?>
				<tr>
					<th colspan="2">
					Occupational License Info Docs :
					</th>
				</tr>
				<tr>
					<td width="100%">
					<table class="adminlist" border="0" >
					<tr><td width="30%" align="center"><strong>Occupational License Number</strong></td><td width="30%" align="center"><strong>Download Doc</strong></td><td width="30%" align="center"><strong>Options</strong></td></tr>
				   <?PHP $k = 0; for ($i=0, $n=count( $this->OLN ); $i < $n; $i++)
					{
					$row = &$this->OLN[$i];
					//if($row->OLN_license != '' || $row->OLN_upld_cert != '') {  ?>
					<tr  class="<?php echo "row$k"; ?>"><td align="center"><?PHP echo $row->OLN_license; ?></td><td align="center"><?PHP if($row->OLN_upld_cert != '') {  ?><a href="index.php?option=com_camassistant&controller=vendorcompliances_details&user_id=<?PHP echo $user->id; ?>&doc=OLN_<?PHP echo $i+1; ?>&task=view_upld_cert&filename=<?PHP echo $row->OLN_upld_cert; ?>"><?PHP echo $row->OLN_upld_cert; ?></a><?PHP } else echo '---'; ?></td><td align="center">
					<input type="radio" name="OLN_radio[<?PHP echo $i ?>]" value="1" <?PHP if($row->OLN_status == 1) {?> checked="checked" <?PHP } ?> />&nbsp;Accept&nbsp;&nbsp;&nbsp;
					<input type="radio" name="OLN_radio[<?PHP echo $i ?>]" onclick="javascript:rejvendor(<?php echo $cid ?>);" value="-1" <?PHP if($row->OLN_status == '-1' || ($row->OLN_expdate != '0000-00-00' && $row->OLN_expdate < date('Y-m-d'))) {?> checked="checked" <?PHP } ?> />&nbsp;Reject&nbsp;&nbsp;&nbsp;
					<input type="radio" name="OLN_radio[<?PHP echo $i ?>]" value="0" <?PHP if($row->OLN_status == 0) {?> checked="checked" <?PHP } ?> />&nbsp;Pending
					<?PHP if($row->OLN_expdate != '0000-00-00' && $row->OLN_expdate < date('Y-m-d')) {?>
					<br/><b style="padding-left:90px; color:#FF0000;">(Expired)</b>
					<?PHP } ?>
					</td></tr>
					<?PHP //} ?>	
					<input type="hidden" name="OLN_ids[]" value="<?PHP echo $row->id; ?>" />
					<input type="hidden" name="OLN_date_verified[]" value="<?PHP echo $row->OLN_date_verified; ?>" />
				<?PHP  } ?>	</table>	
					</td>
				</tr>
				<?PHP } ?>
				</table>
			</td>
		</tr>
		
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<?PHP if(count($this->PLN) > 0 ){ ?>
				<tr>
					<th colspan="2">
					Professional License Info Docs :
					</th>
				</tr>
				<tr>
					<td width="100%">
					<table class="adminlist" border="0" >
					<tr><td width="30%" align="center"><strong>Professional License Number </strong></td><td width="30%" align="center"><strong>Download Doc</strong></td><td width="30%" align="center"><strong>Options</strong></td></tr>
				   <?PHP $k = 0; for ($i=0, $n=count( $this->PLN ); $i < $n; $i++)
					{
					$row = &$this->PLN[$i]; 
					//if($row->PLN_license != '' || $row->PLN_upld_cert) { ?>
					
					<tr  class="<?php echo "row$k"; ?>"><td align="center"><?PHP echo $row->PLN_license; ?></td><td align="center"><?PHP if($row->PLN_upld_cert != '') {  ?><a href="index.php?option=com_camassistant&controller=vendorcompliances_details&user_id=<?PHP echo $user->id; ?>&doc=PLN_<?PHP echo $i+1; ?>&task=view_upld_cert&filename=<?PHP echo $row->PLN_upld_cert; ?>"><?PHP echo $row->PLN_upld_cert; ?></a><?PHP } else echo '---'; ?></td><td align="center">
					<input type="radio" name="PLN_radio[<?PHP echo $i ?>]" value="1" <?PHP if($row->PLN_status == 1) {?> checked="checked" <?PHP } ?> />&nbsp;Accept&nbsp;&nbsp;&nbsp;
					<input type="radio" name="PLN_radio[<?PHP echo $i ?>]" onclick="javascript:rejvendor(<?php echo $cid ?>);" value="-1" <?PHP if($row->PLN_status == '-1' || ($row->PLN_expdate != '0000-00-00' && $row->PLN_expdate < date('Y-m-d'))) {?> checked="checked" <?PHP } ?> /> &nbsp;Reject&nbsp;&nbsp;&nbsp;
					<input type="radio" name="PLN_radio[<?PHP echo $i ?>]" value="0" <?PHP if($row->PLN_status == 0 ) {?> checked="checked" <?PHP } ?> /> &nbsp;Pending 
					<?PHP if($row->PLN_expdate != '0000-00-00' && $row->PLN_expdate < date('Y-m-d')) {?>
					<br/><b style="padding-left:90px; color:#FF0000;">(Expired)</b>
					<?PHP } ?>
					</td></tr>
					<?PHP //} ?>
					<input type="hidden" name="PLN_ids[]" value="<?PHP echo $row->id; ?>" />
					<input type="hidden" name="PLN_date_verified[]" value="<?PHP echo $row->PLN_date_verified; ?>" />
				<?PHP } ?>	</table>	
					</td>
				</tr>
				<?PHP } ?>
				</table>
			</td>
		</tr>
		
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<?PHP if(count($this->GLI) > 0 ){ ?>
				<tr>
					<th colspan="2">
					General Liability License Info Docs :
					</th>
				</tr>
				<tr>
					<td width="100%">
					<table class="adminlist" border="0" >
					<tr><td width="30%" align="center"><strong>General Liability Insurance Carrier</strong></td><td width="30%" align="center"><strong>Download Doc</strong></td><td width="30%" align="center"><strong>Options</strong></td></tr>
				   <?PHP $k = 0; for ($i=0, $n=count( $this->GLI ); $i < $n; $i++)
					{
					$row = &$this->GLI[$i]; 
					//if($row->GLI_name != '' || $row->GLI_upld_cert != '') {  ?> 
		
					<tr  class="<?php echo "row$k"; ?>"><td align="center"><?PHP echo $row->GLI_name; ?></td><td align="center"><?PHP if($row->GLI_upld_cert != '') {  ?><a href="index.php?option=com_camassistant&controller=vendorcompliances_details&user_id=<?PHP echo $user->id; ?>&doc=GLI_<?PHP echo $i+1; ?>&task=view_upld_cert&filename=<?PHP echo $row->GLI_upld_cert; ?>"><?PHP echo $row->GLI_upld_cert; ?></a><?PHP } else echo '---'; ?></td><td align="center">
					<input type="radio" name="GLI_radio[<?PHP echo $i ?>]" value="1" <?PHP if($row->GLI_status == 1 ) {?> checked="checked" <?PHP } ?> /> &nbsp;Accept&nbsp;&nbsp;&nbsp;
					<input type="radio" name="GLI_radio[<?PHP echo $i ?>]" onclick="javascript:rejvendor(<?php echo $cid ?>);" value="-1" <?PHP if($row->GLI_status == '-1' || ($row->GLI_end_date != '0000-00-00' && $row->GLI_end_date < date('Y-m-d'))) {?> checked="checked" <?PHP } ?> /> &nbsp;Reject&nbsp;&nbsp;&nbsp;
					<input type="radio" name="GLI_radio[<?PHP echo $i ?>]" value="0" <?PHP if($row->GLI_status == 0 ) {?> checked="checked" <?PHP } ?> /> &nbsp;Pending
					<?PHP if($row->GLI_end_date != '0000-00-00' && $row->GLI_end_date < date('Y-m-d')) {?>
					<br/><b style="padding-left:90px; color:#FF0000;">(Expired)</b>
					<?PHP } ?>
					</td></tr>
					<?PHP // } ?>
					<input type="hidden" name="GLI_ids[]" value="<?PHP echo $row->id; ?>" />
					<input type="hidden" name="GLI_date_verified[]" value="<?PHP echo $row->GLI_date_verified; ?>" />
				<?PHP } ?>	</table>	
					</td>
				</tr>
				<?PHP } ?>
				</table>
			</td>
		</tr>
		
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<?PHP if(count($this->WCI) > 0 ){ ?>
				<tr>
					<th colspan="2">
					Workers Compensation License Info Docs :
					</th>
				</tr>
				<tr>
					<td width="100%">
					<table class="adminlist" border="0" >
					<tr><td width="30%" align="center"><strong>Workers Compensation Insurance Carrier</strong></td><td width="30%" align="center"><strong>Download Doc</strong></td><td width="30%" align="center"><strong>Options</strong></td></tr>
				   <?PHP $k = 0; for ($i=0, $n=count( $this->WCI ); $i < $n; $i++)
					{
					$row = $this->WCI[$i]; 
					 //if($row->WCI_name != '' || $row->WCI_upld_cert != '') {  ?> 
		
					<tr  class="<?php echo "row$k"; ?>"><td align="center"><?PHP echo $row->WCI_name; ?></td><td align="center"><?PHP if($row->WCI_upld_cert != '') {  ?><a href="index.php?option=com_camassistant&controller=vendorcompliances_details&user_id=<?PHP echo $user->id; ?>&doc=WCI_<?PHP echo $i+1; ?>&task=view_upld_cert&filename=<?PHP echo $row->WCI_upld_cert; ?>"><?PHP echo $row->WCI_upld_cert; ?></a><?PHP } else echo '---'; ?></td><td align="center">
					<input type="radio" name="WCI_radio[<?PHP echo $i ?>]" value="1" <?PHP if($row->WCI_status == 1) {?> checked="checked" <?PHP } ?> />&nbsp;Accept&nbsp;&nbsp;&nbsp;
					<input type="radio" name="WCI_radio[<?PHP echo $i ?>]" onclick="javascript:rejvendor(<?php echo $cid ?>);" value="-1" <?PHP if($row->WCI_status == '-1' || ($row->WCI_end_date  != '0000-00-00' && $row->WCI_end_date < date('Y-m-d'))) {?> checked="checked" <?PHP } ?> />&nbsp;Reject&nbsp;&nbsp;&nbsp;
					<input type="radio" name="WCI_radio[<?PHP echo $i ?>]" value="0" <?PHP if($row->WCI_status == 0 ) {?> checked="checked" <?PHP } ?> />&nbsp;Pending
					<?PHP if($row->WCI_end_date  != '0000-00-00' && $row->WCI_end_date < date('Y-m-d')) {?>
					<br/><b style="padding-left:90px; color:#FF0000;">(Expired)</b>
					<?PHP } ?>
					</td></tr>
					<?PHP //} ?>
					<input type="hidden" name="WCI_ids[]" value="<?PHP echo $row->id; ?>" />
					<input type="hidden" name="WCI_date_verified[]" value="<?PHP echo $row->WCI_date_verified; ?>" />
				<?PHP } ?>	</table>	
					</td>
				</tr>
				<?PHP } ?>
				</table>
			</td>
		</tr>
		
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<?PHP
					$row = &$this->W9[0]; 
		            if($row->w9_upld_cert != '') { ?> 
				<tr>
					<th colspan="2">
					W9 Docs :
					</th>
				</tr>
				<tr>
					<td width="100%">
					<table class="adminlist" border="0" >
					<tr><td width="30%" align="center"><strong>Doc Name</strong></td><td width="30%" align="center"><strong>Download</strong></td><td width="30%" align="center"><strong>Options</strong></td></tr>
				   
					<tr  class="<?php echo "row$k"; ?>"><td align="center"><?PHP echo $row->w9_upld_cert; ?></td><td align="center"><a href="index.php?option=com_camassistant&controller=vendorcompliances_details&user_id=<?PHP echo $user->id; ?>&doc=W9&task=view_upld_cert&filename=<?PHP echo $row->w9_upld_cert; ?>"><?PHP echo $row->w9_upld_cert; ?></a></td><td align="center">
					<input type="radio" name="w9_radio" value="1" <?PHP if($row->w9_status == 1) {?> checked="checked" <?PHP } ?>  />&nbsp;Accept&nbsp;&nbsp;&nbsp;
					<input type="radio" name="w9_radio" onclick="javascript:rejvendor(<?php echo $cid ?>);" value="-1" <?PHP if($row->w9_status == '-1') {?> checked="checked" <?PHP } ?> /> &nbsp;Reject&nbsp;&nbsp;&nbsp;
					<input type="radio" name="w9_radio" value="0" <?PHP if($row->w9_status == 0) {?> checked="checked" <?PHP } ?> /> &nbsp;Pending</td></tr>
					<input type="hidden" name="w9_ids" value="<?PHP echo $row->id; ?>" />
					<input type="hidden" name="w9_date_verified" value="<?PHP echo $row->w9_date_verified; ?>" />
					</table>	
					</td>
				</tr>
				<?PHP } ?>
				</table>
			</td>
		</tr>
		
		</table>

<input type="hidden" name="cid[]" value="<?php echo $_REQUEST['cid'][0] ?>" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="controller" value="vendorcompliances_details" />
</form>


