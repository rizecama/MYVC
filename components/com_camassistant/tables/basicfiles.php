<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableBasicfiles  extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $rfpid = null;
	var $property_id = null;
	var $filename = null; 	
	var $filepath = null; 	
	var $upload_date  = null;
		
	function __construct(& $db) {
//	exit;
		parent::__construct('#__cam_basicrequest_files', 'id', $db);
	}
	
	
}
?>
