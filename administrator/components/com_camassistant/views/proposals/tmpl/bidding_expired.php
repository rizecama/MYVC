<?php
/**
 * @version		1.0.0 camassistant $
 * @package		camassistant
 * @copyright	Copyright � 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
//echo "<pre>"; print_r($this->expired);
?>
<?PHP if($this->expired == 'yes') { ?>
<div align="center" style="color:#FF0000; font-size:15px">"Compliance Documents are Either Missing or Out of Date.  
You must correct required or expired documents prior to accessing the Proposal Center.  If you are having difficulty with this please call the CAMassistant Customer Support Team at 561-246-3830 for assistance."</div>
<?PHP } else if($this->vendor_bids == 'Had bid') { ?>
<div align="center" style=" padding-top:100px; color:#0066FF; font-size:15px; width:813px;">"The RFP you selected already has a Proposal and/or Alternate submitted for this RFP"</div>
<?PHP } else { ?>
<div align="center" style=" padding-top:100px; color:#0066FF; font-size:15px; width:813px;">"The RFP has been closed or max proposals for this RFP has been reached. You are not allowed to bid for this RFP."</div>
<?PHP } ?>