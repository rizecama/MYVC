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

JToolBarHelper::title( JText::_( 'Properties to Board members' ));
?>

<?php //echo "Assigned board memers"; ?>
<table cellpadding="0" cellspacing="0" class="adminlist">
<tr>
<th width="5">
<?php echo JText::_( 'NUM' ); ?>
</th>
<th width="20">
<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->result); ?>);" />
</th>

<th class="title" align="center"><?php echo JHTML::_( 'grid.sort', 'Property Name', 'property_name', $this->lists['order_Dir'], $this->lists['order']); ?>
</th><th class="title" align="center"><?php echo JHTML::_( 'grid.sort', 'Current Manager', 'firstname', $this->lists['order_Dir'], $this->lists['order']); ?></th><th class="title" align="center"><?php echo JHTML::_( 'grid.sort', 'Property manager id', 'manager_id', $this->lists['order_Dir'], $this->lists['order']); ?></th><th colspan="2" align="center" class="title">EDIT or REMOVE</th></tr>

<?php

for ($i=0; $i<count($this->details); $i++){
$checked 	= JHTML::_('grid.checkedout',$result, $i );

	$published 	= JHTML::_('grid.published', $result, $i );
$details = $this->details[$i]; 
?>
<tr>
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>

<td><?php echo $details->property_name; ?></td>
<td><?php echo $details->firstname;  ?>&nbsp;&nbsp;<?php echo $details->lastname;  ?></td>
<td><?php echo $details->manager_id; ?></td>
<td>

	
<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="editform">
<input type="submit" value="EDIT" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="assignedboardmembers" />
<input type="hidden"  name="task" value="editmembers" />
<input type="hidden"  name="propertyid" value="<?php echo $details->property_id; ?>" />
<input type="hidden"  name="memberid" value="<?php echo $details->member_id; ?>" />
</form>
</td>
<td>
<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="removeform">
<input type="submit" value="REMOVE" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="assignedboardmembers" />
<input type="hidden"  name="task"value="remove" />
<input type="hidden"  name="propertyid" value="<?php echo $details->property_id; ?>" />
</form>
</td>
</tr>
<?php } ?>
<tfoot>
		<td colspan="9">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
</table>
<div align="right"  style="padding-top:10px;">
<form action="<?php echo JRoute::_( 'index.php' ); ?>" name="assignform">
<input type="submit" value="Add Board Members" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="assignedboardmembers" />
<input type="hidden"  name="task"value="addmember" />


<input type="hidden" name="task" value="" /> 
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
</div>
<div class="clear"></div>
