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

// Your custom code here

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if($_REQUEST['rfp_type']=='rfp') { ?>
  <tr>
    <td><h3>Congratulations!</h3></td>
  </tr>
  <tr>
    <td><strong>Your RFP has been submitted to the CAMASSIGNMENT NETWORK successfully</strong></td>
  </tr>
 <?php } else { ?>
   <tr>
    <td><h3>RFP Confirmation Message:</h3></td>
  </tr>
  <tr>
    <td><strong>Your RFP has been submitted as a draft to the CAMASSIGNMENT NETWORK successfully</strong></td>
  </tr>
 <?php } ?>

  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
