<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableAssignedbmembers extends JTable
{
	/**
	 * Primary Key
	 * @var int
	 */

    var $property_id = null;
	var $member_id = null; 	
	var $manager_id = null;

	function __construct(& $db) {
		parent::__construct('#__cam_assignedboardmembers', 'id', $db);
	}
	
	
}
?>
