<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableIn_House_vendors extends JTable
{
    var $id = null;
	var $user_id = null; 	
	var $vendor_id = null; 	
	var $firm_id = null;
    var $comp_id = null;	
	var $comp_name = null;	
    var $Tax_id = null;	
	var $Fei_id = null;	
	var $authorized_by = null;
	var $authorized_license_key = null;
	var $vendor_type = null;
	var $reg_date = null;
	var $status = null;
	
	function __construct(& $db) {
		parent::__construct('#__cam_in_house_vendors', 'id', $db);
	}
	
	
}
?>
