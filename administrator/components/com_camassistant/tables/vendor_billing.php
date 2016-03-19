<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_billing extends JTable
{
    var $id = null;
	var $user_id = null; 	
	var $CardType = null;
	var $CardNumber = null;
	var $name_on_card = null;
	var $company_name = null;
	var $ExpMon = null;
	var $ExpYear = null;
	var $pay_amount = null;
	var $promo_code = null;
	var $address = null;
	var $city = null;
	var $states = null;
	var $zipcode = null;
	var $phone = null;
	var $status = null;
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_billing', 'id', $db);
	}
}
?>
