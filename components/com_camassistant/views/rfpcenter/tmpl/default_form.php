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
?>
<script type="text/javascript">
<!--
	function validateForm( frm ) {
		var valid = document.formvalidator.isValid(frm);
		if (valid == false) {
			// do field validation
			// your custom code here
			return false;
		} else {
			frm.submit();
		}
	}
// -->
</script>
<?php /*?><?php
if ( $this->params->def( 'show_page_title', 1 ) && $this->params->get('page_title') ) {
?>
<div class="contentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
	<?php
	$page_title = ($this->params->get('page_title'))? $this->escape($this->params->get('page_title')) : '' ;
	echo $page_title;
	?>
</div>
<?php
}
?><?php */?>
<div>
<form action="<?php echo JRoute::_( 'index.php' );?>" method="post" name="adminForm" id="adminForm" class="form-validate">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">Select Property to be serviced</td>
    <td width="20%" align="left"><select name="property_id">
		<option value="" selected="selected">--Select Property--</option>
		</select></td>
    <td align="left"><a class="modal" title="Click here to add New Property"  href="index.php?option=com_camassistant&controller=rfp&amp;task=addproperty" rel="{handler: 'iframe', size: {x: 550, y: 350 }}"><input type="button" value="Add Property" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php /*?><button class="button validate" type="submit"><?php echo JText::_('Send'); ?></button><?php */?>
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="submit" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>