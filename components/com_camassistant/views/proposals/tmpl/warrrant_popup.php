<?php

/**
 * @version		1.0.0 cam assistant $
 * @package		cam_assistant
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

// Your custom code here
JHTML::_('behavior.modal'); ?>
<?php //echo "<pre>";  print_r($this->pfiles);
session_start();
$_SESSION['taskid']= $_REQUEST['taskid']; ?>
<?php //print_r($_SESSION['taskid']);?>
<div style="width:600px;">
<div id="dotshead_line">&nbsp;</div>
<!-- eof dotshead -->
<div id="i_bar">
<div id="i_bar_txt" style="padding:0px;line-height:33px;">
<?php 
$db = JFactory::getDBO();
$user =& JFactory::getUser();
$user_id = $user->get('id');
$pid=$_REQUEST['pid'];	
	
$db->setQuery('Select property_name,tax_id FROM #__cam_property where id="'.$pid.'"');
$db->query();
$propert_name = $db->loadObjectList();

?>
<?php //echo "<pre>"; print_r($_SESSION);echo "<pre>";  print_r($this->pfiles);?>
<span><?php echo  "Compliance Documents" ?></span>

</div>
<div id="i_icon"></div>
</div>
 <link rel="stylesheet" href="<? echo juri::base(); ?>templates/camassistant_inner/css/style.css" type="text/css" />
<!-- sof table pan -->
<div class="table_pannel">
<div class="table_panneldiv">
<table width="100%" cellpadding="0" cellspacing="4">
  <tr class="table_green_row">
    <td width="62" align="center" valign="top">SELECT</td>
    <td width="426" align="left" valign="top">Name</td>
    <td width="141" align="center" valign="top">options</td>
    </tr>
<tr class="table_blue_rowdots2">
<td>
<a href="index2.php?option=com_camassistant&controller=proposals&task=warranty_docs"><img src="images/folder_icon.png"  alt="folder" /></a></td>
<td><a href="index2.php?option=com_camassistant&controller=proposals&task=warranty_docs">Compliance Documents</a></td>
<td><a href="index2.php?option=com_camassistant&controller=proposals&task=warranty_docs">OPEN</a></td>
</tr>
</table>
</div></div>
</div><br />
<div id="i_bar">
<div id="i_bar_txt" style="padding:0px;line-height:33px;">
<span><?php echo "My Company Documents"; ?></span>
</div>
</div>
<table cellspacing="4" cellpadding="0" width="100%">
  <tbody>
<tr class="table_green_row">
    <td valign="top" align="center" width="62">SELECT</td>
    <td valign="top" align="left" width="426">Name</td>
    <td valign="top" align="center" width="141">Options</td>
    </tr>

<tr class="table_blue_rowdots2">
<!--<td><img src="images/doc.png" /></td>-->
<td><a href="index.php?option=com_camassistant&controller=proposals&task=vendor_docs&Itemid=115&warranty=warranty"><img src="images/folder_icon.png"  alt="folder" /></a></td>
<td><a href="index.php?option=com_camassistant&controller=proposals&task=vendor_docs&Itemid=115&warranty=warranty">My Company Documents</a></td>
<td><a href="index.php?option=com_camassistant&controller=proposals&task=vendor_docs&Itemid=115&warranty=warranty">OPEN</a>&nbsp;&nbsp;</td>
</tr>
   <tr class="table_blue_rowdots2">
   <td align="center" valign="bottom">&nbsp;</td>
   <td align="left" valign="top">&nbsp;</td>
   <td align="left" valign="top">&nbsp;</td>
   </tr>
    
    </tbody></table>