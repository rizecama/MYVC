<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablerfp_task_addexception extends JTable
{
    var $id = null;
	var $rfp_id = null;
	var $task_id = null;
	var $vendor_id = null;
	var $spl_req = null;
	var $add_exception = null;
	var $status = null;
	var $Alt_bid = null;
        var $check_exception = null;

	function __construct(& $db) {
		parent::__construct('#__cam_rfpsow_addexception', 'id', $db);
	}
}
?>
