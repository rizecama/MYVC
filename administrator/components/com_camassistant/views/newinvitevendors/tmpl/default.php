<?php
/**
 * @version		1.0.0 cam assistant $
 * @package		cam_assistant
 * @copyright	Copyright � 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access

$ordering = ($this->lists['order'] == 'ordering');

defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
error_reporting(0);
JToolBarHelper::title( JText::_( 'New Invited Vendors' ));

?>
<link rel="stylesheet" media="all" type="text/css" href="<?php Juri::base(); ?>templates/khepri/css/camassistant.css" />	
<link rel="stylesheet" media="all" type="text/css" href="<?php Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/skin/js/jquery.elastic.js"></script>

<script language="javascript" type="text/javascript">
G = jQuery.noConflict();
function submitform(pressbutton){
var form = document.adminForm;
if(pressbutton)
  { form.task.value=pressbutton; }

if(pressbutton == 'invitation'){
el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=newinvitevendors&task=newinvitation';
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 750, y:500}}"))
SqueezeBox.fromElement(el,options);
}
else if(pressbutton == 'newemail'){
el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=newinvitevendors&task=newemailinvitation';
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 800, y:600}}"))
SqueezeBox.fromElement(el,options);
}
else if(pressbutton == 'maindelete'){
	form.submit();
}
else if(pressbutton == 'remove'){
	form.submit();
}
else {
form.submit();
}
if(pressbutton == 'lists'){
 window.location="index.php?option=com_camassistant";
}

}

</script>
<form action="<?php ?>" method="post" name="adminForm" >
Select camfirm: <select name="camid" id="camid" onchange="document.adminForm.submit();">
 <option value="0">Select camfirm</option>
<?php
for ($i=0; $i<count($this->managers); $i++){
$custmers = $this->managers[$i];   ?>
<option <?php if($_REQUEST['camid'] == $custmers->id) { ?> selected="selected"<?php }?> value="<?php echo $custmers->id; ?>"><?php echo $custmers->name.' '.$custmers->lastname; ?> </option>
<?php }  ?>
 </select> 
 
<br /><br />

<table cellpadding="0" cellspacing="0" class="adminlist">
<tr>
<th width="5">
<?php echo JText::_( 'NUM' ); ?>
</th>

<th width="20">
<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->result); ?>);" />
</th>
<?PHP 
			function sorting( $title, $order)
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

<th class="title" align="center" width="200">
<?php echo 'Article Type'; ?>
</th>
<th class="title" align="center" width="200">
<?php echo 'Vendor Email Id'; ?>
</th>
<th class="title" align="center" width="200">
<?php echo JHTML::_( 'grid.sort', 'Camfirm', 'name', $this->lists['order_Dir'], $this->lists['order']); ?>
</th>
<th class="title" align="center" width="200">
<?php echo 'Camfirm mailid'; ?>
</th>
<th class="title" align="center" width="100">
<?php  echo 'Status';  ?>
</th>
<th class="title" align="center" width="200">
<?php echo JHTML::_( 'grid.sort', 'Invited Date', 'date', $this->lists['order_Dir'], $this->lists['order']); ?>
</th>

</tr>
<?php 
for ($i=0; $i<count($this->result); $i++){
$row = &$this->result[$i];
//$checked 	= JHTML::_('grid.checkedout',$this->result, $i );
$checked 	= JHTML::_('grid.checkedout',   $row, $i );

$published 	= JHTML::_('grid.published', $result, $i );		
$vendor = $this->result[$i];
//$vid=$this->result[$i]->vid;
?>

<tr class="<?php echo "row$k"; ?>">
			<td width="5">
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td width="20">
				<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $this->result[$i]->id; ?>" name="cid[]" id="cb<?php echo $i; ?>">
			</td>
<td align="center" width="200"><?php echo ucfirst($vendor->articletype); ?></td>			
<td align="center" width="200"><?php echo $vendor->vendoremailid; ?></td>
<td align="center" width="200"><?php echo $vendor->name."&nbsp;&nbsp;".$vendor->lastname; ?></td>
<td align="center" width="200"><?php echo $vendor->email; ?></td>

<?php
	$db = JFactory::getDBO();
	$vendor_id = "SELECT id from #__users  where email = '".$vendor->vendoremailid."' ";
	$db->setQuery($vendor_id);
	$vendorid_exist = $db->loadResult();
?>
<td align="center" width="100"><?php if($vendorid_exist)  { echo "<span style='color:green'>Accepted</span>"; } else  { echo "Pending";  }?></td>
<td align="center" width="200"><?php echo $vendor->date; ?></td>
</tr>
<?php /*?><input type="hidden" name="cid" value="<?php echo $this->result[$i]->vid; ?>" /><?php */?>
<?php
} 
 
 ?>
<tfoot>
		<td colspan="9">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
</table>

<input type="hidden" name="task" value="" /> 
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->result['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->result['order_Dir']; ?>" />
</form>



