<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_professional_license  extends JTable
{
    var $id = null;
	var $vendor_id = null; 
	var $PLN_license = null; 	
	var $PLN_category = null;
	var $PLN_type = null;
	var $PLN_expdate = null;
	var $PLN_state = null;
	var $PLN_upld_cert = null;
	var $PLN_date_verified = null;
	var $PLN_status = null;
	var $PLN_folder_id = null;
	var $saveddate = null;
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_professional_license', 'id', $db);
	}
}
?>
