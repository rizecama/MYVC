<?php

/**

 * @version		1.0.0 packages $

 * @package		packages

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

global $mainframe;

$invitecodelist = $this->invitecodeList;

//echo '<pre>'; print_r($this->promocodeList); exit; 

//echo '<pre>'; print_r($this->items[0]); 

?>
<script language="javascript" type="text/javascript">
function submitform(pressbutton){
var form = document.adminForm;
var chks = document.getElementsByName('cid[]');
var hasChecked = 0;
   if(pressbutton)
    {form.task.value=pressbutton;}
	form.submit();
	if(pressbutton=='lists'){
	 window.location="index.php?option=com_camassistant";
	}
}

</script>


<form  method="post" name="adminForm" >

<div id="editcell">

	

	<table class="adminlist">

	<thead>

		<tr>

			<th width="5"><?php echo JText::_( 'NUM' ); ?></th>

			<th width="20">	<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $this->items; ?>);" /></th>

			<th class="title">Invite Code</th>
		</tr>

	</thead>	

	

	<?php

	$k = 0;

	

	for ($i=0, $n=count( $this->items ); $i < $n; $i++)

	{





		$row = &$this->items[$i];

//echo'<pre>';print_r($row);

		$checked 	= JHTML::_('grid.checkedout',   $row, $i );

		

        

		?>

		<tr class="<?php echo "row$k"; ?>">

			<td>

				<?php echo $this->pagination->getRowOffset( $i ); ?>

			</td>

			<td>

				<?php echo $checked; ?>

			</td>

			<td align="center">

				<?php echo $row->invitecode; ?>

			</td>

			

		</tr>

		<?php

		$k = 1 - $k;

	}

	?>

	</table>

</div>



<input type="hidden" name="controller" value="invitecode_details" />

<input type="hidden" name="task" value="invitecode" />

<input type="hidden" name="view" value="invitecode_details" />

<input type="hidden" name="boxchecked" value="0" />



</form>

