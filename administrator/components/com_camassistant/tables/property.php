<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableProperty extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $property_name = null; 	
	var $tax_id = null; 	
	var $property_manager_id = null;
	var $camfirmid = null;
	var $company_id = null;

    var $street = null;	
    var $city = null;	
    var $state = null;	
	var $divcounty = null;	
	var $zip = null;	
	var $share = null;	
	var $units = null;
	var $pro_type = null;	
	var $createtime = null;	
			
	function __construct(& $db) {
		parent::__construct('#__cam_property', 'id', $db);
	}
	
	
}
?>
