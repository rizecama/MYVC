<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_omi_insurance   extends JTable
{
    var $id = null;
	var $vendor_id = null; 
	var $OMI_start_date = null; 	
	var $OMI_end_date = null;
	var $OMI_upld_cert = null;
	var $OMI_status = null;
	var $OMI_folder_id = null;
	var $excemption = null;	
	var $saveddate = null;	
	var $OMI_date_verified = null;
	var $OMI_aggregate = null;	
	var $OMI_each_claim = null;	
	var $OMI_cert = null;	
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_errors_omissions_insurance', 'id', $db);
	}
}
?>
