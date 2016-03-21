<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablepropertyownerproperty  extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

   var $id = null;
	var $property_name = null; 	
	var $manages = null;
	var $property_manager_id = null;
	var $location = null;
	var $fax = null;	
    var $street = null;
	var $city = null;	
	var $state = null;	
    var $divcounty = null;
	var $zip = null;
	var $timezone = null;
	var $boardposition = null;
	var $units = null;
	var $location = null;
	var $phone = null;
	var $pext = null;
	var $altphone = null;
    var $altext = null;	
	
		
	function __construct(& $db) {
//	exit;
		parent::__construct('#__cam_property', 'id', $db);
	}
	
	
}
?>
