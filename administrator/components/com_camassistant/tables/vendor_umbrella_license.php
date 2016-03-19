<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_umbrella_license  extends JTable
{
    var $id = null;
	var $vendor_id = null; 
	var $UMB_license = null; 	
	var $UMB_expdate = null;
	var $UMB_city_country = null;
	var $UMB_state = null;
	var $UMB_upld_cert = null;
	var $UMB_date_verified = null;
	var $UMB_status = null;
	var $UMB_folder_id = null;
	var $saveddate = null;	
	var $UMB_aggregate = null;	
	var $UMB_occur = null;	
	var $UMB_certholder = null;	
	
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_umbrella_license', 'id', $db);
	}
}
?>
