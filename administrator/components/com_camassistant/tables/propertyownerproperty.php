<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablepropertyownerproperty extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $property_name = null;
	var $boardposition = null; 
	var $street = null;
	var $city = null;	
	var $divcounty = null;
	var $state = null;	
	var $timezone = null;
	var $zip = null;
	var $units = null;	
	var $location = null;
	var $pext = null;
	var $altext = null;	
	var $phone = null;
    var $altphone = null;
	var $fax = null;	
	var $manages = null;
	var $property_image = null;
	var $property_manager_id = null;
	var $propertyowner_manage = null;
	
	
  
    
		
			
	function __construct(& $db) {
		parent::__construct('#__cam_property', 'id', $db);
	}
	
	
}
?>
