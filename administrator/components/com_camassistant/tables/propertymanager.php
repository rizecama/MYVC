<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablepropertymanager extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */


	var $id = null; 	
	var $cust_id = null; 
	var $comp_id = null; 		
	var $camfirm_license_no = null;
    var $comp_name = null;	
    var $tax_id = null;	
	var $mailaddress = null;	
    var $comp_city = null;	
	var $comp_state = null;	
	var $comp_zip = null;
	var $comp_phno = null;
	var $comp_extnno = null;
	var $comp_alt_phno = null;
	var $comp_alt_extnno = null;
	var $comp_website = null;
	var $comp_logopath = null;
	var $is_providing_proposals = null;
	var $is_manage_cproperties = null;
	var $status = null;
	var $activation = null;
	var $published = null;
				
	function __construct(& $db) {
		parent::__construct('#__cam_customer_companyinfo', 'id', $db);
	}
	
	
}
?>
