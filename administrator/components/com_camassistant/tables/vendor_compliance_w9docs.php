<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_compliance_w9docs  extends JTable
{
    var $id = null;
	var $vendor_id = null; 
	var $w9_date_verified = null; 	
	var $w9_upld_cert = null;
	var $w9_status = null;
	var $ein_number = null;
	var $saveddate = null;	
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_compliance_w9docs', 'id', $db);
	}
}
?>
