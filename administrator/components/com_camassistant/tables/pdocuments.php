<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TablePdocuments extends JTable
{
	/**
	 * Primary Key
	 * @var int
	 */

    var $property_manager_id = null;
	var $property_id = null; 	
	var $cat_name = null;
	var $cat_id = null;
	var $folder_alias = null;	

	function __construct(& $db) {
		parent::__construct('#__cam_propertydocuments', 'id', $db);
	}
	
	
}
?>
