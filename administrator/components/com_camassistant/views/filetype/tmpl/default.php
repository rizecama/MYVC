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
error_reporting(0);
// Your custom code here
//$ordering = ($this->lists['order'] == 'ordering');

// import html tooltips
JHTML::_('behavior.tooltip');
JToolBarHelper::title( JText::_( 'Uploading File Types' ));
?>

<form action="<?php ?>" method="post" name="adminForm" >
<table cellpadding="0" cellspacing="0">
<tr>
<td>File Types :</td>
<td width="100"></td>
  <?php 

for ($i=0; $i<count($this->types); $i++){
?>
<td><input type="text" name="files" size="60" value="<?php echo $this->types[$i]->files ?>" /></td>

</tr>
<tr height="10"></tr>
<tr>
<td>No of properties to display per a page :</td>
<td width="100"></td>
<td><input type="text" name="pagecount" size="60" value="<?php echo $this->types[$i]->pagecount ?>" /></td>
<?php } ?>
</tr>
<tr height="10"></tr>

<tr>
<td></td><td width="100"></td><td>
<input type="submit" value="Save" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="camassistant" />
<input type="hidden" name="task" value="updatefile" />
</td></tr>
</table>
</form>