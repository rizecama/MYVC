<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablepropertyowner extends JTable
{
 
	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $property_name = null; 	
	var $property_manager_id = null;
	var $propertyowner_manage = null;
	var $manages = null;
	var $tax_id = null;
	var $property_image = null;
    var $street = null;	
    var $city = null;
	var $divcounty = null;	
    var $state = null;	
	var $zip = null;
	var $timezone = null;
	var $location = null;		
	var $units = null;
	var $createtime = null;
	var $property_link = null;
	var $boardposition = null;

		
			
	function __construct(& $db) {
		parent::__construct('#__cam_property', 'id', $db);
	}
	
	
}
?>
