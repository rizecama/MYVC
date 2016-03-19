<?php

/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablepropertypermisisons extends JTable
{
 
	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $vendor_proposals = null;
	var $myvendor_list = null;
	var $invite_vendors = null;
	var $approval_request = null;
	var $approval_awarding = null;
	var $property_id = null;
	var $propertymanager_id = null;
	var $propertyowner_id = null;
	
			
	function __construct(& $db) {
		parent::__construct('#__cam_propertyowner_permissions', 'id', $db);
	}
	
	
}
?>
