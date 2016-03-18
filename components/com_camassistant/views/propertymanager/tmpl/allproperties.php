<?php
/**
 * @version		1.0.0 camassistant $
 * @package		camassistant
 * @copyright	Copyright © 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
//$pmanagers=$this->pmanagers;
$properties=$this->properties;
$Itemid = JRequest::getVar("Itemid",0);
/*echo "<pre>";
print_r($pmanagers);
print_r($properties);exit;*/
?>

<div id="vender_right12">

<!-- sof bedcrumb -->
<div id="bedcrumb">
<ul>
<li class="home"><a href="index.php">Home</a> </li>
<li><a href="index.php?option=com_camassistant&controller=propertymanager&task=company_edit_form&Itemid=87">Firm Admin Home</a> </li>
<li><a href="index.php?option=com_camassistant&controller=propertymanager&task=manage_properties&Itemid=<?php echo $Itemid;?>">My Managers & Properties</a></li>
<li>Viewall Properties</li>
</ul>
</div>
<!-- eof bedcrumb -->

<!-- sof dotshead -->
<div id="dotshead_blue">MY PROPERTIES</div>
<!-- eof dotshead -->

<!-- sof table pan -->
<div class="table_pannel">
<div class="table_panneldiv">
<table width="100%" cellpadding="0" cellspacing="4">
  <tr class="table_green_row">
   <td width="15%" align="left" valign="top">TAX ID#</td>
    <td width="18%" align="left" valign="top" nowrap="nowrap">Property Name</td>
    <td width="25%" align="left" valign="top" nowrap="nowrap">Property Manager</td>
    <td width="15%" align="left" valign="top">Email-ID</td>
    <td width="15%" align="left" valign="top">Address</td>
    <td width="16%" align="center" valign="top">OPTIONS</td>
  </tr>
  
 <?php if(count($properties)>0) { 
  for($i=0;$i<count($properties);$i++) { ?>
  <tr class="table_blue_rowdots">
    <td align="left" valign="top" nowrap="nowrap"><?php echo $properties[$i]->tax_id;?></td>
    <td align="left" valign="top"><?php echo ucwords($properties[$i]->property_name);?></td>
    <td align="left" valign="top"><?php if($properties[$i]->name) echo ucwords($properties[$i]->name); else echo ucwords($properties[$i]->lastname);?></td>
    <td align="left" valign="top"><?php echo $properties[$i]->email;?></td>
    <td align="left" valign="top"><?php echo ucfirst($properties[$i]->street).'<br>City: '.ucfirst($properties[$i]->city).'<br>State: '.ucfirst($properties[$i]->state).'<br>';?></td>
    <td align="center" valign="top" nowrap="nowrap"><a href="index.php?option=com_camassistant&controller=propertymanager&task=property_details&property_id=<?php echo $properties[$i]->id;?>&Itemid=<?php echo $Itemid;?>">VIEW</a><img src="templates/camassistant_left/images/links_devider.gif" alt="liks devider" hspace="8" /><a href="index.php?option=com_camassistant&controller=propertymanager&task=property_edit_form&property_id=<?php echo $properties[$i]->id;?>&Itemid=<?php echo $Itemid;?>">EDIT</a></td>
  </tr>
  <?php } } else {?>
 <tr class="table_blue_rowdots">
    <td align="center" valign="top" colspan="5">No Records Found</td>
  </tr><?php } ?>
  
 </table>


<div class="clear"></div>
</div>
</div>
</div>
<?php echo $this->pagination->getPagesLinks( ); ?>
	<?php //echo $this->pagination->getLimitBox( ); ?>
	<?php echo $this->pagination->getResultsCounter(); ?>
</div>