<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );
$items = $this->items;

$prefer = $this->prefer;
$excluded = $this->excluded;
$user =& JFactory::getUser();
JHTML::_('behavior.modal');
?>
<form name="vendorcenter_edit" id="vendorcenter_edit" method="post"  >
<?php if(isset($items) && $items != '' )  :   ?>
<div id="dotshead"> Edit Vendor </span></div>
<div class="table_panneldiv">
 <?php foreach($items as $am ) {  
 $userid =$am->id; 
 ?>
 <div style="width: 400px;" class="signup">
 <table width="100%" cellpadding="0" cellspacing="4">
  <tr>
    <td align="left" valign="top">Vendor Name</td>
	<td align="left" valign="top"><input type="text" name="vendorname" value="<?php echo $am->name; ?>" /></td>
  </tr>
  <tr>
    <td align="left" valign="top">Salutation</td>
    <td align="left" valign="top"><input type="text" name="salutation"  value="<?php echo $am->salutation; ?>" /></td>
  </tr>
  <tr>
	<td align="left" valign="top">First Name</td>
    <td align="left" valign="top"><input type="text" name="firstname" value="<?php echo $am->name; ?>" /></td>
  </tr>
  <tr> 
	<td align="left" valign="top">Last Name</td>
    <td align="left" valign="top"><input type="text" name="lastname" value="<?php echo $am->lastname; ?>" /></td>
  </tr>
  <tr>
  	<td align="left" valign="top">Phone #</td>
    <td align="left" valign="top"> <input type="text" name="phone" value="<?php echo $am->phone; ?>" /></td>
  </tr>
  <tr>
	<td align="left" valign="top">Extention</td>
	<td align="left" valign="top"><input type="text" name="extention" value="<?php echo $am->extension; ?>" /></td>
  </tr>
  <tr>	
	<td align="left" valign="top">Email address</td>
	<td align="left" valign="top"><input type="text" name="email" value="<?php echo $am->email; ?>" /></td>
  </tr>
  </table>
  
  <div align="right" id="topborder_row">
  <table width="100%" cellpadding="0" cellspacing="4" >
  <tr>
  	<td>&nbsp;</td>
  	<td colspan="2" align="right"><input type="image" src="templates/camassistant_left/images/savechenges.gif" /></td>
  </tr>
 </table>
 </div>
 </div>
 <?php } //echo $userid; ?>
<div class="clear"></div>
</div>
<?php endif; ?>

<input type="hidden" name="Itemid" value="<?php echo $_REQUEST['Itemid']; ?>"  />
<input type="hidden" name="userid" value="<?php echo $userid; ?> " />
<input type="hidden" name="controller" value="vendorscenter"  />
<input type="hidden" name="task" value="vendorscenter_update"  />
<input type="hidden" name="option" value="com_camassistant"  />

</form>
