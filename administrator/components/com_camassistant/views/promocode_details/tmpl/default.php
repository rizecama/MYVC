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

//echo '<pre>';print_r($_REQUEST);

$promocodelist = $this->promocodeList;

//echo '<pre>'; print_r($this->promocodeList); exit;

//print_r($this->items);

JHTML::_('behavior.tooltip');

if(count($this->items)>0)

{

JToolBarHelper::title(   JText::_( 'Edit PromoCode' ), 'generic.png' );

}

else

{

JToolBarHelper::title(   JText::_( 'Add PromoCode' ), 'generic.png' );

}

?>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>

<script type="text/javascript">
G = jQuery.noConflict();
function submitbutton(pressbutton) 

{

	var form = document.adminForm;

	if (pressbutton == 'save')

	{

		if(form.promocode.value == '')

		{

			alert('Fill the Promocode ');

			frm.promocode.focus();

			return false;

		}
		
		else if(G('.ptype:radio:checked').length == 0){
		alert("Please select prmocode type.");
		return false;
		}
		
		else 

	{

		submitform( pressbutton );

				return;

	}

	}

	

}

</script>





<form method="post" name="adminForm"   >

	<table cellpadding="8" cellspacing="5">

		<tbody>

		<th>

			<strong><?php echo JText::_('Enter Promo Code :'); ?></strong>

		</th>

			<tr>

				<td><strong> PROMOCODE :</strong></td>

				<td><input type="text" name="promocode" value="<?php echo $this->items[0]->promocode; ?>" id="promocode" /> </td>

			</tr>

			<tr>

				<td><strong>DISCOUNT AMOUNT :</strong></td>

				<td><input type="text" name="amount" value="<?php echo $this->items[0]->amount; ?>" id="amount" /></td>

			</tr>

			<tr>

				<td><strong> PROMOCODE TYPE:</strong></td>

				<td><input <?php if($this->items[0]->ptype == 'all' ){ echo "checked"; } ?> type="radio" name="ptype" value="all" id="ptype" class="ptype" /> Life Time
				<input <?php if($this->items[0]->ptype == 'single' ){ echo "checked"; } ?> type="radio" name="ptype" value="single" id="ptype" class="ptype" /> One Year
				 </td>

			</tr>
			
		</tbody>

	</table>

	

<input type="hidden" name="cid[]" value="<?php echo $this->items[0]->id; ?>" />

<input type="hidden" name="task" value="save" />

<input type="hidden" name="option" value="com_camassistant" />

<input type="hidden" name="controller" value="promocode_details" />

<?php echo JHTML::_( 'form.token' ); ?>

</form>
