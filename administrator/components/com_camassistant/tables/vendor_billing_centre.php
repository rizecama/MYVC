<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_billing_centre extends JTable
{
    var $id = null;
	var $user_id = null; 	
	var $payment_preference = null;
	var $date = null;
	var $status = null;
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_billing_centre', 'id', $db);
	}
}
?>
