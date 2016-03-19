<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_occupational_license  extends JTable
{
    var $id = null;
	var $vendor_id = null; 
	var $OLN_license = null; 	
	var $OLN_expdate = null;
	var $OLN_city_country = null;
	var $OLN_state = null;
	var $OLN_upld_cert = null;
	var $OLN_date_verified = null;
	var $OLN_status = null;
	var $OLN_folder_id = null;
	var $saveddate = null;
	
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_occupational_license', 'id', $db);
	}
}
?>
