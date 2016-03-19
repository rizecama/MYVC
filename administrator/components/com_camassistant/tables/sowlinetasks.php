<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableSowlinetasks extends JTable
{
	
	/**
	 * Primary Key
	 * @var int
	 */
    var $task_id = null;
	var $rfp_id = null; 	
	var $linetaskname = null; 	
	var $rfpreference = null;
	var $taskuploads  = null; 	
	var $task_desc = null; 
    var $is_req_taskvendors = null;	
	var $task_price = null;	
	function __construct(& $db) {
		parent::__construct('#__cam_rfpsow_linetask', 'task_id', $db);
	}
	
}
?>
