<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableAddproperty  extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $property_name = null; 	
	var $tax_id = null; 	
	var $property_manager_id  = null;
	var $propertyowner_manage  = null;
	var $camfirmid  = null;
	var $company_id = null;
    var $street = null;	
    var $city = null;	
    var $state = null;
	var $divcounty = null;	
	var $zip = null;
	var $cc = null;	
	var $bmember = null;	
	var $share = null;	
	var $show = null;	
	var $units = null;		
	var $property_image = null;	
	var $pro_type = null; 
	var $manages = null; 
	var $copy = null; 
	var $ccemails = null; 	
	var $timezone = null; 	
	var $location = null;
	var $copyvendor = null;
	var $property_name_origin = null;
		
	function __construct(& $db) {
//	exit;
		parent::__construct('#__cam_property', 'id', $db);
	}
	
	
}
?>
