<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_auto_insurance   extends JTable
{
    var $id = null;
	var $vendor_id = null; 
	var $aip_end_date = null; 	
	var $aip_date_verified = null;
	var $aip_upld_cert = null;
	var $aip_status = null;
	var $aip_folder_id = null;
	var $saveddate = null;
	var $aip_bodily = null;	
	var $aip_combined = null;	
	var $aip_body_injury = null;	
	var $aip_property = null;	
	var $aip_primary = null;	
	var $aip_waiver = null;	
	var $aip_cert = null;	
	var $aip_addition = null;	
	var $aip_applies_any = null;	
	var $aip_applies_owned = null;	
	var $aip_applies_nonowned = null;	
	var $aip_applies_hired = null;	
	var $aip_applies_scheduled = null;	
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_auto_insurance', 'id', $db);
	}
}
?>
