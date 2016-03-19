<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablepropertydetails extends JTable
{
 
	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $property_id = null;
	var $property_name = null; 	
	var $manages = null;
	var $property_image = null;
	var $property_manager_id = null;
	var $location = null;
	var $tax_id = null;	
    var $street = null;
	var $city = null;	
	var $state = null;	
    var $divcounty = null;
	var $zip = null;
	var $timezone = null;
	var $boardposition = null;
	var $accept = null;
	var $units = null;
	var $createtime = null;
	var $activation = null;
		
			
	function __construct(& $db) {
		parent::__construct('#__cam_propertydetails', 'id', $db);
	}
	
	
}
?>
