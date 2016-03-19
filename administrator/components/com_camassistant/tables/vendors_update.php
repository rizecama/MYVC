<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendors_update extends JTable
{
    var $id = null;
	var $user_id = null; 	
	var $company_name = null; 	
	var $company_address = null;
	var $company_addresss = null;
    var $tax_id = null;	
	var $fax_id = null;	
	var $city = null;	
    var $state = null;	
	var $zipcode = null;	
	var $in_house_vendor = null;
	var $in_house_parent_company = null;
	var $in_house_parent_company_FEIN = null;
	var $miles = null;
	var $company_phone = null;
	var $phone_ext = null;
	var $alt_phone = null;
	var $alt_phone_ext = null;
	var $established_year = null;
	var $not_interest_RFP = null;
	var $interest_RFP_alerts = null;
	var $preferred_vendors = null;
	var $authorized_business = null;
	var $company_web_url = null;
	var $image = null;
	var $pledge = null;
	var $status = null;
	var $created = null;
	var $published = null;
	var $activation = null;
	var $faxid = null;
	var $fax_acc  = null;
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_company', 'user_id', $db);
	}
	
	
}
?>
