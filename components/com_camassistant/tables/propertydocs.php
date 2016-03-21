<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TablePropertydocs extends JTable
{
	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $parent = null;
	var $property_manager_id = null;
	var $parent_manager = null;
	var $property_id = null; 	
	var $docTitle = null; 
	var $sdocTitle = null; 	
	var $docPath = null;
	var $cat_id = null;
	var $type = null;	

	function __construct(& $db) {
		parent::__construct('#__cam_propertydocs', 'id', $db);
	}
	
	
}
?>
