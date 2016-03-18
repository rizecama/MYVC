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

    var $street = null;	
    var $city = null;	
    var $state = null;	
	var $zip = null;	
	var $share = null;				
	function __construct(& $db) {
		parent::__construct('#__property', 'id', $db);
	}
	
	
}
?>
